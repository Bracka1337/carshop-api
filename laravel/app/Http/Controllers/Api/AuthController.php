<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function register(Request $request) {
        $request->validate([
            
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'User'
        ]);

        return response()->json([
            'status' => true,
            'message'=> 'User Created Successfully'
        ]);
    }

    public function login(Request $request) {
        $request->validate([
            'email'=> 'required|email',
            'password'=> 'required'
        ]);

        if (Auth::attempt([
            'email'=> $request->email,
            'password'=> $request->password,
        ])){
            $user = Auth::user();
            $token = $user->createToken('myToken')->accessToken;

            return response()->json([
                'status'=> true,
                'message'=> 'Login Successful',
                'token'=> $token,
            ]);
        } else {
            return response()->json([
                'status'=> false,
                'message'=> 'Invalid credentials'
            ]);
        }
    }

    public function logout() {
        $user = Auth::user();

        auth()->user()->token()->revoke();

        return response()->json([
            'status'=> true,
            'message'=> 'Logged Out'
        ]);  
    }   
}
