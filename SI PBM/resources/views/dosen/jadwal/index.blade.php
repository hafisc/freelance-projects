@extends('layouts.app')

@section('title', 'Jadwal Mengajar | SI-PBM')
@section('page_title', 'Jadwal Pertemuan Mengajar')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <h3 class="text-xl font-extrabold text-[#1b3f75]">Jadwal Pertemuan Saya</h3>
        <p class="text-slate-400 text-xs mt-1">Kelola rencana pertemuan tatap muka di kelas yang Anda ampu.</p>
    </div>
    <button onclick="openModal('tambahJadwalModal')" 
        class="inline-flex items-center gap-2 bg-[#204a82] hover:bg-[#193f72] text-white font-semibold py-2.5 px-5 rounded-xl shadow-md transition-all duration-200 text-sm">
        <i class="bi bi-calendar-plus-fill"></i> Tambah Pertemuan
    </button>
</div>

<!-- Stats Summary -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#204a82] flex items-center justify-center text-xl shrink-0">
            <i class="bi bi-calendar-event-fill"></i>
        </div>
        <div>
            <h4 class="text-xl font-extrabold text-slate-800">{{ $jadwals->count() }}</h4>
            <span class="text-slate-400 text-[10px] font-semibold uppercase tracking-wider">Total Pertemuan</span>
        </div>
    </div>
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0">
            <i class="bi bi-check-circle-fill"></i>
        </div>
        <div>
            <h4 class="text-xl font-extrabold text-slate-800">{{ $jadwals->where('status', 'Selesai')->count() }}</h4>
            <span class="text-slate-400 text-[10px] font-semibold uppercase tracking-wider">Sudah Selesai</span>
        </div>
    </div>
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shrink-0">
            <i class="bi bi-hourglass-split"></i>
        </div>
        <div>
            <h4 class="text-xl font-extrabold text-slate-800">{{ $jadwals->where('status', 'Terjadwal')->count() }}</h4>
            <span class="text-slate-400 text-[10px] font-semibold uppercase tracking-wider">Belum Dilaksanakan</span>
        </div>
    </div>
</div>

<!-- Table Card -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400 text-[11px] uppercase tracking-wider font-semibold">
                    <th class="py-4 px-6">Kelas / MK</th>
                    <th class="py-4 px-6">Pertemuan</th>
                    <th class="py-4 px-6">Tanggal</th>
                    <th class="py-4 px-6">Waktu / Jam</th>
                    <th class="py-4 px-6">Ruangan</th>
                    <th class="py-4 px-6">Topik / Pokok Bahasan</th>
                    <th class="py-4 px-6">Status</th>
                    <th class="py-4 px-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($jadwals as $j)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-4 px-6 font-bold text-[#204a82]">
                            {{ $j->kelas->kode_kelas }}
                            <span class="block text-slate-400 text-xs font-semibold mt-0.5">{{ $j->kelas->matakuliah->nama_mk }}</span>
                        </td>
                        <td class="py-4 px-6 font-bold text-slate-700">Ke-{{ $j->pertemuan_ke }}</td>
                        <td class="py-4 px-6 text-slate-500 font-medium">{{ date('d-m-Y', strtotime($j->tanggal)) }}</td>
                        <td class="py-4 px-6 text-slate-500">{{ substr($j->jam_mulai, 0, 5) }} - {{ substr($j->jam_selesai, 0, 5) }} WIB</td>
                        <td class="py-4 px-6">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/50">{{ $j->ruangan }}</span>
                        </td>
                        <td class="py-4 px-6 text-slate-500 font-medium max-w-[200px] truncate" title="{{ $j->topik_materi }}">{{ $j->topik_materi ?? 'Belum ditentukan' }}</td>
                        <td class="py-4 px-6">
                            @if($j->status === 'Selesai')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">Selesai</span>
                            @elseif($j->status === 'Berlangsung')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100 animate-pulse">Berlangsung</span>
                            @elseif($j->status === 'Dibatalkan')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-100">Dibatalkan</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-[#204a82] border border-blue-100">Terjadwal</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="inline-flex items-center gap-2">
                                <button onclick="openModal('editJadwalModal{{ $j->id }}')" 
                                    class="w-8 h-8 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 flex items-center justify-center transition-all duration-150" 
                                    title="Edit Jadwal">
                                    <i class="bi bi-pencil-square text-sm"></i>
                                </button>
                                <form action="{{ route('jadwal.destroy', $j->id) }}" method="POST" class="m-0 inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                        class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 flex items-center justify-center transition-all duration-150" 
                                        title="Hapus Jadwal">
                                        <i class="bi bi-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="py-12 text-center text-slate-400">
                            <div class="flex flex-col items-center gap-3">
                                <i class="bi bi-calendar-x text-4xl text-slate-300"></i>
                                <span>Belum ada jadwal pertemuan. Klik <strong>"Tambah Pertemuan"</strong> untuk membuat jadwal baru.</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Tambah Jadwal Modal -->
