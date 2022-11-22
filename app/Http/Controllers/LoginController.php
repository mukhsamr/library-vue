<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function index()
    {
        return Inertia::render('Login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'nama' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'fail' => 'Login gagal !!',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
