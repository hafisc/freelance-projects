@extends('layouts.app')

@section('title', 'Kelola Dosen | SI-PBM')
@section('page_title', 'Kelola Dosen')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <h3 class="text-xl font-extrabold text-[#1b3f75]">Daftar Dosen Pengampu</h3>
        <p class="text-slate-400 text-xs mt-1">Manajemen data tenaga pendidik/dosen pengampu mata kuliah (Operator Panel).</p>
    </div>
    <button onclick="openModal('tambahDosenModal')" 
        class="inline-flex items-center gap-2 bg-[#204a82] hover:bg-[#193f72] text-white font-semibold py-2.5 px-5 rounded-xl shadow-md transition-all duration-200 text-sm">
        <i class="bi bi-person-plus-fill"></i> Tambah Dosen
    </button>
</div>

<!-- Table Card -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400 text-[11px] uppercase tracking-wider font-semibold">
                    <th class="py-4 px-6">NIDN</th>
                    <th class="py-4 px-6">Nama Lengkap</th>
                    <th class="py-4 px-6">Bidang Keahlian</th>
                    <th class="py-4 px-6">Email</th>
                    <th class="py-4 px-6">Nomor HP</th>
                    <th class="py-4 px-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($dosens as $d)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-4 px-6 font-bold text-[#204a82]">{{ $d->nidn }}</td>
                        <td class="py-4 px-6 font-semibold text-slate-700">{{ $d->nama_dosen }}</td>
                        <td class="py-4 px-6">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/50">{{ $d->keahlian }}</span>
                        </td>
                        <td class="py-4 px-6 text-slate-500">{{ $d->email ?? '-' }}</td>
                        <td class="py-4 px-6 text-slate-500">{{ $d->no_hp ?? '-' }}</td>
                        <td class="py-4 px-6 text-right">
                            <div class="inline-flex items-center gap-2">
                                <button onclick="openModal('editDosenModal{{ $d->id }}')" 
                                    class="w-8 h-8 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 flex items-center justify-center transition-all duration-150" 
                                    title="Edit Dosen">
                                    <i class="bi bi-pencil-square text-sm"></i>
                                </button>
                                <form action="{{ route('dosen.destroy', $d->id) }}" method="POST" class="m-0 inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Dosen ini? Akun login terkait juga akan terhapus.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                        class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 flex items-center justify-center transition-all duration-150" 
                                        title="Hapus Dosen">
                                        <i class="bi bi-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-400">
                            <i class="bi bi-person-badge text-3xl d-block mb-3 text-slate-300"></i>
                            Data dosen tidak ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Tambah Dosen Modal -->
<div id="tambahDosenModal" class="fixed inset-0 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm z-50 hidden transition-all duration-300">
    <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl relative border border-slate-100 mx-4">
        <!-- Close Button -->
        <button onclick="closeModal('tambahDosenModal')" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 transition-colors">
            <i class="bi bi-x-lg text-lg"></i>
        </button>

        <h3 class="text-lg font-extrabold text-[#1b3f75] flex items-center gap-2 mb-6">
            <i class="bi bi-person-plus-fill text-blue-500"></i> Tambah Dosen Baru (Operator)
        </h3>

        <form action="{{ route('dosen.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">NIDN</label>
                <input type="text" name="nidn" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" placeholder="Nomor Induk Dosen Nasional" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Dosen</label>
                <input type="text" name="nama_dosen" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" placeholder="Nama lengkap beserta gelar" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Keahlian / Program Studi</label>
                <input type="text" name="keahlian" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" placeholder="Contoh: Pemrograman Web, AI" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Email</label>
                <input type="email" name="email" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" placeholder="nama_dosen@sipbm.ac.id" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nomor HP</label>
                <input type="text" name="no_hp" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" placeholder="Contoh: 0812...">
            </div>

            <button type="submit" 
                class="w-full flex items-center justify-center gap-2 bg-[#204a82] hover:bg-[#193f72] text-white font-semibold py-2.5 px-6 rounded-xl shadow-lg transition-all duration-200 mt-6">
                Simpan Data Dosen
            </button>
        </form>
    </div>
</div>

<!-- Edit Dosen Modals -->
@foreach($dosens as $d)
    <div id="editDosenModal{{ $d->id }}" class="fixed inset-0 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm z-50 hidden transition-all duration-300">
        <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl relative border border-slate-100 mx-4">
            <!-- Close Button -->
            <button onclick="closeModal('editDosenModal{{ $d->id }}')" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 transition-colors">
                <i class="bi bi-x-lg text-lg"></i>
            </button>

            <h3 class="text-lg font-extrabold text-[#1b3f75] flex items-center gap-2 mb-6">
                <i class="bi bi-pencil-square text-blue-500"></i> Ubah Data Dosen
            </h3>

            <form action="{{ route('dosen.update', $d->id) }}" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">NIDN</label>
                    <input type="text" name="nidn" value="{{ $d->nidn }}" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Dosen</label>
                    <input type="text" name="nama_dosen" value="{{ $d->nama_dosen }}" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Keahlian</label>
                    <input type="text" name="keahlian" value="{{ $d->keahlian }}" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Email</label>
                    <input type="email" name="email" value="{{ $d->email }}" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nomor HP</label>
                    <input type="text" name="no_hp" value="{{ $d->no_hp }}" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200">
                </div>

                <button type="submit" 
                    class="w-full flex items-center justify-center gap-2 bg-[#204a82] hover:bg-[#193f72] text-white font-semibold py-2.5 px-6 rounded-xl shadow-lg transition-all duration-200 mt-6">
                    Update Data Dosen
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
