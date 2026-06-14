@extends('layouts.' . strtolower(auth()->user()->role->name))

@section('title', 'Detail Kegiatan Belajar')

@section('content')
<div class="content-header">
    <div class="content-title">Detail Kegiatan Pembelajaran</div>
    
    @php
        $backUrl = route('kegiatan-belajar.index');
        $user = auth()->user();
        if ($user->hasRole('Dosen')) {
            $backUrl = route('dosen.kegiatan');
        } elseif ($user->hasRole('Mahasiswa')) {
            $backUrl = route('mahasiswa.kegiatan');
        } elseif ($user->hasRole('Kaprodi')) {
            $backUrl = route('kaprodi.kegiatan');
        }
    @endphp
    
    <a href="{{ $backUrl }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <div class="card-title">Jurnal Pertemuan Ke-{{ $kegiatan->pertemuan_ke }}</div>
        <div>
            @if($kegiatan->status === 'selesai')
                <span class="badge badge-success" style="font-size: 13px; padding: 6px 12px;">Selesai Terlaksana</span>
            @elseif($kegiatan->status === 'berlangsung')
                <span class="badge badge-warning" style="font-size: 13px; padding: 6px 12px;">Sedang Berlangsung</span>
            @else
                <span class="badge badge-primary" style="font-size: 13px; padding: 6px 12px;">Terjadwal</span>
            @endif
        </div>
    </div>
    
    <div class="card-body" style="padding: 32px;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 32px; border-bottom: 1px solid var(--border); padding-bottom: 24px;">
            <div>
                <p style="font-size: 12px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; margin-bottom: 4px;">Mata Kuliah</p>
                <p style="font-size: 16px; font-weight: 700; color: var(--text);">{{ $kegiatan->jadwalPembelajaran->mataKuliah->nama_mk }}</p>
                <p class="text-muted" style="font-size: 13px; margin-top: 2px;">Kode: {{ $kegiatan->jadwalPembelajaran->mataKuliah->kode_mk }} | {{ $kegiatan->jadwalPembelajaran->mataKuliah->sks }} SKS | Semester {{ $kegiatan->jadwalPembelajaran->mataKuliah->semester }}</p>
            </div>
            
            <div>
                <p style="font-size: 12px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; margin-bottom: 4px;">Kelas & Ruangan</p>
                <p style="font-size: 16px; font-weight: 700; color: var(--text);">Kelas: {{ $kegiatan->jadwalPembelajaran->kelas->nama_kelas }}</p>
                <p class="text-muted" style="font-size: 13px; margin-top: 2px;">Ruangan: {{ $kegiatan->jadwalPembelajaran->ruangan }} | Jadwal: {{ $kegiatan->jadwalPembelajaran->hari }} ({{ substr($kegiatan->jadwalPembelajaran->jam_mulai,0,5) }} - {{ substr($kegiatan->jadwalPembelajaran->jam_selesai,0,5) }})</p>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 32px; border-bottom: 1px solid var(--border); padding-bottom: 24px;">
            <div>
                <p style="font-size: 12px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; margin-bottom: 4px;">Dosen Pengampu</p>
                <p style="font-size: 15px; font-weight: 600; color: var(--text);">{{ $kegiatan->jadwalPembelajaran->dosen->nama }}</p>
                <p class="text-muted" style="font-size: 13px; margin-top: 2px;">NIDN: {{ $kegiatan->jadwalPembelajaran->dosen->nidn }}</p>
            </div>
            
            <div>
                <p style="font-size: 12px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; margin-bottom: 4px;">Tanggal Pelaksanaan</p>
                <p style="font-size: 15px; font-weight: 600; color: var(--text);"><i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($kegiatan->tanggal)->translatedFormat('l, d F Y') }}</p>
            </div>
        </div>

        <div style="margin-bottom: 24px;">
            <p style="font-size: 12px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Materi yang Diajarkan</p>
            <div style="background-color: #F8FAFC; padding: 16px 20px; border-radius: 8px; border: 1px solid var(--border); font-size: 14px; line-height: 1.6; font-weight: 500;">
                {{ $kegiatan->materi }}
            </div>
        </div>

        <div style="margin-bottom: 24px;">
            <p style="font-size: 12px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Metode Pembelajaran</p>
            <p style="font-size: 14px; font-weight: 500; color: var(--text);"><i class="fas fa-chalkboard"></i> {{ $kegiatan->metode_pembelajaran }}</p>
        </div>

        <!-- Kehadiran Mahasiswa -->
        <div style="margin-bottom: 24px; border-top: 1px solid var(--border); padding-top: 24px;">
            <p style="font-size: 12px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; margin-bottom: 12px;">Kehadiran Mahasiswa</p>
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; text-align: center;">
                <div style="background-color: #ECFDF5; border: 1px solid #A7F3D0; padding: 12px; border-radius: 8px;">
                    <span style="font-size: 20px; font-weight: 700; color: #065F46; display: block;">{{ $kegiatan->kehadiran_hadir ?? 0 }}</span>
                    <span style="font-size: 11px; font-weight: 600; color: #047857; text-transform: uppercase;">Hadir</span>
                </div>
                <div style="background-color: #FFFBEB; border: 1px solid #FDE68A; padding: 12px; border-radius: 8px;">
                    <span style="font-size: 20px; font-weight: 700; color: #92400E; display: block;">{{ $kegiatan->kehadiran_sakit ?? 0 }}</span>
                    <span style="font-size: 11px; font-weight: 600; color: #B45309; text-transform: uppercase;">Sakit</span>
                </div>
                <div style="background-color: #EFF6FF; border: 1px solid #BFDBFE; padding: 12px; border-radius: 8px;">
                    <span style="font-size: 20px; font-weight: 700; color: #1E40AF; display: block;">{{ $kegiatan->kehadiran_izin ?? 0 }}</span>
                    <span style="font-size: 11px; font-weight: 600; color: #1D4ED8; text-transform: uppercase;">Izin</span>
                </div>
                <div style="background-color: #FEF2F2; border: 1px solid #FCA5A5; padding: 12px; border-radius: 8px;">
                    <span style="font-size: 20px; font-weight: 700; color: #991B1B; display: block;">{{ $kegiatan->kehadiran_alfa ?? 0 }}</span>
                    <span style="font-size: 11px; font-weight: 600; color: #B91C1C; text-transform: uppercase;">Alfa</span>
                </div>
            </div>
        </div>

        @if($kegiatan->tugas)
            <div style="margin-bottom: 24px;">
                <p style="font-size: 12px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px; color: var(--danger);">Tugas Kuliah yang Diberikan</p>
                <div style="background-color: #FFF5F5; padding: 16px 20px; border-radius: 8px; border: 1px solid rgba(239, 68, 68, 0.2); font-size: 14px; line-height: 1.6; color: #991B1B;">
                    {{ $kegiatan->tugas }}
                </div>
            </div>
        @endif

        <div style="margin-bottom: 8px;">
            <p style="font-size: 12px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Catatan Pertemuan</p>
            <p style="font-size: 14px; line-height: 1.6; color: var(--text);">
                {{ $kegiatan->catatan ?? 'Tidak ada catatan tambahan untuk pertemuan ini.' }}
            </p>
        </div>
    </div>
</div>
@endsection
