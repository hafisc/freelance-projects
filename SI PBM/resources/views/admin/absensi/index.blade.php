@extends('layouts.app')

@section('title', 'Absensi Mahasiswa | SI-PBM')
@section('page_title', 'Kehadiran Mahasiswa')

@section('content')

@php
    $role = session('role');
@endphp

@if($role === 'Mahasiswa')
    <!-- Tampilan Riwayat Kehadiran Mahasiswa -->
    <div class="mb-8">
        <h3 class="text-xl font-extrabold text-[#1b3f75]">Riwayat Kehadiran Saya</h3>
        <p class="text-slate-400 text-xs mt-1">Daftar rekap presensi kehadiran kelas perkuliahan Anda.</p>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-400 text-[11px] uppercase tracking-wider font-semibold">
                        <th class="py-4 px-6">Kelas</th>
                        <th class="py-4 px-6">Mata Kuliah</th>
                        <th class="py-4 px-6">Dosen</th>
                        <th class="py-4 px-6">Pertemuan Ke</th>
                        <th class="py-4 px-6">Tanggal</th>
                        <th class="py-4 px-6">Status Absen</th>
                        <th class="py-4 px-6">Keterangan</th>
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
                            <td class="py-4 px-6 text-slate-500 font-medium">{{ $absen->keterangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <i class="bi bi-clock-history text-3xl d-block mb-3 text-slate-300"></i>
                                Riwayat presensi kehadiran belum tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@else
    <!-- Tampilan Dosen, Operator & Admin Input Presensi -->
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

    @if(isset($selectedJadwal))
        <!-- Input Attendance Card -->
        <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-6 border-b border-slate-100">
                <div>
                    <h4 class="font-extrabold text-slate-800 text-lg leading-tight">{{ $selectedJadwal->kelas->nama_kelas }}</h4>
                    <p class="text-slate-400 text-xs mt-1">Topik: {{ $selectedJadwal->topik_materi ?? 'Belum ditentukan' }}</p>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-[#204a82] border border-blue-100 shrink-0 self-start sm:self-auto">
                    Pertemuan {{ $selectedJadwal->pertemuan_ke }}
                </span>
            </div>

            <form action="{{ route('absensi.store') }}" method="POST">
                @csrf
                <input type="hidden" name="jadwal_id" value="{{ $selectedJadwal->id }}">
                
                <div class="overflow-x-auto mb-6">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 text-slate-400 text-[11px] uppercase tracking-wider font-semibold">
                                <th class="py-3 px-4">NIM</th>
                                <th class="py-3 px-4">Nama Lengkap</th>
                                <th class="py-3 px-4" style="width: 340px;">Presensi Kehadiran</th>
                                <th class="py-3 px-4">Keterangan / Catatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @forelse($mahasiswas as $index => $mhs)
                                @php
                                    $savedStatus = isset($absensi[$mhs->nim]) ? $absensi[$mhs->nim]->status : 'Hadir';
                                    $savedKet = isset($absensi[$mhs->nim]) ? $absensi[$mhs->nim]->keterangan : '';
                                @endphp
                                <tr class="hover:bg-slate-50/50 transition-colors">
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
                                            placeholder="Contoh: Datang terlambat 10 menit">
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-12 text-center text-slate-400">
                                        <i class="bi bi-person-x text-3xl d-block mb-3 text-slate-300"></i>
                                        Belum ada mahasiswa yang terdaftar di kelas/mata kuliah ini. Silakan plot KRS mahasiswa terlebih dahulu.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(count($mahasiswas) > 0)
                    <div class="flex justify-end pt-4 border-t border-slate-100">
                        <button type="submit" 
                            class="flex items-center gap-2 bg-[#204a82] hover:bg-[#193f72] text-white font-semibold py-2.5 px-6 rounded-xl shadow-md transition-all duration-200 text-sm">
                            <i class="bi bi-save-fill"></i> Simpan Daftar Hadir
                        </button>
                    </div>
                @endif
            </form>
        </div>
    @endif
@endif
@endsection
