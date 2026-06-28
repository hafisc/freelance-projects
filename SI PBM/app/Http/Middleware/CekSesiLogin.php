<?php
 
namespace App\Http\Middleware;
 
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
 
class CekSesiLogin
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek Apakah Sudah Login
        if (!$request->session()->has('login')) {
            return redirect('/')->with('loginError', 'Silakan login terlebih dahulu.');
        }
 
        $userRole = $request->session()->get('role');
 
        // 2. ADMIN: Akses Penuh
        if ($userRole === 'Admin') {
            return $next($request);
        }
 
        // 3. Cek apakah role saat ini ada di dalam list role yang diperbolehkan
        if (!in_array($userRole, $roles)) {
            $rolePath = strtolower($userRole);
            return redirect('/' . $rolePath . '/dashboard')->with('loginError', 'Akses ditolak: Anda tidak memiliki wewenang untuk halaman tersebut.');
        }
 
        return $next($request);
    }
}
