@extends('layouts.app')

@section('title', 'Jadwal Pembelajaran | SI-PBM')
@section('page_title', 'Jadwal Pertemuan Pembelajaran')

@section('content')
<div class="mb-8">
    <h3 class="text-xl font-extrabold text-[#1b3f75]">Agenda Pertemuan Kuliah</h3>
    <p class="text-slate-400 text-xs mt-1">Lihat rencana pelaksanaan pertemuan kelas akademik yang terdaftar (Operator Read-Only).</p>
</div>

<!-- Table Card -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400 text-[11px] uppercase tracking-wider font-semibold">
                    <th class="py-4 px-6">Kelas / MK</th>
                    <th class="py-4 px-6">Pertemuan</th>
                    <th class="py-4 px-6">Tanggal</th>
                    <th class="py-4 px-6">Waktu / Jam</th>
                    <th class="py-4 px-6">Ruangan</th>
                    <th class="py-4 px-6">Topik / Pokok Bahasan</th>
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
                        <td class="py-4 px-6 font-bold text-slate-700">Ke-{{ $j->pertemuan_ke }}</td>
                        <td class="py-4 px-6 text-slate-500 font-medium">{{ date('d-m-Y', strtotime($j->tanggal)) }}</td>
                        <td class="py-4 px-6 text-slate-500">{{ substr($j->jam_mulai, 0, 5) }} - {{ substr($j->jam_selesai, 0, 5) }} WIB</td>
                        <td class="py-4 px-6">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/50">{{ $j->ruangan }}</span>
                        </td>
                        <td class="py-4 px-6 text-slate-500 font-medium max-w-[250px] truncate" title="{{ $j->topik_materi }}">{{ $j->topik_materi ?? 'Belum ditentukan' }}</td>
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
                        <td colspan="7" class="py-12 text-center text-slate-400">
                            <i class="bi bi-calendar-x text-3xl d-block mb-3 text-slate-300"></i>
                            Jadwal pertemuan pembelajaran belum terdaftar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
