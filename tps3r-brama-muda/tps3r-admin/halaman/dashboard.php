<?php

session_start();

// Wajib panggil file konfigurasi API
require_once '../config/api.php';

// Proteksi halaman: Jika belum login, tendang kembali ke login.php
if (!isset($_SESSION['auth_token'])) {
    header("Location: login.php");
    exit();
}

// Definisikan judul halaman sebelum memanggil komponen header
$page_title = 'Dashboard';
require_once 'header.php';

// Ambil data laporan dari API untuk menghitung statistik secara real-time
$response_report = callAPI('GET', '/reports');
$reports = [];
if (isset($response_report['success']) && $response_report['success'] === true) {
    $reports = $response_report['data'] ?? [];
}

// Logika perhitungan statistik dashboard berdasarkan data laporan
$total_laporan = count($reports);
$laporan_pending = 0;
$laporan_verified = 0;
$laporan_rejected = 0;

foreach ($reports as $r) {
    $status = strtolower($r['status'] ?? '');
    if ($status === 'pending') {
        $laporan_pending++;
    } elseif ($status === 'verified') {
        $laporan_verified++;
    } elseif ($status === 'rejected') {
        $laporan_rejected++;
    }
}

// Ambil data edukasi untuk menampilkan total artikel yang tersedia
$response_edu = callAPI('GET', '/educations', ['per_page' => 1]);
$total_edukasi = $response_edu['total'] ?? 0;
?>

<div class="stats-grid">
    <div class="stats-card">
        <div class="stats-info">
            <h3>Total Laporan</h3>
            <div class="stats-number"><?php echo $total_laporan; ?></div>
        </div>
        <div class="stats-icon info">
            <i class="fas fa-clipboard-list"></i>
        </div>
    </div>

    <div class="stats-card">
        <div class="stats-info">
            <h3>Menunggu Verifikasi</h3>
            <div class="stats-number" style="color: var(--warning-text);"><?php echo $laporan_pending; ?></div>
        </div>
        <div class="stats-icon warning">
            <i class="fas fa-clock"></i>
        </div>
    </div>

    <div class="stats-card">
        <div class="stats-info">
            <h3>Laporan Selesai</h3>
            <div class="stats-number" style="color: var(--success-text);"><?php echo $laporan_verified; ?></div>
        </div>
        <div class="stats-icon primary">
            <i class="fas fa-check-circle"></i>
        </div>
    </div>

    <div class="stats-card">
        <div class="stats-info">
            <h3>Total Edukasi</h3>
            <div class="stats-number"><?php echo $total_edukasi; ?></div>
        </div>
        <div class="stats-icon info" style="background-color: #E0F2FE; color: #0369A1;">
            <i class="fas fa-book"></i>
        </div>
    </div>
</div>

<div class="main-card" style="padding: 24px;">
    <h3 style="margin-bottom: 12px; color: var(--text-dark);">
        Selamat Datang Kembali, <?php echo htmlspecialchars($_SESSION['user_data']['name'] ?? 'Admin'); ?>!
    </h3>
    <p style="color: var(--text-muted); line-height: 1.6; font-size: 14px;">
        Melalui panel kontrol ini, Anda memegang hak penuh untuk mengelola modul edukasi pemilahan sampah serta memvalidasi laporan penyetoran sampah yang dikirimkan warga secara langsung dari aplikasi mobile <strong>WasteAnalytics</strong>.
    </p>
    
    <div style="margin-top: 24px; padding: 16px; background-color: var(--primary-light); border-radius: var(--radius-md); border-left: 4px solid var(--primary); display: flex; align-items: center; gap: 10px;">
        <i class="fas fa-lightbulb" style="color: var(--warning-text); font-size: 16px;"></i>
        <span style="color: var(--text-body); font-size: 14px;">
            Status Tindakan: Saat ini terdapat <strong><?php echo $laporan_pending; ?> laporan warga</strong> berstatus pending yang perlu Anda periksa di menu verifikasi laporan.
        </span>
    </div>
</div>

<?php
// Memanggil komponen footer penutup halaman
require_once 'footer.php';
?>