@extends('layouts.kaprodi')

@section('title', 'Monitoring Jadwal')

@section('content')
<div class="content-header">
    <div class="content-title">Monitoring Jadwal Pembelajaran</div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Seluruh Jadwal Kuliah Program Studi</div>
    </div>
    
    <div class="card-body">
        @if($jadwal->isEmpty())
            <p class="text-muted text-center py-4">Belum ada data jadwal pembelajaran terdaftar.</p>
        @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">No</th>
                            <th>Hari</th>
                            <th>Waktu</th>
                            <th>Kelas</th>
                            <th>Mata Kuliah</th>
                            <th>Dosen Pengampu</th>
                            <th>Ruangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jadwal as $jd)
                            <tr>
                                <td>{{ ($jadwal->currentPage() - 1) * $jadwal->perPage() + $loop->iteration }}</td>
                                <td><strong>{{ $jd->hari }}</strong></td>
                                <td>{{ substr($jd->jam_mulai, 0, 5) }} - {{ substr($jd->jam_selesai, 0, 5) }}</td>
                                <td><span class="badge badge-success">{{ $jd->kelas->nama_kelas }}</span></td>
                                <td><strong>{{ $jd->mataKuliah->nama_mk }}</strong> ({{ $jd->mataKuliah->kode_mk }})</td>
                                <td>{{ $jd->dosen->nama }}</td>
                                <td><span class="badge badge-primary">{{ $jd->ruangan }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($jadwal->hasPages())
                <div class="pagination-wrapper">
                    {{ $jadwal->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
