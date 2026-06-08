<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Nilai;

class CheckMateriOrder
{
    public function handle(Request $request, Closure $next): Response
    {
        $current = trim($request->path(), '/');
        $userId = auth()->id();

        $kkmGelombang = \App\Models\Quiz::find(1)->kkm ?? 70;
        $kkmBunyi = \App\Models\Quiz::find(2)->kkm ?? 70;
        $kkmCahaya = \App\Models\Quiz::find(3)->kkm ?? 70;

        $lulusGelombang = Nilai::where('user_id', $userId)
            ->where('quiz_id', 1)
            ->where('score', '>=', $kkmGelombang)
            ->exists();

        $lulusBunyi = Nilai::where('user_id', $userId)
            ->where('quiz_id', 2)
            ->where('score', '>=', $kkmBunyi)
            ->exists();

        $lulusCahaya = Nilai::where('user_id', $userId)
            ->where('quiz_id', 3)
            ->where('score', '>=', $kkmCahaya)
            ->exists();


        $urutan = [
            'pengantar_gelombang',
            'definisi_gelombang',
            'jenis_gelombang',
            'beda_fase_gelombang',
            'prinsip_gelombang',
            'kuis_gelombang',
            'pengantar_bunyi',
            'konsep_perambatan_bunyi',
            'sumber_kar_bunyi',
            'fenomena_apk_bunyi',
            'kuis_bunyi',
            'pengantar_cahaya',
            'sifat_cahaya',
            'spektrum_cahaya',
            'fenomena_apk_cahaya',
            'kuis_cahaya',
            'evaluasi',
        ];

        $index = array_search($current, $urutan);

        if ($index === false) {
            return $next($request);
        }

        // ================== PROGRESS ==================
        $progressIndex = 5;

        if ($lulusGelombang) {
            $progressIndex = 10;
        }

        if ($lulusBunyi) {
            $progressIndex = 15;
        }

        if ($lulusCahaya) {
            $progressIndex = 16;
        }

        // ================== BLOCK ==================
        if ($index > $progressIndex) {
            return redirect('/' . $urutan[$progressIndex])
                ->with('error', 'Selesaikan materi sebelumnya dulu!');
        }

        return $next($request);
    }

}