<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|max:32',
                'password' => 'required|confirmed|min:7|max:16',
                'email' => 'required|email|unique:users,email|max:32',
                'phone_nr' => 'required|min:8|max:32',
            ]);

            User::create([
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'email' => $request->email,
                'phone_nr' => $request->phone_nr,
                'role' => 'User',
            ]);

            return redirect()->route('login')->with('success', 'Registered Sucessfully!');
        } catch (\Exception $e) {
            return back()->withErrors([
                'default' => 'An error occured, try again later',
            ])->withInput($request->only('default'));
        }
    }

    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            $request->session()->regenerate(); // prevent session fixation

            return redirect()->intended('profile');
        }

        return back()->withErrors([
            'email' => 'Invalid Credentials.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('main');
    }
}
