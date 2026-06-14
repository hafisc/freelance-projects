@extends('layouts.app')

@section('page_title', 'Ubah Data Anggota')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    
    <!-- Header -->
    <div class="flex items-center justify-between bg-white p-6 rounded-lg border border-libborder shadow-sm">
        <div>
            <h2 class="text-base font-bold text-libnavy">Ubah Data Anggota</h2>
            <p class="text-xs text-libmuted mt-1">Perbarui informasi profil anggota perpustakaan yang aktif.</p>
        </div>
        <a href="{{ route('members.index') }}" class="inline-flex items-center space-x-1 text-xs font-semibold text-libnavy hover:text-libgold transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Card Form -->
    <div class="bg-white rounded-lg border border-libborder shadow-sm p-6 md:p-8">
        <form action="{{ route('members.update', $member->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Baris 1: Kode & Nama -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Kode Anggota -->
                <div>
                    <label for="member_code" class="block text-xs font-bold text-libdark uppercase tracking-wider mb-2">Kode Anggota <span class="text-libdanger">*</span></label>
                    <input type="text" name="member_code" id="member_code" value="{{ old('member_code', $member->member_code) }}" required
                        class="w-full px-4 py-2.5 bg-white border @error('member_code') border-libdanger @else border-libborder @enderror rounded-md text-xs text-libdark font-semibold focus:outline-none focus:border-libgold font-mono transition"
                        placeholder="contoh: AGT-0001">
                    @error('member_code')
                        <p class="text-xs text-libdanger mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-xs font-bold text-libdark uppercase tracking-wider mb-2">Nama Lengkap <span class="text-libdanger">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $member->name) }}" required
                        class="w-full px-4 py-2.5 bg-white border @error('name') border-libdanger @else border-libborder @enderror rounded-md text-xs text-libdark focus:outline-none focus:border-libgold transition"
                        placeholder="Masukkan nama lengkap">
                    @error('name')
                        <p class="text-xs text-libdanger mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Baris 2: Jenis Kelamin & Telepon -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Jenis Kelamin -->
                <div>
                    <label for="gender" class="block text-xs font-bold text-libdark uppercase tracking-wider mb-2">Jenis Kelamin <span class="text-libdanger">*</span></label>
                    <select name="gender" id="gender" required
                        class="w-full px-4 py-2.5 bg-white border @error('gender') border-libdanger @else border-libborder @enderror rounded-md text-xs text-libdark focus:outline-none focus:border-libgold transition">
                        <option value="" disabled>-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-laki" {{ old('gender', $member->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('gender', $member->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('gender')
                        <p class="text-xs text-libdanger mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No Telepon -->
                <div>
                    <label for="phone" class="block text-xs font-bold text-libdark uppercase tracking-wider mb-2">Nomor Telepon</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $member->phone) }}"
                        class="w-full px-4 py-2.5 bg-white border @error('phone') border-libdanger @else border-libborder @enderror rounded-md text-xs text-libdark focus:outline-none focus:border-libgold transition"
                        placeholder="contoh: 08123456789">
                    @error('phone')
                        <p class="text-xs text-libdanger mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Baris 3: Alamat -->
            <div>
                <label for="address" class="block text-xs font-bold text-libdark uppercase tracking-wider mb-2">Alamat Tinggal</label>
                <textarea name="address" id="address" rows="3"
                    class="w-full px-4 py-2.5 bg-white border @error('address') border-libdanger @else border-libborder @enderror rounded-md text-xs text-libdark focus:outline-none focus:border-libgold transition"
                    placeholder="Alamat lengkap anggota perpustakaan...">{{ old('address', $member->address) }}</textarea>
                @error('address')
                    <p class="text-xs text-libdanger mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-libborder">
                <a href="{{ route('members.index') }}" class="px-4 py-2.5 border border-libborder text-libmuted rounded-md text-xs font-semibold hover:bg-libcream hover:text-libdark transition">
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
