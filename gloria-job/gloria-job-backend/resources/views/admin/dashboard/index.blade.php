@extends('admin.layouts.admin')

@section('title', 'Dashboard Utama')

@section('content')
<!-- Welcome Banner -->
<div class="mb-5">
    <div class="bg-primaryBlue text-white rounded-2xl shadow-lg shadow-primaryBlue/10 p-5 md:p-6 relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="max-w-2xl">
                <h2 class="text-xl md:text-2xl font-extrabold tracking-tight mb-1">
                    Selamat Datang Kembali, {{ Auth::guard('admin')->user()->name ?? 'Admin' }}!
                </h2>
                <p class="text-white/80 text-xs md:text-sm leading-relaxed">
                    Kelola postingan lowongan kerja, tinjau lamaran masuk, dan pantau statistik penerimaan kandidat untuk PT. Gloria Jasa Mandiri di sini.
                </p>
            </div>
            <div class="hidden md:block">
                <i class="fa-solid fa-circle-user text-6xl text-white/10"></i>
            </div>
        </div>
    </div>
</div>

<!-- Statistik Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 mb-5">
    <!-- Card 1: Total Lowongan -->
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
        <div>
            <span class="text-slate-400 text-[10px] font-semibold uppercase tracking-wider block mb-1">Total Lowongan</span>
            <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">{{ $totalJobs }}</h2>
        </div>
        <div class="w-10 h-10 rounded-full bg-blue-50 text-primaryBlue flex items-center justify-center">
            <i class="fa-solid fa-briefcase"></i>
        </div>
    </div>
    <!-- Card 2: Perusahaan -->
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
        <div>
            <span class="text-slate-400 text-[10px] font-semibold uppercase tracking-wider block mb-1">Perusahaan</span>
            <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">{{ $totalCompanies }}</h2>
        </div>
        <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center">
            <i class="fa-solid fa-building"></i>
        </div>
    </div>
    <!-- Card 3: Total Lamaran -->
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
        <div>
            <span class="text-slate-400 text-[10px] font-semibold uppercase tracking-wider block mb-1">Total Lamaran</span>
            <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">{{ $totalApplications }}</h2>
        </div>
        <div class="w-10 h-10 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center">
            <i class="fa-solid fa-file-invoice"></i>
        </div>
    </div>
    <!-- Card 4: Menunggu -->
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
        <div>
            <span class="text-slate-400 text-[10px] font-semibold uppercase tracking-wider block mb-1">Menunggu</span>
            <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">{{ $pendingApplications }}</h2>
        </div>
        <div class="w-10 h-10 rounded-full bg-amber-50 text-warning flex items-center justify-center">
            <i class="fa-regular fa-clock"></i>
        </div>
    </div>
    <!-- Card 5: Diterima -->
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
        <div>
            <span class="text-slate-400 text-[10px] font-semibold uppercase tracking-wider block mb-1">Diterima</span>
            <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">{{ $acceptedApplications }}</h2>
        </div>
        <div class="w-10 h-10 rounded-full bg-emerald-50 text-success flex items-center justify-center">
            <i class="fa-solid fa-circle-check"></i>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-5">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4">
        <h4 class="text-xs font-bold text-slate-700 mb-3 flex items-center gap-2"><i class="fa-solid fa-chart-bar text-primaryBlue"></i> Tren Lamaran (6 Bulan Terakhir)</h4>
        <div class="relative w-full h-48">
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4">
        <h4 class="text-xs font-bold text-slate-700 mb-3 flex items-center gap-2"><i class="fa-solid fa-chart-pie text-primaryBlue"></i> Distribusi per Kategori</h4>
        <div class="relative w-full h-48 flex justify-center">
            <canvas id="categoryChart"></canvas>
        </div>
    </div>
</div>

<!-- Recent Applications Table -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-4">
    <div class="p-4 border-b border-slate-100 flex items-center justify-between">
        <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
            <i class="fa-solid fa-clock-rotate-left text-primaryBlue"></i> 5 Lamaran Masuk Terbaru
        </h3>
        <a href="{{ route('admin.applications.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-50 hover:bg-slate-100 text-slate-600 hover:text-slate-900 rounded-lg text-[11px] font-semibold transition-all duration-150 border border-slate-100">
            Lihat Semua <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>
    
    <div class="overflow-x-auto w-full">
        <table class="min-w-full divide-y divide-slate-100 text-left">
            <thead class="bg-slate-50">
                <tr class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                    <th class="px-4 py-3">PELAMAR</th>
                    <th class="px-4 py-3">POSISI LOWONGAN</th>
                    <th class="px-4 py-3">NO. HP</th>
                    <th class="px-4 py-3">TANGGAL MELAMAR</th>
                    <th class="px-4 py-3">STATUS</th>
                    <th class="px-4 py-3 text-center">AKSI</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse($recentApplications as $app)
                    <tr class="hover:bg-slate-50/50 transition-colors duration-150 text-[13px]">
                        <td class="px-4 py-3">
                            <div class="font-bold text-slate-800">{{ $app->full_name }}</div>
                            <div class="text-[11px] text-slate-400">{{ $app->email }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-semibold text-primaryBlue">{{ $app->job->title ?? 'Posisi Terhapus' }}</div>
                            <div class="text-[11px] text-slate-400">{{ $app->job->company_display_name ?? '' }}</div>
                        </td>
                        <td class="px-4 py-3 text-slate-500 font-medium">{{ $app->phone }}</td>
                        <td class="px-4 py-3 text-slate-400">{{ $app->created_at->format('d M Y, H:i') }} WIB</td>
                        <td class="px-4 py-3">
                            @if($app->status == 'Menunggu')
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-slate-50 text-slate-600 border border-slate-200">
                                    <i class="fa-regular fa-clock"></i> Menunggu
                                </span>
                            @elseif($app->status == 'Diproses')
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-blue-50 text-primaryBlue border border-blue-100">
                                    <i class="fa-solid fa-circle-notch fa-spin"></i> Diproses
                                </span>
                            @elseif($app->status == 'Diterima')
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-success border border-emerald-100">
                                    <i class="fa-solid fa-circle-check"></i> Diterima
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-rose-50 text-danger border border-rose-100">
                                    <i class="fa-solid fa-circle-xmark"></i> Ditolak
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('admin.applications.show', $app->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-50 hover:bg-slate-100 text-slate-600 hover:text-slate-900 rounded-md text-[11px] font-bold transition-all duration-150 border border-slate-100">
                                <i class="fa-regular fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-slate-400">
                            <i class="fa-regular fa-folder-open text-3xl mb-2 block text-slate-300"></i>
                            <span class="font-medium text-xs">Belum ada lamaran masuk terbaru.</span>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Monthly Chart
    new Chart(document.getElementById('monthlyChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($monthlyLabels) !!},
            datasets: [{
                label: 'Lamaran',
                data: {!! json_encode($monthlyCounts) !!},
                backgroundColor: 'rgba(37, 99, 235, 0.7)',
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });

    // Category Chart
    new Chart(document.getElementById('categoryChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($categoryLabels) !!},
            datasets: [{
                data: {!! json_encode($categoryCounts) !!},
                backgroundColor: ['#2563eb','#10b981','#f59e0b','#ef4444','#8b5cf6','#06b6d4'],
                borderWidth: 0,
                spacing: 2,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: { position: 'right', labels: { padding: 10, usePointStyle: true, pointStyle: 'circle', font: { size: 10 } } }
            }
        }
    });
</script>
@endsection
