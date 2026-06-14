<?php

session_start();
require_once '../config/api.php';

// Proteksi Halaman
if (!isset($_SESSION['auth_token'])) {
    header("Location: login.php");
    exit();
}

$alert_msg = '';
$alert_type = '';

// Proses eksekusi Hapus Edukasi
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    // Tembak endpoint DELETE /educations/{id}
    $del_response = callAPI('DELETE', "/educations/{$delete_id}");
    
    if (isset($del_response['success']) && $del_response['success'] === true) {
        $alert_type = 'success';
        $alert_msg = 'Artikel edukasi berhasil dihapus dari sistem.';
    } else {
        $alert_type = 'danger';
        $alert_msg = $del_response['message'] ?? 'Gagal menghapus edukasi.';
    }
}

// Tarik data edukasi (Menggunakan pagination bawaan API, kita set per_page besar agar tampil semua)
$response = callAPI('GET', '/educations', ['per_page' => 100]);
$educations = [];

if (isset($response['success']) && $response['success'] === true) {
    $educations = $response['data'] ?? [];
} else {
    $alert_type = 'danger';
    $alert_msg = $response['message'] ?? 'Gagal memuat data edukasi dari server.';
}

$page_title = 'Modul Edukasi';
require_once 'header.php';
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <div>
        <p style="color: var(--text-muted); font-size: 14px;">Kelola konten artikel dan informasi daur ulang sampah.</p>
    </div>
    <a href="edukasi_tambah.php" class="btn btn-primary">
        <i class="fas fa-plus-circle"></i> Tambah Artikel Baru
    </a>
</div>

<?php if (!empty($alert_msg)): ?>
    <div class="alert alert-<?php echo $alert_type; ?>">
        <i class="fas <?php echo $alert_type == 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i>
        <span><?php echo htmlspecialchars($alert_msg); ?></span>
    </div>
<?php endif; ?>

<div class="main-card">
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th style="width: 80px;">Thumbnail</th>
                    <th>Judul Artikel</th>
                    <th>Penulis</th>
                    <th>Status</th>
                    <th>Tgl Dibuat</th>
                    <th style="text-align: center; width: 180px;">Aksi Admin</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($educations)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 40px;">
                            <i class="fas fa-newspaper" style="font-size: 24px; display: block; margin-bottom: 8px; color: #D1D5DB;"></i>
                            Data modul edukasi masih kosong. Silakan tambah artikel baru.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php 
                    $no = 1;
                    $storage_base_url = str_replace('/api', '', API_BASE_URL) . '/storage/';
                    foreach ($educations as $edu): 
                        $status_edu = strtolower($edu['status'] ?? 'draft');
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td>
                                <?php if (!empty($edu['thumbnail'])): ?>
                                    <img src="<?php echo $storage_base_url . $edu['thumbnail']; ?>" alt="Thumb" style="width: 60px; height: 45px; object-fit: cover; border-radius: 4px; border: 1px solid var(--border-color);" onerror="this.src='https://via.placeholder.com/60x45?text=No+Img'">
                                <?php else: ?>
                                    <div style="width: 60px; height: 45px; background: #e5e7eb; display: flex; align-items: center; justify-content: center; border-radius: 4px; border: 1px solid var(--border-color);">
                                        <i class="fas fa-image" style="color: #9CA3AF; font-size: 14px;"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong style="color: var(--text-dark);"><?php echo htmlspecialchars($edu['title']); ?></strong>
                            </td>
                            <td><?php echo htmlspecialchars($edu['author_name'] ?? 'Admin'); ?></td>
                            <td>
                                <span class="badge badge-<?php echo $status_edu; ?>">
                                    <?php echo ucfirst($status_edu); ?>
                                </span>
                            </td>
                            <td><?php echo date('d M Y', strtotime($edu['created_at'])); ?></td>
                            <td style="text-align: center;">
                                <div style="display: flex; gap: 8px; justify-content: center;">
                                    <a href="edukasi_edit.php?id=<?php echo $edu['id']; ?>" class="btn btn-secondary btn-sm" title="Edit Artikel">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="edukasi.php?delete_id=<?php echo $edu['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Peringatan: Apakah Anda yakin ingin menghapus artikel edukasi ini secara permanen?');" title="Hapus Artikel">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'footer.php'; ?>