package com.lauraprinting.config;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.sql.Statement;

public class DatabaseConfig {
    private static final String SERVER_URL = "jdbc:mysql://localhost:3306/?allowMultiQueries=true";
    private static final String DB_URL = "jdbc:mysql://localhost:3306/laura_printing?allowMultiQueries=true";
    private static final String USER = "root";
    private static final String PASSWORD = "";

    // Memuat Driver JDBC MySQL
    static {
        try {
            Class.forName("com.mysql.cj.jdbc.Driver");
        } catch (ClassNotFoundException e) {
            System.err.println("MySQL JDBC Driver not found!");
            e.printStackTrace();
        }
    }

    public static Connection getServerConnection() throws SQLException {
        return DriverManager.getConnection(SERVER_URL, USER, PASSWORD);
    }

    public static Connection getConnection() throws SQLException {
        return DriverManager.getConnection(DB_URL, USER, PASSWORD);
    }

    public static void initializeDatabase() {
        try (Connection conn = getServerConnection();
             Statement stmt = conn.createStatement()) {
            
            // Membuat database jika belum ada
            stmt.executeUpdate("CREATE DATABASE IF NOT EXISTS laura_printing;");
            System.out.println("Database 'laura_printing' checked/created.");
            
        } catch (SQLException e) {
            System.err.println("Error checking/creating database!");
            e.printStackTrace();
            return;
        }

        try (Connection conn = getConnection();
             Statement stmt = conn.createStatement()) {
            
            // Membuat tabel-tabel database
            String createUsersTable = 
                "CREATE TABLE IF NOT EXISTS users (" +
                "  id INT AUTO_INCREMENT PRIMARY KEY," +
                "  username VARCHAR(50) NOT NULL UNIQUE," +
                "  password VARCHAR(100) NOT NULL," +
                "  role VARCHAR(20) NOT NULL," +
                "  name VARCHAR(100) NOT NULL," +
                "  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP" +
                ");";
            
            String createCustomersTable = 
                "CREATE TABLE IF NOT EXISTS customers (" +
                "  id INT AUTO_INCREMENT PRIMARY KEY," +
                "  name VARCHAR(100) NOT NULL," +
                "  phone VARCHAR(20) NOT NULL," +
                "  address TEXT," +
                "  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP" +
                ");";
                
            String createServicesTable = 
                "CREATE TABLE IF NOT EXISTS services (" +
                "  id INT AUTO_INCREMENT PRIMARY KEY," +
                "  name VARCHAR(100) NOT NULL," +
                "  unit VARCHAR(20) NOT NULL," +
                "  price DOUBLE NOT NULL," +
                "  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP" +
                ");";
                
            String createOrdersTable = 
                "CREATE TABLE IF NOT EXISTS orders (" +
                "  id INT AUTO_INCREMENT PRIMARY KEY," +
                "  order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP," +
                "  customer_id INT," +
                "  total_amount DOUBLE NOT NULL," +
                "  paid_amount DOUBLE NOT NULL," +
                "  status VARCHAR(20) NOT NULL DEFAULT 'Pending'," +
                "  FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE SET NULL" +
                ");";
                
            String createOrderDetailsTable = 
                "CREATE TABLE IF NOT EXISTS order_details (" +
                "  id INT AUTO_INCREMENT PRIMARY KEY," +
                "  order_id INT NOT NULL," +
                "  service_id INT," +
                "  qty INT NOT NULL," +
                "  price DOUBLE NOT NULL," +
                "  subtotal DOUBLE NOT NULL," +
                "  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE," +
                "  FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE SET NULL" +
                ");";

            stmt.executeUpdate(createUsersTable);
            stmt.executeUpdate(createCustomersTable);
            stmt.executeUpdate(createServicesTable);
            stmt.executeUpdate(createOrdersTable);
            stmt.executeUpdate(createOrderDetailsTable);
            System.out.println("Tables checked/created.");

            // Memasukkan data awal (seed) pengguna jika masih kosong
            String seedUsers = 
                "INSERT INTO users (username, password, role, name) " +
                "SELECT * FROM (SELECT 'admin' AS u, 'admin123' AS p, 'Admin' AS r, 'Laura (Owner)' AS n) AS tmp " +
                "WHERE NOT EXISTS (SELECT username FROM users WHERE username = 'admin') LIMIT 1;";
            stmt.executeUpdate(seedUsers);
            
            String seedCashier = 
                "INSERT INTO users (username, password, role, name) " +
                "SELECT * FROM (SELECT 'cashier' AS u, 'cashier123' AS p, 'Cashier' AS r, 'Ahmad (Staff)' AS n) AS tmp " +
                "WHERE NOT EXISTS (SELECT username FROM users WHERE username = 'cashier') LIMIT 1;";
            stmt.executeUpdate(seedCashier);

            // Memasukkan data awal (seed) layanan cetak jika masih kosong
            String checkServices = "SELECT COUNT(*) FROM services";
            var rs = stmt.executeQuery(checkServices);
            if (rs.next() && rs.getInt(1) == 0) {
                stmt.executeUpdate("INSERT INTO services (name, unit, price) VALUES " +
                    "('Cetak Dokumen A4 (B/W)', 'Lembar', 500), " +
                    "('Cetak Dokumen A4 (Color)', 'Lembar', 2000), " +
                    "('Cetak Foto 4R', 'Lembar', 3000), " +
                    "('Cetak Banner / Spanduk', 'Meter', 25000), " +
                    "('Cetak Stiker A3+', 'Lembar', 12000), " +
                    "('Jilid Buku (Soft Cover)', 'Pcs', 15000), " +
                    "('Jilid Spiral A4', 'Pcs', 20000);");
            }
            
            // Memasukkan data awal (seed) pelanggan jika masih kosong
            String checkCustomers = "SELECT COUNT(*) FROM customers";
            rs = stmt.executeQuery(checkCustomers);
            if (rs.next() && rs.getInt(1) == 0) {
                stmt.executeUpdate("INSERT INTO customers (name, phone, address) VALUES " +
                    "('Walk-in Customer', '-', '-'), " +
                    "('Budi Santoso', '081234567890', 'Jl. Merdeka No. 10'), " +
                    "('Siti Aminah', '085712345678', 'Jl. Mawar No. 4');");
            }
            
            System.out.println("Database seeding completed.");

        } catch (SQLException e) {
            System.err.println("Error initializing tables and seed data!");
            e.printStackTrace();
        }
    }
}
