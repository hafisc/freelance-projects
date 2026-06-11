<?php

session_start();
require_once '../config/api.php';

if (!isset($_SESSION['auth_token'])) {
    header("Location: login.php");
    exit();
}

$edu_id = $_GET['id'] ?? null;
if (!$edu_id) {
    header("Location: edukasi.php");
    exit();
}

$alert_msg = '';
$alert_type = '';

// Proses jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_data = [
        'title' => $_POST['title'] ?? '',
        'content' => $_POST['content'] ?? '',
        'status' => $_POST['status'] ?? 'draft',
        // Trik khusus Laravel: Kirim sebagai POST tapi suruh Laravel anggap ini PUT
        '_method' => 'PUT' 
    ];

    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['thumbnail']['tmp_name'];
        $file_type = $_FILES['thumbnail']['type'];
        $file_name = $_FILES['thumbnail']['name'];
        $post_data['thumbnail'] = new CURLFile($file_tmp, $file_type, $file_name);
    }

    // Tetap gunakan POST di fungsi cURL karena kita mengirim file (multipart)
    $response = callAPI('POST', "/educations/{$edu_id}", $post_data, true);

    if (isset($response['success']) && $response['success'] === true) {
        $alert_type = 'success';
        $alert_msg = 'Perubahan artikel berhasil disimpan!';
    } else {
        $alert_type = 'danger';
        $alert_msg = $response['message'] ?? 'Gagal memperbarui artikel.';
    }
}

// Ambil data edukasi saat ini dari API
$response_data = callAPI('GET', "/educations/{$edu_id}");
$edu_detail = null;

// Cek apakah data berhasil didapat dari API
if (isset($response_data['success']) && $response_data['success'] === true) {
    $edu_detail = $response_data['data'][0] ?? null; 
}

// Jika ID salah / data tidak ada
if (!$edu_detail) {
    echo "<script>alert('Data artikel tidak ditemukan!'); window.location.href='edukasi.php';</script>";
    exit();
}

$storage_base_url = str_replace('/api', '', API_BASE_URL) . '/storage/';
$page_title = 'Edit Artikel Edukasi';
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
        <h3>Revisi Artikel</h3>
    </div>
    <div style="padding: 24px;">
        <form action="edukasi_edit.php?id=<?php echo $edu_id; ?>" method="POST" enctype="multipart/form-data">
            
            <div class="form-group">
                <label for="title">Judul Artikel <span style="color: var(--danger);">*</span></label>
                <input type="text" id="title" name="title" class="form-control" required 
                       value="<?php echo htmlspecialchars($_POST['title'] ?? $edu_detail['title']); ?>">
            </div>

            <div class="form-group" style="display: flex; gap: 20px; align-items: flex-start;">
                <div style="flex: 1;">
                    <label for="thumbnail">Ubah Gambar Thumbnail</label>
                    <input type="file" id="thumbnail" name="thumbnail" class="form-control" accept="image/jpeg, image/png, image/jpg">
                    <p style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">Biarkan kosong jika tidak ingin mengubah gambar. Format: JPG, PNG (Maks 2MB).</p>
                </div>
                
                <?php if (!empty($edu_detail['thumbnail'])): ?>
                <div style="width: 150px;">
                    <label>Gambar Saat Ini</label>
                    <img src="<?php echo $storage_base_url . $edu_detail['thumbnail']; ?>" alt="Thumbnail" style="width: 100%; border-radius: var(--radius-sm); border: 1px solid var(--border-color);">
                </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="content">Isi Konten Edukasi <span style="color: var(--danger);">*</span></label>
                <textarea id="content" name="content" class="form-control" rows="8" required><?php echo htmlspecialchars($_POST['content'] ?? $edu_detail['content']); ?></textarea>
            </div>

            <div class="form-group" style="max-width: 200px;">
                <label for="status">Status Publikasi</label>
                <?php $current_status = $_POST['status'] ?? strtolower($edu_detail['status']); ?>
                <select id="status" name="status" class="form-control">
                    <option value="draft" <?php echo ($current_status == 'draft') ? 'selected' : ''; ?>>Draft</option>
                    <option value="published" <?php echo ($current_status == 'published') ? 'selected' : ''; ?>>Published</option>
                </select>
            </div>

            <div style="margin-top: 32px; border-top: 1px solid var(--border-color); padding-top: 24px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Perbarui Artikel
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once 'footer.php'; ?>