@extends('layouts.app')

@section('content')

    @php
        $userId = auth()->id();

        $kkmGelombang = \App\Models\Quiz::find(1)->kkm ?? 70;
        $kkmBunyi = \App\Models\Quiz::find(2)->kkm ?? 70;
        $kkmCahaya = \App\Models\Quiz::find(3)->kkm ?? 70;

        $lulusGelombang = \App\Models\Nilai::where('user_id', $userId)
            ->where('quiz_id', 1)
            ->where('score', '>=', $kkmGelombang)
            ->exists();

        $lulusBunyi = \App\Models\Nilai::where('user_id', $userId)
            ->where('quiz_id', 2)
            ->where('score', '>=', $kkmBunyi)
            ->exists();


        $lulusCahaya = \App\Models\Nilai::where('user_id', $userId)
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

        function menuLink($route, $label, $urutan, $progressIndex)
        {
            $i = array_search($route, $urutan);
            $locked = $i > $progressIndex;

            $url = $locked ? '#' : url($route);
            $active = request()->is($route) ? 'active-link' : '';
            $lockedClass = $locked ? 'locked' : '';

            $icon = $locked ? ' 🔒' : '';

            $onclick = $locked ? 'onclick="return false;"' : '';

            return "<a href='{$url}' class='{$active} {$lockedClass}' {$onclick} title='" . ($locked ? "Selesaikan materi sebelumnya dulu" : "") . "'>{$label}{$icon}</a>";
        }
    @endphp

    <div class="layout-wrapper">

        {{-- SIDEBAR --}}
        <aside class="sidebar">


            <div class="menu">

                {{-- GELOMBANG --}}
                <div class="menu-section">

                    <div class="menu-item has-toggle" data-target="sub-gelombang">
                        Gelombang
                        <span class="arrow">▼</span>
                    </div>

                    <div class="submenu" id="sub-gelombang">

                        {!! menuLink('pengantar_gelombang', 'Pengantar', $urutan, $progressIndex) !!}
                        {!! menuLink('definisi_gelombang', 'Definisi', $urutan, $progressIndex) !!}
                        {!! menuLink('jenis_gelombang', 'Jenis Gelombang', $urutan, $progressIndex) !!}
                        {!! menuLink('beda_fase_gelombang', 'Beda Fase', $urutan, $progressIndex) !!}
                        {!! menuLink('prinsip_gelombang', 'Prinsip Gelombang', $urutan, $progressIndex) !!}
                        {!! menuLink('kuis_gelombang', 'Kuis 1', $urutan, $progressIndex) !!}

                    </div>
                </div>

                {{-- BUNYI --}}
                <div class="menu-section">

                    <div class="menu-item has-toggle" data-target="sub-bunyi">
                        Gelombang Bunyi
                        <span class="arrow">▼</span>
                    </div>

                    <div class="submenu" id="sub-bunyi">

                        {!! menuLink('pengantar_bunyi', 'Pengantar', $urutan, $progressIndex) !!}
                        {!! menuLink('konsep_perambatan_bunyi', 'Konsep Dasar', $urutan, $progressIndex) !!}
                        {!! menuLink('sumber_kar_bunyi', 'Sumber & Karakteristik', $urutan, $progressIndex) !!}
                        {!! menuLink('fenomena_apk_bunyi', 'Fenomena & Aplikasi', $urutan, $progressIndex) !!}
                        {!! menuLink('kuis_bunyi', 'Kuis 2', $urutan, $progressIndex) !!}

                    </div>
                </div>

                {{-- CAHAYA --}}
                <div class="menu-section">

                    <div class="menu-item has-toggle" data-target="sub-cahaya">
                        Gelombang Cahaya
                        <span class="arrow">▼</span>
                    </div>

                    <div class="submenu" id="sub-cahaya">

                        {!! menuLink('pengantar_cahaya', 'Pengantar', $urutan, $progressIndex) !!}
                        {!! menuLink('sifat_cahaya', 'Sifat Cahaya', $urutan, $progressIndex) !!}
                        {!! menuLink('spektrum_cahaya', 'Spektrum Cahaya', $urutan, $progressIndex) !!}
                        {!! menuLink('fenomena_apk_cahaya', 'Fenomena & Aplikasi', $urutan, $progressIndex) !!}
                        {!! menuLink('kuis_cahaya', 'Kuis 3', $urutan, $progressIndex) !!}

                    </div>
                </div>

                {{-- EVALUASI --}}
                <div class="menu-section">
                    <div class="menu-item">
                        {!! menuLink('evaluasi', 'Evaluasi Akhir', $urutan, $progressIndex) !!}
                    </div>
                </div>

            </div>
        </aside>

        {{-- CONTENT --}}
        <main class="main-content">
            @yield('siswa-content')
        </main>

    </div>

@endsection