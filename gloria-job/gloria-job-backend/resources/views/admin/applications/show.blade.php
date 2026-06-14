@extends('admin.layouts.admin')

@section('title', 'Review Lamaran Pekerjaan')

@section('content')
<!-- Back Link & Title -->
<div class="mb-8">
    <a href="{{ route('admin.applications.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white hover:bg-slate-50 text-slate-600 hover:text-slate-900 border border-slate-200 rounded-xl text-xs font-bold transition-all duration-150 mb-4">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
    <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Review Lamaran Pekerjaan</h2>
    <p class="text-sm text-slate-500">Tinjau kesesuaian profil pelamar dan perbarui status lamarannya.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Kiri: Detail Pelamar & Info Lowongan -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Detail Pelamar -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 md:p-8">
            <h5 class="text-base font-bold text-primaryBlue border-b border-slate-100 pb-4 mb-6 flex items-center gap-2">
                <i class="fa-solid fa-user-tie text-lg"></i> Data Profil Pelamar
            </h5>
            
            <div class="space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-2">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Nama Lengkap</span>
                    <span class="sm:col-span-3 text-sm font-extrabold text-slate-800">{{ $application->full_name }}</span>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-2">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Email</span>
                    <span class="sm:col-span-3 text-sm text-slate-700 font-medium">{{ $application->email }}</span>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-2">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Nomor HP</span>
                    <span class="sm:col-span-3 text-sm text-slate-800 font-semibold">{{ $application->phone }}</span>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-2">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Alamat Domisili</span>
                    <span class="sm:col-span-3 text-sm text-slate-600 leading-relaxed" style="white-space: pre-line;">{{ $application->address }}</span>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-2">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">CV / Berkas</span>
                    <div class="sm:col-span-3">
                        @if($application->user && $application->user->cv)
                            <a href="{{ asset('storage/' . $application->user->cv) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 bg-rose-50 hover:bg-rose-100 text-danger border border-rose-100 rounded-xl text-xs font-bold transition-all duration-150">
                                <i class="fa-solid fa-file-pdf text-sm"></i> Lihat / Unduh CV ({{ $application->user->cv_filename }})
                            </a>
                        @else
                            <span class="text-slate-400 text-xs italic flex items-center gap-1.5 py-1">
                                <i class="fa-solid fa-file-circle-xmark text-sm text-slate-300"></i> Belum mengunggah berkas CV.
                            </span>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-4 gap-2">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Catatan Pelamar</span>
                    <div class="sm:col-span-3">
                        @if($application->note)
                            <div class="p-4 bg-slate-50 border-l-4 border-slate-300 rounded-r-2xl text-slate-600 text-sm italic leading-relaxed">
                                "{{ $application->note }}"
                            </div>
                        @else
                            <span class="text-slate-400 text-xs italic block py-1">Tidak ada catatan dari pelamar.</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Lowongan Dilamar -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 md:p-8">
            <h5 class="text-base font-bold text-primaryBlue border-b border-slate-100 pb-4 mb-6 flex items-center gap-2">
                <i class="fa-solid fa-briefcase text-lg"></i> Informasi Lowongan Dilamar
            </h5>
            
            @if($application->job)
                <div class="space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-2">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Posisi Pekerjaan</span>
                        <span class="sm:col-span-3 text-sm font-extrabold text-slate-800">{{ $application->job->title }}</span>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-2">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Penempatan</span>
                        <span class="sm:col-span-3 text-sm font-semibold text-slate-600">{{ $application->job->location }}</span>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-2">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kualifikasi</span>
                        <span class="sm:col-span-3 text-sm text-slate-500 leading-relaxed" style="white-space: pre-line;">{{ $application->job->qualification }}</span>
                    </div>
                </div>
            @else
                <div class="p-4 bg-amber-50 border border-amber-100 text-amber-800 text-sm font-medium rounded-2xl flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation text-lg"></i> Lowongan pekerjaan ini telah dihapus dari sistem.
                </div>
            @endif
        </div>
    </div>
    
    <!-- Kanan: Update Status Form -->
    <div class="space-y-6">
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
            <h5 class="text-base font-bold text-primaryBlue border-b border-slate-100 pb-4 mb-6 flex items-center gap-2">
                <i class="fa-solid fa-square-poll-horizontal text-lg"></i> Status Lamaran
            </h5>
            
            <div class="text-center py-6 px-4 bg-slate-50 border border-slate-100 rounded-2xl mb-6">
                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Status Saat Ini</span>
                @if($application->status == 'Menunggu')
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-200/50 text-slate-700 border border-slate-200 rounded-full text-sm font-bold shadow-sm">
                        <i class="fa-regular fa-clock"></i> Menunggu
                    </span>
                @elseif($application->status == 'Diproses')
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-50 text-primaryBlue border border-blue-100 rounded-full text-sm font-bold shadow-sm">
                        <i class="fa-solid fa-circle-notch fa-spin"></i> Diproses
                    </span>
                @elseif($application->status == 'Diterima')
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-50 text-success border border-emerald-100 rounded-full text-sm font-bold shadow-sm">
                        <i class="fa-solid fa-circle-check"></i> Diterima
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-rose-50 text-danger border border-rose-100 rounded-full text-sm font-bold shadow-sm">
                        <i class="fa-solid fa-circle-xmark"></i> Ditolak
                    </span>
                @endif
            </div>
            
            <form action="{{ route('admin.applications.update-status', $application->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')
                
                <div>
                    <label for="status" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Ubah Status</label>
                    <select class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150" id="status" name="status" required>
                        <option value="Menunggu" {{ $application->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="Diproses" {{ $application->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="Diterima" {{ $application->status == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="Ditolak" {{ $application->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                
                <div>
                    <label for="admin_note" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Catatan / Hasil Review</label>
                    <textarea class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-primaryBlue focus:ring-4 focus:ring-primaryBlue/10 transition-all duration-150" id="admin_note" name="admin_note" rows="5" placeholder="Masukkan instruksi wawancara (jika diproses/diterima) atau alasan penolakan (jika ditolak)...">{{ old('admin_note', $application->admin_note) }}</textarea>
                </div>
                
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-6 py-3.5 bg-primaryBlue hover:bg-blue-700 text-white font-bold rounded-2xl shadow-lg shadow-primaryBlue/20 hover:shadow-xl transition-all duration-150">
                    <i class="fa-solid fa-floppy-disk text-sm"></i> Perbarui Status
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
