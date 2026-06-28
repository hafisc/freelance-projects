@extends('layouts.app')

@section('title', 'Mata Kuliah | SI-PBM')
@section('page_title', 'Kelola Mata Kuliah')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <h3 class="text-xl font-extrabold text-[#1b3f75]">Daftar Mata Kuliah</h3>
        <p class="text-slate-400 text-xs mt-1">Manajemen katalog mata kuliah program studi (Operator Panel).</p>
    </div>
    <button onclick="openModal('tambahMkModal')" 
        class="inline-flex items-center gap-2 bg-[#204a82] hover:bg-[#193f72] text-white font-semibold py-2.5 px-5 rounded-xl shadow-md transition-all duration-200 text-sm">
        <i class="bi bi-plus-lg"></i> Tambah MK
    </button>
</div>

<!-- Table Card -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400 text-[11px] uppercase tracking-wider font-semibold">
                    <th class="py-4 px-6">Kode MK</th>
                    <th class="py-4 px-6">Nama Mata Kuliah</th>
                    <th class="py-4 px-6">SKS</th>
                    <th class="py-4 px-6">Semester</th>
                    <th class="py-4 px-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($matakuliahs as $mk)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-4 px-6 font-bold text-[#204a82]">{{ $mk->kode_mk }}</td>
                        <td class="py-4 px-6 font-semibold text-slate-700">{{ $mk->nama_mk }}</td>
                        <td class="py-4 px-6">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/50">{{ $mk->sks }} SKS</span>
                        </td>
                        <td class="py-4 px-6 text-slate-500 font-medium">Semester {{ $mk->semester }}</td>
                        <td class="py-4 px-6 text-right">
                            <div class="inline-flex items-center gap-2">
                                <button onclick="openModal('editMkModal{{ $mk->id }}')" 
                                    class="w-8 h-8 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 flex items-center justify-center transition-all duration-150" 
                                    title="Edit Mata Kuliah">
                                    <i class="bi bi-pencil-square text-sm"></i>
                                </button>
                                <form action="{{ route('matakuliah.destroy', $mk->id) }}" method="POST" class="m-0 inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Mata Kuliah ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                        class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 flex items-center justify-center transition-all duration-150" 
                                        title="Hapus Mata Kuliah">
                                        <i class="bi bi-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-slate-400">
                            <i class="bi bi-book-half text-3xl d-block mb-3 text-slate-300"></i>
                            Mata kuliah tidak ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Tambah MK Modal -->
<div id="tambahMkModal" class="fixed inset-0 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm z-50 hidden transition-all duration-300">
    <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl relative border border-slate-100 mx-4">
        <!-- Close Button -->
        <button onclick="closeModal('tambahMkModal')" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 transition-colors">
            <i class="bi bi-x-lg text-lg"></i>
        </button>

        <h3 class="text-lg font-extrabold text-[#1b3f75] flex items-center gap-2 mb-6">
            <i class="bi bi-plus-circle-fill text-blue-500"></i> Tambah Mata Kuliah
        </h3>

        <form action="{{ route('matakuliah.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kode Mata Kuliah</label>
                <input type="text" name="kode_mk" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" placeholder="Contoh: IF101" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Mata Kuliah</label>
                <input type="text" name="nama_mk" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" placeholder="Contoh: Dasar Pemrograman" required>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">SKS</label>
                    <input type="number" name="sks" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" placeholder="SKS" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Semester</label>
                    <input type="number" name="semester" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" placeholder="Semester" required>
                </div>
            </div>

            <button type="submit" 
                class="w-full flex items-center justify-center gap-2 bg-[#204a82] hover:bg-[#193f72] text-white font-semibold py-2.5 px-6 rounded-xl shadow-lg transition-all duration-200 mt-6">
                Simpan Mata Kuliah
            </button>
        </form>
    </div>
</div>

<!-- Edit MK Modals -->
@foreach($matakuliahs as $mk)
    <div id="editMkModal{{ $mk->id }}" class="fixed inset-0 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm z-50 hidden transition-all duration-300">
        <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl relative border border-slate-100 mx-4">
            <!-- Close Button -->
            <button onclick="closeModal('editMkModal{{ $mk->id }}')" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 transition-colors">
                <i class="bi bi-x-lg text-lg"></i>
            </button>

            <h3 class="text-lg font-extrabold text-[#1b3f75] flex items-center gap-2 mb-6">
                <i class="bi bi-pencil-square text-blue-500"></i> Ubah Mata Kuliah
            </h3>

            <form action="{{ route('matakuliah.update', $mk->id) }}" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kode Mata Kuliah</label>
                    <input type="text" name="kode_mk" value="{{ $mk->kode_mk }}" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Mata Kuliah</label>
                    <input type="text" name="nama_mk" value="{{ $mk->nama_mk }}" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">SKS</label>
                        <input type="number" name="sks" value="{{ $mk->sks }}" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Semester</label>
                        <input type="number" name="semester" value="{{ $mk->semester }}" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                    </div>
                </div>

                <button type="submit" 
                    class="w-full flex items-center justify-center gap-2 bg-[#204a82] hover:bg-[#193f72] text-white font-semibold py-2.5 px-6 rounded-xl shadow-lg transition-all duration-200 mt-6">
                    Update Mata Kuliah
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
</script>
@endsection
