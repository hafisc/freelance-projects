<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\Notification;
use Illuminate\Http\Request;

class ApplicationManagementController extends Controller
{
    // Menampilkan daftar lamaran masuk dari pelamar
    public function index()
    {
        $applications = JobApplication::with(['job', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.applications.index', compact('applications'));
    }

    // Menampilkan detail lamaran tertentu
    public function show($id)
    {
        $application = JobApplication::with(['job', 'user'])->findOrFail($id);

        return view('admin.applications.show', compact('application'));
    }

    // Memperbarui status lamaran pelamar dan memberikan catatan admin
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Diproses,Diterima,Ditolak',
            'admin_note' => 'nullable|string',
        ]);

        $application = JobApplication::with('job')->findOrFail($id);
        $application->update([
            'status' => $request->status,
            'admin_note' => $request->admin_note,
        ]);

        // Buat notifikasi otomatis untuk pencari kerja (user)
        Notification::create([
            'user_id' => $application->user_id,
            'title' => 'Status Lamaran Diperbarui',
            'message' => 'Lamaran Anda untuk posisi ' . ($application->job ? $application->job->title : 'Pekerjaan') . ' saat ini berstatus: ' . $request->status . '.' . ($request->admin_note ? ' Catatan admin: ' . $request->admin_note : ''),
            'is_read' => false,
        ]);

        return redirect()->route('admin.applications.show', $id)
            ->with('success', 'Status lamaran pelamar berhasil diperbarui!');
    }
}

