# WhatsApp AI Chatbot - Raspberry Pi 3

Chatbot WhatsApp berbasis AI yang berjalan di Raspberry Pi 3 menggunakan **Baileys** (WhatsApp Web API), **PicoClaw CLI** (AI Agent), dan **Gemini API** (melalui konfigurasi PicoClaw).

> ⚠️ **Disclaimer:** Project ini hanya untuk penggunaan personal/internal/prototype. Tidak ditujukan untuk penggunaan komersial, broadcast massal, atau automated outreach. Hanya gunakan dengan kontak yang sudah memberikan izin.

---

## Kebutuhan Hardware

- Raspberry Pi 3 Model B/B+ (atau lebih baru)
- MicroSD Card minimal 16GB
- Koneksi internet (WiFi atau Ethernet)
- Power supply yang stabil

## Kebutuhan Software

| Software | Versi Minimum | Keterangan |
|----------|---------------|------------|
| OS | Raspberry Pi OS Lite 64-bit | Atau Debian/Ubuntu server |
| Node.js | 20 LTS | ES Module support |
| npm | Bundled dengan Node.js | Package manager |
| PicoClaw CLI | Latest | AI agent CLI |
| Git | Any | Version control |

---

## Cara Cek Environment

Jalankan script pengecekan untuk memastikan semua dependency tersedia:

```bash
npm run check
```

Atau langsung:

```bash
bash scripts/check-env.sh
```

Script akan mengecek: OS, arsitektur, Node.js, npm, Git, PicoClaw, file .env, dan folder project.

---

## Cara Install Node.js

Jika Node.js belum terinstall atau versi lama:

```bash
sudo bash scripts/install-node.sh
```

Script akan:
1. Mengupdate package list
2. Menginstall curl, git, build-essential
3. Menambahkan NodeSource repository
4. Menginstall Node.js 20 LTS
5. Memverifikasi instalasi

---

## Cara Install PicoClaw

```bash
sudo bash scripts/install-picoclaw.sh
```

Script akan mendownload dan menginstall PicoClaw CLI untuk arsitektur ARM64.

---

## Cara Konfigurasi Gemini API di PicoClaw

Setelah PicoClaw terinstall, konfigurasi API key Gemini:

```bash
picoclaw config set gemini_api_key YOUR_GEMINI_API_KEY
```

Test apakah PicoClaw berfungsi:

```bash
picoclaw agent -m "Halo, apa kabar?"
```

Jika mendapat respons dari AI, konfigurasi berhasil.

> Dapatkan Gemini API key di: https://aistudio.google.com/app/apikey

---

## Cara Clone/Upload Project

**Clone dari repository:**

```bash
git clone <repository-url> wa-ai-raspi-chatbot
cd wa-ai-raspi-chatbot
```

**Atau upload manual:**

Upload folder project ke Raspberry Pi menggunakan SCP/SFTP:

```bash
scp -r wa-ai-raspi-chatbot/ pi@<ip-raspberry>:/home/pi/apps/
```

---

## Cara Membuat .env

```bash
cp .env.example .env
nano .env
```

Sesuaikan konfigurasi sesuai kebutuhan, lalu set permission:

```bash
chmod 600 .env
```

### Daftar Environment Variables

| Variable | Default | Keterangan |
|----------|---------|------------|
| `COMMAND_PREFIX` | `!ai` | Prefix command untuk trigger bot |
| `MAX_CHARS` | `1500` | Batas maksimal karakter input user |
| `MAX_REPLY_CHARS` | `3500` | Batas maksimal karakter balasan per segmen |
| `PICOCLAW_BIN` | `/usr/local/bin/picoclaw` | Path binary PicoClaw CLI |
| `BAILEYS_AUTH_DIR` | `./auth_info_baileys` | Folder penyimpanan session WhatsApp |
| `ALLOWED_NUMBERS` | _(kosong)_ | Daftar nomor yang diizinkan (pisah koma, format: 6281234567890). Kosong = semua boleh |
| `BOT_NAME` | `AI WhatsApp Assistant` | Nama bot untuk logging |
| `LOG_LEVEL` | `info` | Level logging: fatal, error, warn, info, debug, trace |
| `PICOCLAW_TIMEOUT_MS` | `120000` | Timeout eksekusi PicoClaw (milidetik) |

