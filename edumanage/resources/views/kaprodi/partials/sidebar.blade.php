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

        <!-- Menu Kaprodi -->
        <li class="sidebar-item {{ $route == 'kaprodi.jadwal' ? 'active' : '' }}">
            <a href="{{ route('kaprodi.jadwal') }}" class="sidebar-link">
                <i class="fas fa-file-invoice"></i>
                Data Jadwal
            </a>
        </li>
        
        <li class="sidebar-item {{ $route == 'kaprodi.kegiatan' ? 'active' : '' }}">
            <a href="{{ route('kaprodi.kegiatan') }}" class="sidebar-link">
                <i class="fas fa-desktop"></i>
                Monitoring Kegiatan
            </a>
        </li>
    </ul>
    
    <div class="sidebar-footer">
        EduManage v1.0 &copy; 2026
    </div>
</div>
