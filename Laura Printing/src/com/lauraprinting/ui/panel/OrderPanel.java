package com.lauraprinting.ui.panel;

import com.lauraprinting.dao.CustomerDAO;
import com.lauraprinting.dao.OrderDAO;
import com.lauraprinting.dao.ServiceDAO;
import com.lauraprinting.model.Customer;
import com.lauraprinting.model.Order;
import com.lauraprinting.model.OrderDetail;
import com.lauraprinting.model.Service;

import javax.swing.*;
import javax.swing.border.EmptyBorder;
import javax.swing.event.DocumentEvent;
import javax.swing.event.DocumentListener;
import javax.swing.table.DefaultTableModel;
import java.awt.*;
import java.sql.Timestamp;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.List;

public class OrderPanel extends JPanel {
    private final CustomerDAO customerDAO = new CustomerDAO();
    private final ServiceDAO serviceDAO = new ServiceDAO();
    private final OrderDAO orderDAO = new OrderDAO();
    
    // Daftar data dari database
    private List<Customer> customersList;
    private List<Service> servicesList;
    
    // Model Keranjang Belanja
    private final List<OrderDetail> cartItems = new ArrayList<>();
    private double grandTotal = 0.0;
    
    // Komponen GUI Input Transaksi
    private JComboBox<Customer> cbCustomer;
    private JComboBox<Service> cbService;
    private JTextField txtPrice;
    private JTextField txtQty;
    private JLabel lblUnit;
    private JTextField txtSubtotal;
    private JButton btnAddToCart;
    private JButton btnRemoveFromCart;
    
    // Tabel Keranjang
    private JTable cartTable;
    private DefaultTableModel tableModel;
    
    // Komponen Pembayaran & Status
    private JLabel lblGrandTotal;
    private JTextField txtPaidAmount;
    private JLabel lblChangeAmount;
    private JComboBox<String> cbStatus;
    private JButton btnProcess;
    private JButton btnClear;

    public OrderPanel() {
        initComponents();
        loadFormData();
    }

