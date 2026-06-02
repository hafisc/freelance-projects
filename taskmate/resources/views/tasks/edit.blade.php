<x-app-layout>
    <!-- Header Halaman -->
    <x-slot name="header">
        Ubah Tugas
    </x-slot>

    <!-- Container Form -->
    <div class="max-w-3xl mx-auto">
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/60 shadow-sm space-y-6">
            
            <div class="flex items-center justify-between pb-5 border-b border-slate-100">
                <div>
                    <h3 class="text-xl font-extrabold text-slate-800 tracking-tight">Form Ubah Tugas</h3>
                    <p class="text-xs font-medium text-slate-400 mt-1">Perbarui detail informasi tugas Anda.</p>
                </div>
                <a href="{{ route('tasks.index') }}" class="inline-flex items-center space-x-1.5 px-4 py-2 bg-slate-50 hover:bg-slate-100 border border-slate-200/80 text-slate-600 rounded-xl text-xs font-bold hover:scale-[1.02] active:scale-[0.98] transition-all duration-200 cursor-pointer shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Kembali</span>
                </a>
            </div>

            <!-- Form Proses Update ke route tasks.update -->
            <form action="{{ route('tasks.update', $task->id) }}{{ request()->has('redirect') ? '?redirect=' . request('redirect') : '' }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')

                <!-- Judul Tugas -->
                <div>
                    <label for="title" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 flex items-center space-x-1">
                        <span>Judul Tugas</span>
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <input type="text" name="title" id="title" value="{{ old('title', $task->title) }}" required placeholder="Ketik judul tugas Anda..." 
                               class="w-full pl-11 pr-4 py-3 bg-slate-50/70 border @error('title') border-red-500 focus:border-red-500 focus:ring-red-500/10 @else border-slate-200 focus:border-blue-500 focus:ring-blue-500/10 @enderror focus:bg-white rounded-xl text-sm transition-all duration-200 outline-none hover:border-slate-300 focus:ring-4">
                    </div>
                    @error('title')
                        <p class="text-xs text-red-500 mt-2 font-semibold flex items-center space-x-1">
                            <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Deskripsi Tugas -->
                <div>
                    <label for="description" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Deskripsi Tugas</label>
                    <div class="relative">
                        <div class="absolute top-3.5 left-0 pl-3.5 flex items-start pointer-events-none text-slate-400">
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                            </svg>
                        </div>
                        <textarea name="description" id="description" rows="4" placeholder="Detail deskripsi mengenai tugas..." 
                                  class="w-full pl-11 pr-4 py-3 bg-slate-50/70 border @error('description') border-red-500 focus:border-red-500 focus:ring-red-500/10 @else border-slate-200 focus:border-blue-500 focus:ring-blue-500/10 @enderror focus:bg-white rounded-xl text-sm transition-all duration-200 outline-none hover:border-slate-300 focus:ring-4">{{ old('description', $task->description) }}</textarea>
                    </div>
                    @error('description')
                        <p class="text-xs text-red-500 mt-2 font-semibold flex items-center space-x-1">
                            <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Baris Kategori & Deadline -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Kategori -->
                    <div>
                        <label for="category" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kategori Tugas</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <input type="text" name="category" id="category" value="{{ old('category', $task->category) }}" placeholder="Contoh: Kuliah, Kerja, Pribadi, Organisasi" 
                                   class="w-full pl-11 pr-4 py-3 bg-slate-50/70 border @error('category') border-red-500 focus:border-red-500 focus:ring-red-500/10 @else border-slate-200 focus:border-blue-500 focus:ring-blue-500/10 @enderror focus:bg-white rounded-xl text-sm transition-all duration-200 outline-none hover:border-slate-300 focus:ring-4">
                        </div>
                        @error('category')
                            <p class="text-xs text-red-500 mt-2 font-semibold flex items-center space-x-1">
                                <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Tanggal Deadline -->
                    <div>
                        <label for="deadline" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 flex items-center space-x-1">
                            <span>Batas Waktu (Deadline)</span>
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <input type="date" name="deadline" id="deadline" value="{{ old('deadline', $task->deadline) }}" required 
                                   class="w-full pl-11 pr-4 py-3 bg-slate-50/70 border @error('deadline') border-red-500 focus:border-red-500 focus:ring-red-500/10 @else border-slate-200 focus:border-blue-500 focus:ring-blue-500/10 @enderror focus:bg-white rounded-xl text-sm transition-all duration-200 outline-none hover:border-slate-300 focus:ring-4">
                        </div>
                        @error('deadline')
                            <p class="text-xs text-red-500 mt-2 font-semibold flex items-center space-x-1">
                                <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Baris Status & Prioritas -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status Pengerjaan</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <select name="status" id="status" 
                                    class="w-full pl-11 pr-10 py-3 bg-slate-50/70 border border-slate-200 focus:border-blue-500 focus:ring-blue-500/10 focus:bg-white rounded-xl text-sm transition-all duration-200 appearance-none cursor-pointer hover:border-slate-300 focus:ring-4 outline-none">
                                <option value="belum_dikerjakan" {{ old('status', $task->status) === 'belum_dikerjakan' ? 'selected' : '' }}>Belum Dikerjakan</option>
                                <option value="sedang_dikerjakan" {{ old('status', $task->status) === 'sedang_dikerjakan' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                                <option value="selesai" {{ old('status', $task->status) === 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                        @error('status')
                            <p class="text-xs text-red-500 mt-2 font-semibold flex items-center space-x-1">
                                <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Prioritas -->
                    <div>
                        <label for="priority" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tingkat Prioritas</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path>
                                </svg>
                            </div>
                            <select name="priority" id="priority" 
                                    class="w-full pl-11 pr-10 py-3 bg-slate-50/70 border border-slate-200 focus:border-blue-500 focus:ring-blue-500/10 focus:bg-white rounded-xl text-sm transition-all duration-200 appearance-none cursor-pointer hover:border-slate-300 focus:ring-4 outline-none">
                                <option value="tinggi" {{ old('priority', $task->priority) === 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                                <option value="sedang" {{ old('priority', $task->priority) === 'sedang' ? 'selected' : '' }}>Sedang</option>
                                <option value="rendah" {{ old('priority', $task->priority) === 'rendah' ? 'selected' : '' }}>Rendah</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                        @error('priority')
                            <p class="text-xs text-red-500 mt-2 font-semibold flex items-center space-x-1">
                                <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Tombol Aksi Form -->
                <div class="flex items-center justify-end space-x-3 pt-5 border-t border-slate-100 mt-6">
                    <a href="{{ route('tasks.index') }}" class="px-5 py-3 bg-slate-100 hover:bg-slate-200 hover:scale-[1.02] active:scale-[0.98] text-slate-600 rounded-xl text-sm font-semibold transition-all duration-200 cursor-pointer shadow-sm">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 hover:scale-[1.02] active:scale-[0.98] text-white rounded-xl text-sm font-bold shadow-md shadow-blue-500/10 transition-all duration-200 cursor-pointer">
                        Perbarui Tugas
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
