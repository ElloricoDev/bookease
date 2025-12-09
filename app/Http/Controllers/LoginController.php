<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        // Check if user exists
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email not found.']);
        }

        // Check password manually
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Incorrect password.']);
        }

        // Save user login manually in session
        session([
            'logged_in' => true,
            'user_id'   => $user->id,
            'role'      => $user->role,
            'name'      => $user->name,
        ]);

        // ROLE-BASED REDIRECT
        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        }

        return redirect('/user/dashboard');
    }

    public function logout()
    {
        session()->flush();
        return redirect('/login');
    }
}
