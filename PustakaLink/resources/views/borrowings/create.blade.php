@extends('layouts.app')

@section('page_title', 'Catat Peminjaman Buku')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    
    <!-- Header -->
    <div class="flex items-center justify-between bg-white p-6 rounded-lg border border-libborder shadow-sm">
        <div>
            <h2 class="text-base font-bold text-libnavy">Catat Transaksi Peminjaman</h2>
            <p class="text-xs text-libmuted mt-1">Buat sirkulasi peminjaman baru dengan kalkulasi jatuh tempo otomatis.</p>
        </div>
        <a href="{{ route('borrowings.index') }}" class="inline-flex items-center space-x-1 text-xs font-semibold text-libnavy hover:text-libgold transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Card Form -->
    <div class="bg-white rounded-lg border border-libborder shadow-sm p-6 md:p-8">
        <form action="{{ route('borrowings.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Anggota Peminjam -->
            <div>
                <label for="member_id" class="block text-xs font-bold text-libdark uppercase tracking-wider mb-2">Anggota Peminjam <span class="text-libdanger">*</span></label>
                <select name="member_id" id="member_id" required
                    class="w-full px-4 py-2.5 bg-white border @error('member_id') border-libdanger @else border-libborder @enderror rounded-md text-xs text-libdark focus:outline-none focus:border-libgold transition">
                    <option value="" disabled selected>-- Pilih Anggota --</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                            {{ $member->member_code }} - {{ $member->name }}
                        </option>
                    @endforeach
                </select>
                @error('member_id')
                    <p class="text-xs text-libdanger mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buku yang Dipinjam -->
            <div>
                <label for="book_id" class="block text-xs font-bold text-libdark uppercase tracking-wider mb-2">Buku yang Dipinjam <span class="text-libdanger">*</span></label>
                <select name="book_id" id="book_id" required
                    class="w-full px-4 py-2.5 bg-white border @error('book_id') border-libdanger @else border-libborder @enderror rounded-md text-xs text-libdark focus:outline-none focus:border-libgold transition">
                    <option value="" disabled selected>-- Pilih Buku --</option>
                    @foreach($books as $book)
                        <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                            {{ $book->book_code }} - {{ $book->title }} (Stok: {{ $book->stock }})
                        </option>
                    @endforeach
                </select>
                <p class="text-[10px] text-libmuted mt-1.5 leading-relaxed">Hanya menampilkan buku yang memiliki stok fisik tersedia di rak perpustakaan.</p>
                @error('book_id')
                    <p class="text-xs text-libdanger mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal Pinjam -->
            <div>
                <label for="borrow_date" class="block text-xs font-bold text-libdark uppercase tracking-wider mb-2">Tanggal Pinjam <span class="text-libdanger">*</span></label>
                <input type="date" name="borrow_date" id="borrow_date" value="{{ old('borrow_date', date('Y-m-d')) }}" required
                    class="w-full px-4 py-2.5 bg-white border @error('borrow_date') border-libdanger @else border-libborder @enderror rounded-md text-xs text-libdark font-semibold focus:outline-none focus:border-libgold font-mono transition">
                <div class="mt-2 p-3 bg-libcream rounded border border-libgold/20 flex items-start space-x-2">
                    <svg class="w-4 h-4 text-libgold mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-[10px] text-libnavy leading-relaxed font-medium">
                        <strong>Kalkulasi Otomatis:</strong> Sistem akan otomatis menetapkan batas jatuh tempo pengembalian <strong>7 hari</strong> ke depan dari tanggal pinjam yang dipilih di atas menggunakan pustaka Carbon.
                    </p>
                </div>
                @error('borrow_date')
                    <p class="text-xs text-libdanger mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Catatan -->
            <div>
                <label for="notes" class="block text-xs font-bold text-libdark uppercase tracking-wider mb-2">Catatan Tambahan (Opsional)</label>
                <textarea name="notes" id="notes" rows="3"
                    class="w-full px-4 py-2.5 bg-white border @error('notes') border-libdanger @else border-libborder @enderror rounded-md text-xs text-libdark focus:outline-none focus:border-libgold transition"
                    placeholder="Tulis keterangan khusus jika diperlukan (misal: kondisi buku agak rusak)...">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="text-xs text-libdanger mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-libborder">
                <a href="{{ route('borrowings.index') }}" class="px-4 py-2.5 border border-libborder text-libmuted rounded-md text-xs font-semibold hover:bg-libcream hover:text-libdark transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 bg-libnavy text-white text-xs font-semibold rounded-md hover:bg-libnavy/90 hover:shadow-sm transition">
                    Simpan Peminjaman
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
