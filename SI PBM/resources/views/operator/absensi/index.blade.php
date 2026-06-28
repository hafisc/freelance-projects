@extends('layouts.app')

@section('title', 'Absensi Mahasiswa | SI-PBM')
@section('page_title', 'Kehadiran Mahasiswa')

@section('content')
<div class="mb-8">
    <h3 class="text-xl font-extrabold text-[#1b3f75]">Laporan Presensi Kelas</h3>
    <p class="text-slate-400 text-xs mt-1">Pilih pertemuan kelas untuk memantau rekap presensi daftar hadir mahasiswa (Operator View).</p>
</div>

<!-- Filter Card -->
<div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm mb-8">
    <form action="{{ route('absensi.index') }}" method="GET" class="flex flex-col md:flex-row items-end gap-4">
        <div class="flex-1 w-full">
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pilih Pertemuan Kuliah</label>
            <select name="jadwal_id" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                <option value="">-- Pilih Pertemuan --</option>
                @foreach($jadwals as $j)
                    <option value="{{ $j->id }}" {{ request('jadwal_id') == $j->id ? 'selected' : '' }}>
                        {{ $j->kelas->kode_kelas }} - {{ $j->kelas->matakuliah->nama_mk }} (Pertemuan {{ $j->pertemuan_ke }} | {{ date('d M Y', strtotime($j->tanggal)) }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="w-full md:w-auto">
            <button type="submit" 
                class="w-full flex items-center justify-center gap-2 bg-[#204a82] hover:bg-[#193f72] text-white font-semibold py-2.5 px-6 rounded-xl shadow-md transition-all duration-200 text-sm h-11 shrink-0">
                <i class="bi bi-search"></i> Tampilkan Rekap
            </button>
        </div>
    </form>
</div>

@if(isset($selectedJadwal))
    <!-- Rekap Attendance Card -->
    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-6 border-b border-slate-100">
            <div>
                <h4 class="font-extrabold text-slate-800 text-lg leading-tight">{{ $selectedJadwal->kelas->nama_kelas }}</h4>
                <p class="text-slate-400 text-xs mt-1">Dosen Pengampu: {{ $selectedJadwal->kelas->dosen->nama_dosen }} &bull; Topik: {{ $selectedJadwal->topik_materi ?? 'Belum ditentukan' }}</p>
            </div>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-[#204a82] border border-blue-100 shrink-0 self-start sm:self-auto">
                Pertemuan {{ $selectedJadwal->pertemuan_ke }}
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-400 text-[11px] uppercase tracking-wider font-semibold">
                        <th class="py-3 px-4">NIM</th>
                        <th class="py-3 px-4">Nama Lengkap</th>
                        <th class="py-3 px-4">Status Kehadiran</th>
                        <th class="py-3 px-4 text-right">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($mahasiswas as $index => $mhs)
                        @php
                            $savedStatus = isset($absensi[$mhs->nim]) ? $absensi[$mhs->nim]->status : 'Belum absen';
                            $savedKet = isset($absensi[$mhs->nim]) ? $absensi[$mhs->nim]->keterangan : '';
                        @endphp
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-4 px-4 font-bold text-[#204a82]">{{ $mhs->nim }}</td>
                            <td class="py-4 px-4 font-semibold text-slate-700">{{ $mhs->nama }}</td>
                            <td class="py-4 px-4">
                                @if($savedStatus === 'Hadir')
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">Hadir</span>
                                @elseif($savedStatus === 'Izin')
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100">Izin</span>
                                @elseif($savedStatus === 'Sakit')
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">Sakit</span>
                                @elseif($savedStatus === 'Alpha')
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-100">Alpha</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-50 text-slate-500 border border-slate-100">Belum diinput</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-slate-500 font-medium text-right">{{ $savedKet ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-slate-400">
                                <i class="bi bi-person-x text-3xl d-block mb-3 text-slate-300"></i>
                                Belum ada data mahasiswa terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection
