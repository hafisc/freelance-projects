<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocsController extends Controller
{
    /**
     * Menampilkan halaman dokumentasi sistem perpustakaan PustakaLink.
     */
    public function index()
    {
        return view('docs.index');
    }
}
