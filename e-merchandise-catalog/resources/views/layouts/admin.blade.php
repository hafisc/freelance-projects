<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CMB Admin')</title>
    
    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @yield('styles')
</head>
<body class="admin-body">
    <header class="main-header admin-header">
        <div class="container header-container">
            <a href="{{ route('admin.dashboard') }}" class="logo">
                <span class="logo-accent">CMB</span> Admin
            </a>
            <nav class="nav-links">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('admin.banners') }}" class="nav-link {{ request()->routeIs('admin.banners') ? 'active' : '' }}">Banner</a>
                <a href="{{ route('admin.products') }}" class="nav-link {{ request()->routeIs('admin.products') ? 'active' : '' }}">Produk</a>
                <a href="{{ route('admin.orders') }}" class="nav-link {{ request()->routeIs('admin.orders') ? 'active' : '' }}">Pesanan</a>
                <a href="{{ route('admin.vouchers') }}" class="nav-link {{ request()->routeIs('admin.vouchers') ? 'active' : '' }}">Voucher</a>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">User</a>
                @endif
                <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">Pengaturan</a>
                <a href="{{ route('home') }}" class="btn btn-outline btn-sm" target="_blank">Lihat Website</a>
                <form action="{{ route('logout') }}" method="POST" class="inline-form">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                </form>
            </nav>
        </div>
    </header>

    <main class="main-content">
        @if(session('success'))
            <div class="container">
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container">
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="main-footer">
        <div class="container">
            <p>&copy; 2024 Cresta Mandala Bhakti Merch. All rights reserved.</p>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>