package com.lauraprinting.ui.panel;

import com.lauraprinting.dao.ServiceDAO;
import com.lauraprinting.model.Service;

import javax.swing.*;
import javax.swing.border.EmptyBorder;
import javax.swing.table.DefaultTableModel;
import java.awt.*;
import java.util.List;

public class ServicePanel extends JPanel {
    private final ServiceDAO serviceDAO = new ServiceDAO();
    private JTable serviceTable;
    private DefaultTableModel tableModel;
    
    // Komponen Form Pengisian
    private JTextField txtId;
    private JTextField txtName;
    private JComboBox<String> cbUnit;
    private JTextField txtPrice;
    
    private JButton btnAdd;
    private JButton btnUpdate;
    private JButton btnDelete;
    private JButton btnReset;

    public ServicePanel() {
        initComponents();
        loadTableData();
    }

    private void initComponents() {
        setLayout(new BorderLayout());
        setBackground(new Color(248, 250, 252));
        setBorder(new EmptyBorder(25, 25, 25, 25));

        // Panel Header
        JPanel headerPanel = new JPanel(new BorderLayout());
        headerPanel.setOpaque(false);
        headerPanel.setBorder(new EmptyBorder(0, 0, 20, 0));
        
        JLabel lblTitle = new JLabel("Kelola Layanan Cetak");
        lblTitle.setFont(new Font("Segoe UI", Font.BOLD, 24));
        lblTitle.setForeground(new Color(15, 23, 42));
        
        JLabel lblSubtitle = new JLabel("Tambah, edit, atau hapus jasa dan produk percetakan Laura Printing.");
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

        // Grid Utama: Kiri Tabel JTable, Kanan Form Isian
        JPanel mainContent = new JPanel(new BorderLayout(20, 0));
        mainContent.setOpaque(false);

        // 1. Panel Kiri (Kartu Tabel)
        JPanel tableCard = new JPanel(new BorderLayout());
        tableCard.setBackground(Color.WHITE);
        tableCard.setBorder(BorderFactory.createCompoundBorder(
            BorderFactory.createLineBorder(new Color(226, 232, 240), 1, true),
            new EmptyBorder(15, 15, 15, 15)
        ));

        String[] columns = {"ID Jasa", "Nama Jasa Cetak", "Satuan/Unit", "Harga per Satuan"};
        tableModel = new DefaultTableModel(columns, 0) {
            @Override
            public boolean isCellEditable(int row, int column) {
                return false;
            }
        };

        serviceTable = new JTable(tableModel);
        serviceTable.setFont(new Font("Segoe UI", Font.PLAIN, 12));
        serviceTable.setRowHeight(35);
        serviceTable.setFocusable(false);
        
        // Memperbesar dan menata Header Tabel
        serviceTable.getTableHeader().setFont(new Font("Segoe UI", Font.BOLD, 12));
        serviceTable.getTableHeader().setBackground(new Color(241, 245, 249));
        serviceTable.getTableHeader().setForeground(new Color(71, 85, 105));
        serviceTable.getTableHeader().setPreferredSize(new Dimension(0, 32));
        
        serviceTable.setSelectionBackground(new Color(224, 231, 255));
        serviceTable.setSelectionForeground(new Color(79, 70, 229));
        
        // Desain modern tanpa garis vertikal
        serviceTable.setShowGrid(true);
        serviceTable.setShowVerticalLines(false);
        serviceTable.setGridColor(new Color(241, 245, 249));

        // Konfigurasi lebar kolom proporsional
        serviceTable.getColumnModel().getColumn(0).setPreferredWidth(90);   // ID Jasa
        serviceTable.getColumnModel().getColumn(1).setPreferredWidth(230);  // Nama Jasa
        serviceTable.getColumnModel().getColumn(2).setPreferredWidth(100);  // Satuan
        serviceTable.getColumnModel().getColumn(3).setPreferredWidth(130);  // Harga

        // Penyelarasan kolom tabel secara rapi dan profesional
        javax.swing.table.DefaultTableCellRenderer centerRenderer = new javax.swing.table.DefaultTableCellRenderer();
        centerRenderer.setHorizontalAlignment(SwingConstants.CENTER);
        serviceTable.getColumnModel().getColumn(0).setCellRenderer(centerRenderer); // ID Jasa
        serviceTable.getColumnModel().getColumn(2).setCellRenderer(centerRenderer); // Satuan

        javax.swing.table.DefaultTableCellRenderer rightRenderer = new javax.swing.table.DefaultTableCellRenderer();
        rightRenderer.setHorizontalAlignment(SwingConstants.RIGHT);
        serviceTable.getColumnModel().getColumn(3).setCellRenderer(rightRenderer); // Harga

        JScrollPane tableScroll = new JScrollPane(serviceTable);
        tableScroll.setBorder(BorderFactory.createEmptyBorder());
        tableCard.add(tableScroll, BorderLayout.CENTER);

        // 2. Panel Kanan (Kartu Form)
        JPanel formCard = new JPanel();
        formCard.setLayout(new BoxLayout(formCard, BoxLayout.Y_AXIS));
        formCard.setBackground(Color.WHITE);
        formCard.setPreferredSize(new Dimension(320, 0));
        formCard.setBorder(BorderFactory.createCompoundBorder(
            BorderFactory.createLineBorder(new Color(226, 232, 240), 1, true),
            new EmptyBorder(20, 20, 20, 20)
        ));

        JLabel lblFormTitle = new JLabel("Form Data Layanan");
        lblFormTitle.setFont(new Font("Segoe UI", Font.BOLD, 16));
        lblFormTitle.setForeground(new Color(15, 23, 42));
        lblFormTitle.setAlignmentX(Component.LEFT_ALIGNMENT);

        // Isian Inputs
        JLabel lblId = new JLabel("ID Layanan (Otomatis)");
        lblId.setFont(new Font("Segoe UI", Font.BOLD, 12));
        lblId.setForeground(new Color(71, 85, 105));
        lblId.setAlignmentX(Component.LEFT_ALIGNMENT);
        
        txtId = new JTextField();
        txtId.setEnabled(false);
        txtId.setFont(new Font("Segoe UI", Font.PLAIN, 13));
        txtId.putClientProperty("JComponent.roundRect", true);
        txtId.setMaximumSize(new Dimension(Integer.MAX_VALUE, 35));
        txtId.setAlignmentX(Component.LEFT_ALIGNMENT);

        JLabel lblName = new JLabel("Nama Jasa");
        lblName.setFont(new Font("Segoe UI", Font.BOLD, 12));
        lblName.setForeground(new Color(71, 85, 105));
        lblName.setAlignmentX(Component.LEFT_ALIGNMENT);
        
        txtName = new JTextField();
        txtName.setFont(new Font("Segoe UI", Font.PLAIN, 13));
        txtName.putClientProperty("JTextField.showClearButton", true);
        txtName.putClientProperty("JComponent.roundRect", true);
        txtName.setMaximumSize(new Dimension(Integer.MAX_VALUE, 35));
        txtName.setAlignmentX(Component.LEFT_ALIGNMENT);

        JLabel lblUnit = new JLabel("Satuan");
        lblUnit.setFont(new Font("Segoe UI", Font.BOLD, 12));
        lblUnit.setForeground(new Color(71, 85, 105));
        lblUnit.setAlignmentX(Component.LEFT_ALIGNMENT);
        
        cbUnit = new JComboBox<>(new String[]{"Lembar", "Meter", "Pcs", "Buku", "Paket"});
        cbUnit.setFont(new Font("Segoe UI", Font.PLAIN, 13));
        cbUnit.putClientProperty("JComponent.roundRect", true);
        cbUnit.setMaximumSize(new Dimension(Integer.MAX_VALUE, 35));
        cbUnit.setAlignmentX(Component.LEFT_ALIGNMENT);

        JLabel lblPrice = new JLabel("Harga per Satuan (Rp)");
        lblPrice.setFont(new Font("Segoe UI", Font.BOLD, 12));
        lblPrice.setForeground(new Color(71, 85, 105));
        lblPrice.setAlignmentX(Component.LEFT_ALIGNMENT);
        
        txtPrice = new JTextField();
        txtPrice.setFont(new Font("Segoe UI", Font.PLAIN, 13));
        txtPrice.putClientProperty("JTextField.showClearButton", true);
        txtPrice.putClientProperty("JComponent.roundRect", true);
        txtPrice.setMaximumSize(new Dimension(Integer.MAX_VALUE, 35));
        txtPrice.setAlignmentX(Component.LEFT_ALIGNMENT);

        // Tombol Aksi CRUD
        JPanel actionButtonsPanel = new JPanel(new GridLayout(2, 2, 10, 10));
        actionButtonsPanel.setOpaque(false);
        actionButtonsPanel.setMaximumSize(new Dimension(Integer.MAX_VALUE, 80));
        actionButtonsPanel.setAlignmentX(Component.LEFT_ALIGNMENT);

        btnAdd = new JButton("Tambah");
        btnAdd.setFont(new Font("Segoe UI", Font.BOLD, 12));
        btnAdd.putClientProperty("JButton.buttonType", "accent");
        btnAdd.putClientProperty("JComponent.roundRect", true);
        btnAdd.setCursor(new Cursor(Cursor.HAND_CURSOR));

        btnUpdate = new JButton("Perbarui");
        btnUpdate.setFont(new Font("Segoe UI", Font.BOLD, 12));
        btnUpdate.putClientProperty("JComponent.roundRect", true);
        btnUpdate.setCursor(new Cursor(Cursor.HAND_CURSOR));
        btnUpdate.setEnabled(false);

        btnDelete = new JButton("Hapus");
        btnDelete.setFont(new Font("Segoe UI", Font.BOLD, 12));
        btnDelete.setForeground(Color.WHITE);
        btnDelete.setBackground(new Color(239, 68, 68)); // Red 500
        btnDelete.putClientProperty("JComponent.roundRect", true);
        btnDelete.setCursor(new Cursor(Cursor.HAND_CURSOR));
        btnDelete.setEnabled(false);

        btnReset = new JButton("Reset");
        btnReset.setFont(new Font("Segoe UI", Font.BOLD, 12));
        btnReset.putClientProperty("JComponent.roundRect", true);
        btnReset.setCursor(new Cursor(Cursor.HAND_CURSOR));

        actionButtonsPanel.add(btnAdd);
        actionButtonsPanel.add(btnUpdate);
        actionButtonsPanel.add(btnDelete);
        actionButtonsPanel.add(btnReset);

        // Menyusun Form Card
        formCard.add(lblFormTitle);
        formCard.add(Box.createVerticalStrut(20));
        formCard.add(lblId);
        formCard.add(Box.createVerticalStrut(5));
        formCard.add(txtId);
        formCard.add(Box.createVerticalStrut(15));
        formCard.add(lblName);
        formCard.add(Box.createVerticalStrut(5));
        formCard.add(txtName);
        formCard.add(Box.createVerticalStrut(15));
        formCard.add(lblUnit);
        formCard.add(Box.createVerticalStrut(5));
        formCard.add(cbUnit);
        formCard.add(Box.createVerticalStrut(15));
        formCard.add(lblPrice);
        formCard.add(Box.createVerticalStrut(5));
        formCard.add(txtPrice);
        formCard.add(Box.createVerticalStrut(25));
        formCard.add(actionButtonsPanel);
        formCard.add(Box.createVerticalGlue());

        mainContent.add(tableCard, BorderLayout.CENTER);
        mainContent.add(formCard, BorderLayout.EAST);
        add(mainContent, BorderLayout.CENTER);

        // Event Listener Aksi
        serviceTable.getSelectionModel().addListSelectionListener(e -> handleTableSelection());
        
        btnAdd.addActionListener(e -> handleAdd());
        btnUpdate.addActionListener(e -> handleUpdate());
        btnDelete.addActionListener(e -> handleDelete());
        btnReset.addActionListener(e -> resetForm());
    }

