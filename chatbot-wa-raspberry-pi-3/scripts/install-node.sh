#!/bin/bash

# ==============================================================================
# Script Instalasi Node.js 20 LTS
# Digunakan untuk melakukan setup Node.js v20 LTS dan dependency build dasar
# di Raspberry Pi OS Lite / Debian / Ubuntu.
# ==============================================================================

# Warna untuk output terminal agar premium
HIJAU='\033[0;32m'
MERAH='\033[0;31m'
KUNING='\033[1;33m'
NETRAL='\033[0m'

echo -e "${KUNING}===================================================${NETRAL}"
echo -e "      Memulai Instalasi Node.js 20 LTS             "
echo -e "${KUNING}===================================================${NETRAL}"

# 1. Update package list
echo "Memperbarui daftar paket repositori..."
sudo apt-get update -y

# 2. Install dependensi dasar curl dan build-essential jika belum ada
echo "Memasang dependensi dasar (curl, build-essential)..."
sudo apt-get install -y curl build-essential

# 3. Setup NodeSource repository untuk Node.js 20
echo "Mengunduh dan memasang repositori NodeSource Node.js 20.x..."
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -

# 4. Install Node.js
echo "Menginstal Node.js..."
sudo apt-get install -y nodejs

# 5. Verifikasi Instalasi
echo -e "\n${KUNING}Memverifikasi versi instalasi...${NETRAL}"
if command -v node >/dev/null 2>&1; then
    NODE_VER=$(node -v)
    NPM_VER=$(npm -v)
    echo -e "${HIJAU}Node.js berhasil terpasang: $NODE_VER${NETRAL}"
    echo -e "${HIJAU}NPM berhasil terpasang: $NPM_VER${NETRAL}"
else
    echo -e "${MERAH}Instalasi gagal. Periksa koneksi internet atau hak akses sudo Anda.${NETRAL}"
    exit 1
fi

echo -e "${KUNING}===================================================${NETRAL}"
echo -e "Instalasi selesai!"