    private void initComponents() {
        setLayout(new BorderLayout());
        setBackground(new Color(248, 250, 252));
        setBorder(new EmptyBorder(25, 25, 25, 25));

        // Panel Header
        JPanel headerPanel = new JPanel(new BorderLayout());
        headerPanel.setOpaque(false);
        headerPanel.setBorder(new EmptyBorder(0, 0, 20, 0));
        
        JLabel lblTitle = new JLabel("Transaksi Baru");
        lblTitle.setFont(new Font("Segoe UI", Font.BOLD, 24));
        lblTitle.setForeground(new Color(15, 23, 42));
        
        JLabel lblSubtitle = new JLabel("Buat pesanan percetakan baru, hitung tagihan, dan proses pembayaran.");
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

        // Layout POS Utama: Kiri Input Jasa & Keranjang, Kanan Detail Pembayaran
        JPanel posLayout = new JPanel(new BorderLayout(20, 0));
        posLayout.setOpaque(false);

        // Panel Kiri
        JPanel leftPanel = new JPanel(new BorderLayout(0, 15));
        leftPanel.setOpaque(false);

        // 1. Kartu Pemilihan Layanan Cetak (GridBagLayout - Stretched, Stacked Labels Above Fields)
        JPanel selectionCard = new JPanel(new GridBagLayout());
        selectionCard.setBackground(Color.WHITE);
        selectionCard.setBorder(BorderFactory.createCompoundBorder(
            BorderFactory.createLineBorder(new Color(226, 232, 240), 1, true),
            new EmptyBorder(20, 20, 20, 20)
        ));
        
        GridBagConstraints gbc = new GridBagConstraints();
        gbc.fill = GridBagConstraints.HORIZONTAL;
        gbc.insets = new Insets(6, 6, 6, 6);

        // Row 0: Label Pelanggan
        JLabel lblCust = new JLabel("Pilih Pelanggan");
        lblCust.setFont(new Font("Segoe UI", Font.BOLD, 12));
        lblCust.setForeground(new Color(71, 85, 105));
        gbc.gridx = 0; gbc.gridy = 0; gbc.gridwidth = 4; gbc.weightx = 1.0;
        selectionCard.add(lblCust, gbc);
        
        // Row 1: Dropdown Pelanggan
        cbCustomer = new JComboBox<>();
        cbCustomer.setFont(new Font("Segoe UI", Font.PLAIN, 13));
        cbCustomer.setPreferredSize(new Dimension(0, 36));
        cbCustomer.putClientProperty("JComponent.roundRect", true);
        gbc.gridy = 1;
        selectionCard.add(cbCustomer, gbc);

        // Row 2: Label Jasa Cetak
        JLabel lblServ = new JLabel("Pilih Jasa Cetak / Produk");
        lblServ.setFont(new Font("Segoe UI", Font.BOLD, 12));
        lblServ.setForeground(new Color(71, 85, 105));
        gbc.gridy = 2;
        selectionCard.add(lblServ, gbc);
        
        // Row 3: Dropdown Jasa Cetak
        cbService = new JComboBox<>();
        cbService.setFont(new Font("Segoe UI", Font.PLAIN, 13));
        cbService.setPreferredSize(new Dimension(0, 36));
        cbService.putClientProperty("JComponent.roundRect", true);
        gbc.gridy = 3;
        selectionCard.add(cbService, gbc);

        // Row 4: Labels for Price, Qty, Subtotal (Horizontal alignment)
        gbc.gridy = 4; gbc.gridwidth = 2; gbc.weightx = 0.5;
        JLabel lblP = new JLabel("Harga Jasa (Rp)");
        lblP.setFont(new Font("Segoe UI", Font.BOLD, 12));
        lblP.setForeground(new Color(71, 85, 105));
        selectionCard.add(lblP, gbc);

        gbc.gridx = 2; gbc.gridwidth = 1; gbc.weightx = 0.25;
        JLabel lblQ = new JLabel("Kuantitas (Qty)");
        lblQ.setFont(new Font("Segoe UI", Font.BOLD, 12));
        lblQ.setForeground(new Color(71, 85, 105));
        selectionCard.add(lblQ, gbc);

        gbc.gridx = 3; gbc.weightx = 0.25;
        JLabel lblSub = new JLabel("Subtotal Item (Rp)");
        lblSub.setFont(new Font("Segoe UI", Font.BOLD, 12));
        lblSub.setForeground(new Color(71, 85, 105));
        selectionCard.add(lblSub, gbc);

        // Row 5: Inputs for Price, Qty, Subtotal
        gbc.gridx = 0; gbc.gridy = 5; gbc.gridwidth = 2; gbc.weightx = 0.5;
        txtPrice = new JTextField();
        txtPrice.setEditable(false);
        txtPrice.setFocusable(false);
        txtPrice.setFont(new Font("Segoe UI", Font.BOLD, 13));
        txtPrice.setPreferredSize(new Dimension(0, 36));
        txtPrice.putClientProperty("JComponent.roundRect", true);
        selectionCard.add(txtPrice, gbc);

        gbc.gridx = 2; gbc.gridwidth = 1; gbc.weightx = 0.25;
        JPanel qtyPanel = new JPanel(new BorderLayout(5, 0));
        qtyPanel.setOpaque(false);
        txtQty = new JTextField("1");
        txtQty.setFont(new Font("Segoe UI", Font.BOLD, 13));
        txtQty.setPreferredSize(new Dimension(0, 36));
        txtQty.putClientProperty("JComponent.roundRect", true);
        qtyPanel.add(txtQty, BorderLayout.CENTER);
        
        lblUnit = new JLabel(" / Lembar");
        lblUnit.setFont(new Font("Segoe UI", Font.PLAIN, 12));
        qtyPanel.add(lblUnit, BorderLayout.EAST);
        selectionCard.add(qtyPanel, gbc);

        gbc.gridx = 3; gbc.weightx = 0.25;
        txtSubtotal = new JTextField();
        txtSubtotal.setEditable(false);
        txtSubtotal.setFocusable(false);
        txtSubtotal.setFont(new Font("Segoe UI", Font.BOLD, 13));
        txtSubtotal.setForeground(new Color(79, 70, 229)); // Indigo text
        txtSubtotal.setPreferredSize(new Dimension(0, 36));
        txtSubtotal.putClientProperty("JComponent.roundRect", true);
        selectionCard.add(txtSubtotal, gbc);

        // Row 6: Spacer
        gbc.gridx = 0; gbc.gridy = 6; gbc.gridwidth = 4; gbc.weightx = 1.0;
        selectionCard.add(Box.createVerticalStrut(5), gbc);

        // Row 7: Tombol Aksi Keranjang
        gbc.gridy = 7;
        JPanel cartActions = new JPanel(new FlowLayout(FlowLayout.RIGHT, 10, 0));
        cartActions.setOpaque(false);
        
        btnRemoveFromCart = new JButton("Hapus Item");
        btnRemoveFromCart.setFont(new Font("Segoe UI", Font.BOLD, 12));
        btnRemoveFromCart.putClientProperty("JComponent.roundRect", true);
        btnRemoveFromCart.setEnabled(false);
        btnRemoveFromCart.setCursor(new Cursor(Cursor.HAND_CURSOR));

        btnAddToCart = new JButton("Tambah ke Keranjang");
        btnAddToCart.setFont(new Font("Segoe UI", Font.BOLD, 12));
        btnAddToCart.putClientProperty("JButton.buttonType", "accent");
        btnAddToCart.putClientProperty("JComponent.roundRect", true);
        btnAddToCart.setCursor(new Cursor(Cursor.HAND_CURSOR));

        cartActions.add(btnRemoveFromCart);
        cartActions.add(btnAddToCart);
        selectionCard.add(cartActions, gbc);

        // 2. Kartu Tabel Keranjang Belanja
        JPanel cartCard = new JPanel(new BorderLayout());
        cartCard.setBackground(Color.WHITE);
        cartCard.setBorder(BorderFactory.createCompoundBorder(
            BorderFactory.createLineBorder(new Color(226, 232, 240), 1, true),
            new EmptyBorder(15, 15, 15, 15)
        ));

        JLabel lblCartTitle = new JLabel("Keranjang Belanja");
        lblCartTitle.setFont(new Font("Segoe UI", Font.BOLD, 16));
        lblCartTitle.setForeground(new Color(15, 23, 42));
        lblCartTitle.setBorder(new EmptyBorder(0, 0, 10, 0));

        String[] columns = {"No", "Layanan Percetakan", "Satuan", "Qty", "Harga", "Subtotal"};
        tableModel = new DefaultTableModel(columns, 0) {
            @Override
            public boolean isCellEditable(int row, int column) {
                return false;
            }
        };

        cartTable = new JTable(tableModel);
        cartTable.setFont(new Font("Segoe UI", Font.PLAIN, 12));
        cartTable.setRowHeight(32);
        cartTable.setFocusable(false);
        
        // Memperbesar Header Tabel
        cartTable.getTableHeader().setFont(new Font("Segoe UI", Font.BOLD, 12));
        cartTable.getTableHeader().setBackground(new Color(241, 245, 249));
        cartTable.getTableHeader().setForeground(new Color(71, 85, 105));
        cartTable.getTableHeader().setPreferredSize(new Dimension(0, 32));
        
        cartTable.setSelectionBackground(new Color(224, 231, 255));
        cartTable.setSelectionForeground(new Color(79, 70, 229));
        
        // Estetika modern tanpa garis vertikal
        cartTable.setShowGrid(true);
        cartTable.setShowVerticalLines(false);
        cartTable.setGridColor(new Color(241, 245, 249));

        // Konfigurasi lebar kolom keranjang agar seimbang
        cartTable.getColumnModel().getColumn(0).setPreferredWidth(45);   // No
        cartTable.getColumnModel().getColumn(1).setPreferredWidth(210);  // Layanan Percetakan
        cartTable.getColumnModel().getColumn(2).setPreferredWidth(80);   // Satuan
        cartTable.getColumnModel().getColumn(3).setPreferredWidth(60);   // Qty
        cartTable.getColumnModel().getColumn(4).setPreferredWidth(100);  // Harga
        cartTable.getColumnModel().getColumn(5).setPreferredWidth(110);  // Subtotal

        // Penyelarasan kolom tabel secara rapi dan profesional
        javax.swing.table.DefaultTableCellRenderer centerRenderer = new javax.swing.table.DefaultTableCellRenderer();
        centerRenderer.setHorizontalAlignment(SwingConstants.CENTER);
        cartTable.getColumnModel().getColumn(0).setCellRenderer(centerRenderer); // No
        cartTable.getColumnModel().getColumn(2).setCellRenderer(centerRenderer); // Satuan
        cartTable.getColumnModel().getColumn(3).setCellRenderer(centerRenderer); // Qty

        javax.swing.table.DefaultTableCellRenderer rightRenderer = new javax.swing.table.DefaultTableCellRenderer();
        rightRenderer.setHorizontalAlignment(SwingConstants.RIGHT);
        cartTable.getColumnModel().getColumn(4).setCellRenderer(rightRenderer); // Harga
        cartTable.getColumnModel().getColumn(5).setCellRenderer(rightRenderer); // Subtotal

        JScrollPane cartScroll = new JScrollPane(cartTable);
        cartScroll.setBorder(BorderFactory.createEmptyBorder());

        cartCard.add(lblCartTitle, BorderLayout.NORTH);
        cartCard.add(cartScroll, BorderLayout.CENTER);

        leftPanel.add(selectionCard, BorderLayout.NORTH);
        leftPanel.add(cartCard, BorderLayout.CENTER);

        // Panel Kanan (Kartu Ringkasan & Pembayaran)
        JPanel paymentCard = new JPanel();
        paymentCard.setLayout(new BoxLayout(paymentCard, BoxLayout.Y_AXIS));
        paymentCard.setBackground(Color.WHITE);
        paymentCard.setPreferredSize(new Dimension(340, 0));
        paymentCard.setBorder(BorderFactory.createCompoundBorder(
            BorderFactory.createLineBorder(new Color(226, 232, 240), 1, true),
            new EmptyBorder(20, 20, 20, 20)
        ));

        JLabel lblPayTitle = new JLabel("Ringkasan Pembayaran");
        lblPayTitle.setFont(new Font("Segoe UI", Font.BOLD, 16));
        lblPayTitle.setForeground(new Color(15, 23, 42));
        lblPayTitle.setAlignmentX(Component.LEFT_ALIGNMENT);

        // Kartu Penampil Total Tagihan Besar
        JPanel totalBox = new JPanel(new BorderLayout());
        totalBox.setBackground(new Color(240, 253, 250)); // Teal 50
        totalBox.setBorder(BorderFactory.createCompoundBorder(
            BorderFactory.createLineBorder(new Color(204, 251, 241), 1, true),
            new EmptyBorder(15, 15, 15, 15)
        ));
        totalBox.setMaximumSize(new Dimension(Integer.MAX_VALUE, 90));
        totalBox.setAlignmentX(Component.LEFT_ALIGNMENT);

        JLabel lblTotalLabel = new JLabel("TOTAL TAGIHAN");
        lblTotalLabel.setFont(new Font("Segoe UI", Font.BOLD, 12));
        lblTotalLabel.setForeground(new Color(13, 148, 136)); // Teal 600

        lblGrandTotal = new JLabel("Rp 0");
        lblGrandTotal.setFont(new Font("Segoe UI", Font.BOLD, 28));
        lblGrandTotal.setForeground(new Color(15, 118, 110)); // Teal 700

        totalBox.add(lblTotalLabel, BorderLayout.NORTH);
        totalBox.add(lblGrandTotal, BorderLayout.CENTER);

        // Inputs Status & Nominal Bayar
        JLabel lblStatus = new JLabel("Status Pesanan:");
        lblStatus.setFont(new Font("Segoe UI", Font.BOLD, 12));
        lblStatus.setForeground(new Color(71, 85, 105));
        lblStatus.setAlignmentX(Component.LEFT_ALIGNMENT);
        
        cbStatus = new JComboBox<>(new String[]{"Pending", "Processing", "Done", "Picked Up"});
        cbStatus.setFont(new Font("Segoe UI", Font.PLAIN, 13));
        cbStatus.setPreferredSize(new Dimension(0, 36));
        cbStatus.putClientProperty("JComponent.roundRect", true);
        cbStatus.setMaximumSize(new Dimension(Integer.MAX_VALUE, 36));
        cbStatus.setAlignmentX(Component.LEFT_ALIGNMENT);

        JLabel lblPaid = new JLabel("Jumlah Bayar (Rp):");
        lblPaid.setFont(new Font("Segoe UI", Font.BOLD, 12));
        lblPaid.setForeground(new Color(71, 85, 105));
        lblPaid.setAlignmentX(Component.LEFT_ALIGNMENT);
        
        txtPaidAmount = new JTextField();
        txtPaidAmount.setFont(new Font("Segoe UI", Font.BOLD, 16));
        txtPaidAmount.setPreferredSize(new Dimension(0, 38));
        txtPaidAmount.putClientProperty("JTextField.showClearButton", true);
        txtPaidAmount.putClientProperty("JComponent.roundRect", true);
        txtPaidAmount.putClientProperty("JTextField.placeholderText", "Masukkan nominal pembayaran...");
        txtPaidAmount.setMaximumSize(new Dimension(Integer.MAX_VALUE, 38));
        txtPaidAmount.setAlignmentX(Component.LEFT_ALIGNMENT);

        JLabel lblChangeLabel = new JLabel("Uang Kembalian:");
        lblChangeLabel.setFont(new Font("Segoe UI", Font.BOLD, 12));
        lblChangeLabel.setForeground(new Color(71, 85, 105));
        lblChangeLabel.setAlignmentX(Component.LEFT_ALIGNMENT);

        lblChangeAmount = new JLabel("Rp 0");
        lblChangeAmount.setFont(new Font("Segoe UI", Font.BOLD, 20));
        lblChangeAmount.setForeground(new Color(220, 38, 38)); // Merah 600
        lblChangeAmount.setAlignmentX(Component.LEFT_ALIGNMENT);

        // Tombol Proses
        btnProcess = new JButton("Proses Transaksi");
        btnProcess.setFont(new Font("Segoe UI", Font.BOLD, 14));
        btnProcess.setForeground(Color.WHITE);
        btnProcess.setBackground(new Color(16, 185, 129)); // Emerald 500
        btnProcess.putClientProperty("JButton.buttonType", "accent");
        btnProcess.putClientProperty("JComponent.roundRect", true);
        btnProcess.setPreferredSize(new Dimension(0, 42));
        btnProcess.setMaximumSize(new Dimension(Integer.MAX_VALUE, 42));
        btnProcess.setAlignmentX(Component.CENTER_ALIGNMENT);
        btnProcess.setCursor(new Cursor(Cursor.HAND_CURSOR));

        btnClear = new JButton("Batalkan");
        btnClear.setFont(new Font("Segoe UI", Font.BOLD, 12));
        btnClear.putClientProperty("JComponent.roundRect", true);
        btnClear.setPreferredSize(new Dimension(0, 35));
        btnClear.setMaximumSize(new Dimension(Integer.MAX_VALUE, 35));
        btnClear.setAlignmentX(Component.CENTER_ALIGNMENT);
        btnClear.setCursor(new Cursor(Cursor.HAND_CURSOR));

        // Menyusun Panel Kanan
        paymentCard.add(lblPayTitle);
        paymentCard.add(Box.createVerticalStrut(18));
        paymentCard.add(totalBox);
        paymentCard.add(Box.createVerticalStrut(18));
        paymentCard.add(lblStatus);
        paymentCard.add(Box.createVerticalStrut(5));
        paymentCard.add(cbStatus);
        paymentCard.add(Box.createVerticalStrut(15));
        paymentCard.add(lblPaid);
        paymentCard.add(Box.createVerticalStrut(5));
        paymentCard.add(txtPaidAmount);
        paymentCard.add(Box.createVerticalStrut(15));
        paymentCard.add(lblChangeLabel);
        paymentCard.add(Box.createVerticalStrut(5));
        paymentCard.add(lblChangeAmount);
        paymentCard.add(Box.createVerticalStrut(25));
        paymentCard.add(btnProcess);
        paymentCard.add(Box.createVerticalStrut(8));
        paymentCard.add(btnClear);
        paymentCard.add(Box.createVerticalGlue());

        posLayout.add(leftPanel, BorderLayout.CENTER);
        posLayout.add(paymentCard, BorderLayout.EAST);
        add(posLayout, BorderLayout.CENTER);

        // Listener Aksi & Perubahan Input
        cbService.addActionListener(e -> updatePriceAndSubtotal());
        
        txtQty.getDocument().addDocumentListener(new DocumentListener() {
            public void insertUpdate(DocumentEvent e) { updateSubtotal(); }
            public void removeUpdate(DocumentEvent e) { updateSubtotal(); }
            public void changedUpdate(DocumentEvent e) { updateSubtotal(); }
        });

        txtPaidAmount.getDocument().addDocumentListener(new DocumentListener() {
            public void insertUpdate(DocumentEvent e) { updateChange(); }
            public void removeUpdate(DocumentEvent e) { updateChange(); }
            public void changedUpdate(DocumentEvent e) { updateChange(); }
        });

        cartTable.getSelectionModel().addListSelectionListener(e -> {
            btnRemoveFromCart.setEnabled(cartTable.getSelectedRow() != -1);
        });

        btnAddToCart.addActionListener(e -> addToCart());
        btnRemoveFromCart.addActionListener(e -> removeFromCart());
        btnProcess.addActionListener(e -> processOrder());
        btnClear.addActionListener(e -> clearPOS());
    }

