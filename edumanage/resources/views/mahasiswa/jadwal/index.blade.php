@extends('layouts.mahasiswa')

@section('title', 'Jadwal Kuliah')

@section('content')
<div class="content-header">
    <div class="content-title">Jadwal Kuliah Mahasiswa</div>
</div>

<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <div class="card-title">Jadwal Kuliah Kelas Anda (Kelas: {{ $kelas->nama_kelas ?? 'Belum terdaftar' }})</div>
        @if(isset($kelas))
            <span class="text-muted" style="font-size: 13px;">{{ $kelas->prodi }} - Angkatan {{ $kelas->angkatan }}</span>
        @endif
    </div>
    
    <div class="card-body">
        @if(!isset($kelas))
            <p class="text-danger text-center py-4">Kelas Anda belum dikonfigurasi. Silakan hubungi admin.</p>
        @elseif($jadwals->isEmpty())
            <p class="text-muted text-center py-4">Tidak ada jadwal kuliah terdaftar untuk kelas Anda saat ini.</p>
        @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">No</th>
                            <th>Hari</th>
                            <th>Waktu Kuliah</th>
                            <th>Mata Kuliah</th>
                            <th>Dosen Pengampu</th>
                            <th>SKS</th>
                            <th>Semester</th>
                            <th>Ruangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jadwals as $jd)
                            <tr>
                                <td>{{ ($jadwals->currentPage() - 1) * $jadwals->perPage() + $loop->iteration }}</td>
                                <td><strong>{{ $jd->hari }}</strong></td>
                                <td>{{ substr($jd->jam_mulai, 0, 5) }} - {{ substr($jd->jam_selesai, 0, 5) }}</td>
                                <td><strong>{{ $jd->mataKuliah->nama_mk }}</strong> ({{ $jd->mataKuliah->kode_mk }})</td>
                                <td>{{ $jd->dosen->nama }}</td>
                                <td class="text-center">{{ $jd->mataKuliah->sks }}</td>
                                <td class="text-center">{{ $jd->mataKuliah->semester }}</td>
                                <td><span class="badge badge-primary">{{ $jd->ruangan }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($jadwals->hasPages())
                <div class="pagination-wrapper">
                    {{ $jadwals->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
