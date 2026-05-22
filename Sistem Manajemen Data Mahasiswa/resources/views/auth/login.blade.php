<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Admin - Sistem Manajemen Data Mahasiswa</title>
    
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- CSS Kustom -->
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
</head>
<body class="login-body">

    <div class="login-card">
        <h1 class="login-title">Sistem Akademik</h1>
        <p class="login-subtitle">Silakan login menggunakan akun Admin</p>

        <!-- Menyisipkan Alert Sesi/Logout -->
        @include('components.alert')

        <!-- Form Login -->
        <form action="{{ route('login.process') }}" method="POST">
            @csrf

            <!-- Input Email -->
            <div class="mb-3">
                <label for="email" class="form-label font-weight-bold">Alamat Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Input Password -->
            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Tombol Submit -->
            <button type="submit" class="btn btn-navy w-100 py-2">
                Masuk ke Sistem
            </button>
        </form>
    </div>

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
