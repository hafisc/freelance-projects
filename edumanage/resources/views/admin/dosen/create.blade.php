@extends('layouts.admin')

@section('title', 'Tambah Dosen')

@section('content')
<div class="content-header">
    <div class="content-title">Tambah Dosen Baru</div>
    <a href="{{ route('dosen.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card" style="max-width: 700px; margin: 0 auto;">
    <div class="card-header">
        <div class="card-title">Form Input Dosen & Akun Pengguna</div>
    </div>
    
    <div class="card-body">
        <form action="{{ route('dosen.store') }}" method="POST">
            @csrf
            
            <h3 style="font-size: 15px; font-weight: 600; color: var(--primary); border-bottom: 1px solid var(--border); padding-bottom: 8px; margin-bottom: 16px;">
                <i class="fas fa-id-card"></i> 1. Profil Dosen
            </h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label for="nidn" class="form-label">NIDN <span class="text-danger">*</span></label>
                    <input type="text" name="nidn" id="nidn" class="form-control @error('nidn') is-invalid @enderror" placeholder="Contoh: 0412345678" value="{{ old('nidn') }}" required>
                    @error('nidn')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama lengkap dosen beserta gelar..." value="{{ old('nama') }}" required>
                    @error('nama')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control form-select @error('jenis_kelamin') is-invalid @enderror" required>
                        <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="no_hp" class="form-label">Nomor Handphone</label>
                    <input type="text" name="no_hp" id="no_hp" class="form-control @error('no_hp') is-invalid @enderror" placeholder="08..." value="{{ old('no_hp') }}">
                    @error('no_hp')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="alamat" class="form-label">Alamat Lengkap</label>
                <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat dosen saat ini..." rows="3">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <h3 style="font-size: 15px; font-weight: 600; color: var(--primary); border-bottom: 1px solid var(--border); padding-bottom: 8px; margin-top: 24px; margin-bottom: 16px;">
                <i class="fas fa-lock"></i> 2. Kredensial Akun Login
            </h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label for="email" class="form-label">Email Login <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="dosen@edumanage.test" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Kata Sandi Login <span class="text-danger">*</span></label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Min. 6 karakter" required>
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2" style="margin-top: 32px; border-top: 1px solid var(--border); padding-top: 20px;">
                <a href="{{ route('dosen.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Dosen
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
