<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Sale;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    public function index()
	{
		$Payments = Payment::all();
		
		return response()->json($Payments);
	}
	
	public function store(Request $request)
	{
		$request->validate([
			'monto' 		=> 'required|numeric|gte:0',
			'fecha' 		=> 'required|date',
			'sale_id' 		=> 'required_without:invoice_id|exists:sales,id',
			'invoice_id' 	=> 'required_without:sale_id|exists:invoices,id',
		]);
		
		DB::beginTransaction();

		try {
			if ($request->has('sale_id')) {
				$sale = Sale::findOrFail($request->sale_id);

				// Verifica si la venta tiene un estado diferente a "pendiente"
				if ($sale->estadoFactura) {
					throw new \Exception('No se puede registrar un pago para una venta con estado diferente a "pendiente".');
				}

				// Verifica si el monto del pago es mayor que el saldo pendiente
				if ($request->monto > $sale->deuda) {
					throw new \Exception('El monto del pago no puede ser mayor que la deuda pendiente.');
				}

				$sale->deuda -= $request->monto;
				$sale->save();
				
				if ($sale->deuda == 0) {
					$sale->estadoFactura = 1;
					$sale->save();
				}
			} else {
				$invoice = Invoice::findOrFail($request->invoice_id);

				// Verifica si la factura tiene un estado diferente a "pendiente"
				if ($invoice->estadoFactura) {
					throw new \Exception('No se puede registrar un pago para una factura con estado diferente a "pendiente".');
				}

				// Verifica si el monto del pago es mayor que el saldo pendiente
				if ($request->monto > $invoice->deuda) {
					throw new \Exception('El monto del pago no puede ser mayor que la deuda pendiente.');
				}

				$invoice->deuda -= $request->monto;
				$invoice->save();
				
				if ($invoice->deuda == 0) {
					$invoice->estadoFactura = 1;
					$invoice->save();
				}
			}
			
			$payment = new Payment([
				'monto' 		=> $request->monto,
				'fecha' 		=> $request->fecha,
				'sale_id' 		=> $request->sale_id ?? null,
				'invoice_id' 	=> $request->invoice_id ?? null,
			]);

			$payment->save();
			
			DB::commit();

			return response()->json(['message' => 'Pago registrado exitosamente'], 201);
		} catch (\Exception $e) {
			DB::rollBack();

			return response()->json(['error' => $e->getMessage()], 500);
		}
	}

}
