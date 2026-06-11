@extends('layouts.app')

@section('title', 'Edit Mahasiswa')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm custom-card">
            <div class="custom-card-header">
                Edit Data Mahasiswa
            </div>
            <div class="custom-card-body">
                <!-- Form Edit Mahasiswa -->
                <form action="{{ route('mahasiswa.update', $mahasiswa->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Input NIM -->
                    <div class="mb-3">
                        <label for="nim" class="form-label">Nomor Induk Mahasiswa (NIM) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ old('nim', $mahasiswa->nim) }}" required>
                        @error('nim')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Input Nama -->
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $mahasiswa->nama) }}" required>
                        @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Input Jenis Kelamin -->
                    <div class="mb-3">
                        <label class="form-label d-block">Jenis Kelamin <span class="text-danger">*</span></label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" type="radio" name="jenis_kelamin" id="jk_l" value="L" {{ old('jenis_kelamin', $mahasiswa->jenis_kelamin) == 'L' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="jk_l">Laki-laki</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" type="radio" name="jenis_kelamin" id="jk_p" value="P" {{ old('jenis_kelamin', $mahasiswa->jenis_kelamin) == 'P' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="jk_p">Perempuan</label>
                        </div>
                        @error('jenis_kelamin')
                            <div class="text-danger mt-1" style="font-size: 0.875em;">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Input Jurusan -->
                    <div class="mb-3">
                        <label for="jurusan_id" class="form-label">Jurusan <span class="text-danger">*</span></label>
                        <select class="form-select @error('jurusan_id') is-invalid @enderror" id="jurusan_id" name="jurusan_id" required>
                            @foreach ($jurusans as $jr)
                                <option value="{{ $jr->id }}" {{ old('jurusan_id', $mahasiswa->jurusan_id) == $jr->id ? 'selected' : '' }}>{{ $jr->nama_jurusan }}</option>
                            @endforeach
                        </select>
                        @error('jurusan_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Input Tanggal Lahir -->
                    <div class="mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $mahasiswa->tanggal_lahir) }}" required>
                        @error('tanggal_lahir')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Input Nomor HP -->
                    <div class="mb-3">
                        <label for="no_hp" class="form-label">Nomor HP / WA <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp', $mahasiswa->no_hp) }}" required>
                        @error('no_hp')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Input Alamat -->
                    <div class="mb-4">
                        <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="4" required>{{ old('alamat', $mahasiswa->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-navy">
                            Perbarui Data
                        </button>
                        <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
