package parkingmall.dao;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;
import parkingmall.config.DatabaseConnection;
import parkingmall.model.Booking;
import parkingmall.model.Kendaraan;
import parkingmall.model.Transaksi;

public class BookingDAO {
    private final Connection conn;
    private final SlotParkirDAO slotDAO;

    public BookingDAO() {
        this.conn = DatabaseConnection.getConnection();
        this.slotDAO = new SlotParkirDAO();
    }

    // Fungsi ini digunakan untuk menyimpan data booking baru oleh pengguna secara transaksional
    public boolean insertBooking(Booking booking) {
        boolean wasAutoCommit = true;
        try {
            wasAutoCommit = conn.getAutoCommit();
            if (wasAutoCommit) {
                conn.setAutoCommit(false);
            }
            
            // 1. Simpan ke tabel booking
            String sql = "INSERT INTO booking (kode_booking, id_user, id_slot, plat_nomor, jenis_kendaraan, waktu_booking, status) VALUES (?, ?, ?, ?, ?, ?, 'menunggu')";
            try (PreparedStatement ps = conn.prepareStatement(sql)) {
                ps.setString(1, booking.getKodeBooking());
                ps.setInt(2, booking.getIdUser());
                ps.setInt(3, booking.getIdSlot());
                ps.setString(4, booking.getPlatNomor());
                ps.setString(5, booking.getJenisKendaraan());
                ps.setTimestamp(6, new java.sql.Timestamp(booking.getWaktuBooking().getTime()));
                
                int affectedRows = ps.executeUpdate();
                if (affectedRows == 0) {
                    if (wasAutoCommit) {
                        conn.rollback();
                    }
                    return false;
                }
            }
            
            // 2. Ubah status slot parkir menjadi 'dibooking'
            boolean slotUpdated = slotDAO.updateStatusSlot(booking.getIdSlot(), "dibooking");
            if (slotUpdated) {
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

    // Fungsi ini digunakan untuk mengambil data booking berdasarkan ID Pengguna
    public List<Booking> getBookingByUser(int idUser) {
        List<Booking> list = new ArrayList<>();
        String sql = "SELECT b.*, s.kode_slot, l.nama_lantai FROM booking b " +
                     "JOIN slot_parkir s ON b.id_slot = s.id_slot " +
                     "JOIN lantai l ON s.id_lantai = l.id_lantai " +
                     "WHERE b.id_user = ? ORDER BY b.id_booking DESC";
        try (PreparedStatement ps = conn.prepareStatement(sql)) {
            ps.setInt(1, idUser);
            try (ResultSet rs = ps.executeQuery()) {
                while (rs.next()) {
                    Booking b = new Booking(
                        rs.getInt("id_booking"),
                        rs.getString("kode_booking"),
                        rs.getInt("id_user"),
                        rs.getInt("id_slot"),
                        rs.getString("plat_nomor"),
                        rs.getString("jenis_kendaraan"),
                        rs.getTimestamp("waktu_booking"),
                        rs.getString("status"),
                        rs.getTimestamp("created_at")
                    );
                    b.setKodeSlot(rs.getString("kode_slot"));
                    b.setNamaLantai(rs.getString("nama_lantai"));
                    list.add(b);
                }
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return list;
    }

    // Fungsi ini digunakan untuk mengambil semua booking dengan status 'menunggu' untuk diverifikasi petugas
    public List<Booking> getPendingBooking() {
        List<Booking> list = new ArrayList<>();
        String sql = "SELECT b.*, u.nama as nama_pengguna, s.kode_slot, l.nama_lantai FROM booking b " +
                     "JOIN users u ON b.id_user = u.id_user " +
                     "JOIN slot_parkir s ON b.id_slot = s.id_slot " +
                     "JOIN lantai l ON s.id_lantai = l.id_lantai " +
                     "WHERE b.status = 'menunggu' ORDER BY b.id_booking DESC";
        try (PreparedStatement ps = conn.prepareStatement(sql);
             ResultSet rs = ps.executeQuery()) {
            while (rs.next()) {
                Booking b = new Booking(
                    rs.getInt("id_booking"),
                    rs.getString("kode_booking"),
                    rs.getInt("id_user"),
                    rs.getInt("id_slot"),
                    rs.getString("plat_nomor"),
                    rs.getString("jenis_kendaraan"),
                    rs.getTimestamp("waktu_booking"),
                    rs.getString("status"),
                    rs.getTimestamp("created_at")
                );
                b.setNamaPengguna(rs.getString("nama_pengguna"));
                b.setKodeSlot(rs.getString("kode_slot"));
                b.setNamaLantai(rs.getString("nama_lantai"));
                list.add(b);
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return list;
    }

    // Fungsi ini digunakan untuk mencari data booking aktif berdasarkan kode booking
    public Booking findBookingByKode(String kodeBooking) {
        String sql = "SELECT b.*, u.nama as nama_pengguna, s.kode_slot, l.nama_lantai FROM booking b " +
                     "JOIN users u ON b.id_user = u.id_user " +
                     "JOIN slot_parkir s ON b.id_slot = s.id_slot " +
                     "JOIN lantai l ON s.id_lantai = l.id_lantai " +
                     "WHERE b.kode_booking = ? AND b.status = 'menunggu'";
        try (PreparedStatement ps = conn.prepareStatement(sql)) {
            ps.setString(1, kodeBooking);
            try (ResultSet rs = ps.executeQuery()) {
                if (rs.next()) {
                    Booking b = new Booking(
                        rs.getInt("id_booking"),
                        rs.getString("kode_booking"),
                        rs.getInt("id_user"),
                        rs.getInt("id_slot"),
                        rs.getString("plat_nomor"),
                        rs.getString("jenis_kendaraan"),
                        rs.getTimestamp("waktu_booking"),
                        rs.getString("status"),
                        rs.getTimestamp("created_at")
                    );
                    b.setNamaPengguna(rs.getString("nama_pengguna"));
                    b.setKodeSlot(rs.getString("kode_slot"));
                    b.setNamaLantai(rs.getString("nama_lantai"));
                    return b;
                }
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return null;
    }

    // Fungsi ini digunakan untuk membatalkan booking (oleh pengguna atau sistem)
    public boolean batalkanBooking(int idBooking, int idSlot) {
        boolean wasAutoCommit = true;
        try {
            wasAutoCommit = conn.getAutoCommit();
            if (wasAutoCommit) {
                conn.setAutoCommit(false);
            }
            
            // 1. Update status booking menjadi 'dibatalkan'
            String sql = "UPDATE booking SET status = 'dibatalkan' WHERE id_booking = ?";
            try (PreparedStatement ps = conn.prepareStatement(sql)) {
                ps.setInt(1, idBooking);
                int rows = ps.executeUpdate();
                if (rows == 0) {
                    if (wasAutoCommit) {
                        conn.rollback();
                    }
                    return false;
                }
            }
            
            // 2. Kembalikan status slot menjadi 'tersedia'
            boolean slotUpdated = slotDAO.updateStatusSlot(idSlot, "tersedia");
            if (slotUpdated) {
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

    // Fungsi ini digunakan untuk memverifikasi booking oleh petugas secara transaksional
    // Ini mengubah status booking, status slot, mencatat kendaraan masuk, dan memulai transaksi parkir
    public boolean verifikasiBooking(int idBooking, int idSlot, String platNomor, String jenisKendaraan, String kodeTransaksi) {
        boolean wasAutoCommit = true;
        try {
            wasAutoCommit = conn.getAutoCommit();
            if (wasAutoCommit) {
                conn.setAutoCommit(false);
            }
            
            // 1. Update status booking menjadi 'diverifikasi'
            String sqlBooking = "UPDATE booking SET status = 'diverifikasi' WHERE id_booking = ?";
            try (PreparedStatement ps = conn.prepareStatement(sqlBooking)) {
                ps.setInt(1, idBooking);
                int rows = ps.executeUpdate();
                if (rows == 0) {
                    if (wasAutoCommit) {
                        conn.rollback();
                    }
                    return false;
                }
            }
            
            // 2. Update status slot parkir menjadi 'terisi'
            boolean slotUpdated = slotDAO.updateStatusSlot(idSlot, "terisi");
            if (!slotUpdated) {
                if (wasAutoCommit) {
                    conn.rollback();
                }
                return false;
            }
            
            // 3. Tambahkan data kendaraan masuk
            String sqlKendaraan = "INSERT INTO kendaraan (plat_nomor, jenis_kendaraan, id_slot, waktu_masuk, status) VALUES (?, ?, ?, NOW(), 'masuk')";
            int idKendaraan = -1;
            try (PreparedStatement ps = conn.prepareStatement(sqlKendaraan, Statement.RETURN_GENERATED_KEYS)) {
                ps.setString(1, platNomor);
                ps.setString(2, jenisKendaraan);
                ps.setInt(3, idSlot);
                int rows = ps.executeUpdate();
                if (rows > 0) {
                    try (ResultSet generatedKeys = ps.getGeneratedKeys()) {
                        if (generatedKeys.next()) {
                            idKendaraan = generatedKeys.getInt(1);
                        }
                    }
                }
            }
            
            if (idKendaraan == -1) {
                if (wasAutoCommit) {
                    conn.rollback();
                }
                return false;
            }
            
            // 4. Buat data transaksi parkir awal
            String sqlTransaksi = "INSERT INTO transaksi_parkir (kode_transaksi, id_kendaraan, id_booking, waktu_masuk, status) VALUES (?, ?, ?, NOW(), 'berjalan')";
            try (PreparedStatement ps = conn.prepareStatement(sqlTransaksi)) {
                ps.setString(1, kodeTransaksi);
                ps.setInt(2, idKendaraan);
                ps.setInt(3, idBooking);
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
}
