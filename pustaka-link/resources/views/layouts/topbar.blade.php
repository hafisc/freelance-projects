<header class="bg-white border-b border-libborder py-4 px-6 md:px-8 flex items-center justify-between sticky top-0 z-20">
    <div class="flex items-center space-x-4">
        <!-- Hamburger Menu Button Mobile -->
        <button onclick="window.toggleSidebar()" class="md:hidden text-libnavy focus:outline-none hover:text-libgold p-1 rounded-md hover:bg-libcream transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        
        <!-- Judul Halaman Aktif -->
        <h1 class="text-lg md:text-xl font-bold text-libnavy tracking-tight">
            @yield('page_title', 'PustakaLink')
        </h1>
    </div>

    <!-- Sisi Kanan: Tanggal & Info Pengguna -->
    <div class="flex items-center space-x-6">
        <!-- Hari & Tanggal Hari Ini (Indonesian Format) -->
        <div class="hidden sm:flex items-center space-x-2 text-xs text-libmuted">
            <svg class="w-4 h-4 text-libgold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span class="font-medium">
                @php
                    // Set lokalitas Carbon ke Indonesia untuk nama hari dan bulan
                    \Carbon\Carbon::setLocale('id');
                    echo \Carbon\Carbon::now()->translatedFormat('l, d F Y');
                @endphp
            </span>
        </div>

        <!-- Vertikal Separator -->
        <div class="hidden sm:block h-6 w-px bg-libborder"></div>

        <!-- Identitas Login Ringkas -->
        <div class="flex items-center space-x-3 text-right">
            <div class="leading-none">
                <span class="text-sm font-semibold text-libnavy block">{{ Auth::user()->name ?? 'Admin/Petugas' }}</span>
            </div>
            
            <div class="w-9 h-9 rounded-full bg-libcream border border-libgold flex items-center justify-center text-libnavy font-bold text-sm shadow-sm">
                {{ strtoupper(substr(Auth::user()->name ?? 'P', 0, 1)) }}
            </div>
        </div>
    </div>
</header>
