@extends('layouts.app')

@section('page_title', 'Koleksi Buku')

@section('content')
<div class="space-y-6">
    <!-- Header Aksi -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-lg border border-libborder shadow-sm">
        <div>
            <h2 class="text-base font-bold text-libnavy">Kelola Koleksi Buku</h2>
            <p class="text-xs text-libmuted mt-1">Daftar buku perpustakaan untuk dipinjamkan kepada anggota.</p>
        </div>
        <div>
            <a href="{{ route('books.create') }}" class="inline-flex items-center space-x-2 px-4 py-2.5 bg-libnavy text-white text-xs font-semibold rounded-md hover:bg-libnavy/90 hover:shadow-sm transition">
                <svg class="w-4 h-4 text-libgold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Tambah Buku</span>
            </a>
        </div>
    </div>

    <!-- Pencarian & Tabel -->
    <div class="bg-white rounded-lg border border-libborder shadow-sm overflow-hidden">
        <!-- Filter Bar -->
        <div class="p-6 border-b border-libborder bg-white/5 flex items-center justify-between">
            <form action="{{ route('books.index') }}" method="GET" class="w-full max-w-md">
                <div class="relative">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari judul, penulis, kategori, kode..."
                        class="w-full pl-10 pr-4 py-2.5 bg-white border border-libborder rounded-md text-xs text-libdark focus:outline-none focus:border-libgold transition">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-libmuted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </form>
            @if($search)
                <a href="{{ route('books.index') }}" class="text-xs text-libdanger hover:underline font-semibold ml-4">
                    Reset Pencarian
                </a>
            @endif
        </div>

        <!-- Tabel Buku -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-libcream border-b border-libborder">
                        <th class="px-6 py-4 text-xs font-bold text-libnavy uppercase tracking-wider w-32">Kode</th>
                        <th class="px-6 py-4 text-xs font-bold text-libnavy uppercase tracking-wider">Judul Buku</th>
                        <th class="px-6 py-4 text-xs font-bold text-libnavy uppercase tracking-wider w-48">Penulis</th>
                        <th class="px-6 py-4 text-xs font-bold text-libnavy uppercase tracking-wider w-40">Kategori</th>
                        <th class="px-6 py-4 text-xs font-bold text-libnavy text-center uppercase tracking-wider w-32">Stok</th>
                        <th class="px-6 py-4 text-xs font-bold text-libnavy text-center uppercase tracking-wider w-48">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-libborder">
                    @forelse($books as $book)
                        <tr class="hover:bg-libcream/30 transition-colors group">
                            <td class="px-6 py-4 text-xs font-semibold text-libnavy group-hover:text-libgold transition-colors font-mono">
                                {{ $book->book_code }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-libdark">
                                {{ $book->title }}
                            </td>
                            <td class="px-6 py-4 text-xs text-libdark">
                                {{ $book->author ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-xs text-libmuted">
                                <span class="px-2 py-1 bg-libcream text-libnavy rounded text-[10px] font-semibold border border-libgold/10">
                                    {{ $book->category ?? 'Umum' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($book->stock > 0)
                                    <span class="inline-flex items-center justify-center px-2.5 py-1 text-[10px] font-bold bg-[#E6F4EA] text-libsuccess rounded-full border border-libsuccess/10 uppercase tracking-wider">
                                        {{ $book->stock }} Buku
                                    </span>
                                @else
                                    <span class="inline-flex items-center justify-center px-2.5 py-1 text-[10px] font-bold bg-red-50 text-libdanger rounded-full border border-libdanger/10 uppercase tracking-wider">
                                        Habis
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="inline-flex items-center space-x-2">
                                    <!-- Detail -->
                                    <a href="{{ route('books.show', $book->id) }}" class="p-2 text-libnavy hover:bg-libcream hover:text-libnavy rounded-md transition" title="Detail Buku">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <!-- Edit -->
                                    <a href="{{ route('books.edit', $book->id) }}" class="p-2 text-libgold hover:bg-libcream hover:text-libgold rounded-md transition" title="Ubah Buku">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <!-- Hapus -->
                                    <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data buku {{ $book->title }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-libdanger hover:bg-red-50 hover:text-libdanger rounded-md transition" title="Hapus Buku">
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
                            <td colspan="6" class="px-6 py-12 text-center text-xs text-libmuted">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <svg class="w-8 h-8 text-libmuted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    <span>Tidak ada data buku ditemukan.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginasi -->
        @if($books->hasPages())
            <div class="px-6 py-4 border-t border-libborder bg-white/5">
                {{ $books->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
