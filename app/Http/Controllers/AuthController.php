<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function index()
    {
        return view('auth.login');
    }
    function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.menu.index');
        }

        return redirect()->back()->withErrors(trans('customErrorMessages.loginError'));
    }

    function logout(Request $request) 
{
    Auth::logout();
    
    // Güvenlik ve oturum temizliği için bu iki satır çok önemlidir
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login.get');
}
}
