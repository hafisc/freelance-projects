@extends('layouts.app')

@section('title', 'Kegiatan PBM | SI-PBM')
@section('page_title', 'Kegiatan Belajar Mengajar (Materi & Tugas)')

@section('content')
<div class="mb-8">
    <h3 class="text-xl font-extrabold text-[#1b3f75]">Katalog Materi &amp; Tugas</h3>
    <p class="text-slate-400 text-xs mt-1">Daftar unggahan file materi kuliah, tugas, absensi, serta referensi kegiatan proses belajar (Operator Read-Only).</p>
</div>

<!-- Table Card -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400 text-[11px] uppercase tracking-wider font-semibold">
                    <th class="py-4 px-6">Pertemuan / Kelas</th>
                    <th class="py-4 px-6">Jenis Kegiatan</th>
                    <th class="py-4 px-6">Judul Kegiatan</th>
                    <th class="py-4 px-6">Deskripsi</th>
                    <th class="py-4 px-6">File / Lampiran</th>
                    <th class="py-4 px-6 text-right">Batas Pengumpulan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($kegiatans as $k)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-4 px-6 font-bold text-[#204a82]">
                            Pertemuan Ke-{{ $k->jadwalPembelajaran->pertemuan_ke }}
                            <span class="block text-slate-400 text-xs font-semibold mt-0.5">{{ $k->jadwalPembelajaran->kelas->nama_kelas }}</span>
                        </td>
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
                        <td class="py-4 px-6 text-slate-500 font-medium max-w-[250px] truncate" title="{{ $k->deskripsi }}">{{ $k->deskripsi }}</td>
                        <td class="py-4 px-6">
                            @if($k->file_materi)
                                <a href="{{ asset($k->file_materi) }}" 
                                    class="inline-flex items-center gap-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-1.5 px-3 rounded-lg text-xs transition-all duration-150" 
                                    download>
                                    <i class="bi bi-download"></i> Unduh File
                                </a>
                            @else
                                <span class="text-slate-400 text-xs">Tidak ada file</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-slate-500 text-right">
                            @if($k->jenis === 'Tugas' && $k->deadline)
                                <span class="text-red-500 font-semibold text-xs">{{ date('d-m-Y H:i', strtotime($k->deadline)) }} WIB</span>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-400">
                            <i class="bi bi-file-earmark-text text-3xl d-block mb-3 text-slate-300"></i>
                            Kegiatan belajar mengajar belum ditambahkan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
