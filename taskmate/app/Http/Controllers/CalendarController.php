<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CalendarController extends Controller
{
    /**
     * Menampilkan halaman kalender aktivitas tugas.
     * Mengelompokkan tugas berdasarkan tanggal deadline pada bulan yang dipilih.
     */
    public function index(Request $request)
    {
        $userId = auth()->id();

        // Mengambil parameter bulan dan tahun, default ke bulan dan tahun saat ini
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        // Membuat objek tanggal awal bulan
        $firstOfMonth = Carbon::createFromDate($year, $month, 1);
        
        // Menentukan nama bulan dalam Bahasa Indonesia
        $monthNamesId = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $monthName = $monthNamesId[(int)$month];

        // Menghitung jumlah hari dalam bulan tersebut
        $daysInMonth = $firstOfMonth->daysInMonth;

        // Menghitung hari pertama dalam minggu (0 = Minggu, 1 = Senin, dst.)
        $startOfWeekDay = $firstOfMonth->dayOfWeek; // 0 (Sunday) to 6 (Saturday)

        // Mengambil semua tugas milik user yang deadline-nya di bulan ini
        $startOfMonthDate = $firstOfMonth->copy()->startOfMonth()->toDateString();
        $endOfMonthDate = $firstOfMonth->copy()->endOfMonth()->toDateString();

        $tasks = Task::where('user_id', $userId)
            ->whereBetween('deadline', [$startOfMonthDate, $endOfMonthDate])
            ->orderBy('deadline', 'asc')
            ->get();

        // Mengelompokkan tugas berdasarkan tanggal deadline ('YYYY-MM-DD')
        $tasksByDate = [];
        foreach ($tasks as $task) {
            $tasksByDate[$task->deadline][] = $task;
        }

        // Tentukan tanggal yang dipilih (default hari ini jika bulan/tahun saat ini, atau tanggal 1 di bulan tersebut)
        $todayDate = Carbon::today()->toDateString();
        $selectedDate = $request->input('date');

        if (!$selectedDate) {
            $currentMonthYear = Carbon::now()->month == $month && Carbon::now()->year == $year;
            $selectedDate = $currentMonthYear ? $todayDate : $firstOfMonth->toDateString();
        }

        // Mengambil tugas khusus pada tanggal yang dipilih
        $selectedTasks = Task::where('user_id', $userId)
            ->where('deadline', $selectedDate)
            ->orderBy('priority', 'desc')
            ->get();

        // Navigasi bulan sebelumnya dan berikutnya
        $prevMonth = $firstOfMonth->copy()->subMonth();
        $nextMonth = $firstOfMonth->copy()->addMonth();

        return view('calendar.index', compact(
            'month',
            'year',
            'monthName',
            'daysInMonth',
            'startOfWeekDay',
            'tasksByDate',
            'selectedDate',
            'selectedTasks',
            'prevMonth',
            'nextMonth'
        ));
    }
}
