@extends('layouts.app')

@section('title', 'Absensi Kelas | SI-PBM')
@section('page_title', 'Input Kehadiran Mahasiswa')

@section('content')

<!-- Header -->
<div class="mb-8">
    <h3 class="text-xl font-extrabold text-[#1b3f75]">Manajemen Presensi Kelas</h3>
    <p class="text-slate-400 text-xs mt-1">Pilih pertemuan kelas untuk memulai pengisian daftar hadir mahasiswa.</p>
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
                <i class="bi bi-search"></i> Tampilkan Mahasiswa
            </button>
        </div>
    </form>
</div>

@if(!isset($selectedJadwal))
    <!-- Empty state when no jadwal selected -->
    <div class="bg-white rounded-3xl p-12 border border-slate-100 shadow-sm text-center">
        <div class="flex flex-col items-center gap-4">
            <div class="w-20 h-20 rounded-3xl bg-blue-50 text-[#204a82] flex items-center justify-center text-4xl">
                <i class="bi bi-clipboard2-check"></i>
            </div>
            <div>
                <h4 class="font-extrabold text-slate-700 text-lg">Pilih Pertemuan Terlebih Dahulu</h4>
                <p class="text-slate-400 text-sm mt-1">Gunakan dropdown di atas untuk memilih jadwal pertemuan yang ingin Anda isi kehadirannya.</p>
            </div>
        </div>
    </div>
@else
    <!-- Attendance Info Banner -->
    <div class="bg-gradient-to-r from-[#1b3f75] to-[#274f85] rounded-2xl p-6 mb-6 text-white">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h4 class="font-extrabold text-lg leading-tight">{{ $selectedJadwal->kelas->nama_kelas }}</h4>
                <p class="text-blue-200 text-xs mt-1">
                    {{ $selectedJadwal->kelas->matakuliah->nama_mk }} &bull; 
                    Topik: {{ $selectedJadwal->topik_materi ?? 'Belum ditentukan' }}
                </p>
            </div>
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-white/10 text-white border border-white/20">
                    <i class="bi bi-calendar-event mr-1.5"></i> {{ date('d M Y', strtotime($selectedJadwal->tanggal)) }}
                </span>
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-white/10 text-white border border-white/20">
                    Pertemuan {{ $selectedJadwal->pertemuan_ke }}
                </span>
            </div>
        </div>
    </div>

    <!-- Input Attendance Card -->
    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
        <form action="{{ route('absensi.store') }}" method="POST">
            @csrf
            <input type="hidden" name="jadwal_id" value="{{ $selectedJadwal->id }}">
            
            <div class="overflow-x-auto mb-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-slate-400 text-[11px] uppercase tracking-wider font-semibold">
                            <th class="py-3 px-4" style="width: 60px;">No</th>
                            <th class="py-3 px-4">NIM</th>
                            <th class="py-3 px-4">Nama Lengkap</th>
                            <th class="py-3 px-4" style="width: 340px;">Presensi Kehadiran</th>
                            <th class="py-3 px-4">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($mahasiswas as $index => $mhs)
                            @php
                                $savedStatus = isset($absensi[$mhs->nim]) ? $absensi[$mhs->nim]->status : 'Hadir';
                                $savedKet = isset($absensi[$mhs->nim]) ? $absensi[$mhs->nim]->keterangan : '';
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-4 px-4 text-slate-400 font-bold text-center">{{ $index + 1 }}</td>
                                <td class="py-4 px-4 font-bold text-[#204a82]">{{ $mhs->nim }}</td>
                                <td class="py-4 px-4 font-semibold text-slate-700">{{ $mhs->nama }}</td>
                                <td class="py-4 px-4">
                                    <input type="hidden" name="absensi[{{ $index }}][nim]" value="{{ $mhs->nim }}">
                                    <div class="flex flex-wrap gap-4">
                                        <label class="flex items-center gap-1.5 cursor-pointer text-xs font-semibold text-emerald-600">
                                            <input type="radio" name="absensi[{{ $index }}][status]" value="Hadir" class="w-4 h-4 text-emerald-600 border-slate-300 focus:ring-emerald-500" {{ $savedStatus === 'Hadir' ? 'checked' : '' }}>
                                            Hadir
                                        </label>
                                        <label class="flex items-center gap-1.5 cursor-pointer text-xs font-semibold text-amber-600">
                                            <input type="radio" name="absensi[{{ $index }}][status]" value="Izin" class="w-4 h-4 text-amber-600 border-slate-300 focus:ring-amber-500" {{ $savedStatus === 'Izin' ? 'checked' : '' }}>
                                            Izin
                                        </label>
                                        <label class="flex items-center gap-1.5 cursor-pointer text-xs font-semibold text-blue-600">
                                            <input type="radio" name="absensi[{{ $index }}][status]" value="Sakit" class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500" {{ $savedStatus === 'Sakit' ? 'checked' : '' }}>
                                            Sakit
                                        </label>
                                        <label class="flex items-center gap-1.5 cursor-pointer text-xs font-semibold text-rose-600">
                                            <input type="radio" name="absensi[{{ $index }}][status]" value="Alpha" class="w-4 h-4 text-rose-600 border-slate-300 focus:ring-rose-500" {{ $savedStatus === 'Alpha' ? 'checked' : '' }}>
                                            Alpha
                                        </label>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <input type="text" name="absensi[{{ $index }}][keterangan]" value="{{ $savedKet }}" 
                                        class="block w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-xs focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" 
                                        placeholder="Datang terlambat 10 menit">
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center gap-3">
                                        <i class="bi bi-person-x text-4xl text-slate-300"></i>
                                        <span>Belum ada mahasiswa yang terdaftar di kelas ini.<br>Silakan plot KRS mahasiswa terlebih dahulu.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(count($mahasiswas) > 0)
                <!-- Summary & Save -->
                <div class="flex flex-col sm:flex-row items-center justify-between pt-6 border-t border-slate-100 gap-4">
                    <div class="text-xs text-slate-400">
                        <i class="bi bi-info-circle mr-1"></i> Total {{ count($mahasiswas) }} mahasiswa terdaftar di pertemuan ini
                    </div>
                    <button type="submit" 
                        class="flex items-center gap-2 bg-[#204a82] hover:bg-[#193f72] text-white font-semibold py-2.5 px-6 rounded-xl shadow-md transition-all duration-200 text-sm">
                        <i class="bi bi-save-fill"></i> Simpan Daftar Hadir
                    </button>
                </div>
            @endif
        </form>
    </div>
@endif
@endsection
