@extends('layouts.app')

@section('title', 'Dashboard Admin | SI-PBM')
@section('page_title', 'Dashboard Admin')

@section('content')
<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stat 1 -->
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
        <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl shrink-0">
            <i class="bi bi-people-fill"></i>
        </div>
        <div>
            <h3 class="text-2xl font-extrabold text-slate-800 leading-tight">{{ $stats['users'] }}</h3>
            <span class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Total Pengguna</span>
        </div>
    </div>

    <!-- Stat 2 -->
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
        <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl shrink-0">
            <i class="bi bi-mortarboard-fill"></i>
        </div>
        <div>
            <h3 class="text-2xl font-extrabold text-slate-800 leading-tight">{{ $stats['mahasiswa'] }}</h3>
            <span class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Mahasiswa Aktif</span>
        </div>
    </div>

    <!-- Stat 3 -->
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl shrink-0">
            <i class="bi bi-person-badge-fill"></i>
        </div>
        <div>
            <h3 class="text-2xl font-extrabold text-slate-800 leading-tight">{{ $stats['dosen'] }}</h3>
            <span class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Dosen Pendidik</span>
        </div>
    </div>

    <!-- Stat 4 -->
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
        <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl shrink-0">
            <i class="bi bi-door-open-fill"></i>
        </div>
        <div>
            <h3 class="text-2xl font-extrabold text-slate-800 leading-tight">{{ $stats['kelas'] }}</h3>
            <span class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Total Kelas</span>
        </div>
    </div>
</div>

<!-- Details Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Welcome Card -->
    <div class="lg:col-span-2 bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-6">
            <div>
                <h3 class="text-xl font-extrabold text-[#1b3f75] flex items-center gap-2">
                    <i class="bi bi-shield-check text-blue-500"></i> Sistem Operasional Akademik
                </h3>
                <p class="text-slate-400 text-xs mt-1">Status Keamanan & Hak Akses Tertinggi</p>
            </div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-[#204a82] border border-blue-100">
                <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span> Super Admin
            </span>
        </div>

        <div class="space-y-4 text-slate-600 text-sm leading-relaxed">
            <p>Selamat datang di <strong>Sistem Informasi Manajemen Kegiatan Proses Belajar Mengajar (SI-PBM)</strong>.</p>
            <p>Anda masuk sebagai <strong>Super Admin</strong>. Anda memiliki kendali penuh atas konfigurasi sistem, termasuk manajemen otentikasi pengguna, pembatasan hak akses, data master mahasiswa, dosen, mata kuliah, pengisian KRS, kelas, dan penjadwalan proses belajar mengajar.</p>
        </div>

        <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ route('users.index') }}" 
                class="flex items-center gap-2 bg-[#204a82] hover:bg-[#193f72] text-white font-semibold py-2.5 px-5 rounded-xl shadow-md transition-all duration-200 text-sm">
                <i class="bi bi-people"></i> Kelola User
            </a>
            <a href="{{ route('jadwal.index') }}" 
                class="flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-2.5 px-5 rounded-xl transition-all duration-200 text-sm">
                <i class="bi bi-calendar-event"></i> Jadwal Kuliah
            </a>
        </div>
    </div>

    <!-- Side Status Card -->
    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm flex flex-col justify-between">
        <div>
            <h3 class="text-xl font-extrabold text-[#1b3f75] flex items-center gap-2 mb-6">
                <i class="bi bi-cpu text-blue-500"></i> Status Server
            </h3>
            
            <ul class="space-y-4">
                <li class="flex justify-between items-center py-2.5 border-b border-slate-100">
                    <span class="text-slate-500 text-xs font-semibold">Database Engine</span>
                    <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">MySQL</span>
                </li>
                <li class="flex justify-between items-center py-2.5 border-b border-slate-100">
                    <span class="text-slate-500 text-xs font-semibold">Jadwal Hari Ini</span>
                    <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-blue-50 text-[#204a82] border border-blue-100">{{ $stats['jadwal_hari_ini'] }} Kelas</span>
                </li>
                <li class="flex justify-between items-center py-2.5">
                    <span class="text-slate-500 text-xs font-semibold">Status Sistem</span>
                    <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">Normal</span>
                </li>
            </ul>
        </div>
        
        <div class="text-[10px] text-slate-400 text-center mt-6">
            Last Checked: {{ date('d M Y H:i:s') }}
        </div>
    </div>
</div>
@endsection
