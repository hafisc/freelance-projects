@extends('layouts.app')

@section('title', 'Materi & Tugas | SI-PBM')
@section('page_title', 'Materi & Tugas Kuliah')

@section('content')
<div class="mb-8">
    <h3 class="text-xl font-extrabold text-[#1b3f75]">Materi & Tugas Kuliah Saya</h3>
    <p class="text-slate-400 text-xs mt-1">Lihat dan unduh file materi kuliah, petunjuk tugas, serta batas pengumpulan tugas untuk kelas Anda.</p>
</div>

<!-- Stats Summary -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#204a82] flex items-center justify-center text-xl shrink-0">
            <i class="bi bi-journal-text"></i>
        </div>
        <div>
            <h4 class="text-xl font-extrabold text-slate-800">{{ $kegiatans->count() }}</h4>
            <span class="text-slate-400 text-[10px] font-semibold uppercase tracking-wider">Total Kegiatan</span>
        </div>
    </div>
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center text-xl shrink-0">
            <i class="bi bi-book-half"></i>
        </div>
        <div>
            <h4 class="text-xl font-extrabold text-slate-800">{{ $kegiatans->where('jenis', 'Materi')->count() }}</h4>
            <span class="text-slate-400 text-[10px] font-semibold uppercase tracking-wider">Materi Kuliah</span>
        </div>
    </div>
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shrink-0">
            <i class="bi bi-clipboard-data-fill"></i>
        </div>
        <div>
            <h4 class="text-xl font-extrabold text-slate-800">{{ $kegiatans->where('jenis', 'Tugas')->count() }}</h4>
            <span class="text-slate-400 text-[10px] font-semibold uppercase tracking-wider">Tugas Aktif</span>
        </div>
    </div>
</div>

<!-- Table Card -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400 text-[11px] uppercase tracking-wider font-semibold">
                    <th class="py-4 px-6">Pertemuan / Kelas</th>
                    <th class="py-4 px-6">Dosen</th>
                    <th class="py-4 px-6">Jenis</th>
                    <th class="py-4 px-6">Judul / Nama Kegiatan</th>
                    <th class="py-4 px-6">Deskripsi / Petunjuk</th>
                    <th class="py-4 px-6">Unduh File</th>
                    <th class="py-4 px-6 text-right">Batas Waktu</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($kegiatans as $k)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-4 px-6 font-bold text-[#204a82]">
                            Pertemuan Ke-{{ $k->jadwalPembelajaran->pertemuan_ke }}
                            <span class="block text-slate-400 text-xs font-semibold mt-0.5">{{ $k->jadwalPembelajaran->kelas->nama_kelas }}</span>
                        </td>
                        <td class="py-4 px-6 text-slate-500 font-medium">{{ $k->jadwalPembelajaran->kelas->dosen->nama_dosen }}</td>
                        <td class="py-4 px-6">
                            @if($k->jenis === 'Materi')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-100">Materi</span>
                            @elseif($k->jenis === 'Tugas')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100">Tugas</span>
                            @elseif($k->jenis === 'Absensi')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">Absensi</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-[#204a82] border border-blue-100">Pertemuan</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 font-semibold text-slate-700">{{ $k->judul }}</td>
                        <td class="py-4 px-6 text-slate-500 font-medium max-w-[220px] truncate" title="{{ $k->deskripsi }}">{{ $k->deskripsi }}</td>
                        <td class="py-4 px-6">
                            @if($k->file_materi)
                                <a href="{{ asset($k->file_materi) }}" 
                                    class="inline-flex items-center gap-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-1.5 px-3 rounded-lg text-xs transition-all duration-150" 
                                    download>
                                    <i class="bi bi-download"></i> Unduh File
                                </a>
                            @else
                                <span class="text-slate-400 text-xs">Tidak ada lampiran</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right">
                            @if($k->jenis === 'Tugas' && $k->deadline)
                                <span class="text-red-500 font-semibold text-xs">{{ date('d-m-Y H:i', strtotime($k->deadline)) }} WIB</span>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-slate-400">
                            <div class="flex flex-col items-center gap-3">
                                <i class="bi bi-journal-x text-4xl text-slate-300"></i>
                                <span>Belum ada materi atau tugas kuliah yang diunggah oleh Dosen.</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
