<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WasteReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    // Mengambil semua laporan sampah (untuk Admin)
    public function index()
    {
        // Mengambil laporan beserta nama user yang melapor
        $reports = WasteReport::with('user:id,name')->latest()->get();
        
        return response()->json([
            'success' => true,
            'data'    => $reports
        ], 200);
    }

    // Mengirim laporan baru (dari Mobile/Flutter)
    public function store(Request $request)
    {
        
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'location' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string'
        ]);

        // Simpan file ke storage/app/public/reports
        $path = $request->file('photo')->store('reports', 'public');

        $report = WasteReport::create([
            'user_id' => $request->user()->id, 
            'photo_path' => $path, // Simpan path untuk akses nantinya
            'location' => $request->location,
            'category' => $request->category,
            'description' => $request->description,
            'status' => 'pending' // Default status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil dikirim ke Admin',
            'data'    => $report
        ], 201);
    }

    // Verifikasi laporan (untuk Admin)
    public function verify(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:verified,rejected'
        ]);

        $report = WasteReport::findOrFail($id);
        $report->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status laporan berhasil diperbarui'
        ], 200);
    }
}