@extends('layouts.admin')

@section('title', 'Edit Jadwal')

@section('content')
<div class="content-header">
    <div class="content-title">Edit Jadwal Pembelajaran</div>
    <a href="{{ route('jadwal-pembelajaran.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card" style="max-width: 650px; margin: 0 auto;">
    <div class="card-header">
        <div class="card-title">Form Edit Jadwal: {{ $jadwal->mataKuliah->nama_mk }} - Kelas {{ $jadwal->kelas->nama_kelas }}</div>
    </div>
    
    <div class="card-body">
        <form action="{{ route('jadwal-pembelajaran.update', $jadwal->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="kelas_id" class="form-label">Kelas <span class="text-danger">*</span></label>
                <select name="kelas_id" id="kelas_id" class="form-control form-select @error('kelas_id') is-invalid @enderror" required>
                    @foreach($kelas as $kls)
                        <option value="{{ $kls->id }}" {{ old('kelas_id', $jadwal->kelas_id) == $kls->id ? 'selected' : '' }}>{{ $kls->nama_kelas }} ({{ $kls->prodi }} - {{ $kls->angkatan }})</option>
                    @endforeach
                </select>
                @error('kelas_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="mata_kuliah_id" class="form-label">Mata Kuliah <span class="text-danger">*</span></label>
                <select name="mata_kuliah_id" id="mata_kuliah_id" class="form-control form-select @error('mata_kuliah_id') is-invalid @enderror" required>
                    @foreach($mataKuliah as $mk)
                        <option value="{{ $mk->id }}" {{ old('mata_kuliah_id', $jadwal->mata_kuliah_id) == $mk->id ? 'selected' : '' }}>{{ $mk->nama_mk }} ({{ $mk->kode_mk }} - {{ $mk->sks }} SKS)</option>
                    @endforeach
                </select>
                @error('mata_kuliah_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="dosen_id" class="form-label">Dosen Pengampu <span class="text-danger">*</span></label>
                <select name="dosen_id" id="dosen_id" class="form-control form-select @error('dosen_id') is-invalid @enderror" required>
                    @foreach($dosen as $dsn)
                        <option value="{{ $dsn->id }}" {{ old('dosen_id', $jadwal->dosen_id) == $dsn->id ? 'selected' : '' }}>{{ $dsn->nama }} (NIDN: {{ $dsn->nidn }})</option>
                    @endforeach
                </select>
                @error('dosen_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label for="hari" class="form-label">Hari <span class="text-danger">*</span></label>
                    <select name="hari" id="hari" class="form-control form-select @error('hari') is-invalid @enderror" required>
                        <option value="Senin" {{ old('hari', $jadwal->hari) == 'Senin' ? 'selected' : '' }}>Senin</option>
                        <option value="Selasa" {{ old('hari', $jadwal->hari) == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                        <option value="Rabu" {{ old('hari', $jadwal->hari) == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                        <option value="Kamis" {{ old('hari', $jadwal->hari) == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                        <option value="Jumat" {{ old('hari', $jadwal->hari) == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                        <option value="Sabtu" {{ old('hari', $jadwal->hari) == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                    </select>
                    @error('hari')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="ruangan" class="form-label">Ruangan <span class="text-danger">*</span></label>
                    <input type="text" name="ruangan" id="ruangan" class="form-control @error('ruangan') is-invalid @enderror" value="{{ old('ruangan', $jadwal->ruangan) }}" required>
                    @error('ruangan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label for="jam_mulai" class="form-label">Jam Mulai <span class="text-danger">*</span></label>
                    <input type="time" name="jam_mulai" id="jam_mulai" class="form-control @error('jam_mulai') is-invalid @enderror" value="{{ old('jam_mulai', substr($jadwal->jam_mulai, 0, 5)) }}" required>
                    @error('jam_mulai')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jam_selesai" class="form-label">Jam Selesai <span class="text-danger">*</span></label>
                    <input type="time" name="jam_selesai" id="jam_selesai" class="form-control @error('jam_selesai') is-invalid @enderror" value="{{ old('jam_selesai', substr($jadwal->jam_selesai, 0, 5)) }}" required>
                    @error('jam_selesai')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2" style="margin-top: 32px; border-top: 1px solid var(--border); padding-top: 20px;">
                <a href="{{ route('jadwal-pembelajaran.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
