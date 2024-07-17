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

        try {
            $request->validate([
                'name' => 'required|max:255',
                'password'=> 'required|confirmed|min:8|max:16',
                'email'=> 'required|email|unique:users,email|max:255',
                'phone_nr' => 'required|min:8|max:32',
            ]);
    
            User::create([
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'email' => $request->email,
                'phone_nr' => $request->phone_nr,
                'role' => 'User',
            ]);
    
            return redirect()->route('login')->with('success','Registered Sucessfully!');
        } catch (\Exception $e) {
            return back()->withErrors([
                'default' => $e->getMessage(),
            ])->withInput($request->only('default'));
        }
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
            
            $cookie = cookie('access_token', $token, 60, null, null, true, true);
            return redirect()->intended('profile')->cookie($cookie);
        }
        return back()->withErrors([
            'email' => 'Invalid Credentials.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request) {
        $user = Auth::user();
        if ($user) {
            $user->tokens()->delete(); // Revoke all tokens
        }
        
        Auth::logout(); // Log out the user

        $request->session()->invalidate(); // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate the CSRF token
        return redirect()->route('main')->withoutCookie('access_token');
    }   
}
