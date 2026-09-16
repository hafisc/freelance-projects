@extends('admin.layouts.admin')

@section('title', 'Sistem yang Berjalan & Usulan Perbaikan')

@section('content')
<!-- Header -->
<div class="mb-8">
    <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Sistem yang Berjalan & Usulan Perbaikan</h2>
    <p class="text-sm text-slate-500">Dokumentasi alur sistem aplikasi Gloria Job dan rekomendasi pengembangan ke depan.</p>
</div>

<!-- ═══════════════════════════════════════════════ -->
<!-- BAGIAN A: SISTEM YANG BERJALAN                 -->
<!-- ═══════════════════════════════════════════════ -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 md:p-10 mb-8">
    <h3 class="text-xl font-extrabold text-slate-800 mb-6 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-blue-50 text-primaryBlue flex items-center justify-center"><i class="fa-solid fa-gears text-lg"></i></div>
        A. Sistem yang Berjalan (Running System)
    </h3>

    <!-- 1. Overview Sistem -->
    <div class="mb-8">
        <h4 class="text-sm font-bold text-slate-700 uppercase tracking-wider mb-3 flex items-center gap-2"><i class="fa-solid fa-circle-info text-primaryBlue"></i> 1. Overview Sistem</h4>
        <div class="bg-slate-50 rounded-2xl p-5 text-sm text-slate-600 leading-relaxed space-y-2">
            <p><strong>Gloria Job</strong> adalah sistem informasi lowongan kerja berbasis web dan mobile yang dikembangkan untuk PT. Gloria Jasa Mandiri. Sistem ini terdiri dari dua komponen utama:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li><strong>Admin Panel (Web)</strong> — Berbasis Laravel 13 + Blade + TailwindCSS, digunakan oleh admin untuk mengelola lowongan kerja, data perusahaan, lamaran masuk, dan menghasilkan laporan.</li>
                <li><strong>Mobile App (Android/iOS)</strong> — Berbasis Flutter (Dart), digunakan oleh pencari kerja untuk mencari lowongan, melamar pekerjaan, dan menerima notifikasi status lamaran.</li>
            </ul>
            <p>Backend menggunakan <strong>REST API</strong> dengan autentikasi <strong>Laravel Sanctum (Token-Based)</strong> untuk komunikasi antara mobile app dan server.</p>
        </div>
    </div>

    <!-- 2. Arsitektur Teknologi -->
    <div class="mb-8">
        <h4 class="text-sm font-bold text-slate-700 uppercase tracking-wider mb-3 flex items-center gap-2"><i class="fa-solid fa-layer-group text-primaryBlue"></i> 2. Arsitektur Teknologi</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100/50 rounded-2xl p-4 border border-blue-100">
                <div class="text-xs font-bold text-blue-400 uppercase mb-1">Frontend Mobile</div>
                <div class="text-sm font-bold text-slate-800">Flutter (Dart)</div>
                <div class="text-xs text-slate-500 mt-1">Feature-based architecture</div>
            </div>
            <div class="bg-gradient-to-br from-red-50 to-red-100/50 rounded-2xl p-4 border border-red-100">
                <div class="text-xs font-bold text-red-400 uppercase mb-1">Backend</div>
                <div class="text-sm font-bold text-slate-800">Laravel 13 (PHP 8.3)</div>
                <div class="text-xs text-slate-500 mt-1">MVC + Sanctum Auth</div>
            </div>
            <div class="bg-gradient-to-br from-amber-50 to-amber-100/50 rounded-2xl p-4 border border-amber-100">
                <div class="text-xs font-bold text-amber-400 uppercase mb-1">Database</div>
                <div class="text-sm font-bold text-slate-800">SQLite / MySQL</div>
                <div class="text-xs text-slate-500 mt-1">Eloquent ORM</div>
            </div>
            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100/50 rounded-2xl p-4 border border-emerald-100">
                <div class="text-xs font-bold text-emerald-400 uppercase mb-1">Admin Panel</div>
                <div class="text-sm font-bold text-slate-800">Blade + TailwindCSS</div>
                <div class="text-xs text-slate-500 mt-1">Alpine.js + Chart.js</div>
            </div>
        </div>
    </div>

    <!-- 3. Flowchart Alur Sistem -->
    <div class="mb-8">
        <h4 class="text-sm font-bold text-slate-700 uppercase tracking-wider mb-3 flex items-center gap-2"><i class="fa-solid fa-diagram-project text-primaryBlue"></i> 3. Alur Sistem (Flowchart)</h4>
        <div class="bg-slate-50 rounded-2xl p-6 overflow-x-auto">
            <div class="min-w-[700px]">
                <!-- Flow Steps -->
                <div class="flex items-center gap-3 flex-wrap">
                    <!-- Step 1 -->
                    <div class="bg-blue-500 text-white rounded-xl px-4 py-3 text-xs font-bold text-center shadow-sm min-w-[120px]">
                        <i class="fa-solid fa-user-plus block text-lg mb-1"></i>Registrasi User
                    </div>
                    <i class="fa-solid fa-arrow-right text-slate-300"></i>
                    <!-- Step 2 -->
                    <div class="bg-blue-500 text-white rounded-xl px-4 py-3 text-xs font-bold text-center shadow-sm min-w-[120px]">
                        <i class="fa-solid fa-right-to-bracket block text-lg mb-1"></i>Login
                    </div>
                    <i class="fa-solid fa-arrow-right text-slate-300"></i>
                    <!-- Step 3 -->
                    <div class="bg-cyan-500 text-white rounded-xl px-4 py-3 text-xs font-bold text-center shadow-sm min-w-[120px]">
                        <i class="fa-solid fa-file-arrow-up block text-lg mb-1"></i>Upload CV & Profil
                    </div>
                    <i class="fa-solid fa-arrow-right text-slate-300"></i>
                    <!-- Step 4 -->
                    <div class="bg-indigo-500 text-white rounded-xl px-4 py-3 text-xs font-bold text-center shadow-sm min-w-[120px]">
                        <i class="fa-solid fa-magnifying-glass block text-lg mb-1"></i>Cari & Filter Lowongan
                    </div>
                    <i class="fa-solid fa-arrow-right text-slate-300"></i>
                    <!-- Step 5 -->
                    <div class="bg-emerald-500 text-white rounded-xl px-4 py-3 text-xs font-bold text-center shadow-sm min-w-[120px]">
                        <i class="fa-solid fa-paper-plane block text-lg mb-1"></i>Kirim Lamaran + CV
                    </div>
                    <i class="fa-solid fa-arrow-right text-slate-300"></i>
                    <!-- Step 6 -->
                    <div class="bg-amber-500 text-white rounded-xl px-4 py-3 text-xs font-bold text-center shadow-sm min-w-[120px]">
                        <i class="fa-solid fa-clipboard-check block text-lg mb-1"></i>Admin Review
                    </div>
                    <i class="fa-solid fa-arrow-right text-slate-300"></i>
                    <!-- Step 7 -->
                    <div class="bg-purple-500 text-white rounded-xl px-4 py-3 text-xs font-bold text-center shadow-sm min-w-[120px]">
                        <i class="fa-solid fa-bell block text-lg mb-1"></i>Notifikasi Status
                    </div>
                </div>

                <!-- Admin Flow -->
                <div class="mt-6 pt-6 border-t border-slate-200">
                    <div class="text-xs font-bold text-slate-400 uppercase mb-3">Alur Admin Panel:</div>
                    <div class="flex items-center gap-3 flex-wrap">
                        <div class="bg-primaryDark text-white rounded-xl px-4 py-3 text-xs font-bold text-center shadow-sm min-w-[130px]">
                            <i class="fa-solid fa-building block text-lg mb-1"></i>Kelola Perusahaan
                        </div>
                        <i class="fa-solid fa-arrow-right text-slate-300"></i>
                        <div class="bg-primaryDark text-white rounded-xl px-4 py-3 text-xs font-bold text-center shadow-sm min-w-[130px]">
                            <i class="fa-solid fa-briefcase block text-lg mb-1"></i>Buat Lowongan
                        </div>
                        <i class="fa-solid fa-arrow-right text-slate-300"></i>
                        <div class="bg-primaryDark text-white rounded-xl px-4 py-3 text-xs font-bold text-center shadow-sm min-w-[130px]">
                            <i class="fa-solid fa-envelope-open block text-lg mb-1"></i>Review Lamaran
                        </div>
                        <i class="fa-solid fa-arrow-right text-slate-300"></i>
                        <div class="bg-primaryDark text-white rounded-xl px-4 py-3 text-xs font-bold text-center shadow-sm min-w-[130px]">
                            <i class="fa-solid fa-share-nodes block text-lg mb-1"></i>Share ke Perusahaan
                        </div>
                        <i class="fa-solid fa-arrow-right text-slate-300"></i>
                        <div class="bg-primaryDark text-white rounded-xl px-4 py-3 text-xs font-bold text-center shadow-sm min-w-[130px]">
                            <i class="fa-solid fa-chart-pie block text-lg mb-1"></i>Laporan & Export
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. Fitur-fitur Sistem -->
    <div class="mb-4">
        <h4 class="text-sm font-bold text-slate-700 uppercase tracking-wider mb-3 flex items-center gap-2"><i class="fa-solid fa-list-check text-primaryBlue"></i> 4. Fitur-fitur yang Sudah Berjalan</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Mobile App Features -->
            <div class="bg-slate-50 rounded-2xl p-5">
                <h5 class="text-xs font-bold text-primaryBlue uppercase mb-3"><i class="fa-solid fa-mobile-screen-button mr-1"></i> Mobile App (Pencari Kerja)</h5>
                <ul class="space-y-2 text-sm text-slate-600">
                    <li class="flex items-start gap-2"><i class="fa-solid fa-check-circle text-emerald-500 mt-0.5"></i> Registrasi & login (token-based auth)</li>
                    <li class="flex items-start gap-2"><i class="fa-solid fa-check-circle text-emerald-500 mt-0.5"></i> Upload CV (PDF/DOC) dan kelola profil lengkap</li>
                    <li class="flex items-start gap-2"><i class="fa-solid fa-check-circle text-emerald-500 mt-0.5"></i> Pencarian lowongan kerja dengan filter (kategori, lokasi, gaji)</li>
                    <li class="flex items-start gap-2"><i class="fa-solid fa-check-circle text-emerald-500 mt-0.5"></i> Detail lowongan kerja lengkap dengan info perusahaan</li>
                    <li class="flex items-start gap-2"><i class="fa-solid fa-check-circle text-emerald-500 mt-0.5"></i> Pengiriman lamaran kerja + snapshot CV otomatis</li>
                    <li class="flex items-start gap-2"><i class="fa-solid fa-check-circle text-emerald-500 mt-0.5"></i> Riwayat lamaran dan status real-time</li>
                    <li class="flex items-start gap-2"><i class="fa-solid fa-check-circle text-emerald-500 mt-0.5"></i> Push notification untuk update status lamaran</li>
                    <li class="flex items-start gap-2"><i class="fa-solid fa-check-circle text-emerald-500 mt-0.5"></i> Profil perusahaan dan daftar lowongan aktif</li>
                </ul>
            </div>
            <!-- Admin Panel Features -->
            <div class="bg-slate-50 rounded-2xl p-5">
                <h5 class="text-xs font-bold text-primaryBlue uppercase mb-3"><i class="fa-solid fa-desktop mr-1"></i> Admin Panel (Web)</h5>
                <ul class="space-y-2 text-sm text-slate-600">
                    <li class="flex items-start gap-2"><i class="fa-solid fa-check-circle text-emerald-500 mt-0.5"></i> Dashboard statistik dengan grafik visual (Chart.js)</li>
                    <li class="flex items-start gap-2"><i class="fa-solid fa-check-circle text-emerald-500 mt-0.5"></i> CRUD data perusahaan lengkap (profil, PIC, logo)</li>
                    <li class="flex items-start gap-2"><i class="fa-solid fa-check-circle text-emerald-500 mt-0.5"></i> CRUD lowongan kerja + pilih perusahaan + set gaji</li>
                    <li class="flex items-start gap-2"><i class="fa-solid fa-check-circle text-emerald-500 mt-0.5"></i> Manajemen lamaran masuk dengan filter (perusahaan, kategori, status)</li>
                    <li class="flex items-start gap-2"><i class="fa-solid fa-check-circle text-emerald-500 mt-0.5"></i> Download/preview CV pelamar (snapshot saat melamar)</li>
                    <li class="flex items-start gap-2"><i class="fa-solid fa-check-circle text-emerald-500 mt-0.5"></i> Share data pelamar ke perusahaan (export per perusahaan)</li>
                    <li class="flex items-start gap-2"><i class="fa-solid fa-check-circle text-emerald-500 mt-0.5"></i> Laporan per perusahaan dan per kategori</li>
                    <li class="flex items-start gap-2"><i class="fa-solid fa-check-circle text-emerald-500 mt-0.5"></i> Export data pelamar ke Excel (.xlsx) terfilter</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════ -->