    // Memuat data combobox
    public void loadFormData() {
        customersList = customerDAO.getAllCustomers();
        cbCustomer.removeAllItems();
        for (Customer c : customersList) {
            cbCustomer.addItem(c);
        }

        servicesList = serviceDAO.getAllServices();
        cbService.removeAllItems();
        for (Service s : servicesList) {
            cbService.addItem(s);
        }

        updatePriceAndSubtotal();
        clearPOS();
    }

    // Memperbarui harga saat jasa cetak diubah
    private void updatePriceAndSubtotal() {
        Service selected = (Service) cbService.getSelectedItem();
        if (selected != null) {
            txtPrice.setText(String.format("%.0f", selected.getPrice()));
            lblUnit.setText(" / " + selected.getUnit());
            updateSubtotal();
        }
    }

    // Memperbarui nominal subtotal
    private void updateSubtotal() {
        try {
            double price = Double.parseDouble(txtPrice.getText());
            int qty = Integer.parseInt(txtQty.getText().trim());
            double subtotal = price * qty;
            txtSubtotal.setText(String.format("%.0f", subtotal));
        } catch (NumberFormatException e) {
            txtSubtotal.setText("0");
        }
    }

    // Menghitung uang kembalian secara real-time
    private void updateChange() {
        try {
            double paid = Double.parseDouble(txtPaidAmount.getText().trim());
            double change = paid - grandTotal;
            if (change >= 0) {
                lblChangeAmount.setText("Rp " + String.format("%,.0f", change));
                lblChangeAmount.setForeground(new Color(16, 185, 129)); // Hijau Sukses
            } else {
                lblChangeAmount.setText("Kurang: Rp " + String.format("%,.0f", Math.abs(change)));
                lblChangeAmount.setForeground(new Color(220, 38, 38)); // Merah Kurang
            }
        } catch (NumberFormatException e) {
            lblChangeAmount.setText("Rp 0");
            lblChangeAmount.setForeground(new Color(220, 38, 38));
        }
    }

