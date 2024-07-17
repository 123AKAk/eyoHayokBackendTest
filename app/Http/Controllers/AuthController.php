<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try
        {
            $fields = $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed'
            ]);
    
            $user = User::create($fields);
    
            $token = $user->createToken($request->name);
    
            return response()->json([
                'response' => true,
                'user' => $user,
                'token' => $token->plainTextToken,
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'response' => false,
                'message' => $e->errors()
            ], 422);
        }
    }

    public function login(Request $request)
    {
        try
        {
            $request->validate([
                'email' => 'required|email|exists:users',
                'password' => 'required'
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return [
                    'message' => 'The provided credentials are incorrect.' 
                ];
            }

            $token = $user->createToken($user->name);

            return [
                'response' => true,
                'user' => $user,
                'token' => $token->plainTextToken
            ];

        } catch (ValidationException $e) {
            return response()->json([
                'response' => false,
                'message' => $e->errors()
            ], 422);
        }
    }

    public function logout(Request $request)
    {
        try
        {
            $request->user()->tokens()->delete();

            return [
                'response' => true,
                'message' => 'You are logged out.' 
            ];

        } catch (ValidationException $e) {
            return response()->json([
                'response' => false,
                'message' => $e->errors()
            ], 422);
        }
    }
}
