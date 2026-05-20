#!/bin/bash
# ============================================================
# Script instalasi Node.js 20 LTS untuk Raspberry Pi OS / Debian / Ubuntu
# Menggunakan NodeSource repository
# ============================================================

echo "============================================"
echo "  Instalasi Node.js 20 LTS"
echo "============================================"
echo ""

# --- Cek apakah dijalankan sebagai root/sudo ---
if [ "$EUID" -ne 0 ]; then
    echo "❌ Script ini membutuhkan akses root/sudo."
    echo "   Jalankan: sudo bash scripts/install-node.sh"
    exit 1
fi

# --- Cek arsitektur sistem ---
ARCH=$(uname -m)
echo "📋 Arsitektur sistem: $ARCH"

if [ "$ARCH" != "aarch64" ] && [ "$ARCH" != "armv7l" ] && [ "$ARCH" != "x86_64" ]; then
    echo "⚠️  Arsitektur $ARCH mungkin tidak didukung oleh NodeSource."
    echo "   Lanjutkan dengan risiko sendiri."
fi

# --- Cek apakah Node.js 20 sudah terinstall ---
if command -v node &> /dev/null; then
    CURRENT_VERSION=$(node -v)
    MAJOR=$(echo "$CURRENT_VERSION" | cut -d. -f1 | tr -d 'v')
    if [ "$MAJOR" -ge 20 ]; then
        echo "✅ Node.js $CURRENT_VERSION sudah terinstall."
        echo "   npm: $(npm -v)"
        echo "   Tidak perlu instalasi ulang."
        exit 0
    else
        echo "⚠️  Node.js $CURRENT_VERSION terdeteksi (versi lama)."
        echo "   Akan diupgrade ke versi 20 LTS."
    fi
fi

echo ""
echo "📦 Memulai instalasi..."
echo ""

# --- Update package list ---
echo "1️⃣  Mengupdate package list..."
apt-get update -y
if [ $? -ne 0 ]; then
    echo "❌ Gagal mengupdate package list."
    echo "   Pastikan koneksi internet tersedia."
    exit 1
fi

# --- Install dependency dasar ---
echo "2️⃣  Menginstall dependency dasar (curl, git, build-essential)..."
apt-get install -y curl git build-essential
if [ $? -ne 0 ]; then
    echo "❌ Gagal menginstall dependency dasar."
    exit 1
fi

# --- Setup NodeSource repository untuk Node.js 20 ---
echo "3️⃣  Menambahkan NodeSource repository untuk Node.js 20..."
curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
if [ $? -ne 0 ]; then
    echo "❌ Gagal menambahkan NodeSource repository."
    echo "   Troubleshooting:"
    echo "   - Pastikan koneksi internet stabil"
    echo "   - Cek apakah https://deb.nodesource.com bisa diakses"
    echo "   - Coba lagi beberapa saat kemudian"
    exit 1
fi

# --- Install Node.js ---
echo "4️⃣  Menginstall Node.js 20 LTS..."
apt-get install -y nodejs
if [ $? -ne 0 ]; then
    echo "❌ Gagal menginstall Node.js."
    echo "   Troubleshooting:"
    echo "   - Jalankan: sudo apt-get update && sudo apt-get install -y nodejs"
    echo "   - Cek log: /var/log/apt/term.log"
    exit 1
fi

# --- Verifikasi instalasi ---
echo ""
echo "5️⃣  Verifikasi instalasi..."
NODE_VER=$(node -v)
NPM_VER=$(npm -v)

echo ""
echo "============================================"
echo "  ✅ Instalasi Node.js berhasil!"
echo "  Node.js : $NODE_VER"
echo "  npm     : $NPM_VER"
echo "============================================"
