# WhatsApp AI Chatbot - Raspberry Pi 3 + Groq API + Baileys

Aplikasi AI Chatbot WhatsApp ringan dan stabil yang dirancang untuk berjalan 24/7 di **Raspberry Pi 3** (atau server Linux sejenis). Bot ini menggunakan **Baileys** untuk koneksi WhatsApp Web dan **Groq API** sebagai model AI provider secara langsung dari runtime Node.js.

---

## Gambaran Umum Cara Kerja

Raspberry Pi berperan sebagai **mini server lokal** yang menjalankan bot WhatsApp secara terus-menerus (24/7). Konsepnya mirip VPS (server sewaan di internet), tapi menggunakan perangkat fisik milik Anda sendiri.

```
┌─────────────────────────────────────────────────────────────┐
│                    ALUR KERJA BOT                           │
│                                                             │
│   Laptop/PC (Anda)                                          │
│       │                                                     │
│       │  Upload project via SSH/SCP                         │
│       ▼                                                     │
│   Raspberry Pi 3  ◄── Mini server lokal (nyala 24/7)        │
│       │                                                     │
│       │  npm install + npm start                            │
│       ▼                                                     │
│   Bot WhatsApp Aktif                                        │
│       │                                                     │
│       │  Scan QR Code dari HP                               │
│       ▼                                                     │
│   WhatsApp Terhubung                                        │
│       │                                                     │
│       │  User kirim pesan "!ai ..."                         │
│       ▼                                                     │
│   Groq AI memproses ──► Balasan otomatis ke WhatsApp        │
└─────────────────────────────────────────────────────────────┘
```

**Penjelasan singkat:**
- **Raspberry Pi** = tempat bot dijalankan (bukan laptop Anda).
- **SSH/SCP** = cara mengakses dan mengirim file ke Raspberry Pi dari laptop melalui jaringan WiFi/LAN.
- **API Key Groq** = kunci untuk mengakses layanan AI (untuk memproses pertanyaan user).
- **Baileys** = library Node.js untuk menghubungkan bot ke WhatsApp Web.

---

## Fitur Utama

- **Command Prefix**: Hanya merespons pesan yang diawali dengan prefix (default: `!ai`).
- **Whitelist Nomor**: Membatasi akses chatbot hanya untuk nomor-nomor tertentu demi keamanan.
- **Penyimpanan Sesi (Session Store)**: Menyimpan kredensial login WhatsApp agar bot tidak perlu melakukan scan QR ulang setelah restart.
- **Auto Reconnect**: Otomatis menyambungkan kembali jika koneksi internet terputus.
- **Auto Recovery Session**: Jika sesi WhatsApp expired atau logout, bot otomatis menghapus session lama dan menampilkan QR Code baru tanpa perlu restart manual.
- **Anti Double Request (Active Job)**: Mencegah user mengirimkan pertanyaan beruntun secara bersamaan ketika pertanyaan sebelumnya masih diproses.
- **Validasi Panjang Input/Output**: Batasan karakter input user dan chunking otomatis untuk respons AI yang panjang.
- **Daemon systemd**: Konfigurasi siap pakai agar bot berjalan otomatis ketika Raspberry Pi dinyalakan.

---

## Kebutuhan Sistem

### Hardware
- **Raspberry Pi 3** (Model B/B+ atau lebih baru).
- MicroSD Card minimal 8GB (direkomendasikan Class 10).
- Adaptor daya Micro USB 5V/2.5A.
- Koneksi internet stabil (WiFi atau kabel LAN).
- Laptop/PC untuk mengakses Raspberry Pi (hanya saat setup awal).

### Software di Raspberry Pi
- **OS**: Raspberry Pi OS (direkomendasikan 64-bit Lite) / Debian / Ubuntu Server.
- **Node.js**: Versi 20 LTS atau lebih baru.
- **SSH**: Harus diaktifkan di Raspberry Pi.

