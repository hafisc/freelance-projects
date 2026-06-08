@extends('layouts.guru')

@section('title', 'Pengumpulan Tugas Gelombang')

@section('guru-content')

<main class="guru-content">

    <h1>Daftar Pengumpulan Tugas Gelombang</h1>

    <div class="box" style="margin-top:20px;">

        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#f1f5f9;">
                    <th style="padding:10px;">No</th>
                    <th style="padding:10px;">Nama Siswa</th>
                    <th style="padding:10px;">Waktu Submit</th>
                    <th style="padding:10px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $index => $item)
                    <tr style="border-bottom:1px solid #e5e7eb;">
                        <td style="padding:10px;">
                            {{ $index + 1 }}
                        </td>

                        <td style="padding:10px;">
                            {{ $item->user->name }}
                        </td>

                        <td style="padding:10px;">
                            {{ $item->created_at->format('d M Y H:i') }}
                        </td>

                        <td style="padding:10px;">
                            
                            {{-- PREVIEW --}}
                            <a href="{{ asset('storage/'.$item->file_path) }}"
                               target="_blank"
                               class="next-btn"
                               style="margin-right:8px;">
                                👁 Preview
                            </a>

                            {{-- DOWNLOAD --}}
                            <a href="{{ asset('storage/'.$item->file_path) }}"
                               download
                               class="next-btn">
                                ⬇ Download
                            </a>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="padding:15px; text-align:center;">
                            Belum ada siswa yang mengumpulkan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

</main>

@endsection 