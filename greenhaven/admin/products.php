<?php
// Tentukan judul halaman
$admin_title = "Manajemen Produk - GreenHaven";

// Load header & session check
require_once 'includes/header.php';

// Memastikan folder upload gambar ada
$upload_dir = __DIR__ . '/../assets/images/uploads/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

$alert_message = '';
$alert_type = '';

// ==========================================
// 1. PROSES ACTIONS (TAMBAH / EDIT / HAPUS)
// ==========================================

// ACTION: HAPUS PRODUK (GET request)
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $delete_id = (int)$_GET['id'];
    
    if ($delete_id > 0) {
        try {
            // Ambil nama file gambar terlebih dahulu untuk dihapus dari folder upload
            $stmt_img = $pdo->prepare("SELECT image FROM products WHERE id = ?");
            $stmt_img->execute([$delete_id]);
            $old_image = $stmt_img->fetchColumn();
            
            // Hapus record di database
            $stmt_del = $pdo->prepare("DELETE FROM products WHERE id = ?");
            $stmt_del->execute([$delete_id]);
            
            // Hapus file gambar di disk jika bukan file default
            if ($old_image && $old_image !== 'default-plant.jpg') {
                $file_path = $upload_dir . $old_image;
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
            
            $alert_message = "Produk berhasil dihapus.";
            $alert_type = "success";
            header("Refresh: 1; URL=products.php");
        } catch (PDOException $e) {
            $alert_message = "Gagal menghapus produk: " . $e->getMessage();
            $alert_type = "danger";
        }
    }
}

// POST ACTIONS: SIMPAN DATA (TAMBAH / EDIT)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_product'])) {
    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    
    $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS));
    $category_id = isset($_POST['category_id']) ? (int)$_POST['category_id'] : null;
    $description = trim(filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS));
    $price = (float)$_POST['price'];
    $stock = (int)$_POST['stock'];
    $is_promo = isset($_POST['is_promo']) ? 1 : 0;
    $promo_price = !empty($_POST['promo_price']) ? (float)$_POST['promo_price'] : null;
    
    // Upload Gambar Handler
    $image_name = 'default-plant.jpg';
    if ($product_id > 0) {
        // Ambil nama gambar lama sebagai default jika sedang edit
        $stmt_old = $pdo->prepare("SELECT image FROM products WHERE id = ?");
        $stmt_old->execute([$product_id]);
        $image_name = $stmt_old->fetchColumn() ?: 'default-plant.jpg';
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_name_orig = $_FILES['image']['name'];
        $file_ext = strtolower(pathinfo($file_name_orig, PATHINFO_EXTENSION));
        
        $allowed_exts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if (in_array($file_ext, $allowed_exts)) {
            // Generate nama file unik baru untuk mencegah bentrok nama file
            $new_filename = uniqid('plant_', true) . '.' . $file_ext;
            $dest_path = $upload_dir . $new_filename;
            
            if (move_uploaded_file($file_tmp, $dest_path)) {
                // Hapus gambar lama jika ada dan bukan gambar bawaan/default
                if ($product_id > 0 && $image_name !== 'default-plant.jpg') {
                    $old_file = $upload_dir . $image_name;
                    if (file_exists($old_file)) {
                        unlink($old_file);
                    }
                }
                $image_name = $new_filename;
            } else {
                $alert_message = "Gagal memindahkan file upload.";
                $alert_type = "danger";
            }
        } else {
            $alert_message = "Format gambar tidak didukung. Gunakan JPG, PNG, GIF, atau WEBP.";
            $alert_type = "danger";
        }
    }

    // Eksekusi Simpan ke Database
    if (empty($alert_message)) {
        try {
            if ($product_id > 0) {
                // UPDATE data produk
                $stmt = $pdo->prepare("
                    UPDATE products 
                    SET category_id = ?, name = ?, description = ?, price = ?, stock = ?, image = ?, is_promo = ?, promo_price = ?
                    WHERE id = ?
                ");
                $stmt->execute([$category_id, $name, $description, $price, $stock, $image_name, $is_promo, $promo_price, $product_id]);
                $alert_message = "Produk '{$name}' berhasil diperbarui.";
                $alert_type = "success";
            } else {
                // INSERT data produk baru
                $stmt = $pdo->prepare("
                    INSERT INTO products (category_id, name, description, price, stock, image, is_promo, promo_price)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                ");
                $stmt->execute([$category_id, $name, $description, $price, $stock, $image_name, $is_promo, $promo_price]);
                $alert_message = "Produk baru '{$name}' berhasil didaftarkan.";
                $alert_type = "success";
            }
            // Redirect kembali ke daftar produk setelah 1.5 detik
            header("Refresh: 1.5; URL=products.php");
        } catch (PDOException $e) {
            $alert_message = "Gagal menyimpan produk: " . $e->getMessage();
            $alert_type = "danger";
        }
    }
}

// ==========================================
// 2. CHECK MODE Halaman (TAMBAH / EDIT / LIST)
// ==========================================
$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$product_data = null;

if ($action === 'edit' && isset($_GET['id'])) {
    $edit_id = (int)$_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$edit_id]);
    $product_data = $stmt->fetch();
    
    if (!$product_data) {
        $action = 'list'; // fallback jika id produk salah
    }
}

