@extends('layouts.app')

@section('title', 'Data Mahasiswa')

@section('content')
<div class="card border-0 shadow-sm custom-card">
    <div class="custom-card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <span>Daftar Mahasiswa</span>
        
        <!-- Form Pencarian Mahasiswa -->
        <form action="{{ route('mahasiswa.index') }}" method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama atau NIM..." value="{{ $search }}" style="width: 220px;">
            <button type="submit" class="btn btn-navy btn-sm">Cari</button>
            @if(!empty($search))
                <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary btn-sm">Reset</a>
            @endif
        </form>
        
        <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary btn-sm">Tambah Mahasiswa Baru</a>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover table-custom mb-0">
            <thead>
                <tr>
                    <th style="width: 80px;">No</th>
                    <th>NIM</th>
                    <th>Nama Lengkap</th>
                    <th>Jenis Kelamin</th>
                    <th>Jurusan</th>
                    <th>No. HP</th>
                    <th style="width: 220px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mahasiswas as $index => $mhs)
                    <tr>
                        <td>{{ $mahasiswas->firstItem() + $index }}</td>
                        <td><strong>{{ $mhs->nim }}</strong></td>
                        <td>{{ $mhs->nama }}</td>
                        <td>
                            @if($mhs->jenis_kelamin == 'L')
                                Laki-laki
                            @else
                                Perempuan
                            @endif
                        </td>
                        <td>{{ $mhs->jurusan->nama_jurusan }}</td>
                        <td>{{ $mhs->no_hp }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <!-- Tombol Detail -->
                                <a href="{{ route('mahasiswa.show', $mhs->id) }}" class="btn btn-info btn-sm text-white">
                                    Detail
                                </a>
                                
                                <!-- Tombol Edit -->
                                <a href="{{ route('mahasiswa.edit', $mhs->id) }}" class="btn btn-warning btn-sm text-white">
                                    Edit
                                </a>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('mahasiswa.destroy', $mhs->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data mahasiswa {{ $mhs->nama }}?')">
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
                        <td colspan="7">
                            <div class="empty-state">
                                @if(!empty($search))
                                    Tidak ditemukan data mahasiswa yang cocok dengan pencarian "{{ $search }}".
                                @else
                                    Belum ada data mahasiswa yang terdaftar di sistem.
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Menampilkan tombol navigasi pagination jika data lebih dari limit per halaman -->
    @if ($mahasiswas->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $mahasiswas->links() }}
        </div>
    @endif
</div>
@endsection
