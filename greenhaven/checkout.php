<?php
// Ambil data produk dan kuantitas dari query string
$product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;
$quantity = isset($_GET['quantity']) ? (int)$_GET['quantity'] : 1;

// Proteksi jika ID tidak valid atau jumlah negatif
if ($product_id <= 0 || $quantity <= 0) {
    header('Location: index.php');
    exit;
}

// Hubungkan database & load header
require_once 'includes/header.php';

// Ambil info produk
$stmt = $pdo->prepare("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();

// Proteksi jika produk tidak ditemukan atau stok habis
if (!$product || $product['stock'] <= 0) {
    header('Location: index.php');
    exit;
}

// Sesuaikan jumlah pembelian jika melebihi stok yang ada
if ($quantity > $product['stock']) {
    $quantity = $product['stock'];
}

// Tentukan harga yang berlaku (promo vs normal)
$price = ($product['is_promo'] == 1 && $product['promo_price'] > 0) ? $product['promo_price'] : $product['price'];
$subtotal = $price * $quantity;
$shipping_cost = 15000; // Biaya estimasi pengiriman flat
$grand_total = $subtotal + $shipping_cost;

// Set judul halaman
$page_title = "Checkout Pemesanan - GreenHaven";

// ==========================================
// HELPER SEED IMAGES
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

require_once 'includes/navbar.php';
?>

<section class="detail-section" style="background-color: var(--bg-secondary); min-height: 90vh; padding-top: 130px;">
    <div class="container">
        <h1 class="section-title" style="margin-bottom: 40px; font-family: var(--font-heading);">Penyelesaian Pemesanan</h1>

        <div class="contact-grid">
            <!-- 1. Form Informasi Pengiriman (Kiri) -->
            <div class="contact-form-panel">
                <h3 style="font-family: var(--font-heading); color: var(--primary-color); margin-bottom: 24px; font-size: 1.4rem;">Informasi Penerima</h3>
                
                <form id="checkoutForm">
                    <div class="form-group">
                        <label for="buyerName" class="form-label">Nama Lengkap</label>
                        <input type="text" id="buyerName" class="form-control" placeholder="Contoh: Rian Hidayat" required>
                    </div>
                    <div class="form-group">
                        <label for="buyerPhone" class="form-label">Nomor WhatsApp / HP</label>
                        <input type="tel" id="buyerPhone" class="form-control" placeholder="Contoh: 08123456789" required>
                    </div>
                    <div class="form-group">
                        <label for="buyerAddress" class="form-label">Alamat Lengkap Pengiriman</label>
                        <textarea id="buyerAddress" class="form-control" placeholder="Tuliskan alamat lengkap beserta kecamatan dan kode pos..." required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="paymentMethod" class="form-label">Metode Pembayaran</label>
                        <select id="paymentMethod" class="form-control" required>
                            <option value="Transfer Bank (BCA/Mandiri)">Transfer Bank (BCA/Mandiri)</option>
                            <option value="E-Wallet (Dana/OVO/Gopay)">E-Wallet (Dana/OVO/Gopay)</option>
                            <option value="Cash On Delivery (COD)">Cash On Delivery (COD)</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; height: 50px; border-radius: 8px; margin-top: 12px; font-size: 1rem;">
                        Kirim Pesanan Ke WhatsApp <i class="fa-brands fa-whatsapp" style="font-size: 1.25rem;"></i>
                    </button>
                </form>
            </div>

            <!-- 2. Ringkasan Pesanan (Kanan) -->
            <div class="contact-info-panel" style="background-color: var(--bg-card); color: var(--text-main); border: var(--border-light);">
                <div>
                    <h3 style="font-family: var(--font-heading); color: var(--primary-color); font-size: 1.4rem; margin-bottom: 24px; border-bottom: 1px solid rgba(24, 59, 43, 0.08); padding-bottom: 12px;">Ringkasan Pesanan</h3>
                    
                    <!-- Item Produk -->
                    <div style="display: flex; gap: 16px; margin-bottom: 24px; align-items: center;">
                        <img src="<?= get_plant_image($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: var(--border-light);">
                        <div>
                            <h4 style="font-family: var(--font-heading); color: var(--primary-color); font-size: 1.15rem; margin-bottom: 4px;"><?= htmlspecialchars($product['name']) ?></h4>
                            <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 0;">Jumlah: <strong><?= $quantity ?> pcs</strong></p>
                            <p style="color: var(--primary-light); font-size: 0.9rem; font-weight: 700; margin-bottom: 0;">Rp <?= number_format($price, 0, ',', '.') ?> / pcs</p>
                        </div>
                    </div>

                    <!-- Perincian Harga -->
                    <div style="border-top: 1px solid rgba(24, 59, 43, 0.08); padding-top: 16px; display: flex; flex-direction: column; gap: 12px;">
                        <div style="display: flex; justify-content: space-between; font-size: 0.95rem;">
                            <span style="color: var(--text-muted);">Subtotal Tanaman</span>
                            <span style="font-weight: 700; color: var(--primary-color);">Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 0.95rem;">
                            <span style="color: var(--text-muted);">Estimasi Ongkir</span>
                            <span style="font-weight: 700; color: var(--primary-color);">Rp <?= number_format($shipping_cost, 0, ',', '.') ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 1.2rem; border-top: 2px dashed rgba(24, 59, 43, 0.15); padding-top: 16px; margin-top: 4px;">
                            <span style="font-family: var(--font-heading); font-weight: 700; color: var(--primary-color);">Total Pembayaran</span>
                            <span style="font-weight: 800; color: var(--primary-color);">Rp <?= number_format($grand_total, 0, ',', '.') ?></span>
                        </div>
                    </div>
                </div>

                <!-- Informasi Pembayaran -->
                <div style="margin-top: 40px; background-color: var(--bg-secondary); padding: 16px; border-radius: 8px; border: var(--border-light); font-size: 0.85rem; color: var(--text-muted); display: flex; gap: 12px; align-items: flex-start;">
                    <i class="fa-solid fa-circle-info" style="color: var(--primary-color); font-size: 1.1rem; margin-top: 2px;"></i>
                    <p style="margin-bottom: 0; line-height: 1.5;">
                        Pemesanan Anda akan diteruskan langsung ke WhatsApp admin GreenHaven. Admin akan mengonfirmasi ketersediaan stok, alamat kirim, dan memberikan nomor rekening resmi.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Script khusus untuk menangkap input form dan meredirect ke WhatsApp API -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkoutForm = document.getElementById('checkoutForm');
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Mengambil input dari form
            const buyerName = document.getElementById('buyerName').value.trim();
            const buyerPhone = document.getElementById('buyerPhone').value.trim();
            const buyerAddress = document.getElementById('buyerAddress').value.trim();
            const paymentMethod = document.getElementById('paymentMethod').value;
            
            // Parameter produk dari PHP
            const productName = "<?= addslashes($product['name']) ?>";
            const productQty = "<?= $quantity ?>";
            const productPrice = "Rp <?= number_format($price, 0, ',', '.') ?>";
            const grandTotal = "Rp <?= number_format($grand_total, 0, ',', '.') ?>";
            
            // Membuat teks pesan terstruktur untuk WhatsApp
            const waMessage = 
                `*Pemesanan Baru - GreenHaven Plant Shop*\n` +
                `-----------------------------------------\n` +
                `*Data Pembeli:*\n` +
                `• Nama Lengkap: ${buyerName}\n` +
                `• No. WhatsApp: ${buyerPhone}\n` +
                `• Alamat Kirim: ${buyerAddress}\n` +
                `-----------------------------------------\n` +
                `*Rincian Tanaman:*\n` +
                `• Tanaman: ${productName}\n` +
                `• Jumlah: ${productQty} pcs\n` +
                `• Harga Satuan: ${productPrice}\n` +
                `• Estimasi Ongkir: Rp 15.000\n` +
                `• *Total Tagihan: ${grandTotal}*\n` +
                `-----------------------------------------\n` +
                `*Metode Pembayaran:* ${paymentMethod}\n` +
                `-----------------------------------------\n` +
                `Mohon konfirmasi pesanan dan instruksi pembayaran. Terima kasih!`;
            
            // Encode teks pesan agar sesuai format URL
            const encodedMessage = encodeURIComponent(waMessage);
            
            // Nomor WhatsApp tujuan admin GreenHaven (bisa diganti sesuai nomor asli klien)
            const waAdminNumber = "6281234567890";
            
            // Redirect langsung ke WhatsApp Web / App
            window.open(`https://api.whatsapp.com/send?phone=${waAdminNumber}&text=${encodedMessage}`, '_blank');
        });
    }
});
</script>

<?php
// Load footer
require_once 'includes/footer.php';
?>
