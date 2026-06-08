<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\GelombangSubmission;

class GelombangSubmissionController extends Controller
{
    // =========================
    // HALAMAN SISWA
    // =========================
    public function index()
    {
        return view('siswa.pengumpulan_gelombang');
    }

    // =========================
    // PROSES UPLOAD
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:2048',
            'latihan_code' => 'required'
        ], [
            'file.required' => 'Silakan pilih file PDF terlebih dahulu.',
            'file.mimes' => 'File harus berformat PDF.',
            'file.max' => 'Ukuran file maksimal 2 MB.'
        ]);

        $file = $request->file('file');

        $fileName = $request->latihan_code . '_' . Auth::id() . '_' . time() . '.pdf';

        $result = $file->move(
            public_path('submissions'),
            $fileName
        );

        $path = 'submissions/' . $fileName;

        GelombangSubmission::create([
            'user_id' => Auth::id(),
            'latihan_code' => $request->latihan_code,
            'file_path' => $path
        ]);

        return back()->with('success', 'File berhasil dikumpulkan!');
    }

    // =========================
    // HALAMAN GURU
    // =========================
    public function daftar()
    {
        $data = GelombangSubmission::with('user')->latest()->get();
        return view('guru.daftar_pengumpulan', compact('data'));
    }
}