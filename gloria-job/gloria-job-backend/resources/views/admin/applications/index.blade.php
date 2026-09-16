@extends('admin.layouts.admin')

@section('title', 'Manajemen Lamaran Masuk')

@section('content')
<!-- Header Section -->
<div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Manajemen Lamaran Masuk</h2>
        <p class="text-sm text-slate-500">Lihat, review, dan kelola kelulusan lamaran pekerjaan dari pencari kerja.</p>
    </div>
    <a href="{{ route('admin.applications.export', request()->query()) }}"
       class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-bold rounded-2xl shadow-md shadow-emerald-200 hover:shadow-lg transition-all duration-150 whitespace-nowrap">
        <i class="fa-solid fa-file-excel"></i> Export Excel
    </a>
</div>

<!-- Filter Bar -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 mb-6">
    <form method="GET" action="{{ route('admin.applications.index') }}" class="flex flex-wrap items-end gap-3">
        <div class="flex-1 min-w-[160px]">
            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Perusahaan</label>
            <select name="company_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-primaryBlue">
                <option value="">Semua Perusahaan</option>
                @foreach($companies as $c)
                    <option value="{{ $c->id }}" {{ request('company_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex-1 min-w-[140px]">
            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Kategori</label>
            <select name="category" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-primaryBlue">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex-1 min-w-[130px]">
            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Status</label>
            <select name="status" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-primaryBlue">
                <option value="">Semua Status</option>
                @foreach(['Menunggu','Diproses','Diterima','Ditolak'] as $s)
                    <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-primaryBlue hover:bg-blue-700 text-white font-bold rounded-xl text-sm transition-all">
                <i class="fa-solid fa-filter"></i> Filter
            </button>
            <a href="{{ route('admin.applications.index') }}" class="px-4 py-2 bg-slate-50 hover:bg-slate-100 text-slate-500 rounded-xl text-sm font-bold transition-all" title="Reset">
                <i class="fa-solid fa-rotate-left"></i>
            </a>
        </div>
    </form>
</div>

<!-- Table Card -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto w-full">
        <table class="min-w-full divide-y divide-slate-100 text-left">
            <thead class="bg-slate-50">
                <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                    <th class="px-6 py-4">PELAMAR</th>
                    <th class="px-6 py-4">LOWONGAN DILAMAR</th>
                    <th class="px-6 py-4">KATEGORI</th>
                    <th class="px-6 py-4">NOMOR HP</th>
                    <th class="px-6 py-4">TANGGAL MELAMAR</th>
                    <th class="px-6 py-4">CV</th>
                    <th class="px-6 py-4">STATUS LAMARAN</th>
                    <th class="px-6 py-4 text-center">AKSI</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse($applications as $app)
                    <tr class="hover:bg-slate-50/50 transition-colors duration-150 text-sm">
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800">{{ $app->full_name }}</div>
                            <div class="text-xs text-slate-400">{{ $app->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-primaryBlue">{{ $app->job->title ?? 'Posisi Terhapus' }}</div>
                            <div class="text-xs text-slate-400">{{ $app->job->company_display_name ?? '' }}</div>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-500">{{ $app->job->category ?? '-' }}</td>
                        <td class="px-6 py-4 text-slate-500 font-medium">{{ $app->phone }}</td>
                        <td class="px-6 py-4 text-slate-400">{{ $app->created_at->format('d M Y, H:i') }} WIB</td>
                        <td class="px-6 py-4">
                            @if($app->cv_path)
                                <a href="{{ route('admin.applications.cv', $app->id) }}" target="_blank" class="text-primaryBlue text-xs font-semibold hover:underline flex items-center gap-1">
                                    <i class="fa-solid fa-file-pdf text-rose-500"></i> Lihat
                                </a>
                            @elseif($app->user && $app->user->cv)
                                <a href="{{ route('admin.applications.cv', $app->id) }}" target="_blank" class="text-slate-400 text-xs font-semibold hover:underline flex items-center gap-1">
                                    <i class="fa-solid fa-file"></i> Profil
                                </a>
                            @else
                                <span class="text-slate-300 text-xs">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($app->status == 'Menunggu')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-slate-50 text-slate-600 border border-slate-200">
                                    <i class="fa-regular fa-clock"></i> Menunggu
                                </span>
                            @elseif($app->status == 'Diproses')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-primaryBlue border border-blue-100">
                                    <i class="fa-solid fa-circle-notch fa-spin"></i> Diproses
                                </span>
                            @elseif($app->status == 'Diterima')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-success border border-emerald-100">
                                    <i class="fa-solid fa-circle-check"></i> Diterima
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-danger border border-rose-100">
                                    <i class="fa-solid fa-circle-xmark"></i> Ditolak
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.applications.show', $app->id) }}" class="inline-flex items-center gap-1 px-4 py-2 bg-slate-50 hover:bg-slate-100 text-slate-600 hover:text-slate-900 rounded-lg text-xs font-bold border border-slate-100 transition-all duration-150">
                                <i class="fa-regular fa-eye"></i> Review
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-slate-400">
                            <i class="fa-regular fa-envelope-open text-4xl mb-3 block text-slate-300"></i>
                            <span class="font-medium text-sm">Belum ada lamaran pekerjaan yang masuk.</span>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    @if($applications->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-center">
            {{ $applications->appends(request()->query())->links('pagination::tailwind') }}
        </div>
    @endif
</div>
@endsection
