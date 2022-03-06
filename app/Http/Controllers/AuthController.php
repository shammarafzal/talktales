<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'age' => 'required',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'age' => $request->input('age'),
        ]);

        $token = $user->createToken($request->input('name'))->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => 'User logout successfully',
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|min:8',
        ]);

        $user = User::where('email', $request->input('email'))->first();
        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'message' => 'The provided credentials are incorrect',
            ], 401);
        }
        $token = $user->createToken($user->name)->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 200);
    }
}
