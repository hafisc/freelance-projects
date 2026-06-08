@extends('layouts.guru')

@section('title', 'Data Siswa')

@section('guru-content')

    {{-- CONTENT --}}
    <main class="guru-content">

        <h1>Data Siswa</h1>

        <button class="btn-add" onclick="openAddModal()">
            + Tambah Siswa
        </button>

        <div class="table-wrapper">
            <table id="tabelSiswa" class="display">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIS </th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Kelas</th>
                        <th>Tahun</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($siswa as $i => $s)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $s->username }}</td>
                            <td>{{ $s->name }}</td>
                            <td>{{ $s->email }}</td>
                            <td>{{ $s->kelas }}</td>
                            <td>{{ $s->tahun }}</td>
                            <td>
                                <button class="btn" onclick='openEditModal(@json($s))'>
                                    Edit
                                </button>

                                <button class="btn-delete" onclick="confirmDelete({{ $s->id }}, '{{ $s->name }}')">
                                    Hapus
                                </button>

                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
            <div id="addModal" class="modal-overlay" style="display:none;">
                <div class="modal">

                    <h3>Tambah Siswa</h3>

                    <form method="POST" action="/guru-siswa/store" autocomplete="off">
                        @csrf

                        <input type="text" name="name" placeholder="Nama siswa" required>
                        <input type="text" name="username" placeholder="NIS" required inputmode="numeric" pattern="[0-9]+"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"> <input type="email" name="email"
                            placeholder="Email" required>
                        <input type="text" name="kelas" placeholder="Kelas" required>
                        <input type="text" name="tahun" placeholder="Tahun Ajaran" required>
                        <div class="password-wrapper">
                            <input type="password" name="password" id="passwordInput" placeholder="Password" required
                                autocomplete="new-password">

                            <span onclick="togglePassword()" class="eye-btn">👁️</span>
                        </div>

                        <br><br>
                        <button class="btn-add" type="submit">Simpan</button>
                        <button class="btn-delete" type="button" onclick="closeAddModal()">Batal</button>
                    </form>

                </div>
            </div>
            <div id="editModal" class="modal-overlay" style="display:none;">
                <div class="modal">

                    <h3>Edit Siswa</h3>

                    <form method="POST" id="editForm">
                        @csrf
                        @method('PUT')

                        <input type="text" id="editUsername" readonly>
                        <input type="text" name="name" id="editName" required>
                        <input type="email" name="email" id="editEmail" required>

                        <input type="text" name="kelas" id="editKelas" placeholder="Kelas" required>
                        <input type="text" name="tahun" id="editTahun" placeholder="Tahun Ajaran" required>

                        <div class="password-wrapper">
                            <input type="password" name="password" id="editPassword"
                                placeholder="Password baru (kosongkan jika tidak diganti)">
                            <span onclick="toggleEditPassword()" class="eye-btn">👁️</span>
                        </div>

                        <br><br>
                        <button type="button" class="btn" onclick="confirmUpdate()">Update</button>
                        <button type="button" class="btn-delete" onclick="closeEditModal()">Batal</button>
                    </form>

                </div>
            </div>

        </div>
        <div id="alertModal" class="modal-overlay" style="display:none;">
            <div class="modal alert-box">

                <div id="alertIcon" class="alert-icon">✔</div>

                <h3 id="alertTitle">Berhasil</h3>
                <p id="alertMessage"></p>

                <button class="btn-ok" onclick="closeAlert()">OK</button>
            </div>
        </div>

        <div id="deleteModal" class="modal-overlay" style="display:none;">
            <div class="modal alert-box warning-box">

                <div class="warning-icon">⚠️</div>

                <h3>Konfirmasi Hapus</h3>

                <p id="deleteText"></p>

                <form method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn-delete">Ya, Hapus</button>
                    <button type="button" class="btn" onclick="closeDeleteModal()">Batal</button>
                </form>

            </div>
        </div>

        <div id="updateConfirmModal" class="modal-overlay" style="display:none;">
            <div class="modal alert-box warning-box">

                <div class="warning-icon">⚠️</div>

                <h3>Konfirmasi Update</h3>

                <p>Apakah yakin ingin memperbarui data siswa ini?</p>

                <button class="btn" onclick="submitUpdate()">Ya, Update</button>
                <button class="btn-delete" onclick="closeUpdateConfirm()">Batal</button>

            </div>
        </div>



    </main>

@endsection
@section('scripts')
    <script>

        function openAddModal() {
            document.getElementById('addModal').style.display = 'flex';
        }

        function closeAddModal() {
            document.getElementById('addModal').style.display = 'none';
        }

        function togglePassword() {
            const input = document.getElementById('passwordInput');
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        function openEditModal(user) {
            document.getElementById('editUsername').value = user.username;
            document.getElementById('editName').value = user.name;
            document.getElementById('editEmail').value = user.email;
            document.getElementById('editKelas').value = user.kelas ?? '';
            document.getElementById('editTahun').value = user.tahun ?? '';

            document.getElementById('editForm').action =
                '/guru-siswa/update/' + user.id;

            document.getElementById('editModal').style.display = 'flex';
        }

        function toggleEditPassword() {
            const input = document.getElementById('editPassword');
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        function confirmDelete(id, name) {
            document.getElementById('deleteText').innerHTML =
                `Apakah yakin ingin menghapus siswa <b>${name}</b>?`;

            document.getElementById('deleteForm').action =
                '/guru-siswa/delete/' + id;

            document.getElementById('deleteModal').style.display = 'flex';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        function closeAlert() {
            document.getElementById('alertModal').style.display = 'none';
        }


        @if(session('success'))
            document.addEventListener("DOMContentLoaded", function () {

                document.getElementById('alertIcon').innerHTML = "✔";
                document.getElementById('alertTitle').innerHTML = "Berhasil";
                document.getElementById('alertMessage').innerHTML =
                    @json(session('success'));

                document.getElementById('alertModal').style.display = 'flex';
            });
        @endif


            function confirmUpdate() {
                document.getElementById('updateConfirmModal').style.display = 'flex';
            }

        function closeUpdateConfirm() {
            document.getElementById('updateConfirmModal').style.display = 'none';
        }

        function submitUpdate() {
            document.getElementById('editForm').submit();
        }

        $(document).ready(function () {

            $('#tabelSiswa').DataTable({
                pageLength: 10,
                lengthMenu: [10, 25, 50],
                ordering: true,
                autoWidth: false,

                language: {
                    search: "Cari siswa:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ siswa",
                    paginate: {
                        next: "Next",
                        previous: "Prev"
                    }
                }

            });

        });
    </script>
@endsection