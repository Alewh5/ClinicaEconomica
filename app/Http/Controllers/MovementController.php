<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use App\Models\Product;
use App\Models\Cellar;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MovementController extends Controller
{

    public function index(Request $request)
    {
		$search = $request->input('search');
		$perPage = $request->input('per_page', 5);
		$movements = Movement::query();
		
		if ($search) {
			$searchableFields = ['cellar_id', 'fecha', 'tipoMovimiento', 'concepto'];

			$movements->where(function($query) use ($searchableFields, $search) {
				foreach ($searchableFields as $field) {
					$query->orWhere($field, 'LIKE', '%' . $search . '%');
				}
			});
		}
		
		$movements = $movements->with('cellar')->orderBy('created_at', 'desc')->paginate($perPage);
		
        return response()->json($movements);
    }
	
	public function show($id)
	{
		$movement = Movement::find($id);
		
		$movement->load('movementProduct');
		$movement->load('cellar');
		
		return response()->json($movement);
	}

    public function store(Request $request)
    {
        $request->validate([
			'cellar_id' => 'required|exists:cellars,id',
            'fecha' => 'required|date',
            'tipoMovimiento' => 'required|boolean',
            'concepto' => 'required',
			'total' => 'required',
			
			'products' => 'required|array',
			'products.*.product_id' => 'required|exists:products,id',
            'products.*.cantidad' => 'required|numeric|gt:0',
			'products.*.costo_unitario' => 'required|numeric|gte:0',
			'products.*.costo_total' => 'required|numeric|gte:0',
        ]);

        $cellar = Cellar::find($request->cellar_id);
		
		DB::beginTransaction();
		
		try{
			$movement = new Movement($request->except('products'));
			$movement->save();
			
			$products = $request->input('products');
			
			foreach ($products as $productData) {
				$product = Product::findOrFail($productData['product_id']);
				$existingPivot = $cellar->products()->where('product_id', $product->id)->first();
				$movement->movementProduct()->attach($product, $productData);
				
				if ($existingPivot) {
					if ($request->tipoMovimiento) {
						$cantidad = $existingPivot->pivot->cantidad + $productData['cantidad'];
					} else {
						if ($existingPivot->pivot->cantidad < $productData['cantidad']) {
							throw new \Exception('La cantidad de ' . $existingPivot->descripcion . ' sobrepasa a lo que tienes en stock: ' . $existingPivot->pivot->cantidad);
						}
						$cantidad = $existingPivot->pivot->cantidad - $productData['cantidad'];
					}
					$cellar->products()->updateExistingPivot($product->id, ['cantidad' => $cantidad]);
				} else {
					if ($request->tipoMovimiento) {
						$pivotData = ['cantidad' => $productData['cantidad']];
						$cellar->products()->attach($product->id, $pivotData);
					} else {
						throw new \Exception('La ' . $product->descripcion . ' no tiene stock en '. $cellar->nombre );
					}
				}
			}
			
			DB::commit();
			
			return response()->json(['message' => 'Movimiento registrado exitosamente'], 201);
		} catch (\Exception $e){
			DB::rollBack();
			
			return response()->json(['error' => $e->getMessage()], 500);
		}
    }
}
