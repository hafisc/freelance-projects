<?php
// Mendeteksi nama file halaman aktif untuk menandai menu aktif di sidebar
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!-- Bilah Samping (Sidebar Navigation) -->
<aside class="admin-sidebar">
    <!-- Header Sidebar -->
    <div class="sidebar-brand">
        <i class="fa-solid fa-leaf"></i>
        <span>GreenHaven Panel</span>
    </div>
    
    <!-- Profil Singkat Admin -->
    <div class="sidebar-profile">
        <div class="profile-avatar">
            <i class="fa-solid fa-user-shield"></i>
        </div>
        <div class="profile-info">
            <h4 class="profile-name"><?= htmlspecialchars($_SESSION['admin_name']) ?></h4>
            <span class="profile-role">Administrator</span>
        </div>
    </div>
    
    <!-- Menu Navigasi Admin -->
    <nav class="sidebar-menu">
        <a href="index.php" class="menu-item <?= $current_page === 'index.php' ? 'active' : '' ?>">
            <i class="fa-solid fa-chart-line"></i> Dashboard
        </a>
        <a href="categories.php" class="menu-item <?= $current_page === 'categories.php' ? 'active' : '' ?>">
            <i class="fa-solid fa-tags"></i> Kategori Tanaman
        </a>
        <a href="products.php" class="menu-item <?= $current_page === 'products.php' ? 'active' : '' ?>">
            <i class="fa-solid fa-seedling"></i> Produk Tanaman
        </a>
        <a href="messages.php" class="menu-item <?= $current_page === 'messages.php' ? 'active' : '' ?>">
            <i class="fa-solid fa-envelope"></i> Pesan Masuk
        </a>
        <a href="testimonials.php" class="menu-item <?= $current_page === 'testimonials.php' ? 'active' : '' ?>">
            <i class="fa-solid fa-comment-dots"></i> Testimoni Ulasan
        </a>
        
        <!-- Pembatas -->
        <div class="menu-divider"></div>
        
        <!-- Tautan ke Halaman Publik & Logout -->
        <a href="../index.php" target="_blank" class="menu-item">
            <i class="fa-solid fa-globe"></i> Lihat Website
        </a>
        <a href="logout.php" class="menu-item text-danger" onclick="return confirm('Apakah Anda yakin ingin keluar dari panel admin?')">
            <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar / Logout
        </a>
    </nav>
</aside>

<!-- Konten Utama Dashboard (Membuka Wrapper Konten) -->
<main class="admin-content-wrapper">
    <!-- Navbar Atas Dashboard -->
    <header class="admin-topbar">
        <div class="topbar-left">
            <button class="sidebar-toggle-btn" id="sidebarToggle" aria-label="Toggle Sidebar">
                <i class="fa-solid fa-bars"></i>
            </button>
            <h2 class="topbar-title">
                <?php
                // Menentukan nama modul aktif untuk ditampilkan di topbar
                switch($current_page) {
                    case 'index.php': echo 'Ikhtisar Dashboard'; break;
                    case 'categories.php': echo 'Manajemen Kategori Tanaman'; break;
                    case 'products.php': echo 'Manajemen Produk Tanaman'; break;
                    case 'messages.php': echo 'Daftar Pesan Masuk'; break;
                    case 'testimonials.php': echo 'Daftar Ulasan & Testimoni'; break;
                    default: echo 'Dashboard GreenHaven';
                }
                ?>
            </h2>
        </div>
        <div class="topbar-right">
            <span class="topbar-date"><i class="fa-regular fa-calendar"></i> <?= date('d M Y') ?></span>
        </div>
    </header>
    
    <!-- Area Konten Halaman (Dibuka di sini, ditutup di footer) -->
    <div class="admin-page-content">
