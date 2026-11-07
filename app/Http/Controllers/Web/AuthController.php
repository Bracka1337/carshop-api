<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister(): View
    {
        return view('register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        // The password is hashed by the model's "hashed" cast.
        User::create([...$request->validated(), 'role' => 'User']);

        return redirect()->route('login')->with('success', 'Registered successfully!');
    }

    public function showLogin(): View
    {
        return view('login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        if (Auth::attempt($request->validated())) {
            $request->session()->regenerate(); // prevent session fixation

            return redirect()->intended('profile');
        }

        return back()->withErrors([
            'email' => 'Invalid Credentials.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('main');
    }
}
