<?php

session_start();
require_once '../config/api.php';

if (!isset($_SESSION['auth_token'])) {
    header("Location: login.php");
    exit();
}

$alert_msg = '';
$alert_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Siapkan data teks
    $post_data = [
        'title' => $_POST['title'] ?? '',
        'content' => $_POST['content'] ?? '',
        'status' => $_POST['status'] ?? 'draft'
    ];

    // Jika ada file gambar yang diunggah, tambahkan ke array data menggunakan CURLFile
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['thumbnail']['tmp_name'];
        $file_type = $_FILES['thumbnail']['type'];
        $file_name = $_FILES['thumbnail']['name'];
        
        $post_data['thumbnail'] = new CURLFile($file_tmp, $file_type, $file_name);
    }

    // Tembak API menggunakan method POST dan parameter $is_multipart = true
    $response = callAPI('POST', '/educations', $post_data, true);

    if (isset($response['success']) && $response['success'] === true) {
        $alert_type = 'success';
        $alert_msg = 'Artikel edukasi berhasil ditambahkan!';
        // Reset $_POST agar form kosong setelah sukses
        $_POST = [];
    } else {
        $alert_type = 'danger';
        $alert_msg = $response['message'] ?? 'Gagal menyimpan artikel. Periksa kembali form Anda.';
    }
}

$page_title = 'Tambah Edukasi Baru';
require_once 'header.php';
?>

<div style="margin-bottom: 24px;">
    <a href="edukasi.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
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
        <h3>Formulir Artikel Baru</h3>
    </div>
    <div style="padding: 24px;">
        <form action="edukasi_tambah.php" method="POST" enctype="multipart/form-data">
            
            <div class="form-group">
                <label for="title">Judul Artikel <span style="color: var(--danger);">*</span></label>
                <input type="text" id="title" name="title" class="form-control" required 
                       value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>" placeholder="Masukkan judul yang menarik...">
            </div>

            <div class="form-group">
                <label for="thumbnail">Gambar Thumbnail (Opsional)</label>
                <input type="file" id="thumbnail" name="thumbnail" class="form-control" accept="image/jpeg, image/png, image/jpg">
                <p style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">Format: JPG, JPEG, PNG. Maksimal 2MB.</p>
            </div>

            <div class="form-group">
                <label for="content">Isi Konten Edukasi <span style="color: var(--danger);">*</span></label>
                <textarea id="content" name="content" class="form-control" rows="8" required 
                          placeholder="Tuliskan materi edukasi daur ulang di sini..."><?php echo htmlspecialchars($_POST['content'] ?? ''); ?></textarea>
            </div>

            <div class="form-group" style="max-width: 200px;">
                <label for="status">Status Publikasi</label>
                <select id="status" name="status" class="form-control">
                    <option value="draft" <?php echo (isset($_POST['status']) && $_POST['status'] == 'draft') ? 'selected' : ''; ?>>Draft (Simpan Sementara)</option>
                    <option value="published" <?php echo (isset($_POST['status']) && $_POST['status'] == 'published') ? 'selected' : ''; ?>>Published (Terbitkan)</option>
                </select>
            </div>

            <div style="margin-top: 32px; border-top: 1px solid var(--border-color); padding-top: 24px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Artikel
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once 'footer.php'; ?>