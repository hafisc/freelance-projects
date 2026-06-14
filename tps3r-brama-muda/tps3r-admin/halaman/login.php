<?php
/**
 * ============================================================
 * HALAMAN/LOGIN.PHP - Halaman Akses Masuk Admin
 * ============================================================
 */
session_start();

// Wajib panggil file konfigurasi API
require_once '../config/api.php';

// Jika ternyata admin sudah login (punya token), langsung tendang ke dashboard
if (isset($_SESSION['auth_token'])) {
    header("Location: dashboard.php");
    exit();
}

$error_message = '';

// Proses jika tombol "Masuk" ditekan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validasi form kosong
    if (empty($email) || empty($password)) {
        $error_message = 'Email dan password harus diisi.';
    } else {
        // Siapkan data untuk dikirim ke API Laravel
        $data_login = [
            'email' => $email,
            'password' => $password
        ];

        // Tembak endpoint /auth/login
        $response = callAPI('POST', '/auth/login', $data_login);

        // Cek apakah API mengembalikan success = true
        if (isset($response['success']) && $response['success'] === true) {
            
            // Opsional: Jika Anda ingin mengecek role admin secara spesifik
            // $role = strtolower($response['user']['role'] ?? '');
            // if ($role !== 'admin') { ... tolak akses ... }

            // Simpan token dan data user ke dalam Session PHP
            $_SESSION['auth_token'] = $response['token'];
            $_SESSION['user_data'] = $response['user'];
            
            // Arahkan ke dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            // Jika gagal, ambil pesan error dari API (atau tampilkan pesan default)
            $error_message = $response['message'] ?? 'Login gagal. Email atau password salah.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - WasteAnalytics</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            
            <div class="login-header">
                <div class="login-logo-box">
                    <i class="fas fa-leaf"></i>
                </div>
                <h2>Admin Panel</h2>
                <p>Masuk untuk mengelola sistem WasteAnalytics</p>
            </div>

            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?php echo htmlspecialchars($error_message); ?></span>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['msg']) && $_GET['msg'] == 'logout'): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>Anda berhasil keluar dari sistem.</span>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="form-group">
                    <label for="email">Email Admin</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="admin@email.com" required autocomplete="email">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block" style="margin-top: 24px; font-size: 16px;">
                    <i class="fas fa-sign-in-alt"></i> Masuk Sistem
                </button>
            </form>
            
        </div>
    </div>
</body>
</html>