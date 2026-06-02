@extends('layouts.app')

@section('page_title', 'Katalog Koleksi Buku')

@section('content')
<div class="space-y-6">
    <!-- Header Aksi -->
    <div class="bg-white p-6 rounded-lg border border-libborder shadow-sm">
        <h2 class="text-base font-bold text-libnavy">Katalog Koleksi Perpustakaan</h2>
        <p class="text-xs text-libmuted mt-1">Cari dan jelajahi seluruh buku perpustakaan secara visual.</p>
    </div>

    <!-- Filter & Pencarian Bar -->
    <form action="{{ route('catalog.index') }}" method="GET" class="bg-white p-6 rounded-lg border border-libborder shadow-sm flex flex-col md:flex-row gap-4 items-center justify-between">
        
        <!-- Search Input -->
        <div class="w-full md:max-w-md relative">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari judul, penulis, kode buku..."
                class="w-full pl-10 pr-4 py-2.5 bg-white border border-libborder rounded-md text-xs text-libdark focus:outline-none focus:border-libgold transition">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-libmuted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Filter Dropdown & Tombol -->
        <div class="w-full md:w-auto flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <!-- Dropdown Kategori -->
            <select name="category" class="px-4 py-2.5 bg-white border border-libborder rounded-md text-xs text-libdark focus:outline-none focus:border-libgold transition">
                <option value="">-- Semua Kategori --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ $category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>

            <!-- Buttons -->
            <div class="flex items-center gap-2">
                <button type="submit" class="flex-1 sm:flex-none px-5 py-2.5 bg-libnavy text-white text-xs font-semibold rounded-md hover:bg-libnavy/90 hover:shadow-sm transition">
                    Terapkan
                </button>
                @if($search || $category)
                    <a href="{{ route('catalog.index') }}" class="px-4 py-2.5 border border-libborder text-libmuted rounded-md text-xs font-semibold hover:bg-libcream hover:text-libdark text-center transition">
                        Reset
                    </a>
                @endif
            </div>
        </div>
    </form>

    <!-- Grid Katalog Buku -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($books as $book)
            <!-- Book Card -->
            <div class="bg-white rounded-lg border border-libborder shadow-sm overflow-hidden flex flex-col hover:shadow-md transition-all duration-300 transform hover:-translate-y-1 group">
                <!-- Cover Dummy Modern -->
                <div class="bg-libcream py-8 px-4 flex items-center justify-center border-b border-libborder relative">
                    <span class="absolute top-3 left-3 px-2 py-0.5 bg-libnavy text-white rounded font-mono text-[9px] font-semibold tracking-wider">
                        {{ $book->book_code }}
                    </span>
                    <div class="w-16 h-20 bg-white border border-libgold/20 shadow-sm flex flex-col justify-between p-2 text-center rounded">
                        <span class="text-[8px] font-bold text-libnavy truncate leading-none">{{ $book->category ?? 'Umum' }}</span>
                        <div class="h-0.5 bg-libgold/40 my-1"></div>
                        <span class="text-[6px] text-libmuted leading-tight font-mono">{{ $book->publication_year }}</span>
                    </div>
                </div>

                <!-- Detail Content -->
                <div class="p-5 flex-1 flex flex-col space-y-3 justify-between">
                    <div>
                        <span class="text-[9px] font-bold text-libgold uppercase tracking-wider block mb-1">
                            {{ $book->category ?? 'Koleksi Umum' }}
                        </span>
                        <h3 class="text-xs font-bold text-libnavy leading-snug group-hover:text-libgold transition-colors line-clamp-2">
                            {{ $book->title }}
                        </h3>
                        <span class="text-[10px] text-libmuted block mt-1">
                            Penulis: <span class="font-medium text-libdark">{{ $book->author ?? 'Tidak diketahui' }}</span>
                        </span>
                    </div>

                    <div class="pt-4 border-t border-libborder flex items-center justify-between">
                        <!-- Status Stok -->
                        <div>
                            @if($book->stock > 0)
                                <span class="px-2 py-0.5 bg-[#E6F4EA] text-libsuccess rounded text-[9px] font-bold border border-libsuccess/10 uppercase tracking-wider">
                                    Stok: {{ $book->stock }}
                                </span>
                            @else
                                <span class="px-2 py-0.5 bg-red-50 text-libdanger rounded text-[9px] font-bold border border-libdanger/10 uppercase tracking-wider">
                                    Habis
                                </span>
                            @endif
                        </div>

                        <!-- Link Detail -->
                        <a href="{{ route('books.show', $book->id) }}" class="text-[10px] font-bold text-libnavy hover:text-libgold transition flex items-center space-x-0.5">
                            <span>Detail</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-lg border border-libborder p-12 text-center text-xs text-libmuted shadow-sm">
                <div class="flex flex-col items-center justify-center space-y-2">
                    <svg class="w-10 h-10 text-libmuted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span class="text-sm font-medium text-libnavy">Buku tidak ditemukan</span>
                    <span class="text-xs text-libmuted">Silakan sesuaikan kata kunci pencarian atau filter kategori Anda.</span>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Paginasi -->
    @if($books->hasPages())
        <div class="bg-white rounded-lg border border-libborder p-4 shadow-sm">
            {{ $books->links() }}
        </div>
    @endif
</div>
@endsection
