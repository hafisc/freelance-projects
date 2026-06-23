-- Skema Database untuk GreenHaven Plant Shop
-- Mempersiapkan struktur database dan data contoh

CREATE DATABASE IF NOT EXISTS greenhaven_db;
USE greenhaven_db;

-- ==========================================
-- 1. TABEL ADMIN
-- Menyimpan data akun administrator untuk login dashboard
-- ==========================================
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed akun admin default (Username: admin, Password: admin123)
INSERT INTO admins (username, password, name) 
VALUES ('admin', '$2y$10$77Upni1pFCfD57oqxp9sYuwNb7yctY6jz4ZcVKZisDHHpKQ32.6Lq', 'Super Admin')
ON DUPLICATE KEY UPDATE username=username;


-- ==========================================
-- 2. TABEL KATEGORI
-- Menyimpan kategori produk tanaman
-- ==========================================
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed kategori tanaman awal
INSERT INTO categories (id, name) VALUES
(1, 'Tanaman Indoor'),
(2, 'Tanaman Outdoor'),
(3, 'Sukulen & Kaktus'),
(4, 'Tanaman Herbal & Obat')
ON DUPLICATE KEY UPDATE name=VALUES(name);


-- ==========================================
-- 3. TABEL PRODUK
-- Menyimpan data tanaman hias yang dijual
-- ==========================================
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    image VARCHAR(255) DEFAULT 'default-plant.jpg',
    is_promo TINYINT(1) DEFAULT 0,
    promo_price DECIMAL(10,2) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed beberapa produk tanaman berkualitas tinggi untuk demo awal
INSERT INTO products (id, category_id, name, description, price, stock, image, is_promo, promo_price) VALUES
(1, 1, 'Monstera Deliciosa', 'Tanaman indoor tropis ikonik dengan daun berlubang artistik. Sangat cocok diletakkan di sudut ruang tamu atau kantor untuk memberikan nuansa estetis yang segar.', 125000.00, 15, 'monstera.jpg', 0, NULL),
(2, 1, 'Snake Plant (Lidah Mertua)', 'Tanaman hias yang sangat tangguh dan berfungsi sebagai pembersih udara alami. Efektif menyerap polutan dan memproduksi oksigen, bahkan di malam hari.', 45000.00, 30, 'snake_plant.jpg', 1, 35000.00),
(3, 1, 'Calathea Orbifolia', 'Memiliki pola daun bergaris hijau-perak yang lebar dan dramatis. Menyukai tempat dengan kelembapan tinggi dan cahaya tidak langsung.', 95000.00, 10, 'calathea.jpg', 0, NULL),
(4, 3, 'Golden Barrel Cactus', 'Kaktus berbentuk bulat simetris dengan duri kuning keemasan yang menawan. Sangat mudah dirawat dan hanya perlu disiram sesekali.', 60000.00, 25, 'golden_barrel.jpg', 1, 50000.00),
(5, 2, 'Anthurium Merah', 'Menghadirkan bunga berbentuk jantung berwarna merah menyala dengan tongkol kuning cerah. Mempercantik teras atau halaman rumah Anda.', 110000.00, 12, 'anthurium.jpg', 0, NULL),
(6, 4, 'Peppermint (Daun Mint)', 'Tanaman herbal dengan aroma mentol segar yang kuat. Daunnya dapat diseduh menjadi teh hangat atau dijadikan hiasan kuliner aromatik.', 25000.00, 40, 'peppermint.jpg', 0, NULL)
ON DUPLICATE KEY UPDATE name=VALUES(name), description=VALUES(description), price=VALUES(price), stock=VALUES(stock);


-- ==========================================
-- 4. TABEL PESAN MASUK
-- Menyimpan pesan atau pertanyaan dari form hubungi kami
-- ==========================================
CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed contoh pesan masuk
INSERT INTO messages (name, email, subject, message) VALUES
('Rian Hidayat', 'rian@email.com', 'Tanya Stok Monstera', 'Halo GreenHaven, apakah Monstera Deliciosa ukuran besar masih ready? Dan apakah bisa kirim ke luar kota?'),
('Siti Aminah', 'siti.aminah@email.com', 'Konsultasi Perawatan', 'Tanaman Lidah Mertua saya daunnya agak menguning di bagian bawah. Apakah itu karena kelebihan air atau kurang sinar matahari ya?')
ON DUPLICATE KEY UPDATE name=name;


-- ==========================================
-- 5. TABEL TESTIMONI
-- Menyimpan review/ulasan dari pembeli yang ditampilkan di landing page
-- ==========================================
CREATE TABLE IF NOT EXISTS testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    role VARCHAR(100) DEFAULT 'Pelanggan',
    review TEXT NOT NULL,
    rating INT DEFAULT 5,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed contoh testimoni awal
INSERT INTO messages (id, name, email, subject, message) VALUES
-- Testimoni data seed
(1, 'Agus Pratama', 'agus@email.com', 'Testimoni', 'Pelayanan ramah sekali. Tanaman Monstera yang dikirim segar bugar dan packing-nya super aman dengan kayu. Sangat puas!')
ON DUPLICATE KEY UPDATE name=name;

-- Seed tabel testimonials secara terpisah
INSERT INTO testimonials (id, name, role, review, rating, is_active) VALUES
(1, 'Agus Pratama', 'Pencinta Tanaman', 'Pelayanan ramah sekali. Tanaman Monstera yang dikirim segar bugar dan packing-nya super aman dengan kayu. Sangat puas belanja di sini!', 5, 1),
(2, 'Citra Lestari', 'Ibu Rumah Tangga', 'Beli Kaktus Golden Barrel untuk hiasan meja kerja. Lucu sekali ukurannya pas dan durinya rapi. Rekomended buat pemula.', 5, 1),
(3, 'Budi Santoso', 'Dekorator Interior', 'Selalu order tanaman indoor di GreenHaven untuk proyek klien saya. Kualitas tanaman konsisten segar dan bebas hama.', 4, 1)
ON DUPLICATE KEY UPDATE name=VALUES(name), review=VALUES(review);
