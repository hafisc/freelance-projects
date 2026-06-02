<x-app-layout>
    <!-- Header Halaman -->
    <x-slot name="header">
        Ringkasan Aktivitas
    </x-slot>

    <!-- Konten Dashboard -->
    <div class="space-y-6">
        <!-- Selamat Datang & Deskripsi Ringkas (Solid bg-slate-900, Tanpa Gradasi) -->
        <div class="bg-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-md border border-slate-800">
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                Halo, {{ auth()->user()->name }}! 👋
            </h1>
            <p class="text-slate-300 text-sm sm:text-base mt-2 max-w-xl font-medium">
                Selamat datang kembali di TaskMate. Mari kelola dan selesaikan tugas-tugas produktif Anda hari ini dengan teratur.
            </p>
        </div>

        <!-- Grid Statistik Menggunakan Komponen Reusable -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            <!-- Total Tugas -->
            <x-stat-card title="Total Tugas" value="{{ $totalTasks }}" iconBg="bg-blue-50" iconColor="text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </x-stat-card>

            <!-- Belum Dikerjakan -->
            <x-stat-card title="Belum Dikerjakan" value="{{ $belumDikerjakan }}" iconBg="bg-red-50" iconColor="text-red-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </x-stat-card>

            <!-- Sedang Dikerjakan -->
            <x-stat-card title="Sedang Dikerjakan" value="{{ $sedangDikerjakan }}" iconBg="bg-amber-50" iconColor="text-amber-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </x-stat-card>

            <!-- Selesai -->
            <x-stat-card title="Selesai" value="{{ $selesai }}" iconBg="bg-emerald-50" iconColor="text-emerald-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </x-stat-card>
        </div>

        <!-- Visualisasi Progres Produktivitas (Solid bg-blue-600, Tanpa Gradasi) -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Progres Penyelesaian Tugas</h3>
                    <p class="text-xs text-slate-500">Persentase tugas yang sudah selesai dikerjakan.</p>
                </div>
                <span class="text-2xl font-black text-blue-600">{{ $progressPercentage }}%</span>
            </div>
            
            <!-- Progress Bar -->
            <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
                <div class="bg-blue-600 h-full rounded-full transition-all duration-500" style="width: {{ $progressPercentage }}%"></div>
            </div>
            
            <p class="text-xs text-slate-500 font-medium">
                {{ $selesai }} dari {{ $totalTasks }} tugas selesai dikerjakan. 
                @if($progressPercentage === 100 && $totalTasks > 0)
                    Luar biasa! Semua tugas Anda telah selesai dikerjakan 🎉
                @elseif($progressPercentage > 50)
                    Hebat! Progres Anda sudah lebih dari setengah jalan. Pertahankan! 💪
                @elseif($totalTasks > 0)
                    Teruslah berusaha! Selesaikan tugas yang mendekati deadline terlebih dahulu. 👍
                @else
                    Belum ada tugas yang dibuat. Silakan tambahkan tugas baru. 📝
                @endif
            </p>
        </div>

        <!-- Kolom Detil Utama -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Kolom Kiri: Reminder & Pengingat Deadline Dekat -->
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col h-full">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 font-bold">Pengingat Deadline Dekat ⚠️</h3>
                        <p class="text-xs text-slate-500">Tugas yang batas waktunya hari ini, besok, atau dalam 3 hari ke depan.</p>
                    </div>
                </div>

                <div class="flex-1 space-y-3">
                    @forelse($reminders as $task)
                        @php
                            $diffInDays = \Carbon\Carbon::parse($task->deadline)->diffInDays(\Carbon\Carbon::today());
                            $isToday = \Carbon\Carbon::parse($task->deadline)->isToday();
                            $isTomorrow = \Carbon\Carbon::parse($task->deadline)->isTomorrow();
                        @endphp
                        <div class="flex items-start justify-between p-4 rounded-2xl border {{ $isToday ? 'bg-red-50/60 border-red-200 text-red-950' : 'bg-slate-50 border-slate-100 text-slate-800' }} hover:shadow-sm transition-all duration-200">
                            <div class="space-y-1 overflow-hidden pr-2">
                                <h4 class="text-sm font-semibold truncate">{{ $task->title }}</h4>
                                <div class="flex items-center space-x-2 text-xs">
                                    <span class="font-medium">
                                        @if($isToday)
                                            <span class="text-red-600 font-bold">Hari Ini!</span>
                                        @elseif($isTomorrow)
                                            <span class="text-amber-600 font-bold">Besok</span>
                                        @else
                                            <span class="text-slate-600">Dalam {{ $diffInDays }} hari</span>
                                        @endif
                                        <span class="text-slate-500">({{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }})</span>
                                    </span>
                                    <span class="text-slate-300">•</span>
                                    <span class="capitalize text-slate-500">{{ $task->category ?? 'Tanpa Kategori' }}</span>
                                </div>
                            </div>
                            
                            <!-- Badges -->
                            <div class="flex flex-col sm:flex-row items-end sm:items-center gap-1.5 shrink-0">
                                <x-priority-badge :priority="$task->priority" />
                                <x-status-badge :status="$task->status" />
                            </div>
                        </div>
                    @empty
                        <div class="h-full flex flex-col items-center justify-center py-12 text-center">
                            <div class="w-16 h-16 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mb-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <h4 class="text-sm font-bold text-slate-800">Aman dan Terkendali!</h4>
                            <p class="text-xs text-slate-400 mt-1 max-w-xs">Tidak ada tugas mendesak yang mendekati deadline dalam 3 hari ke depan.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Kolom Kanan: Tugas Terdekat Yang Belum Selesai -->
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col h-full">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 font-bold">Daftar Prioritas Kerja 📋</h3>
                        <p class="text-xs text-slate-500">Tugas aktif terdekat yang perlu segera dikerjakan.</p>
                    </div>
                    <a href="{{ route('tasks.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors">Lihat Semua</a>
                </div>

                <div class="flex-1 space-y-3">
                    @forelse($upcomingTasks as $task)
                        <div class="flex items-center justify-between p-4 bg-slate-50 border border-slate-100 rounded-2xl hover:shadow-sm hover:border-slate-200/80 transition-all duration-200">
                            <div class="space-y-1 overflow-hidden pr-2">
                                <h4 class="text-sm font-semibold text-slate-800 truncate">{{ $task->title }}</h4>
                                <div class="flex items-center space-x-2 text-xs text-slate-500">
                                    <span>Deadline: {{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}</span>
                                    <span>•</span>
                                    <span class="capitalize">{{ $task->category ?? 'Tanpa Kategori' }}</span>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2 shrink-0">
                                <x-priority-badge :priority="$task->priority" />
                                <a href="{{ route('tasks.edit', $task->id) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all duration-200" title="Edit Tugas">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="h-full flex flex-col items-center justify-center py-12 text-center">
                            <div class="w-16 h-16 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mb-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"></path>
                                </svg>
                            </div>
                            <h4 class="text-sm font-bold text-slate-800">Semua Beres!</h4>
                            <p class="text-xs text-slate-400 mt-1 max-w-xs">Anda tidak memiliki tugas aktif saat ini. Santai sejenak atau tambahkan tugas baru.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
