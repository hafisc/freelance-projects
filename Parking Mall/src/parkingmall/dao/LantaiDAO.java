package parkingmall.dao;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;
import parkingmall.config.DatabaseConnection;
import parkingmall.model.Lantai;

public class LantaiDAO {
    private final Connection conn;

    public LantaiDAO() {
        this.conn = DatabaseConnection.getConnection();
    }

    // Fungsi ini digunakan untuk mengambil semua data lantai dari database
    public List<Lantai> getAllLantai() {
        List<Lantai> list = new ArrayList<>();
        String sql = "SELECT * FROM lantai ORDER BY id_lantai ASC";
        try (PreparedStatement ps = conn.prepareStatement(sql);
             ResultSet rs = ps.executeQuery()) {
            while (rs.next()) {
                list.add(new Lantai(
                    rs.getInt("id_lantai"),
                    rs.getString("nama_lantai"),
                    rs.getString("keterangan"),
                    rs.getTimestamp("created_at")
                ));
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return list;
    }

    // Fungsi ini digunakan untuk mengambil data satu lantai berdasarkan id
    public Lantai getLantaiById(int idLantai) {
        String sql = "SELECT * FROM lantai WHERE id_lantai = ?";
        try (PreparedStatement ps = conn.prepareStatement(sql)) {
            ps.setInt(1, idLantai);
            try (ResultSet rs = ps.executeQuery()) {
                if (rs.next()) {
                    return new Lantai(
                        rs.getInt("id_lantai"),
                        rs.getString("nama_lantai"),
                        rs.getString("keterangan"),
                        rs.getTimestamp("created_at")
                    );
                }
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return null;
    }

    // Fungsi ini digunakan untuk menyimpan data lantai baru ke database
    public boolean insertLantai(Lantai lantai) {
        String sql = "INSERT INTO lantai (nama_lantai, keterangan) VALUES (?, ?)";
        try (PreparedStatement ps = conn.prepareStatement(sql)) {
            ps.setString(1, lantai.getNamaLantai());
            ps.setString(2, lantai.getKeterangan());
            return ps.executeUpdate() > 0;
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return false;
    }

    // Fungsi ini digunakan untuk memperbarui data lantai di database
    public boolean updateLantai(Lantai lantai) {
        String sql = "UPDATE lantai SET nama_lantai = ?, keterangan = ? WHERE id_lantai = ?";
        try (PreparedStatement ps = conn.prepareStatement(sql)) {
            ps.setString(1, lantai.getNamaLantai());
            ps.setString(2, lantai.getKeterangan());
            ps.setInt(3, lantai.getIdLantai());
            return ps.executeUpdate() > 0;
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return false;
    }

    // Fungsi ini digunakan untuk menghapus data lantai di database
    public boolean deleteLantai(int idLantai) {
        String sql = "DELETE FROM lantai WHERE id_lantai = ?";
        try (PreparedStatement ps = conn.prepareStatement(sql)) {
            ps.setInt(1, idLantai);
            return ps.executeUpdate() > 0;
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return false;
    }
}
