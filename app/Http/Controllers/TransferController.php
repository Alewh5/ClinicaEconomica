<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transfer;
use App\Models\Cellar;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class TransferController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
		$perPage = $request->input('per_page', 5);
		$transfers = Transfer::query();
		
		if ($search) {
			$searchableFields = ['fecha_traslado', 'detalles'];

			$transfers->where(function($query) use ($searchableFields, $search) {
				foreach ($searchableFields as $field) {
					$query->orWhere($field, 'LIKE', '%' . $search . '%');
				}
			});
		}
		
		$transfers = $transfers->orderBy('created_at', 'desc')->paginate($perPage);
		
		$transfers->each(function ($transfer) {
			$transfer->cellar_origen_nombre = Cellar::find($transfer->cellar_origen_id)->nombre;
			$transfer->cellar_destino_nombre = Cellar::find($transfer->cellar_destino_id)->nombre;
		});
		
        return response()->json($transfers);
    }
	
	public function store(Request $request)
    {
        $request->validate([
			'fecha_traslado' => 'required|date',
			'detalles' => 'nullable',
			'cellar_origen_id' => 'required|exists:cellars,id',
			'cellar_destino_id' => 'required|exists:cellars,id',
			
			'products' => 'required|array',
			'products.*.product_id' => 'required|exists:products,id',
			'products.*.cantidad' => 'required|numeric|gt:0'
        ]);
		
		if ($request->cellar_origen_id === $request->cellar_destino_id) {
			return response()->json(['error' => 'La bodega de origen y destino no pueden ser la misma'], 500);
		}
		
		DB::beginTransaction();
		
		try{
			$transfer = new Transfer($request->except('products'));
			$transfer->save();
			
			$products = $request->input('products');
			
			foreach ($products as $productData) {
				$product = Product::findOrFail($productData['product_id']);
				$cellar_origen = Cellar::find($request->cellar_origen_id);
				$cellar_destino = Cellar::find($request->cellar_destino_id);
				
				// Agregar el producto a la transferencia
				$transfer->transferProduct()->attach($product, ['cantidad' => $productData['cantidad']]);
				
				if($cellar_origen->products->contains($product))
				{
					//VALIDAMOS LA CANTIDAD A TRANSFERIR
					if ($productData['cantidad'] > $cellar_origen->products->find($product->id)->pivot->cantidad) {
						throw new \Exception('La cantidad transferida es superior a la disponible en la bodega de origen para ese producto');
					}
					//RESTAMOS LA CANTIDAD EN LA BODEGA DE ORIGEN
					$PivotOrigen = $cellar_origen->products->find($product->id)->pivot;
					$PivotOrigen->cantidad -= $productData['cantidad'];
					$cellar_origen->products()->updateExistingPivot($product->id, ['cantidad' => $PivotOrigen->cantidad]);
				} else
				{
					throw new \Exception('El producto no existe en la bódega de origen');
				}
				
				if(!$cellar_destino->products->contains($product))
				{
					$cellar_destino->products()->attach([$product->id => ['cantidad' => $productData['cantidad']]]);
				} else
				{
					//RESTAMOS LA CANTIDAD EN LA BODEGA DE ORIGEN
					$PivotDestino = $cellar_destino->products->find($product->id)->pivot;
					$PivotDestino->cantidad += $productData['cantidad'];
					$cellar_destino->products()->updateExistingPivot($product->id, ['cantidad' => $PivotDestino->cantidad]);
				}
			}
			
			DB::commit();
				
			return response()->json(['message' => 'Transferencia registrada exitosamente']);
			
		} catch (\Exception $e){
			DB::rollBack();
			
			return response()->json(['error' => $e->getMessage()], 400);
		}
    }
	
	public function show($id)
	{
		$transfer = Transfer::find($id);
		
		$transfer->load('transferProduct');
		$transfer->load('cellar_origen', 'cellar_destino');
		
		return response()->json($transfer);
	}
}
