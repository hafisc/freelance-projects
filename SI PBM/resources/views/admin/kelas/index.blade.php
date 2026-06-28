@extends('layouts.app')

@section('title', 'Data Kelas | SI-PBM')
@section('page_title', 'Kelola Kelas Kuliah')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <h3 class="text-xl font-extrabold text-[#1b3f75]">Daftar Kelas Akademik</h3>
        <p class="text-slate-400 text-xs mt-1">Plotting kelas kuliah, hari, jam, ruangan, dan dosen pengampu.</p>
    </div>
    @if(session('role') === 'Admin' || session('role') === 'Operator')
        <button onclick="openModal('tambahKelasModal')" 
            class="inline-flex items-center gap-2 bg-[#204a82] hover:bg-[#193f72] text-white font-semibold py-2.5 px-5 rounded-xl shadow-md transition-all duration-200 text-sm">
            <i class="bi bi-door-open-fill"></i> Tambah Kelas Baru
        </button>
    @endif
</div>

<!-- Table Card -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400 text-[11px] uppercase tracking-wider font-semibold">
                    <th class="py-4 px-6">Kode Kelas</th>
                    <th class="py-4 px-6">Nama Kelas</th>
                    <th class="py-4 px-6">Mata Kuliah</th>
                    <th class="py-4 px-6">Dosen Pengampu</th>
                    <th class="py-4 px-6">Jadwal Mingguan</th>
                    <th class="py-4 px-6">Ruangan</th>
                    <th class="py-4 px-6">Kapasitas</th>
                    @if(session('role') === 'Admin' || session('role') === 'Operator')
                        <th class="py-4 px-6 text-right">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($kelas as $k)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-4 px-6 font-bold text-[#204a82]">{{ $k->kode_kelas }}</td>
                        <td class="py-4 px-6 font-semibold text-slate-700">{{ $k->nama_kelas }}</td>
                        <td class="py-4 px-6 text-slate-500 font-medium">{{ $k->matakuliah->nama_mk }} (Sem. {{ $k->semester }})</td>
                        <td class="py-4 px-6 text-slate-500">{{ $k->dosen->nama_dosen }}</td>
                        <td class="py-4 px-6 text-slate-500">
                            <span class="font-bold text-slate-700 block">{{ $k->hari }}</span>
                            <span class="text-xs text-slate-400 font-medium inline-flex items-center gap-1"><i class="bi bi-clock"></i> {{ substr($k->jam_mulai, 0, 5) }} - {{ substr($k->jam_selesai, 0, 5) }}</span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/50">{{ $k->ruangan }}</span>
                        </td>
                        <td class="py-4 px-6 text-slate-500 font-medium">{{ $k->kapasitas }} Mahasiswa</td>
                        
                        @if(session('role') === 'Admin' || session('role') === 'Operator')
                            <td class="py-4 px-6 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <button onclick="openModal('editKelasModal{{ $k->id }}')" 
                                        class="w-8 h-8 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 flex items-center justify-center transition-all duration-150" 
                                        title="Edit Kelas">
                                        <i class="bi bi-pencil-square text-sm"></i>
                                    </button>
                                    <form action="{{ route('kelas.destroy', $k->id) }}" method="POST" class="m-0 inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" 
                                            class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 flex items-center justify-center transition-all duration-150" 
                                            title="Hapus Kelas">
                                            <i class="bi bi-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="py-12 text-center text-slate-400">
                            <i class="bi bi-door-open text-3xl d-block mb-3 text-slate-300"></i>
                            Data kelas tidak ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if(session('role') === 'Admin' || session('role') === 'Operator')
    <!-- Tambah Kelas Modal -->
    <div id="tambahKelasModal" class="fixed inset-0 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm z-50 hidden transition-all duration-300">
        <div class="bg-white rounded-3xl p-8 max-w-2xl w-full shadow-2xl relative border border-slate-100 mx-4 max-h-[90vh] overflow-y-auto">
            <!-- Close Button -->
            <button onclick="closeModal('tambahKelasModal')" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 transition-colors">
                <i class="bi bi-x-lg text-lg"></i>
            </button>

            <h3 class="text-lg font-extrabold text-[#1b3f75] flex items-center gap-2 mb-6">
                <i class="bi bi-door-open-fill text-blue-500"></i> Tambah Kelas Baru
            </h3>

            <form action="{{ route('kelas.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kode Kelas</label>
                        <input type="text" name="kode_kelas" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" placeholder="Contoh: K-IF101-A" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Kelas</label>
                        <input type="text" name="nama_kelas" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" placeholder="Contoh: Dasar Pemrograman - A" required>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Mata Kuliah</label>
                        <select name="matakuliah_id" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                            <option value="">-- Pilih Mata Kuliah --</option>
                            @foreach($matakuliahs as $mk)
                                <option value="{{ $mk->id }}">{{ $mk->nama_mk }} (Kode: {{ $mk->kode_mk }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Dosen Pengampu</label>
                        <select name="dosen_id" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                            <option value="">-- Pilih Dosen --</option>
                            @foreach($dosens as $d)
                                <option value="{{ $d->id }}">{{ $d->nama_dosen }} (NIDN: {{ $d->nidn }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Semester</label>
                        <input type="number" name="semester" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" placeholder="Semester ke-..." required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tahun Ajaran</label>
                        <input type="text" name="tahun_ajaran" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" placeholder="Contoh: 2025/2026" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kapasitas</label>
                        <input type="number" name="kapasitas" value="40" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Hari</label>
                        <select name="hari" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                            <option value="Sabtu">Sabtu</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Jam Mulai</label>
                        <input type="time" name="jam_mulai" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Jam Selesai</label>
                        <input type="time" name="jam_selesai" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Ruangan Kelas</label>
                    <input type="text" name="ruangan" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" placeholder="Contoh: Lab Komputer 1" required>
                </div>

                <button type="submit" 
                    class="w-full flex items-center justify-center gap-2 bg-[#204a82] hover:bg-[#193f72] text-white font-semibold py-2.5 px-6 rounded-xl shadow-lg transition-all duration-200 mt-6">
                    Simpan Kelas Baru
                </button>
            </form>
        </div>
    </div>

    <!-- Edit Kelas Modals -->
    @foreach($kelas as $k)
        <div id="editKelasModal{{ $k->id }}" class="fixed inset-0 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm z-50 hidden transition-all duration-300">
            <div class="bg-white rounded-3xl p-8 max-w-2xl w-full shadow-2xl relative border border-slate-100 mx-4 max-h-[90vh] overflow-y-auto">
                <!-- Close Button -->
                <button onclick="closeModal('editKelasModal{{ $k->id }}')" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 transition-colors">
                    <i class="bi bi-x-lg text-lg"></i>
                </button>

                <h3 class="text-lg font-extrabold text-[#1b3f75] flex items-center gap-2 mb-6">
                    <i class="bi bi-pencil-square text-blue-500"></i> Ubah Kelas Kuliah
                </h3>

                <form action="{{ route('kelas.update', $k->id) }}" method="POST" class="space-y-4">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kode Kelas</label>
                            <input type="text" name="kode_kelas" value="{{ $k->kode_kelas }}" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Kelas</label>
                            <input type="text" name="nama_kelas" value="{{ $k->nama_kelas }}" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Mata Kuliah</label>
                            <select name="matakuliah_id" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                                @foreach($matakuliahs as $mk)
                                    <option value="{{ $mk->id }}" {{ $k->matakuliah_id == $mk->id ? 'selected' : '' }}>{{ $mk->nama_mk }} (Kode: {{ $mk->kode_mk }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Dosen Pengampu</label>
                            <select name="dosen_id" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                                @foreach($dosens as $d)
                                    <option value="{{ $d->id }}" {{ $k->dosen_id == $d->id ? 'selected' : '' }}>{{ $d->nama_dosen }} (NIDN: {{ $d->nidn }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Semester</label>
                            <input type="number" name="semester" value="{{ $k->semester }}" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tahun Ajaran</label>
                            <input type="text" name="tahun_ajaran" value="{{ $k->tahun_ajaran }}" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kapasitas</label>
                            <input type="number" name="kapasitas" value="{{ $k->kapasitas }}" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Hari</label>
                            <select name="hari" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                                <option value="Senin" {{ $k->hari === 'Senin' ? 'selected' : '' }}>Senin</option>
                                <option value="Selasa" {{ $k->hari === 'Selasa' ? 'selected' : '' }}>Selasa</option>
                                <option value="Rabu" {{ $k->hari === 'Rabu' ? 'selected' : '' }}>Rabu</option>
                                <option value="Kamis" {{ $k->hari === 'Kamis' ? 'selected' : '' }}>Kamis</option>
                                <option value="Jumat" {{ $k->hari === 'Jumat' ? 'selected' : '' }}>Jumat</option>
                                <option value="Sabtu" {{ $k->hari === 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Jam Mulai</label>
                            <input type="time" name="jam_mulai" value="{{ $k->jam_mulai }}" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Jam Selesai</label>
                            <input type="time" name="jam_selesai" value="{{ $k->jam_selesai }}" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Ruangan Kelas</label>
                        <input type="text" name="ruangan" value="{{ $k->ruangan }}" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                    </div>

                    <button type="submit" 
                        class="w-full flex items-center justify-center gap-2 bg-[#204a82] hover:bg-[#193f72] text-white font-semibold py-2.5 px-6 rounded-xl shadow-lg transition-all duration-200 mt-6">
                        Update Data Kelas
                    </button>
                </form>
            </div>
        </div>
    @endforeach
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
