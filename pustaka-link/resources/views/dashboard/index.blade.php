@extends('layouts.app')

@section('page_title', 'Dashboard Utama')

@section('content')
<div class="space-y-8">
    
    <!-- Ucapan Selamat Datang -->
    <div class="bg-white p-6 md:p-8 rounded-lg border border-libborder shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-lg md:text-xl font-bold text-libnavy">Selamat Datang, {{ Auth::user()->name }}!</h2>
            <p class="text-xs text-libmuted mt-1">Anda masuk sebagai <strong class="text-libgold">Admin/Petugas Perpustakaan</strong>. Kelola data perpustakaan dengan menu navigasi di sisi kiri.</p>
        </div>
        <div class="flex items-center space-x-2 text-xs font-semibold text-libnavy bg-libcream px-4 py-2 rounded-md border border-libgold/20 font-mono">
            <span>Sesi Aktif IP: {{ request()->ip() }}</span>
        </div>
    </div>

    <!-- Grid Kartu Statistik -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- 1. Total Buku -->
        <div class="bg-white p-6 rounded-lg border border-libborder shadow-sm flex items-center justify-between hover:shadow-md transition-all duration-300 transform hover:-translate-y-0.5">
            <div class="space-y-1">
                <span class="block text-[10px] font-bold text-libmuted uppercase tracking-wider">Total Judul Buku</span>
                <span class="block text-2xl font-bold text-libnavy">{{ $totalBooks }}</span>
                <span class="block text-[10px] text-libmuted">Koleksi terdaftar</span>
            </div>
            <div class="p-3 bg-libcream rounded-full border border-libgold/10 text-libnavy">
                <svg class="w-6 h-6 text-libnavy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
        </div>

        <!-- 2. Total Anggota -->
        <div class="bg-white p-6 rounded-lg border border-libborder shadow-sm flex items-center justify-between hover:shadow-md transition-all duration-300 transform hover:-translate-y-0.5">
            <div class="space-y-1">
                <span class="block text-[10px] font-bold text-libmuted uppercase tracking-wider">Total Anggota</span>
                <span class="block text-2xl font-bold text-libnavy">{{ $totalMembers }}</span>
                <span class="block text-[10px] text-libmuted">Pembaca aktif</span>
            </div>
            <div class="p-3 bg-libcream rounded-full border border-libgold/10 text-libnavy">
                <svg class="w-6 h-6 text-libnavy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>

        <!-- 3. Peminjaman Aktif -->
        <div class="bg-white p-6 rounded-lg border border-libborder shadow-sm flex items-center justify-between hover:shadow-md transition-all duration-300 transform hover:-translate-y-0.5">
            <div class="space-y-1">
                <span class="block text-[10px] font-bold text-libmuted uppercase tracking-wider">Peminjaman Aktif</span>
                <span class="block text-2xl font-bold text-libnavy">{{ $activeBorrowings }}</span>
                <span class="block text-[10px] text-[#D97706] font-semibold">Sedang dipinjam</span>
            </div>
            <div class="p-3 bg-libcream rounded-full border border-libgold/10 text-libnavy">
                <svg class="w-6 h-6 text-libnavy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>

        <!-- 4. Buku Tersedia -->
        <div class="bg-white p-6 rounded-lg border border-libborder shadow-sm flex items-center justify-between hover:shadow-md transition-all duration-300 transform hover:-translate-y-0.5">
            <div class="space-y-1">
                <span class="block text-[10px] font-bold text-libmuted uppercase tracking-wider">Stok Buku Tersedia</span>
                <span class="block text-2xl font-bold text-libnavy">{{ $availableBooks }}</span>
                <span class="block text-[10px] text-libsuccess font-semibold">Siap sirkulasi</span>
            </div>
            <div class="p-3 bg-libcream rounded-full border border-libgold/10 text-libnavy">
                <svg class="w-6 h-6 text-libnavy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01m-.01 4h.01"></path>
                </svg>
            </div>
        </div>

    </div>

    <!-- Panel Sirkulasi Terbaru -->
    <div class="bg-white rounded-lg border border-libborder shadow-sm overflow-hidden">
        
        <div class="p-6 border-b border-libborder bg-white/5 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-libnavy">Sirkulasi Transaksi Terbaru</h3>
                <p class="text-xs text-libmuted mt-1">5 transaksi peminjaman buku terakhir yang dicatat ke sistem.</p>
            </div>
            <a href="{{ route('borrowings.history') }}" class="text-xs font-semibold text-libgold hover:underline">
                Lihat Semua Riwayat
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-libcream border-b border-libborder">
                        <th class="px-6 py-4 text-xs font-bold text-libnavy uppercase tracking-wider">Anggota Peminjam</th>
                        <th class="px-6 py-4 text-xs font-bold text-libnavy uppercase tracking-wider">Buku yang Dipinjam</th>
                        <th class="px-6 py-4 text-xs font-bold text-libnavy uppercase tracking-wider w-36">Tgl Pinjam</th>
                        <th class="px-6 py-4 text-xs font-bold text-libnavy uppercase tracking-wider w-36">Jatuh Tempo</th>
                        <th class="px-6 py-4 text-xs font-bold text-libnavy text-center uppercase tracking-wider w-32">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-libborder">
                    @forelse($latestBorrowings as $borrowing)
                        <tr class="hover:bg-libcream/20 transition-colors">
                            <td class="px-6 py-4">
                                <div class="space-y-0.5">
                                    <span class="text-xs font-bold text-libnavy block">{{ $borrowing->member->name }}</span>
                                    <span class="text-[9px] text-libmuted font-mono block">Kode: {{ $borrowing->member->member_code }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-0.5">
                                    @foreach($borrowing->borrowingDetails as $detail)
                                        <span class="text-xs text-libdark block font-medium">{{ $detail->book->title }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 text-xs font-mono text-libdark">
                                {{ $borrowing->borrow_date->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-xs font-mono text-libdark">
                                {{ $borrowing->due_date->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($borrowing->status === 'returned')
                                    <span class="inline-block px-2.5 py-0.5 text-[9px] font-bold bg-[#E6F4EA] text-libsuccess rounded-full border border-libsuccess/10 uppercase tracking-wider">
                                        Selesai
                                    </span>
                                @else
                                    <span class="inline-block px-2.5 py-0.5 text-[9px] font-bold bg-[#FEF3C7] text-[#D97706] rounded-full border border-[#FCD34D]/30 uppercase tracking-wider">
                                        Dipinjam
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-xs text-libmuted">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <svg class="w-8 h-8 text-libmuted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    <span>Belum ada sirkulasi transaksi perpustakaan terbaru.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>
@endsection
