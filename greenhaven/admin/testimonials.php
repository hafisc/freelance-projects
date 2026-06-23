<?php
// Tentukan judul halaman admin
$admin_title = "Manajemen Testimoni - GreenHaven";

// Load header & session check
require_once 'includes/header.php';

$alert_message = '';
$alert_type = '';

// ==========================================
// 1. PROSES ACTIONS (TAMBAH / EDIT / HAPUS / TOGGLE STATUS)
// ==========================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // ACTION: TAMBAH TESTIMONI BARU
    if (isset($_POST['add_testimonial'])) {
        $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS));
        $role = trim(filter_input(INPUT_POST, 'role', FILTER_SANITIZE_SPECIAL_CHARS));
        $review = trim(filter_input(INPUT_POST, 'review', FILTER_SANITIZE_SPECIAL_CHARS));
        $rating = (int)$_POST['rating'];
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        
        if (!empty($name) && !empty($review)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO testimonials (name, role, review, rating, is_active) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$name, $role, $review, $rating, $is_active]);
                $alert_message = "Testimoni dari '{$name}' berhasil ditambahkan.";
                $alert_type = "success";
            } catch (PDOException $e) {
                $alert_message = "Gagal menambahkan testimoni: " . $e->getMessage();
                $alert_type = "danger";
            }
        } else {
            $alert_message = "Nama dan isi ulasan tidak boleh kosong.";
            $alert_type = "danger";
        }
    }
    
    // ACTION: EDIT TESTIMONI (UPDATE)
    if (isset($_POST['edit_testimonial'])) {
        $test_id = (int)$_POST['testimonial_id'];
        $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS));
        $role = trim(filter_input(INPUT_POST, 'role', FILTER_SANITIZE_SPECIAL_CHARS));
        $review = trim(filter_input(INPUT_POST, 'review', FILTER_SANITIZE_SPECIAL_CHARS));
        $rating = (int)$_POST['rating'];
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        
        if ($test_id > 0 && !empty($name) && !empty($review)) {
            try {
                $stmt = $pdo->prepare("UPDATE testimonials SET name = ?, role = ?, review = ?, rating = ?, is_active = ? WHERE id = ?");
                $stmt->execute([$name, $role, $review, $rating, $is_active, $test_id]);
                $alert_message = "Testimoni '{$name}' berhasil diperbarui.";
                $alert_type = "success";
                
                header("Refresh: 1.5; URL=testimonials.php");
            } catch (PDOException $e) {
                $alert_message = "Gagal memperbarui testimoni: " . $e->getMessage();
                $alert_type = "danger";
            }
        } else {
            $alert_message = "Input data ulasan tidak valid.";
            $alert_type = "danger";
        }
    }
}

// ACTION: HAPUS TESTIMONI
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $delete_id = (int)$_GET['id'];
    if ($delete_id > 0) {
        try {
            $stmt = $pdo->prepare("DELETE FROM testimonials WHERE id = ?");
            $stmt->execute([$delete_id]);
            $alert_message = "Ulasan berhasil dihapus.";
            $alert_type = "success";
            
            header("Refresh: 1; URL=testimonials.php");
        } catch (PDOException $e) {
            $alert_message = "Gagal menghapus ulasan: " . $e->getMessage();
            $alert_type = "danger";
        }
    }
}

// ACTION: TOGGLE AKTIF / NON-AKTIF STATUS
if (isset($_GET['action']) && $_GET['action'] === 'toggle' && isset($_GET['id'])) {
    $toggle_id = (int)$_GET['id'];
    if ($toggle_id > 0) {
        try {
            // Ubah status kebalikannya (1 menjadi 0, atau 0 menjadi 1)
            $stmt = $pdo->prepare("UPDATE testimonials SET is_active = NOT is_active WHERE id = ?");
            $stmt->execute([$toggle_id]);
            $alert_message = "Status penampilan ulasan berhasil diubah.";
            $alert_type = "success";
            
            header("Refresh: 1; URL=testimonials.php");
        } catch (PDOException $e) {
            $alert_message = "Gagal mengubah status ulasan: " . $e->getMessage();
            $alert_type = "danger";
        }
    }
}

