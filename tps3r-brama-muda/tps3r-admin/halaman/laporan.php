<?php
/**
 * ============================================================
 * HALAMAN/LAPORAN.PHP - Manajemen Tabel Laporan Masuk Warga
 * ============================================================
 */
session_start();

// Wajib panggil file konfigurasi API
require_once '../config/api.php';

// Proteksi halaman
if (!isset($_SESSION['auth_token'])) {
    header("Location: login.php");
    exit();
}

$page_title = 'Laporan Warga';
require_once 'header.php';

// Tarik data laporan keseluruhan melalui API Laravel
$response = callAPI('GET', '/reports');
$reports = [];
$error_msg = '';

if (isset($response['success']) && $response['success'] === true) {
    $reports = $response['data'] ?? [];
} else {
    $error_msg = $response['message'] ?? 'Gagal mengambil sinkronisasi data laporan dari server API.';
}
?>

<?php if (!empty($error_msg)): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i>
        <span><?php echo htmlspecialchars($error_msg); ?></span>
    </div>
<?php endif; ?>

<div class="main-card">
    <div class="card-header">
        <h3>Riwayat Masuk Laporan Sampah</h3>
        <span style="color: var(--text-muted); font-size: 13px;">Total Data: <strong><?php echo count($reports); ?></strong> Baris</span>
    </div>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 60px;">No</th>
                    <th>Nama Pelapor</th>
                    <th>Kategori Sampah</th>
                    <th>Lokasi Penyetoran</th>
                    <th>Waktu Masuk</th>
                    <th>Status Validasi</th>
                    <th style="text-align: center; width: 180px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($reports)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 40px;">
                            <i class="fas fa-folder-open" style="font-size: 24px; display: block; margin-bottom: 8px; color: #D1D5DB;"></i>
                            Belum ada berkas laporan masuk dari aplikasi mobile saat ini.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php 
                    $no = 1;
                    foreach ($reports as $report): 
                        // Konversi timestamp buatan laravel ke format lokal
                        $waktu_lokal = date('d M Y - H:i', strtotime($report['created_at']));
                        $status_laporan = strtolower($report['status'] ?? 'pending');
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td>
                                <strong><?php echo htmlspecialchars($report['user']['name'] ?? 'Warga TPS 3R'); ?></strong>
                            </td>
                            <td>
                                <span style="font-weight: 500; color: var(--text-dark);">
                                    <?php echo htmlspecialchars($report['category'] ?? '-'); ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($report['location'] ?? '-'); ?></td>
                            <td><?php echo $waktu_lokal; ?> WIB</td>
                            <td>
                                <span class="badge badge-<?php echo $status_laporan; ?>">
                                    <?php 
                                        if ($status_laporan === 'pending') echo 'Menunggu';
                                        elseif ($status_laporan === 'verified') echo 'Terverifikasi';
                                        elseif ($status_laporan === 'rejected') echo 'Ditolak';
                                        else echo htmlspecialchars($status_laporan);
                                    ?>
                                </span>
                            </td>
                            <td style="text-align: center;">
                                <a href="laporan_detail.php?id=<?php echo $report['id']; ?>" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-search"></i> Periksa Berkas
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
require_once 'footer.php';
?>