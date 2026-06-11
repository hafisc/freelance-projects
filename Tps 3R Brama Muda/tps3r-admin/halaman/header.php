<?php
/**
 * ============================================================
 * HALAMAN/HEADER.PHP - Bagian Atas Web Admin (Fixed Toggle)
 * ============================================================
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page_title = $page_title ?? 'Dashboard';
$user_name = $_SESSION['user_data']['name'] ?? 'Admin User';
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - Admin WasteAnalytics</title>
    
    <link rel="stylesheet" href="../style.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="dashboard-wrapper">
        
        <aside class="sidebar" id="appSidebar">
            <div class="sidebar-brand">
                <div class="brand-logo">
                    <i class="fas fa-leaf"></i>
                </div>
                <div class="brand-text">
                    <h1>WasteAnalytics</h1>
                    <p>Admin TPS 3R</p>
                </div>
            </div>
            
            <ul class="sidebar-menu">
                <li class="sidebar-item <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
                    <a href="dashboard.php">
                        <i class="fas fa-home"></i> 
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>
                
                <li class="sidebar-item <?php echo ($current_page == 'laporan.php' || $current_page == 'laporan_detail.php') ? 'active' : ''; ?>">
                    <a href="laporan.php">
                        <i class="fas fa-clipboard-list"></i> 
                        <span class="menu-text">Laporan Warga</span>
                    </a>
                </li>
                
                <li class="sidebar-item <?php echo ($current_page == 'edukasi.php' || $current_page == 'edukasi_tambah.php' || $current_page == 'edukasi_edit.php') ? 'active' : ''; ?>">
                    <a href="edukasi.php">
                        <i class="fas fa-book-open"></i> 
                        <span class="menu-text">Edukasi</span>
                    </a>
                </li>
            </ul>
            
            <div class="sidebar-footer">
                <a href="logout.php" class="btn btn-danger btn-block" onclick="return confirm('Apakah Anda yakin ingin keluar?');">
                    <i class="fas fa-sign-out-alt"></i> 
                    <span class="menu-text">Keluar</span>
                </a>
            </div>
        </aside>
        
        <main class="main-content" id="mainContent">
            
            <nav class="top-navbar">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <button id="toggleSidebarBtn" class="toggle-sidebar-btn">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <div class="page-title">
                        <h2><?php echo $page_title; ?></h2>
                        <p>Panel Manajemen TPS 3R Brama Muda</p>
                    </div>
                </div>
                
                <div class="user-profile-nav">
                    <span style="color: var(--text-dark); font-weight: 600; font-size: 14px;">
                        <?php echo htmlspecialchars($user_name); ?>
                    </span>
                    <div class="user-nav-avatar">
                        <?php echo strtoupper(substr($user_name, 0, 1)); ?>
                    </div>
                </div>
            </nav>