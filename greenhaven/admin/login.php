<?php
// Memulai session PHP
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Hubungkan file database
require_once __DIR__ . '/../config/db.php';

// Jika admin sudah login sebelumnya, langsung arahkan ke dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: index.php');
    exit;
}

$error_message = '';

// Proses form login saat metode POST dikirimkan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS));
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        try {
            // Mengambil data admin berdasarkan username
            $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
            $stmt->execute([$username]);
            $admin = $stmt->fetch();

            // Verifikasi kecocokan username dan hash password (bcrypt)
            if ($admin && password_verify($password, $admin['password'])) {
                // Set variabel session jika berhasil login
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];
                $_SESSION['admin_name'] = $admin['name'];
                
                // Redirect ke halaman utama dashboard admin
                header('Location: index.php');
                exit;
            } else {
                $error_message = 'Username atau password salah.';
            }
        } catch (PDOException $e) {
            $error_message = 'Terjadi kesalahan sistem: ' . $e->getMessage();
        }
    } else {
        $error_message = 'Harap isi semua kolom login.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrator - GreenHaven</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icon CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CSS Login Panel Premium -->
    <style>
        :root {
            --primary-color: #183B2B;
            --primary-light: #597d64;
            --bg-body: #FAFBF9;
            --text-color: #233029;
            --accent-color: #c09d6f;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #183B2B 0%, #0F2E1B 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--text-color);
            padding: 20px;
        }

        .login-card {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            width: 100%;
            max-width: 400px;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-logo {
            font-size: 2.2rem;
            color: var(--primary-color);
            margin-bottom: 8px;
        }

        .login-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .login-subtitle {
            font-size: 0.85rem;
            color: #667c70;
            margin-top: 4px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--primary-color);
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-light);
            font-size: 1rem;
        }

        .form-control {
            width: 100%;
            padding: 12px 14px 12px 42px;
            border: 1px solid rgba(24, 59, 43, 0.15);
            border-radius: 8px;
            font-size: 0.95rem;
            color: var(--text-color);
            transition: all 0.3s;
            font-family: inherit;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(24, 59, 43, 0.08);
        }

        .alert-error {
            background-color: #fcebeb;
            color: #a82e2e;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 8px;
            border: 1px solid #f7d2d2;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background-color: var(--primary-color);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }

        .btn-login:hover {
            background-color: var(--accent-color);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(192, 157, 111, 0.2);
        }

        .back-to-home {
            display: block;
            text-align: center;
            margin-top: 24px;
            font-size: 0.85rem;
            color: var(--primary-light);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }

        .back-to-home:hover {
            color: var(--accent-color);
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="login-header">
        <div class="login-logo">
            <i class="fa-solid fa-leaf"></i>
        </div>
        <h2 class="login-title">GreenHaven Admin</h2>
        <p class="login-subtitle">Silakan login untuk mengelola GreenHaven</p>
    </div>

    <!-- Tampilkan Alert Error jika Ada -->
    <?php if (!empty($error_message)): ?>
        <div class="alert-error">
            <i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($error_message) ?>
        </div>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <div class="form-group">
            <label for="username" class="form-label">Username</label>
            <div class="input-wrapper">
                <i class="fa-solid fa-user input-icon"></i>
                <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username admin" required autocomplete="off">
            </div>
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <div class="input-wrapper">
                <i class="fa-solid fa-lock input-icon"></i>
                <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
            </div>
        </div>

        <button type="submit" class="btn-login">
            Masuk ke Dashboard <i class="fa-solid fa-arrow-right-to-bracket"></i>
        </button>
    </form>

    <a href="../index.php" class="back-to-home">
        <i class="fa-solid fa-house"></i> Kembali ke Website
    </a>
</div>

</body>
</html>
