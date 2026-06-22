@extends('layouts.app')

@section('title', 'Lengkapi Profil')

@section('content')
<div class="container" style="max-width: 600px;">
    <div class="card">
        <div class="card-body">
            <h1 style="margin-bottom: 2rem; color: var(--primary); text-align: center;">Lengkapi Profil</h1>
            
            <form action="{{ route('profile.complete.store') }}" method="POST">
                @csrf
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">Email</label>
                    <input type="email" name="email" class="form-control" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">Nomor HP</label>
                    <input type="text" name="phone" class="form-control" required value="{{ auth()->user()->phone }}" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">Tipe Pembeli</label>
                    <div style="display: flex; gap: 1rem;">
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                            <input type="radio" name="type" value="internal" onchange="toggleFields()"> Internal (Siswa/Guru)
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                            <input type="radio" name="type" value="external" onchange="toggleFields()"> Eksternal
                        </label>
                    </div>
                </div>

                <div id="classField" style="margin-bottom: 1rem; display: none;">
                    <label style="display: block; margin-bottom: 0.5rem;">Kelas</label>
                    <input type="text" name="class" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                </div>

                <div id="addressField" style="margin-bottom: 1rem; display: none;">
                    <label style="display: block; margin-bottom: 0.5rem;">Alamat</label>
                    <textarea name="address" class="form-control" rows="3" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;"></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Simpan Profil</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleFields() {
        const type = document.querySelector('input[name="type"]:checked').value;
        document.getElementById('classField').style.display = type === 'internal' ? 'block' : 'none';
        document.getElementById('addressField').style.display = type === 'external' ? 'block' : 'none';
    }
</script>
@endsection
