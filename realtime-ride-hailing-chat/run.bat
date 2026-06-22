@echo off
:: Script Otomatisasi Deployment AFL-3 Microservices (Windows)
:: Dibuat dengan cinta untuk klien joki Anda agar lancar sekali klik

echo =======================================================================
echo     MENJALANKAN MICROSERVICES DEVELOPMENT STACK - GO-AFL3
echo =======================================================================
echo.

:: 1. Cek apakah Docker Daemon berjalan
docker info >nul 2>&1
if %errorlevel% neq 0 (
    echo [ERROR] Docker belum aktif! Silakan buka Docker Desktop terlebih dahulu.
    echo.
    pause
    exit /b 1
)

echo [INFO] Docker terdeteksi aktif. Memulai build dan deployment container...
echo.

:: 2. Jalankan docker-compose build dan up
docker compose up -d --build

if %errorlevel% neq 0 (
    echo.
    echo [ERROR] Gagal membuild atau menjalankan container Docker.
    pause
    exit /b 1
)

echo.
echo =======================================================================
echo    DEPLOYMENT BERHASIL! SEMUA CONTAINER BERJALAN DENGAN STABIL
echo =======================================================================
echo.
echo  Akses Layanan Berikut Melalui Browser Anda:
echo  ---------------------------------------------------------
echo  - Frontend Web UI      : http://localhost/
echo  - Traefik Dashboard    : http://localhost:8080/
echo  - Grafana Monitoring   : http://localhost/grafana/
echo  ---------------------------------------------------------
echo  Detail Akun default Grafana:
echo  - Username: admin
echo  - Password: admin
echo.
echo  Tekan sembarang tombol untuk menutup jendela ini...
pause
