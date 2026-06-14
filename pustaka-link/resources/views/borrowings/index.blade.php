@extends('layouts.app')

@section('page_title', 'Peminjaman Aktif')

@section('content')
<div class="space-y-6">
    <!-- Header Aksi -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-lg border border-libborder shadow-sm">
        <div>
            <h2 class="text-base font-bold text-libnavy">Daftar Peminjaman Aktif</h2>
            <p class="text-xs text-libmuted mt-1">Kelola transaksi peminjaman buku yang sedang berlangsung.</p>
        </div>
        <div>
            <a href="{{ route('borrowings.create') }}" class="inline-flex items-center space-x-2 px-4 py-2.5 bg-libnavy text-white text-xs font-semibold rounded-md hover:bg-libnavy/90 hover:shadow-sm transition">
                <svg class="w-4 h-4 text-libgold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Catat Pinjam Buku</span>
            </a>
        </div>
    </div>

    <!-- Pencarian & Tabel -->
    <div class="bg-white rounded-lg border border-libborder shadow-sm overflow-hidden">
        <!-- Filter Bar -->
        <div class="p-6 border-b border-libborder bg-white/5 flex items-center justify-between">
            <form action="{{ route('borrowings.index') }}" method="GET" class="w-full max-w-md">
                <div class="relative">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama anggota atau judul buku..."
                        class="w-full pl-10 pr-4 py-2.5 bg-white border border-libborder rounded-md text-xs text-libdark focus:outline-none focus:border-libgold transition">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-libmuted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </form>
            @if($search)
                <a href="{{ route('borrowings.index') }}" class="text-xs text-libdanger hover:underline font-semibold ml-4">
                    Reset Pencarian
                </a>
            @endif
        </div>

        <!-- Tabel Transaksi -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-libcream border-b border-libborder">
                        <th class="px-6 py-4 text-xs font-bold text-libnavy uppercase tracking-wider">Anggota Peminjam</th>
                        <th class="px-6 py-4 text-xs font-bold text-libnavy uppercase tracking-wider">Buku yang Dipinjam</th>
                        <th class="px-6 py-4 text-xs font-bold text-libnavy uppercase tracking-wider w-36">Tgl Pinjam</th>
                        <th class="px-6 py-4 text-xs font-bold text-libnavy uppercase tracking-wider w-36">Jatuh Tempo</th>
                        <th class="px-6 py-4 text-xs font-bold text-libnavy text-center uppercase tracking-wider w-32">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-libnavy text-center uppercase tracking-wider w-48">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-libborder">
                    @forelse($borrowings as $borrowing)
                        <tr class="hover:bg-libcream/30 transition-colors">
                            <!-- Anggota -->
                            <td class="px-6 py-4">
                                <div class="space-y-0.5">
                                    <span class="text-sm font-bold text-libnavy">{{ $borrowing->member->name }}</span>
                                    <span class="text-[10px] text-libmuted font-mono block">Kode: {{ $borrowing->member->member_code }}</span>
                                </div>
                            </td>
                            <!-- Buku -->
                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    @foreach($borrowing->borrowingDetails as $detail)
                                        <span class="text-xs font-medium text-libdark block">{{ $detail->book->title }}</span>
                                        <span class="text-[9px] text-libmuted font-mono block">Kode Buku: {{ $detail->book->book_code }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <!-- Tanggal Pinjam -->
                            <td class="px-6 py-4 text-xs font-mono text-libdark">
                                {{ $borrowing->borrow_date->translatedFormat('d M Y') }}
                            </td>
                            <!-- Tanggal Jatuh Tempo -->
                            <td class="px-6 py-4 text-xs font-mono text-libdark">
                                @php
                                    $isOverdue = \Carbon\Carbon::now()->startOfDay()->greaterThan($borrowing->due_date);
                                @endphp
                                <span class="{{ $isOverdue ? 'text-libdanger font-bold' : 'text-libdark' }}">
                                    {{ $borrowing->due_date->translatedFormat('d M Y') }}
                                    @if($isOverdue)
                                        <span class="block text-[8px] font-bold text-libdanger uppercase tracking-wider mt-0.5">Terlambat!</span>
                                    @endif
                                </span>
                            </td>
                            <!-- Status -->
                            <td class="px-6 py-4 text-center">
                                <span class="inline-block px-2.5 py-1 text-[10px] font-bold bg-[#FEF3C7] text-[#D97706] rounded-full border border-[#FCD34D]/30 uppercase tracking-wider">
                                    Dipinjam
                                </span>
                            </td>
                            <!-- Aksi -->
                            <td class="px-6 py-4 text-center">
                                <div class="inline-flex items-center space-x-2">
                                    <!-- Detail -->
                                    <a href="{{ route('borrowings.show', $borrowing->id) }}" class="p-2 text-libnavy hover:bg-libcream hover:text-libnavy rounded-md transition" title="Rincian Transaksi">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <!-- Tombol Pengembalian Cepat -->
                                    <form action="{{ route('borrowings.return', $borrowing->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menyelesaikan peminjaman buku untuk {{ $borrowing->member->name }}?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="inline-flex items-center space-x-1 px-3 py-1.5 bg-libsuccess text-white text-[10px] font-bold rounded hover:bg-libsuccess/90 transition shadow-sm uppercase tracking-wider">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>Kembalikan</span>
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>Tidak ada sirkulasi peminjaman aktif saat ini.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginasi -->
        @if($borrowings->hasPages())
            <div class="px-6 py-4 border-t border-libborder bg-white/5">
                {{ $borrowings->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
