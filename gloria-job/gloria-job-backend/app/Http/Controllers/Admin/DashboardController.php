<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
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
        $totalCompanies = Company::count();
        $rejectedApplications = JobApplication::where('status', 'Ditolak')->count();
        $processedApplications = JobApplication::where('status', 'Diproses')->count();

        // Mengambil 5 lamaran masuk terbaru
        $recentApplications = JobApplication::with(['job.company'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Data untuk chart: lamaran per bulan (6 bulan terakhir)
        $monthlyLabels = [];
        $monthlyCounts = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyLabels[] = $date->format('M Y');
            $monthlyCounts[] = JobApplication::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        // Data chart: distribusi per kategori
        $categoryLabels = [];
        $categoryCounts = [];
        $categoryJobs = Job::with('applications')->whereNotNull('category')->get()->groupBy('category');
        foreach ($categoryJobs as $cat => $jobs) {
            $categoryLabels[] = $cat;
            $categoryCounts[] = $jobs->sum(fn($j) => $j->applications->count());
        }

        return view('admin.dashboard.index', compact(
            'totalJobs',
            'totalApplications',
            'pendingApplications',
            'acceptedApplications',
            'totalCompanies',
            'rejectedApplications',
            'processedApplications',
            'recentApplications',
            'monthlyLabels',
            'monthlyCounts',
            'categoryLabels',
            'categoryCounts'
        ));
    }
}
