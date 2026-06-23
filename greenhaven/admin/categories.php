<?php
// Tentukan judul halaman admin
$admin_title = "Manajemen Kategori - GreenHaven";

// Load header & session check
require_once 'includes/header.php';

$alert_message = '';
$alert_type = '';

// ==========================================
// 1. PROSES POST ACTIONS (TAMBAH / EDIT / HAPUS)
// ==========================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // ACTION: TAMBAH KATEGORI BARU
    if (isset($_POST['add_category'])) {
        $cat_name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS));
        
        if (!empty($cat_name)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
                $stmt->execute([$cat_name]);
                $alert_message = "Kategori '{$cat_name}' berhasil ditambahkan.";
                $alert_type = "success";
            } catch (PDOException $e) {
                $alert_message = "Gagal menambahkan kategori: " . $e->getMessage();
                $alert_type = "danger";
            }
        } else {
            $alert_message = "Nama kategori tidak boleh kosong.";
            $alert_type = "danger";
        }
    }
    
    // ACTION: EDIT KATEGORI (UPDATE)
    if (isset($_POST['edit_category'])) {
        $cat_id = (int)$_POST['category_id'];
        $cat_name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS));
        
        if ($cat_id > 0 && !empty($cat_name)) {
            try {
                $stmt = $pdo->prepare("UPDATE categories SET name = ? WHERE id = ?");
                $stmt->execute([$cat_name, $cat_id]);
                $alert_message = "Kategori berhasil diperbarui menjadi '{$cat_name}'.";
                $alert_type = "success";
                
                // Hapus query edit_id dari URL setelah berhasil edit
                header("Refresh: 2; URL=categories.php");
            } catch (PDOException $e) {
                $alert_message = "Gagal memperbarui kategori: " . $e->getMessage();
                $alert_type = "danger";
            }
        } else {
            $alert_message = "Input kategori tidak valid.";
            $alert_type = "danger";
        }
    }
}

// ACTION: HAPUS KATEGORI (GET REQUEST DENGAN KONFIRMASI)
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    if ($delete_id > 0) {
        try {
            // Hapus kategori (relasi produk diset NULL otomatis oleh ON DELETE SET NULL di MySQL)
            $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
            $stmt->execute([$delete_id]);
            $alert_message = "Kategori berhasil dihapus.";
            $alert_type = "success";
            
            header("Refresh: 1; URL=categories.php");
        } catch (PDOException $e) {
            $alert_message = "Gagal menghapus kategori: " . $e->getMessage();
            $alert_type = "danger";
        }
    }
}

// ==========================================
// 2. CHECK STATUS EDIT (AMBIL DATA KATEGORI YANG AKAN DI-EDIT)
// ==========================================
$edit_mode = false;
$edit_category = null;
if (isset($_GET['edit_id'])) {
    $edit_id = (int)$_GET['edit_id'];
    if ($edit_id > 0) {
        $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$edit_id]);
        $edit_category = $stmt->fetch();
        if ($edit_category) {
            $edit_mode = true;
        }
    }
}

// ==========================================
// 3. LOAD DATA SEMUA KATEGORI
// ==========================================
$all_categories = $pdo->query("SELECT * FROM categories ORDER BY id DESC")->fetchAll();

// Muat sidebar admin
require_once 'includes/sidebar.php';
?>

<!-- Menampilkan Alert Pemberitahuan jika Ada -->
<?php if (!empty($alert_message)): ?>
    <div class="admin-alert alert-<?= $alert_type ?>">
        <i class="fa-solid <?= $alert_type === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation' ?>"></i> 
        <?= htmlspecialchars($alert_message) ?>
    </div>
<?php endif; ?>

<div class="form-panel-grid">
    <!-- PANEL FORM (Tambah / Edit Kategori - Kiri) -->
    <div class="table-card">
        <h3 class="table-title" style="margin-bottom: 20px;">
            <?= $edit_mode ? '<i class="fa-solid fa-pen-to-square"></i> Edit Kategori' : '<i class="fa-solid fa-plus"></i> Tambah Kategori Baru' ?>
        </h3>
        
        <form action="categories.php" method="POST" class="admin-form">
            <?php if ($edit_mode): ?>
                <!-- Input tersembunyi untuk menyimpan ID saat mode edit -->
                <input type="hidden" name="category_id" value="<?= $edit_category['id'] ?>">
            <?php endif; ?>
            
            <div class="admin-input-group">
                <label for="name" class="admin-label">Nama Kategori</label>
                <input type="text" name="name" id="name" class="admin-control" 
                       placeholder="Contoh: Tanaman Air, Terrarium" 
                       value="<?= $edit_mode ? htmlspecialchars($edit_category['name']) : '' ?>" required>
            </div>
            
            <div style="display: flex; gap: 8px;">
                <?php if ($edit_mode): ?>
                    <button type="submit" name="edit_category" class="btn-admin btn-admin-success">
                        Simpan Perubahan <i class="fa-solid fa-check"></i>
                    </button>
                    <a href="categories.php" class="btn-admin btn-admin-outline">Batal</a>
                <?php else: ?>
                    <button type="submit" name="add_category" class="btn-admin btn-admin-primary">
                        Tambah Kategori <i class="fa-solid fa-plus"></i>
                    </button>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- PANEL DAFTAR KATEGORI (Tabel - Kanan) -->
    <div class="table-card">
        <h3 class="table-title" style="margin-bottom: 20px;"><i class="fa-solid fa-list"></i> Daftar Kategori</h3>
        
        <div class="table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th>Nama Kategori</th>
                        <th style="width: 140px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($all_categories) > 0): ?>
                        <?php foreach ($all_categories as $cat): ?>
                            <tr>
                                <td><?= $cat['id'] ?></td>
                                <td style="font-weight: 700;"><?= htmlspecialchars($cat['name']) ?></td>
                                <td align="center">
                                    <div class="action-buttons">
                                        <!-- Tombol Edit -->
                                        <a href="categories.php?edit_id=<?= $cat['id'] ?>" class="btn-admin btn-admin-outline btn-admin-sm" title="Edit">
                                            <i class="fa-solid fa-pen" style="color: var(--primary-light);"></i>
                                        </a>
                                        <!-- Tombol Hapus -->
                                        <a href="categories.php?delete_id=<?= $cat['id'] ?>" 
                                           class="btn-admin btn-admin-outline btn-admin-sm" 
                                           title="Hapus" 
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus kategori \'<?= addslashes($cat['name']) ?>\'? Produk dengan kategori ini akan diset tanpa kategori.')">
                                            <i class="fa-solid fa-trash" style="color: var(--danger-color);"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center" style="color: var(--text-muted); padding: 24px 0;">
                                Belum ada kategori tanaman yang terdaftar.
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
