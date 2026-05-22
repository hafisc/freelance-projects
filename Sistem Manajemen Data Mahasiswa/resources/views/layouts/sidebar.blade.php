<!-- Sidebar Kiri -->
<aside class="app-sidebar">
    <div class="sidebar-header">
        Sistem Akademik
    </div>
    
    <ul class="sidebar-menu">
        <li class="{{ request()->routeIs('dashboard.*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.index') }}">
                Dashboard
            </a>
        </li>
        <li class="{{ request()->routeIs('mahasiswa.*') ? 'active' : '' }}">
            <a href="{{ route('mahasiswa.index') }}">
                Data Mahasiswa
            </a>
        </li>
        <li class="{{ request()->routeIs('jurusan.*') ? 'active' : '' }}">
            <a href="{{ route('jurusan.index') }}">
                Data Jurusan
            </a>
        </li>
    </ul>

    <div class="sidebar-footer">
        <!-- Form Logout Admin -->
        <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin keluar dari sistem?')">
            @csrf
            <button type="submit" class="btn btn-danger w-100 py-2">
                Keluar
            </button>
        </form>
    </div>
</aside>
