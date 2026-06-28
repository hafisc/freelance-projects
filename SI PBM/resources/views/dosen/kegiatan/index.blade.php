@extends('layouts.app')

@section('title', 'Kegiatan PBM | SI-PBM')
@section('page_title', 'Kegiatan Belajar Mengajar')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <h3 class="text-xl font-extrabold text-[#1b3f75]">Materi & Tugas Saya</h3>
        <p class="text-slate-400 text-xs mt-1">Kelola unggahan materi kuliah, tugas, dan referensi kegiatan belajar di kelas yang Anda ampu.</p>
    </div>
    <button onclick="openModal('tambahKegiatanModal')" 
        class="inline-flex items-center gap-2 bg-[#204a82] hover:bg-[#193f72] text-white font-semibold py-2.5 px-5 rounded-xl shadow-md transition-all duration-200 text-sm">
        <i class="bi bi-file-earmark-arrow-up-fill"></i> Tambah Kegiatan PBM
    </button>
</div>

<!-- Stats Summary -->
<div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-8">
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#204a82] flex items-center justify-center text-xl shrink-0">
            <i class="bi bi-journal-text"></i>
        </div>
        <div>
            <h4 class="text-xl font-extrabold text-slate-800">{{ $kegiatans->count() }}</h4>
            <span class="text-slate-400 text-[10px] font-semibold uppercase tracking-wider">Total Kegiatan</span>
        </div>
    </div>
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center text-xl shrink-0">
            <i class="bi bi-book-half"></i>
        </div>
        <div>
            <h4 class="text-xl font-extrabold text-slate-800">{{ $kegiatans->where('jenis', 'Materi')->count() }}</h4>
            <span class="text-slate-400 text-[10px] font-semibold uppercase tracking-wider">Materi</span>
        </div>
    </div>
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shrink-0">
            <i class="bi bi-clipboard-data-fill"></i>
        </div>
        <div>
            <h4 class="text-xl font-extrabold text-slate-800">{{ $kegiatans->where('jenis', 'Tugas')->count() }}</h4>
            <span class="text-slate-400 text-[10px] font-semibold uppercase tracking-wider">Tugas</span>
        </div>
    </div>
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0">
            <i class="bi bi-people-fill"></i>
        </div>
        <div>
            <h4 class="text-xl font-extrabold text-slate-800">{{ $kegiatans->where('jenis', 'Pertemuan')->count() }}</h4>
            <span class="text-slate-400 text-[10px] font-semibold uppercase tracking-wider">Pertemuan</span>
        </div>
    </div>
</div>

