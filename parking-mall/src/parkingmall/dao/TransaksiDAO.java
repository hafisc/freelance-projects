package parkingmall.dao;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import parkingmall.config.DatabaseConnection;
import parkingmall.model.Transaksi;

public class TransaksiDAO {
    private final Connection conn;
    private final KendaraanDAO kendaraanDAO;
    private final SlotParkirDAO slotDAO;

    public TransaksiDAO() {
        this.conn = DatabaseConnection.getConnection();
        this.kendaraanDAO = new KendaraanDAO();
        this.slotDAO = new SlotParkirDAO();
    }

    // Fungsi ini digunakan untuk mencatat transaksi masuk baru (untuk kendaraan non-booking)
    public boolean insertTransaksiMasuk(Transaksi trx) {
        String sql = "INSERT INTO transaksi_parkir (kode_transaksi, id_kendaraan, waktu_masuk, status) VALUES (?, ?, ?, 'berjalan')";
        try (PreparedStatement ps = conn.prepareStatement(sql)) {
            ps.setString(1, trx.getKodeTransaksi());
            ps.setInt(2, trx.getIdKendaraan());
            ps.setTimestamp(3, new java.sql.Timestamp(trx.getWaktuMasuk().getTime()));
            return ps.executeUpdate() > 0;
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return false;
    }

    // Fungsi ini digunakan untuk mencari transaksi parkir yang sedang berjalan berdasarkan plat nomor atau kode slot
    public Transaksi findTransaksiAktif(String keyword) {
        String sql = "SELECT t.*, k.plat_nomor, k.jenis_kendaraan, k.id_slot, s.kode_slot, l.nama_lantai, b.kode_booking " +
                     "FROM transaksi_parkir t " +
                     "JOIN kendaraan k ON t.id_kendaraan = k.id_kendaraan " +
                     "LEFT JOIN slot_parkir s ON k.id_slot = s.id_slot " +
                     "LEFT JOIN lantai l ON s.id_lantai = l.id_lantai " +
                     "LEFT JOIN booking b ON t.id_booking = b.id_booking " +
                     "WHERE t.status = 'berjalan' AND (k.plat_nomor = ? OR s.kode_slot = ? OR t.kode_transaksi = ?)";
        try (PreparedStatement ps = conn.prepareStatement(sql)) {
            ps.setString(1, keyword);
            ps.setString(2, keyword);
            ps.setString(3, keyword);
            try (ResultSet rs = ps.executeQuery()) {
                if (rs.next()) {
                    Transaksi trx = new Transaksi(
                        rs.getInt("id_transaksi"),
                        rs.getString("kode_transaksi"),
                        rs.getInt("id_kendaraan"),
                        rs.getObject("id_booking") != null ? rs.getInt("id_booking") : null,
                        rs.getTimestamp("waktu_masuk"),
                        rs.getTimestamp("waktu_keluar"),
                        rs.getInt("durasi_jam"),
                        rs.getInt("total_bayar"),
                        rs.getString("status"),
                        rs.getTimestamp("created_at")
                    );
                    trx.setPlatNomor(rs.getString("plat_nomor"));
                    trx.setJenisKendaraan(rs.getString("jenis_kendaraan"));
                    trx.setKodeSlot(rs.getString("kode_slot"));
                    trx.setNamaLantai(rs.getString("nama_lantai"));
                    trx.setKodeBooking(rs.getString("kode_booking"));
                    return trx;
                }
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return null;
    }

    // Fungsi ini digunakan untuk memproses checkout/kendaraan keluar secara transaksional
    // Ini mengupdate transaksi, status kendaraan, status slot, dan status booking (jika dari booking)
    public boolean checkoutTransaksi(int idTransaksi, int idKendaraan, Integer idSlot, Integer idBooking, 
                                     java.util.Date waktuKeluar, int durasiJam, int totalBayar) {
        boolean wasAutoCommit = true;
        try {
            wasAutoCommit = conn.getAutoCommit();
            if (wasAutoCommit) {
                conn.setAutoCommit(false);
            }
            
            // 1. Update data transaksi
            String sqlTrx = "UPDATE transaksi_parkir SET waktu_keluar = ?, durasi_jam = ?, total_bayar = ?, status = 'selesai' " +
                            "WHERE id_transaksi = ?";
            try (PreparedStatement ps = conn.prepareStatement(sqlTrx)) {
                ps.setTimestamp(1, new java.sql.Timestamp(waktuKeluar.getTime()));
                ps.setInt(2, durasiJam);
                ps.setInt(3, totalBayar);
                ps.setInt(4, idTransaksi);
                int rows = ps.executeUpdate();
                if (rows == 0) {
                    if (wasAutoCommit) {
                        conn.rollback();
                    }
                    return false;
                }
            }
            
            // 2. Update data kendaraan
            boolean kendaraanUpdated = kendaraanDAO.updateKendaraanKeluar(idKendaraan, idSlot != null ? idSlot : 0, waktuKeluar);
            if (!kendaraanUpdated) {
                if (wasAutoCommit) {
                    conn.rollback();
                }
                return false;
            }
            
            // 3. Update status booking ke 'selesai' (jika ada)
            if (idBooking != null && idBooking > 0) {
                String sqlBooking = "UPDATE booking SET status = 'selesai' WHERE id_booking = ?";
                try (PreparedStatement ps = conn.prepareStatement(sqlBooking)) {
                    ps.setInt(1, idBooking);
                    ps.executeUpdate();
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

    // Fungsi ini digunakan untuk mengambil data transaksi untuk kebutuhan Laporan Parkir (dengan filter opsional)
    public List<Transaksi> getLaporanParkir(String tglMulai, String tglSelesai, String jenisKendaraan) {
        List<Transaksi> list = new ArrayList<>();
        StringBuilder sql = new StringBuilder(
            "SELECT t.*, k.plat_nomor, k.jenis_kendaraan, s.kode_slot, l.nama_lantai, b.kode_booking " +
            "FROM transaksi_parkir t " +
            "JOIN kendaraan k ON t.id_kendaraan = k.id_kendaraan " +
            "LEFT JOIN slot_parkir s ON k.id_slot = s.id_slot " +
            "LEFT JOIN lantai l ON s.id_lantai = l.id_lantai " +
            "LEFT JOIN booking b ON t.id_booking = b.id_booking " +
            "WHERE t.status = 'selesai' "
        );
        
        if (tglMulai != null && !tglMulai.isEmpty()) {
            sql.append("AND DATE(t.waktu_masuk) >= ? ");
        }
        if (tglSelesai != null && !tglSelesai.isEmpty()) {
            sql.append("AND DATE(t.waktu_masuk) <= ? ");
        }
        if (jenisKendaraan != null && !jenisKendaraan.equalsIgnoreCase("Semua")) {
            sql.append("AND k.jenis_kendaraan = ? ");
        }
        
        sql.append("ORDER BY t.waktu_keluar DESC");
        
        try (PreparedStatement ps = conn.prepareStatement(sql.toString())) {
            int paramIndex = 1;
            if (tglMulai != null && !tglMulai.isEmpty()) {
                ps.setString(paramIndex++, tglMulai);
            }
            if (tglSelesai != null && !tglSelesai.isEmpty()) {
                ps.setString(paramIndex++, tglSelesai);
            }
            if (jenisKendaraan != null && !jenisKendaraan.equalsIgnoreCase("Semua")) {
                ps.setString(paramIndex++, jenisKendaraan.toLowerCase());
            }
            
            try (ResultSet rs = ps.executeQuery()) {
                while (rs.next()) {
                    Transaksi trx = new Transaksi(
                        rs.getInt("id_transaksi"),
                        rs.getString("kode_transaksi"),
                        rs.getInt("id_kendaraan"),
                        rs.getObject("id_booking") != null ? rs.getInt("id_booking") : null,
                        rs.getTimestamp("waktu_masuk"),
                        rs.getTimestamp("waktu_keluar"),
                        rs.getInt("durasi_jam"),
                        rs.getInt("total_bayar"),
                        rs.getString("status"),
                        rs.getTimestamp("created_at")
                    );
                    trx.setPlatNomor(rs.getString("plat_nomor"));
                    trx.setJenisKendaraan(rs.getString("jenis_kendaraan"));
                    trx.setKodeSlot(rs.getString("kode_slot"));
                    trx.setNamaLantai(rs.getString("nama_lantai"));
                    trx.setKodeBooking(rs.getString("kode_booking"));
                    list.add(trx);
                }
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return list;
    }

    // Fungsi ini digunakan untuk mengambil data statistik/ringkasan dashboard admin
    public Map<String, Integer> getStatistikDashboard() {
        Map<String, Integer> stats = new HashMap<>();
        
        // Default values
        stats.put("total_slot", 0);
        stats.put("slot_tersedia", 0);
        stats.put("slot_dibooking", 0);
        stats.put("slot_terisi", 0);
        stats.put("kendaraan_hari_ini", 0);
        stats.put("pendapatan_hari_ini", 0);

        try {
            // 1. Hitung total slot dan slot per status
            String sqlSlot = "SELECT status, COUNT(*) as jumlah FROM slot_parkir GROUP BY status";
            try (PreparedStatement ps = conn.prepareStatement(sqlSlot);
                 ResultSet rs = ps.executeQuery()) {
                int total = 0;
                while (rs.next()) {
                    String status = rs.getString("status");
                    int jumlah = rs.getInt("jumlah");
                    stats.put("slot_" + status, jumlah);
                    total += jumlah;
                }
                stats.put("total_slot", total);
            }

            // 2. Hitung kendaraan masuk hari ini
            String sqlKendaraan = "SELECT " +
                                  "COUNT(*) as total, " +
                                  "SUM(CASE WHEN jenis_kendaraan = 'motor' THEN 1 ELSE 0 END) as motor, " +
                                  "SUM(CASE WHEN jenis_kendaraan = 'mobil' THEN 1 ELSE 0 END) as mobil " +
                                  "FROM kendaraan WHERE DATE(waktu_masuk) = CURDATE()";
            try (PreparedStatement ps = conn.prepareStatement(sqlKendaraan);
                 ResultSet rs = ps.executeQuery()) {
                if (rs.next()) {
                    stats.put("kendaraan_hari_ini", rs.getInt("total"));
                    stats.put("motor_hari_ini", rs.getInt("motor"));
                    stats.put("mobil_hari_ini", rs.getInt("mobil"));
                }
            }

            // 3. Hitung pendapatan hari ini
            String sqlPendapatan = "SELECT SUM(total_bayar) as jumlah FROM transaksi_parkir " +
                                   "WHERE status = 'selesai' AND DATE(waktu_keluar) = CURDATE()";
            try (PreparedStatement ps = conn.prepareStatement(sqlPendapatan);
                 ResultSet rs = ps.executeQuery()) {
                if (rs.next()) {
                    stats.put("pendapatan_hari_ini", rs.getInt("jumlah"));
                }
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        
        return stats;
    }
}
