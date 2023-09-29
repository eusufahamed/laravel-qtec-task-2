<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use App\Models\User;

class AuthController extends Controller
{   
    // Registration Form
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // User Registration function 
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect('/login')->with('success', 'Registration successful.');
    }

    // Login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // User loging function 
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed
            return redirect()->route('url.create');
        }

        // Authentication failed
        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    // Logout function
    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}