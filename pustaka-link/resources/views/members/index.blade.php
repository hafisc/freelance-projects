@extends('layouts.app')

@section('page_title', 'Data Anggota')

@section('content')
<div class="space-y-6">
    <!-- Header Aksi -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-lg border border-libborder shadow-sm">
        <div>
            <h2 class="text-base font-bold text-libnavy">Kelola Anggota Perpustakaan</h2>
            <p class="text-xs text-libmuted mt-1">Daftar seluruh anggota yang terdaftar untuk meminjam buku.</p>
        </div>
        <div>
            <a href="{{ route('members.create') }}" class="inline-flex items-center space-x-2 px-4 py-2.5 bg-libnavy text-white text-xs font-semibold rounded-md hover:bg-libnavy/90 hover:shadow-sm transition">
                <svg class="w-4 h-4 text-libgold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Tambah Anggota</span>
            </a>
        </div>
    </div>

    <!-- Pencarian & Tabel -->
    <div class="bg-white rounded-lg border border-libborder shadow-sm overflow-hidden">
        <!-- Filter Bar -->
        <div class="p-6 border-b border-libborder bg-white/5 flex items-center justify-between">
            <form action="{{ route('members.index') }}" method="GET" class="w-full max-w-md">
                <div class="relative">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau kode anggota..."
                        class="w-full pl-10 pr-4 py-2.5 bg-white border border-libborder rounded-md text-xs text-libdark focus:outline-none focus:border-libgold transition">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-libmuted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </form>
            @if($search)
                <a href="{{ route('members.index') }}" class="text-xs text-libdanger hover:underline font-semibold ml-4">
                    Reset Pencarian
                </a>
            @endif
        </div>

        <!-- Tabel Anggota -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-libcream border-b border-libborder">
                        <th class="px-6 py-4 text-xs font-bold text-libnavy uppercase tracking-wider w-32">Kode</th>
                        <th class="px-6 py-4 text-xs font-bold text-libnavy uppercase tracking-wider">Nama Lengkap</th>
                        <th class="px-6 py-4 text-xs font-bold text-libnavy uppercase tracking-wider w-36">Jenis Kelamin</th>
                        <th class="px-6 py-4 text-xs font-bold text-libnavy uppercase tracking-wider w-40">No. Telepon</th>
                        <th class="px-6 py-4 text-xs font-bold text-libnavy text-center uppercase tracking-wider w-48">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-libborder">
                    @forelse($members as $member)
                        <tr class="hover:bg-libcream/30 transition-colors group">
                            <td class="px-6 py-4 text-xs font-semibold text-libnavy group-hover:text-libgold transition-colors font-mono">
                                {{ $member->member_code }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-libdark">
                                {{ $member->name }}
                            </td>
                            <td class="px-6 py-4 text-xs text-libdark">
                                {{ $member->gender }}
                            </td>
                            <td class="px-6 py-4 text-xs text-libmuted font-mono">
                                {{ $member->phone ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="inline-flex items-center space-x-2">
                                    <!-- Detail -->
                                    <a href="{{ route('members.show', $member->id) }}" class="p-2 text-libnavy hover:bg-libcream hover:text-libnavy rounded-md transition" title="Detail Anggota">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <!-- Edit -->
                                    <a href="{{ route('members.edit', $member->id) }}" class="p-2 text-libgold hover:bg-libcream hover:text-libgold rounded-md transition" title="Ubah Anggota">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <!-- Hapus -->
                                    <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data anggota {{ $member->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-libdanger hover:bg-red-50 hover:text-libdanger rounded-md transition" title="Hapus Anggota">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-xs text-libmuted">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <svg class="w-8 h-8 text-libmuted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0V9a2 2 0 00-2-2H6a2 2 0 00-2 2v2M9 5h6m-6 8h6"></path>
                                    </svg>
                                    <span>Tidak ada data anggota ditemukan.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginasi -->
        @if($members->hasPages())
            <div class="px-6 py-4 border-t border-libborder bg-white/5">
                {{ $members->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
