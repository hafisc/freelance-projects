@extends('layouts.app')

@section('title', 'Login Admin/Panitia')

@section('content')
<div class="container" style="max-width: 500px;">
    <div class="card">
        <div class="card-body" style="text-align: center;">
            <h1 style="margin-bottom: 2rem; color: var(--primary);">Login Admin/Panitia</h1>
            
            <form action="{{ route('admin.login.post') }}" method="POST">
                @csrf
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; text-align: left;">Email</label>
                    <input type="email" name="email" class="form-control" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; text-align: left;">Password</label>
                    <input type="password" name="password" class="form-control" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;">
                </div>

                @if($errors->any())
                    <div class="alert alert-error">{{ $errors->first() }}</div>
                @endif
                
                <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
            </form>

            <p style="margin-top: 2rem; color: #666;">
                <a href="{{ route('home') }}" style="color: var(--primary);">← Kembali ke Beranda</a>
            </p>
        </div>
    </div>
</div>
@endsection
