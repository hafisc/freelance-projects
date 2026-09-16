@extends('admin.layouts.admin')

@section('title', 'Edit Perusahaan: ' . $company->name)

@section('content')
<!-- Back Link & Title -->
<div class="mb-8">
    <a href="{{ route('admin.companies.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white hover:bg-slate-50 text-slate-600 hover:text-slate-900 border border-slate-200 rounded-xl text-xs font-bold transition-all duration-150 mb-4">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
    <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Edit Data Perusahaan</h2>
    <p class="text-sm text-slate-500">Perbarui informasi perusahaan: {{ $company->name }}</p>
</div>

<!-- Errors Card -->
@if ($errors->any())
    <div class="mb-6 p-5 bg-rose-50 border border-rose-100 text-rose-800 rounded-3xl shadow-sm">
        <h6 class="font-bold mb-2 flex items-center gap-2 text-sm"><i class="fa-solid fa-circle-xmark text-lg"></i> Terdapat beberapa kesalahan input:</h6>
        <ul class="list-disc pl-5 space-y-1 text-xs font-medium">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Form Card -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 md:p-10">
    <form action="{{ route('admin.companies.update', $company->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Perusahaan <span class="text-rose-500">*</span></label>
                <input type="text" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150" id="name" name="name" value="{{ old('name', $company->name) }}" required>
            </div>
            <div>
                <label for="industry" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Bidang Industri</label>
                <select class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150" id="industry" name="industry">
                    <option value="">-- Pilih Industri --</option>
                    @foreach(['Outsourcing / Jasa Tenaga Kerja', 'Manufaktur / Pabrik', 'Retail / Perdagangan', 'F&B / Restoran', 'Teknologi / IT', 'Logistik / Transportasi', 'Keuangan / Perbankan', 'Kesehatan / Farmasi', 'Pendidikan', 'Konstruksi / Properti', 'Lainnya'] as $ind)
                        <option value="{{ $ind }}" {{ old('industry', $company->industry) == $ind ? 'selected' : '' }}>{{ $ind }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="email" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Email Perusahaan</label>
                <input type="email" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150" id="email" name="email" value="{{ old('email', $company->email) }}" placeholder="contoh@perusahaan.com">
            </div>
            <div>
                <label for="phone" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Telepon Perusahaan</label>
                <input type="text" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150" id="phone" name="phone" value="{{ old('phone', $company->phone) }}">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="website" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Website</label>
                <input type="url" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150" id="website" name="website" value="{{ old('website', $company->website) }}">
            </div>
            <div>
                <label for="logo" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Logo Perusahaan</label>
                @if($company->logo)
                    <div class="flex items-center gap-3 mb-2">
                        <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo" class="h-12 w-12 object-cover rounded-xl border border-slate-200">
                        <span class="text-xs text-slate-400">Logo saat ini</span>
                    </div>
                @endif
                <input type="file" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-primaryBlue" id="logo" name="logo" accept="image/jpeg,image/png,image/webp">
                <div class="text-xs text-slate-400 mt-1">Kosongkan jika tidak ingin mengganti logo.</div>
            </div>
        </div>

        <div>
            <label for="address" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Alamat Perusahaan</label>
            <textarea class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150" id="address" name="address" rows="3">{{ old('address', $company->address) }}</textarea>
        </div>

        <div>
            <label for="description" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Deskripsi Perusahaan</label>
            <textarea class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150" id="description" name="description" rows="4">{{ old('description', $company->description) }}</textarea>
        </div>

        <!-- Contact Person -->
        <div class="pt-4 border-t border-slate-100">
            <h4 class="text-sm font-bold text-slate-700 mb-4 flex items-center gap-2"><i class="fa-solid fa-user-tie text-primaryBlue"></i> Contact Person (PIC)</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="pic_name" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama PIC</label>
                    <input type="text" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150" id="pic_name" name="pic_name" value="{{ old('pic_name', $company->pic_name) }}">
                </div>
                <div>
                    <label for="pic_phone" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">No. HP PIC</label>
                    <input type="text" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150" id="pic_phone" name="pic_phone" value="{{ old('pic_phone', $company->pic_phone) }}">
                </div>
            </div>
        </div>
        
        <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
            <a href="{{ route('admin.companies.index') }}" class="px-6 py-3 bg-slate-50 hover:bg-slate-100 text-slate-600 hover:text-slate-900 rounded-2xl font-bold text-sm transition-all duration-150">Batal</a>
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-primaryBlue hover:bg-blue-700 text-white font-bold rounded-2xl shadow-lg shadow-primaryBlue/20 hover:shadow-xl transition-all duration-150">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
