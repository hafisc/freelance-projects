<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobApplication;

class DashboardController extends Controller
{
    // Menampilkan halaman dashboard utama admin beserta statistik ringkas
    public function index()
    {
        $totalJobs = Job::count();
        $totalApplications = JobApplication::count();
        $pendingApplications = JobApplication::where('status', 'Menunggu')->count();
        $acceptedApplications = JobApplication::where('status', 'Diterima')->count();

        // Mengambil 5 lamaran masuk terbaru
        $recentApplications = JobApplication::with('job')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard.index', compact(
            'totalJobs',
            'totalApplications',
            'pendingApplications',
            'acceptedApplications',
            'recentApplications'
        ));
    }
}
