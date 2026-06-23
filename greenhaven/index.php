<?php
// Tentukan judul halaman spesifik
$page_title = "GreenHaven - Toko Tanaman Hias Premium & Estetik";

// Menyertakan header & koneksi database (session dimulai di header)
require_once 'includes/header.php';

// ==========================================
// FORM MESSAGE PROCESSING (HUBUNGI KAMI)
// ==========================================
$message_status = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_message'])) {
    // Mengambil dan menyaring input dari form
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_SPECIAL_CHARS);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($name && $email && $subject && $message) {
        try {
            // Memasukkan pesan ke database
            $stmt = $pdo->prepare("INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $subject, $message]);
            $message_status = 'success';
        } catch (PDOException $e) {
            $message_status = 'error';
        }
    } else {
        $message_status = 'invalid';
    }
}

// ==========================================
// HELPER DYNAMIC IMAGE LOAD
// ==========================================
/**
 * Mengambil URL gambar produk. Jika merupakan seed data,
 * mengembalikan link Unsplash resolusi tinggi agar tampilan memukau.
 */
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
    
    // Path untuk gambar hasil upload admin
    $upload_path = 'assets/images/uploads/' . $image_name;
    if (!empty($image_name) && file_exists(__DIR__ . '/' . $upload_path)) {
        return $upload_path;
    }
    
    return 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=600&q=80';
}

// ==========================================
// LOAD DATA DARI DATABASE
// ==========================================
// 1. Ambil semua kategori untuk filter dan galeri
$categories = $pdo->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll();

