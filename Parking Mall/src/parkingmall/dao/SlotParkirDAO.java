package parkingmall.dao;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;
import parkingmall.config.DatabaseConnection;
import parkingmall.model.SlotParkir;

public class SlotParkirDAO {
    private final Connection conn;

    public SlotParkirDAO() {
        this.conn = DatabaseConnection.getConnection();
    }

    // Fungsi ini digunakan untuk mengambil semua data slot parkir beserta nama lantai
    public List<SlotParkir> getAllSlot() {
        List<SlotParkir> list = new ArrayList<>();
        String sql = "SELECT s.*, l.nama_lantai FROM slot_parkir s " +
                     "JOIN lantai l ON s.id_lantai = l.id_lantai ORDER BY l.id_lantai ASC, s.kode_slot ASC";
        try (PreparedStatement ps = conn.prepareStatement(sql);
             ResultSet rs = ps.executeQuery()) {
            while (rs.next()) {
                SlotParkir slot = new SlotParkir(
                    rs.getInt("id_slot"),
                    rs.getInt("id_lantai"),
                    rs.getString("kode_slot"),
                    rs.getString("status"),
                    rs.getTimestamp("created_at")
                );
                slot.setNamaLantai(rs.getString("nama_lantai"));
                list.add(slot);
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return list;
    }

    // Fungsi ini digunakan untuk mengambil semua data slot parkir berdasarkan lantai tertentu
    public List<SlotParkir> getSlotByLantai(int idLantai) {
        List<SlotParkir> list = new ArrayList<>();
        String sql = "SELECT s.*, l.nama_lantai FROM slot_parkir s " +
                     "JOIN lantai l ON s.id_lantai = l.id_lantai " +
                     "WHERE s.id_lantai = ? ORDER BY s.kode_slot ASC";
        try (PreparedStatement ps = conn.prepareStatement(sql)) {
            ps.setInt(1, idLantai);
            try (ResultSet rs = ps.executeQuery()) {
                while (rs.next()) {
                    SlotParkir slot = new SlotParkir(
                        rs.getInt("id_slot"),
                        rs.getInt("id_lantai"),
                        rs.getString("kode_slot"),
                        rs.getString("status"),
                        rs.getTimestamp("created_at")
                    );
                    slot.setNamaLantai(rs.getString("nama_lantai"));
                    list.add(slot);
                }
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return list;
    }

    // Fungsi ini digunakan untuk mengambil semua slot parkir dengan status 'tersedia' berdasarkan lantai
    public List<SlotParkir> getAvailableSlotByLantai(int idLantai) {
        List<SlotParkir> list = new ArrayList<>();
        String sql = "SELECT s.*, l.nama_lantai FROM slot_parkir s " +
                     "JOIN lantai l ON s.id_lantai = l.id_lantai " +
                     "WHERE s.id_lantai = ? AND s.status = 'tersedia' ORDER BY s.kode_slot ASC";
        try (PreparedStatement ps = conn.prepareStatement(sql)) {
            ps.setInt(1, idLantai);
            try (ResultSet rs = ps.executeQuery()) {
                while (rs.next()) {
                    SlotParkir slot = new SlotParkir(
                        rs.getInt("id_slot"),
                        rs.getInt("id_lantai"),
                        rs.getString("kode_slot"),
                        rs.getString("status"),
                        rs.getTimestamp("created_at")
                    );
                    slot.setNamaLantai(rs.getString("nama_lantai"));
                    list.add(slot);
                }
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return list;
    }

    // Fungsi ini digunakan untuk memeriksa apakah kode slot sudah ada di lantai tersebut
    public boolean isKodeSlotExists(int idLantai, String kodeSlot) {
        String sql = "SELECT id_slot FROM slot_parkir WHERE id_lantai = ? AND kode_slot = ?";
        try (PreparedStatement ps = conn.prepareStatement(sql)) {
            ps.setInt(1, idLantai);
            ps.setString(2, kodeSlot);
            try (ResultSet rs = ps.executeQuery()) {
                return rs.next();
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return false;
    }

    // Fungsi ini digunakan untuk menyimpan data slot parkir baru ke database
    public boolean insertSlot(SlotParkir slot) {
        String sql = "INSERT INTO slot_parkir (id_lantai, kode_slot, status) VALUES (?, ?, ?)";
        try (PreparedStatement ps = conn.prepareStatement(sql)) {
            ps.setInt(1, slot.getIdLantai());
            ps.setString(2, slot.getKodeSlot());
            ps.setString(3, slot.getStatus() == null ? "tersedia" : slot.getStatus());
            return ps.executeUpdate() > 0;
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return false;
    }

    // Fungsi ini digunakan untuk memperbarui data slot parkir di database
    public boolean updateSlot(SlotParkir slot) {
        String sql = "UPDATE slot_parkir SET id_lantai = ?, kode_slot = ?, status = ? WHERE id_slot = ?";
        try (PreparedStatement ps = conn.prepareStatement(sql)) {
            ps.setInt(1, slot.getIdLantai());
            ps.setString(2, slot.getKodeSlot());
            ps.setString(3, slot.getStatus());
            ps.setInt(4, slot.getIdSlot());
            return ps.executeUpdate() > 0;
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return false;
    }

    // Fungsi ini digunakan untuk memperbarui status slot parkir saja (misal: 'tersedia', 'dibooking', 'terisi')
    public boolean updateStatusSlot(int idSlot, String status) {
        String sql = "UPDATE slot_parkir SET status = ? WHERE id_slot = ?";
        try (PreparedStatement ps = conn.prepareStatement(sql)) {
            ps.setString(1, status);
            ps.setInt(2, idSlot);
            return ps.executeUpdate() > 0;
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return false;
    }

    // Fungsi ini digunakan untuk menghapus data slot parkir di database
    public boolean deleteSlot(int idSlot) {
        String sql = "DELETE FROM slot_parkir WHERE id_slot = ?";
        try (PreparedStatement ps = conn.prepareStatement(sql)) {
            ps.setInt(1, idSlot);
            return ps.executeUpdate() > 0;
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return false;
    }
}
