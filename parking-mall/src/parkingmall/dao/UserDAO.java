package parkingmall.dao;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import parkingmall.config.DatabaseConnection;
import parkingmall.model.User;

public class UserDAO {
    private final Connection conn;

    public UserDAO() {
        this.conn = DatabaseConnection.getConnection();
    }

    // Fungsi ini digunakan untuk memvalidasi login user berdasarkan username dan password
    public User login(String username, String password) {
        String sql = "SELECT * FROM users WHERE username = ? AND password = ?";
        try (PreparedStatement ps = conn.prepareStatement(sql)) {
            ps.setString(1, username);
            ps.setString(2, password);
            try (ResultSet rs = ps.executeQuery()) {
                if (rs.next()) {
                    return new User(
                        rs.getInt("id_user"),
                        rs.getString("nama"),
                        rs.getString("username"),
                        rs.getString("password"),
                        rs.getString("role"),
                        rs.getTimestamp("created_at")
                    );
                }
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return null;
    }

    // Fungsi ini digunakan untuk mendaftarkan user baru (khusus role pengguna)
    public boolean register(User user) {
        String sql = "INSERT INTO users (nama, username, password, role) VALUES (?, ?, ?, 'pengguna')";
        try (PreparedStatement ps = conn.prepareStatement(sql, Statement.RETURN_GENERATED_KEYS)) {
            ps.setString(1, user.getNama());
            ps.setString(2, user.getUsername());
            ps.setString(3, user.getPassword());
            int affectedRows = ps.executeUpdate();
            if (affectedRows > 0) {
                try (ResultSet generatedKeys = ps.getGeneratedKeys()) {
                    if (generatedKeys.next()) {
                        user.setIdUser(generatedKeys.getInt(1));
                    }
                }
                return true;
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return false;
    }

    // Fungsi ini digunakan untuk membuat user baru dengan role spesifik (untuk petugas/admin)
    public int insertUser(User user) {
        String sql = "INSERT INTO users (nama, username, password, role) VALUES (?, ?, ?, ?)";
        try (PreparedStatement ps = conn.prepareStatement(sql, Statement.RETURN_GENERATED_KEYS)) {
            ps.setString(1, user.getNama());
            ps.setString(2, user.getUsername());
            ps.setString(3, user.getPassword());
            ps.setString(4, user.getRole());
            int affectedRows = ps.executeUpdate();
            if (affectedRows > 0) {
                try (ResultSet generatedKeys = ps.getGeneratedKeys()) {
                    if (generatedKeys.next()) {
                        return generatedKeys.getInt(1);
                    }
                }
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return -1;
    }

    // Fungsi ini digunakan untuk memperbarui data user (nama, password)
    public boolean updateUser(User user) {
        String sql = "UPDATE users SET nama = ?, password = ? WHERE id_user = ?";
        try (PreparedStatement ps = conn.prepareStatement(sql)) {
            ps.setString(1, user.getNama());
            ps.setString(2, user.getPassword());
            ps.setInt(3, user.getIdUser());
            return ps.executeUpdate() > 0;
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return false;
    }

    // Fungsi ini digunakan untuk memeriksa apakah username sudah terdaftar
    public boolean isUsernameTaken(String username) {
        String sql = "SELECT id_user FROM users WHERE username = ?";
        try (PreparedStatement ps = conn.prepareStatement(sql)) {
            ps.setString(1, username);
            try (ResultSet rs = ps.executeQuery()) {
                return rs.next();
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return false;
    }

    // Fungsi ini digunakan untuk menghapus user berdasarkan id
    public boolean deleteUser(int idUser) {
        String sql = "DELETE FROM users WHERE id_user = ?";
        try (PreparedStatement ps = conn.prepareStatement(sql)) {
            ps.setInt(1, idUser);
            return ps.executeUpdate() > 0;
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return false;
    }
}