<div id="tambahJadwalModal" class="fixed inset-0 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm z-50 hidden transition-all duration-300">
    <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl relative border border-slate-100 mx-4 max-h-[90vh] overflow-y-auto">
        <button onclick="closeModal('tambahJadwalModal')" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 transition-colors">
            <i class="bi bi-x-lg text-lg"></i>
        </button>

        <h3 class="text-lg font-extrabold text-[#1b3f75] flex items-center gap-2 mb-6">
            <i class="bi bi-calendar-plus-fill text-blue-500"></i> Tambah Jadwal Pertemuan
        </h3>

        <form action="{{ route('jadwal.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pilih Kelas</label>
                <select name="kelas_id" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                    <option value="">-- Pilih Kelas Anda --</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kelas }} ({{ $k->kode_kelas }})</option>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pertemuan Ke</label>
                    <input type="number" name="pertemuan_ke" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" placeholder="1" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal</label>
                    <input type="date" name="tanggal" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
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
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Ruangan</label>
                <input type="text" name="ruangan" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" placeholder="Lab 1 atau R.302" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Topik / Bahasan Materi</label>
                <input type="text" name="topik_materi" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" placeholder="Pengenalan OOP">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status Pertemuan</label>
                <select name="status" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                    <option value="Terjadwal">Terjadwal</option>
                    <option value="Berlangsung">Berlangsung</option>
                    <option value="Selesai">Selesai</option>
                    <option value="Dibatalkan">Dibatalkan</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Catatan PBM</label>
                <textarea name="catatan" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" rows="2" placeholder="Catatan tambahan..."></textarea>
            </div>

            <button type="submit" 
                class="w-full flex items-center justify-center gap-2 bg-[#204a82] hover:bg-[#193f72] text-white font-semibold py-2.5 px-6 rounded-xl shadow-lg transition-all duration-200 mt-6">
                Simpan Jadwal Pertemuan
            </button>
        </form>
    </div>
</div>

<!-- Edit Jadwal Modals -->
@foreach($jadwals as $j)
    <div id="editJadwalModal{{ $j->id }}" class="fixed inset-0 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm z-50 hidden transition-all duration-300">
        <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl relative border border-slate-100 mx-4 max-h-[90vh] overflow-y-auto">
            <button onclick="closeModal('editJadwalModal{{ $j->id }}')" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 transition-colors">
                <i class="bi bi-x-lg text-lg"></i>
            </button>

            <h3 class="text-lg font-extrabold text-[#1b3f75] flex items-center gap-2 mb-6">
                <i class="bi bi-pencil-square text-blue-500"></i> Ubah Jadwal Pertemuan
            </h3>

            <form action="{{ route('jadwal.update', $j->id) }}" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pilih Kelas</label>
                    <select name="kelas_id" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ $j->kelas_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }} ({{ $k->kode_kelas }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pertemuan Ke</label>
                        <input type="number" name="pertemuan_ke" value="{{ $j->pertemuan_ke }}" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ $j->tanggal }}" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Jam Mulai</label>
                        <input type="time" name="jam_mulai" value="{{ $j->jam_mulai }}" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Jam Selesai</label>
                        <input type="time" name="jam_selesai" value="{{ $j->jam_selesai }}" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Ruangan</label>
                    <input type="text" name="ruangan" value="{{ $j->ruangan }}" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Topik / Bahasan Materi</label>
                    <input type="text" name="topik_materi" value="{{ $j->topik_materi }}" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status Pertemuan</label>
                    <select name="status" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
                        <option value="Terjadwal" {{ $j->status === 'Terjadwal' ? 'selected' : '' }}>Terjadwal</option>
                        <option value="Berlangsung" {{ $j->status === 'Berlangsung' ? 'selected' : '' }}>Berlangsung</option>
                        <option value="Selesai" {{ $j->status === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="Dibatalkan" {{ $j->status === 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Catatan PBM</label>
                    <textarea name="catatan" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" rows="2">{{ $j->catatan }}</textarea>
                </div>

                <button type="submit" 
                    class="w-full flex items-center justify-center gap-2 bg-[#204a82] hover:bg-[#193f72] text-white font-semibold py-2.5 px-6 rounded-xl shadow-lg transition-all duration-200 mt-6">
                    Update Jadwal Pertemuan
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