    // Memuat data jasa cetak ke JTable
    private void loadTableData() {
        tableModel.setRowCount(0);
        List<Service> services = serviceDAO.getAllServices();
        for (Service s : services) {
            tableModel.addRow(new Object[]{
                "SRV-" + String.format("%03d", s.getId()),
                s.getName(),
                s.getUnit(),
                "Rp " + String.format("%,.0f", s.getPrice())
            });
        }
    }

    // Memindahkan data baris terpilih ke form input
    private void handleTableSelection() {
        int row = serviceTable.getSelectedRow();
        if (row != -1) {
            String codeStr = tableModel.getValueAt(row, 0).toString();
            int id = Integer.parseInt(codeStr.replace("SRV-", ""));
            String name = tableModel.getValueAt(row, 1).toString();
            String unit = tableModel.getValueAt(row, 2).toString();
            String priceStr = tableModel.getValueAt(row, 3).toString()
                    .replace("Rp ", "").replace(",", "").replace(".", "");
            
            priceStr = priceStr.replaceAll("[^0-9]", "");
            double price = Double.parseDouble(priceStr);

            txtId.setText(String.valueOf(id));
            txtName.setText(name);
            cbUnit.setSelectedItem(unit);
            txtPrice.setText(String.format("%.0f", price));

            btnAdd.setEnabled(false);
            btnUpdate.setEnabled(true);
            btnDelete.setEnabled(true);
        }
    }

