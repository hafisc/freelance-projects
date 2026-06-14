@extends('layouts.admin')

@section('title', 'Data Dosen')

@section('content')
<div class="content-header">
    <div class="content-title">Kelola Data Dosen</div>
    <a href="{{ route('dosen.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Dosen
    </a>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Daftar Dosen Pengampu</div>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>NIDN</th>
                        <th>Nama Dosen</th>
                        <th>Jenis Kelamin</th>
                        <th>Nomor Handphone</th>
                        <th>Email Login</th>
                        <th style="width: 180px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dosen as $dsn)
                        <tr>
                            <td>{{ ($dosen->currentPage() - 1) * $dosen->perPage() + $loop->iteration }}</td>
                            <td><strong>{{ $dsn->nidn }}</strong></td>
                            <td>{{ $dsn->nama }}</td>
                            <td>{{ $dsn->jenis_kelamin }}</td>
                            <td>{{ $dsn->no_hp ?? '-' }}</td>
                            <td>{{ $dsn->user->email ?? '-' }}</td>
                            <td style="text-align: center;">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('dosen.edit', $dsn->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    
                                    <form action="{{ route('dosen.destroy', $dsn->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data dosen ini? Semua jadwal dan akun login terkait juga akan dihapus.')">
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
                            <td colspan="7" class="text-muted text-center py-4">Belum ada data dosen.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($dosen->hasPages())
            <div class="pagination-wrapper">
                {{ $dosen->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
