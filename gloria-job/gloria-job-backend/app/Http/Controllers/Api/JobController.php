<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    // Mengambil daftar lowongan pekerjaan yang berstatus aktif
    public function index(Request $request)
    {
        $query = Job::with('company')->where('status', 'Aktif');

        // Filter by salary category
        if ($request->filled('salary_category')) {
            $query->where('salary_category', $request->salary_category);
        }

        // Filter by salary range (min-max)
        if ($request->filled('salary_min')) {
            $query->where(function ($q) use ($request) {
                $q->where('salary_max', '>=', $request->salary_min)
                  ->orWhereNull('salary_max');
            });
        }
        if ($request->filled('salary_max')) {
            $query->where(function ($q) use ($request) {
                $q->where('salary_min', '<=', $request->salary_max)
                  ->orWhereNull('salary_min');
            });
        }

        $jobs = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil daftar lowongan pekerjaan',
            'data' => $jobs,
        ], 200);
    }

    // Mengambil detail lowongan pekerjaan tertentu
    public function show($id)
    {
        $job = Job::with('company')->find($id);

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

    // Mengambil daftar perusahaan
    public function companies()
    {
        $companies = Company::withCount('jobs')->orderBy('name')->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil daftar perusahaan',
            'data' => $companies,
        ], 200);
    }

    // Mengambil detail perusahaan beserta lowongan aktifnya
    public function companyDetail($id)
    {
        $company = Company::with(['jobs' => function ($q) {
            $q->where('status', 'Aktif')->orderBy('created_at', 'desc');
        }])->find($id);

        if (! $company) {
            return response()->json([
                'success' => false,
                'message' => 'Perusahaan tidak ditemukan',
                'errors' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil detail perusahaan',
            'data' => $company,
        ], 200);
    }
}
