<?php
// Tentukan judul halaman admin
$admin_title = "Pesan Masuk - GreenHaven";

// Load header & session check
require_once 'includes/header.php';

$alert_message = '';
$alert_type = '';

// ==========================================
// 1. PROSES ACTIONS (HAPUS PESAN)
// ==========================================
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $delete_id = (int)$_GET['id'];
    
    if ($delete_id > 0) {
        try {
            // Hapus pesan dari database
            $stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
            $stmt->execute([$delete_id]);
            
            $alert_message = "Pesan berhasil dihapus.";
            $alert_type = "success";
            header("Refresh: 1; URL=messages.php");
        } catch (PDOException $e) {
            $alert_message = "Gagal menghapus pesan: " . $e->getMessage();
            $alert_type = "danger";
        }
    }
}

// ==========================================
// 2. QUERY SEMUA PESAN MASUK
// ==========================================
$all_messages = $pdo->query("SELECT * FROM messages ORDER BY id DESC")->fetchAll();

require_once 'includes/sidebar.php';
?>

<!-- Alert Notifikasi -->
<?php if (!empty($alert_message)): ?>
    <div class="admin-alert alert-<?= $alert_type ?>">
        <i class="fa-solid <?= $alert_type === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation' ?>"></i> 
        <?= htmlspecialchars($alert_message) ?>
    </div>
<?php endif; ?>

<!-- PANEL DAFTAR PESAN MASUK -->
<div class="table-card">
    <div class="table-header">
        <h3 class="table-title"><i class="fa-solid fa-envelope-open-text"></i> Hubungi Kami - Kotak Masuk Pesan</h3>
    </div>
    
    <div class="table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 60px;">No</th>
                    <th style="width: 180px;">Pengirim</th>
                    <th style="width: 180px;">Email</th>
                    <th style="width: 180px;">Subjek / Topik</th>
                    <th>Isi Pesan</th>
                    <th style="width: 160px;">Tanggal Masuk</th>
                    <th style="width: 80px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($all_messages) > 0): ?>
                    <?php $no = 1; foreach ($all_messages as $msg): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td style="font-weight: 700; color: var(--primary-color);">
                                <?= htmlspecialchars($msg['name']) ?>
                            </td>
                            <td>
                                <a href="mailto:<?= htmlspecialchars($msg['email']) ?>" style="color: var(--primary-light); text-decoration: underline;">
                                    <?= htmlspecialchars($msg['email']) ?>
                                </a>
                            </td>
                            <td>
                                <span class="admin-badge badge-info"><?= htmlspecialchars($msg['subject']) ?></span>
                            </td>
                            <td style="white-space: normal; word-break: break-word; min-width: 250px; line-height: 1.5;">
                                <?= nl2br(htmlspecialchars($msg['message'])) ?>
                            </td>
                            <td><?= date('d M Y, H:i', strtotime($msg['created_at'])) ?> WIB</td>
                            <td align="center">
                                <!-- Tombol Hapus Pesan -->
                                <a href="messages.php?action=delete&id=<?= $msg['id'] ?>" 
                                   class="btn-admin btn-admin-outline btn-admin-sm" 
                                   title="Hapus Pesan" 
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus pesan dari \'<?= addslashes($msg['name']) ?>\'? Tindakan ini permanen.')">
                                    <i class="fa-solid fa-trash" style="color: var(--danger-color);"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center" style="color: var(--text-muted); padding: 48px 0;">
                            <i class="fa-solid fa-inbox" style="font-size: 3rem; color: var(--primary-light); margin-bottom: 16px; display: block;"></i>
                            Kotak masuk kosong. Belum ada pesan dari pengunjung website.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
// Load footer admin
require_once 'includes/footer.php';
?>
