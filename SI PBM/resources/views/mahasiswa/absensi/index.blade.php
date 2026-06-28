@extends('layouts.app')

@section('title', 'Absensi Saya | SI-PBM')
@section('page_title', 'Riwayat Presensi Kehadiran')

@section('content')
<div class="mb-8">
    <h3 class="text-xl font-extrabold text-[#1b3f75]">Rekap Kehadiran Kuliah</h3>
    <p class="text-slate-400 text-xs mt-1">Daftar rekap riwayat kehadiran presensi kelas perkuliahan Anda pada semester ini.</p>
</div>

<!-- Stats Summary -->
<div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-8">
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#204a82] flex items-center justify-center text-xl shrink-0">
            <i class="bi bi-clock-history"></i>
        </div>
        <div>
            <h4 class="text-xl font-extrabold text-slate-800">{{ $absensi->count() }}</h4>
            <span class="text-slate-400 text-[10px] font-semibold uppercase tracking-wider">Total Presensi</span>
        </div>
    </div>
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0">
            <i class="bi bi-check-circle-fill"></i>
        </div>
        <div>
            <h4 class="text-xl font-extrabold text-slate-800">{{ $absensi->where('status', 'Hadir')->count() }}</h4>
            <span class="text-slate-400 text-[10px] font-semibold uppercase tracking-wider">Hadir</span>
        </div>
    </div>
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shrink-0">
            <i class="bi bi-info-circle-fill"></i>
        </div>
        <div>
            <h4 class="text-xl font-extrabold text-slate-800">{{ $absensi->whereIn('status', ['Izin', 'Sakit'])->count() }}</h4>
            <span class="text-slate-400 text-[10px] font-semibold uppercase tracking-wider">Izin / Sakit</span>
        </div>
    </div>
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl shrink-0">
            <i class="bi bi-x-circle-fill"></i>
        </div>
        <div>
            <h4 class="text-xl font-extrabold text-slate-800">{{ $absensi->where('status', 'Alpha')->count() }}</h4>
            <span class="text-slate-400 text-[10px] font-semibold uppercase tracking-wider">Alpha (Alpa)</span>
        </div>
    </div>
</div>

<!-- Table Card -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400 text-[11px] uppercase tracking-wider font-semibold">
                    <th class="py-4 px-6">Kelas</th>
                    <th class="py-4 px-6">Mata Kuliah</th>
                    <th class="py-4 px-6">Dosen Pengampu</th>
                    <th class="py-4 px-6">Pertemuan Ke</th>
                    <th class="py-4 px-6">Tanggal</th>
                    <th class="py-4 px-6">Status Absen</th>
                    <th class="py-4 px-6 text-right">Keterangan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($absensi as $absen)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-4 px-6 font-bold text-[#204a82]">{{ $absen->jadwalPembelajaran->kelas->kode_kelas }}</td>
                        <td class="py-4 px-6 font-semibold text-slate-700">{{ $absen->jadwalPembelajaran->kelas->matakuliah->nama_mk }}</td>
                        <td class="py-4 px-6 text-slate-500 font-medium">{{ $absen->jadwalPembelajaran->kelas->dosen->nama_dosen }}</td>
                        <td class="py-4 px-6 text-slate-700 font-bold">Ke-{{ $absen->jadwalPembelajaran->pertemuan_ke }}</td>
                        <td class="py-4 px-6 text-slate-500">{{ date('d-m-Y', strtotime($absen->jadwalPembelajaran->tanggal)) }}</td>
                        <td class="py-4 px-6">
                            @if($absen->status === 'Hadir')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">Hadir</span>
                            @elseif($absen->status === 'Izin')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100">Izin</span>
                            @elseif($absen->status === 'Sakit')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">Sakit</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-100">Alpha</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-slate-500 font-medium text-right">{{ $absen->keterangan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-slate-400">
                            <div class="flex flex-col items-center gap-3">
                                <i class="bi bi-clock-history text-4xl text-slate-300"></i>
                                <span>Riwayat presensi kehadiran kuliah belum tercatat.</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
