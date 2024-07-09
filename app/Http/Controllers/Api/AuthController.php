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

    public function showRegister() {
        return view('register');
    }

    public function register(Request $request) {
        $request->validate([
            'username' => 'required',
            'password'=> 'required|confirmed',
            'email'=> 'required|email',
            'phone_nr' => 'required',
            'name' => 'required',
        ]);

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'phone_nr' => $request->phone_nr,
            'role' => 'User',
            'name'=> $request->name
        ]);

        return redirect()->route('login')->with('success','Registered Sucessfully!');
    }

    public function showLogin() {
        return view('login');
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
