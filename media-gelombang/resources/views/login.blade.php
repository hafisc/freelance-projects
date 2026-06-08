@extends('layouts.app')

@section('title', 'Login - Fisiterra Portal')

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* --- VARIABLES --- */
        :root {
            /* Warna disesuaikan dengan video (Sky Blue / Cyan vibe) */
            --primary: #0ea5e9;
            --primary-hover: #0284c7;
            --bg-top: #e0f2fe;
            /* Biru sangat muda di atas */
            --bg-bottom: #bae6fd;
            /* Biru langit di bawah */

            --text-dark: #1e293b;
            --text-gray: #64748b;
            --input-bg: #f8fafc;
            --input-border: #e2e8f0;
        }

        /* --- FULL SCREEN OVERRIDE --- */
        .fullscreen-auth {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 9999;
            background: linear-gradient(135deg, var(--bg-top) 0%, var(--bg-bottom) 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Inter', sans-serif;
            /* Menggunakan font Inter */
            overflow: hidden;
        }

        /* --- PARTICLES ANIMATION --- */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            background: rgba(14, 165, 233, 0.3);
            border-radius: 50%;
            filter: blur(2px);
            /* Efek blur pada partikel seperti di video */
            animation: float 15s infinite linear;
        }

        .particle:nth-child(1) {
            width: 30px;
            height: 30px;
            left: 15%;
            bottom: -50px;
            animation-duration: 12s;
        }

        .particle:nth-child(2) {
            width: 15px;
            height: 15px;
            left: 25%;
            bottom: -50px;
            animation-duration: 15s;
            animation-delay: 2s;
        }

        .particle:nth-child(3) {
            width: 40px;
            height: 40px;
            left: 45%;
            bottom: -50px;
            animation-duration: 18s;
            animation-delay: 5s;
        }

        .particle:nth-child(4) {
            width: 20px;
            height: 20px;
            left: 60%;
            bottom: -50px;
            animation-duration: 14s;
            animation-delay: 1s;
        }

        .particle:nth-child(5) {
            width: 50px;
            height: 50px;
            left: 75%;
            bottom: -50px;
            animation-duration: 20s;
            animation-delay: 3s;
        }

        @keyframes float {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                transform: translateY(-100vh) rotate(360deg);
                opacity: 0;
            }
        }

        /* --- WAVES ANIMATION --- */
        .waves-container {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 120px;
            z-index: 1;
        }

        .waves {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .parallax>use {
            animation: move-forever 25s cubic-bezier(.55, .5, .45, .5) infinite;
        }

        .parallax>use:nth-child(1) {
            animation-delay: -2s;
            animation-duration: 7s;
        }

        .parallax>use:nth-child(2) {
            animation-delay: -3s;
            animation-duration: 10s;
        }

        .parallax>use:nth-child(3) {
            animation-delay: -4s;
            animation-duration: 13s;
        }

        .parallax>use:nth-child(4) {
            animation-delay: -5s;
            animation-duration: 20s;
        }

        @keyframes move-forever {
            0% {
                transform: translate3d(-90px, 0, 0);
            }

            100% {
                transform: translate3d(85px, 0, 0);
            }
        }

        /* --- LOGIN CARD MATCHING VIDEO --- */
        .login-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
            padding: 20px;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            /* Putih bersih transparan sedikit */
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 24px;
            padding: 48px 40px;
            box-shadow: 0 10px 40px -10px rgba(14, 165, 233, 0.15);
            /* Shadow biru lembut */
            text-align: center;
        }

        /* --- TYPOGRAPHY --- */
        .brand-logo {
            color: var(--primary);
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 24px;
            letter-spacing: -0.5px;
        }

        .auth-title {
            color: var(--text-dark);
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .auth-subtitle {
            color: var(--text-gray);
            font-size: 0.95rem;
            margin-bottom: 32px;
        }

        /* --- FORM ELEMENTS --- */
        .form-group {
            position: relative;
            margin-bottom: 20px;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1.1rem;
            transition: color 0.3s ease;
        }

        .form-control {
            width: 100%;
            height: 52px;
            /* Tambahkan !important di baris padding ini bro 👇 */
            padding: 0 50px !important;
            border-radius: 12px;
            border: 1px solid var(--input-border);
            background-color: var(--input-bg);
            font-size: 0.95rem;
            color: var(--text-dark);
            outline: none;
            transition: all 0.3s ease;
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        .form-control:focus {
            border-color: var(--primary);
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.15);
        }

        .form-control:focus+.input-icon,
        .form-control:focus~.input-icon {
            color: var(--primary);
        }

        .toggle-password {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            cursor: pointer;
            border: none;
            background: none;
            font-size: 1.1rem;
            padding: 0;
        }

        .toggle-password:hover {
            color: var(--text-dark);
        }

        .forgot-password {
            display: block;
            text-align: right;
            color: var(--primary);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 28px;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: var(--primary-hover);
        }

        .btn-submit {
            width: 100%;
            height: 52px;
            background-color: var(--primary);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.25);
        }

        /* --- FOOTER TAGS --- */
        .footer-tags {
            margin-top: 32px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
            color: var(--text-gray);
            font-size: 0.85rem;
            font-weight: 500;
        }

        .tag-dot {
            width: 4px;
            height: 4px;
            background-color: #cbd5e1;
            border-radius: 50%;
        }

        /* Styling Error Validation Laravel */
        .error-text {
            color: #ef4444;
            text-align: left;
            display: block;
            font-size: 0.85rem;
            margin-top: 6px;
            margin-left: 4px;
        }

        .is-invalid {
            border-color: #ef4444 !important;
            background-color: #fef2f2 !important;
        }
    </style>
@endsection

@section('content')
    <div class="fullscreen-auth">

        <div class="particles">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
        </div>

        <div class="waves-container">
            <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
                <defs>
                    <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
                </defs>
                <g class="parallax">
                    <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(2, 132, 199, 0.3)" />
                    <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(2, 132, 199, 0.5)" />
                    <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(3, 105, 161, 0.8)" />
                    <use xlink:href="#gentle-wave" x="48" y="7" fill="#0369a1" />
                </g>
            </svg>
        </div>

        <div class="login-wrapper">
            <div class="auth-card">

                <div class="brand-logo">Fisiterra</div>
                <h1 class="auth-title">Login Pengguna</h1>
                <p class="auth-subtitle">Masukkan NIS (Siswa) atau NIP (Guru)</p>

                <form method="POST" action="/login">
                    @csrf

                    <div class="form-group">
                        <input type="text" class="form-control @error('username') is-invalid @enderror" name="username"
                            placeholder="NIS / NIP" value="{{ old('username') }}" required autofocus>
                        <i class="fa-regular fa-user input-icon"></i>
                        @error('username')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                            name="password" placeholder="Password" required>
                        <i class="fa-solid fa-lock input-icon"></i>
                        <button type="button" class="toggle-password" onclick="togglePassword()">
                            <i class="fa-regular fa-eye-slash" id="toggleIcon"></i>
                        </button>
                        @error('password')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-password">Lupa password?</a>
                    @else
                        <a href="#" class="forgot-password">Lupa password?</a>
                    @endif

                    <button type="submit" class="btn-submit">Masuk</button>
                </form>

                <div class="footer-tags">
                    <span>Gelombang</span>
                    <span class="tag-dot"></span>
                    <span>Bunyi</span>
                    <span class="tag-dot"></span>
                    <span>Cahaya</span>
                </div>

            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            }
        }
    </script>
@endsection