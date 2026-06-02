@extends('layouts.app')

@section('page_title', 'Profil Detail Anggota')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex items-center justify-between bg-white p-6 rounded-lg border border-libborder shadow-sm">
        <div>
            <h2 class="text-base font-bold text-libnavy">Profil Anggota Perpustakaan</h2>
            <p class="text-xs text-libmuted mt-1">Informasi lengkap tentang data pribadi dan riwayat peminjaman.</p>
        </div>
        <a href="{{ route('members.index') }}" class="inline-flex items-center space-x-1 text-xs font-semibold text-libnavy hover:text-libgold transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Kembali ke Daftar</span>
        </a>
    </div>

    <!-- Layout Grid 2 Kolom -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Kolom Kiri: Profil Pribadi -->
        <div class="lg:col-span-1 bg-white rounded-lg border border-libborder shadow-sm p-6 space-y-6 self-start">
            <div class="text-center pb-6 border-b border-libborder">
                <div class="w-20 h-20 rounded-full bg-libcream border border-libgold/30 flex items-center justify-center text-libnavy font-bold text-2xl mx-auto shadow-sm">
                    {{ strtoupper(substr($member->name, 0, 1)) }}
                </div>
                <h3 class="text-base font-bold text-libnavy mt-4">{{ $member->name }}</h3>
                <span class="inline-block mt-1.5 px-3 py-1 bg-libcream text-libnavy font-semibold text-[10px] uppercase tracking-wider rounded-full border border-libgold/20 font-mono">
                    {{ $member->member_code }}
                </span>
            </div>

            <div class="space-y-4">
                <div>
                    <span class="block text-[10px] font-bold text-libmuted uppercase tracking-wider">Jenis Kelamin</span>
                    <span class="text-xs font-semibold text-libdark block mt-1">{{ $member->gender }}</span>
                </div>
                <div>
                    <span class="block text-[10px] font-bold text-libmuted uppercase tracking-wider">Nomor Telepon</span>
                    <span class="text-xs font-semibold text-libdark block mt-1 font-mono">{{ $member->phone ?? '-' }}</span>
                </div>
                <div>
                    <span class="block text-[10px] font-bold text-libmuted uppercase tracking-wider">Alamat Tinggal</span>
                    <span class="text-xs text-libdark block mt-1 leading-relaxed">{{ $member->address ?? '-' }}</span>
                </div>
                <div>
                    <span class="block text-[10px] font-bold text-libmuted uppercase tracking-wider">Terdaftar Sejak</span>
                    <span class="text-xs text-libdark block mt-1 font-mono">{{ $member->created_at->translatedFormat('d F Y H:i') }}</span>
                </div>
            </div>

            <div class="pt-6 border-t border-libborder flex justify-stretch">
                <a href="{{ route('members.edit', $member->id) }}" class="flex-1 text-center py-2 border border-libgold text-libgold rounded-md text-xs font-semibold hover:bg-libcream transition">
                    Ubah Data Profil
                </a>
            </div>
        </div>

        <!-- Kolom Kanan: Riwayat Peminjaman Buku -->
        <div class="lg:col-span-2 bg-white rounded-lg border border-libborder shadow-sm overflow-hidden flex flex-col">
            <div class="p-6 border-b border-libborder bg-white/5">
                <h3 class="text-sm font-bold text-libnavy">Riwayat Transaksi Peminjaman Buku</h3>
                <p class="text-xs text-libmuted mt-1">Daftar buku-buku yang sedang dipinjam atau pernah dipinjam oleh anggota ini.</p>
            </div>

            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-libcream border-b border-libborder">
                            <th class="px-6 py-3.5 text-xs font-bold text-libnavy uppercase tracking-wider">Buku</th>
                            <th class="px-6 py-3.5 text-xs font-bold text-libnavy uppercase tracking-wider w-32">Tgl Pinjam</th>
                            <th class="px-6 py-3.5 text-xs font-bold text-libnavy uppercase tracking-wider w-32">Jatuh Tempo</th>
                            <th class="px-6 py-3.5 text-xs font-bold text-libnavy uppercase tracking-wider w-32">Tgl Kembali</th>
                            <th class="px-6 py-3.5 text-xs font-bold text-libnavy text-center uppercase tracking-wider w-32">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-libborder">
                        @forelse($member->borrowings as $borrowing)
                            <tr class="hover:bg-libcream/20 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        @foreach($borrowing->borrowingDetails as $detail)
                                            <span class="text-xs font-bold text-libnavy block">{{ $detail->book->title }}</span>
                                            <span class="text-[10px] text-libmuted font-mono block">Kode Buku: {{ $detail->book->book_code }}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-xs font-mono text-libdark">
                                    {{ $borrowing->borrow_date->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-xs font-mono text-libdark">
                                    {{ $borrowing->due_date->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-xs font-mono text-libdark">
                                    {{ $borrowing->return_date ? $borrowing->return_date->translatedFormat('d M Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($borrowing->status === 'returned')
                                        <span class="inline-block px-2.5 py-1 text-[10px] font-bold bg-[#E6F4EA] text-libsuccess rounded-full border border-libsuccess/10 uppercase tracking-wider">
                                            Dikembalikan
                                        </span>
                                    @else
                                        <span class="inline-block px-2.5 py-1 text-[10px] font-bold bg-[#FEF3C7] text-[#D97706] rounded-full border border-[#FCD34D]/30 uppercase tracking-wider">
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
                                        <span>Anggota ini belum memiliki riwayat peminjaman buku.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
