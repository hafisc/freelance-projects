<?php
// Memulai session PHP
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Proteksi Keamanan: Jika admin belum login, redirect ke halaman login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Hubungkan koneksi database (karena semua halaman admin butuh query data)
require_once __DIR__ . '/../../config/db.php';

// Menentukan judul halaman dashboard dinamis
$admin_title = isset($admin_title) ? $admin_title . " - Panel Admin GreenHaven" : "Dashboard Admin - GreenHaven";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($admin_title) ?></title>
    
    <!-- Google Fonts: Plus Jakarta Sans (Bersih & Geometris) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icon CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Stylesheet khusus panel admin -->
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
<div class="admin-wrapper">
