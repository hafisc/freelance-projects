@extends('admin.layouts.admin')

@section('title', 'Manajemen Lamaran Masuk')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Manajemen Lamaran Masuk</h2>
    <p class="text-sm text-slate-500">Lihat, review, dan kelola kelulusan lamaran pekerjaan dari pencari kerja.</p>
</div>

<!-- Table Card -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto w-full">
        <table class="min-w-full divide-y divide-slate-100 text-left">
            <thead class="bg-slate-50">
                <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                    <th class="px-6 py-4">PELAMAR</th>
                    <th class="px-6 py-4">LOWONGAN DILAMAR</th>
                    <th class="px-6 py-4">NOMOR HP</th>
                    <th class="px-6 py-4">TANGGAL MELAMAR</th>
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
                            <div class="text-xs text-slate-400">{{ $app->job->company_name ?? '' }}</div>
                        </td>
                        <td class="px-6 py-4 text-slate-500 font-medium">{{ $app->phone }}</td>
                        <td class="px-6 py-4 text-slate-400">{{ $app->created_at->format('d M Y, H:i') }} WIB</td>
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
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400">
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
            {{ $applications->links('pagination::tailwind') }}
        </div>
    @endif
</div>
@endsection
