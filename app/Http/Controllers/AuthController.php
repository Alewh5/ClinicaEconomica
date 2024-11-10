<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'nombre' => $request->input('nombre'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        $token = $user->createToken('token-name')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token], 201);
    }


    public function login(Request $request)
	{
		$request->validate([
			'email' => 'required|email',
			'password' => 'required|min:8',
		]);

		$credentials = $request->only('email', 'password');

		if (Auth::attempt($credentials)) {
			$user = Auth::user();
			$company = Company::find($user->company_id);
			$token = $user->createToken('token-name')->plainTextToken;

			return response()->json(['user' => $user, 'company' => $company, 'token' => $token], 200);
		}

		$user = User::where('email', $request->email)->first();

		if (!$user) {
			throw ValidationException::withMessages([
				'email' => ['El correo electrónico proporcionado es incorrecto.'],
			])->status(401);
		}
		throw ValidationException::withMessages([
			'password' => ['La contraseña proporcionada es incorrecta.'],
		])->status(401);
	}


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
