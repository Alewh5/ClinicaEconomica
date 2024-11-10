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
			'nombre' => 'required|string|max:50',
			'email' => 'required|email|unique:users,email,'.$user->id,
			'telefono' => 'nullable|numeric',
			'direccion' => 'nullable|string|max:255',
		]);
		
		$user->update($request->all());
		
		return response()->json(['message' => 'Usuario actualizado correctamente', 'user' => $user], 200);
	}
}
