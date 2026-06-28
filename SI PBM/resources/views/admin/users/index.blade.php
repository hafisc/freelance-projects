@extends('layouts.app')

@section('title', 'Kelola User | SI-PBM')
@section('page_title', 'Kelola Pengguna')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <h3 class="text-xl font-extrabold text-[#1b3f75]">Daftar Pengguna</h3>
        <p class="text-slate-400 text-xs mt-1">Kelola kredensial login dan tingkatan peran akun pengguna.</p>
    </div>
    <button onclick="openModal('addUserModal')" 
        class="inline-flex items-center gap-2 bg-[#204a82] hover:bg-[#193f72] text-white font-semibold py-2.5 px-5 rounded-xl shadow-md transition-all duration-200 text-sm">
        <i class="bi bi-person-plus-fill"></i> Tambah Pengguna
    </button>
</div>

<!-- Table Card -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400 text-[11px] uppercase tracking-wider font-semibold">
                    <th class="py-4 px-6">Nama</th>
                    <th class="py-4 px-6">Email</th>
                    <th class="py-4 px-6">Hak Akses</th>
                    <th class="py-4 px-6">Detail Link</th>
                    <th class="py-4 px-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($users as $user)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-4 px-6 font-bold text-slate-700">
                            {{ $user->name }}
                            @if(auth()->check() && auth()->id() === $user->id)
                                <span class="ml-1.5 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-500">Saya</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-slate-500">{{ $user->email }}</td>
                        <td class="py-4 px-6">
                            @if($user->role === 'Admin')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-100">Admin</span>
                            @elseif($user->role === 'Operator')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-100">Operator</span>
                            @elseif($user->role === 'Dosen')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">Dosen</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">Mahasiswa</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-slate-500">
                            @if($user->role === 'Mahasiswa')
                                <span class="inline-flex items-center gap-1.5 text-xs text-slate-500"><i class="bi bi-mortarboard"></i> NIM: {{ $user->nim }}</span>
                            @elseif($user->role === 'Dosen')
                                <span class="inline-flex items-center gap-1.5 text-xs text-slate-500"><i class="bi bi-person-workspace"></i> NIDN: {{ $user->dosen->nidn ?? 'N/A' }}</span>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="inline-flex items-center gap-2">
                                <button onclick="openModal('editUserModal{{ $user->id }}')" 
                                    class="w-8 h-8 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 flex items-center justify-center transition-all duration-150" 
                                    title="Edit User">
                                    <i class="bi bi-pencil-square text-sm"></i>
                                </button>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="m-0 inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                        class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 flex items-center justify-center transition-all duration-150" 
                                        title="Hapus User">
                                        <i class="bi bi-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-slate-400">
                            <i class="bi bi-people text-3xl d-block mb-3 text-slate-300"></i>
                            Data pengguna tidak ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Add User Modal -->
