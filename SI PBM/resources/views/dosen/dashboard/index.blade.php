@extends('layouts.app')

@section('title', 'Dashboard Dosen | SI-PBM')
@section('page_title', 'Dashboard Dosen')

@section('content')
<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Stat 1 -->
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
        <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl shrink-0">
            <i class="bi bi-door-open-fill"></i>
        </div>
        <div>
            <h3 class="text-2xl font-extrabold text-slate-800 leading-tight">{{ $stats['kelas'] }}</h3>
            <span class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Kelas Diampu</span>
        </div>
    </div>

    <!-- Stat 2 -->
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
        <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl shrink-0">
            <i class="bi bi-people-fill"></i>
        </div>
        <div>
            <h3 class="text-2xl font-extrabold text-slate-800 leading-tight">{{ $stats['mahasiswa'] }}</h3>
            <span class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Mahasiswa Didik</span>
        </div>
    </div>

    <!-- Stat 3 -->
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
        <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl shrink-0">
            <i class="bi bi-calendar-check-fill"></i>
        </div>
        <div>
            <h3 class="text-2xl font-extrabold text-slate-800 leading-tight">{{ $stats['jadwal_hari_ini']->count() }}</h3>
            <span class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Jadwal Hari Ini</span>
        </div>
    </div>
</div>

<!-- Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Schedule Table Card -->
    <div class="lg:col-span-2 bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
        <div class="flex items-center justify-between gap-4 mb-6">
            <div>
                <h3 class="text-xl font-extrabold text-[#1b3f75] flex items-center gap-2">
                    <i class="bi bi-calendar-event text-blue-500"></i> Jadwal Mengajar Hari Ini
                </h3>
                <p class="text-slate-400 text-xs mt-1">Daftar tatap muka perkuliahan hari ini</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-400 text-[11px] uppercase tracking-wider font-semibold">
                        <th class="py-3 px-4">Kelas</th>
                        <th class="py-3 px-4">Mata Kuliah</th>
                        <th class="py-3 px-4">Jam</th>
                        <th class="py-3 px-4">Ruangan</th>
                        <th class="py-3 px-4 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($stats['jadwal_hari_ini'] as $jadwal)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-3.5 px-4 font-bold text-[#204a82]">{{ $jadwal->kelas->kode_kelas }}</td>
                            <td class="py-3.5 px-4 text-slate-700 font-medium">{{ $jadwal->kelas->matakuliah->nama_mk }}</td>
                            <td class="py-3.5 px-4 text-slate-500">{{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }} WIB</td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/50">{{ $jadwal->ruangan }}</span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                @if($jadwal->status === 'Selesai')
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">Selesai</span>
                                @elseif($jadwal->status === 'Berlangsung')
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100 animate-pulse">Berlangsung</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-[#204a82] border border-blue-100">Terjadwal</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400">
                                <i class="bi bi-calendar-x text-3xl d-block mb-3 text-slate-300"></i>
                                Tidak ada jadwal mengajar hari ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Actions Card -->
    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm flex flex-col justify-between">
        <div>
            <h3 class="text-xl font-extrabold text-[#1b3f75] flex items-center gap-2 mb-6">
                <i class="bi bi-lightning-charge text-blue-500"></i> Aksi Cepat
            </h3>
            
            <div class="space-y-3">
                <a href="{{ route('jadwal.index') }}" 
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-xl border border-slate-150 bg-slate-50 hover:bg-slate-100 text-slate-700 hover:text-slate-900 transition-all font-medium text-sm">
                    <i class="bi bi-calendar-plus text-lg text-indigo-500"></i> Kelola Jadwal Pertemuan
                </a>
                <a href="{{ route('kegiatan.index') }}" 
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-xl border border-slate-150 bg-slate-50 hover:bg-slate-100 text-slate-700 hover:text-slate-900 transition-all font-medium text-sm">
                    <i class="bi bi-journal-text text-lg text-blue-500"></i> Upload Materi & Tugas
                </a>
                <a href="{{ route('absensi.index') }}" 
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-xl border border-slate-150 bg-slate-50 hover:bg-slate-100 text-slate-700 hover:text-slate-900 transition-all font-medium text-sm">
                    <i class="bi bi-clipboard2-check text-lg text-emerald-500"></i> Input Absensi Mahasiswa
                </a>
            </div>
        </div>
        
        <div class="text-[10px] text-slate-400 text-center mt-6">
            SI-PBM Portal &bull; Dosen
        </div>
    </div>
</div>
@endsection