// Ambil data pendukung
$categories = $pdo->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll();
$products = $pdo->query("
    SELECT p.*, c.name as category_name 
    FROM products p 
    LEFT JOIN categories c ON p.category_id = c.id 
    ORDER BY p.id DESC
")->fetchAll();

// Helper Gambar Unsplash bawaan untuk demo awal
function get_plant_image($image_name) {
    $fallback_images = [
        'monstera.jpg' => 'https://images.unsplash.com/photo-1614594975525-e45190c55d0b?auto=format&fit=crop&w=600&q=80',
        'snake_plant.jpg' => 'https://images.unsplash.com/photo-1596547609652-9cf5d8d76921?auto=format&fit=crop&w=600&q=80',
        'calathea.jpg' => 'https://images.unsplash.com/photo-1545241047-6083a3684587?auto=format&fit=crop&w=600&q=80',
        'golden_barrel.jpg' => 'https://images.unsplash.com/photo-1520302630591-fd1c66edc19d?auto=format&fit=crop&w=600&q=80',
        'anthurium.jpg' => 'https://images.unsplash.com/photo-1599599810769-bcde5a160d32?auto=format&fit=crop&w=600&q=80',
        'peppermint.jpg' => 'https://images.unsplash.com/photo-1591880911575-b4458f44c4fa?auto=format&fit=crop&w=600&q=80',
    ];
    
    if (array_key_exists($image_name, $fallback_images)) {
        return $fallback_images[$image_name];
    }
    
    $upload_path = '../assets/images/uploads/' . $image_name;
    if (!empty($image_name) && file_exists(__DIR__ . '/' . $upload_path)) {
        return 'assets/images/uploads/' . $image_name; // relatif terhadap root admin
    }
    
    return 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=600&q=80';
}

require_once 'includes/sidebar.php';
?>

<!-- Alert Notifikasi -->
<?php if (!empty($alert_message)): ?>
    <div class="admin-alert alert-<?= $alert_type ?>">
        <i class="fa-solid <?= $alert_type === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation' ?>"></i> 
        <?= htmlspecialchars($alert_message) ?>
    </div>
<?php endif; ?>

<!-- ==========================================
     MODE: FORM TAMBAH / EDIT PRODUK
     ========================================== -->
<?php if ($action === 'add' || $action === 'edit'): ?>
    <div class="table-card" style="max-width: 800px; margin: 0 auto;">
        <div class="table-header">
            <h3 class="table-title">
                <?= $action === 'edit' ? '<i class="fa-solid fa-pen-to-square"></i> Edit Tanaman' : '<i class="fa-solid fa-circle-plus"></i> Tambah Produk Baru' ?>
            </h3>
            <a href="products.php" class="btn-admin btn-admin-outline btn-admin-sm"><i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar</a>
        </div>

        <form action="products.php" method="POST" enctype="multipart/form-data" class="admin-form">
            <!-- Simpan ID Produk jika sedang Edit -->
            <?php if ($action === 'edit'): ?>
                <input type="hidden" name="product_id" value="<?= $product_data['id'] ?>">
            <?php endif; ?>

            <!-- Row 1: Nama & Kategori -->
            <div class="form-row-2">
                <div class="admin-input-group">
                    <label for="name" class="admin-label">Nama Produk Tanaman</label>
                    <input type="text" name="name" id="name" class="admin-control" placeholder="Contoh: Monstera Variegata" value="<?= $action === 'edit' ? htmlspecialchars($product_data['name']) : '' ?>" required>
                </div>
                <div class="admin-input-group">
                    <label for="category_id" class="admin-label">Kategori Tanaman</label>
                    <select name="category_id" id="category_id" class="admin-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= ($action === 'edit' && $product_data['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Row 2: Deskripsi -->
            <div class="admin-input-group">
                <label for="description" class="admin-label">Deskripsi Tanaman</label>
                <textarea name="description" id="description" class="admin-control" placeholder="Tuliskan spesifikasi detail tanaman, tips penyiraman, kebutuhan cahaya matahari, dll..." required><?= $action === 'edit' ? htmlspecialchars($product_data['description']) : '' ?></textarea>
            </div>

            <!-- Row 3: Harga & Stok -->
            <div class="form-row-2">
                <div class="admin-input-group">
                    <label for="price" class="admin-label">Harga Satuan (Rp)</label>
                    <input type="number" name="price" id="price" class="admin-control" placeholder="Contoh: 120000" min="0" value="<?= $action === 'edit' ? (int)$product_data['price'] : '' ?>" required>
                </div>
                <div class="admin-input-group">
                    <label for="stock" class="admin-label">Jumlah Stok Ready</label>
                    <input type="number" name="stock" id="stock" class="admin-control" placeholder="Contoh: 15" min="0" value="<?= $action === 'edit' ? $product_data['stock'] : '' ?>" required>
                </div>
            </div>

            <!-- Row 4: Status Promo & Diskon -->
            <div class="table-card" style="padding: 16px; margin-bottom: 0; background-color: var(--bg-body);">
                <div class="admin-input-group" style="flex-direction: row; align-items: center; gap: 10px; margin-bottom: 12px;">
                    <input type="checkbox" name="is_promo" id="is_promo" value="1" <?= ($action === 'edit' && $product_data['is_promo'] == 1) ? 'checked' : '' ?> style="width: 18px; height: 18px; cursor: pointer;">
                    <label for="is_promo" class="admin-label" style="cursor: pointer; margin-bottom: 0; user-select: none;">Aktifkan Harga Promo / Diskon untuk Produk ini</label>
                </div>
                
                <div class="admin-input-group" id="promo_price_group" style="<?= ($action === 'edit' && $product_data['is_promo'] == 1) ? '' : 'display: none;' ?>">
                    <label for="promo_price" class="admin-label">Harga Promo (Rp)</label>
                    <input type="number" name="promo_price" id="promo_price" class="admin-control" placeholder="Contoh: 95000 (Harus lebih rendah dari harga normal)" min="0" value="<?= ($action === 'edit' && $product_data['promo_price']) ? (int)$product_data['promo_price'] : '' ?>">
                </div>
            </div>

            <!-- Row 5: Upload Foto Gambar -->
            <div class="form-row-2" style="align-items: center; gap: 24px;">
                <div class="admin-input-group">
                    <label for="image" class="admin-label">Foto Tanaman</label>
                    <input type="file" name="image" id="image" class="admin-control" accept="image/*">
                    <small style="color: var(--text-muted);">Format file: JPG, PNG, WEBP. Maksimal 2MB. Kosongkan jika tidak ingin mengubah gambar.</small>
                </div>
                
                <!-- Preview Gambar -->
                <div class="admin-input-group" style="align-items: center;">
                    <label class="admin-label">Pratinjau Gambar</label>
                    <div class="img-preview-box">
                        <?php if ($action === 'edit' && $product_data['image']): ?>
                            <img src="<?= get_plant_image($product_data['image']) ?>" alt="Preview">
                        <?php else: ?>
                            <i class="fa-solid fa-image" style="font-size: 2.5rem; color: var(--text-muted);"></i>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi Form -->
            <div style="display: flex; gap: 12px; margin-top: 24px; border-top: 1px solid var(--border-color); padding-top: 20px;">
                <button type="submit" name="save_product" class="btn-admin btn-admin-primary">
                    Simpan Produk <i class="fa-solid fa-floppy-disk"></i>
                </button>
                <a href="products.php" class="btn-admin btn-admin-outline">Batal</a>
            </div>
        </form>
    </div>

    <!-- Script Javascript dinamis untuk menampilkan/menyembunyikan form harga promo secara instan -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const isPromoCheckbox = document.getElementById('is_promo');
        const promoGroup = document.getElementById('promo_price_group');
        const promoInput = document.getElementById('promo_price');
        
        if (isPromoCheckbox && promoGroup) {
            isPromoCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    promoGroup.style.display = 'flex';
                    promoInput.setAttribute('required', 'required');
                } else {
                    promoGroup.style.display = 'none';
                    promoInput.removeAttribute('required');
                    promoInput.value = '';
                }
            });
        }
    });
    </script>

