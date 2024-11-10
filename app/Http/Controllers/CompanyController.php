<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function show($id)
    {
        $company = Company::find($id);
        return response()->json($company, 200);
    }

    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $request->validate([
            'nit' => 'numeric|min:00000000001|max:99999999999',
            'nombre' => 'string',
            'direccion' => 'string',
            'telefono' => 'numeric|min:00000000001|max:99999999999',
            'email' => 'email',
            'sitio_web' => 'nullable|string',
			'municipio' => 'string',
			'departamento' => 'string',
			'codigo_postal' => 'integer'
        ]);

        $company->update($request->all());

        return response()->json(['message' => 'Empresa actualizada con éxito'], 200);
    }
}
