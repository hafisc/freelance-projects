@extends('layouts.guru')

@section('title', 'Progres Pembelajaran Siswa')

@section('style')
    <style>
        /* CARD TABLE */
        .table-wrapper {
            background: white;
            border-radius: 12px;
            padding: 20px;
        }

        /* DATATABLE BASE */
        table.dataTable {
            width: 100% !important;
            border-collapse: collapse;
        }

        /* HEADER TABLE */
        table.dataTable thead th {
            background: #e2e8f0;
            font-weight: 600;
            text-align: center;
            padding: 12px;
            border-bottom: 1px solid #cbd5e1;
        }

        /* BODY TABLE */
        table.dataTable tbody td {
            padding: 12px;
            text-align: center;
        }

        /* ZEBRA ROW */
        table.dataTable tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        /* ROW HOVER */
        table.dataTable tbody tr:hover {
            background: #eef2f7;
        }

        /* KOLOM KHUSUS */
        .name-cell {
            text-align: left !important;
        }

        .nisn-cell {
            width: 110px;
        }

        .aksi-cell {
            width: 120px;
        }

        /* ICON STATUS */
        .icon-check {
            color: #16a34a;
            font-size: 18px;
            font-weight: 600;
        }

        .icon-cross {
            color: #dc2626;
            font-size: 18px;
            font-weight: 600;
        }

        /* PROGRESS TEXT */
        .progres-text {
            font-weight: 600;
            color: #334155;
        }

        /* MODAL DETAIL */
        .modal-detail {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.45);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            padding: 25px;
            border-radius: 10px;
            width: 90%;
            max-width: 1100px;
            height: 80vh;
            overflow: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            font-size: 18px;
            font-weight: 600;
        }

        /* BUTTON CLOSE */
        .close-btn {
            background: #ef4444;
            border: none;
            color: white;
            font-size: 18px;
            width: 35px;
            height: 35px;
            border-radius: 6px;
            cursor: pointer;
        }

        .close-btn:hover {
            background: #dc2626;
        }

        /* DOWNLOAD BUTTON */
        .download-btn {
            display: inline-block;
            background: #16a34a;
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            text-decoration: none;
            margin-left: 6px;
        }

        .download-btn:hover {
            background: #15803d;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endsection


@section('guru-content')

    <main class="guru-content">

        <h1>Progres Pembelajaran Siswa</h1>

        <div class="table-wrapper">


            <table id="progresTable" class="display">

                <thead>
                    <tr>

                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>NISN</th>
                        <th>Kelas</th>

                        <th>L1.1</th>
                        <th>L1.2</th>
                        <th>K1</th>

                        <th>L2.1</th>
                        <th>L2.2</th>
                        <th>L2.3</th>
                        <th>L2.4</th>
                        <th>K2</th>

                        <th>L3.1</th>
                        <th>K3</th>
                        <th>Evaluasi</th>

                        <th>Progres</th>
                        <th>Aksi</th>

                    </tr>
                </thead>

                <tbody>

                    @forelse($students as $index => $s)

                        @php
                            $total = 11;

                            $done =
                                ($s->L11 ? 1 : 0) +
                                ($s->L12 ? 1 : 0) +
                                ($s->K1 ? 1 : 0) +
                                ($s->L21 ? 1 : 0) +
                                ($s->L22 ? 1 : 0) +
                                ($s->L23 ? 1 : 0) +
                                ($s->L24 ? 1 : 0) +
                                ($s->K2 ? 1 : 0) +
                                ($s->L31 ? 1 : 0) +
                                ($s->K3 ? 1 : 0) +
                                ($s->evaluasi ? 1 : 0);
                        @endphp

                        <tr>

                            <td>{{ $index + 1 }}</td>

                            <td class="name-cell">
                                {{ $s->name }}
                            </td>

                            <td class="nisn-cell">
                                {{ $s->username }}
                            </td>

                            <td>
                                {{ $s->kelas }}
                            </td>

                            <td>
                                @if($s->L11)
                                    <span class="icon-check">✔</span>
                                @else
                                    <span class="icon-cross">✖</span>
                                @endif
                            </td>


                            <td>
                                @if($s->L12)
                                    <span class="icon-check">✔</span>
                                @else
                                    <span class="icon-cross">✖</span>
                                @endif
                            </td>


                            <td>
                                @if($s->K1)
                                    <span class="icon-check">✔</span>
                                @else
                                    <span class="icon-cross">✖</span>
                                @endif
                            </td>


                            <td>
                                @if($s->L21)
                                    <span class="icon-check">✔</span>
                                @else
                                    <span class="icon-cross">✖</span>
                                @endif
                            </td>


                            <td>
                                @if($s->L22)
                                    <span class="icon-check">✔</span>
                                @else
                                    <span class="icon-cross">✖</span>
                                @endif
                            </td>


                            <td>
                                @if($s->L23)
                                    <span class="icon-check">✔</span>
                                @else
                                    <span class="icon-cross">✖</span>
                                @endif
                            </td>

                            <td>
                                @if($s->L24)
                                    <span class="icon-check">✔</span>
                                @else
                                    <span class="icon-cross">✖</span>
                                @endif
                            </td>
                            
                            
                            <td>
                                @if($s->K2)
                                <span class="icon-check">✔</span>
                                @else
                                <span class="icon-cross">✖</span>
                                @endif
                            </td>

                            <td>
                                @if($s->L31)
                                    <span class="icon-check">✔</span>
                                @else
                                    <span class="icon-cross">✖</span>
                                @endif
                            </td>


                            <td>
                                @if($s->K3)
                                    <span class="icon-check">✔</span>
                                @else
                                    <span class="icon-cross">✖</span>
                                @endif
                            </td>


                            <td>
                                @if($s->evaluasi)
                                    <span class="icon-check">✔</span>
                                @else
                                    <span class="icon-cross">✖</span>
                                @endif
                            </td>


                            <td class="progres-text">
                                {{ $done }} dari {{ $total }}
                            </td>

                            <td class="aksi-cell">

                                @if($s->submissions->count() > 0)

                                    <button class="next-btn" onclick="showDetail({{ $s->id }})">
                                        Detail
                                    </button>

                                @else
                                    <span style="color:#94a3b8;">
                                        Belum Upload
                                    </span>
                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="11" style="padding:20px; text-align:center;">
                                Belum ada data siswa.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

            <div id="detailModal" class="modal-detail" style="display:none;">
                <div class="modal-content">

                    <div class="modal-header">
                        <h3>Detail Pengumpulan Tugas</h3>
                        <button onclick="closeModal()" class="close-btn">
                            ✕
                        </button>
                    </div>

                    <table class="progres-table">
                        <thead>
                            <tr>
                                <th>Latihan</th>
                                <th>Waktu Submit</th>
                                <th>Preview</th>
                            </tr>
                        </thead>
                        <tbody id="detailBody">
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
        </div>
    </main>

    <script>

        const submissions = @json(
            $students->mapWithKeys(function ($s) {

                $latestSubmissions = $s->submissions
                    ->sortByDesc('created_at')
                    ->unique('latihan_code')
                    ->values();

                return [
                    $s->id => $latestSubmissions->map(function ($sub) {
                        return [
                            'latihan' => $sub->latihan_code,
                            'waktu' => $sub->created_at->format('d M Y H:i'),
                            'file' => asset($sub->file_path)
                        ];
                    })
                ];
            })
        );

        function showDetail(userId) {

            let data = submissions[userId];
            let body = document.getElementById("detailBody");

            body.innerHTML = "";

            if (data) {
                data.sort((a, b) => {
                    return a.latihan.localeCompare(b.latihan, undefined, { numeric: true });
                });
            }

            if (!data || data.length === 0) {

                body.innerHTML = "<tr><td colspan='3'>Belum ada pengumpulan</td></tr>";

            } else {

                data.forEach(item => {

                    body.innerHTML += `
                <tr>
                    <td>${item.latihan}</td>
                    <td>${item.waktu}</td>
                    <td>
                        <a href="${item.file}" target="_blank" class="btn">
                            Preview
                        </a>

                        <a href="${item.file}" download class="download-btn">
                            Download
                        </a>
                    </td>
                </tr>
                `;

                });

            }

            document.getElementById("detailModal").style.display = "flex";
        }

        function closeModal() {
            document.getElementById("detailModal").style.display = "none";
        }

    </script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {

            $('#progresTable').DataTable({
                pageLength: 10,
                lengthChange: false,
                ordering: true,
                autoWidth: false,
                language: {
                    search: "Cari:",
                    paginate: {
                        next: "Next",
                        previous: "Prev"
                    },
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ siswa"
                }
            });

        });
    </script>

@endsection