package com.lauraprinting.ui.panel;

import com.lauraprinting.dao.OrderDAO;
import com.lauraprinting.model.Order;
import com.lauraprinting.model.OrderDetail;
import com.lauraprinting.model.User;

import javax.swing.*;
import javax.swing.border.EmptyBorder;
import javax.swing.table.DefaultTableModel;
import java.awt.*;
import java.sql.Timestamp;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.List;

public class ReportPanel extends JPanel {
    private final OrderDAO orderDAO = new OrderDAO();
    private final User currentUser;
    
    // Komponen Daftar Transaksi Utama
    private JTable ordersTable;
    private DefaultTableModel ordersTableModel;
    
    // Komponen Detail Transaksi Terpilih
    private JTable detailsTable;
    private DefaultTableModel detailsTableModel;
    
    // Form filter tanggal & ringkasan
    private JTextField txtStartDate;
    private JTextField txtEndDate;
    private JLabel lblTotalRevenue;
    
    private JButton btnFilter;
    private JButton btnReset;
    private JButton btnUpdateStatus;
    private JButton btnDeleteOrder;
    private JButton btnReprint;
    private JComboBox<String> cbStatusEdit;
    
    private List<Order> loadedOrders;
    private Order selectedOrder;

    public ReportPanel(User currentUser) {
        this.currentUser = currentUser;
        initComponents();
        resetFilters();
    }

