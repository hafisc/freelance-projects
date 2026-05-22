@extends('layouts.app')

@section('title', 'Detail Jurusan')

@section('content')
<div class="card border-0 shadow-sm custom-card mb-4">
    <div class="custom-card-header">
        Detail Informasi Jurusan
    </div>
    <div class="custom-card-body">
        <div class="row mb-3">
            <div class="col-md-3 text-secondary font-weight-bold">Nama Jurusan:</div>
            <div class="col-md-9"><strong>{{ $jurusan->nama_jurusan }}</strong></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3 text-secondary font-weight-bold">Keterangan:</div>
            <div class="col-md-9" style="line-height: 1.6;">{{ $jurusan->keterangan ?? 'Tidak ada keterangan tambahan.' }}</div>
        </div>
        <div class="row">
            <div class="col-md-3 text-secondary font-weight-bold">Jumlah Mahasiswa Aktif:</div>
            <div class="col-md-9">
                <span class="badge bg-navy px-3 py-2">{{ $jurusan->mahasiswas->count() }} Orang</span>
            </div>
        </div>
    </div>
    <div class="card-footer bg-white border-0 py-3">
        <a href="{{ route('jurusan.index') }}" class="btn btn-secondary btn-sm">Kembali ke Daftar Jurusan</a>
        <a href="{{ route('jurusan.edit', $jurusan->id) }}" class="btn btn-warning btn-sm text-white">Edit Jurusan</a>
    </div>
</div>

<!-- Daftar Mahasiswa Terdaftar -->
<div class="card border-0 shadow-sm custom-card">
    <div class="custom-card-header">
        Daftar Mahasiswa di Jurusan {{ $jurusan->nama_jurusan }}
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-custom mb-0">
            <thead>
                <tr>
                    <th style="width: 80px;">No</th>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Jenis Kelamin</th>
                    <th>No. HP</th>
                    <th style="width: 180px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jurusan->mahasiswas as $index => $mhs)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $mhs->nim }}</strong></td>
                        <td>{{ $mhs->nama }}</td>
                        <td>
                            @if ($mhs->jenis_kelamin == 'L')
                                Laki-laki
                            @else
                                Perempuan
                            @endif
                        </td>
                        <td>{{ $mhs->no_hp }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('mahasiswa.show', $mhs->id) }}" class="btn btn-info btn-sm text-white">
                                    Detail
                                </a>
                                <a href="{{ route('mahasiswa.edit', $mhs->id) }}" class="btn btn-warning btn-sm text-white">
                                    Edit
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                Belum ada mahasiswa yang terdaftar pada jurusan ini.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