<!-- BAGIAN B: USULAN PERBAIKAN                     -->
<!-- ═══════════════════════════════════════════════ -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 md:p-10">
    <h3 class="text-xl font-extrabold text-slate-800 mb-6 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center"><i class="fa-solid fa-lightbulb text-lg"></i></div>
        B. Usulan Perbaikan (System Improvement Proposal)
    </h3>

    <!-- Kelemahan Saat Ini -->
    <div class="mb-8">
        <h4 class="text-sm font-bold text-slate-700 uppercase tracking-wider mb-3 flex items-center gap-2"><i class="fa-solid fa-triangle-exclamation text-amber-500"></i> 1. Identifikasi Kelemahan Sistem Saat Ini</h4>
        <div class="space-y-3">
            @php
                $weaknesses = [
                    ['title' => 'Belum Ada Notifikasi Email', 'desc' => 'Sistem hanya mengandalkan push notification in-app. Belum ada email notification untuk update status lamaran, pengingat deadline, atau konfirmasi pendaftaran.'],
                    ['title' => 'Tidak Ada Role Management', 'desc' => 'Hanya ada 2 jenis user (Admin & Pelamar). Belum ada role per perusahaan (HR/Recruiter) yang bisa login dan mereview pelamar mereka sendiri.'],
                    ['title' => 'Belum Ada Fitur Chat/Messaging', 'desc' => 'Tidak ada komunikasi langsung antara pelamar dan perusahaan/admin. Semua informasi hanya melalui catatan admin dan notifikasi satu arah.'],
                    ['title' => 'Pencarian Belum Optimal', 'desc' => 'Filter lowongan masih berbasis kategori tetap. Belum ada full-text search, filter gabungan (multi-criteria), atau rekomendasi lowongan berdasarkan profil.'],
                    ['title' => 'Tidak Ada Verifikasi Dokumen', 'desc' => 'Berkas CV yang diunggah tidak divalidasi isinya. Belum ada preview dokumen inline atau scan virus.'],
                ];
            @endphp
            @foreach($weaknesses as $w)
                <div class="flex items-start gap-3 bg-amber-50/50 border border-amber-100 rounded-2xl p-4">
                    <i class="fa-solid fa-circle-exclamation text-amber-400 mt-0.5"></i>
                    <div>
                        <div class="text-sm font-bold text-slate-800">{{ $w['title'] }}</div>
                        <div class="text-xs text-slate-500 mt-0.5">{{ $w['desc'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Rekomendasi Perbaikan -->
    <div class="mb-8">
        <h4 class="text-sm font-bold text-slate-700 uppercase tracking-wider mb-3 flex items-center gap-2"><i class="fa-solid fa-rocket text-emerald-500"></i> 2. Rekomendasi Pengembangan ke Depan</h4>
        <div class="space-y-3">
            @php
                $recommendations = [
                    ['title' => 'Implementasi Email Notification (SMTP)', 'priority' => 'Tinggi', 'color' => 'rose', 'desc' => 'Kirim email otomatis ke pelamar saat status berubah, konfirmasi pendaftaran, dan pengingat deadline lowongan. Juga kirim email ringkasan pelamar ke PIC perusahaan secara berkala.'],
                    ['title' => 'Portal Perusahaan (Multi-Role)', 'priority' => 'Tinggi', 'color' => 'rose', 'desc' => 'Berikan akses login ke setiap perusahaan (HR/Recruiter) agar bisa mereview pelamar, mengubah status lamaran, dan membuat lowongan sendiri tanpa melalui admin.'],
                    ['title' => 'Fitur Chat/Messaging Real-Time', 'priority' => 'Sedang', 'color' => 'amber', 'desc' => 'Tambahkan fitur chat antara pelamar dan perusahaan menggunakan WebSocket (Laravel Reverb/Pusher) untuk komunikasi langsung.'],
                    ['title' => 'Rekomendasi Lowongan (AI/ML)', 'priority' => 'Rendah', 'color' => 'blue', 'desc' => 'Implementasi algoritma matching antara profil/skill pelamar dengan persyaratan lowongan untuk memberikan rekomendasi yang lebih relevan.'],
                    ['title' => 'Penjadwalan Interview Online', 'priority' => 'Sedang', 'color' => 'amber', 'desc' => 'Fitur untuk menjadwalkan interview online dengan integrasi kalender dan link meeting (Google Meet/Zoom).'],
                    ['title' => 'Analytics Dashboard Lanjutan', 'priority' => 'Rendah', 'color' => 'blue', 'desc' => 'Dashboard analitik yang lebih mendalam: conversion rate per lowongan, waktu rata-rata review, tren skill yang dicari, dan prediksi kebutuhan tenaga kerja.'],
                    ['title' => 'Progressive Web App (PWA)', 'priority' => 'Rendah', 'color' => 'blue', 'desc' => 'Konversi web admin ke PWA agar bisa diakses offline dan diinstall sebagai aplikasi di desktop/mobile.'],
                ];
            @endphp
            @foreach($recommendations as $r)
                <div class="flex items-start gap-3 bg-{{ $r['color'] }}-50/30 border border-{{ $r['color'] }}-100 rounded-2xl p-4">
                    <i class="fa-solid fa-arrow-up-right-dots text-{{ $r['color'] }}-400 mt-0.5"></i>
                    <div class="flex-grow">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-slate-800">{{ $r['title'] }}</span>
                            <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold bg-{{ $r['color'] }}-100 text-{{ $r['color'] }}-600">{{ $r['priority'] }}</span>
                        </div>
                        <div class="text-xs text-slate-500 mt-0.5">{{ $r['desc'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Tabel Perbandingan -->
    <div>
        <h4 class="text-sm font-bold text-slate-700 uppercase tracking-wider mb-3 flex items-center gap-2"><i class="fa-solid fa-scale-balanced text-primaryBlue"></i> 3. Perbandingan Sistem Lama vs Sistem Baru</h4>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-slate-50">
                    <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        <th class="px-4 py-3">Aspek</th>
                        <th class="px-4 py-3">Sistem Lama</th>
                        <th class="px-4 py-3">Sistem Baru (Saat Ini)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <tr><td class="px-4 py-3 font-semibold">Pengiriman CV</td><td class="px-4 py-3 text-rose-500">CV hanya di profil, tidak ada snapshot</td><td class="px-4 py-3 text-emerald-600">CV otomatis disalin saat melamar (snapshot)</td></tr>
                    <tr><td class="px-4 py-3 font-semibold">Informasi Gaji</td><td class="px-4 py-3 text-rose-500">Tidak ada field gaji sama sekali</td><td class="px-4 py-3 text-emerald-600">Ada kategori gaji + filter di mobile app</td></tr>
                    <tr><td class="px-4 py-3 font-semibold">Data Perusahaan</td><td class="px-4 py-3 text-rose-500">Hanya string nama perusahaan</td><td class="px-4 py-3 text-emerald-600">Tabel companies lengkap (profil, PIC, logo)</td></tr>
                    <tr><td class="px-4 py-3 font-semibold">Share ke Perusahaan</td><td class="px-4 py-3 text-rose-500">Tidak ada mekanisme sharing</td><td class="px-4 py-3 text-emerald-600">Export data pelamar per perusahaan (Excel)</td></tr>
                    <tr><td class="px-4 py-3 font-semibold">Laporan</td><td class="px-4 py-3 text-rose-500">Hanya export global tanpa filter</td><td class="px-4 py-3 text-emerald-600">Laporan per perusahaan & kategori + chart</td></tr>
                    <tr><td class="px-4 py-3 font-semibold">Dokumentasi Sistem</td><td class="px-4 py-3 text-rose-500">Tidak ada</td><td class="px-4 py-3 text-emerald-600">Halaman sistem berjalan + usulan perbaikan</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
