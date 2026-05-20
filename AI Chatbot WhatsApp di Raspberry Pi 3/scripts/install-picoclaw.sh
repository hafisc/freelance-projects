#!/bin/bash
# ============================================================
# Script instalasi PicoClaw CLI untuk ARM64 (Raspberry Pi OS 64-bit)
# Download release terbaru dan install ke /usr/local/bin
# ============================================================

echo "============================================"
echo "  Instalasi PicoClaw CLI"
echo "============================================"
echo ""

# --- Cek apakah dijalankan sebagai root/sudo ---
if [ "$EUID" -ne 0 ]; then
    echo "❌ Script ini membutuhkan akses root/sudo."
    echo "   Jalankan: sudo bash scripts/install-picoclaw.sh"
    exit 1
fi

# --- Cek arsitektur ---
ARCH=$(uname -m)
echo "📋 Arsitektur sistem: $ARCH"

if [ "$ARCH" = "aarch64" ]; then
    PLATFORM="linux-arm64"
elif [ "$ARCH" = "x86_64" ]; then
    PLATFORM="linux-amd64"
else
    echo "❌ Arsitektur $ARCH tidak didukung."
    echo "   PicoClaw membutuhkan ARM64 (aarch64) atau x86_64."
    exit 1
fi

echo "   Platform target: $PLATFORM"
echo ""

# --- Konfigurasi ---
INSTALL_DIR="/usr/local/bin"
TMP_DIR=$(mktemp -d)
PICOCLAW_URL="https://github.com/nicepkg/picoclaw/releases/latest/download/picoclaw-${PLATFORM}.tar.gz"

echo "📦 Memulai instalasi PicoClaw..."
echo ""

# --- Download release terbaru ---
echo "1️⃣  Mendownload PicoClaw dari GitHub..."
echo "   URL: $PICOCLAW_URL"
curl -fsSL "$PICOCLAW_URL" -o "$TMP_DIR/picoclaw.tar.gz"
if [ $? -ne 0 ]; then
    echo "❌ Gagal mendownload PicoClaw."
    echo "   Troubleshooting:"
    echo "   - Pastikan koneksi internet tersedia"
    echo "   - Cek URL release di: https://github.com/nicepkg/picoclaw/releases"
    echo "   - Jika nama file berbeda, download manual dan copy ke $INSTALL_DIR"
    rm -rf "$TMP_DIR"
    exit 1
fi

# --- Extract archive ---
echo "2️⃣  Mengekstrak archive..."
tar -xzf "$TMP_DIR/picoclaw.tar.gz" -C "$TMP_DIR"
if [ $? -ne 0 ]; then
    echo "❌ Gagal mengekstrak archive."
    echo "   File mungkin corrupt. Coba download ulang."
    rm -rf "$TMP_DIR"
    exit 1
fi

# --- Install binary ---
echo "3️⃣  Menginstall binary ke $INSTALL_DIR..."

# Cari file binary picoclaw di folder extract
PICOCLAW_BIN=$(find "$TMP_DIR" -name "picoclaw" -type f | head -1)
if [ -z "$PICOCLAW_BIN" ]; then
    echo "⚠️  Binary 'picoclaw' tidak ditemukan di archive."
    echo "   Isi archive:"
    ls -la "$TMP_DIR"
    echo ""
    echo "   Catatan: Nama file binary mungkin berbeda."
    echo "   Silakan cek isi archive dan copy manual ke $INSTALL_DIR"
    rm -rf "$TMP_DIR"
    exit 1
fi

# Copy binary ke install directory
cp "$PICOCLAW_BIN" "$INSTALL_DIR/picoclaw"
chmod +x "$INSTALL_DIR/picoclaw"

# Cek apakah ada picoclaw-launcher
LAUNCHER_BIN=$(find "$TMP_DIR" -name "picoclaw-launcher" -type f | head -1)
if [ -n "$LAUNCHER_BIN" ]; then
    echo "   Ditemukan picoclaw-launcher, menginstall juga..."
    cp "$LAUNCHER_BIN" "$INSTALL_DIR/picoclaw-launcher"
    chmod +x "$INSTALL_DIR/picoclaw-launcher"
fi

# --- Cleanup ---
echo "4️⃣  Membersihkan file sementara..."
rm -rf "$TMP_DIR"

# --- Verifikasi ---
echo "5️⃣  Verifikasi instalasi..."
if [ -x "$INSTALL_DIR/picoclaw" ]; then
    echo ""
    echo "   Menjalankan: picoclaw --help"
    echo "   ---"
    "$INSTALL_DIR/picoclaw" --help 2>&1 | head -10
    echo "   ---"
    echo ""
    echo "============================================"
    echo "  ✅ PicoClaw berhasil diinstall!"
    echo "  Path: $INSTALL_DIR/picoclaw"
    echo ""
    echo "  Langkah selanjutnya:"
    echo "  1. Konfigurasi Gemini API key:"
    echo "     picoclaw config set gemini_api_key YOUR_API_KEY"
    echo "  2. Test PicoClaw:"
    echo "     picoclaw agent -m \"Halo, apa kabar?\""
    echo "============================================"
else
    echo "❌ Verifikasi gagal. Binary tidak executable."
    exit 1
fi
