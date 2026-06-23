<!-- Kaki Halaman (Footer) -->
<footer class="footer">
    <div class="footer-container">
        <!-- Informasi Brand/Toko -->
        <div class="footer-info">
            <a href="index.php" class="footer-logo">
                <i class="fa-solid fa-leaf"></i>
                <span>GreenHaven</span>
            </a>
            <p class="footer-description">
                GreenHaven adalah penyedia tanaman hias premium terpercaya. Kami membantu Anda menghadirkan keindahan alam tropis ke dalam ruang hunian dan kerja Anda secara praktis dan estetik.
            </p>
            <div class="footer-socials">
                <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" aria-label="Youtube"><i class="fa-brands fa-youtube"></i></a>
                <a href="#" aria-label="Pinterest"><i class="fa-brands fa-pinterest-p"></i></a>
            </div>
        </div>

        <!-- Tautan Navigasi Cepat -->
        <div class="footer-nav">
            <h3>Navigasi Cepat</h3>
            <ul>
                <li><a href="index.php#home">Home</a></li>
                <li><a href="index.php#kategori">Kategori Tanaman</a></li>
                <li><a href="index.php#produk">Katalog Produk</a></li>
                <li><a href="index.php#testimoni">Ulasan Pelanggan</a></li>
                <li><a href="index.php#kontak">Hubungi Kami</a></li>
            </ul>
        </div>

        <!-- Informasi Kontak -->
        <div class="footer-contact">
            <h3>Hubungi Kami</h3>
            <ul>
                <li>
                    <i class="fa-solid fa-location-dot"></i>
                    <span>Jl. Hutan Hijau No. 45, Kebayoran Baru, Jakarta Selatan, 12130</span>
                </li>
                <li>
                    <i class="fa-solid fa-phone"></i>
                    <span>+62 812-3456-7890</span>
                </li>
                <li>
                    <i class="fa-solid fa-envelope"></i>
                    <span>info@greenhaven.my.id</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Bagian Hak Cipta & Portal Admin -->
    <div class="footer-bottom">
        <div class="footer-bottom-container">
            <p>&copy; <?= date('Y') ?> GreenHaven Plant Shop. All Rights Reserved.</p>
            <p class="admin-portal-link">
                <!-- Tautan tersembunyi/halus menuju Dashboard Admin untuk memudahkan akses dosen/klien -->
                <a href="admin/login.php" class="text-muted"><i class="fa-solid fa-lock"></i> Panel Administrator</a>
            </p>
        </div>
    </div>
</footer>

<!-- Custom JavaScript (Animasi & Navigasi Responsif) -->
<script src="assets/js/main.js"></script>
</body>
</html>
