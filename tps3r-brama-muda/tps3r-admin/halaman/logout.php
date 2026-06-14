<?php
/**
 * ============================================================
 * HALAMAN/LOGOUT.PHP - Proses Keluar Sistem
 * ============================================================
 */
session_start();

// Wajib panggil file konfigurasi API
require_once '../config/api.php';

// Jika admin punya token, beri tahu server Laravel untuk menghancurkan token tersebut
if (isset($_SESSION['auth_token'])) {
    // Tembak endpoint /auth/logout (fungsi callAPI otomatis akan menyisipkan Bearer Token)
    // Kita abaikan responsenya, berhasil atau gagal di server, yang penting kita hapus session lokal
    callAPI('POST', '/auth/logout');
}

// Hapus semua data session di sisi Web PHP Native
session_unset();
session_destroy();

// Tendang kembali ke halaman login dengan pesan sukses
header("Location: login.php?msg=logout");
exit();
?>