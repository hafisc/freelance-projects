@extends('layouts.app')

@section('title', 'Ubah Data Mahasiswa | SI-PBM')
@section('page_title', 'Ubah Data Mahasiswa')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Form Card -->
    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
        <h3 class="text-xl font-extrabold text-[#1b3f75] flex items-center gap-2 mb-6">
            <i class="bi bi-pencil-square text-blue-500"></i> Ubah Profil Mahasiswa (Operator)
        </h3>

        <form action="{{ route('update-mahasiswa', $mahasiswa->nim) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nomor Induk Mahasiswa (NIM)</label>
                    <input type="text" name="nim" value="{{ $mahasiswa->nim }}" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ $mahasiswa->nama }}" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Program Studi (Prodi)</label>
                    <input type="text" name="prodi" value="{{ $mahasiswa->prodi }}" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tahun Masuk (Angkatan)</label>
                    <input type="number" name="tahun_masuk" value="{{ $mahasiswa->tahun_masuk }}" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('data-mahasiswa') }}" 
                    class="flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-2.5 px-5 rounded-xl transition-all duration-200 text-sm">
                    Batal
                </a>
                <button type="submit" 
                    class="flex items-center gap-2 bg-[#204a82] hover:bg-[#193f72] text-white font-semibold py-2.5 px-5 rounded-xl shadow-md transition-all duration-200 text-sm">
                    <i class="bi bi-check-circle"></i> Perbarui Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