<!-- ==========================================
     MODE: LIST DAFTAR PRODUK (DEFAULT)
     ========================================== -->
<?php else: ?>
    <div class="table-card">
        <div class="table-header">
            <h3 class="table-title"><i class="fa-solid fa-seedling"></i> Daftar Koleksi Tanaman</h3>
            <a href="products.php?action=add" class="btn-admin btn-admin-primary">
                Tambah Produk Baru <i class="fa-solid fa-plus"></i>
            </a>
        </div>

        <div class="table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">No</th>
                        <th style="width: 80px;">Gambar</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga Normal</th>
                        <th>Status Promo</th>
                        <th>Harga Jual</th>
                        <th style="width: 80px; text-align: center;">Stok</th>
                        <th style="width: 140px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($products) > 0): ?>
                        <?php $no = 1; foreach ($products as $p): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <div style="width: 50px; height: 50px; border-radius: 6px; overflow: hidden; border: var(--border-color);">
                                        <img src="<?= get_plant_image($p['image']) ?>" alt="Tanaman" style="width:100%; height:100%; object-fit:cover;">
                                    </div>
                                </td>
                                <td style="font-weight: 700; color: var(--primary-color);"><?= htmlspecialchars($p['name']) ?></td>
                                <td><span class="admin-badge badge-info"><?= htmlspecialchars($p['category_name'] ?? 'Tanpa Kategori') ?></span></td>
                                <td>Rp <?= number_format($p['price'], 0, ',', '.') ?></td>
                                <td align="center">
                                    <?php if ($p['is_promo'] == 1): ?>
                                        <span class="admin-badge badge-success">Promo</span>
                                    <?php else: ?>
                                        <span class="admin-badge badge-danger">Normal</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($p['is_promo'] == 1 && $p['promo_price'] > 0): ?>
                                        <strong style="color: var(--success-color);">Rp <?= number_format($p['promo_price'], 0, ',', '.') ?></strong>
                                    <?php else: ?>
                                        <strong>Rp <?= number_format($p['price'], 0, ',', '.') ?></strong>
                                    <?php endif; ?>
                                </td>
                                <td align="center">
                                    <?php if ($p['stock'] > 10): ?>
                                        <span class="admin-badge badge-success"><?= $p['stock'] ?></span>
                                    <?php elseif ($p['stock'] > 0): ?>
                                        <span class="admin-badge badge-warning"><?= $p['stock'] ?></span>
                                    <?php else: ?>
                                        <span class="admin-badge badge-danger">Habis</span>
                                    <?php endif; ?>
                                </td>
                                <td align="center">
                                    <div class="action-buttons">
                                        <!-- Tombol Edit -->
                                        <a href="products.php?action=edit&id=<?= $p['id'] ?>" class="btn-admin btn-admin-outline btn-admin-sm" title="Edit">
                                            <i class="fa-solid fa-pen" style="color: var(--primary-light);"></i>
                                        </a>
                                        <!-- Tombol Hapus -->
                                        <a href="products.php?action=delete&id=<?= $p['id'] ?>" 
                                           class="btn-admin btn-admin-outline btn-admin-sm" 
                                           title="Hapus" 
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus produk \'<?= addslashes($p['name']) ?>\'? Tindakan ini tidak dapat dibatalkan.')">
                                            <i class="fa-solid fa-trash" style="color: var(--danger-color);"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center" style="color: var(--text-muted); padding: 32px 0;">
                                Belum ada produk tanaman yang terdaftar.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?php
// Load footer admin
require_once 'includes/footer.php';
?>