// ==========================================
// 2. CHECK STATUS EDIT
// ==========================================
$edit_mode = false;
$edit_data = null;
if (isset($_GET['edit_id'])) {
    $edit_id = (int)$_GET['edit_id'];
    if ($edit_id > 0) {
        $stmt = $pdo->prepare("SELECT * FROM testimonials WHERE id = ?");
        $stmt->execute([$edit_id]);
        $edit_data = $stmt->fetch();
        if ($edit_data) {
            $edit_mode = true;
        }
    }
}

// ==========================================
// 3. LOAD DATA SEMUA TESTIMONI
// ==========================================
$all_testimonials = $pdo->query("SELECT * FROM testimonials ORDER BY id DESC")->fetchAll();

require_once 'includes/sidebar.php';
?>

<!-- Alert Notifikasi -->
<?php if (!empty($alert_message)): ?>
    <div class="admin-alert alert-<?= $alert_type ?>">
        <i class="fa-solid <?= $alert_type === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation' ?>"></i> 
        <?= htmlspecialchars($alert_message) ?>
    </div>
<?php endif; ?>

<div class="form-panel-grid">
    <!-- PANEL FORM (Tambah / Edit Testimoni - Kiri) -->
    <div class="table-card" style="height: fit-content;">
        <h3 class="table-title" style="margin-bottom: 20px;">
            <?= $edit_mode ? '<i class="fa-solid fa-pen-to-square"></i> Edit Ulasan' : '<i class="fa-solid fa-plus"></i> Tambah Ulasan Baru' ?>
        </h3>
        
        <form action="testimonials.php" method="POST" class="admin-form">
            <?php if ($edit_mode): ?>
                <input type="hidden" name="testimonial_id" value="<?= $edit_data['id'] ?>">
            <?php endif; ?>
            
            <div class="admin-input-group">
                <label for="name" class="admin-label">Nama Pelanggan</label>
                <input type="text" name="name" id="name" class="admin-control" placeholder="Contoh: Citra Lestari" value="<?= $edit_mode ? htmlspecialchars($edit_data['name']) : '' ?>" required>
            </div>

            <div class="admin-input-group">
                <label for="role" class="admin-label">Pekerjaan / Label Profil</label>
                <input type="text" name="role" id="role" class="admin-control" placeholder="Contoh: Ibu Rumah Tangga, Arsitek" value="<?= $edit_mode ? htmlspecialchars($edit_data['role']) : '' ?>">
            </div>

            <div class="admin-input-group">
                <label for="rating" class="admin-label">Rating Penilaian</label>
                <select name="rating" id="rating" class="admin-control" required>
                    <option value="5" <?= ($edit_mode && $edit_data['rating'] == 5) ? 'selected' : '' ?>>⭐⭐⭐⭐⭐ (5 Bintang)</option>
                    <option value="4" <?= ($edit_mode && $edit_data['rating'] == 4) ? 'selected' : '' ?>>⭐⭐⭐⭐ (4 Bintang)</option>
                    <option value="3" <?= ($edit_mode && $edit_data['rating'] == 3) ? 'selected' : '' ?>>⭐⭐⭐ (3 Bintang)</option>
                    <option value="2" <?= ($edit_mode && $edit_data['rating'] == 2) ? 'selected' : '' ?>>⭐⭐ (2 Bintang)</option>
                    <option value="1" <?= ($edit_mode && $edit_data['rating'] == 1) ? 'selected' : '' ?>>⭐ (1 Bintang)</option>
                </select>
            </div>

            <div class="admin-input-group">
                <label for="review" class="admin-label">Isi Ulasan / Testimoni</label>
                <textarea name="review" id="review" class="admin-control" placeholder="Tulis testimoni pelanggan di sini..." required><?= $edit_mode ? htmlspecialchars($edit_data['review']) : '' ?></textarea>
            </div>

            <div class="admin-input-group" style="flex-direction: row; align-items: center; gap: 8px;">
                <input type="checkbox" name="is_active" id="is_active" value="1" <?= (!$edit_mode || $edit_data['is_active'] == 1) ? 'checked' : '' ?> style="width: 18px; height: 18px; cursor: pointer;">
                <label for="is_active" class="admin-label" style="cursor: pointer; margin-bottom: 0; user-select: none;">Tampilkan Ulasan di Website Utama</label>
            </div>

            <div style="display: flex; gap: 8px; margin-top: 12px;">
                <?php if ($edit_mode): ?>
                    <button type="submit" name="edit_testimonial" class="btn-admin btn-admin-success">
                        Simpan Perubahan <i class="fa-solid fa-check"></i>
                    </button>
                    <a href="testimonials.php" class="btn-admin btn-admin-outline">Batal</a>
                <?php else: ?>
                    <button type="submit" name="add_testimonial" class="btn-admin btn-admin-primary">
                        Tambah Testimoni <i class="fa-solid fa-plus"></i>
                    </button>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- PANEL DAFTAR TESTIMONI (Tabel - Kanan) -->
    <div class="table-card">
        <h3 class="table-title" style="margin-bottom: 20px;"><i class="fa-solid fa-comments"></i> Daftar Ulasan Pelanggan</h3>
        
        <div class="table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>Nama & Pekerjaan</th>
                        <th>Ulasan</th>
                        <th style="width: 100px;">Rating</th>
                        <th style="width: 100px; text-align: center;">Tampilkan</th>
                        <th style="width: 120px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($all_testimonials) > 0): ?>
                        <?php $no = 1; foreach ($all_testimonials as $t): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <strong style="color: var(--primary-color); display: block;"><?= htmlspecialchars($t['name']) ?></strong>
                                    <small style="color: var(--text-muted);"><?= htmlspecialchars($t['role'] ?? 'Pelanggan') ?></small>
                                </td>
                                <td style="font-size: 0.85rem; line-height: 1.4; max-width: 200px;">
                                    "<?= htmlspecialchars($t['review']) ?>"
                                </td>
                                <td>
                                    <span style="color: var(--warning-color); font-weight: 700;">
                                        <?= str_repeat('★', $t['rating']) ?>
                                    </span>
                                </td>
                                <td align="center">
                                    <!-- Toggle Tampilan status dengan klik -->
                                    <a href="testimonials.php?action=toggle&id=<?= $t['id'] ?>" title="Klik untuk mengubah status tampil">
                                        <?php if ($t['is_active'] == 1): ?>
                                            <span class="admin-badge badge-success" style="cursor: pointer;">Aktif</span>
                                        <?php else: ?>
                                            <span class="admin-badge badge-danger" style="cursor: pointer;">Muted</span>
                                        <?php endif; ?>
                                    </a>
                                </td>
                                <td align="center">
                                    <div class="action-buttons">
                                        <!-- Tombol Edit -->
                                        <a href="testimonials.php?edit_id=<?= $t['id'] ?>" class="btn-admin btn-admin-outline btn-admin-sm" title="Edit">
                                            <i class="fa-solid fa-pen" style="color: var(--primary-light);"></i>
                                        </a>
                                        <!-- Tombol Hapus -->
                                        <a href="testimonials.php?action=delete&id=<?= $t['id'] ?>" 
                                           class="btn-admin btn-admin-outline btn-admin-sm" 
                                           title="Hapus" 
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus ulasan dari \'<?= addslashes($t['name']) ?>\'?')">
                                            <i class="fa-solid fa-trash" style="color: var(--danger-color);"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center" style="color: var(--text-muted); padding: 24px 0;">
                                Belum ada ulasan testimoni yang masuk.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
// Load footer admin
require_once 'includes/footer.php';
?>