---

## Cara Install Dependency

```bash
npm install
```

---

## Cara Menjalankan Bot Pertama Kali

```bash
npm start
```

Terminal akan menampilkan QR code. Scan QR tersebut dari WhatsApp di HP.

---

## Cara Scan QR WhatsApp Linked Device

1. Jalankan bot: `npm start`
2. Tunggu QR code muncul di terminal
3. Buka WhatsApp di HP
4. Pergi ke **Settings > Linked Devices > Link a Device**
5. Scan QR code yang tampil di terminal
6. Tunggu hingga muncul log "WhatsApp bot berhasil terhubung"

> Setelah scan pertama berhasil, restart berikutnya tidak perlu scan QR lagi selama session masih valid.

---

## Cara Test Command WhatsApp

Setelah bot terhubung, kirim pesan dari HP (atau nomor lain yang ada di whitelist):

**Contoh 1 - Pertanyaan umum:**
```
!ai halo, apa kabar?
```
Bot akan membalas dengan respons AI.

**Contoh 2 - Pertanyaan teknis:**
```
!ai jelaskan apa itu preventive maintenance
```
Bot akan membalas dengan penjelasan dari AI.

**Contoh 3 - Tanpa pertanyaan:**
```
!ai
```
Bot akan membalas dengan petunjuk penggunaan.

---

## Cara Setup Systemd

Agar bot otomatis berjalan saat Raspberry Pi dinyalakan:

### 1. Copy service file

```bash
sudo cp systemd/wa-ai-chatbot.service.example /etc/systemd/system/wa-ai-chatbot.service
```

### 2. Edit service file (sesuaikan path dan user)

```bash
sudo nano /etc/systemd/system/wa-ai-chatbot.service
```

Yang perlu disesuaikan:
- `User=pi` → ganti dengan username Raspberry Pi Anda
- `WorkingDirectory=/home/pi/apps/wa-ai-raspi-chatbot` → ganti dengan lokasi project
- `ExecStart=/usr/bin/npm start` → cek path npm dengan `which npm`

### 3. Reload systemd

```bash
sudo systemctl daemon-reload
```

### 4. Enable service (auto-start saat boot)

```bash
sudo systemctl enable wa-ai-chatbot
```

### 5. Start service

```bash
sudo systemctl start wa-ai-chatbot
```

---

## Cara Start, Stop, Restart Service

```bash
# Start service
sudo systemctl start wa-ai-chatbot

# Stop service
sudo systemctl stop wa-ai-chatbot

# Restart service
sudo systemctl restart wa-ai-chatbot

# Cek status
sudo systemctl status wa-ai-chatbot
```

---

## Cara Melihat Log

```bash
# Log realtime (follow)
journalctl -u wa-ai-chatbot -f

# Log 100 baris terakhir
journalctl -u wa-ai-chatbot -n 100

# Log hari ini
journalctl -u wa-ai-chatbot --since today
```

---

## Troubleshooting

### QR Code Tidak Muncul

**Gejala:** Bot berjalan tapi QR tidak tampil di terminal.

**Penyebab:** Session lama masih tersimpan tapi sudah expired/corrupt.

**Solusi:**
```bash
rm -rf auth_info_baileys/
npm start
```

### Koneksi Sering Terputus

**Gejala:** Bot sering disconnect dan reconnect.

**Penyebab:** Koneksi internet tidak stabil atau WhatsApp membatasi koneksi.

