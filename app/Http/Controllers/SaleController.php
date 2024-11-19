<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Cellar;
use App\Models\Company;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

require_once(app_path('Libraries/code128.php'));

use PDF_Code128;

class SaleController extends Controller
{
	public function index(Request $request)
	{
		$search = $request->input('search');
		$perPage = $request->input('per_page', 5);
		$sales = Sale::query();

		if ($search) {
			$searchableFields = ['codigo', 'fechaEmision'];

			$sales->where(function ($query) use ($searchableFields, $search) {
				foreach ($searchableFields as $field) {
					$query->orWhere($field, 'LIKE', '%' . $search . '%');
				}
			});
		}

		$sales = $sales->orderBy('created_at', 'desc')->paginate($perPage);

		return response()->json($sales);
	}

	public function store(Request $request)
	{
		//VALIDACIONES
		$request->validate([
			'customer_id' 		=> 'required|exists:customers,id',
			'codigo' 			=> 'required|unique:sales,codigo',
			'fechaEmision' 		=> 'required|date',
			'metodoPago' 		=> 'required|in:Efectivo,Nequi,Tarjeta,Credito',
			'subTotal' 			=> 'required|numeric|gte:0',
			'impuestos' 		=> 'required|numeric|gte:0',
			'total' 			=> 'required|numeric|gte:0',
			'descuento_global' 	=> 'required|numeric|gte:0',
			'valor_descuentoGlobal' => 'required|numeric|gte:0',
			'descuento_total' 	=> 'required|numeric|gte:0',

			//CLAVE PRODUCTS
			'products' 				=> 'required|array',
			'products.*.product_id' => 'required|exists:products,id',
			'products.*.cantidad' 	=> 'required|numeric|gt:0',
			'products.*.precio_unitario' => 'required|numeric|gte:0',
			'products.*.descuento' 	=> 'required|numeric|gte:0',
			'products.*.valor_descuento' => 'required|numeric|gte:0',
			'products.*.subtotal' 	=> 'required|numeric|gte:0',
			'products.*.impuestos' 	=> 'required|numeric|gte:0',
			'products.*.precio_total' => 'required|numeric|gte:0',
		]);

		$cellar = Cellar::where('predeterminada', 1)->first();

		if ($cellar === null) {
			return response()->json(['error' => 'No existen bódegas, agrega una']);
		}

		DB::beginTransaction();

		try {
			$sales = new Sale($request->except('products'));
			if ($request->metodoPago === 'Credito') {
				$sales->estadoFactura = 0; // Pendiente
				$sales->deuda = $request->total;
			} else {
				$sales->estadoFactura = 1; // Pagada
				$sales->deuda = 0;
			}
			$sales->save();

			//ACTUALIZACIÓN DE PRESUPUESTO
			$cellar->company->presupuesto += $request->total;
			$cellar->company->save();

			$products = $request->input('products');

			foreach ($products as $productData) {
				$product = Product::find($productData['product_id']);
				$productInCellar = $cellar->products()->where('product_id', $product->id)->first();

				if ($productInCellar) {
					$cantidadDisponible = $productInCellar->pivot->cantidad;
				} else {
					throw new \Exception('No hay stock del producto en la bodega predeterminada');
				}

				if ($cantidadDisponible < $productData['cantidad']) {
					throw new \Exception('La cantidad a vender del producto ' . $product->nombre . ' es mayor que la cantidad disponible en la bodega.');
				}

				$sales->productSale()->attach($product, $productData);
				$cellar->products()->syncWithoutDetaching([$product->id => ['cantidad' => \DB::raw('cantidad - ' . $productData['cantidad'])]]);
			}

			DB::commit();

			return response()->json(['message' => 'Venta realizada exitosamente'], 201);
		} catch (\Exception $e) {
			DB::rollBack();

			return response()->json(['error' => $e->getMessage()], 500);
		}
	}

	public function show($id)
	{
		$sale = Sale::with('customer', 'productSale')->findOrFail($id);

		$hasRefunds = $sale->refunds()->exists();

		return response()->json([
			'sale' => $sale,
			'hasRefunds' => $hasRefunds
		], 200);
	}

