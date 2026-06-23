<?php
// Memulai session PHP jika belum dimulai untuk mendukung autentikasi atau flash messages
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Menyertakan koneksi database secara otomatis jika diperlukan di setiap halaman
require_once __DIR__ . '/../config/db.php';

// Menentukan judul halaman dinamis
$page_title = isset($page_title) ? $page_title . " - GreenHaven Plant Shop" : "GreenHaven - Toko Tanaman Hias Premium";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="GreenHaven - Menyediakan koleksi tanaman hias premium indoor & outdoor terlengkap untuk menghias ruang hidup Anda secara estetik dan sehat.">
    <title><?= htmlspecialchars($page_title) ?></title>
    
    <!-- Google Fonts: Playfair Display (Serif Elegan) & Plus Jakarta Sans (Sans-serif Bersih) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icon CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS (Gaya Desain Premium) -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
