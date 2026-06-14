@extends('layouts.admin')

@section('title', 'Data Mahasiswa')

@section('content')
<div class="content-header">
    <div class="content-title">Kelola Data Mahasiswa</div>
    <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Mahasiswa
    </a>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Daftar Mahasiswa Aktif</div>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Program Studi</th>
                        <th>Angkatan</th>
                        <th>Jenis Kelamin</th>
                        <th>Email Login</th>
                        <th style="width: 180px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mahasiswa as $mhs)
                        <tr>
                            <td>{{ ($mahasiswa->currentPage() - 1) * $mahasiswa->perPage() + $loop->iteration }}</td>
                            <td><strong>{{ $mhs->nim }}</strong></td>
                            <td>{{ $mhs->nama }}</td>
                            <td>{{ $mhs->prodi }}</td>
                            <td class="text-center">{{ $mhs->angkatan }}</td>
                            <td>{{ $mhs->jenis_kelamin }}</td>
                            <td>{{ $mhs->user->email ?? '-' }}</td>
                            <td style="text-align: center;">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('mahasiswa.edit', $mhs->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    
                                    <form action="{{ route('mahasiswa.destroy', $mhs->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data mahasiswa ini? Akun login terkait juga akan dihapus.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-muted text-center py-4">Belum ada data mahasiswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($mahasiswa->hasPages())
            <div class="pagination-wrapper">
                {{ $mahasiswa->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
