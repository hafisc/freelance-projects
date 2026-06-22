@extends('layouts.admin')

@section('title', 'Pengaturan')

@section('content')
<div class="header">
    <h1>Pengaturan Akun</h1>
</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}" required>
        </div>

        <div class="form-group">
            <label>Password Baru (kosongkan jika tidak ingin diubah)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <button type="submit" class="btn btn-secondary">Simpan Perubahan</button>
    </form>
</div>
@endsection