    private void initComponents() {
        setLayout(new BorderLayout(0, 15));
        setBackground(new Color(248, 250, 252));
        setBorder(new EmptyBorder(25, 25, 25, 25));

        // Panel Header
        JPanel headerPanel = new JPanel(new BorderLayout());
        headerPanel.setOpaque(false);
        
        JLabel lblTitle = new JLabel("Laporan & Daftar Pesanan");
        lblTitle.setFont(new Font("Segoe UI", Font.BOLD, 24));
        lblTitle.setForeground(new Color(15, 23, 42));
        
        JLabel lblSubtitle = new JLabel("Lihat riwayat transaksi, edit status pesanan, dan cetak ulang nota.");
        lblSubtitle.setFont(new Font("Segoe UI", Font.PLAIN, 14));
        lblSubtitle.setForeground(new Color(100, 116, 139));

        JPanel titleContainer = new JPanel();
        titleContainer.setLayout(new BoxLayout(titleContainer, BoxLayout.Y_AXIS));
        titleContainer.setOpaque(false);
        titleContainer.add(lblTitle);
        titleContainer.add(Box.createVerticalStrut(4));
        titleContainer.add(lblSubtitle);
        
        headerPanel.add(titleContainer, BorderLayout.WEST);
        add(headerPanel, BorderLayout.NORTH);

        // Panel Filter Tanggal Pencarian
        JPanel filterCard = new JPanel(new FlowLayout(FlowLayout.LEFT, 15, 10));
        filterCard.setBackground(Color.WHITE);
        filterCard.setBorder(BorderFactory.createCompoundBorder(
            BorderFactory.createLineBorder(new Color(226, 232, 240), 1, true),
            new EmptyBorder(5, 10, 5, 10)
        ));

        JLabel lblStart = new JLabel("Tanggal Mulai:");
        lblStart.setFont(new Font("Segoe UI", Font.BOLD, 12));
        txtStartDate = new JTextField(10);
        txtStartDate.setFont(new Font("Segoe UI", Font.PLAIN, 13));
        txtStartDate.putClientProperty("JTextField.placeholderText", "YYYY-MM-DD");
        txtStartDate.putClientProperty("JComponent.roundRect", true);
        txtStartDate.putClientProperty("JTextField.showClearButton", true);

        JLabel lblEnd = new JLabel("Tanggal Selesai:");
        lblEnd.setFont(new Font("Segoe UI", Font.BOLD, 12));
        txtEndDate = new JTextField(10);
        txtEndDate.setFont(new Font("Segoe UI", Font.PLAIN, 13));
        txtEndDate.putClientProperty("JTextField.placeholderText", "YYYY-MM-DD");
        txtEndDate.putClientProperty("JComponent.roundRect", true);
        txtEndDate.putClientProperty("JTextField.showClearButton", true);

        btnFilter = new JButton("Filter Cari");
        btnFilter.setFont(new Font("Segoe UI", Font.BOLD, 12));
        btnFilter.putClientProperty("JButton.buttonType", "accent");
        btnFilter.putClientProperty("JComponent.roundRect", true);
        btnFilter.setCursor(new Cursor(Cursor.HAND_CURSOR));

        btnReset = new JButton("Reset");
        btnReset.setFont(new Font("Segoe UI", Font.BOLD, 12));
        btnReset.putClientProperty("JComponent.roundRect", true);
        btnReset.setCursor(new Cursor(Cursor.HAND_CURSOR));

        filterCard.add(lblStart);
        filterCard.add(txtStartDate);
        filterCard.add(lblEnd);
        filterCard.add(txtEndDate);
        filterCard.add(btnFilter);
        filterCard.add(btnReset);

        // Grid Split: Atas (Tabel Transaksi), Bawah (Detail Transaksi + Tombol Aksi)
        JSplitPane splitPane = new JSplitPane(JSplitPane.VERTICAL_SPLIT);
        splitPane.setDividerLocation(220);
        splitPane.setBorder(null);
        splitPane.setOpaque(false);

        // Panel Daftar Transaksi (Atas)
        JPanel ordersCard = new JPanel(new BorderLayout());
        ordersCard.setBackground(Color.WHITE);
        ordersCard.setBorder(BorderFactory.createCompoundBorder(
            BorderFactory.createLineBorder(new Color(226, 232, 240), 1, true),
            new EmptyBorder(15, 15, 15, 15)
        ));

        JLabel lblOrdersTitle = new JLabel("Daftar Transaksi Penjualan");
        lblOrdersTitle.setFont(new Font("Segoe UI", Font.BOLD, 14));
        lblOrdersTitle.setForeground(new Color(15, 23, 42));
        lblOrdersTitle.setBorder(new EmptyBorder(0, 0, 8, 0));

        String[] ordersCols = {"ID Transaksi", "Tanggal", "Nama Pelanggan", "Total Belanja", "Uang Bayar", "Status"};
        ordersTableModel = new DefaultTableModel(ordersCols, 0) {
            @Override
            public boolean isCellEditable(int row, int column) {
                return false;
            }
        };

        ordersTable = new JTable(ordersTableModel);
        ordersTable.setFont(new Font("Segoe UI", Font.PLAIN, 12));
        ordersTable.setRowHeight(32);
        ordersTable.setFocusable(false);
        
        // Memperbesar Header Tabel
        ordersTable.getTableHeader().setFont(new Font("Segoe UI", Font.BOLD, 12));
        ordersTable.getTableHeader().setBackground(new Color(241, 245, 249));
        ordersTable.getTableHeader().setForeground(new Color(71, 85, 105));
        ordersTable.getTableHeader().setPreferredSize(new Dimension(0, 32));
        
        ordersTable.setSelectionBackground(new Color(224, 231, 255));
        ordersTable.setSelectionForeground(new Color(79, 70, 229));
        
        // Desain modern tanpa garis vertikal
        ordersTable.setShowGrid(true);
        ordersTable.setShowVerticalLines(false);
        ordersTable.setGridColor(new Color(241, 245, 249));

        // Konfigurasi lebar kolom transaksi agar seimbang
        ordersTable.getColumnModel().getColumn(0).setPreferredWidth(95);   // ID Transaksi
        ordersTable.getColumnModel().getColumn(1).setPreferredWidth(140);  // Tanggal
        ordersTable.getColumnModel().getColumn(2).setPreferredWidth(180);  // Nama Pelanggan
        ordersTable.getColumnModel().getColumn(3).setPreferredWidth(110);  // Total Belanja
        ordersTable.getColumnModel().getColumn(4).setPreferredWidth(110);  // Uang Bayar
        ordersTable.getColumnModel().getColumn(5).setPreferredWidth(95);   // Status

        // Penyelarasan kolom tabel secara rapi dan profesional
        javax.swing.table.DefaultTableCellRenderer ordersCenterRenderer = new javax.swing.table.DefaultTableCellRenderer();
        ordersCenterRenderer.setHorizontalAlignment(SwingConstants.CENTER);
        ordersTable.getColumnModel().getColumn(0).setCellRenderer(ordersCenterRenderer); // ID Transaksi
        ordersTable.getColumnModel().getColumn(1).setCellRenderer(ordersCenterRenderer); // Tanggal

        javax.swing.table.DefaultTableCellRenderer ordersRightRenderer = new javax.swing.table.DefaultTableCellRenderer();
        ordersRightRenderer.setHorizontalAlignment(SwingConstants.RIGHT);
        ordersTable.getColumnModel().getColumn(3).setCellRenderer(ordersRightRenderer); // Total Belanja
        ordersTable.getColumnModel().getColumn(4).setCellRenderer(ordersRightRenderer); // Uang Bayar

        // Pewarnaan status dengan renderer kustom
        ordersTable.getColumnModel().getColumn(5).setCellRenderer(new com.lauraprinting.ui.component.StatusTableCellRenderer());

        JScrollPane ordersScroll = new JScrollPane(ordersTable);
        ordersScroll.setBorder(BorderFactory.createEmptyBorder());

        ordersCard.add(lblOrdersTitle, BorderLayout.NORTH);
        ordersCard.add(ordersScroll, BorderLayout.CENTER);
        splitPane.setTopComponent(ordersCard);

        // Panel Detail & Aksi Transaksi (Bawah)
        JPanel bottomCard = new JPanel(new BorderLayout(15, 0));
        bottomCard.setBackground(Color.WHITE);
        bottomCard.setBorder(BorderFactory.createCompoundBorder(
            BorderFactory.createLineBorder(new Color(226, 232, 240), 1, true),
            new EmptyBorder(15, 15, 15, 15)
        ));

        // Rincian Item Cetak (Kiri-Bawah)
        JPanel detailsSection = new JPanel(new BorderLayout());
        detailsSection.setOpaque(false);

        JLabel lblDetailsTitle = new JLabel("Detail Item Jasa Cetak");
        lblDetailsTitle.setFont(new Font("Segoe UI", Font.BOLD, 14));
        lblDetailsTitle.setForeground(new Color(15, 23, 42));
        lblDetailsTitle.setBorder(new EmptyBorder(0, 0, 8, 0));

        String[] detailsCols = {"Jasa Cetak", "Satuan", "Kuantitas", "Harga Satuan", "Subtotal"};
        detailsTableModel = new DefaultTableModel(detailsCols, 0) {
            @Override
            public boolean isCellEditable(int row, int column) {
                return false;
            }
        };

        detailsTable = new JTable(detailsTableModel);
        detailsTable.setFont(new Font("Segoe UI", Font.PLAIN, 12));
        detailsTable.setRowHeight(28);
        detailsTable.setFocusable(false);
        
        // Memperbesar Header Tabel Detail
        detailsTable.getTableHeader().setFont(new Font("Segoe UI", Font.BOLD, 12));
        detailsTable.getTableHeader().setBackground(new Color(241, 245, 249));
        detailsTable.getTableHeader().setForeground(new Color(71, 85, 105));
        detailsTable.getTableHeader().setPreferredSize(new Dimension(0, 32));
        
        detailsTable.setSelectionBackground(new Color(241, 245, 249));
        detailsTable.setSelectionForeground(Color.BLACK);
        
        // Desain modern tanpa garis vertikal
        detailsTable.setShowGrid(true);
        detailsTable.setShowVerticalLines(false);
        detailsTable.setGridColor(new Color(241, 245, 249));

        // Konfigurasi lebar kolom rincian agar seimbang
        detailsTable.getColumnModel().getColumn(0).setPreferredWidth(210);  // Jasa Cetak
        detailsTable.getColumnModel().getColumn(1).setPreferredWidth(80);   // Satuan
        detailsTable.getColumnModel().getColumn(2).setPreferredWidth(70);   // Kuantitas
        detailsTable.getColumnModel().getColumn(3).setPreferredWidth(100);  // Harga Satuan
        detailsTable.getColumnModel().getColumn(4).setPreferredWidth(110);  // Subtotal

        // Penyelarasan kolom tabel secara rapi dan profesional
        javax.swing.table.DefaultTableCellRenderer detailsCenterRenderer = new javax.swing.table.DefaultTableCellRenderer();
        detailsCenterRenderer.setHorizontalAlignment(SwingConstants.CENTER);
        detailsTable.getColumnModel().getColumn(1).setCellRenderer(detailsCenterRenderer); // Satuan
        detailsTable.getColumnModel().getColumn(2).setCellRenderer(detailsCenterRenderer); // Kuantitas

        javax.swing.table.DefaultTableCellRenderer detailsRightRenderer = new javax.swing.table.DefaultTableCellRenderer();
        detailsRightRenderer.setHorizontalAlignment(SwingConstants.RIGHT);
        detailsTable.getColumnModel().getColumn(3).setCellRenderer(detailsRightRenderer); // Harga Satuan
        detailsTable.getColumnModel().getColumn(4).setCellRenderer(detailsRightRenderer); // Subtotal

        JScrollPane detailsScroll = new JScrollPane(detailsTable);
        detailsScroll.setBorder(BorderFactory.createEmptyBorder());

        detailsSection.add(lblDetailsTitle, BorderLayout.NORTH);
        detailsSection.add(detailsScroll, BorderLayout.CENTER);
        bottomCard.add(detailsSection, BorderLayout.CENTER);

        // Aksi Pengubahan Status & Nota (Kanan-Bawah)
        JPanel actionsSection = new JPanel();
        actionsSection.setLayout(new BoxLayout(actionsSection, BoxLayout.Y_AXIS));
        actionsSection.setOpaque(false);
        actionsSection.setPreferredSize(new Dimension(220, 0));

        JLabel lblActTitle = new JLabel("Aksi Transaksi");
        lblActTitle.setFont(new Font("Segoe UI", Font.BOLD, 14));
        lblActTitle.setForeground(new Color(15, 23, 42));
        lblActTitle.setAlignmentX(Component.LEFT_ALIGNMENT);

        JLabel lblStatusEdit = new JLabel("Ubah Status:");
        lblStatusEdit.setFont(new Font("Segoe UI", Font.BOLD, 11));
        lblStatusEdit.setForeground(new Color(100, 116, 139));
        lblStatusEdit.setAlignmentX(Component.LEFT_ALIGNMENT);

        cbStatusEdit = new JComboBox<>(new String[]{"Pending", "Processing", "Done", "Picked Up"});
        cbStatusEdit.setFont(new Font("Segoe UI", Font.PLAIN, 12));
        cbStatusEdit.putClientProperty("JComponent.roundRect", true);
        cbStatusEdit.setMaximumSize(new Dimension(Integer.MAX_VALUE, 30));
        cbStatusEdit.setAlignmentX(Component.LEFT_ALIGNMENT);
        cbStatusEdit.setEnabled(false);

        btnUpdateStatus = new JButton("Simpan Status Baru");
        btnUpdateStatus.setFont(new Font("Segoe UI", Font.BOLD, 11));
        btnUpdateStatus.putClientProperty("JComponent.roundRect", true);
        btnUpdateStatus.setMaximumSize(new Dimension(Integer.MAX_VALUE, 30));
        btnUpdateStatus.setAlignmentX(Component.LEFT_ALIGNMENT);
        btnUpdateStatus.setEnabled(false);
        btnUpdateStatus.setCursor(new Cursor(Cursor.HAND_CURSOR));

        btnReprint = new JButton("Cetak Ulang Nota");
        btnReprint.setFont(new Font("Segoe UI", Font.BOLD, 11));
        btnReprint.putClientProperty("JComponent.roundRect", true);
        btnReprint.setMaximumSize(new Dimension(Integer.MAX_VALUE, 30));
        btnReprint.setAlignmentX(Component.LEFT_ALIGNMENT);
        btnReprint.setEnabled(false);
        btnReprint.setCursor(new Cursor(Cursor.HAND_CURSOR));

        btnDeleteOrder = new JButton("Hapus Transaksi");
        btnDeleteOrder.setFont(new Font("Segoe UI", Font.BOLD, 11));
        btnDeleteOrder.setForeground(Color.WHITE);
        btnDeleteOrder.setBackground(new Color(220, 38, 38)); // Red 600
        btnDeleteOrder.putClientProperty("JComponent.roundRect", true);
        btnDeleteOrder.setMaximumSize(new Dimension(Integer.MAX_VALUE, 30));
        btnDeleteOrder.setAlignmentX(Component.LEFT_ALIGNMENT);
        btnDeleteOrder.setEnabled(false);
        btnDeleteOrder.setCursor(new Cursor(Cursor.HAND_CURSOR));

        actionsSection.add(lblActTitle);
        actionsSection.add(Box.createVerticalStrut(15));
        actionsSection.add(lblStatusEdit);
        actionsSection.add(Box.createVerticalStrut(5));
        actionsSection.add(cbStatusEdit);
        actionsSection.add(Box.createVerticalStrut(5));
        actionsSection.add(btnUpdateStatus);
        actionsSection.add(Box.createVerticalStrut(15));
        actionsSection.add(btnReprint);
        actionsSection.add(Box.createVerticalStrut(15));
        actionsSection.add(btnDeleteOrder);
        actionsSection.add(Box.createVerticalGlue());

        bottomCard.add(actionsSection, BorderLayout.EAST);
        splitPane.setBottomComponent(bottomCard);

        // Panel Ringkasan Pendapatan (Bawah - Floating Rounded Card)
        JPanel summaryPanel = new JPanel(new BorderLayout()) {
            @Override
            protected void paintComponent(Graphics g) {
                Graphics2D g2 = (Graphics2D) g.create();
                g2.setRenderingHint(RenderingHints.KEY_ANTIALIASING, RenderingHints.VALUE_ANTIALIAS_ON);
                g2.setColor(new Color(79, 70, 229)); // Indigo 600
                g2.fillRoundRect(0, 0, getWidth(), getHeight(), 16, 16);
                g2.dispose();
            }
        };
        summaryPanel.setOpaque(false);
        summaryPanel.setBorder(new EmptyBorder(12, 20, 12, 20));
        
        JLabel lblTotalLabel = new JLabel("TOTAL PENDAPATAN (OMSET) DI FILTER:");
        lblTotalLabel.setFont(new Font("Segoe UI", Font.BOLD, 12));
        lblTotalLabel.setForeground(new Color(199, 210, 254)); // Indigo 200

        lblTotalRevenue = new JLabel("Rp 0");
        lblTotalRevenue.setFont(new Font("Segoe UI", Font.BOLD, 22));
        lblTotalRevenue.setForeground(Color.WHITE);

        summaryPanel.add(lblTotalLabel, BorderLayout.WEST);
        summaryPanel.add(lblTotalRevenue, BorderLayout.EAST);

        // Menyusun Panel
        add(filterCard, BorderLayout.NORTH);
        
        JPanel centerWrapper = new JPanel(new BorderLayout(0, 15));
        centerWrapper.setOpaque(false);
        centerWrapper.add(splitPane, BorderLayout.CENTER);
        centerWrapper.add(summaryPanel, BorderLayout.SOUTH);
        
        add(centerWrapper, BorderLayout.CENTER);

        // Event Listeners
        btnFilter.addActionListener(e -> applyFilter());
        btnReset.addActionListener(e -> resetFilters());
        
        ordersTable.getSelectionModel().addListSelectionListener(e -> handleOrderSelection());
        
        btnUpdateStatus.addActionListener(e -> handleUpdateStatus());
        btnReprint.addActionListener(e -> handleReprint());
        btnDeleteOrder.addActionListener(e -> handleDeleteOrder());
    }

