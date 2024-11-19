<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Cellar;

use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
	public function index(Request $request)
	{
		$search = $request->input('search');
		$perPage = $request->input('per_page', 5);
		$invoices = Invoice::query();

		if ($search) {
			$searchableFields = ['codigo', 'fechaEmision'];

			$invoices->where(function ($query) use ($searchableFields, $search) {
				foreach ($searchableFields as $field) {
					$query->orWhere($field, 'LIKE', '%' . $search . '%');
				}
			});
		}

		$invoices = $invoices->orderBy('created_at', 'desc')->paginate($perPage);

		return response()->json($invoices);
	}

	public function store(Request $request)
	{
		//VALIDACIONES
		$request->validate([
			'provider_id' 			=> 'required|exists:providers,id',
			'codigo' 				=> 'required|unique:invoices,codigo',
			'fechaEmision' 			=> 'required|date',
			'metodoPago' 			=> 'required|in:Efectivo,Nequi,Tarjeta,Credito',
			'subTotal' 				=> 'required|numeric|gte:0',
			'impuestos' 			=> 'required|numeric|gte:0',
			'total' 				=> 'required|numeric|gte:0',
			'descuento_global' 		=> 'required|numeric|gte:0',
			'valor_descuentoGlobal' => 'required|numeric|gte:0',
			'descuento_total' 		=> 'required|numeric|gte:0',

			//CLAVE PRODUCTS
			'products' 					=> 'required|array',
			'products.*.product_id' 	=> 'required|exists:products,id',
			'products.*.cantidad' 		=> 'required|numeric|gt:0',
			'products.*.precio_unitario' => 'required|numeric|gte:0',
			'products.*.descuento' 		=> 'required|numeric|gte:0',
			'products.*.valor_descuento' => 'required|numeric|gte:0',
			'products.*.subtotal' 		=> 'required|numeric|gte:0',
			'products.*.impuestos' 		=> 'required|numeric|gte:0',
			'products.*.precio_total' 	=> 'required|numeric|gte:0',
		]);

		$cellar = Cellar::where('predeterminada', 1)->first();

		if ($cellar === null) {
			return response()->json(['error' => 'No existen bódegas, agrega una'], 500);
		}

		if ($cellar->company->presupuesto < $request->total) {
			return response()->json(['error' => 'No tienes suficiente presupuesto'], 500);
		}

		DB::beginTransaction();

		try {
			$invoice = new Invoice($request->except('products'));
			if ($request->metodoPago === 'Credito') {
				$invoice->estadoFactura = 0; // Pendiente
				$invoice->deuda = $request->total;
			} else {
				$invoice->estadoFactura = 1; // Pagada
				$invoice->deuda = 0;
			}

			$invoice->save();

			//ACTUALIZACIÓN DE PRESUPUESTO
			$cellar->company->presupuesto -= $request->total;
			$cellar->company->save();

			$productos = $request->input('products');

			foreach ($productos as $productoData) {
				$product = Product::find($productoData['product_id']);
				$invoice->productInvoice()->attach($product, $productoData);

				$cellar->products()->syncWithoutDetaching([$product->id => ['cantidad' => \DB::raw('cantidad + ' . $productoData['cantidad'])]]);
			}

			DB::commit();

			return response()->json(['message' => 'Factura creada exitosamente'], 201);
		} catch (\Exception $e) {
			DB::rollBack();

			return response()->json(['error' => $e->getMessage()], 500);
		}
	}

	public function show($id)
	{
		$invoice = Invoice::with('provider', 'productInvoice')->findOrFail($id);

		$hasRefunds = $invoice->refunds()->exists();

		return response()->json([
			'invoice' 		=> $invoice,
			'hasRefunds' 	=> $hasRefunds
		], 200);
	}
}
