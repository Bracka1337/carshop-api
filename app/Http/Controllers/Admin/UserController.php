<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());


        $validated = $request->validate([
            'username' => 'required',
            'password'=> 'required|confirmed',
            'email'=> 'required|email',
            'phone_nr' => 'required',
        ]);

        User::create($validated);

        return response()->json([
            'Message' => "User Registerd",
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return User::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        dd($id);
        $validated = $request->validate([
            'username' => 'required|unique',
            'password'=> 'required|confirmed',
            'email'=> 'required|email|unique',
            'phone_nr' => 'required|unique',
        ]);

        User::find($id)->update($validated);

        return response()->json(['message'=> 'Updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
    }
}
