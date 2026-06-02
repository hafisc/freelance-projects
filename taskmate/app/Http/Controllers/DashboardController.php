<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard ringkasan tugas.
     * Menghitung total tugas, status tugas, progres kerja, dan tugas mendekati deadline.
     */
    public function index()
    {
        $userId = auth()->id();

        // Mengambil query dasar tugas milik user yang sedang login
        $tasksQuery = Task::where('user_id', $userId);

        // Menghitung jumlah tugas berdasarkan status
        $totalTasks = (clone $tasksQuery)->count();
        $belumDikerjakan = (clone $tasksQuery)->where('status', 'belum_dikerjakan')->count();
        $sedangDikerjakan = (clone $tasksQuery)->where('status', 'sedang_dikerjakan')->count();
        $selesai = (clone $tasksQuery)->where('status', 'selesai')->count();

        // Menghitung persentase progress tugas selesai
        $progressPercentage = $totalTasks > 0 ? round(($selesai / $totalTasks) * 100) : 0;

        // Mendapatkan rentang tanggal untuk reminder (hari ini sampai 3 hari ke depan)
        $today = Carbon::today()->toDateString();
        $threeDaysLater = Carbon::today()->addDays(3)->toDateString();

        // Mengambil tugas yang belum selesai dan jatuh tempo dalam 3 hari ke depan
        $reminders = Task::where('user_id', $userId)
            ->where('status', '!=', 'selesai')
            ->whereBetween('deadline', [$today, $threeDaysLater])
            ->orderBy('deadline', 'asc')
            ->get();

        // Mengambil 5 tugas terdekat yang belum selesai untuk daftar prioritas kerja
        $upcomingTasks = Task::where('user_id', $userId)
            ->where('status', '!=', 'selesai')
            ->orderBy('deadline', 'asc')
            ->limit(5)
            ->get();

        // Mengirimkan seluruh data ringkasan ke view dashboard
        return view('dashboard', compact(
            'totalTasks',
            'belumDikerjakan',
            'sedangDikerjakan',
            'selesai',
            'progressPercentage',
            'reminders',
            'upcomingTasks'
        ));
    }
}
