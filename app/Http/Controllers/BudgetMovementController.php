<?php

namespace App\Http\Controllers;

use App\Models\Budget_movement;
use App\Models\Company;
use Illuminate\Http\Request;

class BudgetMovementController extends Controller
{

    public function index(Request $request)
    {
		$search = $request->input('search');
		$perPage = $request->input('per_page', 5);
		$budgetMovements = Budget_movement::query();

		if ($search) {
			$searchableFields = ['codigo', 'fechaEmision'];

			$budgetMovements->where(function($query) use ($searchableFields, $search) {
				foreach ($searchableFields as $field) {
					$query->orWhere($field, 'LIKE', '%' . $search . '%');
				}
			});
		}

		$budgetMovements = $budgetMovements->orderBy('created_at', 'desc')->paginate($perPage);

		return response()->json($budgetMovements);
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_id'        => 'required|exists:companies,id',
            'fecha'             => 'required',
            'tipoMovimiento'    => 'required',
            'concepto'          => 'required',
            'monto'             => 'required',
        ]);
		
		$company = Company::find($request->company_id);
        
        if ($request->tipoMovimiento == 1) {
            $company->presupuesto += $request->monto;
        } else {
			if($request->monto > $company->presupuesto){
				return response()->json(['error' => 'No puedes retirar mas de lo que tienes'], 500);
			}
			$company->presupuesto -= $request->monto;
        }
		
		$budgetMovement = Budget_movement::create($request->all());
        $company->save();

        return response()->json(['message' => 'Presupuesto actualizado'], 201);
    }
}
