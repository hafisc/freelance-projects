@extends('admin.layouts.admin')

@section('title', 'Dashboard Utama')

@section('content')
<!-- Welcome Banner -->
<div class="mb-8">
    <div class="bg-primaryBlue text-white rounded-3xl shadow-lg shadow-primaryBlue/10 p-6 md:p-10 relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="max-w-2xl">
                <span class="inline-block bg-white/20 text-white text-xs font-semibold px-3 py-1.5 rounded-full mb-3 uppercase tracking-wider">
                    Panel Kontrol Admin
                </span>
                <h2 class="text-2xl md:text-4xl font-extrabold tracking-tight mb-2">
                    Selamat Datang Kembali, {{ Auth::guard('admin')->user()->name ?? 'Admin' }}!
                </h2>
                <p class="text-white/80 text-sm md:text-base leading-relaxed">
                    Kelola postingan lowongan kerja, tinjau lamaran masuk, dan pantau statistik penerimaan kandidat untuk PT. Gloria Jasa Mandiri di sini.
                </p>
            </div>
            <div class="hidden md:block">
                <i class="fa-solid fa-circle-user text-8xl text-white/10"></i>
            </div>
        </div>
    </div>
</div>

<!-- Statistik Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Card 1: Total Lowongan -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center justify-between hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
        <div>
            <span class="text-slate-400 text-xs font-semibold uppercase tracking-wider block mb-1">Total Lowongan</span>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $totalJobs }}</h2>
        </div>
        <div class="w-12 h-12 rounded-full bg-blue-50 text-primaryBlue flex items-center justify-center">
            <i class="fa-solid fa-briefcase text-lg"></i>
        </div>
    </div>
    
    <!-- Card 2: Total Lamaran -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center justify-between hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
        <div>
            <span class="text-slate-400 text-xs font-semibold uppercase tracking-wider block mb-1">Total Lamaran</span>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $totalApplications }}</h2>
        </div>
        <div class="w-12 h-12 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center">
            <i class="fa-solid fa-file-invoice text-lg"></i>
        </div>
    </div>
    
    <!-- Card 3: Lamaran Menunggu -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center justify-between hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
        <div>
            <span class="text-slate-400 text-xs font-semibold uppercase tracking-wider block mb-1">Lamaran Menunggu</span>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $pendingApplications }}</h2>
        </div>
        <div class="w-12 h-12 rounded-full bg-amber-50 text-warning flex items-center justify-center">
            <i class="fa-regular fa-clock text-lg"></i>
        </div>
    </div>
    
    <!-- Card 4: Diterima -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center justify-between hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
        <div>
            <span class="text-slate-400 text-xs font-semibold uppercase tracking-wider block mb-1">Diterima</span>
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $acceptedApplications }}</h2>
        </div>
        <div class="w-12 h-12 rounded-full bg-emerald-50 text-success flex items-center justify-center">
            <i class="fa-solid fa-circle-check text-lg"></i>
        </div>
    </div>
</div>

<!-- Recent Applications Table -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
            <i class="fa-solid fa-clock-rotate-left text-primaryBlue"></i> 5 Lamaran Masuk Terbaru
        </h3>
        <a href="{{ route('admin.applications.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-50 hover:bg-slate-100 text-slate-600 hover:text-slate-900 rounded-xl text-xs font-semibold transition-all duration-150">
            Lihat Semua <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>
    
    <div class="overflow-x-auto w-full">
        <table class="min-w-full divide-y divide-slate-100 text-left">
            <thead class="bg-slate-50">
                <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                    <th class="px-6 py-4">PELAMAR</th>
                    <th class="px-6 py-4">POSISI LOWONGAN</th>
                    <th class="px-6 py-4">NO. HP</th>
                    <th class="px-6 py-4">TANGGAL MELAMAR</th>
                    <th class="px-6 py-4">STATUS</th>
                    <th class="px-6 py-4 text-center">AKSI</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse($recentApplications as $app)
                    <tr class="hover:bg-slate-50/50 transition-colors duration-150 text-sm">
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800">{{ $app->full_name }}</div>
                            <div class="text-xs text-slate-400">{{ $app->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-primaryBlue">{{ $app->job->title ?? 'Posisi Terhapus' }}</div>
                            <div class="text-xs text-slate-400">{{ $app->job->company_name ?? '' }}</div>
                        </td>
                        <td class="px-6 py-4 text-slate-500 font-medium">{{ $app->phone }}</td>
                        <td class="px-6 py-4 text-slate-400">{{ $app->created_at->format('d M Y, H:i') }} WIB</td>
                        <td class="px-6 py-4">
                            @if($app->status == 'Menunggu')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-slate-50 text-slate-600 border border-slate-200">
                                    <i class="fa-regular fa-clock"></i> Menunggu
                                </span>
                            @elseif($app->status == 'Diproses')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-primaryBlue border border-blue-100">
                                    <i class="fa-solid fa-circle-notch fa-spin"></i> Diproses
                                </span>
                            @elseif($app->status == 'Diterima')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-success border border-emerald-100">
                                    <i class="fa-solid fa-circle-check"></i> Diterima
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-danger border border-rose-100">
                                    <i class="fa-solid fa-circle-xmark"></i> Ditolak
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.applications.show', $app->id) }}" class="inline-flex items-center gap-1 px-4 py-2 bg-slate-50 hover:bg-slate-100 text-slate-600 hover:text-slate-900 rounded-lg text-xs font-bold transition-all duration-150">
                                <i class="fa-regular fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                            <i class="fa-regular fa-folder-open text-4xl mb-3 block text-slate-300"></i>
                            <span class="font-medium text-sm">Belum ada lamaran masuk terbaru.</span>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
