@extends('layouts.admin')

@section('title', 'Data Mata Kuliah')

@section('content')
<div class="content-header">
    <div class="content-title">Kelola Mata Kuliah</div>
    <a href="{{ route('mata-kuliah.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Matakuliah
    </a>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Daftar Mata Kuliah Terdaftar</div>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 80px;">No</th>
                        <th>Kode MK</th>
                        <th>Nama Mata Kuliah</th>
                        <th>SKS</th>
                        <th>Semester</th>
                        <th style="width: 200px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mataKuliah as $mk)
                        <tr>
                            <td>{{ ($mataKuliah->currentPage() - 1) * $mataKuliah->perPage() + $loop->iteration }}</td>
                            <td><span class="badge badge-primary">{{ $mk->kode_mk }}</span></td>
                            <td><strong>{{ $mk->nama_mk }}</strong></td>
                            <td class="text-center">{{ $mk->sks }}</td>
                            <td class="text-center">{{ $mk->semester }}</td>
                            <td style="text-align: center;">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('mata-kuliah.edit', $mk->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    
                                    <form action="{{ route('mata-kuliah.destroy', $mk->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata kuliah ini?')">
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
                            <td colspan="6" class="text-muted text-center py-4">Belum ada data mata kuliah.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($mataKuliah->hasPages())
            <div class="pagination-wrapper">
                {{ $mataKuliah->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
