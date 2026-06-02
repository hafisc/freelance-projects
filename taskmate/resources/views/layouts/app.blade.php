<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TaskMate') }}</title>

        <!-- Fonts (Inter) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
        </style>
    </head>
    <body class="h-full antialiased text-slate-900">
        <div class="min-h-full flex">
            <!-- Sidebar Component -->
            <x-sidebar />

            <!-- Main Panel -->
            <div class="flex-1 flex flex-col lg:pl-64 min-w-0">
                <!-- Top Navigation Header -->
                @php
                    $notificationTasks = auth()->user()->tasks()
                        ->where('status', '!=', 'selesai')
                        ->whereDate('deadline', '>=', now()->toDateString())
                        ->whereDate('deadline', '<=', now()->addDays(3)->toDateString())
                        ->orderBy('deadline', 'asc')
                        ->take(5)
                        ->get();
                    $notificationCount = $notificationTasks->count();
                @endphp
                <header class="sticky top-0 z-30 h-16 bg-white border-b border-slate-200/80 flex items-center justify-between px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center space-x-4">
                        <!-- Toggle Button for Mobile -->
                        <button type="button" onclick="toggleSidebar()" class="lg:hidden text-slate-500 hover:text-slate-700 focus:outline-none p-1.5 rounded-lg hover:bg-slate-100 transition-colors">
                            <span class="sr-only">Buka sidebar</span>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        
                        <!-- Page Title Header Slot -->
                        @isset($header)
                            <div class="text-lg font-semibold text-slate-800 tracking-tight">
                                {{ $header }}
                            </div>
                        @endisset
                    </div>

                    <!-- Right Side Header (User type badge + Quick actions) -->
                    <div class="flex items-center space-x-3">
                        <!-- Notification Bell (Alpine.js Dropdown) -->
                        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                            <button @click="open = !open" class="relative p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-xl transition-all duration-200 cursor-pointer focus:outline-none">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                                @if($notificationCount > 0)
                                    <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 border-2 border-white rounded-full"></span>
                                @endif
                            </button>

                            <!-- Dropdown menu -->
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-80 bg-white border border-slate-200 shadow-xl rounded-2xl py-3 z-50 origin-top-right"
                                 style="display: none;">
                                <div class="px-4 pb-2 border-b border-slate-100 flex items-center justify-between">
                                    <span class="font-bold text-slate-800 text-sm">Notifikasi Pengingat</span>
                                    @if($notificationCount > 0)
                                        <span class="px-2 py-0.5 bg-red-50 text-red-600 rounded-full text-[10px] font-bold">{{ $notificationCount }} Tugas</span>
                                    @endif
                                </div>
                                <div class="max-h-64 overflow-y-auto px-2 pt-2 divide-y divide-slate-50">
                                    @forelse($notificationTasks as $task)
                                        @php
                                            $diff = \Carbon\Carbon::parse($task->deadline)->diffInDays(\Carbon\Carbon::today());
                                            $isToday = \Carbon\Carbon::parse($task->deadline)->isToday();
                                            $isTomorrow = \Carbon\Carbon::parse($task->deadline)->isTomorrow();
                                        @endphp
                                        <a href="{{ route('tasks.edit', $task->id) }}" class="flex flex-col p-3 rounded-xl hover:bg-slate-50 transition-colors duration-150">
                                            <span class="text-xs font-semibold text-slate-800 truncate">{{ $task->title }}</span>
                                            <div class="flex items-center space-x-1.5 mt-1 text-[10px]">
                                                @if($isToday)
                                                    <span class="text-red-600 font-bold">Hari Ini!</span>
                                                @elseif($isTomorrow)
                                                    <span class="text-amber-600 font-bold">Besok</span>
                                                @else
                                                    <span class="text-slate-500 font-medium">Dalam {{ $diff }} hari</span>
                                                @endif
                                                <span class="text-slate-300">•</span>
                                                <span class="text-slate-400 capitalize">{{ $task->category ?? 'Tugas' }}</span>
                                            </div>
                                        </a>
                                    @empty
                                        <div class="py-6 text-center text-slate-400 flex flex-col items-center justify-center">
                                            <svg class="w-8 h-8 text-slate-300 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-xs font-semibold">Semua aman! Tidak ada deadline dekat.</span>
                                        </div>
                                    @endforelse
                                </div>
                                <div class="px-3 pt-2 border-t border-slate-100 mt-2">
                                    <a href="{{ route('tasks.index') }}" class="block text-center text-[11px] font-semibold text-blue-600 hover:text-blue-700 py-1 hover:bg-blue-50 rounded-lg transition-colors">
                                        Lihat Semua Tugas
                                    </a>
                                </div>
                            </div>
                        </div>


                        @if(!request()->routeIs('tasks.create'))
                        <a href="{{ route('tasks.create') }}" class="inline-flex items-center space-x-1.5 px-4 py-2.5 rounded-xl text-sm font-semibold bg-blue-600 text-white hover:bg-blue-700 hover:scale-[1.02] active:scale-[0.98] shadow-sm shadow-blue-500/10 transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span class="hidden md:inline">Tambah Tugas</span>
                        </a>
                        @endif
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-y-auto">
                    <!-- Session Success Flash Alert -->
                    @if (session('success'))
                        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-800 rounded-2xl flex items-center space-x-3 shadow-sm">
                            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm font-medium">{{ session('success') }}</span>
                        </div>
                    @endif

                    {{ $slot }}
                </main>
            </div>
        </div>

        <!-- Sidebar Toggle Helper Script -->
        <script>
            function toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebar-overlay');
                if (sidebar.classList.contains('-translate-x-full')) {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('hidden');
                } else {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                }
            }
        </script>
    </body>
</html>
