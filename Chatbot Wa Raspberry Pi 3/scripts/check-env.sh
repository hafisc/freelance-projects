#!/bin/bash

# ==============================================================================
# Script Pengecekan Lingkungan Sistem (Environment Check)
# Digunakan untuk memverifikasi apakah Raspberry Pi / server Linux siap
# untuk menjalankan WhatsApp AI Chatbot.
# ==============================================================================

# Warna untuk output terminal agar premium
HIJAU='\033[0;32m'
MERAH='\033[0;31m'
KUNING='\033[1;33m'
NETRAL='\033[0m'

echo -e "${KUNING}===================================================${NETRAL}"
echo -e "${KUNING}   Pengecekan Lingkungan Chatbot WhatsApp AI       ${NETRAL}"
echo -e "${KUNING}===================================================${NETRAL}"

# 1. Cek Sistem Operasi
echo -n "Memeriksa OS... "
OS_NAME=$(uname -s)
if [ "$OS_NAME" = "Linux" ]; then
    echo -e "${HIJAU}OK (Linux)${NETRAL}"
else
    echo -e "${KUNING}Peringatan: OS bukan Linux ($OS_NAME). Bot didesain untuk Linux/Raspberry Pi.${NETRAL}"
fi

# 2. Cek Arsitektur CPU
echo -n "Memeriksa Arsitektur CPU... "
ARCH_NAME=$(uname -m)
echo -e "${HIJAU}$ARCH_NAME${NETRAL}"

# 3. Cek Node.js
echo -n "Memeriksa Node.js... "
if command -v node >/dev/null 2>&1; then
    NODE_VER=$(node -v)
    # Ambil angka versi utama (contoh: v20.10.0 -> 20)
    NODE_MAJOR_VER=$(echo "$NODE_VER" | cut -d'v' -f2 | cut -d'.' -f1)
    if [ "$NODE_MAJOR_VER" -ge 20 ]; then
        echo -e "${HIJAU}OK ($NODE_VER)${NETRAL}"
    else
        echo -e "${MERAH}ERROR: Node.js versi $NODE_VER. Butuh versi >= 20 LTS.${NETRAL}"
    fi
else
    echo -e "${MERAH}ERROR: Node.js tidak terdeteksi. Silakan jalankan scripts/install-node.sh${NETRAL}"
fi

# 4. Cek NPM
echo -n "Memeriksa NPM... "
if command -v npm >/dev/null 2>&1; then
    NPM_VER=$(npm -v)
    echo -e "${HIJAU}OK ($NPM_VER)${NETRAL}"
else
    echo -e "${MERAH}ERROR: NPM tidak terdeteksi.${NETRAL}"
fi

# 5. Cek Git
echo -n "Memeriksa Git... "
if command -v git >/dev/null 2>&1; then
    GIT_VER=$(git --version | awk '{print $3}')
    echo -e "${HIJAU}OK ($GIT_VER)${NETRAL}"
else
    echo -e "${KUNING}Peringatan: Git tidak terdeteksi.${NETRAL}"
fi

# 6. Cek Konfigurasi Groq API Key di .env
echo -n "Memeriksa GROQ_API_KEY... "
if [ -f ".env" ]; then
    if grep -E -q "^GROQ_API_KEY=gsk_[A-Za-z0-9]+" ".env"; then
        echo -e "${HIJAU}OK (Terdeteksi)${NETRAL}"
    else
        echo -e "${MERAH}ERROR: GROQ_API_KEY belum dikonfigurasi dengan benar di file .env (harus diawali 'gsk_').${NETRAL}"
    fi
else
    echo -e "${KUNING}Peringatan: File .env tidak ditemukan, dilewati.${NETRAL}"
fi

# 7. Cek File .env
echo -n "Memeriksa file konfigurasi .env... "
if [ -f ".env" ]; then
    echo -e "${HIJAU}OK (Tersedia)${NETRAL}"
else
    echo -e "${MERAH}ERROR: File .env tidak ditemukan. Salin .env.example menjadi .env lalu konfigurasikan.${NETRAL}"
fi

echo -e "${KUNING}===================================================${NETRAL}"
echo -e "Selesai melakukan pengecekan."
