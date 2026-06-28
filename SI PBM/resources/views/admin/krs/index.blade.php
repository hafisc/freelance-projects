@extends('layouts.app')

@section('title', 'KRS Mahasiswa | SI-PBM')
@section('page_title', 'Kartu Rencana Studi (KRS)')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <h3 class="text-xl font-extrabold text-[#1b3f75]">Kartu Rencana Studi Mahasiswa</h3>
        <p class="text-slate-400 text-xs mt-1">Kelola dan plotting kelas mahasiswa berdasarkan mata kuliah.</p>
    </div>
    @if(session('role') === 'Admin' || session('role') === 'Operator')
        <button onclick="openModal('tambahKrsModal')" 
            class="inline-flex items-center gap-2 bg-[#204a82] hover:bg-[#193f72] text-white font-semibold py-2.5 px-5 rounded-xl shadow-md transition-all duration-200 text-sm">
            <i class="bi bi-file-earmark-plus-fill"></i> Plotting KRS
        </button>
    @endif
</div>

<!-- Table Card -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400 text-[11px] uppercase tracking-wider font-semibold">
                    <th class="py-4 px-6">Mahasiswa</th>
                    <th class="py-4 px-6">Mata Kuliah</th>
                    <th class="py-4 px-6">Dosen Pengampu</th>
                    <th class="py-4 px-6">Semester</th>
                    @if(session('role') === 'Admin' || session('role') === 'Operator')
                        <th class="py-4 px-6 text-right">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($krs as $item)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-4 px-6">
                            <span class="font-bold text-slate-700 block">{{ $item->mahasiswa->nama ?? 'N/A' }}</span>
                            <span class="text-slate-400 text-xs font-semibold">NIM: {{ $item->mahasiswa_id }}</span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="font-semibold text-slate-700 block">{{ $item->matakuliah->nama_mk ?? 'N/A' }}</span>
                            <span class="text-slate-400 text-xs">Kode: {{ $item->matakuliah->kode_mk ?? 'N/A' }}</span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-[#204a82] font-semibold">{{ $item->dosen->nama_dosen ?? 'N/A' }}</span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/50">Sem. {{ $item->semester }}</span>
                        </td>
                        
                        @if(session('role') === 'Admin' || session('role') === 'Operator')
                            <td class="py-4 px-6 text-right">
                                <form action="{{ route('krs.destroy', $item->id) }}" method="POST" class="m-0 inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus plotting KRS ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                        class="inline-flex items-center gap-1 bg-red-50 hover:bg-red-100 text-red-600 text-xs font-semibold py-1.5 px-3 rounded-lg transition-all duration-150" 
                                        title="Hapus Plotting">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-slate-400">
                            <i class="bi bi-file-earmark-text text-3xl d-block mb-3 text-slate-300"></i>
                            Plotting KRS tidak ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if(session('role') === 'Admin' || session('role') === 'Operator')
    <!-- Tambah KRS Modal -->
    <div id="tambahKrsModal" class="fixed inset-0 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm z-50 hidden transition-all duration-300">
        <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl relative border border-slate-100 mx-4">
            <!-- Close Button -->
            <button onclick="closeModal('tambahKrsModal')" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 transition-colors">
                <i class="bi bi-x-lg text-lg"></i>
            </button>

            <h3 class="text-lg font-extrabold text-[#1b3f75] flex items-center gap-2 mb-6">
                <i class="bi bi-file-earmark-plus-fill text-blue-500"></i> Plotting KRS Baru
            </h3>

            <form action="{{ route('krs.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pilih Mahasiswa</label>
                    <select name="mahasiswa_id" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                        <option value="">-- Pilih Mahasiswa --</option>
                        @foreach($mahasiswas as $m)
                            <option value="{{ $m->nim }}">{{ $m->nama }} (NIM: {{ $m->nim }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pilih Mata Kuliah</label>
                    <select name="matakuliah_id" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                        <option value="">-- Pilih Mata Kuliah --</option>
                        @foreach($matakuliahs as $mk)
                            <option value="{{ $mk->id }}">{{ $mk->nama_mk }} (Kode: {{ $mk->kode_mk }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pilih Dosen Pengampu</label>
                    <select name="dosen_id" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                        <option value="">-- Pilih Dosen --</option>
                        @foreach($dosens as $d)
                            <option value="{{ $d->id }}">{{ $d->nama_dosen }} (NIDN: {{ $d->nidn }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Semester</label>
                    <input type="number" name="semester" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" placeholder="Masukkan semester plotting" required>
                </div>

                <button type="submit" 
                    class="w-full flex items-center justify-center gap-2 bg-[#204a82] hover:bg-[#193f72] text-white font-semibold py-2.5 px-6 rounded-xl shadow-lg transition-all duration-200 mt-6">
                    Simpan Plotting KRS
                </button>
            </form>
        </div>
    </div>
@endif

<script>
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
        }
    }
</script>
@endsection
