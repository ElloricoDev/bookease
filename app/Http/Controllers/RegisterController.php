<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('register'); // resources/views/register.blade.php
    }

    public function register(Request $request)
    {
        // Validate inputs
        $request->validate([
            'name'     => 'required|string|max:255',
            'contact'  => 'nullable|string|min:7',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        // Create user
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user', // default role
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! You can now login.');
    }
}
