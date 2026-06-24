-- Database Schema for Laura Printing

CREATE DATABASE IF NOT EXISTS laura_printing;
USE laura_printing;

-- 1. Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    role VARCHAR(20) NOT NULL, -- 'Admin', 'Cashier'
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Customers Table
CREATE TABLE IF NOT EXISTS customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Services Table (Products/Jasa Percetakan)
CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    unit VARCHAR(20) NOT NULL, -- e.g., 'Lembar', 'Meter', 'Pcs'
    price DOUBLE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. Orders Table
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    customer_id INT,
    total_amount DOUBLE NOT NULL,
    paid_amount DOUBLE NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'Pending', -- 'Pending', 'Processing', 'Done', 'Picked Up'
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE SET NULL
);

-- 5. Order Details Table
CREATE TABLE IF NOT EXISTS order_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    service_id INT,
    qty INT NOT NULL,
    price DOUBLE NOT NULL,
    subtotal DOUBLE NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE SET NULL
);

-- Seed Default Users (Passwords are plain text for simplicity in college assignments)
INSERT INTO users (username, password, role, name)
VALUES 
('admin', 'admin123', 'Admin', 'Laura (Owner)'),
('cashier', 'cashier123', 'Cashier', 'Ahmad (Staff)')
ON DUPLICATE KEY UPDATE username=username;

-- Seed Default Services
INSERT INTO services (name, unit, price)
VALUES 
('Cetak Dokumen A4 (B/W)', 'Lembar', 500),
('Cetak Dokumen A4 (Color)', 'Lembar', 2000),
('Cetak Foto 4R', 'Lembar', 3000),
('Cetak Banner / Spanduk', 'Meter', 25000),
('Cetak Stiker A3+', 'Lembar', 12000),
('Jilid Buku (Soft Cover)', 'Pcs', 15000),
('Jilid Spiral A4', 'Pcs', 20000)
ON DUPLICATE KEY UPDATE name=name;

-- Seed Default Customers
INSERT INTO customers (name, phone, address)
VALUES 
('Walk-in Customer', '-', '-'),
('Budi Santoso', '081234567890', 'Jl. Merdeka No. 10'),
('Siti Aminah', '085712345678', 'Jl. Mawar No. 4')
ON DUPLICATE KEY UPDATE name=name;
