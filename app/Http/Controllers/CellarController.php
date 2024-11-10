<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cellar;

class CellarController extends Controller
{
    public function index(Request $request) {
		
		$search = $request->input('search');
		$perPage = $request->input('per_page', 5);
		$cellars = Cellar::query();
		
		if ($search) {
			$searchableFields = ['nombre', 'ubicacion', 'detalles'];

			$cellars->where(function($query) use ($searchableFields, $search) {
				foreach ($searchableFields as $field) {
					$query->orWhere($field, 'LIKE', '%' . $search . '%');
				}
			});
		}
		
		$cellars = $cellars->paginate($perPage);
		
		return response()->json($cellars);
	}
	
	public function show($id)
	{
		$cellar = Cellar::find($id);
		
		return response()->json($cellar);
	}
	
	public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required|integer',
            'nombre' => 'required',
            'ubicacion' => 'required',
            'detalles' => 'nullable',
        ]);

        $cellar = Cellar::create($request->all());
		
		$existingCellars = Cellar::count();
		if ($existingCellars == 1 || $existingCellars == 0) {
			$cellar->predeterminada = true;
			$cellar->save();
		}

        return response()->json(['message' => 'Bodega creada exitosamente']);
    }
	
	public function update(Request $request, $id)
	{
		$request->validate([
            'company_id' => 'required|integer',
            'nombre' => 'required',
            'ubicacion' => 'required',
            'detalles' => 'nullable',
        ]);
		
		Cellar::find($id)->update($request->all());
		
		return response()->json(['message' => 'Bodega actualizada exitosamente']);
	}
	
	public function default($id)
	{
		$cellar = Cellar::findOrFail($id);
		
		if ($cellar->predeterminada) {
			return response()->json(['error' => 'La bodega ya está marcada como predeterminada'], 400);
		}
		
		$cellar->predeterminada = true;
		$cellar->save();
		
		Cellar::where('id', '!=', $cellar->id)->update(['predeterminada' => false]);
		
		return response()->json(['message' => 'Bodega predeterminada marcada con éxito']);
	}
	
	public function destroy($id)
	{
		$cellar = Cellar::find($id);

		if (!$cellar) {
			return response()->json(['error' => 'Bodega no encontrada'], 404);
		}

		if ($cellar->predeterminada) {
			return response()->json(['error' => 'No puedes eliminar la bodega predeterminada.'], 422);
		}

		$cellar->delete();

		return response()->json(['message' => 'Bodega eliminada exitosamente']);
	}
}
