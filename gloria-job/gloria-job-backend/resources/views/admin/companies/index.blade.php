@extends('admin.layouts.admin')

@section('title', 'Manajemen Perusahaan')

@section('content')
<!-- Header -->
<div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Manajemen Perusahaan</h2>
        <p class="text-sm text-slate-500">Kelola data perusahaan yang membuka lowongan kerja melalui Gloria Job.</p>
    </div>
    <a href="{{ route('admin.companies.create') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-primaryBlue hover:bg-blue-700 text-white font-bold rounded-2xl shadow-lg shadow-primaryBlue/20 hover:shadow-xl transition-all duration-150 text-sm">
        <i class="fa-solid fa-plus"></i> Tambah Perusahaan
    </a>
</div>

<!-- Table -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto w-full">
        <table class="min-w-full divide-y divide-slate-100 text-left">
            <thead class="bg-slate-50">
                <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                    <th class="px-6 py-4">NO</th>
                    <th class="px-6 py-4">PERUSAHAAN</th>
                    <th class="px-6 py-4">INDUSTRI</th>
                    <th class="px-6 py-4">EMAIL</th>
                    <th class="px-6 py-4">TELEPON</th>
                    <th class="px-6 py-4 text-center">LOWONGAN</th>
                    <th class="px-6 py-4 text-center">PELAMAR</th>
                    <th class="px-6 py-4 text-center">AKSI</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse($companies as $index => $company)
                    <tr class="hover:bg-slate-50/50 transition-colors duration-150 text-sm">
                        <td class="px-6 py-4 text-slate-400 font-medium">{{ $companies->firstItem() + $index }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($company->logo)
                                    <img src="{{ asset('storage/' . $company->logo) }}" alt="{{ $company->name }}" class="h-10 w-10 object-cover rounded-xl border border-slate-100">
                                @else
                                    <div class="h-10 w-10 rounded-xl bg-blue-50 text-primaryBlue flex items-center justify-center font-bold text-sm">
                                        {{ strtoupper(substr($company->name, 0, 2)) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="font-bold text-slate-800">{{ $company->name }}</div>
                                    @if($company->pic_name)
                                        <div class="text-xs text-slate-400">PIC: {{ $company->pic_name }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-500">{{ $company->industry ?? '-' }}</td>
                        <td class="px-6 py-4 text-slate-500">{{ $company->email ?? '-' }}</td>
                        <td class="px-6 py-4 text-slate-500">{{ $company->phone ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-primaryBlue border border-blue-100">
                                <i class="fa-solid fa-briefcase"></i> {{ $company->jobs_count }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-purple-50 text-purple-600 border border-purple-100">
                                <i class="fa-solid fa-users"></i> {{ $company->applications_count }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.companies.show', $company->id) }}" class="inline-flex items-center gap-1 px-3 py-2 bg-slate-50 hover:bg-slate-100 text-slate-600 hover:text-slate-900 rounded-lg text-xs font-bold transition-all duration-150" title="Detail">
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.companies.edit', $company->id) }}" class="inline-flex items-center gap-1 px-3 py-2 bg-amber-50 hover:bg-amber-100 text-amber-600 hover:text-amber-700 rounded-lg text-xs font-bold transition-all duration-150" title="Edit">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.companies.destroy', $company->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus perusahaan ini? Semua lowongan terkait akan kehilangan relasi.');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 px-3 py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 hover:text-rose-700 rounded-lg text-xs font-bold transition-all duration-150" title="Hapus">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-slate-400">
                            <i class="fa-regular fa-building text-4xl mb-3 block text-slate-300"></i>
                            <span class="font-medium text-sm">Belum ada data perusahaan. Silakan tambah perusahaan terlebih dahulu.</span>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($companies->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $companies->links() }}
        </div>
    @endif
</div>
@endsection
