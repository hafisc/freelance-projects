@extends('layouts.guru')

@section('title', 'Analisis Butir Soal')

@section('guru-content')

<main class="guru-content">

    <h1>Data Soal</h1>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pertanyaan</th>
                    <th>Opsi A</th>
                    <th>Opsi B</th>
                    <th>Opsi C</th>
                    <th>Opsi D</th>
                    <th>Opsi E</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($analysis as $i => $row)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $row->question }}</td>
                        <td>{{ $row->option_a }}</td>
                        <td>{{ $row->option_b }}</td>
                        <td>{{ $row->option_c }}</td>
                        <td>{{ $row->option_d }}</td>
                        <td>{{ $row->option_e }}</td>
                        <td>
                            <button class="btn" onclick='openEditModal(@json($row))'>
                                Edit
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</main>

    {{-- ================= MODAL EDIT ================= --}}
    <div id="editModal" class="modal-overlay" style="display:none;">
        <div class="modal modal-lg">

            <h3 class="modal-title">Edit Soal</h3>

            <form method="POST" id="editForm">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Pertanyaan</label>
                    <textarea name="question" id="editQuestion" required></textarea>
                </div>

                <div class="option-grid">
                    <div class="form-group">
                        <label>Opsi A</label>
                        <input type="text" name="option_a" id="editA" required>
                    </div>

                    <div class="form-group">
                        <label>Opsi B</label>
                        <input type="text" name="option_b" id="editB" required>
                    </div>

                    <div class="form-group">
                        <label>Opsi C</label>
                        <input type="text" name="option_c" id="editC" required>
                    </div>

                    <div class="form-group">
                        <label>Opsi D</label>
                        <input type="text" name="option_d" id="editD" required>
                    </div>

                    <div class="form-group">
                        <label>Opsi E</label>
                        <input type="text" name="option_e" id="editE" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Kunci Jawaban</label>
                    <select name="correct_answer" id="editCorrect">
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                    </select>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn">Simpan Perubahan</button>
                    <button type="button" class="btn-delete" onclick="closeEditModal()">Batal</button>
                </div>

            </form>

        </div>
    </div>

@endsection


@section('scripts')
    <script>

        function openEditModal(question) {

            document.getElementById('editQuestion').value = question.question;
            document.getElementById('editA').value = question.option_a;
            document.getElementById('editB').value = question.option_b;
            document.getElementById('editC').value = question.option_c;
            document.getElementById('editD').value = question.option_d;
            document.getElementById('editE').value = question.option_e;

            const map = {
                0: 'A',
                1: 'B',
                2: 'C',
                3: 'D',
                4: 'E'
            };

            document.getElementById('editCorrect').value = map[question.answer];

            document.getElementById('editForm').action =
                '/guru/question/' + question.id;

            document.getElementById('editModal').style.display = 'flex';
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        @if(session('success'))
            document.addEventListener("DOMContentLoaded", function () {
                alert("{{ session('success') }}");
            });
        @endif

    </script>
@endsection