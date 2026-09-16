<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class SystemInfoController extends Controller
{
    // Menampilkan halaman informasi sistem yang berjalan dan usulan perbaikan
    public function index()
    {
        return view('admin.system.index');
    }
}
