<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Menampilkan daftar tugas milik user yang sedang login.
     * Dilengkapi fitur pencarian, filter status, prioritas, kategori, dan pagination.
     */
    public function index(Request $request)
    {
        $userId = auth()->id();
        $query = Task::where('user_id', $userId);

        // Filter pencarian berdasarkan judul tugas
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan status tugas
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tingkat prioritas
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Filter berdasarkan kategori tugas
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Urutkan tugas berdasarkan deadline terdekat, lalu prioritas
        $tasks = $query->orderBy('deadline', 'asc')
            ->paginate(10)
            ->withQueryString();

        // Mengambil daftar kategori unik milik user untuk pilihan filter
        $categories = Task::where('user_id', $userId)
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category');

        return view('tasks.index', compact('tasks', 'categories'));
    }

    /**
     * Menampilkan form tambah tugas baru.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Menyimpan tugas baru ke database setelah divalidasi.
     */
    public function store(Request $request)
    {
        // Validasi input form tugas
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'deadline' => 'required|date',
            'status' => 'required|string|in:belum_dikerjakan,sedang_dikerjakan,selesai',
            'priority' => 'required|string|in:tinggi,sedang,rendah',
        ]);

        // Tambahkan user_id dari user yang sedang login
        $validated['user_id'] = auth()->id();

        // Simpan tugas ke database
        Task::create($validated);

        return redirect()->route('tasks.index')
            ->with('success', 'Tugas berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit tugas tertentu.
     * Memastikan tugas yang diedit adalah milik user yang login.
     */
    public function edit(Task $task)
    {
        // Pastikan user hanya bisa mengedit tugas miliknya sendiri
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke tugas ini.');
        }

        return view('tasks.edit', compact('task'));
    }

    /**
     * Memperbarui data tugas di database setelah divalidasi.
     * Memastikan tugas yang diperbarui adalah milik user yang login.
     */
    public function update(Request $request, Task $task)
    {
        // Pastikan user hanya bisa mengubah tugas miliknya sendiri
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke tugas ini.');
        }

        // Validasi input form tugas
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'deadline' => 'required|date',
            'status' => 'required|string|in:belum_dikerjakan,sedang_dikerjakan,selesai',
            'priority' => 'required|string|in:tinggi,sedang,rendah',
        ]);

        // Perbarui data tugas
        $task->update($validated);

        if ($request->query('redirect') === 'calendar') {
            return redirect()->route('calendar.index', ['date' => $task->deadline])
                ->with('success', 'Tugas berhasil diperbarui!');
        }

        return redirect()->route('tasks.index')
            ->with('success', 'Tugas berhasil diperbarui!');
    }

    /**
     * Menghapus tugas dari database.
     * Memastikan tugas yang dihapus adalah milik user yang login.
     */
    public function destroy(Task $task)
    {
        // Pastikan user hanya bisa menghapus tugas miliknya sendiri
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke tugas ini.');
        }

        // Hapus tugas
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Tugas berhasil dihapus!');
    }
}
