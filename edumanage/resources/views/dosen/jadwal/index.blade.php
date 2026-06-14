@extends('layouts.dosen')

@section('title', 'Jadwal Mengajar')

@section('content')
<div class="content-header">
    <div class="content-title">Jadwal Mengajar Dosen</div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Jadwal Mengajar Anda (Dosen: {{ $dosen->nama }})</div>
    </div>
    
    <div class="card-body">
        @if($jadwals->isEmpty())
            <p class="text-muted text-center py-4">Anda tidak memiliki jadwal mengajar yang terdaftar saat ini.</p>
        @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">No</th>
                            <th>Hari</th>
                            <th>Waktu Mengajar</th>
                            <th>Kelas</th>
                            <th>Mata Kuliah</th>
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
                                <td><span class="badge badge-success">{{ $jd->kelas->nama_kelas }}</span></td>
                                <td><strong>{{ $jd->mataKuliah->nama_mk }}</strong> ({{ $jd->mataKuliah->kode_mk }})</td>
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
