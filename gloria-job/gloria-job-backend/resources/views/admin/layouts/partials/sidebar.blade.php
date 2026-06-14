<!-- Overlay untuk Mobile -->
<div class="fixed inset-0 bg-slate-900/40 z-40 md:hidden" 
     x-show="sidebarOpen" 
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @click="sidebarOpen = false"
     x-cloak></div>

<!-- Sidebar Panel -->
<aside class="fixed inset-y-0 left-0 w-64 bg-primaryDark text-white z-50 transform md:translate-x-0 flex flex-col transition-transform duration-300 ease-in-out"
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">
    
    <!-- Sidebar Header / Brand -->
    <div class="h-16 flex items-center justify-between px-6 border-b border-white/10">
        <span class="font-extrabold text-lg tracking-wider flex items-center gap-3">
            <img src="{{ asset('assets/images/logo.jpg') }}" alt="Gloria Job Logo" class="h-7 w-7 object-contain rounded-md shadow-sm">
            GLORIA JOB
        </span>
        <button class="md:hidden text-white/80 hover:text-white" @click="sidebarOpen = false">
            <i class="fa-solid fa-xmark fa-lg"></i>
        </button>
    </div>
    
    <!-- Navigation Links -->
    <nav class="flex-grow py-6 px-4 space-y-1">
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-200 {{ Route::is('admin.dashboard') ? 'bg-primaryBlue text-white shadow-lg shadow-primaryBlue/20' : 'text-white/75 hover:bg-white/5 hover:text-white' }}">
            <i class="fa-solid fa-chart-line w-5 text-center text-lg"></i> Dashboard
        </a>
        <a href="{{ route('admin.jobs.index') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-200 {{ Route::is('admin.jobs.*') ? 'bg-primaryBlue text-white shadow-lg shadow-primaryBlue/20' : 'text-white/75 hover:bg-white/5 hover:text-white' }}">
            <i class="fa-solid fa-file-contract w-5 text-center text-lg"></i> Lowongan Kerja
        </a>
        <a href="{{ route('admin.applications.index') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-200 {{ Route::is('admin.applications.*') ? 'bg-primaryBlue text-white shadow-lg shadow-primaryBlue/20' : 'text-white/75 hover:bg-white/5 hover:text-white' }}">
            <i class="fa-solid fa-envelope-open-text w-5 text-center text-lg"></i> Lamaran Masuk
        </a>
    </nav>
    
    <!-- Sidebar Footer / Logout -->
    <div class="p-4 border-t border-white/10">
        <form action="{{ route('admin.logout') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin keluar?');">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-rose-200 hover:bg-rose-500/10 hover:text-rose-400 transition-all duration-200">
                <i class="fa-solid fa-right-from-bracket w-5 text-center text-lg"></i> Keluar
            </button>
        </form>
    </div>
</aside>