    // Menambah item cetak ke keranjang belanja JTable
    private void addToCart() {
        Service service = (Service) cbService.getSelectedItem();
        String qtyStr = txtQty.getText().trim();
        
        if (service == null || qtyStr.isEmpty()) {
            return;
        }

        try {
            int qty = Integer.parseInt(qtyStr);
            if (qty <= 0) {
                JOptionPane.showMessageDialog(this, "Kuantitas harus lebih dari 0!", "Validasi Gagal", JOptionPane.WARNING_MESSAGE);
                return;
            }

            // Gabungkan qty jika item sejenis sudah ada di keranjang
            OrderDetail existing = null;
            for (OrderDetail item : cartItems) {
                if (item.getServiceId() == service.getId()) {
                    existing = item;
                    break;
                }
            }

            if (existing != null) {
                existing.setQty(existing.getQty() + qty);
            } else {
                OrderDetail newItem = new OrderDetail(0, 0, service.getId(), service.getName(), service.getUnit(), qty, service.getPrice(), service.getPrice() * qty);
                cartItems.add(newItem);
            }

            refreshCartTable();
            txtQty.setText("1");
            updateSubtotal();

        } catch (NumberFormatException ex) {
            JOptionPane.showMessageDialog(this, "Kuantitas tidak valid!", "Validasi Gagal", JOptionPane.WARNING_MESSAGE);
        }
    }

