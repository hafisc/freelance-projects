package parkingmall.dao;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;
import parkingmall.config.DatabaseConnection;
import parkingmall.model.Petugas;
import parkingmall.model.User;

public class PetugasDAO {
    private final Connection conn;
    private final UserDAO userDAO;

    public PetugasDAO() {
        this.conn = DatabaseConnection.getConnection();
        this.userDAO = new UserDAO();
    }

    // Fungsi ini digunakan untuk mengambil semua data petugas dari database
    public List<Petugas> getAllPetugas() {
        List<Petugas> list = new ArrayList<>();
        String sql = "SELECT p.* FROM petugas p JOIN users u ON p.id_user = u.id_user ORDER BY p.id_petugas DESC";
        try (PreparedStatement ps = conn.prepareStatement(sql);
             ResultSet rs = ps.executeQuery()) {
            while (rs.next()) {
                list.add(new Petugas(
                    rs.getInt("id_petugas"),
                    rs.getInt("id_user"),
                    rs.getString("nama_petugas"),
                    rs.getString("no_hp"),
                    rs.getString("alamat"),
                    rs.getTimestamp("created_at")
                ));
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return list;
    }

    // Fungsi ini digunakan untuk mengambil data user berdasarkan id_user petugas
    public User getUserByPetugas(int idUser) {
        String sql = "SELECT * FROM users WHERE id_user = ?";
        try (PreparedStatement ps = conn.prepareStatement(sql)) {
            ps.setInt(1, idUser);
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

    // Fungsi ini digunakan untuk menambah data petugas baru beserta akun login-nya secara transaksional
    public boolean insertPetugas(Petugas petugas, User user) {
        boolean wasAutoCommit = true;
        try {
            wasAutoCommit = conn.getAutoCommit();
            if (wasAutoCommit) {
                conn.setAutoCommit(false);
            }
            
            // 1. Simpan user ke tabel users
            int idUser = userDAO.insertUser(user);
            if (idUser == -1) {
                if (wasAutoCommit) {
                    conn.rollback();
                }
                return false;
            }
            
            // 2. Simpan petugas ke tabel petugas dengan id_user yang didapat
            String sql = "INSERT INTO petugas (id_user, nama_petugas, no_hp, alamat) VALUES (?, ?, ?, ?)";
            try (PreparedStatement ps = conn.prepareStatement(sql)) {
                ps.setInt(1, idUser);
                ps.setString(2, petugas.getNamaPetugas());
                ps.setString(3, petugas.getNoHp());
                ps.setString(4, petugas.getAlamat());
                
                int rows = ps.executeUpdate();
                if (rows > 0) {
                    if (wasAutoCommit) {
                        conn.commit();
                    }
                    return true;
                }
            }
            
            if (wasAutoCommit) {
                conn.rollback();
            }
        } catch (SQLException e) {
            if (wasAutoCommit) {
                try {
                    conn.rollback();
                } catch (SQLException ex) {
                    ex.printStackTrace();
                }
            }
            e.printStackTrace();
        } finally {
            if (wasAutoCommit) {
                try {
                    conn.setAutoCommit(true);
                } catch (SQLException e) {
                    e.printStackTrace();
                }
            }
        }
        return false;
    }

    // Fungsi ini digunakan untuk memperbarui data petugas dan akun login-nya secara transaksional
    public boolean updatePetugas(Petugas petugas, User user) {
        boolean wasAutoCommit = true;
        try {
            wasAutoCommit = conn.getAutoCommit();
            if (wasAutoCommit) {
                conn.setAutoCommit(false);
            }
            
            // 1. Update data user
            boolean userUpdated = userDAO.updateUser(user);
            if (!userUpdated) {
                if (wasAutoCommit) {
                    conn.rollback();
                }
                return false;
            }
            
            // 2. Update data petugas
            String sql = "UPDATE petugas SET nama_petugas = ?, no_hp = ?, alamat = ? WHERE id_petugas = ?";
            try (PreparedStatement ps = conn.prepareStatement(sql)) {
                ps.setString(1, petugas.getNamaPetugas());
                ps.setString(2, petugas.getNoHp());
                ps.setString(3, petugas.getAlamat());
                ps.setInt(4, petugas.getIdPetugas());
                
                int rows = ps.executeUpdate();
                if (rows > 0) {
                    if (wasAutoCommit) {
                        conn.commit();
                    }
                    return true;
                }
            }
            
            if (wasAutoCommit) {
                conn.rollback();
            }
        } catch (SQLException e) {
            if (wasAutoCommit) {
                try {
                    conn.rollback();
                } catch (SQLException ex) {
                    ex.printStackTrace();
                }
            }
            e.printStackTrace();
        } finally {
            if (wasAutoCommit) {
                try {
                    conn.setAutoCommit(true);
                } catch (SQLException e) {
                    e.printStackTrace();
                }
            }
        }
        return false;
    }

    // Fungsi ini digunakan untuk menghapus data petugas beserta akun login-nya secara transaksional
    public boolean deletePetugas(int idPetugas, int idUser) {
        boolean wasAutoCommit = true;
        try {
            wasAutoCommit = conn.getAutoCommit();
            if (wasAutoCommit) {
                conn.setAutoCommit(false);
            }
            
            // 1. Hapus petugas (foreign key Cascade atau delete manual)
            String sqlPetugas = "DELETE FROM petugas WHERE id_petugas = ?";
            try (PreparedStatement ps = conn.prepareStatement(sqlPetugas)) {
                ps.setInt(1, idPetugas);
                ps.executeUpdate();
            }
            
            // 2. Hapus user (akan menghapus baris di users)
            boolean userDeleted = userDAO.deleteUser(idUser);
            if (userDeleted) {
                if (wasAutoCommit) {
                    conn.commit();
                }
                return true;
            }
            
            if (wasAutoCommit) {
                conn.rollback();
            }
        } catch (SQLException e) {
            if (wasAutoCommit) {
                try {
                    conn.rollback();
                } catch (SQLException ex) {
                    ex.printStackTrace();
                }
            }
            e.printStackTrace();
        } finally {
            if (wasAutoCommit) {
                try {
                    conn.setAutoCommit(true);
                } catch (SQLException e) {
                    e.printStackTrace();
                }
            }
        }
        return false;
    }
}