    // Mengeset ulang filter ke 7 hari terakhir
    private void resetFilters() {
        SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd");
        Date today = new Date();
        Date weekAgo = new Date(today.getTime() - 7L * 24 * 60 * 60 * 1000);

        txtStartDate.setText(sdf.format(weekAgo));
        txtEndDate.setText(sdf.format(today));
        applyFilter();
    }

    // Menerapkan filter tanggal
    private void applyFilter() {
        String startStr = txtStartDate.getText().trim();
        String endStr = txtEndDate.getText().trim();

        try {
            Date start = new SimpleDateFormat("yyyy-MM-dd").parse(startStr);
            Date end = new SimpleDateFormat("yyyy-MM-dd").parse(endStr);
            
            Timestamp startTimestamp = new Timestamp(start.getTime());
            Timestamp endTimestamp = new Timestamp(end.getTime() + 24L * 60 * 60 * 1000 - 1); // Hingga akhir hari

            loadedOrders = orderDAO.getOrdersByDateRange(startTimestamp, endTimestamp);
            populateOrdersTable();
            clearDetails();

        } catch (ParseException ex) {
            JOptionPane.showMessageDialog(this, "Format tanggal tidak valid! Harap gunakan YYYY-MM-DD.", "Peringatan", JOptionPane.WARNING_MESSAGE);
        }
    }

