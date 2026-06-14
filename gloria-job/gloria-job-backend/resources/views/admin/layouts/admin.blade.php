<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') | Gloria Job</title>
    
    <!-- Google Fonts Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS v3 -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        primaryBlue: '#2563eb',   // Royal Blue
                        primaryDark: '#1e3a8a',   // Royal Navy
                        accentCyan: '#06b6d4',    // Accent Cyan
                        success: '#16a34a',
                        warning: '#f59e0b',
                        danger: '#dc2626',
                    }
                }
            }
        }
    </script>
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
    @yield('styles')
</head>
<body class="bg-slate-50 text-slate-900 antialiased font-sans" x-data="{ sidebarOpen: false }">

    <!-- Container Utama -->
    <div class="min-h-screen flex flex-col md:flex-row">
        
        <!-- Sidebar Menu -->
        @include('admin.layouts.partials.sidebar')

        <!-- Main Content Area -->
        <div class="flex-grow flex flex-col min-h-screen md:pl-64">
            
            <!-- Topbar / Header -->
            @include('admin.layouts.partials.topbar')
            
            <!-- Main Content Grid -->
            <main class="flex-grow p-6 md:p-8 max-w-[1600px] w-full mx-auto">
                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="mb-6 flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-100 text-emerald-800 rounded-2xl shadow-sm text-sm font-medium relative pr-12" 
                         x-data="{ show: true }" x-show="show">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                        <span>{{ session('success') }}</span>
                        <button class="absolute right-4 text-emerald-500 hover:text-emerald-700" @click="show = false">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mb-6 flex items-center gap-3 p-4 bg-rose-50 border border-rose-100 text-rose-800 rounded-2xl shadow-sm text-sm font-medium relative pr-12" 
                         x-data="{ show: true }" x-show="show">
                        <i class="fa-solid fa-triangle-exclamation text-rose-600 text-lg"></i>
                        <span>{{ session('error') }}</span>
                        <button class="absolute right-4 text-rose-500 hover:text-rose-700" @click="show = false">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>

    @yield('scripts')
</body>
</html>
