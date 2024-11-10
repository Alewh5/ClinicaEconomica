<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index(Request $request)
	{
		$search = $request->input('search');
		$perPage = $request->input('per_page', 5);
		$customers = Customer::query();

		if ($search) {
			$searchableFields = ['numeroDocumento', 'NombreRazonSocial', 'direccion', 'telefono', 'email', 'departamento', 'municipio'];

			$customers->where(function($query) use ($searchableFields, $search) {
				foreach ($searchableFields as $field) {
					$query->orWhere($field, 'LIKE', '%' . $search . '%');
				}
			});
		}

		$customers = $customers->paginate($perPage);

		return response()->json($customers);
	}
	
	public function show($id)
	{
		$Customer = Customer::findOrFail($id);
		
		return response()->json($Customer);
	}
	
	public function store(Request $request)
	{
		$request->validate([
			'tipoDocumento' => 'required|in:CC,CE,NIT,TI,PB',
			'numeroDocumento' => 'required|unique:customers,numeroDocumento|numeric|gt:0',
			'NombreRazonSocial' => 'required|max:50',
			'direccion' => 'nullable|max:50',
			'telefono' => 'required|unique:customers,telefono|numeric|gt:0',
			'email' => 'required|email|unique:customers,email',
			'departamento' => 'nullable|max:30',
			'municipio' => 'nullable|max:30',
		]);
		
		$customer = Customer::create($request->all());
		
		return response()->json(['message' => 'Cliente creado con exito',  'customer' => $customer], 201);
	}
	
	public function update(Request $request, $id)
	{
		$customer = Customer::find($id);
		
		$request->validate([
			'tipoDocumento' => 'required|in:CC,NIT,TI,PP',
			'numeroDocumento' => 'required|gt:0|unique:customers,numeroDocumento,' . $customer->id,
			'NombreRazonSocial' => 'required|max:50',
			'direccion' => 'nullable|max:50',
			'telefono' => 'required|gt:0|unique:customers,telefono,'. $customer->id,
			'email' => 'required|email|unique:customers,email,'. $customer->id,
			'departamento' => 'nullable|max:30',
			'municipio' => 'nullable|max:30',
		]);
		
		$customer->update($request->all());
		
		return response()->json(['message' => 'Cliente actualizado con exíto', 'customer' => $customer]);
	}
	
	public function destroy($id)
	{
		Customer::findOrFail($id)->delete();
		
		return response()->json(['message' => 'Cliente eliminado con exíto']);
	}
}
