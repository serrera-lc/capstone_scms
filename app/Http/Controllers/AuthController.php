<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLogin()
    {
        return view('login');
    }

    /**
     * Handle login submission.
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect based on role
            $role = Auth::user()->role;

            return match ($role) {
                'admin'     => redirect('/admin_dashboard'),
                'counselor' => redirect('/counselor/dashboard'),
                'student'   => redirect('/student_dashboard'),
                default     => redirect('/login'),
            };
        }

        return back()->withErrors([
            'email' => 'Invalid login credentials',
        ])->onlyInput('email');
    }

    /**
     * Logout the user.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
