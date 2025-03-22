<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
   
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

  
    // public function login(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required|string',
    //     ]);

    //     if (!Auth::attempt($credentials)) {
    //         return response()->json(['message' => 'Invalid credentials'], 401);
    //     }

        
    //     $user = Auth::guard('web')->user();


    //     $user->tokens()->where('name', 'auth_token')->delete();

    //     $token = $user->createToken('auth_token')->plainTextToken;
        

    //     return response()->json([
    //         'message' => 'Login successful',
    //         'user' => $user,
    //         'token' => $token,
    //     ]);
    // }

   
    public function profile(Request $request)
    {
        return response()->json([
            'user' => $request->user()
        ]);
    }

  
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    public function login(Request $request)
    {
        // Validate request input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        // Find user by email
        $user = User::where('email', $credentials['email'])->first();

        // Check if user exists and password is correct
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Generate API Token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user
        ]);
    }
    

}