    // Menghapus item terpilih dari keranjang belanja
    private void removeFromCart() {
        int row = cartTable.getSelectedRow();
        if (row != -1) {
            cartItems.remove(row);
            refreshCartTable();
        }
    }

    // Memperbarui visual tabel keranjang belanja & nominal grand total
    private void refreshCartTable() {
        tableModel.setRowCount(0);
        grandTotal = 0.0;
        
        int index = 1;
        for (OrderDetail item : cartItems) {
            tableModel.addRow(new Object[]{
                index++,
                item.getServiceName(),
                item.getServiceUnit(),
                item.getQty(),
                "Rp " + String.format("%,.0f", item.getPrice()),
                "Rp " + String.format("%,.0f", item.getSubtotal())
            });
            grandTotal += item.getSubtotal();
        }

        lblGrandTotal.setText("Rp " + String.format("%,.0f", grandTotal));
        updateChange();
    }

    // Memproses transaksi pesanan ke database (Order & OrderDetail)
    private void processOrder() {
        if (cartItems.isEmpty()) {
            JOptionPane.showMessageDialog(this, "Keranjang belanja kosong!", "Peringatan", JOptionPane.WARNING_MESSAGE);
            return;
        }

        Customer cust = (Customer) cbCustomer.getSelectedItem();
        if (cust == null) {
            JOptionPane.showMessageDialog(this, "Harap pilih pelanggan!", "Peringatan", JOptionPane.WARNING_MESSAGE);
            return;
        }

        String paidText = txtPaidAmount.getText().trim();
        if (paidText.isEmpty()) {
            JOptionPane.showMessageDialog(this, "Harap masukkan jumlah pembayaran!", "Peringatan", JOptionPane.WARNING_MESSAGE);
            return;
        }

        try {
            double paid = Double.parseDouble(paidText);
            if (paid < grandTotal) {
                JOptionPane.showMessageDialog(this, "Jumlah pembayaran kurang dari total tagihan!", "Validasi Gagal", JOptionPane.WARNING_MESSAGE);
                return;
            }

            // Membuat model transaksi Order
            Order order = new Order(0, new Timestamp(System.currentTimeMillis()), cust.getId(), cust.getName(), grandTotal, paid, cbStatus.getSelectedItem().toString());
            
            // Memindahkan item keranjang ke pesanan
            for (OrderDetail item : cartItems) {
                order.addOrderDetail(item);
            }

            // Menyimpan transaksi pesanan dengan DAO (sistem transaksi ACID)
            if (orderDAO.createOrder(order)) {
                JOptionPane.showMessageDialog(this, "Transaksi berhasil diproses!", "Sukses", JOptionPane.INFORMATION_MESSAGE);
                showReceiptDialog(order);
                clearPOS();
            } else {
                JOptionPane.showMessageDialog(this, "Gagal memproses transaksi. Terjadi kesalahan pada database.", "Gagal", JOptionPane.ERROR_MESSAGE);
            }

        } catch (NumberFormatException ex) {
            JOptionPane.showMessageDialog(this, "Format jumlah pembayaran tidak valid!", "Validasi Gagal", JOptionPane.WARNING_MESSAGE);
        }
    }

