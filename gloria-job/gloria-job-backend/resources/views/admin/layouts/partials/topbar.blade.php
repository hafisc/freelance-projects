<header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 sticky top-0 z-30">
    
    <!-- Kiri: Hamburger Toggle & Mobile Brand -->
    <div class="flex items-center gap-4">
        <button class="md:hidden p-1 text-slate-600 hover:text-slate-900 border-0 bg-transparent" @click="sidebarOpen = true">
            <i class="fa-solid fa-bars fa-lg"></i>
        </button>
        <span class="md:hidden font-extrabold text-slate-900 flex items-center gap-2">
            <img src="{{ asset('assets/images/logo.jpg') }}" alt="Gloria Job Logo" class="h-6 w-6 object-contain rounded shadow-sm">
            GLORIA JOB
        </span>
        <span class="hidden md:flex items-center gap-2 text-slate-500 text-sm font-medium">
            <i class="fa-regular fa-calendar-check text-primaryBlue"></i> {{ date('d F Y') }}
        </span>
    </div>
    
    <!-- Kanan: Profile Info (Statis, Tanpa Dropdown) -->
    <div class="flex items-center gap-3">
        <div class="hidden sm:block text-right">
            <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Administrator</span>
            <strong class="block text-slate-800 text-sm -mt-0.5">{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</strong>
        </div>
        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ urlencode(Auth::guard('admin')->user()->name ?? 'Admin') }}" 
             class="w-9 h-9 rounded-full object-cover border border-slate-200 shadow-sm" alt="Avatar">
    </div>
</header>
