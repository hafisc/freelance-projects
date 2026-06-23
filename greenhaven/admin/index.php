<?php
// Tentukan judul modul dashboard aktif
$admin_title = "Ikhtisar Dashboard - GreenHaven Panel";

// Hubungkan header & session check
require_once 'includes/header.php';

// Hubungkan sidebar admin
require_once 'includes/sidebar.php';

// ==========================================
// QUERY DATA REAL-TIME DARI DATABASE
// ==========================================
try {
    // 1. Total Produk
    $total_products = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();

    // 2. Total Kategori
    $total_categories = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();

    // 3. Total Pesan Masuk
    $total_messages = $pdo->query("SELECT COUNT(*) FROM messages")->fetchColumn();

    // 4. Total Testimoni
    $total_testimonials = $pdo->query("SELECT COUNT(*) FROM testimonials")->fetchColumn();

    // 5. Pesan Masuk Terbaru (menampilkan 3 pesan terakhir)
    $recent_messages = $pdo->query("SELECT * FROM messages ORDER BY id DESC LIMIT 3")->fetchAll();
} catch (PDOException $e) {
    echo "<div class='admin-alert alert-danger'>Gagal memuat data statistik: " . $e->getMessage() . "</div>";
    $total_products = $total_categories = $total_messages = $total_testimonials = 0;
    $recent_messages = [];
}
?>

<!-- ==========================================
     KARTU RINGKASAN STATISTIK (STATS GRID)
     ========================================== -->
<div class="stats-grid">
    <!-- Kartu 1: Total Produk -->
    <div class="stat-card">
        <div>
            <div class="stat-value"><?= $total_products ?></div>
            <div class="stat-title">Total Produk</div>
        </div>
        <div class="stat-icon">
            <i class="fa-solid fa-seedling"></i>
        </div>
    </div>
    
    <!-- Kartu 2: Total Kategori -->
    <div class="stat-card">
        <div>
            <div class="stat-value"><?= $total_categories ?></div>
            <div class="stat-title">Kategori Tanaman</div>
        </div>
        <div class="stat-icon">
            <i class="fa-solid fa-tags"></i>
        </div>
    </div>

    <!-- Kartu 3: Total Pesan Masuk -->
    <div class="stat-card">
        <div>
            <div class="stat-value"><?= $total_messages ?></div>
            <div class="stat-title">Pesan Masuk</div>
        </div>
        <div class="stat-icon">
            <i class="fa-solid fa-envelope"></i>
        </div>
    </div>

    <!-- Kartu 4: Total Testimoni -->
    <div class="stat-card">
        <div>
            <div class="stat-value"><?= $total_testimonials ?></div>
            <div class="stat-title">Testimoni Aktif</div>
        </div>
        <div class="stat-icon">
            <i class="fa-solid fa-comment-dots"></i>
        </div>
    </div>
</div>

<!-- ==========================================
     GRAFIK & KEMAJUAN (CHART & PROGRESS)
     ========================================== -->
