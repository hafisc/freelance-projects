<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
 
class LoginController extends Controller
{
    /**
     * Menampilkan halaman login utama.
     * Jika user sudah terautentikasi (mempunyai sesi login), redirect ke dashboard masing-masing.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        if (session()->has('login')) {
            $role = session('role');
            return redirect('/' . strtolower($role) . '/dashboard');
        }
        return view('auth.login');
    }
 
    /**
     * Memproses otentikasi user (login).
     * Memvalidasi input, memverifikasi password, dan menyimpan data user ke dalam sesi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function autentikasi(Request $request)
    {
        // Validasi input email dan password
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
 
        // Cari user berdasarkan email
        $user = User::where('email', $credentials['email'])->first();
 
        // Verifikasi password dan buat sesi jika cocok
        if ($user && Hash::check($credentials['password'], $user->password)) {
            $request->session()->put('login', true);
            $request->session()->put('user_id', $user->id);
            $request->session()->put('role', $user->role);
            $request->session()->put('nama', $user->name);
            $request->session()->put('nim', $user->nim);
            $request->session()->put('dosen_id', $user->dosen_id);
 
            $rolePath = strtolower($user->role);
            return redirect()->intended('/' . $rolePath . '/dashboard')->with('success', 'Selamat Datang ' . $user->name . '!');
        }
 
        // Jika otentikasi gagal, kembali ke halaman login dengan pesan error
        return back()->with('loginError', 'Email atau Password salah! Akses ditolak.');
    }
 
    /**
     * Memproses logout user.
     * Membersihkan seluruh data sesi dan kembali ke halaman login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/')->with('success', 'Anda telah berhasil keluar.');
    }
}
