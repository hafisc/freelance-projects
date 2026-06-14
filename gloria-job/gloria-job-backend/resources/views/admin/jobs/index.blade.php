@extends('admin.layouts.admin')

@section('title', 'Kelola Lowongan Kerja')

@section('content')
<!-- Header Section -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Manajemen Lowongan Kerja</h2>
        <p class="text-sm text-slate-500">Kelola postingan lowongan kerja yang tampil di aplikasi mobile.</p>
    </div>
    <a href="{{ route('admin.jobs.create') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-primaryBlue hover:bg-blue-700 text-white font-bold rounded-2xl shadow-lg shadow-primaryBlue/20 hover:shadow-xl transition-all duration-200">
        <i class="fa-solid fa-plus text-sm"></i> Tambah Lowongan
    </a>
</div>

<!-- Table Card -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto w-full">
        <table class="min-w-full divide-y divide-slate-100 text-left">
            <thead class="bg-slate-50">
                <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                    <th class="px-6 py-4">POSISI PEKERJAAN</th>
                    <th class="px-6 py-4">PERUSAHAAN</th>
                    <th class="px-6 py-4">LOKASI</th>
                    <th class="px-6 py-4">BATAS WAKTU (DEADLINE)</th>
                    <th class="px-6 py-4">STATUS</th>
                    <th class="px-6 py-4 text-center">AKSI</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse($jobs as $job)
                    <tr class="hover:bg-slate-50/50 transition-colors duration-150 text-sm">
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800">{{ $job->title }}</div>
                            <div class="text-xs text-slate-400">Ditambahkan: {{ $job->created_at->format('d M Y') }}</div>
                        </td>
                        <td class="px-6 py-4 font-semibold text-slate-500">{{ $job->company_name }}</td>
                        <td class="px-6 py-4 text-slate-500">
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-solid fa-location-dot text-rose-500"></i> {{ $job->location }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-400">
                            @if($job->deadline)
                                {{ date('d M Y', strtotime($job->deadline)) }}
                            @else
                                <span class="text-slate-300 italic">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($job->status == 'Aktif')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-success border border-emerald-100">
                                    <i class="fa-solid fa-circle-check"></i> Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-danger border border-rose-100">
                                    <i class="fa-solid fa-circle-xmark"></i> Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="inline-flex gap-2">
                                <a href="{{ route('admin.jobs.edit', $job->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-50 hover:bg-blue-50 text-slate-600 hover:text-primaryBlue rounded-lg text-xs font-semibold border border-slate-100 transition-all duration-150">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </a>
                                <form action="{{ route('admin.jobs.destroy', $job->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lowongan ini? Semua lamaran terkait akan terhapus.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-50 hover:bg-rose-50 text-slate-600 hover:text-danger rounded-lg text-xs font-semibold border border-slate-100 transition-all duration-150">
                                        <i class="fa-solid fa-trash-can"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                            <i class="fa-regular fa-folder-open text-4xl mb-3 block text-slate-300"></i>
                            <span class="font-medium text-sm">Belum ada lowongan pekerjaan yang diposting.</span>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    @if($jobs->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-center">
            {{ $jobs->links('pagination::tailwind') }}
        </div>
    @endif
</div>
@endsection
