<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Job;
use Illuminate\Http\Request;

class JobManagementController extends Controller
{
    // Menampilkan daftar lowongan pekerjaan
    public function index()
    {
        $jobs = Job::with('company')->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.jobs.index', compact('jobs'));
    }

    // Menampilkan form tambah lowongan baru
    public function create()
    {
        $companies = Company::orderBy('name')->get();

        return view('admin.jobs.create', compact('companies'));
    }

    // Menyimpan lowongan baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'company_id' => 'nullable|exists:companies,id',
            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'qualification' => 'required|string',
            'description' => 'required|string',
            'deadline' => 'nullable|date',
            'status' => 'required|in:Aktif,Nonaktif',
            'job_type' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0',
            'salary_category' => 'nullable|string|max:255',
        ]);

        // Jika company_id dipilih, gunakan nama perusahaan dari database
        $data = $request->all();
        if ($request->company_id) {
            $company = Company::find($request->company_id);
            if ($company) {
                $data['company_name'] = $company->name;
            }
        }

        Job::create($data);

        return redirect()->route('admin.jobs.index')->with('success', 'Lowongan pekerjaan berhasil ditambahkan!');
    }

    // Menampilkan form edit data lowongan
    public function edit($id)
    {
        $job = Job::findOrFail($id);
        $companies = Company::orderBy('name')->get();

        return view('admin.jobs.edit', compact('job', 'companies'));
    }

    // Menyimpan perubahan data lowongan pekerjaan
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'company_id' => 'nullable|exists:companies,id',
            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'qualification' => 'required|string',
            'description' => 'required|string',
            'deadline' => 'nullable|date',
            'status' => 'required|in:Aktif,Nonaktif',
            'job_type' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0',
            'salary_category' => 'nullable|string|max:255',
        ]);

        $job = Job::findOrFail($id);
        $data = $request->all();

        if ($request->company_id) {
            $company = Company::find($request->company_id);
            if ($company) {
                $data['company_name'] = $company->name;
            }
        }

        $job->update($data);

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
