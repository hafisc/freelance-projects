@extends('layouts.app')

@section('title', 'Tabel Hak Akses | SI-PBM')
@section('page_title', 'Tabel Hak Akses')

@section('content')
<div class="mb-8">
    <h3 class="text-xl font-extrabold text-[#1b3f75]">Tingkat Hak Akses Peran</h3>
    <p class="text-slate-400 text-xs mt-1">Daftar referensi tingkat otorisasi peran pengguna dalam sistem SI-PBM.</p>
</div>

<!-- Table Card -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400 text-[11px] uppercase tracking-wider font-semibold">
                    <th class="py-4 px-6">Role</th>
                    <th class="py-4 px-6">Level Akses</th>
                    <th class="py-4 px-6">Deskripsi Otoritas</th>
                    <th class="py-4 px-6 text-right">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($hakAkses as $akses)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-4 px-6">
                            @if($akses->nama_role === 'Admin')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-100">Admin</span>
                            @elseif($akses->nama_role === 'Operator')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-100">Operator</span>
                            @elseif($akses->nama_role === 'Dosen')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">Dosen</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">Mahasiswa</span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/50">Level {{ $akses->level_akses }}</span>
                        </td>
                        <td class="py-4 px-6 text-slate-500 font-medium">{{ $akses->deskripsi }}</td>
                        <td class="py-4 px-6 text-right">
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                {{ $akses->is_active ? 'Aktif' : 'Non-aktif' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-12 text-center text-slate-400">
                            <i class="bi bi-shield-lock text-3xl d-block mb-3 text-slate-300"></i>
                            Referensi hak akses kosong.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