    // Memuat data transaksi ke JTable
    private void populateOrdersTable() {
        ordersTableModel.setRowCount(0);
        double totalSum = 0.0;
        
        SimpleDateFormat sdf = new SimpleDateFormat("dd MMM yyyy, HH:mm");
        for (Order order : loadedOrders) {
            ordersTableModel.addRow(new Object[]{
                "TRX-" + String.format("%04d", order.getId()),
                sdf.format(order.getOrderDate()),
                order.getCustomerName(),
                "Rp " + String.format("%,.0f", order.getTotalAmount()),
                "Rp " + String.format("%,.0f", order.getPaidAmount()),
                order.getStatus()
            });
            totalSum += order.getTotalAmount();
        }

        lblTotalRevenue.setText("Rp " + String.format("%,.0f", totalSum));
    }

    // Menangani pemilihan baris transaksi pada JTable
    private void handleOrderSelection() {
        int row = ordersTable.getSelectedRow();
        if (row != -1 && row < loadedOrders.size()) {
            selectedOrder = loadedOrders.get(row);
            
            List<OrderDetail> details = orderDAO.getOrderDetails(selectedOrder.getId());
            selectedOrder.setOrderDetails(details);
            
            populateDetailsTable(details);

            cbStatusEdit.setEnabled(true);
            cbStatusEdit.setSelectedItem(selectedOrder.getStatus());
            btnUpdateStatus.setEnabled(true);
            btnReprint.setEnabled(true);
            
            // Batasan: Hanya Admin yang diperbolehkan menghapus transaksi
            if (currentUser.getRole().equalsIgnoreCase("Admin")) {
                btnDeleteOrder.setEnabled(true);
            } else {
                btnDeleteOrder.setEnabled(false);
            }
        } else {
            clearDetails();
        }
    }