<!-- Table Card -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400 text-[11px] uppercase tracking-wider font-semibold">
                    <th class="py-4 px-6">Pertemuan / Kelas</th>
                    <th class="py-4 px-6">Jenis</th>
                    <th class="py-4 px-6">Judul Kegiatan</th>
                    <th class="py-4 px-6">Deskripsi</th>
                    <th class="py-4 px-6">File</th>
                    <th class="py-4 px-6">Deadline</th>
                    <th class="py-4 px-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($kegiatans as $k)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-4 px-6 font-bold text-[#204a82]">
                            Pertemuan Ke-{{ $k->jadwalPembelajaran->pertemuan_ke }}
                            <span class="block text-slate-400 text-xs font-semibold mt-0.5">{{ $k->jadwalPembelajaran->kelas->nama_kelas }}</span>
                        </td>
                        <td class="py-4 px-6">
                            @if($k->jenis === 'Materi')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-100">Materi</span>
                            @elseif($k->jenis === 'Tugas')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100">Tugas</span>
                            @elseif($k->jenis === 'Absensi')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">Absensi</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-[#204a82] border border-blue-100">Pertemuan</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 font-semibold text-slate-700">{{ $k->judul }}</td>
                        <td class="py-4 px-6 text-slate-500 font-medium max-w-[200px] truncate" title="{{ $k->deskripsi }}">{{ $k->deskripsi }}</td>
                        <td class="py-4 px-6">
                            @if($k->file_materi)
                                <a href="{{ asset($k->file_materi) }}" 
                                    class="inline-flex items-center gap-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-1.5 px-3 rounded-lg text-xs transition-all duration-150" 
                                    download>
                                    <i class="bi bi-download"></i> Unduh
                                </a>
                            @else
                                <span class="text-slate-400 text-xs">Tidak ada</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-slate-500">
                            @if($k->jenis === 'Tugas' && $k->deadline)
                                <span class="text-red-500 font-semibold text-xs">{{ date('d-m-Y H:i', strtotime($k->deadline)) }}</span>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="inline-flex items-center gap-2">
                                <button onclick="openModal('editKegiatanModal{{ $k->id }}')" 
                                    class="w-8 h-8 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 flex items-center justify-center transition-all duration-150" 
                                    title="Edit">
                                    <i class="bi bi-pencil-square text-sm"></i>
                                </button>
                                <form action="{{ route('kegiatan.destroy', $k->id) }}" method="POST" class="m-0 inline" onsubmit="return confirm('Hapus kegiatan ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                        class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 flex items-center justify-center transition-all duration-150" 
                                        title="Hapus">
                                        <i class="bi bi-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-slate-400">
                            <div class="flex flex-col items-center gap-3">
                                <i class="bi bi-file-earmark-text text-4xl text-slate-300"></i>
                                <span>Belum ada kegiatan. Klik <strong>"Tambah Kegiatan PBM"</strong> untuk mengunggah materi atau tugas.</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Tambah Kegiatan Modal -->
<div id="tambahKegiatanModal" class="fixed inset-0 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm z-50 hidden transition-all duration-300">
    <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl relative border border-slate-100 mx-4 max-h-[90vh] overflow-y-auto">
        <button onclick="closeModal('tambahKegiatanModal')" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 transition-colors">
            <i class="bi bi-x-lg text-lg"></i>
        </button>

        <h3 class="text-lg font-extrabold text-[#1b3f75] flex items-center gap-2 mb-6">
            <i class="bi bi-file-earmark-arrow-up-fill text-blue-500"></i> Tambah Kegiatan Baru
        </h3>

        <form action="{{ route('kegiatan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pilih Pertemuan</label>
                <select name="jadwal_id" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                    <option value="">-- Pilih Pertemuan --</option>
                    @foreach($jadwals as $j)
                        <option value="{{ $j->id }}">Pertemuan {{ $j->pertemuan_ke }} - {{ $j->kelas->matakuliah->nama_mk }} ({{ $j->kelas->kode_kelas }})</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Jenis Kegiatan</label>
                <select name="jenis" id="add_jenis_kegiatan" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required onchange="toggleAddDeadline()">
                    <option value="Pertemuan">Pertemuan Tatap Muka</option>
                    <option value="Materi">Materi Perkuliahan</option>
                    <option value="Tugas">Tugas Rumah / Latihan</option>
                    <option value="Absensi">Pengumuman Absensi</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Judul Kegiatan</label>
                <input type="text" name="judul" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" placeholder="Modul Praktikum Basis Data" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Deskripsi / Instruksi</label>
                <textarea name="deskripsi" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" rows="3" placeholder="Tulis instruksi atau rincian kegiatan..."></textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Unggah File (PDF, PPT, Word, ZIP, Gambar)</label>
                <input type="file" name="file_materi" class="block w-full text-slate-500 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-[#204a82] hover:file:bg-blue-100">
                <p class="text-[10px] text-slate-400 mt-1">Maksimal ukuran file: 10MB</p>
            </div>

            <div class="hidden" id="add_deadline_div">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Batas Pengumpulan (Deadline)</label>
                <input type="datetime-local" name="deadline" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200">
            </div>

            <button type="submit" 
                class="w-full flex items-center justify-center gap-2 bg-[#204a82] hover:bg-[#193f72] text-white font-semibold py-2.5 px-6 rounded-xl shadow-lg transition-all duration-200 mt-6">
                Simpan Kegiatan
            </button>
        </form>
    </div>
</div>

