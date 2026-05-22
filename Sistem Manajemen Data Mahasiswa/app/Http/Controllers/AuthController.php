<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login admin.
     */
    public function showLogin()
    {
        // Jika admin sudah login, langsung arahkan ke dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        }

        return view('auth.login');
    }

    /**
     * Memproses data login yang dikirim oleh admin.
     */
    public function login(Request $request)
    {
        // Validasi input email dan password
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Mencoba melakukan autentikasi admin
        if (Auth::attempt($credentials)) {
            // Meregenerasi session untuk keamanan
            $request->session()->regenerate();

            // Mengarahkan ke halaman dashboard dengan pesan sukses
            return redirect()->route('dashboard.index')
                ->with('success', 'Selamat datang kembali, Admin!');
        }

        // Jika login gagal, kembalikan ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Memproses logout admin dari sistem.
     */
    public function logout(Request $request)
    {
        // Mengeluarkan admin dari sesi aktif
        Auth::logout();

        // Menghapus sesi saat ini
        $request->session()->invalidate();

        // Meregenerasi CSRF token sesi baru
        $request->session()->regenerateToken();

        // Mengarahkan kembali ke halaman login dengan pesan sukses
        return redirect()->route('login')
            ->with('success', 'Anda telah berhasil keluar dari sistem.');
    }
}
