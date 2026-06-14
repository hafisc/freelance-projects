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

        <!-- Menu Admin -->
        <li class="sidebar-item {{ str_starts_with($route, 'users.') ? 'active' : '' }}">
            <a href="{{ route('users.index') }}" class="sidebar-link">
                <i class="fas fa-users"></i>
                Data User
            </a>
        </li>

        <li class="sidebar-item {{ str_starts_with($route, 'mahasiswa.') ? 'active' : '' }}">
            <a href="{{ route('mahasiswa.index') }}" class="sidebar-link">
                <i class="fas fa-user-graduate"></i>
                Data Mahasiswa
            </a>
        </li>

        <li class="sidebar-item {{ str_starts_with($route, 'dosen.') && !str_contains($route, 'dosen.kegiatan') && !str_contains($route, 'dosen.jadwal') ? 'active' : '' }}">
            <a href="{{ route('dosen.index') }}" class="sidebar-link">
                <i class="fas fa-chalkboard-teacher"></i>
                Data Dosen
            </a>
        </li>

        <li class="sidebar-item {{ str_starts_with($route, 'mata-kuliah.') ? 'active' : '' }}">
            <a href="{{ route('mata-kuliah.index') }}" class="sidebar-link">
                <i class="fas fa-book"></i>
                Mata Kuliah
            </a>
        </li>

        <li class="sidebar-item {{ str_starts_with($route, 'kelas.') ? 'active' : '' }}">
            <a href="{{ route('kelas.index') }}" class="sidebar-link">
                <i class="fas fa-school"></i>
                Data Kelas
            </a>
        </li>

        <li class="sidebar-item {{ str_starts_with($route, 'jadwal-pembelajaran.') ? 'active' : '' }}">
            <a href="{{ route('jadwal-pembelajaran.index') }}" class="sidebar-link">
                <i class="fas fa-calendar-alt"></i>
                Jadwal Pembelajaran
            </a>
        </li>

        <li class="sidebar-item {{ str_starts_with($route, 'kegiatan-belajar.') ? 'active' : '' }}">
            <a href="{{ route('kegiatan-belajar.index') }}" class="sidebar-link">
                <i class="fas fa-tasks"></i>
                Kegiatan Belajar
            </a>
        </li>
    </ul>
    
    <div class="sidebar-footer">
        EduManage v1.0 &copy; 2026
    </div>
</div>
