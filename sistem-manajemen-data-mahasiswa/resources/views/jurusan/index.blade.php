@extends('layouts.app')

@section('title', 'Data Jurusan')

@section('content')
<div class="card border-0 shadow-sm custom-card">
    <div class="custom-card-header d-flex justify-content-between align-items-center">
        <span>Daftar Jurusan Kuliah</span>
        <a href="{{ route('jurusan.create') }}" class="btn btn-primary btn-sm">Tambah Jurusan Baru</a>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover table-custom mb-0">
            <thead>
                <tr>
                    <th style="width: 80px;">No</th>
                    <th>Nama Jurusan</th>
                    <th>Keterangan</th>
                    <th style="width: 150px; text-align: center;">Jumlah Mahasiswa</th>
                    <th style="width: 220px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jurusans as $index => $jr)
                    <tr>
                        <td>{{ $jurusans->firstItem() + $index }}</td>
                        <td><strong>{{ $jr->nama_jurusan }}</strong></td>
                        <td>{{ Str::limit($jr->keterangan, 80, '...') }}</td>
                        <td class="text-center">
                            <span class="badge bg-secondary px-3 py-2" style="font-size: 0.9rem;">
                                {{ $jr->mahasiswas_count ?? $jr->mahasiswas()->count() }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <!-- Tombol Detail -->
                                <a href="{{ route('jurusan.show', $jr->id) }}" class="btn btn-info btn-sm text-white">
                                    Detail
                                </a>
                                
                                <!-- Tombol Edit -->
                                <a href="{{ route('jurusan.edit', $jr->id) }}" class="btn btn-warning btn-sm text-white">
                                    Edit
                                </a>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('jurusan.destroy', $jr->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jurusan {{ $jr->nama_jurusan }}? Menghapus jurusan ini juga akan menghapus seluruh data mahasiswa yang terdaftar di dalamnya.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                Belum ada data jurusan yang tersedia.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Menampilkan tombol navigasi pagination jika data lebih dari limit per halaman -->
    @if ($jurusans->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $jurusans->links() }}
        </div>
    @endif
</div>
@endsection
