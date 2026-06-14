<div class="sidebar">
    <div class="sidebar-brand">
        Edu<span>Manage</span>
    </div>
    
    <ul class="sidebar-menu">
        @php
            $route = Request::route()->getName();
        @endphp

        <!-- Dashboard Link -->
        <li class="sidebar-item {{ $route == 'dashboard' ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="sidebar-link">
                <i class="fas fa-tachometer-alt"></i>
                Dashboard
            </a>
        </li>

        <!-- Menu Dosen -->
        <li class="sidebar-item {{ $route == 'dosen.jadwal' ? 'active' : '' }}">
            <a href="{{ route('dosen.jadwal') }}" class="sidebar-link">
                <i class="fas fa-calendar-day"></i>
                Jadwal Mengajar
            </a>
        </li>
        
        <li class="sidebar-item {{ str_starts_with($route, 'dosen.kegiatan') ? 'active' : '' }}">
            <a href="{{ route('dosen.kegiatan') }}" class="sidebar-link">
                <i class="fas fa-clipboard-list"></i>
                Kegiatan Belajar
            </a>
        </li>
    </ul>
    
    <div class="sidebar-footer">
        EduManage v1.0 &copy; 2026
    </div>
</div>
