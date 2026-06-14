@extends('layouts.app')

@section('page_title', 'Riwayat Sirkulasi Peminjaman')

@section('content')
<div class="space-y-6">
    <!-- Header Aksi -->
    <div class="bg-white p-6 rounded-lg border border-libborder shadow-sm">
        <h2 class="text-base font-bold text-libnavy">Riwayat Transaksi Peminjaman</h2>
        <p class="text-xs text-libmuted mt-1">Daftar lengkap seluruh sirkulasi peminjaman buku (aktif maupun selesai).</p>
    </div>

    <!-- Pencarian & Tabel -->
    <div class="bg-white rounded-lg border border-libborder shadow-sm overflow-hidden">
        <!-- Filter Bar -->
        <div class="p-6 border-b border-libborder bg-white/5 flex items-center justify-between">
            <form action="{{ route('borrowings.history') }}" method="GET" class="w-full max-w-md">
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
                <a href="{{ route('borrowings.history') }}" class="text-xs text-libdanger hover:underline font-semibold ml-4">
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
                        <th class="px-6 py-4 text-xs font-bold text-libnavy uppercase tracking-wider w-32">Tgl Pinjam</th>
                        <th class="px-6 py-4 text-xs font-bold text-libnavy uppercase tracking-wider w-32">Jatuh Tempo</th>
                        <th class="px-6 py-4 text-xs font-bold text-libnavy uppercase tracking-wider w-32">Tgl Kembali</th>
                        <th class="px-6 py-4 text-xs font-bold text-libnavy text-center uppercase tracking-wider w-32">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-libnavy text-center uppercase tracking-wider w-20">Detail</th>
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
                                {{ $borrowing->due_date->translatedFormat('d M Y') }}
                            </td>
                            <!-- Tanggal Kembali -->
                            <td class="px-6 py-4 text-xs font-mono text-libdark">
                                {{ $borrowing->return_date ? $borrowing->return_date->translatedFormat('d M Y') : '-' }}
                            </td>
                            <!-- Status -->
                            <td class="px-6 py-4 text-center">
                                @if($borrowing->status === 'returned')
                                    <span class="inline-block px-2.5 py-1 text-[10px] font-bold bg-[#E6F4EA] text-libsuccess rounded-full border border-libsuccess/10 uppercase tracking-wider">
                                        Selesai
                                    </span>
                                @else
                                    <span class="inline-block px-2.5 py-1 text-[10px] font-bold bg-[#FEF3C7] text-[#D97706] rounded-full border border-[#FCD34D]/30 uppercase tracking-wider">
                                        Dipinjam
                                    </span>
                                @endif
                            </td>
                            <!-- Aksi -->
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('borrowings.show', $borrowing->id) }}" class="p-2 text-libnavy hover:bg-libcream hover:text-libnavy rounded-md inline-block transition" title="Rincian Transaksi">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-xs text-libmuted">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <svg class="w-8 h-8 text-libmuted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Belum ada riwayat transaksi peminjaman buku.</span>
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
