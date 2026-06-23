<?php
// Ambil ID produk dari query URL
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Jika ID tidak valid, redirect kembali ke home
if ($product_id <= 0) {
    header('Location: index.php');
    exit;
}

// Hubungkan database & load header
require_once 'includes/header.php';

// Ambil data produk berdasarkan ID beserta nama kategori
$stmt = $pdo->prepare("
    SELECT p.*, c.name as category_name 
    FROM products p 
    LEFT JOIN categories c ON p.category_id = c.id 
    WHERE p.id = ?
");
$stmt->execute([$product_id]);
$product = $stmt->fetch();

// Jika produk tidak ditemukan, arahkan kembali ke home
if (!$product) {
    header('Location: index.php');
    exit;
}

// Set judul halaman sesuai nama produk
$page_title = $product['name'] . " - GreenHaven";

// ==========================================
// HELPER GAMBAR SEED DATA
// ==========================================
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
    
    $upload_path = 'assets/images/uploads/' . $image_name;
    if (!empty($image_name) && file_exists(__DIR__ . '/' . $upload_path)) {
        return $upload_path;
    }
    
    return 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=600&q=80';
}

// Muat navigasi bar
require_once 'includes/navbar.php';
?>

<section class="detail-section">
    <div class="container">
        <!-- Tautan Kembali -->
        <a href="index.php#produk" style="display: inline-flex; align-items: center; gap: 8px; color: var(--primary-light); font-weight: 600; margin-bottom: 32px;">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Katalog
        </a>

        <div class="detail-grid">
            <!-- Galeri Gambar Produk -->
            <div class="detail-gallery">
                <img src="<?= get_plant_image($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
            </div>

            <!-- Detail Informasi Produk -->
            <div class="detail-content">
                <div class="detail-meta">
                    <span class="product-category" style="margin-bottom: 0;"><?= htmlspecialchars($product['category_name'] ?? 'Kategori Lain') ?></span>
                    <?php if ($product['stock'] > 0): ?>
                        <span style="font-size: 0.8rem; font-weight: 700; color: #1e6b3b; background-color: #e2f3e8; padding: 4px 12px; border-radius: 12px;">Stok Tersedia (<?= $product['stock'] ?>)</span>
                    <?php else: ?>
                        <span style="font-size: 0.8rem; font-weight: 700; color: #a82e2e; background-color: #fcebeb; padding: 4px 12px; border-radius: 12px;">Stok Habis</span>
                    <?php endif; ?>
                </div>

                <h1 class="detail-title"><?= htmlspecialchars($product['name']) ?></h1>
                
                <div class="product-rating" style="margin-bottom: 24px;">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <span style="color: var(--text-muted); font-size: 0.85rem; margin-left: 8px;">(4.9 Rating Pelanggan)</span>
                </div>

                <!-- Box Harga (Promo vs Normal) -->
                <div class="detail-price-box">
                    <?php if ($product['is_promo'] == 1 && $product['promo_price'] > 0): ?>
                        <div style="font-size: 0.85rem; text-transform: uppercase; color: var(--accent-color); font-weight: 700; margin-bottom: 4px;">Harga Promo Spesial</div>
                        <span class="detail-price">Rp <?= number_format($product['promo_price'], 0, ',', '.') ?></span>
                        <span class="product-price-old" style="font-size: 1.1rem; margin-left: 12px;">Rp <?= number_format($product['price'], 0, ',', '.') ?></span>
                    <?php else: ?>
                        <div style="font-size: 0.85rem; text-transform: uppercase; color: var(--primary-light); font-weight: 700; margin-bottom: 4px;">Harga Normal</div>
                        <span class="detail-price">Rp <?= number_format($product['price'], 0, ',', '.') ?></span>
                    <?php endif; ?>
                </div>

                <!-- Deskripsi Produk -->
                <h3 class="detail-desc-title">Deskripsi Tanaman</h3>
                <p class="detail-desc">
                    <?= nl2br(htmlspecialchars($product['description'])) ?>
                </p>

                <!-- Spesifikasi Botani Ringkas -->
                <div class="detail-specs">
                    <div class="spec-item">
                        <span class="spec-label">Frekuensi Siram</span>
                        <span class="spec-value">1 - 2 kali seminggu (menyesuaikan kelembapan)</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Kebutuhan Cahaya</span>
                        <span class="spec-value">Cahaya tidak langsung (sedang - teduh)</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Media Tanam</span>
                        <span class="spec-value">Sekam bakar, humus daun, & pupuk organik</span>
                    </div>
                </div>

                <!-- Aksi Pembelian -->
                <?php if ($product['stock'] > 0): ?>
                    <form action="checkout.php" method="GET">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        
                        <div class="detail-actions">
                            <!-- Input Kuantitas dengan Tombol Kustom JS -->
                            <div class="quantity-control">
                                <button type="button" class="quantity-btn" id="btnMinus">-</button>
                                <input type="number" name="quantity" id="quantityInput" class="quantity-input" value="1" min="1" max="<?= $product['stock'] ?>" readonly>
                                <button type="button" class="quantity-btn" id="btnPlus">+</button>
                            </div>
                            
                            <!-- Tombol Submit Form Checkout -->
                            <button type="submit" class="btn btn-primary" style="height: 48px; border-radius: 25px; flex-grow: 1; justify-content: center; font-size: 1rem;">
                                Pesan Sekarang <i class="fa-solid fa-cart-shopping"></i>
                            </button>
                        </div>
                    </form>
                <?php else: ?>
                    <button class="btn btn-outline" style="height: 48px; border-radius: 25px; cursor: not-allowed; text-align: center; justify-content: center;" disabled>
                        Stok Tanaman Habis <i class="fa-solid fa-ban"></i>
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php
// Muat footer
require_once 'includes/footer.php';
?>
