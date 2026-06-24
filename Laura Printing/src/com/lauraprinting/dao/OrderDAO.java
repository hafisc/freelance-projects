package com.lauraprinting.dao;

import com.lauraprinting.config.DatabaseConfig;
import com.lauraprinting.model.Order;
import com.lauraprinting.model.OrderDetail;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class OrderDAO {

    public boolean createOrder(Order order) {
        String insertOrderSQL = "INSERT INTO orders (customer_id, total_amount, paid_amount, status) VALUES (?, ?, ?, ?)";
        String insertDetailSQL = "INSERT INTO order_details (order_id, service_id, qty, price, subtotal) VALUES (?, ?, ?, ?, ?)";
        
        Connection conn = null;
        try {
            conn = DatabaseConfig.getConnection();
            conn.setAutoCommit(false); // Memulai transaksi database
            
            // 1. Masukkan data pesanan utama
            int orderId = -1;
            try (PreparedStatement psOrder = conn.prepareStatement(insertOrderSQL, Statement.RETURN_GENERATED_KEYS)) {
                if (order.getCustomerId() > 0) {
                    psOrder.setInt(1, order.getCustomerId());
                } else {
                    psOrder.setNull(1, Types.INTEGER);
                }
                psOrder.setDouble(2, order.getTotalAmount());
                psOrder.setDouble(3, order.getPaidAmount());
                psOrder.setString(4, order.getStatus());
                
                int affectedRows = psOrder.executeUpdate();
                if (affectedRows == 0) {
                    throw new SQLException("Creating order failed, no rows affected.");
                }
                
                try (ResultSet generatedKeys = psOrder.getGeneratedKeys()) {
                    if (generatedKeys.next()) {
                        orderId = generatedKeys.getInt(1);
                    } else {
                        throw new SQLException("Creating order failed, no ID obtained.");
                    }
                }
            }
            
            // 2. Masukkan rincian pesanan (item-item cetak)
            try (PreparedStatement psDetail = conn.prepareStatement(insertDetailSQL)) {
                for (OrderDetail detail : order.getOrderDetails()) {
                    psDetail.setInt(1, orderId);
                    if (detail.getServiceId() > 0) {
                        psDetail.setInt(2, detail.getServiceId());
                    } else {
                        psDetail.setNull(2, Types.INTEGER);
                    }
                    psDetail.setInt(3, detail.getQty());
                    psDetail.setDouble(4, detail.getPrice());
                    psDetail.setDouble(5, detail.getSubtotal());
                    psDetail.addBatch();
                }
                psDetail.executeBatch();
            }
            
            conn.commit(); // Komit transaksi jika berhasil
            order.setId(orderId); // Simpan ID transaksi yang dihasilkan ke model
            return true;
            
        } catch (SQLException e) {
            if (conn != null) {
                try {
                    conn.rollback(); // Batalkan transaksi jika terjadi kesalahan
                } catch (SQLException ex) {
                    ex.printStackTrace();
                }
            }
            e.printStackTrace();
            return false;
        } finally {
            if (conn != null) {
                try {
                    conn.setAutoCommit(true);
                    conn.close();
                } catch (SQLException e) {
                    e.printStackTrace();
                }
            }
        }
    }

    public List<Order> getAllOrders() {
        List<Order> list = new ArrayList<>();
        String sql = "SELECT o.*, c.name AS customer_name FROM orders o " +
                     "LEFT JOIN customers c ON o.customer_id = c.id " +
                     "ORDER BY o.order_date DESC";
        try (Connection conn = DatabaseConfig.getConnection();
             PreparedStatement ps = conn.prepareStatement(sql);
             ResultSet rs = ps.executeQuery()) {
            
            while (rs.next()) {
                String cName = rs.getString("customer_name");
                if (cName == null) {
                    cName = "General / Walk-in";
                }
                list.add(new Order(
                    rs.getInt("id"),
                    rs.getTimestamp("order_date"),
                    rs.getInt("customer_id"),
                    cName,
                    rs.getDouble("total_amount"),
                    rs.getDouble("paid_amount"),
                    rs.getString("status")
                ));
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return list;
    }

    public List<OrderDetail> getOrderDetails(int orderId) {
        List<OrderDetail> list = new ArrayList<>();
        String sql = "SELECT od.*, s.name AS service_name, s.unit AS service_unit FROM order_details od " +
                     "LEFT JOIN services s ON od.service_id = s.id " +
                     "WHERE od.order_id = ?";
        try (Connection conn = DatabaseConfig.getConnection();
             PreparedStatement ps = conn.prepareStatement(sql)) {
            
            ps.setInt(1, orderId);
            try (ResultSet rs = ps.executeQuery()) {
                while (rs.next()) {
                    String sName = rs.getString("service_name");
                    if (sName == null) sName = "Deleted Service";
                    String sUnit = rs.getString("service_unit");
                    if (sUnit == null) sUnit = "Unit";
                    
                    list.add(new OrderDetail(
                        rs.getInt("id"),
                        rs.getInt("order_id"),
                        rs.getInt("service_id"),
                        sName,
                        sUnit,
                        rs.getInt("qty"),
                        rs.getDouble("price"),
                        rs.getDouble("subtotal")
                    ));
                }
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return list;
    }

    public boolean updateOrderStatus(int orderId, String status) {
        String sql = "UPDATE orders SET status = ? WHERE id = ?";
        try (Connection conn = DatabaseConfig.getConnection();
             PreparedStatement ps = conn.prepareStatement(sql)) {
            
            ps.setString(1, status);
            ps.setInt(2, orderId);
            return ps.executeUpdate() > 0;
        } catch (SQLException e) {
            e.printStackTrace();
            return false;
        }
    }

    public boolean deleteOrder(int orderId) {
        String sql = "DELETE FROM orders WHERE id = ?";
        try (Connection conn = DatabaseConfig.getConnection();
             PreparedStatement ps = conn.prepareStatement(sql)) {
            
            ps.setInt(1, orderId);
            return ps.executeUpdate() > 0;
        } catch (SQLException e) {
            e.printStackTrace();
            return false;
        }
    }

    public List<Order> getOrdersByDateRange(Timestamp start, Timestamp end) {
        List<Order> list = new ArrayList<>();
        String sql = "SELECT o.*, c.name AS customer_name FROM orders o " +
                     "LEFT JOIN customers c ON o.customer_id = c.id " +
                     "WHERE o.order_date >= ? AND o.order_date <= ? " +
                     "ORDER BY o.order_date DESC";
        try (Connection conn = DatabaseConfig.getConnection();
             PreparedStatement ps = conn.prepareStatement(sql)) {
            
            ps.setTimestamp(1, start);
            ps.setTimestamp(2, end);
            
            try (ResultSet rs = ps.executeQuery()) {
                while (rs.next()) {
                    String cName = rs.getString("customer_name");
                    if (cName == null) cName = "General / Walk-in";
                    list.add(new Order(
                        rs.getInt("id"),
                        rs.getTimestamp("order_date"),
                        rs.getInt("customer_id"),
                        cName,
                        rs.getDouble("total_amount"),
                        rs.getDouble("paid_amount"),
                        rs.getString("status")
                    ));
                }
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return list;
    }

    // Pembantu Statistik Dashboard
    public double getTodayRevenue() {
        String sql = "SELECT SUM(total_amount) FROM orders WHERE DATE(order_date) = CURDATE()";
        try (Connection conn = DatabaseConfig.getConnection();
             PreparedStatement ps = conn.prepareStatement(sql);
             ResultSet rs = ps.executeQuery()) {
            if (rs.next()) {
                return rs.getDouble(1);
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return 0.0;
    }

    public int getPendingOrdersCount() {
        String sql = "SELECT COUNT(*) FROM orders WHERE status = 'Pending' OR status = 'Processing'";
        try (Connection conn = DatabaseConfig.getConnection();
             PreparedStatement ps = conn.prepareStatement(sql);
             ResultSet rs = ps.executeQuery()) {
            if (rs.next()) {
                return rs.getInt(1);
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return 0;
    }

    public int getServicesCount() {
        String sql = "SELECT COUNT(*) FROM services";
        try (Connection conn = DatabaseConfig.getConnection();
             PreparedStatement ps = conn.prepareStatement(sql);
             ResultSet rs = ps.executeQuery()) {
            if (rs.next()) {
                return rs.getInt(1);
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return 0;
    }
}
