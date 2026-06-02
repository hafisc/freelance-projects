<x-app-layout>
    <!-- Header Halaman -->
    <x-slot name="header">
        Daftar Tugas
    </x-slot>

    <!-- Konten Utama Halaman Tugas -->
    <div class="space-y-6">
        
        <!-- Form Filter & Pencarian -->
        <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200/60 shadow-sm">
            <form id="filter-form" action="{{ route('tasks.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
                <!-- Input Pencarian -->
                <div class="lg:col-span-2">
                    <label for="search" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Cari Tugas</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Ketik judul tugas..." 
                               class="w-full pl-10 pr-4 py-3 bg-slate-50/70 border border-slate-200 hover:border-slate-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:bg-white rounded-xl text-sm transition-all duration-200 outline-none">
                    </div>
                </div>

                <!-- Filter Status -->
                <div>
                    <label for="status" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <select name="status" id="status" 
                                class="w-full pl-10 pr-9 py-3 bg-slate-50/70 border border-slate-200 hover:border-slate-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:bg-white rounded-xl text-sm transition-all duration-200 appearance-none cursor-pointer outline-none">
                            <option value="">Semua Status</option>
                            <option value="belum_dikerjakan" {{ request('status') === 'belum_dikerjakan' ? 'selected' : '' }}>Belum Dikerjakan</option>
                            <option value="sedang_dikerjakan" {{ request('status') === 'sedang_dikerjakan' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                            <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Filter Prioritas -->
                <div>
                    <label for="priority" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Prioritas</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path>
                            </svg>
                        </div>
                        <select name="priority" id="priority" 
                                class="w-full pl-10 pr-9 py-3 bg-slate-50/70 border border-slate-200 hover:border-slate-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:bg-white rounded-xl text-sm transition-all duration-200 appearance-none cursor-pointer outline-none">
                            <option value="">Semua Prioritas</option>
                            <option value="tinggi" {{ request('priority') === 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                            <option value="sedang" {{ request('priority') === 'sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="rendah" {{ request('priority') === 'rendah' ? 'selected' : '' }}>Rendah</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Filter Kategori & Tombol Aksi Form -->
                <div class="flex items-end space-x-2">
                    <div class="flex-1">
                        <label for="category" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kategori</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <select name="category" id="category" 
                                    class="w-full pl-10 pr-9 py-3 bg-slate-50/70 border border-slate-200 hover:border-slate-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:bg-white rounded-xl text-sm transition-all duration-200 appearance-none cursor-pointer outline-none">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div id="reset-btn-container" class="inline-flex">
                        @if(request()->anyFilled(['search', 'status', 'priority', 'category']))
                            <a href="{{ route('tasks.index') }}" class="p-3 bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-700 hover:scale-[1.02] active:scale-[0.98] rounded-xl transition-all duration-200 shrink-0 cursor-pointer" title="Reset Filter">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Bagian Render Tugas -->
        <div id="tasks-container">
            @if($tasks->isEmpty())
            <!-- Tampilan Jika Data Tugas Kosong -->
            <div class="bg-white p-12 text-center rounded-3xl border border-slate-100 shadow-sm flex flex-col items-center justify-center">
                <div class="w-16 h-16 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800">Tugas Tidak Ditemukan</h3>
                <p class="text-sm text-slate-400 mt-1 max-w-sm">
                    @if(request()->anyFilled(['search', 'status', 'priority', 'category']))
                        Tidak ada tugas yang cocok dengan filter pencarian Anda. Coba reset filter.
                    @else
                        Anda belum memiliki tugas terdaftar. Klik "Tambah Tugas" untuk memulai.
                    @endif
                </p>
                @if(!request()->anyFilled(['search', 'status', 'priority', 'category']))
                    <a href="{{ route('tasks.create') }}" class="mt-4 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 hover:scale-[1.02] active:scale-[0.98] text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-200">
                        Tambah Tugas Baru
                    </a>
                @endif
            </div>
        @else
            <!-- Tampilan Desktop: Tabel (Visible md ke atas) -->
            <div class="hidden md:block bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/70 border-b border-slate-100">
                                <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider pl-6">Judul Tugas</th>
                                <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Kategori</th>
                                <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Deadline</th>
                                <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Prioritas</th>
                                <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right pr-6">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($tasks as $task)
                                <tr class="hover:bg-slate-50/30 transition-colors duration-150">
                                    <td class="p-4 pl-6">
                                        <div class="space-y-0.5">
                                            <h4 class="text-sm font-semibold text-slate-800 max-w-xs truncate" title="{{ $task->title }}">
                                                {{ $task->title }}
                                            </h4>
                                            @if($task->description)
                                                <p class="text-xs text-slate-400 max-w-xs truncate" title="{{ $task->description }}">
                                                    {{ $task->description }}
                                                </p>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-4 text-sm text-slate-600 capitalize">
                                        <span class="px-2.5 py-1 bg-slate-100 border border-slate-200/60 rounded-lg text-xs font-medium text-slate-700">
                                            {{ $task->category ?? 'Tanpa Kategori' }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-sm font-medium text-slate-700">
                                        {{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}
                                    </td>
                                    <td class="p-4">
                                        <x-priority-badge :priority="$task->priority" />
                                    </td>
                                    <td class="p-4">
                                        <x-status-badge :status="$task->status" />
                                    </td>
                                    <td class="p-4 text-right pr-6 shrink-0">
                                        <div class="flex items-center justify-end space-x-1">
                                            <!-- Tombol Edit -->
                                            <a href="{{ route('tasks.edit', $task->id) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all duration-200" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                                </svg>
                                            </a>
                                            <!-- Form Hapus -->
                                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tugas ini?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200 cursor-pointer" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tampilan Mobile: Daftar Card (Visible di mobile, hidden md ke atas) -->
            <div class="block md:hidden space-y-4">
                @foreach($tasks as $task)
                    <div class="bg-white p-5 border border-slate-100 rounded-3xl shadow-sm space-y-4">
                        <div class="space-y-1">
                            <h4 class="text-sm font-semibold text-slate-800">{{ $task->title }}</h4>
                            @if($task->description)
                                <p class="text-xs text-slate-500">{{ $task->description }}</p>
                            @endif
                        </div>
                        
                        <div class="grid grid-cols-2 gap-3 py-3 border-y border-slate-100/50 text-xs">
                            <div>
                                <span class="text-slate-400 block mb-0.5">Kategori</span>
                                <span class="font-semibold text-slate-700 capitalize">{{ $task->category ?? 'Tanpa Kategori' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block mb-0.5">Deadline</span>
                                <span class="font-semibold text-slate-700">{{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block mb-0.5">Prioritas</span>
                                <x-priority-badge :priority="$task->priority" />
                            </div>
                            <div>
                                <span class="text-slate-400 block mb-0.5">Status</span>
                                <x-status-badge :status="$task->status" />
                            </div>
                        </div>

                        <!-- Aksi Tombol Mobile -->
                        <div class="flex items-center justify-end space-x-2 pt-1">
                            <a href="{{ route('tasks.edit', $task->id) }}" class="flex items-center space-x-1.5 px-3 py-2 bg-slate-50 border border-slate-200/60 text-slate-600 rounded-xl text-xs font-semibold hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 transition-all duration-200">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                                <span>Ubah</span>
                            </a>

                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tugas ini?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="flex items-center space-x-1.5 px-3 py-2 bg-red-50 border border-red-150 text-red-600 rounded-xl text-xs font-semibold hover:bg-red-100 hover:border-red-200 transition-all duration-200 cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    <span>Hapus</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination Links -->
            <div class="mt-4">
                {{ $tasks->links() }}
            </div>
        @endif
        </div>
    </div>

    {{-- Script Live Search & Filter Asinkron (AJAX) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterForm = document.getElementById('filter-form');
            const searchInput = document.getElementById('search');
            const tasksContainer = document.getElementById('tasks-container');
            const resetBtnContainer = document.getElementById('reset-btn-container');
            let debounceTimer;

            if (!filterForm || !tasksContainer) return;

            // Fungsi utama untuk memuat data via AJAX
            function fetchTasks() {
                const formData = new FormData(filterForm);
                const queryString = new URLSearchParams(formData).toString();
                const url = `${filterForm.action}?${queryString}`;

                // Update URL browser tanpa reload halaman
                window.history.pushState(null, '', url);

                // Tambahkan efek loading (transparansi)
                tasksContainer.style.opacity = '0.5';
                tasksContainer.style.transition = 'opacity 0.15s ease-in-out';

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    
                    // Ganti isi kontainer tugas
                    const newTasksContainer = doc.getElementById('tasks-container');
                    if (newTasksContainer) {
                        tasksContainer.innerHTML = newTasksContainer.innerHTML;
                    }

                    // Ganti isi tombol reset filter
                    const newResetBtnContainer = doc.getElementById('reset-btn-container');
                    if (newResetBtnContainer && resetBtnContainer) {
                        resetBtnContainer.innerHTML = newResetBtnContainer.innerHTML;
                        bindResetEvent(); // Bind ulang event click ke tombol reset yang baru dimuat
                    }
                    
                    tasksContainer.style.opacity = '1';
                })
                .catch(error => {
                    console.error('Error fetching tasks:', error);
                    tasksContainer.style.opacity = '1';
                });
            }

            // Fungsi bind event click untuk reset button
            function bindResetEvent() {
                if (!resetBtnContainer) return;
                const resetBtn = resetBtnContainer.querySelector('a');
                if (resetBtn) {
                    resetBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        // Kosongkan form
                        filterForm.reset();
                        if (searchInput) searchInput.value = '';
                        filterForm.querySelectorAll('select').forEach(select => select.value = '');
                        // Ambil data ulang
                        fetchTasks();
                    });
                }
            }

            // Ambil input pencarian dengan debounce (300ms)
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(fetchTasks, 300);
                });
            }

            // Dropdown filter berubah -> langsung load
            filterForm.querySelectorAll('select').forEach(select => {
                select.addEventListener('change', fetchTasks);
            });

            // Mencegah form di-submit via enter/button tradisional
            filterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                clearTimeout(debounceTimer);
                fetchTasks();
            });

            // Bind reset button pertama kali saat halaman dimuat
            bindResetEvent();
        });
    </script>
</x-app-layout>
