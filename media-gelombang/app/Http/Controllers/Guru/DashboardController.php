<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Nilai;
use App\Models\DurasiBelajar;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::with(['nilais'])->get();

        $durasiVsNilai = $users->map(function ($user) {
            $nilai = $user->nilais->avg('score');

            return [
                'nama' => $user->name,
                'durasi' => 0,
                'nilai' => round($nilai, 1),
            ];
        });

        $progressVsNilai = $durasiVsNilai;

        return view('guru.dashboard', [
            'durasiVsNilai' => $durasiVsNilai,
            'progressVsNilai' => $progressVsNilai,
        ]);
    }
}