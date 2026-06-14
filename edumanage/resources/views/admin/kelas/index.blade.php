@extends('layouts.admin')

@section('title', 'Data Kelas')

@section('content')
<div class="content-header">
    <div class="content-title">Kelola Data Kelas</div>
    <a href="{{ route('kelas.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Kelas
    </a>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Daftar Kelas</div>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 80px;">No</th>
                        <th>Nama Kelas</th>
                        <th>Program Studi</th>
                        <th>Angkatan (Tahun)</th>
                        <th style="width: 200px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kelas as $kls)
                        <tr>
                            <td>{{ ($kelas->currentPage() - 1) * $kelas->perPage() + $loop->iteration }}</td>
                            <td><strong>{{ $kls->nama_kelas }}</strong></td>
                            <td>{{ $kls->prodi }}</td>
                            <td class="text-center">{{ $kls->angkatan }}</td>
                            <td style="text-align: center;">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('kelas.edit', $kls->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    
                                    <form action="{{ route('kelas.destroy', $kls->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">
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
                            <td colspan="5" class="text-muted text-center py-4">Belum ada data kelas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($kelas->hasPages())
            <div class="pagination-wrapper">
                {{ $kelas->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
