<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobManagementController extends Controller
{
    // Menampilkan daftar lowongan pekerjaan
    public function index()
    {
        $jobs = Job::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.jobs.index', compact('jobs'));
    }

    // Menampilkan form tambah lowongan baru
    public function create()
    {
        return view('admin.jobs.create');
    }

    // Menyimpan lowongan baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'qualification' => 'required|string',
            'description' => 'required|string',
            'deadline' => 'nullable|date',
            'status' => 'required|in:Aktif,Nonaktif',
            'job_type' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
        ]);

        Job::create($request->all());

        return redirect()->route('admin.jobs.index')->with('success', 'Lowongan pekerjaan berhasil ditambahkan!');
    }

    // Menampilkan form edit data lowongan
    public function edit($id)
    {
        $job = Job::findOrFail($id);

        return view('admin.jobs.edit', compact('job'));
    }

    // Menyimpan perubahan data lowongan pekerjaan
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'qualification' => 'required|string',
            'description' => 'required|string',
            'deadline' => 'nullable|date',
            'status' => 'required|in:Aktif,Nonaktif',
            'job_type' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
        ]);

        $job = Job::findOrFail($id);
        $job->update($request->all());

        return redirect()->route('admin.jobs.index')->with('success', 'Data lowongan pekerjaan berhasil diperbarui!');
    }

    // Menghapus data lowongan pekerjaan dari database
    public function destroy($id)
    {
        $job = Job::findOrFail($id);
        $job->delete();

        return redirect()->route('admin.jobs.index')->with('success', 'Lowongan pekerjaan berhasil dihapus!');
    }
}
