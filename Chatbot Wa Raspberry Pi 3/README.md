# WhatsApp AI Chatbot - Raspberry Pi 3 + Groq API + Baileys

Aplikasi AI Chatbot WhatsApp ringan dan stabil yang dirancang untuk berjalan 24/7 di **Raspberry Pi 3** (atau server Linux sejenis). Bot ini menggunakan **Baileys** untuk koneksi WhatsApp Web dan **Groq API** sebagai model AI provider secara langsung dari runtime Node.js.

---

## Fitur Utama

- **Command Prefix**: Hanya merespons pesan yang diawali dengan prefix (default: `!ai`).
- **Whitelist Nomor**: Membatasi akses chatbot hanya untuk nomor-nomor tertentu demi keamanan.
- **Penyimpanan Sesi (Session Store)**: Menyimpan kredensial login WhatsApp agar bot tidak perlu melakukan scan QR ulang setelah restart.
- **Auto Reconnect**: Otomatis menyambungkan kembali jika koneksi internet terputus.
- **Anti Double Request (Active Job)**: Mencegah user mengirimkan pertanyaan beruntun secara bersamaan ketika pertanyaan sebelumnya masih diproses.
- **Validasi Panjang Input/Output**: Batasan karakter input user dan chunking otomatis untuk respons AI yang panjang.
- **Daemon systemd**: Konfigurasi siap pakai agar bot berjalan otomatis ketika Raspberry Pi dinyalakan.

---

## Kebutuhan Sistem

### Hardware
- **Raspberry Pi 3** (Model B/B+ atau lebih baru).
- MicroSD Card minimal 8GB (direkomendasikan Class 10).
- Koneksi internet stabil.

### Software
- **OS**: Raspberry Pi OS (direkomendasikan 64-bit Lite) / Debian / Ubuntu Server.
- **Node.js**: Versi 20 LTS atau lebih baru.

---

## Struktur Folder Project

```txt
wa-ai-raspi-chatbot/
├── package.json
├── package-lock.json
├── .env.example
├── .gitignore
├── README.md
├── index.js
├── src/
│   ├── config/
│   │   └── env.js
│   ├── bot/
│   │   ├── whatsapp.js
│   │   └── handlers.js
│   ├── services/
│   │   └── picoclaw.service.js
│   ├── utils/
│   │   ├── logger.js
│   │   ├── message.js
│   │   ├── whitelist.js
│   │   └── validation.js
│   └── constants/
│       └── app.constant.js
├── scripts/
│   ├── check-env.sh
│   ├── install-node.sh
│   └── install-picoclaw.sh
├── systemd/
│   └── wa-ai-chatbot.service.example
├── auth_info_baileys/
│   └── .gitkeep
└── logs/
    └── .gitkeep
```

---

## Langkah Instalasi & Setup

### 1. Pengecekan Awal Environment
Jalankan script helper berikut untuk memeriksa kesiapan OS dan dependensi pada Raspberry Pi Anda:
```bash
# Memberikan izin eksekusi pada script helper
chmod +x scripts/*.sh

# Menjalankan pengecekan
bash scripts/check-env.sh
```

### 2. Instalasi Node.js 20 LTS
Jika hasil pengecekan menunjukkan Node.js belum terinstal atau versinya di bawah 20, jalankan installer:
```bash
bash scripts/install-node.sh
```

### 3. Setup File Environment (.env)
Salin file template `.env.example` menjadi `.env` dan masukkan API Key Groq Anda:
```bash
cp .env.example .env
```
Isi dari `.env` dapat dikonfigurasi sebagai berikut:
```env
COMMAND_PREFIX=!ai
MAX_CHARS=1500
MAX_REPLY_CHARS=3500
GROQ_API_KEY=gsk_YourGroqApiKeyHere
GROQ_MODEL=llama-3.3-70b-versatile
BAILEYS_AUTH_DIR=./auth_info_baileys
ALLOWED_NUMBERS=6281234567890,6289876543210
BOT_NAME=AI WhatsApp Assistant
LOG_LEVEL=info
GROQ_TIMEOUT_MS=120000
```
> [!IMPORTANT]
> - `GROQ_API_KEY`: Masukkan API Key Groq Anda (diawali dengan `gsk_`).
> - `ALLOWED_NUMBERS`: Masukkan daftar nomor telepon pengirim yang diizinkan menggunakan bot (pisahkan dengan koma, awali dengan kode negara tanpa tanda `+`, contoh: `6281234567890`). Jika dikosongkan, semua nomor diperbolehkan memakai bot (berguna untuk testing).