### Software di Laptop/PC Anda
- **Terminal SSH**: PowerShell (Windows 10+), Terminal (macOS/Linux), atau [PuTTY](https://putty.org/).
- **SCP**: Sudah tersedia bawaan di Windows 10+, macOS, dan Linux.

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

## Tahap 1: Persiapan Raspberry Pi

> [!IMPORTANT]
> Tahap ini hanya perlu dilakukan **sekali** saat pertama kali setup.

### 1.1 Install OS di Raspberry Pi

1. Download dan install [Raspberry Pi Imager](https://www.raspberrypi.com/software/) di laptop Anda.
2. Masukkan MicroSD Card ke laptop.
3. Buka Raspberry Pi Imager, pilih:
   - **Device**: Raspberry Pi 3
   - **OS**: Raspberry Pi OS (64-bit Lite) — *versi tanpa desktop, lebih ringan*
   - **Storage**: MicroSD Card Anda
4. Klik ikon **⚙️ (gear/settings)** sebelum klik "Write" untuk mengatur:
   - ✅ **Set hostname**: `raspberrypi` (atau nama lain yang Anda inginkan)
   - ✅ **Enable SSH**: Pilih "Use password authentication"
   - ✅ **Set username and password**: Username: `pi`, Password: *(buat password Anda sendiri)*
   - ✅ **Configure wireless LAN**: Masukkan nama WiFi (SSID) dan password WiFi Anda
5. Klik **Write** dan tunggu hingga selesai.
6. Cabut MicroSD, pasang ke Raspberry Pi, lalu nyalakan Raspberry Pi.

### 1.2 Cari Tahu IP Address Raspberry Pi

Raspberry Pi perlu beberapa menit untuk booting pertama kali. Setelah itu, cari IP-nya:

**Cara 1 — Dari Router WiFi:**
- Buka halaman admin router (biasanya `192.168.1.1` atau `192.168.0.1` di browser).
- Cari perangkat bernama `raspberrypi` di daftar perangkat terhubung.
- Catat IP-nya (contoh: `192.168.1.50`).

**Cara 2 — Pakai Command Prompt/PowerShell (Windows):**
```powershell
ping raspberrypi.local
```
Jika berhasil, akan muncul IP address-nya.

**Cara 3 — Pakai Aplikasi Scanner:**
- Download [Fing](https://www.fing.com/products/fing-app) di HP, scan jaringan WiFi, cari perangkat Raspberry Pi.

### 1.3 Akses Raspberry Pi via SSH

Buka **PowerShell** (Windows) atau **Terminal** (macOS/Linux), lalu ketik:

```bash
ssh pi@IP_RASPBERRY_PI_ANDA
```

**Contoh:**
```bash
ssh pi@192.168.1.50
```

- Jika muncul pertanyaan `Are you sure you want to continue connecting?`, ketik `yes` lalu Enter.
- Masukkan password yang Anda buat saat install OS di langkah 1.1.
- Jika berhasil, Anda akan melihat terminal Raspberry Pi:
  ```
  pi@raspberrypi:~ $
  ```

> [!TIP]
> Mulai dari sini, **semua perintah diketik di terminal Raspberry Pi** (yang sudah terhubung via SSH), bukan di laptop Anda.

---

## Tahap 2: Upload Project ke Raspberry Pi

### 2.1 Buat Folder di Raspberry Pi

Di terminal SSH Raspberry Pi, jalankan:
```bash
mkdir -p ~/apps
```

### 2.2 Upload Project dari Laptop ke Raspberry Pi

**Buka terminal/PowerShell BARU** di laptop Anda (jangan tutup terminal SSH yang sudah terhubung). Jalankan perintah berikut:

**Dari Windows (PowerShell):**
```powershell
scp -r "E:\Project\Freelance Projects\Chatbot Wa Raspberry Pi 3" pi@192.168.1.50:/home/pi/apps/wa-ai-chatbot
```

**Dari macOS/Linux (Terminal):**
```bash
scp -r "/path/ke/folder/project" pi@192.168.1.50:/home/pi/apps/wa-ai-chatbot
```

> [!IMPORTANT]
> - Ganti `192.168.1.50` dengan **IP Raspberry Pi Anda** yang didapat di langkah 1.2.
> - Ganti path folder project sesuai lokasi project di laptop Anda.
> - Masukkan password Raspberry Pi saat diminta.

Tunggu hingga proses upload selesai (tergantung kecepatan jaringan).

---

## Tahap 3: Instalasi & Setup di Raspberry Pi

> [!NOTE]
> Semua perintah di tahap ini dijalankan di **terminal SSH Raspberry Pi**.

### 3.1 Masuk ke Folder Project

```bash
cd ~/apps/wa-ai-chatbot
```

### 3.2 Pengecekan Awal Environment

Jalankan script helper untuk memeriksa kesiapan sistem Raspberry Pi:
```bash
chmod +x scripts/*.sh
bash scripts/check-env.sh
```

### 3.3 Instalasi Node.js 20 LTS

Jika hasil pengecekan menunjukkan Node.js belum terinstal atau versinya di bawah 20, jalankan installer:
```bash
bash scripts/install-node.sh
```
Setelah selesai, verifikasi:
```bash
node -v
# Harus menampilkan v20.x.x atau lebih baru
```

### 3.4 Setup File Environment (.env)

Salin file template `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```

Edit file `.env` menggunakan nano:
```bash
nano .env
```

Isi konfigurasi berikut (sesuaikan bagian yang diberi keterangan):
```env
# ==========================================
# Konfigurasi Bot WhatsApp AI
# ==========================================

# --- Bot Settings ---
COMMAND_PREFIX=!ai
BOT_NAME=AI WhatsApp Assistant
ALLOWED_NUMBERS=6281234567890,6289876543210

# --- Input/Output Limits ---
MAX_CHARS=1500
MAX_REPLY_CHARS=3500

# --- Groq AI API ---
GROQ_API_KEY=gsk_MasukkanAPIKeyGroqAnda
GROQ_MODEL=llama-3.3-70b-versatile
GROQ_TIMEOUT_MS=120000

# --- Baileys (WhatsApp Session) ---
BAILEYS_AUTH_DIR=./auth_info_baileys

# --- Logging ---
LOG_LEVEL=info
```

**Cara menyimpan di nano:**
1. Tekan `Ctrl + X`
2. Tekan `Y` (Yes untuk simpan)
3. Tekan `Enter`

> [!IMPORTANT]
> - **`GROQ_API_KEY`**: Masukkan API Key Groq Anda (diawali dengan `gsk_`). Dapatkan di [console.groq.com](https://console.groq.com).
> - **`ALLOWED_NUMBERS`**: Masukkan daftar nomor telepon yang diizinkan menggunakan bot (pisahkan dengan koma, awali dengan kode negara tanpa tanda `+`, contoh: `6281234567890`). Jika dikosongkan, semua nomor diperbolehkan memakai bot (berguna untuk testing).

Amankan file `.env`:
```bash
chmod 600 .env
```

### 3.5 Instalasi Dependensi Node.js

```bash
npm install
```

> [!NOTE]
> Proses ini mungkin memakan waktu 3-10 menit di Raspberry Pi 3. Tunggu hingga selesai.

---

## Tahap 4: Menjalankan Bot & Scan QR Code

### 4.1 Jalankan Bot

Di terminal SSH Raspberry Pi:
```bash
npm start
```

### 4.2 Scan QR Code

1. QR Code akan muncul langsung di terminal.
2. Buka **WhatsApp** di HP Anda.
3. Ketuk **Titik Tiga (⋮)** atau **Pengaturan** → pilih **Perangkat Tertaut (Linked Devices)**.
4. Ketuk **Tautkan Perangkat (Link a Device)**.
5. Arahkan kamera HP Anda ke QR Code yang tampil di terminal SSH.

### 4.3 Verifikasi Bot Berjalan

Setelah scan QR berhasil:
1. Kirim pesan ke nomor WhatsApp bot dari HP lain (atau dari nomor yang ada di whitelist):
   ```
   !ai Halo, apakah bot ini aktif?
   ```
2. Jika bot membalas, berarti **bot sudah berjalan dengan benar**! 🎉

> [!TIP]
> Sesi WhatsApp akan tersimpan di folder `auth_info_baileys/`. Setelah scan QR pertama berhasil, bot **tidak perlu scan QR ulang** meskipun di-restart.

---

## Tahap 5: Setup Auto-Start 24/7 (systemd)

> [!IMPORTANT]
> Tahap ini membuat bot **otomatis menyala** setiap kali Raspberry Pi dinyalakan atau restart, tanpa perlu menjalankan `npm start` secara manual.

### 5.1 Salin File Service

```bash
sudo cp systemd/wa-ai-chatbot.service.example /etc/systemd/system/wa-ai-chatbot.service
```

### 5.2 Edit File Service (Sesuaikan Path)

```bash
sudo nano /etc/systemd/system/wa-ai-chatbot.service
```

Pastikan bagian berikut sudah sesuai:
```ini
[Service]
User=pi
WorkingDirectory=/home/pi/apps/wa-ai-chatbot
ExecStart=/usr/bin/npm start
```

> [!TIP]
> - Jika username Raspberry Pi Anda bukan `pi`, ganti `User=pi` dan path `/home/pi/...` sesuai username Anda.
> - Untuk mengetahui path npm, jalankan `which npm` di terminal.

Simpan file (`Ctrl + X` → `Y` → `Enter`).

### 5.3 Aktifkan Service

```bash
# Reload konfigurasi systemd
sudo systemctl daemon-reload

# Aktifkan agar jalan otomatis saat Raspberry Pi boot
sudo systemctl enable wa-ai-chatbot.service

# Jalankan service sekarang
sudo systemctl start wa-ai-chatbot.service
```

### 5.4 Cek Status Bot

```bash
sudo systemctl status wa-ai-chatbot.service
```

Jika berhasil, akan muncul status **`active (running)`** berwarna hijau.

### 5.5 Lihat Log Aktivitas (Real-time)

```bash
journalctl -u wa-ai-chatbot.service -f
```

Tekan `Ctrl + C` untuk keluar dari tampilan log.

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
!ai Apa itu machine learning?
!ai Buatkan puisi tentang teknologi
```

---

## Perintah-Perintah Berguna

Berikut perintah-perintah yang sering digunakan untuk mengelola bot di Raspberry Pi:

| Kebutuhan | Perintah |
|---|---|
| Akses Raspberry Pi dari laptop | `ssh pi@IP_RASPBERRY_PI` |
| Cek status bot | `sudo systemctl status wa-ai-chatbot.service` |
| Restart bot | `sudo systemctl restart wa-ai-chatbot.service` |
| Stop bot | `sudo systemctl stop wa-ai-chatbot.service` |
| Start bot | `sudo systemctl start wa-ai-chatbot.service` |
| Lihat log real-time | `journalctl -u wa-ai-chatbot.service -f` |
| Jalankan bot manual (untuk scan QR) | `cd ~/apps/wa-ai-chatbot && npm start` |
| Update project dari laptop | `scp -r "path/project" pi@IP:/home/pi/apps/wa-ai-chatbot` |

---

## Troubleshooting (Penanganan Masalah)

### 1. Tidak Bisa SSH ke Raspberry Pi

**Gejala:** Perintah `ssh pi@IP` timeout atau ditolak.

**Solusi:**
- Pastikan Raspberry Pi sudah menyala dan terhubung ke jaringan WiFi/LAN yang sama dengan laptop Anda.
- Pastikan SSH sudah diaktifkan saat install OS (lihat langkah 1.1).
- Coba ping Raspberry Pi: `ping IP_RASPBERRY_PI`. Jika tidak merespons, cek kembali IP-nya di router.
- Jika menggunakan WiFi, pastikan SSID dan password yang dimasukkan saat install OS sudah benar.

### 2. QR Code Tidak Muncul saat Menjalankan systemd Service

Hal ini **wajar** karena systemd service berjalan di background (tidak ada tampilan terminal).

**Solusi:**
1. Stop service: `sudo systemctl stop wa-ai-chatbot.service`
2. Jalankan manual: `cd ~/apps/wa-ai-chatbot && npm start`
3. Scan QR Code dari HP.
4. Setelah berhasil terhubung, tekan `Ctrl + C` untuk menghentikan proses manual.
5. Jalankan kembali service: `sudo systemctl start wa-ai-chatbot.service`

### 3. Koneksi Terputus / Bot Tidak Merespons

**Solusi:**
- Periksa log real-time: `journalctl -u wa-ai-chatbot.service -f`
- Bot memiliki fitur **Auto Recovery**: jika sesi WhatsApp expired/logout, bot otomatis menghapus folder session dan menampilkan QR Code baru.
- Jika bot berjalan via `npm start` (manual), QR Code baru akan langsung muncul di terminal.
- Jika bot berjalan via **systemd service**, QR Code tidak bisa tampil di background. Lakukan langkah berikut:
  1. Stop service: `sudo systemctl stop wa-ai-chatbot.service`
  2. Jalankan manual: `cd ~/apps/wa-ai-chatbot && npm start`
  3. Tunggu QR Code muncul, lalu scan dari HP.
  4. Setelah berhasil terhubung, tekan `Ctrl + C`.
  5. Start service kembali: `sudo systemctl start wa-ai-chatbot.service`

### 4. Groq API Error

**Solusi:**
- Periksa apakah `GROQ_API_KEY` di file `.env` sudah benar dan aktif.
- Buka [console.groq.com](https://console.groq.com) untuk memverifikasi status API Key Anda.
- Jika request timeout, coba tingkatkan `GROQ_TIMEOUT_MS` di file `.env` (default: `120000` ms = 2 menit).

### 5. npm install Gagal / Error di Raspberry Pi

**Solusi:**
- Pastikan Node.js versi 20+: `node -v`
- Coba hapus cache npm dan install ulang:
  ```bash
  cd ~/apps/wa-ai-chatbot
  rm -rf node_modules package-lock.json
  npm cache clean --force
  npm install
  ```

---

## Update & Maintenance (Pembaruan & Perawatan)

### Update Project dari Laptop ke Raspberry Pi

Jika ada perubahan kode, upload ulang dari laptop:

**Dari Windows (PowerShell):**
```powershell
scp -r "E:\Project\Freelance Projects\Chatbot Wa Raspberry Pi 3" pi@192.168.1.50:/home/pi/apps/wa-ai-chatbot
```

Kemudian di terminal SSH Raspberry Pi:
```bash
cd ~/apps/wa-ai-chatbot
npm install
sudo systemctl restart wa-ai-chatbot.service
```

### Restart Raspberry Pi

Jika perlu restart Raspberry Pi secara remote:
```bash
sudo reboot
```
Bot akan otomatis menyala kembali setelah reboot (jika systemd sudah di-enable di Tahap 5).

### Matikan Raspberry Pi dengan Aman

```bash
sudo shutdown -h now
```

> [!WARNING]
> Jangan mencabut kabel listrik Raspberry Pi secara langsung tanpa melakukan shutdown terlebih dahulu. Hal ini dapat menyebabkan kerusakan data pada MicroSD Card.

---

## Catatan Keamanan & Batasan

- **Keamanan File `.env`**: File `.env` berisi API Key dan konfigurasi sensitif. **Jangan membagikan file ini kepada siapapun**. File ini sudah didaftarkan di `.gitignore`.
- **Keamanan Sesi**: Jangan membagikan isi folder `auth_info_baileys/` karena berisi kunci enkripsi sesi WhatsApp Anda. Folder ini sudah didaftarkan di `.gitignore`.
- **API Key**: Jika API Key pernah terekspos (misalnya tidak sengaja dikirim via screenshot atau commit ke GitHub), segera **revoke/regenerate** API Key di [console.groq.com](https://console.groq.com) dan ganti yang baru di file `.env`.
- **Ketentuan WhatsApp**: Bot ini menggunakan library tidak resmi Baileys. Gunakan hanya untuk kebutuhan personal, internal, atau prototype demi menghindari pemblokiran akun oleh WhatsApp. **Dilarang keras** menggunakan bot ini untuk aktivitas spamming massal atau broadcast yang mengganggu.

---

## FAQ (Pertanyaan yang Sering Ditanyakan)

<details>
<summary><strong>Apakah Raspberry Pi harus selalu menyala?</strong></summary>

Ya. Raspberry Pi berperan sebagai server lokal. Jika dimatikan, bot WhatsApp juga akan mati. Pastikan Raspberry Pi terhubung ke listrik dan internet secara terus-menerus.
</details>

<details>
<summary><strong>Apakah Raspberry Pi butuh monitor/keyboard?</strong></summary>

Tidak. Setelah setup awal, Raspberry Pi diakses **sepenuhnya via SSH** dari laptop Anda. Tidak perlu monitor, keyboard, atau mouse.
</details>

<details>
<summary><strong>Apakah harus pakai WiFi yang sama antara laptop dan Raspberry Pi?</strong></summary>

Saat setup awal, **ya** — laptop dan Raspberry Pi harus berada di jaringan WiFi/LAN yang sama agar bisa terhubung via SSH. Setelah bot sudah berjalan, laptop tidak perlu terus terhubung.
</details>

<details>
<summary><strong>Bagaimana jika WiFi berubah (ganti router/SSID)?</strong></summary>

Raspberry Pi perlu dikonfigurasi ulang untuk terhubung ke WiFi baru. Cara paling mudah: hubungkan Raspberry Pi ke monitor dan keyboard sementara, lalu jalankan `sudo raspi-config` → **System Options** → **Wireless LAN** → masukkan SSID dan password WiFi baru.
</details>

<details>
<summary><strong>Bot tidak merespons setelah beberapa hari, kenapa?</strong></summary>

Kemungkinan sesi WhatsApp expired. Bot memiliki fitur **Auto Recovery** yang otomatis menghapus session dan generate QR baru. Jika berjalan via systemd, ikuti langkah Troubleshooting #3 untuk scan QR ulang.
</details>

<details>
<summary><strong>Apakah bisa pakai Raspberry Pi 4 atau 5?</strong></summary>

Ya, bot ini kompatibel dengan Raspberry Pi 4 dan 5. Performanya akan lebih baik karena spesifikasi hardware yang lebih tinggi.
</details>

<details>
<summary><strong>Apa bedanya Raspberry Pi dengan VPS?</strong></summary>

| | Raspberry Pi | VPS |
|---|---|---|
| **Lokasi** | Fisik di rumah/kantor | Data center di internet |
| **Akses** | IP lokal (WiFi/LAN) | IP public |
| **Biaya** | Sekali beli, tanpa langganan | Sewa bulanan |
| **Ketergantungan** | Listrik & internet lokal | Provider hosting |
| **Kelebihan** | Tanpa biaya berulang | Uptime lebih stabil |
</details>

<details>
<summary><strong>Bagaimana cara mendapatkan API Key Groq?</strong></summary>

1. Buka [console.groq.com](https://console.groq.com).
2. Daftar atau login dengan akun Google/GitHub.
3. Masuk ke menu **API Keys**.
4. Klik **Create API Key**, beri nama, lalu copy key-nya (diawali `gsk_`).
5. Paste ke file `.env` pada bagian `GROQ_API_KEY`.
</details>
