package parkingmall.dao;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;
import parkingmall.config.DatabaseConnection;
import parkingmall.model.Kendaraan;

public class KendaraanDAO {
    private final Connection conn;
    private final SlotParkirDAO slotDAO;

    public KendaraanDAO() {
        this.conn = DatabaseConnection.getConnection();
        this.slotDAO = new SlotParkirDAO();
    }

    // Fungsi ini digunakan untuk mengambil data semua kendaraan yang statusnya masih 'masuk' (ada di parkiran)
    public List<Kendaraan> getKendaraanAktif() {
        List<Kendaraan> list = new ArrayList<>();
        String sql = "SELECT k.*, s.kode_slot, l.nama_lantai FROM kendaraan k " +
                     "LEFT JOIN slot_parkir s ON k.id_slot = s.id_slot " +
                     "LEFT JOIN lantai l ON s.id_lantai = l.id_lantai " +
                     "WHERE k.status = 'masuk' ORDER BY k.waktu_masuk DESC";
        try (PreparedStatement ps = conn.prepareStatement(sql);
             ResultSet rs = ps.executeQuery()) {
            while (rs.next()) {
                Kendaraan k = new Kendaraan(
                    rs.getInt("id_kendaraan"),
                    rs.getString("plat_nomor"),
                    rs.getString("jenis_kendaraan"),
                    rs.getObject("id_slot") != null ? rs.getInt("id_slot") : null,
                    rs.getTimestamp("waktu_masuk"),
                    rs.getTimestamp("waktu_keluar"),
                    rs.getString("status"),
                    rs.getTimestamp("created_at")
                );
                k.setKodeSlot(rs.getString("kode_slot"));
                k.setNamaLantai(rs.getString("nama_lantai"));
                list.add(k);
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return list;
    }

    // Fungsi ini digunakan untuk mencari kendaraan aktif berdasarkan plat nomor atau kode slot
    public Kendaraan findKendaraanAktif(String keyword) {
        String sql = "SELECT k.*, s.kode_slot, l.nama_lantai FROM kendaraan k " +
                     "LEFT JOIN slot_parkir s ON k.id_slot = s.id_slot " +
                     "LEFT JOIN lantai l ON s.id_lantai = l.id_lantai " +
                     "WHERE k.status = 'masuk' AND (k.plat_nomor = ? OR s.kode_slot = ?)";
        try (PreparedStatement ps = conn.prepareStatement(sql)) {
            ps.setString(1, keyword);
            ps.setString(2, keyword);
            try (ResultSet rs = ps.executeQuery()) {
                if (rs.next()) {
                    Kendaraan k = new Kendaraan(
                        rs.getInt("id_kendaraan"),
                        rs.getString("plat_nomor"),
                        rs.getString("jenis_kendaraan"),
                        rs.getObject("id_slot") != null ? rs.getInt("id_slot") : null,
                        rs.getTimestamp("waktu_masuk"),
                        rs.getTimestamp("waktu_keluar"),
                        rs.getString("status"),
                        rs.getTimestamp("created_at")
                    );
                    k.setKodeSlot(rs.getString("kode_slot"));
                    k.setNamaLantai(rs.getString("nama_lantai"));
                    return k;
                }
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return null;
    }

    // Fungsi ini digunakan untuk mencatat kendaraan masuk secara transaksional
    public int insertKendaraanMasuk(Kendaraan kendaraan) {
        boolean wasAutoCommit = true;
        try {
            wasAutoCommit = conn.getAutoCommit();
            if (wasAutoCommit) {
                conn.setAutoCommit(false);
            }
            
            // 1. Simpan data kendaraan ke database
            String sql = "INSERT INTO kendaraan (plat_nomor, jenis_kendaraan, id_slot, waktu_masuk, status) VALUES (?, ?, ?, ?, 'masuk')";
            int idKendaraan = -1;
            try (PreparedStatement ps = conn.prepareStatement(sql, Statement.RETURN_GENERATED_KEYS)) {
                ps.setString(1, kendaraan.getPlatNomor());
                ps.setString(2, kendaraan.getJenisKendaraan());
                if (kendaraan.getIdSlot() != null) {
                    ps.setInt(3, kendaraan.getIdSlot());
                } else {
                    ps.setNull(3, java.sql.Types.INTEGER);
                }
                ps.setTimestamp(4, new java.sql.Timestamp(kendaraan.getWaktuMasuk().getTime()));
                
                int affectedRows = ps.executeUpdate();
                if (affectedRows > 0) {
                    try (ResultSet generatedKeys = ps.getGeneratedKeys()) {
                        if (generatedKeys.next()) {
                            idKendaraan = generatedKeys.getInt(1);
                        }
                    }
                }
            }
            
            // 2. Jika sukses dan slot parkir diset, ubah status slot menjadi 'terisi'
            if (idKendaraan != -1 && kendaraan.getIdSlot() != null) {
                boolean slotUpdated = slotDAO.updateStatusSlot(kendaraan.getIdSlot(), "terisi");
                if (slotUpdated) {
                    if (wasAutoCommit) {
                        conn.commit();
                    }
                    return idKendaraan;
                }
            } else if (idKendaraan != -1) {
                if (wasAutoCommit) {
                    conn.commit();
                }
                return idKendaraan;
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
        return -1;
    }

    // Fungsi ini digunakan untuk mencatat kendaraan keluar secara transaksional
    public boolean updateKendaraanKeluar(int idKendaraan, int idSlot, java.util.Date waktuKeluar) {
        boolean wasAutoCommit = true;
        try {
            wasAutoCommit = conn.getAutoCommit();
            if (wasAutoCommit) {
                conn.setAutoCommit(false);
            }
            
            // 1. Update waktu keluar dan status kendaraan
            String sql = "UPDATE kendaraan SET waktu_keluar = ?, status = 'keluar' WHERE id_kendaraan = ?";
            try (PreparedStatement ps = conn.prepareStatement(sql)) {
                ps.setTimestamp(1, new java.sql.Timestamp(waktuKeluar.getTime()));
                ps.setInt(2, idKendaraan);
                int rows = ps.executeUpdate();
                if (rows == 0) {
                    if (wasAutoCommit) {
                        conn.rollback();
                    }
                    return false;
                }
            }
            
            // 2. Kembalikan status slot menjadi 'tersedia' jika ada slot
            if (idSlot > 0) {
                boolean slotUpdated = slotDAO.updateStatusSlot(idSlot, "tersedia");
                if (!slotUpdated) {
                    if (wasAutoCommit) {
                        conn.rollback();
                    }
                    return false;
                }
            }
            
            if (wasAutoCommit) {
                conn.commit();
            }
            return true;
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
