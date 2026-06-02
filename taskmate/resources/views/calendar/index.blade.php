<x-app-layout>
    <!-- Header Halaman -->
    <x-slot name="header">
        Kalender Aktivitas
    </x-slot>

    <!-- Konten Utama Halaman Kalender -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Kalender Bulanan (Kiri/Utama) -->
        <div class="lg:col-span-2 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-6">
            <!-- Navigasi Bulan -->
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div>
                    <h3 class="text-xl font-bold text-slate-800 leading-tight">
                        {{ $monthName }} {{ $year }}
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Klik tanggal untuk melihat daftar tugas yang jatuh tempo.</p>
                </div>

                <div class="flex items-center space-x-2">
                    <!-- Bulan Sebelumnya -->
                    <a href="{{ route('calendar.index', ['month' => $prevMonth->month, 'year' => $prevMonth->year]) }}" class="p-2.5 bg-slate-50 hover:bg-slate-100 border border-slate-200/60 text-slate-600 hover:scale-[1.02] active:scale-[0.98] rounded-xl transition-all duration-200 cursor-pointer" title="Bulan Sebelumnya">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                    
                    <!-- Hari Ini / Kembali ke bulan berjalan -->
                    <a href="{{ route('calendar.index') }}" class="px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 hover:scale-[1.02] active:scale-[0.98] text-xs font-semibold rounded-xl transition-all duration-200 cursor-pointer">
                        Bulan Ini
                    </a>

                    <!-- Bulan Berikutnya -->
                    <a href="{{ route('calendar.index', ['month' => $nextMonth->month, 'year' => $nextMonth->year]) }}" class="p-2.5 bg-slate-50 hover:bg-slate-100 border border-slate-200/60 text-slate-600 hover:scale-[1.02] active:scale-[0.98] rounded-xl transition-all duration-200 cursor-pointer" title="Bulan Berikutnya">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Grid Header Hari (Minggu - Sabtu) -->
            <div class="grid grid-cols-7 gap-2 text-center text-xs font-bold text-slate-400 uppercase tracking-wider">
                <div>Min</div>
                <div>Sen</div>
                <div>Sel</div>
                <div>Rab</div>
                <div>Kam</div>
                <div>Jum</div>
                <div>Sab</div>
            </div>

            <!-- Grid Tanggal Kalender -->
            <div class="grid grid-cols-7 gap-2">
                <!-- 1. Menampilkan slot kosong awal sebelum tanggal 1 -->
                @for($i = 0; $i < $startOfWeekDay; $i++)
                    <div class="aspect-square bg-slate-50/30 rounded-2xl border border-dashed border-slate-100"></div>
                @endfor

                <!-- 2. Loop rendering tanggal dalam bulan terpilih -->
                @for($day = 1; $day <= $daysInMonth; $day++)
                    @php
                        // Format tanggal ISO 'YYYY-MM-DD'
                        $dateString = sprintf('%04d-%02d-%02d', $year, $month, $day);
                        $hasTasks = isset($tasksByDate[$dateString]);
                        
                        $isToday = $dateString === \Carbon\Carbon::today()->toDateString();
                        $isSelected = $dateString === $selectedDate;
                        
                        // Menentukan gaya kelas CSS berdasarkan state
                        $cellClass = 'aspect-square rounded-2xl flex flex-col items-center justify-between p-2.5 border transition-all duration-200 cursor-pointer ';
                        if ($isSelected) {
                            $cellClass .= 'bg-blue-600 border-blue-600 text-white shadow-md shadow-blue-500/20 hover:bg-blue-700';
                        } elseif ($isToday) {
                            $cellClass .= 'bg-blue-50/70 border-blue-200 text-blue-700 font-bold hover:bg-blue-100/50';
                        } else {
                            $cellClass .= 'bg-slate-50 hover:bg-slate-100 border-slate-200/50 text-slate-700';
                        }
                    @endphp

                    <a href="{{ route('calendar.index', ['month' => $month, 'year' => $year, 'date' => $dateString]) }}" class="{{ $cellClass }}">
                        <span class="text-xs sm:text-sm font-semibold">{{ $day }}</span>
                        
                        <!-- Indikator Dot Jika Ada Deadline Tugas di Tanggal Tersebut -->
                        <div class="flex space-x-0.5 justify-center mt-1 shrink-0 h-1.5">
                            @if($hasTasks)
                                @php
                                    $completedCount = collect($tasksByDate[$dateString])->where('status', 'selesai')->count();
                                    $allCount = count($tasksByDate[$dateString]);
                                    $hasUncompleted = $completedCount < $allCount;
                                @endphp
                                @if($hasUncompleted)
                                    <!-- Jika ada tugas yang belum selesai, tampilkan dot merah/putih -->
                                    <span class="w-1.5 h-1.5 rounded-full {{ $isSelected ? 'bg-white' : 'bg-rose-500' }}"></span>
                                @endif
                            @endif
                        </div>
                    </a>
                @endfor
            </div>
        </div>

        <!-- Detail Tugas Hari Terpilih (Kanan) -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col h-full">
            <div class="pb-4 border-b border-slate-100 mb-4">
                <h3 class="text-lg font-bold text-slate-800">Detail Harian 📌</h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    Batas waktu: <span class="font-semibold text-slate-700">{{ \Carbon\Carbon::parse($selectedDate)->format('d F Y') }}</span>
                </p>
            </div>

            <!-- List Tugas pada Tanggal Terpilih -->
            <div class="flex-1 space-y-4">
                @forelse($selectedTasks as $task)
                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl space-y-3 hover:shadow-sm hover:border-slate-200/80 transition-all duration-200">
                        <div class="space-y-1">
                            <h4 class="text-sm font-semibold text-slate-800">{{ $task->title }}</h4>
                            @if($task->description)
                                <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">{{ $task->description }}</p>
                            @endif
                        </div>

                        <div class="flex items-center justify-between text-xs pt-2.5 border-t border-slate-200/50">
                            <span class="capitalize px-2 py-0.5 bg-white border border-slate-200/60 rounded text-[11px] font-medium text-slate-600">
                                {{ $task->category ?? 'Tanpa Kategori' }}
                            </span>
                            <div class="flex space-x-1">
                                <x-priority-badge :priority="$task->priority" />
                                <x-status-badge :status="$task->status" />
                            </div>
                        </div>

                        <!-- Aksi Pintasan Edit -->
                        <div class="flex justify-end pt-1">
                            <a href="{{ route('tasks.edit', $task->id) }}?redirect=calendar" class="inline-flex items-center space-x-1 px-3 py-1.5 bg-white border border-slate-200 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 hover:scale-[1.02] active:scale-[0.98] rounded-xl text-xs font-semibold text-slate-600 transition-all duration-200 cursor-pointer">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                                <span>Ubah Tugas</span>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="h-full flex flex-col items-center justify-center py-12 text-center">
                        <div class="w-16 h-16 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center mb-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h4 class="text-sm font-bold text-slate-800">Tidak Ada Deadline</h4>
                        <p class="text-xs text-slate-400 mt-1 max-w-xs">Tidak ada tugas yang memiliki batas waktu di tanggal ini.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</x-app-layout>
