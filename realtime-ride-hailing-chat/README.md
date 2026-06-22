# Go-AFL3 | Real-Time Ride-Hailing & Chat Platform

Aplikasi simulasi ride-hailing dan chat real-time menggunakan arsitektur Microservices dengan Docker.

## Persyaratan
- Docker Desktop aktif di komputer Anda.

## Cara Menjalankan (Sekali Klik)
Jika Anda menggunakan Windows, cukup double-click file `run.bat` di folder utama ini. 

Atau jika ingin menjalankan lewat terminal:
```bash
docker compose up -d --build
```

## Link Akses Layanan
Setelah semua kontainer berjalan (status *Running* di Docker Desktop), buka browser dan akses link berikut:
- **Aplikasi Utama (Web UI)**: http://localhost/
- **Traefik API Gateway Dashboard**: http://localhost:8080/
- **Grafana Monitoring**: http://localhost/grafana/ (Username: `admin`, Password: `admin`)

## Cara Pengujian Fitur Real-Time
Untuk mencoba simulasi pemesanan, GPS tracking, dan chat secara real-time:
1. Buka browser utama (misal Chrome), masuk ke http://localhost/, lalu klik **Daftar Sekarang** untuk membuat akun **Penumpang (Customer)**.
2. Buka jendela Samaran / Incognito browser, masuk ke http://localhost/, lalu klik **Daftar Sekarang** untuk membuat akun **Pengemudi (Driver)**.
3. Gunakan akun Penumpang untuk memesan perjalanan.
4. Terima orderan tersebut di tab Pengemudi. Anda bisa melihat pergerakan driver di peta dan mengobrol lewat fitur live chat.

## Struktur Microservices (Total 11 Container)
1. **gateway-traefik**: API Gateway (Port 80)
2. **web-frontend**: Tampilan Web Utama (Nginx)
3. **svc-auth**: Service Autentikasi (Node.js)
4. **svc-trip**: Service Manajemen Perjalanan (Node.js)
5. **svc-chat**: Service Chat & GPS Real-Time (Node.js + Socket.io)
6. **db-auth-mongo**: Database untuk Data Pengguna (MongoDB)
7. **db-trip-mongo**: Database untuk Perjalanan & Chat (MongoDB)
8. **monitor-node-exporter**: Monitor Resource Host
9. **monitor-cadvisor**: Monitor Resource Container
10. **monitor-prometheus**: Mengumpulkan Data Metrics
11. **monitor-grafana**: Visualisasi Dashboard Monitoring
