<!-- Sidebar Container -->
<aside id="sidebar" class="bg-libnavy text-white w-64 h-screen flex-shrink-0 flex flex-col z-40 fixed top-0 left-0 bottom-0 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out shadow-lg md:shadow-none">
    <!-- Header Sidebar / Logo -->
    <div class="p-6 border-b border-white/10 flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <!-- Logo PustakaLink -->
            <img src="{{ asset('logo.png') }}" alt="Logo PustakaLink" class="w-8 h-8 object-contain">
            <div>
                <span class="text-lg font-bold tracking-wider block">PustakaLink</span>
                <span class="text-xs text-white/60 block -mt-1 font-medium">Perpustakaan</span>
            </div>
        </div>
        <!-- Close button mobile -->
        <button id="close-sidebar" class="md:hidden text-white hover:text-libgold focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Menu-Menu Sidebar -->
    <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
        <!-- 1. Dashboard -->
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-md transition-all duration-200 group {{ Route::is('dashboard') ? 'bg-white/10 text-libgold font-semibold' : 'text-white/80 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5 flex-shrink-0 transition-colors {{ Route::is('dashboard') ? 'text-libgold' : 'text-white/60 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"></path>
            </svg>
            <span>Dashboard</span>
        </a>

        <!-- 2. Data Anggota -->
        <a href="{{ route('members.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-md transition-all duration-200 group {{ Route::is('members.*') ? 'bg-white/10 text-libgold font-semibold' : 'text-white/80 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5 flex-shrink-0 transition-colors {{ Route::is('members.*') ? 'text-libgold' : 'text-white/60 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <span>Data Anggota</span>
        </a>

        <!-- 3. Data Buku -->
        <a href="{{ route('books.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-md transition-all duration-200 group {{ Route::is('books.*') ? 'bg-white/10 text-libgold font-semibold' : 'text-white/80 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5 flex-shrink-0 transition-colors {{ Route::is('books.*') ? 'text-libgold' : 'text-white/60 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            <span>Data Buku</span>
        </a>

        <!-- 4. Katalog Buku -->
        <a href="{{ route('catalog.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-md transition-all duration-200 group {{ Route::is('catalog.*') ? 'bg-white/10 text-libgold font-semibold' : 'text-white/80 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5 flex-shrink-0 transition-colors {{ Route::is('catalog.*') ? 'text-libgold' : 'text-white/60 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
            </svg>
            <span>Katalog Buku</span>
        </a>

        <!-- 5. Peminjaman -->
        <a href="{{ route('borrowings.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-md transition-all duration-200 group {{ Route::is('borrowings.*') && !Route::is('borrowings.history') ? 'bg-white/10 text-libgold font-semibold' : 'text-white/80 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5 flex-shrink-0 transition-colors {{ Route::is('borrowings.*') && !Route::is('borrowings.history') ? 'text-libgold' : 'text-white/60 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span>Peminjaman Buku</span>
        </a>

        <!-- 6. Riwayat Peminjaman -->
        <a href="{{ route('borrowings.history') }}" class="flex items-center space-x-3 px-4 py-3 rounded-md transition-all duration-200 group {{ Route::is('borrowings.history') ? 'bg-white/10 text-libgold font-semibold' : 'text-white/80 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5 flex-shrink-0 transition-colors {{ Route::is('borrowings.history') ? 'text-libgold' : 'text-white/60 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>Riwayat Peminjaman</span>
        </a>

        <!-- Pemisah / Garis -->
        {{-- <div class="h-px bg-white/10 my-4"></div> --}}

        <!-- 7. Dokumentasi / Testing (halaman statis info project & status test) -->
        {{-- <a href="{{ route('docs.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-md transition-all duration-200 group {{ Route::is('docs.*') ? 'bg-white/10 text-libgold font-semibold' : 'text-white/80 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5 flex-shrink-0 transition-colors {{ Route::is('docs.*') ? 'text-libgold' : 'text-white/60 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <span>Dokumentasi & Test</span>
        </a> --}}
    </nav>

    <!-- Logout / Profil singkat petugas -->
    <div class="p-4 border-t border-white/10 bg-white/5 flex flex-col space-y-3">
       
        
        <form action="{{ route('logout') }}" method="POST" class="block w-full">
            @csrf
            <button type="submit" class="w-full flex items-center space-x-3 px-4 py-2.5 rounded-md text-red-300 hover:bg-red-950/30 hover:text-red-200 transition text-sm font-medium">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>

<!-- Mobile Overlay & Drawer Scripts -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden md:hidden"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const closeBtn = document.getElementById('close-sidebar');
        
        // Fungsi pembuka sidebar (dipanggil dari topbar menu button)
        window.toggleSidebar = function() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden');
        };

        const closeSidebar = () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        };

        closeBtn.addEventListener('click', closeSidebar);
        overlay.addEventListener('click', closeSidebar);
    });
</script>
