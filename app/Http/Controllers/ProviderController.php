<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provider;

class ProviderController extends Controller
{
    public function index(Request $request)
	{
		$search = $request->input('search');
		$perPage = $request->input('per_page', 5);
		$providers = Provider::query();
		
		if ($search) {
			$searchableFields = ['numeroDocumento', 'NombreRazonSocial', 'direccion', 'telefono', 'email', 'departamento', 'municipio'];

			$providers->where(function($query) use ($searchableFields, $search) {
				foreach ($searchableFields as $field) {
					$query->orWhere($field, 'LIKE', '%' . $search . '%');
				}
			});
		}
		
		$providers = $providers->paginate($perPage);
		
		return response()->json($providers);
	}
	
	public function show($id)
	{
		$Provider = Provider::findOrFail($id);
		
		return response()->json($Provider);
	}
	
	public function store(Request $request)
	{
		$request->validate([
			'tipoDocumento' 	=> 'required|in:CC,NIT,TI,PP',
			'numeroDocumento' 	=> 'required|unique:providers,numeroDocumento|numeric|gt:0',
			'NombreRazonSocial' => 'required|max:50',
			'direccion' 		=> 'nullable|max:50',
			'telefono' 			=> 'required|unique:providers,telefono|numeric|gt:0',
			'email' 			=> 'required|email|unique:providers,email',
			'departamento' 		=> 'nullable',
			'municipio' 		=> 'nullable',
			'responsable_iva' 	=> 'required|boolean'
		]);
		
		$provider = Provider::create($request->all());
		
		return response()->json(['message' => 'Proveedor creado con exito']);
	}
	
	public function update(Request $request, $id)
	{
		$provider = Provider::find($id);
		
		$request->validate([
			'tipoDocumento' 	=> 'required|in:CC,NIT,TI,PP',
			'numeroDocumento' 	=> 'required|unique:providers,numeroDocumento,'. $provider->id,
			'NombreRazonSocial' => 'required',
			'direccion' 		=> 'nullable|max:50',
			'telefono' 			=> 'required|unique:providers,telefono,'. $provider->id,
			'email' 			=> 'required|email|unique:providers,email,'. $provider->id,
			'departamento' 		=> 'nullable',
			'municipio' 		=> 'nullable',
			'responsable_iva' 	=> 'required|boolean'
		]);
		
		$provider->update($request->all());
		
		return response()->json(['message' => 'Proveedor actualizado exitosamente']);
	}
	
	public function destroy($id)
	{
		Provider::findOrFail($id)->delete();
		
		return response()->json(['message' => 'Proveedor eliminado con exito']);
	}
}