<div id="addUserModal" class="fixed inset-0 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm z-50 hidden transition-all duration-300">
    <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl relative border border-slate-100 mx-4">
        <!-- Close Button -->
        <button onclick="closeModal('addUserModal')" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 transition-colors">
            <i class="bi bi-x-lg text-lg"></i>
        </button>

        <h3 class="text-lg font-extrabold text-[#1b3f75] flex items-center gap-2 mb-6">
            <i class="bi bi-person-plus-fill text-blue-500"></i> Tambah User Baru
        </h3>

        <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap</label>
                <input type="text" name="name" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" placeholder="Nama lengkap pengguna" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Email</label>
                <input type="email" name="email" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" placeholder="nama@sipbm.ac.id" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Password</label>
                <input type="password" name="password" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" placeholder="Min. 6 karakter" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Hak Akses Role</label>
                <select name="role" id="add_role_select" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required onchange="toggleAddLinks()">
                    <option value="Admin">Admin</option>
                    <option value="Operator">Operator</option>
                    <option value="Dosen">Dosen</option>
                    <option value="Mahasiswa">Mahasiswa</option>
                </select>
            </div>
            
            <!-- Link ke Dosen -->
            <div class="hidden" id="add_dosen_div">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pilih Dosen Pengampu</label>
                <select name="dosen_id" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200">
                    <option value="">-- Pilih Dosen --</option>
                    @foreach($dosens as $dsn)
                        <option value="{{ $dsn->id }}">{{ $dsn->nama_dosen }} (NIDN: {{ $dsn->nidn }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Link ke Mahasiswa -->
            <div class="hidden" id="add_mahasiswa_div">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pilih Mahasiswa</label>
                <select name="nim" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200">
                    <option value="">-- Pilih Mahasiswa --</option>
                    @foreach($mahasiswas as $mhs)
                        <option value="{{ $mhs->nim }}">{{ $mhs->nama }} (NIM: {{ $mhs->nim }})</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" 
                class="w-full flex items-center justify-center gap-2 bg-[#204a82] hover:bg-[#193f72] text-white font-semibold py-2.5 px-6 rounded-xl shadow-lg transition-all duration-200 mt-6">
                Simpan User
            </button>
        </form>
    </div>
</div>

<!-- Edit User Modals -->
@foreach($users as $user)
<div id="editUserModal{{ $user->id }}" class="fixed inset-0 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm z-50 hidden transition-all duration-300">
    <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl relative border border-slate-100 mx-4">
        <!-- Close Button -->
        <button onclick="closeModal('editUserModal{{ $user->id }}')" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 transition-colors">
            <i class="bi bi-x-lg text-lg"></i>
        </button>

        <h3 class="text-lg font-extrabold text-[#1b3f75] flex items-center gap-2 mb-6">
            <i class="bi bi-pencil-square text-blue-500"></i> Edit Data User
        </h3>

        <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ $user->name }}" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Email</label>
                <input type="email" name="email" value="{{ $user->email }}" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Password <small class="text-slate-400 font-normal">(Kosongkan jika tidak diubah)</small></label>
                <input type="password" name="password" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" placeholder="Password baru">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Hak Akses Role</label>
                <select name="role" id="edit_role_select_{{ $user->id }}" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200" required onchange="toggleEditLinks({{ $user->id }})">
                    <option value="Admin" {{ $user->role === 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option value="Operator" {{ $user->role === 'Operator' ? 'selected' : '' }}>Operator</option>
                    <option value="Dosen" {{ $user->role === 'Dosen' ? 'selected' : '' }}>Dosen</option>
                    <option value="Mahasiswa" {{ $user->role === 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                </select>
            </div>
            
            <!-- Link ke Dosen -->
            <div class="{{ $user->role === 'Dosen' ? '' : 'hidden' }}" id="edit_dosen_div_{{ $user->id }}">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Dosen Pengampu</label>
                <select name="dosen_id" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200">
                    <option value="">-- Pilih Dosen --</option>
                    @foreach($dosens as $dsn)
                        <option value="{{ $dsn->id }}" {{ $user->dosen_id == $dsn->id ? 'selected' : '' }}>{{ $dsn->nama_dosen }} (NIDN: {{ $dsn->nidn }})</option>
                    @endforeach
                    @if($user->dosen)
                        <option value="{{ $user->dosen_id }}" selected>{{ $user->dosen->nama_dosen }} (NIDN: {{ $user->dosen->nidn }})</option>
                    @endif
                </select>
            </div>

            <!-- Link ke Mahasiswa -->
            <div class="{{ $user->role === 'Mahasiswa' ? '' : 'hidden' }}" id="edit_mahasiswa_div_{{ $user->id }}">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Mahasiswa</label>
                <select name="nim" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 text-sm focus:outline-none focus:border-[#204a82] focus:ring-4 focus:ring-blue-100 transition-all duration-200">
                    <option value="">-- Pilih Mahasiswa --</option>
                    @foreach($mahasiswas as $mhs)
                        <option value="{{ $mhs->nim }}" {{ $user->nim == $mhs->nim ? 'selected' : '' }}>{{ $mhs->nama }} (NIM: {{ $mhs->nim }})</option>
                    @endforeach
                    @if($user->mahasiswa)
                        <option value="{{ $user->nim }}" selected>{{ $user->mahasiswa->nama }} (NIM: {{ $user->nim }})</option>
                    @endif
                </select>
            </div>

            <button type="submit" 
                class="w-full flex items-center justify-center gap-2 bg-[#204a82] hover:bg-[#193f72] text-white font-semibold py-2.5 px-6 rounded-xl shadow-lg transition-all duration-200 mt-6">
                Update User
            </button>
        </form>
    </div>
</div>
@endforeach

<script>
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
        }
    }

    function toggleAddLinks() {
        const role = document.getElementById('add_role_select').value;
        const dosenDiv = document.getElementById('add_dosen_div');
        const mhsDiv = document.getElementById('add_mahasiswa_div');
        
        dosenDiv.classList.add('hidden');
        mhsDiv.classList.add('hidden');
        
        if (role === 'Dosen') {
            dosenDiv.classList.remove('hidden');
        } else if (role === 'Mahasiswa') {
            mhsDiv.classList.remove('hidden');
        }
    }

    function toggleEditLinks(id) {
        const role = document.getElementById('edit_role_select_' + id).value;
        const dosenDiv = document.getElementById('edit_dosen_div_' + id);
        const mhsDiv = document.getElementById('edit_mahasiswa_div_' + id);
        
        dosenDiv.classList.add('hidden');
        mhsDiv.classList.add('hidden');
        
        if (role === 'Dosen') {
            dosenDiv.classList.remove('hidden');
        } else if (role === 'Mahasiswa') {
            mhsDiv.classList.remove('hidden');
        }
    }
</script>
@endsection
