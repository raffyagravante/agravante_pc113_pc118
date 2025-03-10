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
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]
            );
    
            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid credentials!',
                ], 401);
            }
    
            $user = User::where('email', $request->email)->first();
    
            Log::info('User retrieved:', ['email' => $request->email, 'user_id' => $user->id]);
    
            if (empty($user)) {
                return response()->json([
                    'message' => 'User not found',
                ], 404);
            }
    
            $token = $user->createToken('auth_token')->plainTextToken;
    
            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token,
            ]);
    
        } catch (\Throwable $th) {
            Log::error('Exception occurred during login:', ['message' => $th->getMessage()]);
    
            return response()->json([
                'status' => false,
                'message' => 'An error occurred during login',
                'error' => $th->getMessage()
            ], 500);
        }
    }
    

}
