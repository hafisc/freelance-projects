<!-- Sidebar Wrapper -->
<div id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-slate-900 border-r border-slate-800/80 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col justify-between">
    <div>
        <!-- Logo / App Name -->
        <div class="h-16 flex items-center px-6 border-b border-slate-800/80 bg-slate-950/40">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                <img src="{{ asset('logo.png') }}" alt="TaskMate Logo" class="w-8 h-8 rounded-lg shadow-md shadow-blue-500/10 object-contain">
                <span class="text-xl font-bold text-white tracking-tight">Task<span class="text-blue-500">Mate</span></span>
            </a>
        </div>

        <!-- Navigation Links -->
        <nav class="p-4 space-y-1.5 flex-1">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/10' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-slate-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"></path>
                </svg>
                <span>Dashboard</span>
            </a>

            <!-- Daftar Tugas -->
            <a href="{{ route('tasks.index') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('tasks.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/10' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('tasks.*') ? 'text-white' : 'text-slate-400 group-hover:text-slate-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 002 2h2a2 2 0 002-2v-4zM9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                <span>Daftar Tugas</span>
            </a>

            <!-- Kalender -->
            <a href="{{ route('calendar.index') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('calendar.index') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/10' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('calendar.index') ? 'text-white' : 'text-slate-400 group-hover:text-slate-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span>Kalender</span>
            </a>

            <!-- Profil -->
            <a href="{{ route('profile.edit') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('profile.edit') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/10' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('profile.edit') ? 'text-white' : 'text-slate-400 group-hover:text-slate-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span>Profil</span>
            </a>
        </nav>
    </div>

    <!-- User Section / Logout -->
    <div class="p-4 border-t border-slate-800/80 bg-slate-950/20">


        <form method="POST" action="{{ route('logout') }}" id="sidebar-logout-form" class="hidden">
            @csrf
        </form>
        <a href="#" 
           onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();"
           class="flex items-center justify-center space-x-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-red-400 bg-red-950/30 border border-red-900/30 hover:bg-red-950/50 hover:text-red-300 hover:border-red-900/50 hover:scale-[1.02] active:scale-[0.98] transition-all duration-200 w-full cursor-pointer">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
            <span>Keluar</span>
        </a>
    </div>
</div>

<!-- Overlay for Mobile -->
<div id="sidebar-overlay" class="fixed inset-0 z-30 bg-slate-950/60 backdrop-blur-sm hidden lg:hidden" onclick="toggleSidebar()"></div>
