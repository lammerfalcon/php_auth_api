<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use PHPUnit\Exception;

class AuthController extends Controller
{
 
    public function register(RegisterRequest $request)
    {
        try {
            $user = new User($request->validated());
            $user->password = Hash::make($request->input('password'));
            $user->save();
            return response()->json(['message' => 'Registration successful', 'user' => $user], 201);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Registration failed', 'error' => $e->getMessage()], 500);
        }
    }
    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $token = $user->createToken('auth-token')->plainTextToken;
        return response()->json([
            'user' => $user,
            'access_token' => $token
        ]);
    } else {
        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }
}
    
}