    // Menampilkan Dialog Nota Pembayaran berestetika struk kertas belanja
    private void showReceiptDialog(Order order) {
        JDialog dialog = new JDialog((Frame) SwingUtilities.getWindowAncestor(this), "Nota Pembayaran", true);
        dialog.setSize(380, 520);
        dialog.setLocationRelativeTo(this);
        dialog.setLayout(new BorderLayout());

        JTextArea area = new JTextArea();
        area.setFont(new Font("Monospaced", Font.PLAIN, 12));
        area.setEditable(false);
        area.setMargin(new Insets(15, 15, 15, 15));

        // Pembuatan Desain Nota Teks Struk
        StringBuilder sb = new StringBuilder();
        sb.append("==========================================\n");
        sb.append("             LAURA PRINTING               \n");
        sb.append("   Jasa Percetakan Berkualitas & Cepat    \n");
        sb.append("==========================================\n");
        
        SimpleDateFormat sdf = new SimpleDateFormat("dd-MM-yyyy HH:mm");
        sb.append(String.format("No Nota : TRX-%04d\n", order.getId()));
        sb.append(String.format("Tanggal : %s\n", sdf.format(order.getOrderDate())));
        sb.append(String.format("Cust    : %s\n", order.getCustomerName()));
        sb.append("==========================================\n");
        sb.append(String.format("%-22s %-3s %-6s %-8s\n", "Jasa Cetak", "Qty", "Harga", "Subtotal"));
        sb.append("------------------------------------------\n");

        for (OrderDetail item : order.getOrderDetails()) {
            String name = item.getServiceName();
            if (name.length() > 20) {
                name = name.substring(0, 18) + "..";
            }
            sb.append(String.format("%-22s %-3d %-6.0f %-8.0f\n", 
                name, item.getQty(), item.getPrice(), item.getSubtotal()));
        }
        sb.append("------------------------------------------\n");
        sb.append(String.format("Total Tagihan : Rp %,.0f\n", order.getTotalAmount()));
        sb.append(String.format("Bayar         : Rp %,.0f\n", order.getPaidAmount()));
        double change = order.getPaidAmount() - order.getTotalAmount();
        sb.append(String.format("Kembalian     : Rp %,.0f\n", change));
        sb.append("==========================================\n");
        sb.append("    Status Pesanan: " + order.getStatus() + "       \n");
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
            // Aksi menyimpan file nota struk belanja ke sistem penyimpanan lokal
            JFileChooser chooser = new JFileChooser();
            chooser.setSelectedFile(new java.io.File("Nota_TRX_" + order.getId() + ".txt"));
            int returnVal = chooser.showSaveDialog(dialog);
            if (returnVal == JFileChooser.APPROVE_OPTION) {
                try (java.io.FileWriter fw = new java.io.FileWriter(chooser.getSelectedFile())) {
                    fw.write(area.getText());
                    JOptionPane.showMessageDialog(dialog, "Nota disimpan dengan sukses!", "Sukses", JOptionPane.INFORMATION_MESSAGE);
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

    // Mereset seluruh isian kasir POS
    private void clearPOS() {
        cartItems.clear();
        refreshCartTable();
        txtQty.setText("1");
        txtPaidAmount.setText("");
        lblChangeAmount.setText("Rp 0");
        lblChangeAmount.setForeground(new Color(220, 38, 38));
        cbStatus.setSelectedIndex(0);
        if (cbCustomer.getItemCount() > 0) {
            cbCustomer.setSelectedIndex(0);
        }
        if (cbService.getItemCount() > 0) {
            cbService.setSelectedIndex(0);
        }
        updatePriceAndSubtotal();
    }
}
