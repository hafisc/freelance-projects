<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('username','password');

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            // cek role
            if(auth()->user()->role == 'guru'){
                return redirect('/guru-siswa');
            }

            return redirect('/home');
        }

        return back()->with('error','Username atau password salah');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
