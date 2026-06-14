<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Job;

class JobController extends Controller
{
    // Mengambil daftar lowongan pekerjaan yang berstatus aktif
    public function index()
    {
        $jobs = Job::where('status', 'Aktif')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil daftar lowongan pekerjaan',
            'data' => $jobs,
        ], 200);
    }

    // Mengambil detail lowongan pekerjaan tertentu
    public function show($id)
    {
        $job = Job::find($id);

        if (! $job) {
            return response()->json([
                'success' => false,
                'message' => 'Lowongan pekerjaan tidak ditemukan',
                'errors' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil detail lowongan pekerjaan',
            'data' => $job,
        ], 200);
    }
}
