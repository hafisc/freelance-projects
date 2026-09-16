@extends('admin.layouts.admin')

@section('title', 'Tambah Lowongan Kerja Baru')

@section('content')
<!-- Back Link & Title -->
<div class="mb-8">
    <a href="{{ route('admin.jobs.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white hover:bg-slate-50 text-slate-600 hover:text-slate-900 border border-slate-200 rounded-xl text-xs font-bold transition-all duration-150 mb-4">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
    <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Tambah Lowongan Kerja Baru</h2>
    <p class="text-sm text-slate-500">Buat postingan lowongan kerja baru untuk PT. Gloria Jasa Mandiri.</p>
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
    <form action="{{ route('admin.jobs.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="title" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Posisi Pekerjaan <span class="text-rose-500">*</span></label>
                <input type="text" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150 @error('title') border-rose-300 @enderror" id="title" name="title" value="{{ old('title') }}" placeholder="Contoh: Staff Administrasi" required>
            </div>
            
            <div>
                <label for="company_id" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Perusahaan <span class="text-rose-500">*</span></label>
                <select class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150" id="company_id" name="company_id" onchange="updateCompanyName(this)">
                    <option value="">-- Pilih Perusahaan --</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" data-name="{{ $company->name }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>
                <input type="hidden" name="company_name" id="company_name" value="{{ old('company_name', 'PT. Gloria Jasa Mandiri') }}">
                @if($companies->isEmpty())
                    <div class="text-xs text-amber-500 mt-1 flex items-center gap-1">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        Belum ada perusahaan. <a href="{{ route('admin.companies.create') }}" class="underline font-semibold">Tambah perusahaan terlebih dahulu.</a>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="location" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Lokasi Penempatan <span class="text-rose-500">*</span></label>
                <input type="text" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150 @error('location') border-rose-300 @enderror" id="location" name="location" value="{{ old('location') }}" placeholder="Contoh: Jakarta Barat" required>
            </div>
            
            <div>
                <label for="deadline" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Batas Akhir Pendaftaran</label>
                <input type="date" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150" id="deadline" name="deadline" value="{{ old('deadline') }}">
            </div>
            
            <div>
                <label for="status" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status Tampil <span class="text-rose-500">*</span></label>
                <select class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150" id="status" name="status" required>
                    <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif (Tampil di Mobile)</option>
                    <option value="Nonaktif" {{ old('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif (Sembunyikan)</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="job_type" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tipe Pekerjaan</label>
                <select class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150" id="job_type" name="job_type">
                    <option value="Full-time" {{ old('job_type') == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                    <option value="Part-time" {{ old('job_type') == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                    <option value="Kontrak" {{ old('job_type') == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                    <option value="Magang" {{ old('job_type') == 'Magang' ? 'selected' : '' }}>Magang</option>
                </select>
            </div>

            <div>
                <label for="category" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kategori Pekerjaan</label>
                <select class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150" id="category" name="category">
                    <option value="Administrasi" {{ old('category') == 'Administrasi' ? 'selected' : '' }}>Administrasi</option>
                    <option value="Operasional/Lapangan" {{ old('category') == 'Operasional/Lapangan' ? 'selected' : '' }}>Operasional / Lapangan</option>
                    <option value="IT/Teknis" {{ old('category') == 'IT/Teknis' ? 'selected' : '' }}>IT / Teknis</option>
                    <option value="Sales/Marketing" {{ old('category') == 'Sales/Marketing' ? 'selected' : '' }}>Sales / Marketing</option>
                    <option value="F&B/Retail" {{ old('category') == 'F&B/Retail' ? 'selected' : '' }}>F&B / Retail</option>
                    <option value="Teknologi/IT" {{ old('category') == 'Teknologi/IT' ? 'selected' : '' }}>Teknologi / IT</option>
                </select>
            </div>

            <div>
                <label for="experience" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Minimal Pengalaman</label>
                <select class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150" id="experience" name="experience">
                    <option value="Fresh Graduate" {{ old('experience') == 'Fresh Graduate' ? 'selected' : '' }}>Fresh Graduate</option>
                    <option value="1-3 Tahun" {{ old('experience') == '1-3 Tahun' ? 'selected' : '' }}>1 - 3 Tahun</option>
                    <option value=">3 Tahun" {{ old('experience') == '>3 Tahun' ? 'selected' : '' }}>> 3 Tahun</option>
                </select>
            </div>
        </div>

        <!-- Salary Section -->
        <div class="pt-4 border-t border-slate-100">
            <h4 class="text-sm font-bold text-slate-700 mb-4 flex items-center gap-2"><i class="fa-solid fa-money-bill-wave text-emerald-500"></i> Informasi Gaji</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="salary_category" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kategori Gaji</label>
                    <select class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150" id="salary_category" name="salary_category">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="< Rp 3 Juta" {{ old('salary_category') == '< Rp 3 Juta' ? 'selected' : '' }}>< Rp 3 Juta</option>
                        <option value="Rp 3-5 Juta" {{ old('salary_category') == 'Rp 3-5 Juta' ? 'selected' : '' }}>Rp 3 - 5 Juta</option>
                        <option value="Rp 5-8 Juta" {{ old('salary_category') == 'Rp 5-8 Juta' ? 'selected' : '' }}>Rp 5 - 8 Juta</option>
                        <option value="Rp 8-15 Juta" {{ old('salary_category') == 'Rp 8-15 Juta' ? 'selected' : '' }}>Rp 8 - 15 Juta</option>
                        <option value="> Rp 15 Juta" {{ old('salary_category') == '> Rp 15 Juta' ? 'selected' : '' }}>> Rp 15 Juta</option>
                        <option value="Negosiasi" {{ old('salary_category') == 'Negosiasi' ? 'selected' : '' }}>Negosiasi</option>
                    </select>
                </div>
                <div>
                    <label for="salary_min" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Gaji Minimum (Rp)</label>
                    <input type="number" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150" id="salary_min" name="salary_min" value="{{ old('salary_min') }}" placeholder="Contoh: 3000000" min="0">
                </div>
                <div>
                    <label for="salary_max" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Gaji Maksimum (Rp)</label>
                    <input type="number" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150" id="salary_max" name="salary_max" value="{{ old('salary_max') }}" placeholder="Contoh: 5000000" min="0">
                </div>
            </div>
            <div class="text-xs text-slate-400 mt-2 flex items-center gap-1"><i class="fa-solid fa-circle-info"></i> Isi gaji minimum dan maksimum untuk informasi rentang. Kosongkan jika pilih "Negosiasi".</div>
        </div>
        
        <div>
            <label for="qualification" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Persyaratan Kualifikasi <span class="text-rose-500">*</span></label>
            <textarea class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150 @error('qualification') border-rose-300 @enderror" id="qualification" name="qualification" rows="6" placeholder="Masukkan poin-poin kualifikasi (pisahkan per baris)..." required>{{ old('qualification') }}</textarea>
            <div class="text-xs text-slate-400 mt-2 flex items-center gap-1"><i class="fa-solid fa-circle-info"></i> Gunakan baris baru (Enter) untuk menulis poin kualifikasi berikutnya.</div>
        </div>
        
        <div>
            <label for="description" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Deskripsi Pekerjaan <span class="text-rose-500">*</span></label>
            <textarea class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150 @error('description') border-rose-300 @enderror" id="description" name="description" rows="6" placeholder="Deskripsikan peran, tugas, dan tanggung jawab posisi pekerjaan..." required>{{ old('description') }}</textarea>
        </div>
        
        <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
            <a href="{{ route('admin.jobs.index') }}" class="px-6 py-3 bg-slate-50 hover:bg-slate-100 text-slate-600 hover:text-slate-900 rounded-2xl font-bold text-sm transition-all duration-150">
                Batal
            </a>
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-primaryBlue hover:bg-blue-700 text-white font-bold rounded-2xl shadow-lg shadow-primaryBlue/20 hover:shadow-xl transition-all duration-150">
                <i class="fa-solid fa-cloud-arrow-up"></i> Publikasikan Lowongan
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
function updateCompanyName(select) {
    const selected = select.options[select.selectedIndex];
    const name = selected.dataset.name || 'PT. Gloria Jasa Mandiri';
    document.getElementById('company_name').value = name;
}
// Init on load
window.addEventListener('DOMContentLoaded', function() {
    const sel = document.getElementById('company_id');
    if (sel && sel.value) updateCompanyName(sel);
});
</script>
@endsection
