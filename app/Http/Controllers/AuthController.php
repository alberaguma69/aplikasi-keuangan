<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * LOGIN
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * REGISTER
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * STORE
     */
    public function store(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password)
        ]);

        return redirect('/login');
    }

    /**
     * AUTHHENTICATE
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            // ROLE KEUANGAN
            if (auth()->user()->role == 'keuangan') {

                return redirect('/keuangan/dashboard');

            }

            // ROLE PEMOHON
            return redirect('/dashboard');
        }

        return back()->with('error', 'Login gagal');
    }

    /**
     * LOGOUT
     */
    public function logout()
    {
        Auth::logout();

        return redirect('/login');
    }
}