**Solusi:**
1. Pastikan koneksi internet stabil
2. Cek apakah HP (device utama) masih online
3. Jangan gunakan akun WhatsApp yang sama di bot lain
4. Restart bot: `sudo systemctl restart wa-ai-chatbot`

### PicoClaw Error / Tidak Merespons

**Gejala:** Bot membalas "AI sedang error" atau timeout.

**Penyebab:** PicoClaw tidak terinstall, API key belum dikonfigurasi, atau timeout.

**Solusi:**
1. Cek PicoClaw terinstall: `which picoclaw`
2. Test PicoClaw manual: `picoclaw agent -m "test"`
3. Cek API key: `picoclaw config get gemini_api_key`
4. Jika timeout, naikkan `PICOCLAW_TIMEOUT_MS` di .env

### Bot Tidak Merespons Pesan

**Gejala:** Pesan dikirim tapi bot tidak membalas.

**Penyebab:** Nomor tidak ada di whitelist, prefix salah, atau bot crash.

**Solusi:**
1. Cek apakah nomor ada di `ALLOWED_NUMBERS` (atau kosongkan untuk testing)
2. Pastikan pesan diawali prefix yang benar (default: `!ai`)
3. Cek status bot: `sudo systemctl status wa-ai-chatbot`
4. Cek log: `journalctl -u wa-ai-chatbot -n 50`

### Permission Denied saat Start

**Gejala:** Error permission saat menjalankan bot.

**Solusi:**
```bash
# Fix permission folder project
chown -R pi:pi /home/pi/apps/wa-ai-raspi-chatbot

# Fix permission .env
chmod 600 .env

# Fix permission auth folder
chmod 700 auth_info_baileys/
```

---

## Catatan Keamanan dan Batasan Penggunaan

1. **Personal use only** - Project ini hanya untuk chatbot personal/internal/prototype
2. **Tidak ada fitur spam** - Tidak ada broadcast, bulk message, atau auto-message
3. **Tidak ada scraping** - Tidak ada fitur scraping kontak atau data
4. **Whitelist** - Gunakan fitur whitelist untuk membatasi akses
5. **Jangan share .env** - File .env berisi konfigurasi sensitif
6. **Jangan commit auth_info_baileys** - Folder ini berisi session WhatsApp
7. **Gunakan dengan bijak** - Hormati Terms of Service WhatsApp
8. **Risiko ban** - Penggunaan unofficial API memiliki risiko akun dibatasi oleh WhatsApp

---

## Struktur Project

```
wa-ai-raspi-chatbot/
├── package.json            # Konfigurasi project dan dependencies
├── .env.example            # Template konfigurasi environment
├── .gitignore              # File yang diabaikan Git
├── README.md               # Dokumentasi ini
├── index.js                # Entry point utama
├── src/
│   ├── config/
│   │   └── env.js          # Baca dan validasi konfigurasi .env
│   ├── bot/
│   │   ├── whatsapp.js     # Koneksi Baileys, QR, session, reconnect
│   │   └── handlers.js     # Logic pemrosesan pesan masuk
│   ├── services/
│   │   └── picoclaw.service.js  # Panggil PicoClaw CLI
│   ├── utils/
│   │   ├── logger.js       # Logger dengan pino
│   │   ├── message.js      # Ambil teks pesan & split pesan panjang
│   │   ├── whitelist.js    # Validasi whitelist nomor
│   │   └── validation.js   # Validasi input user
│   └── constants/
│       └── app.constant.js # Konstanta default aplikasi
├── scripts/
│   ├── check-env.sh        # Cek environment
│   ├── install-node.sh     # Install Node.js 20
│   └── install-picoclaw.sh # Install PicoClaw CLI
├── systemd/
│   └── wa-ai-chatbot.service.example  # Template systemd service
├── auth_info_baileys/      # Session WhatsApp (jangan commit)
└── logs/                   # Folder log
```

---

## Lisensi

MIT - Gunakan dengan bijak dan bertanggung jawab.