    // Tambah Jasa Cetak
    private void handleAdd() {
        String name = txtName.getText().trim();
        String unit = cbUnit.getSelectedItem().toString();
        String priceText = txtPrice.getText().trim();

        if (name.isEmpty() || priceText.isEmpty()) {
            JOptionPane.showMessageDialog(this, "Semua field harus diisi!", "Validasi Gagal", JOptionPane.WARNING_MESSAGE);
            return;
        }

        try {
            double price = Double.parseDouble(priceText);
            Service service = new Service(0, name, unit, price);
            if (serviceDAO.addService(service)) {
                JOptionPane.showMessageDialog(this, "Jasa cetak berhasil ditambahkan!", "Sukses", JOptionPane.INFORMATION_MESSAGE);
                loadTableData();
                resetForm();
            } else {
                JOptionPane.showMessageDialog(this, "Gagal menambahkan jasa cetak.", "Gagal", JOptionPane.ERROR_MESSAGE);
            }
        } catch (NumberFormatException ex) {
            JOptionPane.showMessageDialog(this, "Format harga tidak valid! Harap masukkan angka.", "Validasi Gagal", JOptionPane.WARNING_MESSAGE);
        }
    }

    // Perbarui Jasa Cetak
    private void handleUpdate() {
        int id = Integer.parseInt(txtId.getText());
        String name = txtName.getText().trim();
        String unit = cbUnit.getSelectedItem().toString();
        String priceText = txtPrice.getText().trim();

        if (name.isEmpty() || priceText.isEmpty()) {
            JOptionPane.showMessageDialog(this, "Semua field harus diisi!", "Validasi Gagal", JOptionPane.WARNING_MESSAGE);
            return;
        }

        try {
            double price = Double.parseDouble(priceText);
            Service service = new Service(id, name, unit, price);
            if (serviceDAO.updateService(service)) {
                JOptionPane.showMessageDialog(this, "Jasa cetak berhasil diperbarui!", "Sukses", JOptionPane.INFORMATION_MESSAGE);
                loadTableData();
                resetForm();
            } else {
                JOptionPane.showMessageDialog(this, "Gagal memperbarui jasa cetak.", "Gagal", JOptionPane.ERROR_MESSAGE);
            }
        } catch (NumberFormatException ex) {
            JOptionPane.showMessageDialog(this, "Format harga tidak valid! Harap masukkan angka.", "Validasi Gagal", JOptionPane.WARNING_MESSAGE);
        }
    }

    // Hapus Jasa Cetak
    private void handleDelete() {
        int confirm = JOptionPane.showConfirmDialog(this, 
                "Apakah Anda yakin ingin menghapus jasa cetak ini?", 
                "Konfirmasi Hapus", 
                JOptionPane.YES_NO_OPTION);
        
        if (confirm == JOptionPane.YES_OPTION) {
            int id = Integer.parseInt(txtId.getText());
            if (serviceDAO.deleteService(id)) {
                JOptionPane.showMessageDialog(this, "Jasa cetak berhasil dihapus!", "Sukses", JOptionPane.INFORMATION_MESSAGE);
                loadTableData();
                resetForm();
            } else {
                JOptionPane.showMessageDialog(this, "Gagal menghapus jasa cetak.", "Gagal", JOptionPane.ERROR_MESSAGE);
            }
        }
    }

    // Reset Form Input
    private void resetForm() {
        txtId.setText("");
        txtName.setText("");
        cbUnit.setSelectedIndex(0);
        txtPrice.setText("");
        
        serviceTable.clearSelection();
        btnAdd.setEnabled(true);
        btnUpdate.setEnabled(false);
        btnDelete.setEnabled(false);
    }
}
