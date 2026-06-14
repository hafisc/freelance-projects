@extends('layouts.admin')

@section('title', 'Tambah Kelas')

@section('content')
<div class="content-header">
    <div class="content-title">Tambah Kelas Baru</div>
    <a href="{{ route('kelas.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header">
        <div class="card-title">Form Input Kelas</div>
    </div>
    
    <div class="card-body">
        <form action="{{ route('kelas.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="nama_kelas" class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                <input type="text" name="nama_kelas" id="nama_kelas" class="form-control @error('nama_kelas') is-invalid @enderror" placeholder="Contoh: IF-4A" value="{{ old('nama_kelas') }}" required>
                @error('nama_kelas')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="prodi" class="form-label">Program Studi <span class="text-danger">*</span></label>
                <input type="text" name="prodi" id="prodi" class="form-control @error('prodi') is-invalid @enderror" placeholder="Contoh: Teknik Informatika" value="{{ old('prodi') }}" required>
                @error('prodi')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="angkatan" class="form-label">Angkatan (Tahun) <span class="text-danger">*</span></label>
                <input type="number" name="angkatan" id="angkatan" class="form-control @error('angkatan') is-invalid @enderror" placeholder="Contoh: 2022" value="{{ old('angkatan') }}" required min="2000" max="2100">
                @error('angkatan')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2" style="margin-top: 24px;">
                <a href="{{ route('kelas.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Kelas
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
