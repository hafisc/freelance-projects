#!/bin/bash
# ============================================================
# Script pengecekan environment untuk WhatsApp AI Chatbot
# Mengecek semua dependency yang dibutuhkan sebelum menjalankan bot
# ============================================================

echo "============================================"
echo "  Pengecekan Environment - WA AI Chatbot"
echo "============================================"
echo ""

ERRORS=0

# --- Informasi OS ---
echo "📋 Informasi Sistem:"
echo "   OS        : $(cat /etc/os-release 2>/dev/null | grep PRETTY_NAME | cut -d= -f2 | tr -d '"' || echo 'Tidak diketahui')"
echo "   Kernel    : $(uname -r)"
echo "   Arsitektur: $(uname -m)"
echo ""

# --- Cek Node.js ---
echo "🔍 Mengecek Node.js..."
if command -v node &> /dev/null; then
    NODE_VERSION=$(node -v)
    NODE_MAJOR=$(echo "$NODE_VERSION" | cut -d. -f1 | tr -d 'v')
    if [ "$NODE_MAJOR" -ge 20 ]; then
        echo "   ✅ Node.js $NODE_VERSION (OK)"
    else
        echo "   ❌ Node.js $NODE_VERSION (Minimal versi 20 diperlukan)"
        echo "      → Jalankan: bash scripts/install-node.sh"
        ERRORS=$((ERRORS + 1))
    fi
else
    echo "   ❌ Node.js tidak ditemukan"
    echo "      → Jalankan: bash scripts/install-node.sh"
    ERRORS=$((ERRORS + 1))
fi

# --- Cek npm ---
echo "🔍 Mengecek npm..."
if command -v npm &> /dev/null; then
    NPM_VERSION=$(npm -v)
    echo "   ✅ npm v$NPM_VERSION (OK)"
else
    echo "   ❌ npm tidak ditemukan"
    echo "      → npm biasanya terinstall bersama Node.js"
    ERRORS=$((ERRORS + 1))
fi

# --- Cek Git ---
echo "🔍 Mengecek Git..."
if command -v git &> /dev/null; then
    GIT_VERSION=$(git --version | awk '{print $3}')
    echo "   ✅ Git v$GIT_VERSION (OK)"
else
    echo "   ❌ Git tidak ditemukan"
    echo "      → Jalankan: sudo apt install git"
    ERRORS=$((ERRORS + 1))
fi

# --- Cek PicoClaw ---
echo "🔍 Mengecek PicoClaw CLI..."
PICOCLAW_PATH="${PICOCLAW_BIN:-/usr/local/bin/picoclaw}"
if [ -x "$PICOCLAW_PATH" ]; then
    echo "   ✅ PicoClaw ditemukan di $PICOCLAW_PATH (OK)"
else
    if [ -f "$PICOCLAW_PATH" ]; then
        echo "   ❌ PicoClaw ditemukan tapi tidak executable"
        echo "      → Jalankan: sudo chmod +x $PICOCLAW_PATH"
    else
        echo "   ❌ PicoClaw tidak ditemukan di $PICOCLAW_PATH"
        echo "      → Jalankan: bash scripts/install-picoclaw.sh"
    fi
    ERRORS=$((ERRORS + 1))
fi

# --- Cek folder project ---
echo "🔍 Mengecek folder project..."
if [ -f "package.json" ]; then
    echo "   ✅ package.json ditemukan (OK)"
else
    echo "   ❌ package.json tidak ditemukan"
    echo "      → Pastikan Anda berada di folder project"
    ERRORS=$((ERRORS + 1))
fi

# --- Cek file .env ---
echo "🔍 Mengecek file .env..."
if [ -f ".env" ]; then
    echo "   ✅ File .env ditemukan (OK)"

    # Cek permission .env
    PERM=$(stat -c "%a" .env 2>/dev/null || stat -f "%Lp" .env 2>/dev/null)
    if [ "$PERM" = "600" ]; then
        echo "   ✅ Permission .env: $PERM (OK)"
    else
        echo "   ⚠️  Permission .env: $PERM (Disarankan 600)"
        echo "      → Jalankan: chmod 600 .env"
    fi
else
    echo "   ❌ File .env tidak ditemukan"
    echo "      → Jalankan: cp .env.example .env && nano .env"
    ERRORS=$((ERRORS + 1))
fi

# --- Cek node_modules ---
echo "🔍 Mengecek node_modules..."
if [ -d "node_modules" ]; then
    echo "   ✅ node_modules ditemukan (OK)"
else
    echo "   ⚠️  node_modules belum ada"
    echo "      → Jalankan: npm install"
fi

echo ""
echo "============================================"
if [ $ERRORS -eq 0 ]; then
    echo "  ✅ Semua pengecekan BERHASIL!"
    echo "  Bot siap dijalankan dengan: npm start"
else
    echo "  ❌ Ditemukan $ERRORS masalah."
    echo "  Perbaiki masalah di atas sebelum menjalankan bot."
fi
echo "============================================"

exit $ERRORS
