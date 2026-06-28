@extends('layouts.app')

@section('title', 'Portal Mahasiswa | SI-PBM')
@section('page_title', 'Portal Akademik Mahasiswa')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left Column (Schedules and Tasks) -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Today's Schedule Card -->
        <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
            <h3 class="text-xl font-extrabold text-[#1b3f75] flex items-center gap-2 mb-6">
                <i class="bi bi-calendar3 text-blue-500"></i> Jadwal Kuliah Hari Ini
            </h3>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-slate-400 text-[11px] uppercase tracking-wider font-semibold">
                            <th class="py-3 px-4">Kelas</th>
                            <th class="py-3 px-4">Mata Kuliah</th>
                            <th class="py-3 px-4">Dosen</th>
                            <th class="py-3 px-4">Jam</th>
                            <th class="py-3 px-4 text-right">Ruangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($stats['jadwal_hari_ini'] as $jadwal)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-3.5 px-4 font-bold text-[#204a82]">{{ $jadwal->kelas->kode_kelas }}</td>
                                <td class="py-3.5 px-4 text-slate-700 font-medium">{{ $jadwal->kelas->matakuliah->nama_mk }}</td>
                                <td class="py-3.5 px-4 text-slate-500">{{ $jadwal->kelas->dosen->nama_dosen }}</td>
                                <td class="py-3.5 px-4 text-slate-500">{{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }} WIB</td>
                                <td class="py-3.5 px-4 text-right">
                                    <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/50">{{ $jadwal->ruangan }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-slate-400">
                                    <i class="bi bi-calendar-x text-3xl d-block mb-3 text-slate-300"></i>
                                    Tidak ada jadwal kuliah hari ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pending Tasks Card -->
        <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
            <h3 class="text-xl font-extrabold text-[#1b3f75] flex items-center gap-2 mb-6">
                <i class="bi bi-clipboard-pulse text-amber-500"></i> Tugas Aktif &amp; Deadline
            </h3>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-slate-400 text-[11px] uppercase tracking-wider font-semibold">
                            <th class="py-3 px-4">Nama Tugas</th>
                            <th class="py-3 px-4">Tanggal Pertemuan</th>
                            <th class="py-3 px-4">Batas Pengumpulan</th>
                            <th class="py-3 px-4 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($stats['tugas_pending'] as $tugas)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-3.5 px-4 font-bold text-slate-700">{{ $tugas->judul }}</td>
                                <td class="py-3.5 px-4 text-slate-500">{{ $tugas->tanggal }}</td>
                                <td class="py-3.5 px-4 text-red-500 font-semibold">{{ date('d M Y, H:i', strtotime($tugas->deadline)) }} WIB</td>
                                <td class="py-3.5 px-4 text-right">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100 animate-pulse">Belum Dikumpul</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-slate-400">
                                    <i class="bi bi-clipboard-check text-3xl d-block mb-3 text-slate-300"></i>
                                    Tidak ada tugas aktif atau deadline dekat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Column (Profile and Quick Links) -->
    <div class="space-y-8">
        <!-- Profile Widget -->
        <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm text-center">
            <div class="w-20 h-20 rounded-full bg-blue-50 text-[#204a82] border-2 border-blue-100 flex items-center justify-center font-extrabold text-3xl mx-auto mb-4">
                {{ strtoupper(substr(session('nama', 'U'), 0, 1)) }}
            </div>
            <h4 class="font-extrabold text-slate-800 text-lg leading-tight">{{ session('nama') }}</h4>
            <p class="text-slate-400 text-xs mt-1">NIM: {{ session('nim') }}</p>
            
            <div class="my-6 border-t border-slate-100"></div>
            
            <div class="flex items-center justify-between text-left">
                <div>
                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Status Akademik</p>
                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-600 mt-1">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Mahasiswa Aktif
                    </span>
                </div>
            </div>
        </div>

        <!-- Quick Access Card -->
        <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm flex flex-col justify-between">
            <div>
                <h3 class="text-xl font-extrabold text-[#1b3f75] flex items-center gap-2 mb-6">
                    <i class="bi bi-link-45deg text-blue-500"></i> Akses Cepat
                </h3>
                
                <div class="space-y-3">
                    <a href="{{ route('jadwal.index') }}" 
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl border border-slate-150 bg-slate-50 hover:bg-slate-100 text-slate-700 hover:text-slate-900 transition-all font-medium text-sm">
                        <i class="bi bi-calendar3 text-lg text-[#204a82]"></i> Jadwal Kuliah Lengkap
                    </a>
                    <a href="{{ route('kegiatan.index') }}" 
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl border border-slate-150 bg-slate-50 hover:bg-slate-100 text-slate-700 hover:text-slate-900 transition-all font-medium text-sm">
                        <i class="bi bi-journal-bookmark-fill text-lg text-amber-500"></i> Materi &amp; Tugas Kuliah
                    </a>
                    <a href="{{ route('absensi.index') }}" 
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl border border-slate-150 bg-slate-50 hover:bg-slate-100 text-slate-700 hover:text-slate-900 transition-all font-medium text-sm">
                        <i class="bi bi-clock-history text-lg text-emerald-500"></i> Riwayat Kehadiran Saya
                    </a>
                </div>
            </div>
            
            <div class="text-[10px] text-slate-400 text-center mt-6">
                SI-PBM Portal &bull; Mahasiswa
            </div>
        </div>
    </div>
</div>
@endsection
