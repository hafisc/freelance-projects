-- Buat database jika belum ada
CREATE DATABASE IF NOT EXISTS parking_mall;
USE parking_mall;

-- Hapus tabel jika sudah ada (urutannya disesuaikan dengan foreign key)
DROP TABLE IF EXISTS transaksi_parkir;
DROP TABLE IF EXISTS booking;
DROP TABLE IF EXISTS kendaraan;
DROP TABLE IF EXISTS slot_parkir;
DROP TABLE IF EXISTS lantai;
DROP TABLE IF EXISTS petugas;
DROP TABLE IF EXISTS users;

-- 1. Tabel users (Menyimpan akun login)
CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    role ENUM('admin', 'petugas', 'pengguna') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Tabel petugas (Detail data petugas)
CREATE TABLE petugas (
    id_petugas INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT,
    nama_petugas VARCHAR(100) NOT NULL,
    no_hp VARCHAR(20),
    alamat TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE
);

-- 3. Tabel lantai (Data lantai parkir)
CREATE TABLE lantai (
    id_lantai INT AUTO_INCREMENT PRIMARY KEY,
    nama_lantai VARCHAR(50) NOT NULL,
    keterangan VARCHAR(150),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. Tabel slot_parkir (Slot berdasarkan lantai)
CREATE TABLE slot_parkir (
    id_slot INT AUTO_INCREMENT PRIMARY KEY,
    id_lantai INT NOT NULL,
    kode_slot VARCHAR(20) NOT NULL,
    status ENUM('tersedia', 'dibooking', 'terisi') DEFAULT 'tersedia',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_lantai) REFERENCES lantai(id_lantai) ON DELETE CASCADE
);

-- 5. Tabel kendaraan (Data kendaraan masuk)
CREATE TABLE kendaraan (
    id_kendaraan INT AUTO_INCREMENT PRIMARY KEY,
    plat_nomor VARCHAR(20) NOT NULL,
    jenis_kendaraan ENUM('motor', 'mobil') NOT NULL,
    id_slot INT,
    waktu_masuk DATETIME NOT NULL,
    waktu_keluar DATETIME NULL,
    status ENUM('masuk', 'keluar') DEFAULT 'masuk',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_slot) REFERENCES slot_parkir(id_slot) ON DELETE SET NULL
);

-- 6. Tabel booking (Data booking pengguna)
CREATE TABLE booking (
    id_booking INT AUTO_INCREMENT PRIMARY KEY,
    kode_booking VARCHAR(30) NOT NULL UNIQUE,
    id_user INT NOT NULL,
    id_slot INT NOT NULL,
    plat_nomor VARCHAR(20) NOT NULL,
    jenis_kendaraan ENUM('motor', 'mobil') NOT NULL,
    waktu_booking DATETIME NOT NULL,
    status ENUM('menunggu', 'diverifikasi', 'selesai', 'dibatalkan') DEFAULT 'menunggu',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_slot) REFERENCES slot_parkir(id_slot) ON DELETE CASCADE
);

-- 7. Tabel transaksi_parkir (Billing parkir)
CREATE TABLE transaksi_parkir (
    id_transaksi INT AUTO_INCREMENT PRIMARY KEY,
    kode_transaksi VARCHAR(30) NOT NULL UNIQUE,
    id_kendaraan INT NULL,
    id_booking INT NULL,
    waktu_masuk DATETIME NOT NULL,
    waktu_keluar DATETIME NULL,
    durasi_jam INT DEFAULT 0,
    total_bayar INT DEFAULT 0,
    status ENUM('berjalan', 'selesai') DEFAULT 'berjalan',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_kendaraan) REFERENCES kendaraan(id_kendaraan) ON DELETE SET NULL,
    FOREIGN KEY (id_booking) REFERENCES booking(id_booking) ON DELETE SET NULL
);

-- Data Dummy Awal
INSERT INTO users (nama, username, password, role) VALUES
('Administrator', 'admin', 'admin123', 'admin'),
('Petugas Parkir', 'petugas', 'petugas123', 'petugas'),
('Pengguna Parkir', 'pengguna', 'pengguna123', 'pengguna');

INSERT INTO petugas (id_user, nama_petugas, no_hp, alamat) VALUES
(2, 'Petugas Parkir', '081234567890', 'Gedung Parkir Utama');

INSERT INTO lantai (nama_lantai, keterangan) VALUES
('Lantai 1', 'Area parkir lantai 1 (Dekat lobby utama)'),
('Lantai 2', 'Area parkir lantai 2 (Dekat bioskop)'),
('Lantai 3', 'Area parkir lantai 3 (Rooftop)');

INSERT INTO slot_parkir (id_lantai, kode_slot, status) VALUES
-- Lantai 1 (A1-A5 Mobil, M1-M5 Motor)
(1, 'A1', 'tersedia'),
(1, 'A2', 'tersedia'),
(1, 'A3', 'tersedia'),
(1, 'A4', 'tersedia'),
(1, 'A5', 'tersedia'),
(1, 'M1', 'tersedia'),
(1, 'M2', 'tersedia'),
(1, 'M3', 'tersedia'),
(1, 'M4', 'tersedia'),
(1, 'M5', 'tersedia'),

-- Lantai 2 (B1-B5 Mobil, M6-M10 Motor)
(2, 'B1', 'tersedia'),
(2, 'B2', 'tersedia'),
(2, 'B3', 'tersedia'),
(2, 'B4', 'tersedia'),
(2, 'B5', 'tersedia'),
(2, 'M6', 'tersedia'),
(2, 'M7', 'tersedia'),
(2, 'M8', 'tersedia'),
(2, 'M9', 'tersedia'),
(2, 'M10', 'tersedia'),

-- Lantai 3 (C1-C5 Mobil, M11-M15 Motor)
(3, 'C1', 'tersedia'),
(3, 'C2', 'tersedia'),
(3, 'C3', 'tersedia'),
(3, 'C4', 'tersedia'),
(3, 'C5', 'tersedia'),
(3, 'M11', 'tersedia'),
(3, 'M12', 'tersedia'),
(3, 'M13', 'tersedia'),
(3, 'M14', 'tersedia'),
(3, 'M15', 'tersedia');