// 2. Ambil produk berdasarkan filter kategori
$filter_category = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
if ($filter_category > 0) {
    $stmt_products = $pdo->prepare("
        SELECT p.*, c.name as category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        WHERE p.category_id = ? 
        ORDER BY p.id DESC
    ");
    $stmt_products->execute([$filter_category]);
    $products = $stmt_products->fetchAll();
} else {
    $products = $pdo->query("
        SELECT p.*, c.name as category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        ORDER BY p.id DESC
    ")->fetchAll();
}

// 3. Ambil testimoni aktif
$testimonials = $pdo->query("SELECT * FROM testimonials WHERE is_active = 1 ORDER BY id DESC LIMIT 3")->fetchAll();

// Menyertakan navbar di bagian atas
require_once 'includes/navbar.php';
?>

<!-- ==========================================
     HERO SECTION
     ========================================== -->
<header class="hero" id="home">
    <div class="container hero-grid">
        <div class="hero-content">
            <span class="hero-tag">Welcome to GreenHaven</span>
            <h1 class="hero-title">Bring the <span>Elegance</span> of Nature into Your Home</h1>
            <p class="hero-description">
                Temukan koleksi tanaman hias premium yang dirawat dengan penuh kasih sayang oleh para ahli botani. Dapatkan udara bersih, ketenangan jiwa, dan estetika interior yang menawan.
            </p>
            <div class="hero-actions">
                <a href="#produk" class="btn btn-primary">Lihat Koleksi <i class="fa-solid fa-arrow-right"></i></a>
                <a href="#kontak" class="btn btn-outline">Konsultasi <i class="fa-solid fa-circle-question"></i></a>
            </div>
        </div>
        <div class="hero-visual">
            <div class="hero-image-wrapper">
                <!-- Foto tanaman yang memukau untuk representasi utama -->
                <img src="https://images.unsplash.com/photo-1545241047-6083a3684587?auto=format&fit=crop&w=800&q=80" alt="Tanaman Premium GreenHaven">
            </div>
            <!-- Card dekorasi mengapung -->
            <div class="hero-deco-card">
                <i class="fa-solid fa-award"></i>
                <div>
                    <h4>100% Organik</h4>
                    <p>Bebas bahan kimia berbahaya</p>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- ==========================================
     FEATURES SECTION
     ========================================== -->
<section class="features">
    <div class="container">
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                <h3>Pengiriman Aman</h3>
                <p>Garansi tanaman tetap segar sampai di depan pintu rumah Anda dengan packing proteksi kayu khusus.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fa-solid fa-seedling"></i>
                </div>
                <h3>Kualitas Terjamin</h3>
                <p>Setiap tanaman melewati seleksi kualitas yang ketat, sehat, bebas hama, dan siap tumbuh subur.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <h3>Konsultasi Gratis</h3>
                <p>Dapatkan panduan cara merawat, penyiraman, dan pencahayaan yang tepat langsung dari tim botani kami.</p>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================
     CATEGORIES SECTION
     ========================================== -->
<section class="categories" id="kategori">
    <div class="container">
        <div class="section-title-wrapper">
            <span class="section-tag">Koleksi Kami</span>
            <h2 class="section-title">Kategori Tanaman Pilihan</h2>
        </div>
        <div class="categories-grid">
            <!-- Menampilkan kategori dengan gambar dekoratif yang pas -->
            <a href="index.php?category_id=1#produk" class="category-card">
                <img class="category-img" src="https://images.unsplash.com/photo-1614594975525-e45190c55d0b?auto=format&fit=crop&w=400&q=80" alt="Tanaman Indoor">
                <div class="category-overlay">
                    <h3>Tanaman Indoor</h3>
                    <p>Pembersih udara & penghias ruangan</p>
                </div>
            </a>
            <a href="index.php?category_id=2#produk" class="category-card">
                <img class="category-img" src="https://images.unsplash.com/photo-1599599810769-bcde5a160d32?auto=format&fit=crop&w=400&q=80" alt="Tanaman Outdoor">
                <div class="category-overlay">
                    <h3>Tanaman Outdoor</h3>
                    <p>Sinar matahari penuh & tahan cuaca</p>
                </div>
            </a>
            <a href="index.php?category_id=3#produk" class="category-card">
                <img class="category-img" src="https://images.unsplash.com/photo-1520302630591-fd1c66edc19d?auto=format&fit=crop&w=400&q=80" alt="Sukulen & Kaktus">
                <div class="category-overlay">
                    <h3>Sukulen & Kaktus</h3>
                    <p>Perawatan mudah & hemat tempat</p>
                </div>
            </a>
            <a href="index.php?category_id=4#produk" class="category-card">
                <img class="category-img" src="https://images.unsplash.com/photo-1591880911575-b4458f44c4fa?auto=format&fit=crop&w=400&q=80" alt="Tanaman Herbal">
                <div class="category-overlay">
                    <h3>Herbal & Obat</h3>
                    <p>Segar, aromatik, & kaya khasiat</p>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- ==========================================
     PRODUCT CATALOG SECTION
     ========================================== -->
<section class="products-section" id="produk">
    <div class="container">
        <div class="section-title-wrapper">
            <span class="section-tag">Katalog Hijau</span>
            <h2 class="section-title">Temukan Tanaman Favorit Anda</h2>
        </div>

        <!-- Filter Tab Kategori Dinamis -->
        <div class="product-filters">
            <a href="index.php#produk" class="filter-btn <?= $filter_category === 0 ? 'active' : '' ?>">Semua Produk</a>
            <?php foreach ($categories as $cat): ?>
                <a href="index.php?category_id=<?= $cat['id'] ?>#produk" 
                   class="filter-btn <?= $filter_category === (int)$cat['id'] ? 'active' : '' ?>">
                    <?= htmlspecialchars($cat['name']) ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Grid Produk -->
        <div class="products-grid">
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $prod): ?>
                    <div class="product-card">
                        <div class="product-image-container">
                            <img src="<?= get_plant_image($prod['image']) ?>" alt="<?= htmlspecialchars($prod['name']) ?>">
                            
                            <!-- Badge Status (Promo / Stok Habis) -->
                            <?php if ($prod['is_promo'] == 1 && $prod['promo_price'] > 0): ?>
                                <span class="badge badge-promo">Promo</span>
                            <?php endif; ?>
                            <?php if ($prod['stock'] <= 0): ?>
                                <span class="badge badge-stock">Habis</span>
                            <?php endif; ?>
                        </div>
                        <div class="product-info">
                            <span class="product-category"><?= htmlspecialchars($prod['category_name'] ?? 'Kategori Lain') ?></span>
                            <h3 class="product-name"><?= htmlspecialchars($prod['name']) ?></h3>
                            
                            <div class="product-rating">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            
                            <div class="product-price-wrapper">
                                <?php if ($prod['is_promo'] == 1 && $prod['promo_price'] > 0): ?>
                                    <span class="product-price">Rp <?= number_format($prod['promo_price'], 0, ',', '.') ?></span>
                                    <span class="product-price-old">Rp <?= number_format($prod['price'], 0, ',', '.') ?></span>
                                <?php else: ?>
                                    <span class="product-price">Rp <?= number_format($prod['price'], 0, ',', '.') ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <a href="detail.php?id=<?= $prod['id'] ?>" class="product-btn">
                                Detail Tanaman <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center" style="grid-column: 1/-1; padding: 48px 0; color: var(--text-muted);">
                    <i class="fa-regular fa-face-frown" style="font-size: 3rem; margin-bottom: 16px; display: block; color: var(--primary-light);"></i>
                    <p>Maaf, produk tanaman untuk kategori ini belum tersedia saat ini.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ==========================================
     TESTIMONIALS SECTION
     ========================================== -->
<section class="testimonials" id="testimoni">
    <div class="container">
        <div class="section-title-wrapper">
            <span class="section-tag">Ulasan Pembeli</span>
            <h2 class="section-title">Apa Kata Mereka Tentang Kami</h2>
        </div>
        <div class="testimonials-grid">
            <?php foreach ($testimonials as $t): ?>
                <div class="testimonial-card">
                    <p class="testimonial-quote">
                        "<?= htmlspecialchars($t['review']) ?>"
                    </p>
                    <div class="testimonial-profile">
                        <div class="testimonial-avatar">
                            <?= substr(htmlspecialchars($t['name']), 0, 1) ?>
                        </div>
                        <div>
                            <h4 class="testimonial-name"><?= htmlspecialchars($t['name']) ?></h4>
                            <span class="testimonial-role"><?= htmlspecialchars($t['role'] ?? 'Pelanggan') ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ==========================================
     KONTAK & FORM KIRIM PESAN SECTION
     ========================================== -->
<section class="contact-section" id="kontak">
    <div class="container contact-grid">
        <!-- Informasi Detail Kontak (Panel Kiri) -->
        <div class="contact-info-panel">
            <div>
                <h3>Konsultasi & Kunjungi Showroom Kami</h3>
                <p>Kami sangat senang membantu Anda memilih tanaman yang sesuai dengan pencahayaan dan gaya ruangan Anda. Jangan ragu menghubungi kami.</p>
            </div>
            <div class="contact-details">
                <div class="contact-detail-item">
                    <i class="fa-solid fa-phone"></i>
                    <div>
                        <h4>WhatsApp Care</h4>
                        <p>+62 812-3456-7890 (Setiap Hari 08.00 - 20.00 WIB)</p>
                    </div>
                </div>
                <div class="contact-detail-item">
                    <i class="fa-solid fa-envelope"></i>
                    <div>
                        <h4>Email Hubungan Pelanggan</h4>
                        <p>support@greenhaven.my.id</p>
                    </div>
                </div>
                <div class="contact-detail-item">
                    <i class="fa-solid fa-map-location-dot"></i>
                    <div>
                        <h4>Kebun Utama & Showroom</h4>
                        <p>Jl. Hutan Hijau No. 45, Kebayoran Baru, Jakarta Selatan</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Kirim Pesan (Panel Kanan) -->
        <div class="contact-form-panel">
            <h3 class="form-title" style="font-family: var(--font-heading); color: var(--primary-color); font-size: 1.6rem; margin-bottom: 24px;">Kirim Pertanyaan Anda</h3>
            
            <!-- Notifikasi Pengiriman Form -->
            <?php if ($message_status === 'success'): ?>
                <div class="alert-message alert-success">
                    <i class="fa-solid fa-circle-check"></i> Pesan Anda telah terkirim! Tim ahli botani kami akan membalas via email secepatnya.
                </div>
            <?php elseif ($message_status === 'error'): ?>
                <div class="alert-message alert-danger">
                    <i class="fa-solid fa-circle-xmark"></i> Terjadi kesalahan sistem. Pesan gagal disimpan. Coba beberapa saat lagi.
                </div>
            <?php elseif ($message_status === 'invalid'): ?>
                <div class="alert-message alert-danger">
                    <i class="fa-solid fa-triangle-exclamation"></i> Harap isi semua kolom form dengan data yang benar.
                </div>
            <?php endif; ?>

            <form action="index.php#kontak" method="POST">
                <div class="form-group">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Contoh: Budi Santoso" required>
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Contoh: budi@email.com" required>
                </div>
                <div class="form-group">
                    <label for="subject" class="form-label">Subjek / Topik Pesan</label>
                    <input type="text" name="subject" id="subject" class="form-control" placeholder="Contoh: Tanya Stok atau Perawatan Tanaman" required>
                </div>
                <div class="form-group">
                    <label for="message" class="form-label">Isi Pesan / Pertanyaan</label>
                    <textarea name="message" id="message" class="form-control" placeholder="Tuliskan pertanyaan detail Anda di sini..." required></textarea>
                </div>
                <button type="submit" name="send_message" class="btn btn-primary" style="width: 100%; justify-content: center; height: 48px; border-radius: 8px;">
                    Kirim Pesan <i class="fa-solid fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
</section>

<!-- ==========================================
     FAQ SECTION (ACCORDION)
     ========================================== -->
<section class="container" style="padding: 60px 24px 100px 24px; border-top: 1px solid rgba(24, 59, 43, 0.08);">
    <div class="section-title-wrapper">
        <span class="section-tag">Bantuan</span>
        <h2 class="section-title">Pertanyaan Sering Diajukan (FAQ)</h2>
    </div>
    
    <div style="max-width: 800px; margin: 0 auto; display: flex; flex-direction: column; gap: 16px;">
        <details style="background-color: var(--bg-card); padding: 20px 24px; border-radius: var(--border-radius); border: var(--border-light); cursor: pointer; transition: var(--transition-smooth);" onplay="this.style.borderColor='var(--primary-color)'">
            <summary style="font-weight: 700; color: var(--primary-color); font-size: 1.05rem; display: flex; justify-content: space-between; align-items: center; list-style: none;">
                Bagaimana garansi pengiriman jika tanaman mati di jalan?
                <i class="fa-solid fa-chevron-down" style="font-size: 0.85rem; color: var(--primary-light);"></i>
            </summary>
            <p style="margin-top: 12px; color: var(--text-muted); font-size: 0.9rem; line-height: 1.6;">
                Kami memberikan garansi 100% uang kembali atau pengiriman ulang gratis jika tanaman Anda rusak atau mati dalam proses pengiriman. Silakan kirimkan video unboxing tanpa terputus dalam waktu 24 jam setelah paket diterima.
            </p>
        </details>

        <details style="background-color: var(--bg-card); padding: 20px 24px; border-radius: var(--border-radius); border: var(--border-light); cursor: pointer; transition: var(--transition-smooth);">
            <summary style="font-weight: 700; color: var(--primary-color); font-size: 1.05rem; display: flex; justify-content: space-between; align-items: center; list-style: none;">
                Apakah tanaman dikirim beserta potnya?
                <i class="fa-solid fa-chevron-down" style="font-size: 0.85rem; color: var(--primary-light);"></i>
            </summary>
            <p style="margin-top: 12px; color: var(--text-muted); font-size: 0.9rem; line-height: 1.6;">
                Ya, tanaman dikirim lengkap beserta pot plastik hitam bawaan dan media tanam yang dikurangi secukupnya untuk menghemat berat pengiriman namun tetap menjaga kelembapan akar tanaman.
            </p>
        </details>

        <details style="background-color: var(--bg-card); padding: 20px 24px; border-radius: var(--border-radius); border: var(--border-light); cursor: pointer; transition: var(--transition-smooth);">
            <summary style="font-weight: 700; color: var(--primary-color); font-size: 1.05rem; display: flex; justify-content: space-between; align-items: center; list-style: none;">
                Bagaimana saya tahu frekuensi penyiraman tanaman yang saya beli?
                <i class="fa-solid fa-chevron-down" style="font-size: 0.85rem; color: var(--primary-light);"></i>
            </summary>
            <p style="margin-top: 12px; color: var(--text-muted); font-size: 0.9rem; line-height: 1.6;">
                Setiap tanaman yang kami kirimkan dilengkapi dengan kartu panduan perawatan khusus. Kartu tersebut berisi informasi detail tentang kebutuhan cahaya matahari, dosis penyiraman, dan pupuk berkala. Anda juga dapat berkonsultasi via WhatsApp.
            </p>
        </details>
    </div>
</section>

<?php
// Menyertakan footer halaman publik
require_once 'includes/footer.php';
?>
