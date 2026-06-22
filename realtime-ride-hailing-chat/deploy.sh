#!/bin/bash
# Script Otomatisasi Deployment AFL-3 Microservices (Bash)
# Dibuat dengan cinta untuk klien joki Anda agar lancar sekali klik

echo "======================================================================="
echo "    MENJALANKAN MICROSERVICES DEVELOPMENT STACK - GO-AFL3"
echo "======================================================================="
echo ""

# 1. Cek apakah Docker Daemon berjalan
if ! docker info >/dev/null 2>&1; then
    echo "[ERROR] Docker belum aktif! Silakan aktifkan Docker terlebih dahulu."
    echo ""
    exit 1
fi

echo "[INFO] Docker terdeteksi aktif. Memulai build dan deployment container..."
echo ""

# 2. Jalankan docker-compose build dan up
docker compose up -d --build

if [ $? -ne 0 ]; then
    echo ""
    echo "[ERROR] Gagal membuild atau menjalankan container Docker."
    exit 1
fi

echo ""
echo "======================================================================="
echo "   DEPLOYMENT BERHASIL! SEMUA CONTAINER BERJALAN DENGAN STABIL"
echo "======================================================================="
echo ""
echo " Akses Layanan Berikut Melalui Browser Anda:"
echo " ---------------------------------------------------------"
echo " - Frontend Web UI      : http://localhost/"
echo " - Traefik Dashboard    : http://localhost:8080/"
echo " - Grafana Monitoring   : http://localhost/grafana/"
echo " ---------------------------------------------------------"
echo " Detail Akun default Grafana:"
echo " - Username: admin"
echo " - Password: admin"
echo ""