 	// funcion encontrada en 3uschool no tocar
	public function generatePDF($id)
	{
		$sale 		= Sale::with('customer')->findOrFail($id);
		$company 	= auth()->user()->company;
		$items 		= $sale->productSale;

		/* CALCULAR ALTURA */
		$alturaItems 	= count($items) * 4 * 2;
		$largoInicial 	= 200;
		$largoTotal 	= $largoInicial + $alturaItems;

		$pdf = new PDF_Code128('P', 'mm', array(80, $largoTotal));
		$pdf->SetMargins(4, 8, 4);
		$pdf->AddPage();

		// Encabezado y datos de la empresa
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", strtoupper($company->nombre)), 0, 'C', false);
		$pdf->SetFont('Arial', '', 9);
		$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "NIT: $company->nit"), 0, 'C', false);
		$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "Dirección: $company->direccion"), 0, 'C', false);
		$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "Teléfono: $company->telefono"), 0, 'C', false);
		$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "Email: $company->email"), 0, 'C', false);

		$pdf->Ln(1);
		$pdf->Cell(0, 5, iconv("UTF-8", "ISO-8859-1", "-------------------------------------------------------------"), 0, 0, 'C');
		$pdf->Ln(5);

		// Fecha y detalles de la venta
		$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "Fecha de emisión: " . $sale->fechaEmision), 0, 'C', false);
		$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "Método de pago: " . $sale->metodoPago), 0, 'C', false);

		$pdf->Ln(1);
		$pdf->Cell(0, 5, iconv("UTF-8", "ISO-8859-1", "-------------------------------------------------------------"), 0, 0, 'C');
		$pdf->Ln(5);

		// Detalles del cliente
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->MultiCell(0, 10, iconv("UTF-8", "ISO-8859-1", strtoupper("Datos del Cliente")), 0, 'C', false);
		$pdf->SetFont('Arial', '', 9);
		$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "Cliente: " . $sale->customer->NombreRazonSocial), 0, 'C', false);
		$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "Documento: " . $sale->customer->tipoDocumento . " " . $sale->customer->numeroDocumento), 0, 'C', false);
		$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "Correo: " . $sale->customer->email), 0, 'C', false);

		$pdf->Ln(1);
		$pdf->Cell(0, 5, iconv("UTF-8", "ISO-8859-1", "----------------------------------------"), 0, 0, 'C');
		$pdf->Ln(5);

		$pdf->SetFont('Arial', 'B', 9); // Configurar una fuente en negrita
		$pdf->Cell(10, 4, "Cant.", 0, 0, 'C');
		$pdf->Cell(19, 4, "Precio", 0, 0, 'C');
		$pdf->Cell(19, 4, "Descuento", 0, 0, 'C');
		$pdf->Cell(28, 4, "Total", 0, 0, 'C');
		$pdf->Ln(4); // Salto de línea
		// Detalles de los productos
		$pdf->SetFont('Arial', '', 9);
		foreach ($items as $item) {
			$pdf->MultiCell(0, 4, iconv("UTF-8", "ISO-8859-1", $item->nombre . " " . $item->descripcion), 0, 'C', false);
			$pdf->Cell(10, 4, iconv("UTF-8", "ISO-8859-1", $item->pivot->cantidad), 0, 0, 'C');
			$pdf->Cell(19, 4, iconv("UTF-8", "ISO-8859-1", "$" . number_format($item->pivot->precio_unitario, 2)), 0, 0, 'C');
			$pdf->Cell(19, 4, iconv("UTF-8", "ISO-8859-1", "$" . number_format($item->pivot->valor_descuento, 2)), 0, 0, 'C');
			$pdf->Cell(28, 4, iconv("UTF-8", "ISO-8859-1", "$" . number_format($item->pivot->precio_total, 2)), 0, 0, 'C');
			$pdf->Ln(4);
		}

		$pdf->Ln(7);

		// Impuestos y totales
		$pdf->Cell(18, 5, "", 0, 0, 'C');
		$pdf->Cell(22, 5, "DESCUENTO", 0, 0, 'C');
		$pdf->Cell(32, 5, "+ " . number_format($sale->valor_descuentoGlobal), 0, 0, 'C');
		$pdf->Ln(5);
		$pdf->Cell(18, 5, "", 0, 0, 'C');
		$pdf->Cell(22, 5, "SUBTOTAL", 0, 0, 'C');
		$pdf->Cell(32, 5, "+ " . number_format($sale->subTotal), 0, 0, 'C');
		$pdf->Ln(5);
		$pdf->Cell(18, 5, "", 0, 0, 'C');
		$pdf->Cell(22, 5, "IMPUESTOS", 0, 0, 'C');
		$pdf->Cell(32, 5, "+ " . number_format($sale->impuestos), 0, 0, 'C');
		$pdf->Ln(5);
		$pdf->Cell(18, 5, "", 0, 0, 'C');
		$pdf->Cell(22, 5, "TOTAL A PAGAR", 0, 0, 'C');
		$pdf->Cell(32, 5, "$ " . number_format($sale->total), 0, 0, 'C');
		$pdf->Ln(10);

		// Código de barras
		$pdf->Code128(5, $pdf->GetY(), $sale->codigo, 70, 10);

		// Capturar la salida del PDF en una variable
		ob_start();
		$pdf->Output();
		$pdfData = ob_get_clean();

		// Devolver el PDF como respuesta HTTP
		return response($pdfData)
			->header('Content-Type', 'application/pdf');
	}
}
