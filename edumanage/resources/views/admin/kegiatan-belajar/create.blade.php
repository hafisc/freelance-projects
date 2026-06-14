@extends('layouts.admin')

@section('title', 'Tambah Kegiatan')

@section('content')
<div class="content-header">
    <div class="content-title">Tambah Kegiatan Belajar Baru</div>
    <a href="{{ route('kegiatan-belajar.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card" style="max-width: 700px; margin: 0 auto;">
    <div class="card-header">
        <div class="card-title">Form Jurnal Kegiatan Belajar</div>
    </div>
    
    <div class="card-body">
        <form action="{{ route('kegiatan-belajar.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="jadwal_pembelajaran_id" class="form-label">Jadwal Pembelajaran <span class="text-danger">*</span></label>
                <select name="jadwal_pembelajaran_id" id="jadwal_pembelajaran_id" class="form-control form-select @error('jadwal_pembelajaran_id') is-invalid @enderror" required>
                    <option value="" disabled selected>-- Pilih Jadwal & Kelas --</option>
                    @foreach($jadwals as $jd)
                        <option value="{{ $jd->id }}" {{ old('jadwal_pembelajaran_id') == $jd->id ? 'selected' : '' }}>
                            {{ $jd->hari }}, {{ substr($jd->jam_mulai,0,5) }}-{{ substr($jd->jam_selesai,0,5) }} | {{ $jd->kelas->nama_kelas }} | {{ $jd->mataKuliah->nama_mk }} (Dosen: {{ $jd->dosen->nama }})
                        </option>
                    @endforeach
                </select>
                @error('jadwal_pembelajaran_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label for="pertemuan_ke" class="form-label">Pertemuan Ke- <span class="text-danger">*</span></label>
                    <input type="number" name="pertemuan_ke" id="pertemuan_ke" class="form-control @error('pertemuan_ke') is-invalid @enderror" placeholder="1 s/d 16" value="{{ old('pertemuan_ke') }}" required min="1" max="16">
                    @error('pertemuan_ke')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tanggal" class="form-label">Tanggal Kegiatan <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                    @error('tanggal')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="materi" class="form-label">Materi Pembelajaran <span class="text-danger">*</span></label>
                <input type="text" name="materi" id="materi" class="form-control @error('materi') is-invalid @enderror" placeholder="Contoh: Pembuatan Model MVC dan Database Routing" value="{{ old('materi') }}" required>
                @error('materi')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label for="metode_pembelajaran" class="form-label">Metode Pembelajaran <span class="text-danger">*</span></label>
                    <input type="text" name="metode_pembelajaran" id="metode_pembelajaran" class="form-control @error('metode_pembelajaran') is-invalid @enderror" placeholder="Contoh: Ceramah, Praktikum Mandiri" value="{{ old('metode_pembelajaran') }}" required>
                    @error('metode_pembelajaran')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">Status Pertemuan <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-control form-select @error('status') is-invalid @enderror" required>
                        <option value="terjadwal" {{ old('status') == 'terjadwal' ? 'selected' : '' }}>Terjadwal</option>
                        <option value="berlangsung" {{ old('status') == 'berlangsung' ? 'selected' : '' }}>Berlangsung</option>
                        <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Absensi Mahasiswa -->
            <div style="border-top: 1px dashed var(--border); padding-top: 20px; margin-top: 20px; margin-bottom: 20px;">
                <h4 style="font-size: 14px; font-weight: 600; color: var(--text); margin-bottom: 12px;"><i class="fas fa-user-check"></i> Absensi Kehadiran Mahasiswa</h4>
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="kehadiran_hadir" class="form-label" style="font-size: 12px;">Hadir</label>
                        <input type="number" name="kehadiran_hadir" id="kehadiran_hadir" class="form-control @error('kehadiran_hadir') is-invalid @enderror" value="{{ old('kehadiran_hadir', 0) }}" min="0">
                        @error('kehadiran_hadir')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="kehadiran_sakit" class="form-label" style="font-size: 12px; color: var(--warning);">Sakit</label>
                        <input type="number" name="kehadiran_sakit" id="kehadiran_sakit" class="form-control @error('kehadiran_sakit') is-invalid @enderror" value="{{ old('kehadiran_sakit', 0) }}" min="0">
                        @error('kehadiran_sakit')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="kehadiran_izin" class="form-label" style="font-size: 12px; color: var(--primary);">Izin</label>
                        <input type="number" name="kehadiran_izin" id="kehadiran_izin" class="form-control @error('kehadiran_izin') is-invalid @enderror" value="{{ old('kehadiran_izin', 0) }}" min="0">
                        @error('kehadiran_izin')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="kehadiran_alfa" class="form-label" style="font-size: 12px; color: var(--danger);">Alfa</label>
                        <input type="number" name="kehadiran_alfa" id="kehadiran_alfa" class="form-control @error('kehadiran_alfa') is-invalid @enderror" value="{{ old('kehadiran_alfa', 0) }}" min="0">
                        @error('kehadiran_alfa')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="tugas" class="form-label">Tugas Kuliah (Opsional)</label>
                <textarea name="tugas" id="tugas" class="form-control @error('tugas') is-invalid @enderror" placeholder="Isi deskripsi tugas jika ada..." rows="3">{{ old('tugas') }}</textarea>
                @error('tugas')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="catatan" class="form-label">Catatan Tambahan (Opsional)</label>
                <textarea name="catatan" id="catatan" class="form-control @error('catatan') is-invalid @enderror" placeholder="Catatan jalannya perkuliahan atau kendala kelas..." rows="3">{{ old('catatan') }}</textarea>
                @error('catatan')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2" style="margin-top: 32px; border-top: 1px solid var(--border); padding-top: 20px;">
                <a href="{{ route('kegiatan-belajar.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Kegiatan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
