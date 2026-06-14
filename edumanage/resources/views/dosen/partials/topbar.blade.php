<nav class="navbar">
    <div class="navbar-title">
        @yield('title', 'Dosen Dashboard')
    </div>
    
    <div class="user-profile">
        <div class="user-info">
            <div class="user-name">{{ auth()->user()->name }}</div>
            <div class="user-role">{{ auth()->user()->role->name }}</div>
        </div>
        
        <div class="user-avatar" style="overflow: hidden; padding: 0;">
            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ urlencode(auth()->user()->name) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
        </div>

        <form action="{{ route('logout') }}" method="POST" style="margin-left: 10px;">
            @csrf
            <button type="submit" class="btn btn-secondary btn-sm" title="Keluar Sistem">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </button>
        </form>
    </div>
</nav>
