@extends('layouts.admin')

@section('title', 'Edit Mata Kuliah')

@section('content')
<div class="content-header">
    <div class="content-title">Edit Mata Kuliah</div>
    <a href="{{ route('mata-kuliah.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header">
        <div class="card-title">Form Edit: {{ $mataKuliah->nama_mk }}</div>
    </div>
    
    <div class="card-body">
        <form action="{{ route('mata-kuliah.update', $mataKuliah->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="kode_mk" class="form-label">Kode Mata Kuliah <span class="text-danger">*</span></label>
                <input type="text" name="kode_mk" id="kode_mk" class="form-control @error('kode_mk') is-invalid @enderror" value="{{ old('kode_mk', $mataKuliah->kode_mk) }}" required>
                @error('kode_mk')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="nama_mk" class="form-label">Nama Mata Kuliah <span class="text-danger">*</span></label>
                <input type="text" name="nama_mk" id="nama_mk" class="form-control @error('nama_mk') is-invalid @enderror" value="{{ old('nama_mk', $mataKuliah->nama_mk) }}" required>
                @error('nama_mk')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label for="sks" class="form-label">Jumlah SKS <span class="text-danger">*</span></label>
                    <input type="number" name="sks" id="sks" class="form-control @error('sks') is-invalid @enderror" value="{{ old('sks', $mataKuliah->sks) }}" required min="1" max="6">
                    @error('sks')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                    <input type="number" name="semester" id="semester" class="form-control @error('semester') is-invalid @enderror" value="{{ old('semester', $mataKuliah->semester) }}" required min="1" max="8">
                    @error('semester')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2" style="margin-top: 24px;">
                <a href="{{ route('mata-kuliah.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
