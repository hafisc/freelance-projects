<!-- Navbar Atas -->
<nav class="app-navbar">
    <div class="navbar-brand-title">
        @yield('title', 'Sistem Manajemen Data Mahasiswa')
    </div>
    
    <div class="navbar-user-info">
        @auth
            <!-- Menampilkan nama admin yang sedang aktif login -->
            Masuk sebagai: <strong>{{ Auth::user()->name }}</strong>
        @endauth
    </div>
</nav>
