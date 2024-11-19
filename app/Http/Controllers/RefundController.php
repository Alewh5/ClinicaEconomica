<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Refund;
use App\Models\Invoice;
use App\Models\Sale;
use App\Models\Cellar;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class RefundController extends Controller
{
	public function index(Request $request)
	{
		$search = $request->input('search');
		$perPage = $request->input('per_page', 5);
		$refunds = Refund::query();

		if ($search) {
			$searchableFields = ['motivo', 'fecha'];

			$refunds->where(function ($query) use ($searchableFields, $search) {
				foreach ($searchableFields as $field) {
					$query->orWhere($field, 'LIKE', '%' . $search . '%');
				}
			});
		}

		$refunds = $refunds->orderBy('created_at', 'desc')->paginate($perPage);

		return response()->json($refunds);
	}

	public function store(Request $request)
	{
		//VALIDACIONES
		$request->validate([
			'sale_id' 		=> 'nullable|exists:sales,id',
			'invoice_id' 	=> 'nullable|exists:invoices,id',
			'motivo' 		=> 'required|max:30',
			'fecha' 		=> 'date|required',
			'total' 		=> 'required|numeric|gt:0',

			'products' 					=> 'required|array',
			'products.*.product_id' 	=> 'required|exists:products,id',
			'products.*.cantidad' 		=> 'required|numeric|gte:0',
			'products.*.precio_total' 	=> 'required|numeric|gte:0',
		]);

		$cellar = Cellar::where('predeterminada', 1)->first();

		DB::beginTransaction();

		try {
			$refund = new Refund($request->except('products'));
			$refund->save();

			$products = $request->input('products');
			$productosDevueltos = [];

			if ($request->sale_id) {
				$sale = Sale::findOrFail($request->sale_id);
				$devolucionesAnteriores = $sale->refunds()->with('productRefund')->get();

				foreach ($devolucionesAnteriores as $devolucion) {
					foreach ($devolucion->productRefund as $productoDevuelto) {
						if (!isset($productosDevueltos[$productoDevuelto->id])) {
							$productosDevueltos[$productoDevuelto->id] = 0;
						}
						$productosDevueltos[$productoDevuelto->id] += $productoDevuelto->pivot->cantidad;
					}
				}

				foreach ($products as $productData) {
					$product = Product::find($productData['product_id']);
					$productSale = $sale->productSale()->where('product_id', $productData['product_id'])->firstOrFail();

					if (isset($productosDevueltos[$product->id])) {
						$cantidadDevueltaAnteriormente = $productosDevueltos[$product->id];
					} else {
						$cantidadDevueltaAnteriormente = 0;
					}

					$cantidadMaximaDevolver = $productSale->pivot->cantidad - $cantidadDevueltaAnteriormente;

					if ($productData['cantidad'] > $cantidadMaximaDevolver) {
						throw new \Exception('La cantidad a devolver de ' . $product->descripcion . ' excede la cantidad restante (' . $cantidadMaximaDevolver . ')');
					}

					$refund->productRefund()->attach($product, $productData);
					$productosDevueltos[$product->id] = $cantidadDevueltaAnteriormente + $productData['cantidad'];
					$cellar->products()->syncWithoutDetaching([$product->id => ['cantidad' => \DB::raw('cantidad + ' . $productData['cantidad'])]]);
				}

				//ACTUALIZACIÓN DE PRESUPUESTO
				$cellar->company->presupuesto -= $request->total;
				$cellar->company->save();
			} else if ($request->invoice_id) {
				$invoice = Invoice::findOrFail($request->invoice_id);
				$devolucionesAnteriores = $invoice->refunds()->with('productRefund')->get();

				foreach ($devolucionesAnteriores as $devolucion) {
					foreach ($devolucion->productRefund as $productoDevuelto) {
						if (!isset($productosDevueltos[$productoDevuelto->id])) {
							$productosDevueltos[$productoDevuelto->id] = 0;
						}
						$productosDevueltos[$productoDevuelto->id] += $productoDevuelto->pivot->cantidad;
					}
				}

				foreach ($products as $productData) {
					$product = Product::find($productData['product_id']);
					$productInvoice = $invoice->productInvoice()->where('product_id', $productData['product_id'])->firstOrFail();

					if (isset($productosDevueltos[$product->id])) {
						$cantidadDevueltaAnteriormente = $productosDevueltos[$product->id];
					} else {
						$cantidadDevueltaAnteriormente = 0;
					}

					$cantidadMaximaDevolver = $productInvoice->pivot->cantidad - $cantidadDevueltaAnteriormente;

					if ($productData['cantidad'] > $cantidadMaximaDevolver) {
						throw new \Exception('La cantidad a devolver de ' . $product->descripcion . ' excede la cantidad restante (' . $cantidadMaximaDevolver . ')');
					}

					$refund->productRefund()->attach($product, $productData);
					$productosDevueltos[$product->id] = $cantidadDevueltaAnteriormente + $productData['cantidad'];
					$cellar->products()->syncWithoutDetaching([$product->id => ['cantidad' => \DB::raw('cantidad - ' . $productData['cantidad'])]]);
				}

				//ACTUALIZACIÓN DE PRESUPUESTO
				$cellar->company->presupuesto += $request->total;
				$cellar->company->save();
			} else {
				throw new \Exception('Algo Pasa!!');
			}

			DB::commit();

			return response()->json(['message' => 'Devolución registrada exitosamente'], 201);
		} catch (\Exception $e) {
			DB::rollBack();
			return response()->json(['error' => $e->getMessage()], 500);
		}
	}

	public function show($id)
	{
		$refund = Refund::with('productRefund')->findOrFail($id);

		// Verificar si el refund está asociado a una sale o a una invoice
		if ($refund->sale_id) {
			$refund->load(['sale.customer', 'sale.productSale']); // Cargar el cliente y los productos de la venta
			$relatedData = $refund->sale;
		} elseif ($refund->invoice_id) {
			$refund->load(['invoice.provider', 'invoice.productInvoice']); // Cargar el cliente y los productos de la factura
			$relatedData = $refund->invoice;
		} else {
			return response()->json(['error' => 'No se encontró una venta o factura asociada'], 404);
		}

		$refundDetails = $refund->productRefund->map(function ($refundProduct) use ($relatedData) {
			// Buscar el producto en la relación de la venta o factura
			$relatedProduct = null;
	
			// Verificar si estamos trabajando con una venta o una factura
			if (isset($relatedData->productSale)) {
				$relatedProduct = $relatedData->productSale->where('id', $refundProduct->id)->first();
			} elseif (isset($relatedData->productInvoice)) {
				$relatedProduct = $relatedData->productInvoice->where('id', $refundProduct->id)->first();
			}
		
			return [
				'product_id' 	=> $refundProduct->id,
				'codigo' 		=> $refundProduct->codigo ?? null, 
				'descripcion' 	=> $refundProduct->descripcion ?? null,
				'cantidad' 		=> $refundProduct->pivot->cantidad,
				'precio_total' 	=> $refundProduct->pivot->precio_total,
				'precio_unitario' => $relatedProduct->pivot->precio_unitario ?? null,
				'descuento' 	=> $relatedProduct->pivot->descuento ?? null,
				'impuestos' 	=> $relatedProduct->pivot->impuestos ?? null,
				'valor_descuento' => $relatedProduct->pivot->valor_descuento ?? null,
				'subtotal' 		=> $relatedProduct->pivot->subtotal ?? null, // Agregar subtotal
			];
		});		

		return response()->json([
			'refund' => [
				'id' => $refund->id,
				'amount' => $refund, // 
				'product_refund' => $refundDetails, // Productos del refund con sus detalles
			],
			'relatedData' => $relatedData
		], 200);
	}
}
