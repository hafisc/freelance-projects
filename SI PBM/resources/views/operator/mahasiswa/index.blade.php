@extends('layouts.app')

@section('title', 'Data Mahasiswa | SI-PBM')
@section('page_title', 'Data Mahasiswa')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <h3 class="text-xl font-extrabold text-[#1b3f75]">Pengelolaan Mahasiswa</h3>
        <p class="text-slate-400 text-xs mt-1">Tambah, ubah, dan hapus data mahasiswa aktif (Operator Panel).</p>
    </div>
    <a href="{{ route('create-mahasiswa') }}" 
        class="inline-flex items-center gap-2 bg-[#204a82] hover:bg-[#193f72] text-white font-semibold py-2.5 px-5 rounded-xl shadow-md transition-all duration-200 text-sm">
        <i class="bi bi-mortarboard-fill"></i> Tambah Mahasiswa
    </a>
</div>

<!-- Table Card -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400 text-[11px] uppercase tracking-wider font-semibold">
                    <th class="py-4 px-6">NIM</th>
                    <th class="py-4 px-6">Nama Lengkap</th>
                    <th class="py-4 px-6">Program Studi</th>
                    <th class="py-4 px-6">Angkatan</th>
                    <th class="py-4 px-6">Status</th>
                    <th class="py-4 px-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($mahasiswa as $item)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-4 px-6 font-bold text-[#204a82]">{{ $item->nim }}</td>
                        <td class="py-4 px-6 font-semibold text-slate-700">{{ $item->nama }}</td>
                        <td class="py-4 px-6 text-slate-500 font-medium">{{ $item->prodi }}</td>
                        <td class="py-4 px-6 text-slate-500">{{ $item->tahun_masuk }}</td>
                        <td class="py-4 px-6">
                            @if($item->status_mahasiswa === 'Aktif')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">Aktif</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100">Non-aktif</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('edit-mahasiswa', $item->nim) }}" 
                                    class="w-8 h-8 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 flex items-center justify-center transition-all duration-150" 
                                    title="Edit Mahasiswa">
                                    <i class="bi bi-pencil-square text-sm"></i>
                                </a>
                                <form action="{{ route('hapus-mahasiswa', $item->nim) }}" method="POST" class="m-0 inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mahasiswa ini? Akun login terkait juga akan terhapus.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                        class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 flex items-center justify-center transition-all duration-150" 
                                        title="Hapus Mahasiswa">
                                        <i class="bi bi-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-400">
                            <i class="bi bi-mortarboard text-3xl d-block mb-3 text-slate-300"></i>
                            Data mahasiswa kosong.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