    // Memuat rincian item ke JTable rincian
    private void populateDetailsTable(List<OrderDetail> details) {
        detailsTableModel.setRowCount(0);
        for (OrderDetail d : details) {
            detailsTableModel.addRow(new Object[]{
                d.getServiceName(),
                d.getServiceUnit(),
                d.getQty(),
                "Rp " + String.format("%,.0f", d.getPrice()),
                "Rp " + String.format("%,.0f", d.getSubtotal())
            });
        }
    }

    // Mereset form rincian
    private void clearDetails() {
        selectedOrder = null;
        detailsTableModel.setRowCount(0);
        
        cbStatusEdit.setEnabled(false);
        btnUpdateStatus.setEnabled(false);
        btnReprint.setEnabled(false);
        btnDeleteOrder.setEnabled(false);
    }

    // Menyimpan perubahan status transaksi
    private void handleUpdateStatus() {
        if (selectedOrder != null) {
            String newStatus = cbStatusEdit.getSelectedItem().toString();
            if (orderDAO.updateOrderStatus(selectedOrder.getId(), newStatus)) {
                JOptionPane.showMessageDialog(this, "Status transaksi berhasil diperbarui!", "Sukses", JOptionPane.INFORMATION_MESSAGE);
                selectedOrder.setStatus(newStatus);
                
                int selectedRow = ordersTable.getSelectedRow();
                applyFilter();
                if (selectedRow != -1 && selectedRow < ordersTable.getRowCount()) {
                    ordersTable.setRowSelectionInterval(selectedRow, selectedRow);
                }
            } else {
                JOptionPane.showMessageDialog(this, "Gagal memperbarui status.", "Error", JOptionPane.ERROR_MESSAGE);
            }
        }
    }

