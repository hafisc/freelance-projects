<?php
/**
 * Konfigurasi Koneksi Database - GreenHaven Plant Shop
 * Menggunakan ekstensi PDO (PHP Data Objects) untuk keamanan dan portabilitas.
 */

// Pengaturan kredensial database (Silakan ubah sesuai konfigurasi server hosting Anda)
$db_host = 'localhost';          // Host database (biasanya localhost)
$db_name = 'greenhaven_db';      // Nama database
$db_user = 'root';               // Username database (default XAMPP: root)
$db_pass = '';                   // Password database (default XAMPP: kosong)

try {
    // Membuat koneksi ke database dengan opsi error mode exception dan default fetch mode sebagai associative array
    $pdo = new PDO(
        "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4",
        $db_user,
        $db_pass,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Mengaktifkan exception saat terjadi error SQL
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Hasil fetch data otomatis berupa array asosiatif
            PDO::ATTR_EMULATE_PREPARES   => false,                  // Menggunakan prepared statements asli bawaan MySQL
        ]
    );
} catch (PDOException $e) {
    // Jika koneksi gagal, tampilkan pesan error yang ramah atau log kesalahan
    // Catatan: Pada server production/hosting, disarankan tidak menampilkan detail error $e->getMessage() secara langsung ke publik demi keamanan
    die("Koneksi ke database gagal: " . $e->getMessage());
}
?>
