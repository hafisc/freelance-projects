@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container" style="max-width: 600px;">
    <h1 style="margin-bottom: 2rem; color: var(--primary);">Profil Saya</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('customer.profile.update') }}" method="POST">
                @csrf
                
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                </div>

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                </div>

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Nomor HP</label>
                    <input type="text" name="phone" class="form-control" value="{{ auth()->user()->phone }}" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                </div>

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Tipe Pembeli</label>
                    <div style="display: flex; gap: 1rem;">
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                            <input type="radio" name="type" value="internal" {{ auth()->user()->type === 'internal' ? 'checked' : '' }}> Internal (Siswa/Guru)
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                            <input type="radio" name="type" value="external" {{ auth()->user()->type === 'external' ? 'checked' : '' }}> Eksternal
                        </label>
                    </div>
                </div>

                <div class="form-group" id="classField" style="margin-bottom: 1rem; display: {{ auth()->user()->type === 'internal' ? 'block' : 'none' }};">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Kelas</label>
                    <input type="text" name="class" class="form-control" value="{{ auth()->user()->class }}" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                </div>

                <div class="form-group" id="addressField" style="margin-bottom: 1rem; display: {{ auth()->user()->type === 'external' ? 'block' : 'none' }};">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Alamat</label>
                    <textarea name="address" class="form-control" rows="3" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">{{ auth()->user()->address }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('input[name="type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.getElementById('classField').style.display = this.value === 'internal' ? 'block' : 'none';
            document.getElementById('addressField').style.display = this.value === 'external' ? 'block' : 'none';
        });
    });
</script>
@endsection
