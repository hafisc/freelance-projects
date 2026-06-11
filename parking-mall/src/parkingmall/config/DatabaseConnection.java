package parkingmall.config;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

public class DatabaseConnection {
    // URL, username, dan password default phpMyAdmin / XAMPP
    private static final String URL = "jdbc:mysql://localhost:3306/parking_mall";
    private static final String USER = "root";
    private static final String PASSWORD = "";
    private static Connection connection = null;

    // Fungsi ini digunakan untuk mendapatkan koneksi database dengan pattern Singleton
    public static Connection getConnection() {
        if (connection == null) {
            try {
                // Memuat driver JDBC MySQL
                try {
                    Class.forName("com.mysql.cj.jdbc.Driver");
                } catch (ClassNotFoundException e) {
                    Class.forName("com.mysql.jdbc.Driver");
                }
                
                connection = DriverManager.getConnection(URL, USER, PASSWORD);
                System.out.println("Koneksi database berhasil terhubung.");
            } catch (ClassNotFoundException e) {
                System.err.println("Driver JDBC MySQL tidak ditemukan! Silakan tambahkan mysql-connector-java ke Library.");
                e.printStackTrace();
            } catch (SQLException e) {
                System.err.println("Gagal koneksi ke database! Pastikan MySQL XAMPP sudah berjalan.");
                e.printStackTrace();
            }
        } else {
            try {
                if (connection.isClosed()) {
                    connection = null;
                    return getConnection();
                }
            } catch (SQLException e) {
                connection = null;
                return getConnection();
            }
        }
        return connection;
    }
}
