@extends('layouts.app')

@section('title', 'Detail Mahasiswa')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm custom-card">
            <div class="custom-card-header">
                Detail Informasi Mahasiswa
            </div>
            <div class="custom-card-body p-4">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0" style="vertical-align: middle;">
                        <tbody>
                            <tr>
                                <th style="width: 250px; background-color: #F8FAFC; color: #475569;">Nomor Induk Mahasiswa (NIM)</th>
                                <td><strong>{{ $mahasiswa->nim }}</strong></td>
                            </tr>
                            <tr>
                                <th style="background-color: #F8FAFC; color: #475569;">Nama Lengkap</th>
                                <td>{{ $mahasiswa->nama }}</td>
                            </tr>
                            <tr>
                                <th style="background-color: #F8FAFC; color: #475569;">Jenis Kelamin</th>
                                <td>
                                    @if ($mahasiswa->jenis_kelamin == 'L')
                                        Laki-laki
                                    @else
                                        Perempuan
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th style="background-color: #F8FAFC; color: #475569;">Jurusan Kuliah</th>
                                <td>
                                    <a href="{{ route('jurusan.show', $mahasiswa->jurusan->id) }}" class="text-decoration-none font-weight-bold">
                                        {{ $mahasiswa->jurusan->nama_jurusan }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th style="background-color: #F8FAFC; color: #475569;">Tanggal Lahir</th>
                                <td>{{ \Carbon\Carbon::parse($mahasiswa->tanggal_lahir)->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <th style="background-color: #F8FAFC; color: #475569;">Nomor HP / WA</th>
                                <td>{{ $mahasiswa->no_hp }}</td>
                            </tr>
                            <tr>
                                <th style="background-color: #F8FAFC; color: #475569;">Alamat Lengkap</th>
                                <td style="line-height: 1.6;">{{ $mahasiswa->alamat }}</td>
                            </tr>
                            <tr>
                                <th style="background-color: #F8FAFC; color: #475569;">Tanggal Terdaftar</th>
                                <td>{{ $mahasiswa->created_at->format('d M Y, H:i') }} WIB</td>
                            </tr>
                            <tr>
                                <th style="background-color: #F8FAFC; color: #475569;">Terakhir Diperbarui</th>
                                <td>{{ $mahasiswa->updated_at->format('d M Y, H:i') }} WIB</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-0 py-3 d-flex gap-2">
                <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary btn-sm">
                    Kembali ke Daftar Mahasiswa
                </a>
                <a href="{{ route('mahasiswa.edit', $mahasiswa->id) }}" class="btn btn-warning btn-sm text-white">
                    Edit Mahasiswa
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
