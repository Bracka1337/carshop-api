<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show() {
        $user = auth()->user();
        $user->load('orders');
        return view('profile', compact('user'));
    }
}
