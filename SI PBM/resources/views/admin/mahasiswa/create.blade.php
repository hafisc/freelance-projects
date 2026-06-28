@extends('layouts.app')

@section('title', 'Daftarkan Mahasiswa | SI-PBM')
@section('page_title', 'Daftar Mahasiswa Baru')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Form Card -->
    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
        <h3 class="text-xl font-extrabold text-[#1b3f75] flex items-center gap-2 mb-2">
            <i class="bi bi-person-plus text-blue-500"></i> Form Registrasi Mahasiswa Baru
        </h3>
        <p class="text-slate-400 text-xs mb-8">Silakan isi formulir di bawah ini dengan lengkap. Setelah mahasiswa didaftarkan, akun login otomatis akan aktif dengan password default yang sama dengan NIM.</p>

        <form action="{{ route('store-mahasiswa') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nomor Induk Mahasiswa (NIM)</label>
                    <input type="text" name="nim" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" placeholder="Contoh: 2024002" required autofocus>
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap</label>
                    <input type="text" name="nama" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" placeholder="Nama lengkap sesuai KTP" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Program Studi (Prodi)</label>
                    <input type="text" name="prodi" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" placeholder="Contoh: Teknik Informatika" required>
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tahun Masuk (Angkatan)</label>
                    <input type="number" name="tahun_masuk" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" placeholder="Contoh: 2024" required>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('data-mahasiswa') }}" 
                    class="flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-2.5 px-5 rounded-xl transition-all duration-200 text-sm">
                    Batal
                </a>
                <button type="submit" 
                    class="flex items-center gap-2 bg-[#204a82] hover:bg-[#193f72] text-white font-semibold py-2.5 px-5 rounded-xl shadow-md transition-all duration-200 text-sm">
                    <i class="bi bi-check-circle"></i> Simpan Data &amp; Buat Akun
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
