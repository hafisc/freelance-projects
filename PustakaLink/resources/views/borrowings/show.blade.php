@extends('layouts.app')

@section('page_title', 'Detail Sirkulasi Peminjaman')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    
    <!-- Header -->
    <div class="flex items-center justify-between bg-white p-6 rounded-lg border border-libborder shadow-sm">
        <div>
            <h2 class="text-base font-bold text-libnavy">Rincian Transaksi Peminjaman</h2>
            <p class="text-xs text-libmuted mt-1">Detail data peminjaman buku beserta status kelayakan buku.</p>
        </div>
        <a href="{{ route('borrowings.index') }}" class="inline-flex items-center space-x-1 text-xs font-semibold text-libnavy hover:text-libgold transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Kembali ke Daftar</span>
        </a>
    </div>

    <!-- Layout Grid 2 Kolom -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Kolom Kiri: Status & Informasi Sirkulasi -->
        <div class="md:col-span-1 bg-white rounded-lg border border-libborder shadow-sm p-6 space-y-6 self-start">
            <div class="pb-6 border-b border-libborder text-center">
                <span class="block text-[10px] font-bold text-libmuted uppercase tracking-wider mb-2">Status Transaksi</span>
                @if($borrowing->status === 'returned')
                    <span class="inline-block px-3 py-1 bg-[#E6F4EA] text-libsuccess rounded-full border border-libsuccess/10 text-xs font-bold uppercase tracking-wider shadow-sm">
                        Dikembalikan
                    </span>
                @else
                    <span class="inline-block px-3 py-1 bg-[#FEF3C7] text-[#D97706] rounded-full border border-[#FCD34D]/30 text-xs font-bold uppercase tracking-wider shadow-sm">
                        Sedang Dipinjam
                    </span>
                @endif
            </div>

            <div class="space-y-4">
                <div>
                    <span class="block text-[10px] font-bold text-libmuted uppercase tracking-wider">Tanggal Pinjam</span>
                    <span class="text-xs font-semibold text-libdark block mt-1 font-mono">
                        {{ $borrowing->borrow_date->translatedFormat('d F Y') }}
                    </span>
                </div>
                <div>
                    <span class="block text-[10px] font-bold text-libmuted uppercase tracking-wider">Tanggal Jatuh Tempo</span>
                    <span class="text-xs font-semibold text-libdark block mt-1 font-mono">
                        {{ $borrowing->due_date->translatedFormat('d F Y') }}
                    </span>
                </div>
                <div>
                    <span class="block text-[10px] font-bold text-libmuted uppercase tracking-wider">Tanggal Pengembalian</span>
                    <span class="text-xs font-semibold text-libdark block mt-1 font-mono">
                        {{ $borrowing->return_date ? $borrowing->return_date->translatedFormat('d F Y') : '-' }}
                    </span>
                </div>
                <div>
                    <span class="block text-[10px] font-bold text-libmuted uppercase tracking-wider">Catatan Transaksi</span>
                    <p class="text-xs text-libdark block mt-1 leading-relaxed">{{ $borrowing->notes ?? 'Tidak ada catatan khusus.' }}</p>
                </div>
            </div>

            <!-- Tombol Pengembalian Cepat -->
            @if($borrowing->status === 'borrowed')
                <div class="pt-6 border-t border-libborder">
                    <form action="{{ route('borrowings.return', $borrowing->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengembalikan buku ini?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full inline-flex items-center justify-center space-x-2 py-2.5 bg-libsuccess text-white text-xs font-semibold rounded-md hover:bg-libsuccess/90 transition shadow-sm uppercase tracking-wider">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Selesaikan Pengembalian</span>
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <!-- Kolom Kanan: Peminjam & Buku -->
        <div class="md:col-span-2 space-y-6">
            
            <!-- Card Anggota -->
            <div class="bg-white rounded-lg border border-libborder shadow-sm p-6 space-y-4">
                <div class="flex items-center space-x-3 pb-3 border-b border-libborder">
                    <svg class="w-5 h-5 text-libgold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <h3 class="text-sm font-bold text-libnavy">Identitas Anggota Peminjam</h3>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <span class="block text-[9px] font-bold text-libmuted uppercase tracking-wider">Kode Anggota</span>
                        <span class="text-xs font-semibold text-libnavy block mt-1 font-mono">{{ $borrowing->member->member_code }}</span>
                    </div>
                    <div>
                        <span class="block text-[9px] font-bold text-libmuted uppercase tracking-wider">Nama Lengkap</span>
                        <span class="text-xs font-semibold text-libdark block mt-1">{{ $borrowing->member->name }}</span>
                    </div>
                    <div>
                        <span class="block text-[9px] font-bold text-libmuted uppercase tracking-wider">Jenis Kelamin</span>
                        <span class="text-xs font-semibold text-libdark block mt-1">{{ $borrowing->member->gender }}</span>
                    </div>
                    <div>
                        <span class="block text-[9px] font-bold text-libmuted uppercase tracking-wider">Nomor Telepon</span>
                        <span class="text-xs font-semibold text-libdark block mt-1 font-mono">{{ $borrowing->member->phone ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Card Buku -->
            <div class="bg-white rounded-lg border border-libborder shadow-sm p-6 space-y-4">
                <div class="flex items-center space-x-3 pb-3 border-b border-libborder">
                    <svg class="w-5 h-5 text-libgold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <h3 class="text-sm font-bold text-libnavy">Buku yang Dipinjam</h3>
                </div>
                <div class="space-y-4 divide-y divide-libborder">
                    @foreach($borrowing->borrowingDetails as $detail)
                        <div class="pt-3 first:pt-0 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <span class="block text-[9px] font-bold text-libmuted uppercase tracking-wider">Judul Buku</span>
                                <span class="text-xs font-bold text-libnavy block mt-1">{{ $detail->book->title }}</span>
                            </div>
                            <div>
                                <span class="block text-[9px] font-bold text-libmuted uppercase tracking-wider">Kode Buku</span>
                                <span class="text-xs font-semibold text-libdark block mt-1 font-mono">{{ $detail->book->book_code }}</span>
                            </div>
                            <div>
                                <span class="block text-[9px] font-bold text-libmuted uppercase tracking-wider">Kategori</span>
                                <span class="text-xs font-semibold text-libdark block mt-1">{{ $detail->book->category ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="block text-[9px] font-bold text-libmuted uppercase tracking-wider">Penulis / Pengarang</span>
                                <span class="text-xs font-semibold text-libdark block mt-1">{{ $detail->book->author ?? '-' }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
