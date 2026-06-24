package com.lauraprinting.ui.panel;

import com.lauraprinting.dao.OrderDAO;
import com.lauraprinting.model.Order;
import com.lauraprinting.ui.component.ModernCard;
import com.lauraprinting.ui.component.StatusTableCellRenderer;

import javax.swing.*;
import javax.swing.border.EmptyBorder;
import javax.swing.table.DefaultTableModel;
import javax.swing.table.DefaultTableCellRenderer;
import java.awt.*;
import java.text.SimpleDateFormat;
import java.util.List;

public class DashboardPanel extends JPanel {
    private final OrderDAO orderDAO = new OrderDAO();
    private ModernCard cardRevenue;
    private ModernCard cardPendingOrders;
    private ModernCard cardServices;
    private JTable recentOrdersTable;
    private DefaultTableModel tableModel;

    public DashboardPanel() {
        initComponents();
        refreshData();
    }

    private void initComponents() {
        setLayout(new BorderLayout());
        setBackground(new Color(248, 250, 252)); // Slate 50 background
        setBorder(new EmptyBorder(25, 25, 25, 25));

        // Panel Judul Utama
        JPanel headerPanel = new JPanel(new BorderLayout());
        headerPanel.setOpaque(false);
        
        JLabel lblTitle = new JLabel("Ringkasan Dashboard");
        lblTitle.setFont(new Font("Segoe UI", Font.BOLD, 24));
        lblTitle.setForeground(new Color(15, 23, 42)); // Slate 900
        
        JLabel lblSubtitle = new JLabel("Pantau statistik transaksi dan jasa cetak Laura Printing secara real-time.");
        lblSubtitle.setFont(new Font("Segoe UI", Font.PLAIN, 14));
        lblSubtitle.setForeground(new Color(100, 116, 139)); // Slate 500
        
        JButton btnRefresh = new JButton("Perbarui Data");
        btnRefresh.setFont(new Font("Segoe UI", Font.BOLD, 12));
        btnRefresh.putClientProperty("JButton.buttonType", "roundRect");
        btnRefresh.putClientProperty("JComponent.roundRect", true); // Sudut melengkung penuh
        btnRefresh.setCursor(new Cursor(Cursor.HAND_CURSOR));
        btnRefresh.addActionListener(e -> refreshData());

        JPanel titleContainer = new JPanel();
        titleContainer.setLayout(new BoxLayout(titleContainer, BoxLayout.Y_AXIS));
        titleContainer.setOpaque(false);
        titleContainer.add(lblTitle);
        titleContainer.add(Box.createVerticalStrut(4));
        titleContainer.add(lblSubtitle);

        headerPanel.add(titleContainer, BorderLayout.WEST);
        headerPanel.add(btnRefresh, BorderLayout.EAST);

        // Panel Kartu Statistik Utama (Gaya modern, tidak kaku)
        JPanel cardsPanel = new JPanel(new GridLayout(1, 3, 20, 0));
        cardsPanel.setOpaque(false);
        cardsPanel.setBorder(new EmptyBorder(20, 0, 25, 0));

        cardRevenue = new ModernCard("Pendapatan Hari Ini", "Rp 0", new Color(16, 185, 129)); // Hijau Emerald
        cardPendingOrders = new ModernCard("Pesanan Aktif (Proses)", "0 Pesanan", new Color(245, 158, 11)); // Amber Kuning
        cardServices = new ModernCard("Total Jasa Cetak", "0 Jasa", new Color(79, 70, 229)); // Biru Indigo

        cardsPanel.add(cardRevenue);
        cardsPanel.add(cardPendingOrders);
        cardsPanel.add(cardServices);

        // Panel Aktivitas Penjualan Terbaru (Tabel)
        JPanel contentPanel = new JPanel(new BorderLayout());
        contentPanel.setBackground(Color.WHITE);
        contentPanel.setBorder(BorderFactory.createCompoundBorder(
            BorderFactory.createLineBorder(new Color(226, 232, 240), 1, true),
            new EmptyBorder(20, 20, 20, 20)
        ));

        JLabel lblTableTitle = new JLabel("Daftar Transaksi Terbaru");
        lblTableTitle.setFont(new Font("Segoe UI", Font.BOLD, 16));
        lblTableTitle.setForeground(new Color(15, 23, 42));
        lblTableTitle.setBorder(new EmptyBorder(0, 0, 12, 0));

        // Konfigurasi Model Tabel
        String[] columns = {"ID Transaksi", "Tanggal", "Nama Pelanggan", "Total Harga", "Bayar", "Status"};
        tableModel = new DefaultTableModel(columns, 0) {
            @Override
            public boolean isCellEditable(int row, int column) {
                return false; // Tabel read-only
            }
        };

        // Styling Tabel agar Keren, Bersih, dan Proporsional
        recentOrdersTable = new JTable(tableModel);
        recentOrdersTable.setFont(new Font("Segoe UI", Font.PLAIN, 12));
        recentOrdersTable.setRowHeight(35);
        recentOrdersTable.setFocusable(false); // Mematikan garis fokus sel yang mengganggu
        
        // Memperbesar dan menata Header Tabel
        recentOrdersTable.getTableHeader().setFont(new Font("Segoe UI", Font.BOLD, 12));
        recentOrdersTable.getTableHeader().setBackground(new Color(241, 245, 249));
        recentOrdersTable.getTableHeader().setForeground(new Color(71, 85, 105));
        recentOrdersTable.getTableHeader().setPreferredSize(new Dimension(0, 32)); // Padding tinggi header
        
        recentOrdersTable.setSelectionBackground(new Color(224, 231, 255));
        recentOrdersTable.setSelectionForeground(new Color(79, 70, 229));
        
        // Desain modern tanpa garis vertikal
        recentOrdersTable.setShowGrid(true);
        recentOrdersTable.setShowVerticalLines(false);
        recentOrdersTable.setGridColor(new Color(241, 245, 249));

        // Konfigurasi lebar kolom proporsional (menggantikan lebar sama rata bawaan JTable)
        recentOrdersTable.getColumnModel().getColumn(0).setPreferredWidth(95);   // ID Transaksi
        recentOrdersTable.getColumnModel().getColumn(1).setPreferredWidth(140);  // Tanggal
        recentOrdersTable.getColumnModel().getColumn(2).setPreferredWidth(180);  // Nama Pelanggan
        recentOrdersTable.getColumnModel().getColumn(3).setPreferredWidth(110);  // Total Harga
        recentOrdersTable.getColumnModel().getColumn(4).setPreferredWidth(110);  // Bayar
        recentOrdersTable.getColumnModel().getColumn(5).setPreferredWidth(95);   // Status

        // Penyelarasan Posisi (Alignments) Sel Tabel secara rapi dan profesional
        DefaultTableCellRenderer centerRenderer = new DefaultTableCellRenderer();
        centerRenderer.setHorizontalAlignment(SwingConstants.CENTER);
        recentOrdersTable.getColumnModel().getColumn(0).setCellRenderer(centerRenderer); // ID Transaksi
        recentOrdersTable.getColumnModel().getColumn(1).setCellRenderer(centerRenderer); // Tanggal

        DefaultTableCellRenderer rightRenderer = new DefaultTableCellRenderer();
        rightRenderer.setHorizontalAlignment(SwingConstants.RIGHT);
        recentOrdersTable.getColumnModel().getColumn(3).setCellRenderer(rightRenderer); // Total Harga
        recentOrdersTable.getColumnModel().getColumn(4).setCellRenderer(rightRenderer); // Bayar

        // Pewarnaan status dengan renderer kustom
        recentOrdersTable.getColumnModel().getColumn(5).setCellRenderer(new StatusTableCellRenderer());

        JScrollPane tableScroll = new JScrollPane(recentOrdersTable);
        tableScroll.setBorder(BorderFactory.createEmptyBorder());

        contentPanel.add(lblTableTitle, BorderLayout.NORTH);
        contentPanel.add(tableScroll, BorderLayout.CENTER);

        // Gabungkan seluruh komponen ke layout utama
        add(headerPanel, BorderLayout.NORTH);
        
        JPanel centerWrapper = new JPanel(new BorderLayout());
        centerWrapper.setOpaque(false);
        centerWrapper.add(cardsPanel, BorderLayout.NORTH);
        centerWrapper.add(contentPanel, BorderLayout.CENTER);
        
        add(centerWrapper, BorderLayout.CENTER);
    }

    // Memuat ulang data dari database
    public void refreshData() {
        double todayRevenue = orderDAO.getTodayRevenue();
        int pendingOrders = orderDAO.getPendingOrdersCount();
        int totalServices = orderDAO.getServicesCount();

        cardRevenue.setValue("Rp " + String.format("%,.0f", todayRevenue));
        cardPendingOrders.setValue(pendingOrders + " Pesanan");
        cardServices.setValue(totalServices + " Jasa");

        // Muat 10 transaksi teranyar
        tableModel.setRowCount(0);
        List<Order> orders = orderDAO.getAllOrders();
        int limit = Math.min(orders.size(), 10);
        
        SimpleDateFormat sdf = new SimpleDateFormat("dd MMM yyyy, HH:mm");
        
        for (int i = 0; i < limit; i++) {
            Order order = orders.get(i);
            String formattedDate = sdf.format(order.getOrderDate());
            tableModel.addRow(new Object[]{
                "TRX-" + String.format("%04d", order.getId()),
                formattedDate,
                order.getCustomerName(),
                "Rp " + String.format("%,.0f", order.getTotalAmount()),
                "Rp " + String.format("%,.0f", order.getPaidAmount()),
                order.getStatus()
            });
        }
    }
}