Keamanan file `.env` di Linux dapat ditingkatkan dengan membatasi izin baca:
```bash
chmod 600 .env
```

### 4. Instalasi Dependensi Node.js
```bash
npm install
```

---

## Cara Menjalankan Bot & Scan QR Code

1. Jalankan bot secara manual terlebih dahulu untuk melakukan scan QR Code:
   ```bash
   npm start
   ```
2. QR Code akan muncul langsung di terminal.
3. Buka WhatsApp di HP Anda -> ketuk **Titik Tiga (Opsi)** atau **Pengaturan** -> pilih **Perangkat Tertaut (Linked Devices)** -> ketuk **Tautkan Perangkat (Link a Device)**.
4. Arahkan kamera HP Anda ke QR Code yang tampil di terminal.
5. Sesi akan tersimpan di dalam folder `auth_info_baileys/`. Setelah terhubung, bot akan merespons pesan secara real-time.

---

## Cara Penggunaan Chatbot

Kirim pesan ke nomor WhatsApp bot dengan prefix `!ai` diikuti pertanyaan Anda.

**Format:**
```txt
!ai <pertanyaan>
```

**Contoh:**
```txt
!ai Jelaskan prinsip dasar MQTT pada IoT
```

---

## Setup Auto-Start menggunakan systemd (24/7)

Agar bot otomatis menyala kembali ketika Raspberry Pi dinyalakan atau restart, Anda dapat menjadikannya sebagai background service systemd:

1. Salin file contoh service ke folder systemd sistem Linux:
   ```bash
   sudo cp systemd/wa-ai-chatbot.service.example /etc/systemd/system/wa-ai-chatbot.service
   ```
2. Edit file service tersebut untuk menyesuaikan username (`pi`), WorkingDirectory, dan path npm:
   ```bash
   sudo nano /etc/systemd/system/wa-ai-chatbot.service
   ```
3. Lakukan daemon-reload dan aktifkan service:
   ```bash
   sudo systemctl daemon-reload
   sudo systemctl enable wa-ai-chatbot.service
   ```
4. Jalankan service:
   ```bash
   sudo systemctl start wa-ai-chatbot.service
   ```
5. Untuk memeriksa status running:
   ```bash
   sudo systemctl status wa-ai-chatbot.service
   ```
6. Untuk melihat log aktivitas chatbot secara real-time:
   ```bash
   journalctl -u wa-ai-chatbot.service -f
   ```

---

## Troubleshooting (Penanganan Masalah)

### 1. QR Code Tidak Muncul saat Menjalankan systemd Service
Hal ini wajar terjadi karena systemd service berjalan di background.
**Solusi:**
- Hentikan service: `sudo systemctl stop wa-ai-chatbot.service`.
- Jalankan manual: `npm start`.
- Lakukan scan QR. Setelah berhasil terhubung dan session tersimpan, matikan proses manual (`Ctrl+C`).
- Jalankan kembali service systemd: `sudo systemctl start wa-ai-chatbot.service`.

### 2. Koneksi Terputus / Tidak Merespons
- Periksa log realtime menggunakan perintah `journalctl -u wa-ai-chatbot.service -f`.
- Jika log menampilkan error logged out / sesi berakhir, hapus folder session: `rm -rf auth_info_baileys/` lalu ulangi langkah scan QR.

### 3. Groq API Error
- Periksa apakah `GROQ_API_KEY` di file `.env` sudah benar dan aktif.
- Periksa log realtime untuk detail status code API. Jika request timeout, coba tingkatkan `GROQ_TIMEOUT_MS` di file `.env`.

---

## Catatan Keamanan & Batasan

- **Keamanan Sesi**: Jangan membagikan isi folder `auth_info_baileys/` karena berisi kunci enkripsi sesi WhatsApp Anda. Folder ini sudah didaftarkan di `.gitignore`.
- **Ketentuan WhatsApp**: Bot ini menggunakan library tidak resmi Baileys. Gunakan hanya untuk kebutuhan personal, internal, atau prototype demi menghindari pemblokiran akun oleh WhatsApp. Dilarang keras menggunakan bot ini untuk aktivitas spamming massal atau broadcast yang mengganggu.
