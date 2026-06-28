<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SI-PBM Portal')</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 font-sans min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-[#1b3f75] text-white fixed top-0 bottom-0 left-0 flex flex-col justify-between shadow-xl z-20">
        <div>
            <!-- Brand -->
            <div class="p-6 flex items-center gap-3 border-b border-white/5 bg-black/10">
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-blue-500/10 text-blue-300 border border-blue-500/20 text-xl">
                    <i class="bi bi-clipboard2-check"></i>
                </span>
                <div>
                    <h1 class="font-bold tracking-tight text-white leading-none text-base"><span class="text-blue-300">SI-PBM</span> Portal</h1>
                    <span class="text-[10px] text-blue-200/60 font-semibold tracking-wider uppercase">Sistem Akademik</span>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="p-4 space-y-1.5 overflow-y-auto max-h-[calc(100vh-170px)]">
                @php
                    $role = session('role');
                    $rolePath = strtolower($role);
                    $routeActive = Route::currentRouteName();
                @endphp

                <!-- Dashboard Link -->
                <a href="{{ route($rolePath . '.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ $routeActive === $rolePath . '.dashboard' ? 'bg-[#274f85] text-white shadow-md' : 'text-blue-200 hover:bg-white/5 hover:text-white' }}">
                    <i class="bi bi-speedometer2 text-base"></i> Dashboard
                </a>

                <!-- Group 1: System Admin (Admin only) -->
                @if($role === 'Admin')
                    <div>
                        @php
                            $isAdminActive = str_contains($routeActive, 'users') || $routeActive === 'hak-akses.index';
                        @endphp
                        <button data-collapse-toggle="admin-menu" class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ $isAdminActive ? 'text-white' : 'text-blue-200 hover:bg-white/5 hover:text-white' }}">
                            <span class="flex items-center gap-3">
                                <i class="bi bi-shield-lock-fill text-base"></i> System Admin
                            </span>
                            <i class="bi bi-chevron-down dropdown-arrow text-xs transition-transform duration-200 {{ $isAdminActive ? 'rotate-180' : '' }}"></i>
                        </button>
                        <div id="admin-menu" class="{{ $isAdminActive ? '' : 'hidden' }} mt-1 pl-4 space-y-1 bg-black/10 rounded-xl py-1.5">
                            <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs font-medium transition-all duration-150 {{ str_contains($routeActive, 'users') ? 'bg-[#274f85] text-white' : 'text-blue-200/80 hover:text-white hover:bg-white/5' }}">
                                <i class="bi bi-people-fill text-sm"></i> Kelola User
                            </a>
                            <a href="{{ route('hak-akses.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs font-medium transition-all duration-150 {{ $routeActive === 'hak-akses.index' ? 'bg-[#274f85] text-white' : 'text-blue-200/80 hover:text-white hover:bg-white/5' }}">
                                <i class="bi bi-key-fill text-sm"></i> Tabel Hak Akses
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Group 2: Akademik Master (Admin & Operator) -->
                @if($role === 'Admin' || $role === 'Operator')
                    <div>
                        @php
                            $isAcademicActive = str_contains($routeActive, 'mahasiswa') || str_contains($routeActive, 'dosen') || str_contains($routeActive, 'matakuliah') || str_contains($routeActive, 'krs') || str_contains($routeActive, 'kelas');
                        @endphp
                        <button data-collapse-toggle="academic-menu" class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ $isAcademicActive ? 'text-white' : 'text-blue-200 hover:bg-white/5 hover:text-white' }}">
                            <span class="flex items-center gap-3">
                                <i class="bi bi-mortarboard-fill text-base"></i> Akademik Master
                            </span>
                            <i class="bi bi-chevron-down dropdown-arrow text-xs transition-transform duration-200 {{ $isAcademicActive ? 'rotate-180' : '' }}"></i>
                        </button>
                        <div id="academic-menu" class="{{ $isAcademicActive ? '' : 'hidden' }} mt-1 pl-4 space-y-1 bg-black/10 rounded-xl py-1.5">
                            <a href="{{ route('data-mahasiswa') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs font-medium transition-all duration-150 {{ $routeActive === 'data-mahasiswa' || str_contains($routeActive, 'mahasiswa') ? 'bg-[#274f85] text-white' : 'text-blue-200/80 hover:text-white hover:bg-white/5' }}">
                                <i class="bi bi-people text-sm"></i> Data Mahasiswa
                            </a>
                            <a href="{{ route('dosen.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs font-medium transition-all duration-150 {{ str_contains($routeActive, 'dosen') ? 'bg-[#274f85] text-white' : 'text-blue-200/80 hover:text-white hover:bg-white/5' }}">
                                <i class="bi bi-person-badge-fill text-sm"></i> Data Dosen
                            </a>
                            <a href="{{ route('matakuliah.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs font-medium transition-all duration-150 {{ str_contains($routeActive, 'matakuliah') ? 'bg-[#274f85] text-white' : 'text-blue-200/80 hover:text-white hover:bg-white/5' }}">
                                <i class="bi bi-book-half text-sm"></i> Mata Kuliah
                            </a>
                            <a href="{{ route('krs.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs font-medium transition-all duration-150 {{ str_contains($routeActive, 'krs') ? 'bg-[#274f85] text-white' : 'text-blue-200/80 hover:text-white hover:bg-white/5' }}">
                                <i class="bi bi-file-earmark-text-fill text-sm"></i> Data KRS
                            </a>
                            <a href="{{ route('kelas.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs font-medium transition-all duration-150 {{ str_contains($routeActive, 'kelas') ? 'bg-[#274f85] text-white' : 'text-blue-200/80 hover:text-white hover:bg-white/5' }}">
                                <i class="bi bi-door-open-fill text-sm"></i> Data Kelas
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Group 3: Kegiatan Belajar (All Roles) -->
                <div>
                    @php
                        $isLearningActive = str_contains($routeActive, 'jadwal') || str_contains($routeActive, 'kegiatan') || str_contains($routeActive, 'absensi');
                    @endphp
                    <button data-collapse-toggle="learning-menu" class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ $isLearningActive ? 'text-white' : 'text-blue-200 hover:bg-white/5 hover:text-white' }}">
                        <span class="flex items-center gap-3">
                            <i class="bi bi-calendar-event-fill text-base"></i> Kegiatan Belajar
                        </span>
                        <i class="bi bi-chevron-down dropdown-arrow text-xs transition-transform duration-200 {{ $isLearningActive ? 'rotate-180' : '' }}"></i>
                    </button>
                    <div id="learning-menu" class="{{ $isLearningActive ? '' : 'hidden' }} mt-1 pl-4 space-y-1 bg-black/10 rounded-xl py-1.5">
                        <a href="{{ route('jadwal.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs font-medium transition-all duration-150 {{ str_contains($routeActive, 'jadwal') ? 'bg-[#274f85] text-white' : 'text-blue-200/80 hover:text-white hover:bg-white/5' }}">
                            <i class="bi bi-clock-fill text-sm"></i> Jadwal Belajar
                        </a>
                        <a href="{{ route('kegiatan.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs font-medium transition-all duration-150 {{ str_contains($routeActive, 'kegiatan') ? 'bg-[#274f85] text-white' : 'text-blue-200/80 hover:text-white hover:bg-white/5' }}">
                            <i class="bi bi-list-task text-sm"></i> Kegiatan PBM
                        </a>
                        <a href="{{ route('absensi.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs font-medium transition-all duration-150 {{ str_contains($routeActive, 'absensi') ? 'bg-[#274f85] text-white' : 'text-blue-200/80 hover:text-white hover:bg-white/5' }}">
                            <i class="bi bi-clipboard2-check-fill text-sm"></i> Absensi Kelas
                        </a>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Sidebar Profile & Logout Footer -->
        <div class="p-4 bg-black/15 border-t border-white/5">
            <div class="flex items-center justify-between gap-3">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-10 h-10 rounded-xl bg-[#274f85] text-white border border-white/10 flex items-center justify-center font-bold text-sm shrink-0">
                        {{ strtoupper(substr(session('nama', 'U'), 0, 1)) }}
                    </div>
                    <div class="min-w-0 leading-tight">
                        <h4 class="font-bold text-sm text-white truncate" title="{{ session('nama') }}">{{ session('nama') }}</h4>
                        <span class="text-[10px] text-blue-200 font-semibold uppercase tracking-wider">{{ session('role') }}</span>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="m-0 shrink-0">
                    @csrf
                    <button type="submit" class="w-8 h-8 rounded-lg bg-red-500/10 hover:bg-red-500/20 text-red-400 hover:text-red-300 flex items-center justify-center transition-all duration-150" title="Keluar" onclick="return confirm('Apakah Anda yakin ingin keluar?')">
                        <i class="bi bi-box-arrow-right text-base"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Panel -->
    <div class="flex-1 ml-64 min-h-screen flex flex-col">
        <!-- Topbar -->
        <header class="bg-white border-b border-slate-200 sticky top-0 z-10 px-8 py-4 flex items-center justify-between">
            <div>
                <h2 class="font-extrabold text-slate-800 text-lg leading-tight">@yield('page_title', 'Dashboard')</h2>
                <p class="text-xs text-slate-400 mt-0.5">Portal Informasi & Kegiatan Belajar Mengajar</p>
            </div>
        </header>

        <!-- Main Wrapper -->
        <main class="flex-1 p-8">
            <!-- Flash Message Alerts -->
            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-start gap-3 shadow-sm">
                    <i class="bi bi-check-circle-fill text-emerald-500 text-lg mt-0.5 shrink-0"></i>
                    <div class="flex-1">
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm flex items-start gap-3 shadow-sm">
                    <i class="bi bi-exclamation-triangle-fill text-red-500 text-lg mt-0.5 shrink-0"></i>
                    <div class="flex-1">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <!-- Content Area -->
            @yield('content')
        </main>
    </div>

    <!-- Toggle Dropdown Scripts -->
    <script>
        document.querySelectorAll('[data-collapse-toggle]').forEach(button => {
            button.addEventListener('click', () => {
                const targetId = button.getAttribute('data-collapse-toggle');
                const target = document.getElementById(targetId);
                if (target) {
                    target.classList.toggle('hidden');
                    const arrow = button.querySelector('.dropdown-arrow');
                    if (arrow) {
                        arrow.classList.toggle('rotate-180');
                    }
                }
            });
        });
    </script>
</body>
</html>
