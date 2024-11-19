<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($id)
    {
        $User = User::find($id);

        return response()->json($User);
    }
	
	public function update(Request $request, $id)
	{
		$user = User::findOrFail($id);
		
		$request->validate([
			'nombre' 	=> 'required|string|max:50',
			'email' 	=> 'required|email|unique:users,email,'.$user->id,
			'telefono' 	=> 'nullable|numeric',
			'direccion' => 'nullable|string|max:255',
		]);
		
		$user->update($request->all());
		
		return response()->json(['message' => 'Usuario actualizado correctamente', 'user' => $user], 200);
	}

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 5);
        $search = $request->input('search', '');

        $query = User::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('telefono', 'LIKE', "%{$search}%");
            });
        }

        $users = $query->paginate($perPage);
        
        return response()->json($users);
    }

	public function store(Request $request)
	{
		$validated = $request->validate([
			'nombre'    => 'required|string|max:50',
			'email'     => 'required|email|unique:users,email',
			'role'      => 'required',
			'telefono'  => 'nullable|numeric',
			'direccion' => 'nullable|string|max:255',
			'password'  => 'required'
		]);

		$validated['password'] = bcrypt($validated['password']);

		$user = User::create($validated);

		return response()->json([
			'message' => 'Usuario creado correctamente',
			'user' => $user
		], 201);
	}

}
