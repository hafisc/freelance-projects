<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\HakAkses;
 
class HakAksesController extends Controller
{
    /**
     * Menampilkan daftar semua Hak Akses / role pengguna yang terdaftar di sistem.
     * Halaman ini hanya bersifat baca (Read-Only) untuk kebutuhan administrasi hak akses.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $hakAkses = HakAkses::all();
        return view('admin.hak-akses.index', compact('hakAkses'));
    }
}
