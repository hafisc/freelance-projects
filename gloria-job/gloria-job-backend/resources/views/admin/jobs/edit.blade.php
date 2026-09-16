@extends('admin.layouts.admin')

@section('title', 'Edit Lowongan Kerja')

@section('content')
<!-- Back Link & Title -->
<div class="mb-8">
    <a href="{{ route('admin.jobs.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white hover:bg-slate-50 text-slate-600 hover:text-slate-900 border border-slate-200 rounded-xl text-xs font-bold transition-all duration-150 mb-4">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
    <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Edit Lowongan Kerja</h2>
    <p class="text-sm text-slate-500">Ubah data postingan lowongan kerja PT. Gloria Jasa Mandiri.</p>
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
    <form action="{{ route('admin.jobs.update', $job->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="title" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Posisi Pekerjaan <span class="text-rose-500">*</span></label>
                <input type="text" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150 @error('title') border-rose-300 @enderror" id="title" name="title" value="{{ old('title', $job->title) }}" required>
            </div>
            
            <div>
                <label for="company_id" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Perusahaan <span class="text-rose-500">*</span></label>
                <select class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150" id="company_id" name="company_id" onchange="updateCompanyName(this)">
                    <option value="">-- Pilih Perusahaan --</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" data-name="{{ $company->name }}" {{ old('company_id', $job->company_id) == $company->id ? 'selected' : '' }}>
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>
                <input type="hidden" name="company_name" id="company_name" value="{{ old('company_name', $job->company_name) }}">
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="location" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Lokasi Penempatan <span class="text-rose-500">*</span></label>
                <input type="text" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150" id="location" name="location" value="{{ old('location', $job->location) }}" required>
            </div>
            
            <div>
                <label for="deadline" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Batas Akhir Pendaftaran</label>
                <input type="date" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150" id="deadline" name="deadline" value="{{ old('deadline', $job->deadline) }}">
            </div>
            
            <div>
                <label for="status" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status Tampil</label>
                <select class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150" id="status" name="status" required>
                    <option value="Aktif" {{ old('status', $job->status) == 'Aktif' ? 'selected' : '' }}>Aktif (Tampil di Mobile)</option>
                    <option value="Nonaktif" {{ old('status', $job->status) == 'Nonaktif' ? 'selected' : '' }}>Nonaktif (Sembunyikan)</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="job_type" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tipe Pekerjaan</label>
                <select class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150" id="job_type" name="job_type">
                    <option value="Full-time" {{ old('job_type', $job->job_type) == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                    <option value="Part-time" {{ old('job_type', $job->job_type) == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                    <option value="Kontrak" {{ old('job_type', $job->job_type) == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                    <option value="Magang" {{ old('job_type', $job->job_type) == 'Magang' ? 'selected' : '' }}>Magang</option>
                </select>
            </div>

            <div>
                <label for="category" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kategori Pekerjaan</label>
                <select class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150" id="category" name="category">
                    @foreach(['Administrasi','Operasional/Lapangan','IT/Teknis','Sales/Marketing','F&B/Retail','Teknologi/IT'] as $cat)
                        <option value="{{ $cat }}" {{ old('category', $job->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="experience" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Minimal Pengalaman</label>
                <select class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150" id="experience" name="experience">
                    <option value="Fresh Graduate" {{ old('experience', $job->experience) == 'Fresh Graduate' ? 'selected' : '' }}>Fresh Graduate</option>
                    <option value="1-3 Tahun" {{ old('experience', $job->experience) == '1-3 Tahun' ? 'selected' : '' }}>1 - 3 Tahun</option>
                    <option value=">3 Tahun" {{ old('experience', $job->experience) == '>3 Tahun' ? 'selected' : '' }}>> 3 Tahun</option>
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
                        @foreach(['< Rp 3 Juta','Rp 3-5 Juta','Rp 5-8 Juta','Rp 8-15 Juta','> Rp 15 Juta','Negosiasi'] as $sc)
                            <option value="{{ $sc }}" {{ old('salary_category', $job->salary_category) == $sc ? 'selected' : '' }}>{{ $sc }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="salary_min" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Gaji Minimum (Rp)</label>
                    <input type="number" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150" id="salary_min" name="salary_min" value="{{ old('salary_min', $job->salary_min) }}" min="0">
                </div>
                <div>
                    <label for="salary_max" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Gaji Maksimum (Rp)</label>
                    <input type="number" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150" id="salary_max" name="salary_max" value="{{ old('salary_max', $job->salary_max) }}" min="0">
                </div>
            </div>
        </div>
        
        <div>
            <label for="qualification" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Persyaratan Kualifikasi <span class="text-rose-500">*</span></label>
            <textarea class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150" id="qualification" name="qualification" rows="6" required>{{ old('qualification', $job->qualification) }}</textarea>
            <div class="text-xs text-slate-400 mt-2 flex items-center gap-1"><i class="fa-solid fa-circle-info"></i> Gunakan baris baru untuk menulis poin kualifikasi berikutnya.</div>
        </div>
        
        <div>
            <label for="description" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Deskripsi Pekerjaan <span class="text-rose-500">*</span></label>
            <textarea class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150" id="description" name="description" rows="6" required>{{ old('description', $job->description) }}</textarea>
        </div>
        
        <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
            <a href="{{ route('admin.jobs.index') }}" class="px-6 py-3 bg-slate-50 hover:bg-slate-100 text-slate-600 hover:text-slate-900 rounded-2xl font-bold text-sm transition-all duration-150">
                Batal
            </a>
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-primaryBlue hover:bg-blue-700 text-white font-bold rounded-2xl shadow-lg shadow-primaryBlue/20 hover:shadow-xl transition-all duration-150">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
function updateCompanyName(select) {
    const selected = select.options[select.selectedIndex];
    document.getElementById('company_name').value = selected.dataset.name || '';
}
window.addEventListener('DOMContentLoaded', function() {
    const sel = document.getElementById('company_id');
    if (sel && sel.value) updateCompanyName(sel);
});
</script>
@endsection
