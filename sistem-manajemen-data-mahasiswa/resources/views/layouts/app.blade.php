<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistem Manajemen Data Mahasiswa</title>
    
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- CSS Kustom -->
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    
    @yield('styles')
</head>
<body>

    <div class="app-wrapper">
        <!-- Menyisipkan Sidebar -->
        @include('layouts.sidebar')

        <!-- Area Konten Utama -->
        <div class="app-content">
            <!-- Menyisipkan Navbar -->
            @include('layouts.navbar')

            <!-- Kontainer Halaman -->
            <main class="page-container">
                <!-- Menyisipkan Alert Flash Message -->
                @include('components.alert')

                <!-- Konten Dinamis Halaman -->
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    @yield('scripts')
</body>
</html>
