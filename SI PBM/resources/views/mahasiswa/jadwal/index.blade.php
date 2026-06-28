@extends('layouts.app')

@section('title', 'Jadwal Kuliah | SI-PBM')
@section('page_title', 'Jadwal Perkuliahan Saya')

@section('content')
<div class="mb-8">
    <h3 class="text-xl font-extrabold text-[#1b3f75]">Agenda Kelas & Jadwal Kuliah</h3>
    <p class="text-slate-400 text-xs mt-1">Daftar jadwal perkuliahan lengkap untuk kelas-kelas yang Anda ikuti pada semester ini.</p>
</div>

<!-- Stats Summary -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#204a82] flex items-center justify-center text-xl shrink-0">
            <i class="bi bi-book-half"></i>
        </div>
        <div>
            <h4 class="text-xl font-extrabold text-slate-800">{{ $jadwals->unique('kelas_id')->count() }}</h4>
            <span class="text-slate-400 text-[10px] font-semibold uppercase tracking-wider">Kelas Diikuti</span>
        </div>
    </div>
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl shrink-0">
            <i class="bi bi-calendar3"></i>
        </div>
        <div>
            <h4 class="text-xl font-extrabold text-slate-800">{{ $jadwals->count() }}</h4>
            <span class="text-slate-400 text-[10px] font-semibold uppercase tracking-wider">Total Pertemuan</span>
        </div>
    </div>
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0">
            <i class="bi bi-check-circle-fill"></i>
        </div>
        <div>
            <h4 class="text-xl font-extrabold text-slate-800">{{ $jadwals->where('status', 'Selesai')->count() }}</h4>
            <span class="text-slate-400 text-[10px] font-semibold uppercase tracking-wider">Selesai Terlaksana</span>
        </div>
    </div>
</div>

<!-- Table Card -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400 text-[11px] uppercase tracking-wider font-semibold">
                    <th class="py-4 px-6">Kelas / MK</th>
                    <th class="py-4 px-6">Dosen Pengampu</th>
                    <th class="py-4 px-6">Pertemuan</th>
                    <th class="py-4 px-6">Tanggal</th>
                    <th class="py-4 px-6">Waktu / Jam</th>
                    <th class="py-4 px-6">Ruangan</th>
                    <th class="py-4 px-6">Topik / Bahasan</th>
                    <th class="py-4 px-6 text-right">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($jadwals as $j)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-4 px-6 font-bold text-[#204a82]">
                            {{ $j->kelas->kode_kelas }}
                            <span class="block text-slate-400 text-xs font-semibold mt-0.5">{{ $j->kelas->matakuliah->nama_mk }}</span>
                        </td>
                        <td class="py-4 px-6 text-slate-600 font-medium">{{ $j->kelas->dosen->nama_dosen }}</td>
                        <td class="py-4 px-6 font-bold text-slate-700">Ke-{{ $j->pertemuan_ke }}</td>
                        <td class="py-4 px-6 text-slate-500 font-medium">{{ date('d-m-Y', strtotime($j->tanggal)) }}</td>
                        <td class="py-4 px-6 text-slate-500">{{ substr($j->jam_mulai, 0, 5) }} - {{ substr($j->jam_selesai, 0, 5) }} WIB</td>
                        <td class="py-4 px-6">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/50">{{ $j->ruangan }}</span>
                        </td>
                        <td class="py-4 px-6 text-slate-500 font-medium max-w-[200px] truncate" title="{{ $j->topik_materi }}">{{ $j->topik_materi ?? 'Belum ditentukan' }}</td>
                        <td class="py-4 px-6 text-right">
                            @if($j->status === 'Selesai')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">Selesai</span>
                            @elseif($j->status === 'Berlangsung')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100 animate-pulse">Berlangsung</span>
                            @elseif($j->status === 'Dibatalkan')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-100">Dibatalkan</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-[#204a82] border border-blue-100">Terjadwal</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="py-12 text-center text-slate-400">
                            <div class="flex flex-col items-center gap-3">
                                <i class="bi bi-calendar-x text-4xl text-slate-300"></i>
                                <span>Belum ada jadwal perkuliahan terdaftar untuk kelas Anda.</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
