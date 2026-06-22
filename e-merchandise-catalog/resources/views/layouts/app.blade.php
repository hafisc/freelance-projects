<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CMB Merch')</title>
    
    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @yield('styles')
</head>
<body>
    @if(!request()->is('admin*'))
    <header class="main-header">
        <div class="container header-container">
            <a href="{{ route('home') }}" class="logo">
                <span class="logo-accent">CMB</span> Merch
            </a>
            <nav class="nav-links">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                @auth
                    <a href="{{ route('customer.orders') }}" class="nav-link {{ request()->routeIs('customer.orders') ? 'active' : '' }}">Pesanan</a>
                    <a href="{{ route('cart.index') }}" class="nav-link cart-link {{ request()->routeIs('cart.index') ? 'active' : '' }}">
                        Keranjang
                        @php 
                            $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count(); 
                        @endphp 
                        @if($cartCount > 0) 
                            <span class="cart-badge">{{ $cartCount }}</span> 
                        @endif
                    </a>
                    <a href="{{ route('customer.profile') }}" class="nav-link {{ request()->routeIs('customer.profile') ? 'active' : '' }}">Profil</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline-form">
                        @csrf
                        <button type="submit" class="btn btn-outline btn-sm">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-secondary btn-sm">Login</a>
                @endauth
            </nav>
        </div>
    </header>
    @endif

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