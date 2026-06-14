@extends('layouts.app')

@section('page_title', 'Ubah Data Buku')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    
    <!-- Header -->
    <div class="flex items-center justify-between bg-white p-6 rounded-lg border border-libborder shadow-sm">
        <div>
            <h2 class="text-base font-bold text-libnavy">Ubah Informasi Buku</h2>
            <p class="text-xs text-libmuted mt-1">Perbarui detail katalog dan stok buku.</p>
        </div>
        <a href="{{ route('books.index') }}" class="inline-flex items-center space-x-1 text-xs font-semibold text-libnavy hover:text-libgold transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Card Form -->
    <div class="bg-white rounded-lg border border-libborder shadow-sm p-6 md:p-8">
        <form action="{{ route('books.update', $book->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Baris 1: Kode & Judul -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Kode Buku -->
                <div>
                    <label for="book_code" class="block text-xs font-bold text-libdark uppercase tracking-wider mb-2">Kode Buku <span class="text-libdanger">*</span></label>
                    <input type="text" name="book_code" id="book_code" value="{{ old('book_code', $book->book_code) }}" required
                        class="w-full px-4 py-2.5 bg-white border @error('book_code') border-libdanger @else border-libborder @enderror rounded-md text-xs text-libdark font-semibold focus:outline-none focus:border-libgold font-mono transition"
                        placeholder="contoh: BK-0001">
                    @error('book_code')
                        <p class="text-xs text-libdanger mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Judul Buku -->
                <div>
                    <label for="title" class="block text-xs font-bold text-libdark uppercase tracking-wider mb-2">Judul Buku <span class="text-libdanger">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}" required
                        class="w-full px-4 py-2.5 bg-white border @error('title') border-libdanger @else border-libborder @enderror rounded-md text-xs text-libdark focus:outline-none focus:border-libgold transition"
                        placeholder="Masukkan judul lengkap buku">
                    @error('title')
                        <p class="text-xs text-libdanger mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Baris 2: Penulis & Penerbit -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Penulis -->
                <div>
                    <label for="author" class="block text-xs font-bold text-libdark uppercase tracking-wider mb-2">Penulis / Pengarang</label>
                    <input type="text" name="author" id="author" value="{{ old('author', $book->author) }}"
                        class="w-full px-4 py-2.5 bg-white border @error('author') border-libdanger @else border-libborder @enderror rounded-md text-xs text-libdark focus:outline-none focus:border-libgold transition"
                        placeholder="Nama pengarang buku">
                    @error('author')
                        <p class="text-xs text-libdanger mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Penerbit -->
                <div>
                    <label for="publisher" class="block text-xs font-bold text-libdark uppercase tracking-wider mb-2">Penerbit</label>
                    <input type="text" name="publisher" id="publisher" value="{{ old('publisher', $book->publisher) }}"
                        class="w-full px-4 py-2.5 bg-white border @error('publisher') border-libdanger @else border-libborder @enderror rounded-md text-xs text-libdark focus:outline-none focus:border-libgold transition"
                        placeholder="Perusahaan penerbit buku">
                    @error('publisher')
                        <p class="text-xs text-libdanger mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Baris 3: Tahun Terbit, Kategori & Stok -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <!-- Tahun Terbit -->
                <div>
                    <label for="publication_year" class="block text-xs font-bold text-libdark uppercase tracking-wider mb-2">Tahun Terbit</label>
                    <input type="number" name="publication_year" id="publication_year" value="{{ old('publication_year', $book->publication_year) }}"
                        class="w-full px-4 py-2.5 bg-white border @error('publication_year') border-libdanger @else border-libborder @enderror rounded-md text-xs text-libdark focus:outline-none focus:border-libgold transition font-mono"
                        placeholder="contoh: 2024">
                    @error('publication_year')
                        <p class="text-xs text-libdanger mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div>
                    <label for="category" class="block text-xs font-bold text-libdark uppercase tracking-wider mb-2">Kategori Buku</label>
                    <input type="text" name="category" id="category" value="{{ old('category', $book->category) }}"
                        class="w-full px-4 py-2.5 bg-white border @error('category') border-libdanger @else border-libborder @enderror rounded-md text-xs text-libdark focus:outline-none focus:border-libgold transition"
                        placeholder="Pemrograman, Sains, dll.">
                    @error('category')
                        <p class="text-xs text-libdanger mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jumlah Stok -->
                <div>
                    <label for="stock" class="block text-xs font-bold text-libdark uppercase tracking-wider mb-2">Jumlah Stok <span class="text-libdanger">*</span></label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock', $book->stock) }}" required
                        class="w-full px-4 py-2.5 bg-white border @error('stock') border-libdanger @else border-libborder @enderror rounded-md text-xs text-libdark font-semibold focus:outline-none focus:border-libgold transition font-mono"
                        placeholder="contoh: 5">
                    @error('stock')
                        <p class="text-xs text-libdanger mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Baris 4: Deskripsi -->
            <div>
                <label for="description" class="block text-xs font-bold text-libdark uppercase tracking-wider mb-2">Deskripsi Ringkas</label>
                <textarea name="description" id="description" rows="3"
                    class="w-full px-4 py-2.5 bg-white border @error('description') border-libdanger @else border-libborder @enderror rounded-md text-xs text-libdark focus:outline-none focus:border-libgold transition"
                    placeholder="Sinopsis singkat atau info tambahan buku...">{{ old('description', $book->description) }}</textarea>
                @error('description')
                    <p class="text-xs text-libdanger mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-libborder">
                <a href="{{ route('books.index') }}" class="px-4 py-2.5 border border-libborder text-libmuted rounded-md text-xs font-semibold hover:bg-libcream hover:text-libdark transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 bg-libnavy text-white text-xs font-semibold rounded-md hover:bg-libnavy/90 hover:shadow-sm transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
