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

        <!-- Menu Mahasiswa -->
        <li class="sidebar-item {{ $route == 'mahasiswa.jadwal' ? 'active' : '' }}">
            <a href="{{ route('mahasiswa.jadwal') }}" class="sidebar-link">
                <i class="fas fa-calendar-week"></i>
                Jadwal Kuliah
            </a>
        </li>
        
        <li class="sidebar-item {{ $route == 'mahasiswa.kegiatan' ? 'active' : '' }}">
            <a href="{{ route('mahasiswa.kegiatan') }}" class="sidebar-link">
                <i class="fas fa-graduation-cap"></i>
                Kegiatan Belajar
            </a>
        </li>
    </ul>
    
    <div class="sidebar-footer">
        EduManage v1.0 &copy; 2026
    </div>
</div>