<!-- Edit Kegiatan Modals -->
@foreach($kegiatans as $k)
    <div id="editKegiatanModal{{ $k->id }}" class="fixed inset-0 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm z-50 hidden transition-all duration-300">
        <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl relative border border-slate-100 mx-4 max-h-[90vh] overflow-y-auto">
            <button onclick="closeModal('editKegiatanModal{{ $k->id }}')" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 transition-colors">
                <i class="bi bi-x-lg text-lg"></i>
            </button>

            <h3 class="text-lg font-extrabold text-[#1b3f75] flex items-center gap-2 mb-6">
                <i class="bi bi-pencil-square text-blue-500"></i> Ubah Kegiatan PBM
            </h3>

            <form action="{{ route('kegiatan.update', $k->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pilih Pertemuan</label>
                    <select name="jadwal_id" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                        @foreach($jadwals as $j)
                            <option value="{{ $j->id }}" {{ $k->jadwal_id == $j->id ? 'selected' : '' }}>Pertemuan {{ $j->pertemuan_ke }} - {{ $j->kelas->matakuliah->nama_mk }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Jenis Kegiatan</label>
                    <select name="jenis" id="edit_jenis_kegiatan_{{ $k->id }}" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required onchange="toggleEditDeadline({{ $k->id }})">
                        <option value="Pertemuan" {{ $k->jenis === 'Pertemuan' ? 'selected' : '' }}>Pertemuan Tatap Muka</option>
                        <option value="Materi" {{ $k->jenis === 'Materi' ? 'selected' : '' }}>Materi Perkuliahan</option>
                        <option value="Tugas" {{ $k->jenis === 'Tugas' ? 'selected' : '' }}>Tugas Rumah / Latihan</option>
                        <option value="Absensi" {{ $k->jenis === 'Absensi' ? 'selected' : '' }}>Pengumuman Absensi</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Judul Kegiatan</label>
                    <input type="text" name="judul" value="{{ $k->judul }}" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Deskripsi / Instruksi</label>
                    <textarea name="deskripsi" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" rows="3">{{ $k->deskripsi }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Unggah File Baru <small class="text-slate-400 font-normal">(Biarkan jika tidak diganti)</small></label>
                    <input type="file" name="file_materi" class="block w-full text-slate-500 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-[#204a82] hover:file:bg-blue-100">
                    @if($k->file_materi)
                        <p class="text-[10px] text-emerald-600 mt-1 font-semibold flex items-center gap-1"><i class="bi bi-file-check"></i> File saat ini: {{ basename($k->file_materi) }}</p>
                    @endif
                </div>

                <div class="{{ $k->jenis === 'Tugas' ? '' : 'hidden' }}" id="edit_deadline_div_{{ $k->id }}">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Batas Pengumpulan (Deadline)</label>
                    <input type="datetime-local" name="deadline" value="{{ $k->deadline ? date('Y-m-d\TH:i', strtotime($k->deadline)) : '' }}" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200">
                </div>

                <button type="submit" 
                    class="w-full flex items-center justify-center gap-2 bg-[#204a82] hover:bg-[#193f72] text-white font-semibold py-2.5 px-6 rounded-xl shadow-lg transition-all duration-200 mt-6">
                    Update Kegiatan
                </button>
            </form>
        </div>
    </div>
@endforeach

<script>
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) modal.classList.remove('hidden');
    }
    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) modal.classList.add('hidden');
    }
    function toggleAddDeadline() {
        const jenis = document.getElementById('add_jenis_kegiatan').value;
        const div = document.getElementById('add_deadline_div');
        if (jenis === 'Tugas') { div.classList.remove('hidden'); } else { div.classList.add('hidden'); }
    }
    function toggleEditDeadline(id) {
        const jenis = document.getElementById('edit_jenis_kegiatan_' + id).value;
        const div = document.getElementById('edit_deadline_div_' + id);
        if (jenis === 'Tugas') { div.classList.remove('hidden'); } else { div.classList.add('hidden'); }
    }
</script>
@endsection
