<?php
/**
 * ============================================================
 * INDEX.PHP - Pintu Masuk Utama Web Admin TPS 3R
 * ============================================================
 * File ini berfungsi sebagai router awal untuk memeriksa session.
 * Jika admin sudah login -> Redirection ke Dashboard
 * Jika belum login       -> Redirection ke Halaman Login
 * ============================================================
 */

// Mulai session PHP
session_start();

// Periksa apakah token authentication dan data user sudah ada di session
if (isset($_SESSION['auth_token']) && isset($_SESSION['user_data'])) {
    // Jika session valid, arahkan langsung ke dashboard admin
    header("Location: halaman/dashboard.php");
    exit();
} else {
    // Jika tidak ada session, paksa masuk ke halaman login
    header("Location: halaman/login.php");
    exit();
}
?>