    // Menghapus transaksi pesanan beserta rinciannya
    private void handleDeleteOrder() {
        if (selectedOrder != null) {
            int confirm = JOptionPane.showConfirmDialog(this, 
                    "Apakah Anda yakin ingin menghapus transaksi TRX-" + String.format("%04d", selectedOrder.getId()) + "?\n" +
                    "Ini juga akan menghapus rincian transaksi terkait.", 
                    "Konfirmasi Hapus Transaksi", 
                    JOptionPane.YES_NO_OPTION, 
                    JOptionPane.WARNING_MESSAGE);
            
            if (confirm == JOptionPane.YES_OPTION) {
                if (orderDAO.deleteOrder(selectedOrder.getId())) {
                    JOptionPane.showMessageDialog(this, "Transaksi berhasil dihapus!", "Sukses", JOptionPane.INFORMATION_MESSAGE);
                    applyFilter();
                    clearDetails();
                } else {
                    JOptionPane.showMessageDialog(this, "Gagal menghapus transaksi.", "Error", JOptionPane.ERROR_MESSAGE);
                }
            }
        }
    }

    // Menampilkan kembali cetak nota struk transaksi terpilih
    private void handleReprint() {
        if (selectedOrder != null) {
            JDialog dialog = new JDialog((Frame) SwingUtilities.getWindowAncestor(this), "Nota Pembayaran", true);
            dialog.setSize(380, 520);
            dialog.setLocationRelativeTo(this);
            dialog.setLayout(new BorderLayout());

            JTextArea area = new JTextArea();
            area.setFont(new Font("Monospaced", Font.PLAIN, 12));
            area.setEditable(false);
            area.setMargin(new Insets(15, 15, 15, 15));

            StringBuilder sb = new StringBuilder();
            sb.append("==========================================\n");
            sb.append("             LAURA PRINTING               \n");
            sb.append("   Jasa Percetakan Berkualitas & Cepat    \n");
            sb.append("      (SALINAN NOTA / CETAK ULANG)        \n");
            sb.append("==========================================\n");
            
            SimpleDateFormat sdf = new SimpleDateFormat("dd-MM-yyyy HH:mm");
            sb.append(String.format("No Nota : TRX-%04d\n", selectedOrder.getId()));
            sb.append(String.format("Tanggal : %s\n", sdf.format(selectedOrder.getOrderDate())));
            sb.append(String.format("Cust    : %s\n", selectedOrder.getCustomerName()));
            sb.append("==========================================\n");
            sb.append(String.format("%-22s %-3s %-6s %-8s\n", "Jasa Cetak", "Qty", "Harga", "Subtotal"));
            sb.append("------------------------------------------\n");

            for (OrderDetail item : selectedOrder.getOrderDetails()) {
                String name = item.getServiceName();
                if (name.length() > 20) {
                    name = name.substring(0, 18) + "..";
                }
                sb.append(String.format("%-22s %-3d %-6.0f %-8.0f\n", 
                    name, item.getQty(), item.getPrice(), item.getSubtotal()));
            }
            sb.append("------------------------------------------\n");
            sb.append(String.format("Total Tagihan : Rp %,.0f\n", selectedOrder.getTotalAmount()));
            sb.append(String.format("Bayar         : Rp %,.0f\n", selectedOrder.getPaidAmount()));
            double change = selectedOrder.getPaidAmount() - selectedOrder.getTotalAmount();
            sb.append(String.format("Kembalian     : Rp %,.0f\n", change));
            sb.append("==========================================\n");
            sb.append("    Status Pesanan: " + selectedOrder.getStatus() + "       \n");
            sb.append("         Terima Kasih Atas Kunjungan          \n");
            sb.append("            Hubungi Kami: 0812-xxx            \n");
            sb.append("==========================================\n");

            area.setText(sb.toString());

            JScrollPane scroll = new JScrollPane(area);
            scroll.setBorder(BorderFactory.createEmptyBorder());
            dialog.add(scroll, BorderLayout.CENTER);

            JPanel btnPanel = new JPanel(new FlowLayout(FlowLayout.RIGHT));
            btnPanel.setBackground(Color.WHITE);
            
            JButton btnPrint = new JButton("Cetak Nota (TXT)");
            btnPrint.putClientProperty("JButton.buttonType", "accent");
            btnPrint.putClientProperty("JComponent.roundRect", true);
            
            JButton btnClose = new JButton("Tutup");
            btnClose.putClientProperty("JComponent.roundRect", true);
            
            btnPrint.addActionListener(e -> {
                JFileChooser chooser = new JFileChooser();
                chooser.setSelectedFile(new java.io.File("Nota_TRX_" + selectedOrder.getId() + "_Copy.txt"));
                int returnVal = chooser.showSaveDialog(dialog);
                if (returnVal == JFileChooser.APPROVE_OPTION) {
                    try (java.io.FileWriter fw = new java.io.FileWriter(chooser.getSelectedFile())) {
                        fw.write(area.getText());
                        JOptionPane.showMessageDialog(dialog, "Nota berhasil disimpan!", "Sukses", JOptionPane.INFORMATION_MESSAGE);
                    } catch (Exception ex) {
                        JOptionPane.showMessageDialog(dialog, "Gagal menyimpan nota.", "Error", JOptionPane.ERROR_MESSAGE);
                    }
                }
            });
            
            btnClose.addActionListener(e -> dialog.dispose());

            btnPanel.add(btnPrint);
            btnPanel.add(btnClose);
            dialog.add(btnPanel, BorderLayout.SOUTH);

            dialog.setVisible(true);
        }
    }
}