<div class="dashboard-details-grid">
    <!-- Panel Grafik (Kolom Kiri) -->
    <div class="chart-card">
        <h3 style="font-size: 1rem; font-weight: 700; color: var(--primary-color); margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-chart-area"></i> Grafik Tren Kunjungan & Minat Produk (Tahun <?= date('Y') ?>)
        </h3>
        
        <!-- Grafik Kustom menggunakan SVG agar tampak tajam, modern, & premium tanpa library luar -->
        <div style="width: 100%; height: 260px; position: relative;">
            <svg viewBox="0 0 500 200" width="100%" height="100%" style="overflow: visible;">
                <!-- Grid Horizontal Lines -->
                <line x1="0" y1="40" x2="500" y2="40" stroke="#e9eee9" stroke-width="1" />
                <line x1="0" y1="90" x2="500" y2="90" stroke="#e9eee9" stroke-width="1" />
                <line x1="0" y1="140" x2="500" y2="140" stroke="#e9eee9" stroke-width="1" />
                <line x1="0" y1="180" x2="500" y2="180" stroke="#183b2b" stroke-width="1.5" />
                
                <!-- Grafik Area Gradasi (Glow Effect) -->
                <defs>
                    <linearGradient id="chartGradient" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0%" stop-color="#55b27b" stop-opacity="0.3"/>
                        <stop offset="100%" stop-color="#55b27b" stop-opacity="0.0"/>
                    </linearGradient>
                </defs>
                <polygon points="0,180 50,150 100,160 150,120 200,130 250,90 300,70 350,110 400,60 450,40 500,80 500,180 0,180" fill="url(#chartGradient)" />
                
                <!-- Jalur Garis Tren Utama -->
                <path d="M0,180 Q25,165 50,150 T100,160 T150,120 T200,130 T250,90 T300,70 T350,110 T400,60 T450,40 T500,80" fill="none" stroke="#55b27b" stroke-width="3" stroke-linecap="round" />
                
                <!-- Lingkaran Titik Nilai Puncak -->
                <circle cx="250" cy="90" r="5" fill="#183b2b" stroke="#55b27b" stroke-width="2" />
                <circle cx="450" cy="40" r="5" fill="#183b2b" stroke="#55b27b" stroke-width="2" />
                
                <!-- Label Grafik -->
                <text x="0" y="195" font-size="8" fill="#6f8075" font-weight="600">Jan</text>
                <text x="50" y="195" font-size="8" fill="#6f8075" font-weight="600">Feb</text>
                <text x="100" y="195" font-size="8" fill="#6f8075" font-weight="600">Mar</text>
                <text x="150" y="195" font-size="8" fill="#6f8075" font-weight="600">Apr</text>
                <text x="200" y="195" font-size="8" fill="#6f8075" font-weight="600">Mei</text>
                <text x="250" y="195" font-size="8" fill="#6f8075" font-weight="600">Jun</text>
                <text x="300" y="195" font-size="8" fill="#6f8075" font-weight="600">Jul</text>
                <text x="350" y="195" font-size="8" fill="#6f8075" font-weight="600">Agt</text>
                <text x="400" y="195" font-size="8" fill="#6f8075" font-weight="600">Sep</text>
                <text x="450" y="195" font-size="8" fill="#6f8075" font-weight="600">Okt</text>
                <text x="500" y="195" font-size="8" fill="#6f8075" font-weight="600">Nov</text>
            </svg>
        </div>
    </div>

    <!-- Panel Status Indikator (Kolom Kanan) -->
    <div class="chart-card">
        <h3 style="font-size: 1rem; font-weight: 700; color: var(--primary-color); margin-bottom: 20px;">
            <i class="fa-solid fa-list-check"></i> Status Operasional
        </h3>
        
        <div class="progress-list">
            <!-- Indikator 1: Ketersediaan Stok -->
            <div class="progress-item">
                <div class="progress-info">
                    <span>Pemantauan Stok Tanaman</span>
                    <span>Ready 78%</span>
                </div>
                <div class="progress-bar-wrapper">
                    <div class="progress-bar-fill bg-success" style="width: 78%;"></div>
                </div>
            </div>
            
            <!-- Indikator 2: Target Penjualan -->
            <div class="progress-item">
                <div class="progress-info">
                    <span>Target Penjualan Bulan Ini</span>
                    <span>Tercapai 65%</span>
                </div>
                <div class="progress-bar-wrapper">
                    <div class="progress-bar-fill bg-primary" style="width: 65%;"></div>
                </div>
            </div>

            <!-- Indikator 3: Kapasitas Kebun/Showroom -->
            <div class="progress-item">
                <div class="progress-info">
                    <span>Kapasitas Lahan Showroom</span>
                    <span>Terisi 45%</span>
                </div>
                <div class="progress-bar-wrapper">
                    <div class="progress-bar-fill bg-warning" style="width: 45%;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ==========================================
     TABEL INFORMASI TERBARU (RECENT MESSAGES)
     ========================================== -->
<div class="table-card">
    <div class="table-header">
        <h3 class="table-title"><i class="fa-solid fa-envelope-open-text"></i> Pesan Masuk Terbaru</h3>
        <a href="messages.php" class="btn-admin btn-admin-outline btn-admin-sm">Buka Semua Pesan <i class="fa-solid fa-arrow-right"></i></a>
    </div>
    
    <div class="table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 80px;">No</th>
                    <th>Nama Pengirim</th>
                    <th>Subjek / Topik</th>
                    <th>Isi Pesan</th>
                    <th>Tanggal Masuk</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($recent_messages) > 0): ?>
                    <?php $no = 1; foreach ($recent_messages as $msg): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td style="font-weight: 700;"><?= htmlspecialchars($msg['name']) ?></td>
                            <td><span class="admin-badge badge-info"><?= htmlspecialchars($msg['subject']) ?></span></td>
                            <td style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                <?= htmlspecialchars($msg['message']) ?>
                            </td>
                            <td><?= date('d M Y, H:i', strtotime($msg['created_at'])) ?> WIB</td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center" style="color: var(--text-muted); padding: 32px 0;">
                            Belum ada pesan masuk dari pengunjung website.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
// Hubungkan footer admin
require_once 'includes/footer.php';
?>
