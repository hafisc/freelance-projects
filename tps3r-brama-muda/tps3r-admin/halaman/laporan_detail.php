<?php
/**
 * ============================================================
 * HALAMAN/LAPORAN_DETAIL.PHP - Pemeriksaan & Verifikasi Laporan
 * ============================================================
 */
session_start();
require_once '../config/api.php';

// Proteksi Halaman
if (!isset($_SESSION['auth_token'])) {
    header("Location: login.php");
    exit();
}

// Ambil ID dari parameter URL
$report_id = $_GET['id'] ?? null;
if (!$report_id) {
    header("Location: laporan.php");
    exit();
}

$alert_msg = '';
$alert_type = '';

// Proses eksekusi tombol Terima / Tolak
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_status'])) {
    $new_status = $_POST['action_status']; // Berisi 'verified' atau 'rejected'
    
    // Tembak endpoint /reports/{id}/verify menggunakan method PUT
    $verify_response = callAPI('PUT', "/reports/{$report_id}/verify", [
        'status' => $new_status
    ]);

    if (isset($verify_response['success']) && $verify_response['success'] === true) {
        $alert_type = 'success';
        $alert_msg = $verify_response['message'] ?? 'Status berhasil diperbarui.';
    } else {
        $alert_type = 'danger';
        $alert_msg = $verify_response['message'] ?? 'Gagal memproses verifikasi.';
    }
}

// Ambil ulang semua data laporan untuk mencari detail laporan saat ini
// (Karena API saat ini belum punya endpoint khusus get single report untuk Admin)
$response = callAPI('GET', '/reports');
$detail_laporan = null;

if (isset($response['success']) && $response['success'] === true) {
    foreach ($response['data'] as $r) {
        if ($r['id'] == $report_id) {
            $detail_laporan = $r;
            break;
        }
    }
}

// Jika data laporan tidak ditemukan di server
if (!$detail_laporan) {
    echo "<script>alert('Data laporan tidak ditemukan!'); window.location.href='laporan.php';</script>";
    exit();
}

// Pengaturan URL Storage (Hapus '/api' dari base URL API untuk mengakses folder storage/app/public)
$storage_base_url = str_replace('/api', '', API_BASE_URL) . '/storage/';

$page_title = 'Detail Verifikasi Laporan';
require_once 'header.php';
?>

<div style="margin-bottom: 24px;">
    <a href="laporan.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Laporan
    </a>
</div>

<?php if (!empty($alert_msg)): ?>
    <div class="alert alert-<?php echo $alert_type; ?>">
        <i class="fas <?php echo $alert_type == 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i>
        <span><?php echo htmlspecialchars($alert_msg); ?></span>
    </div>
<?php endif; ?>

<div class="main-card">
    <div class="card-header">
        <h3>Informasi Berkas Laporan #<?php echo $detail_laporan['id']; ?></h3>
        <span class="badge badge-<?php echo strtolower($detail_laporan['status']); ?>">
            Status Saat Ini: <?php echo strtoupper($detail_laporan['status']); ?>
        </span>
    </div>

    <div style="padding: 24px; display: flex; flex-wrap: wrap; gap: 32px;">
        
        <div style="flex: 1; min-width: 300px;">
            <p style="font-size: 13px; font-weight: 600; color: var(--text-muted); margin-bottom: 12px; text-transform: uppercase;">Bukti Foto Sampah</p>
            <?php if (!empty($detail_laporan['photo_path'])): ?>
                <img src="<?php echo $storage_base_url . $detail_laporan['photo_path']; ?>" alt="Foto Sampah Warga" class="report-img-preview" onerror="this.src='https://via.placeholder.com/400x300?text=Gambar+Gagal+Dimuat'">
            <?php else: ?>
                <div class="report-img-preview" style="display: flex; align-items: center; justify-content: center; background: #F3F4F6;">
                    <span style="color: #9CA3AF;">Tidak ada lampiran foto</span>
                </div>
            <?php endif; ?>
        </div>

        <div style="flex: 1; min-width: 300px;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 12px 0; color: var(--text-muted); width: 140px;">Nama Pelapor</td>
                    <td style="padding: 12px 0; font-weight: 600; color: var(--text-dark);">
                        <?php echo htmlspecialchars($detail_laporan['user']['name'] ?? 'Warga Tidak Diketahui'); ?>
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 12px 0; color: var(--text-muted);">Kategori Sampah</td>
                    <td style="padding: 12px 0; font-weight: 600; color: var(--primary-dark);">
                        <?php echo htmlspecialchars($detail_laporan['category']); ?>
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 12px 0; color: var(--text-muted);">Lokasi Jemput/Setor</td>
                    <td style="padding: 12px 0; font-weight: 500; color: var(--text-body);">
                        <?php echo htmlspecialchars($detail_laporan['location']); ?>
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 12px 0; color: var(--text-muted);">Waktu Pengajuan</td>
                    <td style="padding: 12px 0; font-weight: 500; color: var(--text-body);">
                        <?php echo date('d F Y, H:i', strtotime($detail_laporan['created_at'])); ?> WIB
                    </td>
                </tr>
                <tr>
                    <td style="padding: 12px 0; color: var(--text-muted); vertical-align: top;">Deskripsi / Catatan</td>
                    <td style="padding: 12px 0; font-weight: 500; color: var(--text-body);">
                        <?php echo nl2br(htmlspecialchars($detail_laporan['description'] ?? '-')); ?>
                    </td>
                </tr>
            </table>

            <?php if (strtolower($detail_laporan['status']) === 'pending'): ?>
                <div style="margin-top: 32px; padding: 20px; background-color: #F9FAFB; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
                    <p style="font-size: 14px; font-weight: 600; margin-bottom: 16px;">Tindakan Verifikasi</p>
                    <div style="display: flex; gap: 12px;">
                        
                        <form action="laporan_detail.php?id=<?php echo $report_id; ?>" method="POST" style="flex: 1;">
                            <input type="hidden" name="action_status" value="rejected">
                            <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Tolak laporan warga ini?');">
                                <i class="fas fa-times"></i> Tolak Data
                            </button>
                        </form>

                        <form action="laporan_detail.php?id=<?php echo $report_id; ?>" method="POST" style="flex: 1;">
                            <input type="hidden" name="action_status" value="verified">
                            <button type="submit" class="btn btn-primary btn-block" onclick="return confirm('Terima dan verifikasi laporan sampah ini?');">
                                <i class="fas fa-check"></i> Verifikasi
                            </button>
                        </form>
                        
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>