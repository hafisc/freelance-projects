package com.lauraprinting.ui.panel;

import com.lauraprinting.dao.CustomerDAO;
import com.lauraprinting.model.Customer;

import javax.swing.*;
import javax.swing.border.EmptyBorder;
import javax.swing.table.DefaultTableModel;
import java.awt.*;
import java.util.List;

public class CustomerPanel extends JPanel {
    private final CustomerDAO customerDAO = new CustomerDAO();
    private JTable customerTable;
    private DefaultTableModel tableModel;
    
    // Komponen Form Pengisian
    private JTextField txtId;
    private JTextField txtName;
    private JTextField txtPhone;
    private JTextArea txtAddress;
    
    private JButton btnAdd;
    private JButton btnUpdate;
    private JButton btnDelete;
    private JButton btnReset;

    public CustomerPanel() {
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
        
        JLabel lblTitle = new JLabel("Kelola Data Pelanggan");
        lblTitle.setFont(new Font("Segoe UI", Font.BOLD, 24));
        lblTitle.setForeground(new Color(15, 23, 42));
        
        JLabel lblSubtitle = new JLabel("Tambah, edit, atau hapus data pelanggan Laura Printing.");
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

        String[] columns = {"ID Pelanggan", "Nama Lengkap", "No. Telepon", "Alamat"};
        tableModel = new DefaultTableModel(columns, 0) {
            @Override
            public boolean isCellEditable(int row, int column) {
                return false;
            }
        };

        customerTable = new JTable(tableModel);
        customerTable.setFont(new Font("Segoe UI", Font.PLAIN, 12));
        customerTable.setRowHeight(35);
        customerTable.setFocusable(false);
        
        // Memperbesar dan menata Header Tabel
        customerTable.getTableHeader().setFont(new Font("Segoe UI", Font.BOLD, 12));
        customerTable.getTableHeader().setBackground(new Color(241, 245, 249));
        customerTable.getTableHeader().setForeground(new Color(71, 85, 105));
        customerTable.getTableHeader().setPreferredSize(new Dimension(0, 32));
        
        customerTable.setSelectionBackground(new Color(224, 231, 255));
        customerTable.setSelectionForeground(new Color(79, 70, 229));
        
        // Desain modern tanpa garis vertikal
        customerTable.setShowGrid(true);
        customerTable.setShowVerticalLines(false);
        customerTable.setGridColor(new Color(241, 245, 249));

        // Konfigurasi lebar kolom proporsional
        customerTable.getColumnModel().getColumn(0).setPreferredWidth(95);   // ID Pelanggan
        customerTable.getColumnModel().getColumn(1).setPreferredWidth(180);  // Nama Lengkap
        customerTable.getColumnModel().getColumn(2).setPreferredWidth(120);  // No. Telepon
        customerTable.getColumnModel().getColumn(3).setPreferredWidth(210);  // Alamat

        // Penyelarasan kolom tabel secara rapi dan profesional
        javax.swing.table.DefaultTableCellRenderer centerRenderer = new javax.swing.table.DefaultTableCellRenderer();
        centerRenderer.setHorizontalAlignment(SwingConstants.CENTER);
        customerTable.getColumnModel().getColumn(0).setCellRenderer(centerRenderer); // ID Pelanggan
        customerTable.getColumnModel().getColumn(2).setCellRenderer(centerRenderer); // No. Telepon

        JScrollPane tableScroll = new JScrollPane(customerTable);
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

        JLabel lblFormTitle = new JLabel("Form Data Pelanggan");
        lblFormTitle.setFont(new Font("Segoe UI", Font.BOLD, 16));
        lblFormTitle.setForeground(new Color(15, 23, 42));
        lblFormTitle.setAlignmentX(Component.LEFT_ALIGNMENT);

        // Isian Inputs
        JLabel lblId = new JLabel("ID Pelanggan (Otomatis)");
        lblId.setFont(new Font("Segoe UI", Font.BOLD, 12));
        lblId.setForeground(new Color(71, 85, 105));
        lblId.setAlignmentX(Component.LEFT_ALIGNMENT);
        
        txtId = new JTextField();
        txtId.setEnabled(false);
        txtId.setFont(new Font("Segoe UI", Font.PLAIN, 13));
        txtId.putClientProperty("JComponent.roundRect", true);
        txtId.setMaximumSize(new Dimension(Integer.MAX_VALUE, 35));
        txtId.setAlignmentX(Component.LEFT_ALIGNMENT);

        JLabel lblName = new JLabel("Nama Pelanggan");
        lblName.setFont(new Font("Segoe UI", Font.BOLD, 12));
        lblName.setForeground(new Color(71, 85, 105));
        lblName.setAlignmentX(Component.LEFT_ALIGNMENT);
        
        txtName = new JTextField();
        txtName.setFont(new Font("Segoe UI", Font.PLAIN, 13));
        txtName.putClientProperty("JTextField.showClearButton", true);
        txtName.putClientProperty("JComponent.roundRect", true);
        txtName.setMaximumSize(new Dimension(Integer.MAX_VALUE, 35));
        txtName.setAlignmentX(Component.LEFT_ALIGNMENT);

        JLabel lblPhone = new JLabel("No. Telepon");
        lblPhone.setFont(new Font("Segoe UI", Font.BOLD, 12));
        lblPhone.setForeground(new Color(71, 85, 105));
        lblPhone.setAlignmentX(Component.LEFT_ALIGNMENT);
        
        txtPhone = new JTextField();
        txtPhone.setFont(new Font("Segoe UI", Font.PLAIN, 13));
        txtPhone.putClientProperty("JTextField.showClearButton", true);
        txtPhone.putClientProperty("JComponent.roundRect", true);
        txtPhone.setMaximumSize(new Dimension(Integer.MAX_VALUE, 35));
        txtPhone.setAlignmentX(Component.LEFT_ALIGNMENT);

        JLabel lblAddress = new JLabel("Alamat Lengkap");
        lblAddress.setFont(new Font("Segoe UI", Font.BOLD, 12));
        lblAddress.setForeground(new Color(71, 85, 105));
        lblAddress.setAlignmentX(Component.LEFT_ALIGNMENT);
        
        txtAddress = new JTextArea(3, 20);
        txtAddress.setFont(new Font("Segoe UI", Font.PLAIN, 13));
        txtAddress.setLineWrap(true);
        txtAddress.setWrapStyleWord(true);
        
        JScrollPane addressScroll = new JScrollPane(txtAddress);
        addressScroll.setMaximumSize(new Dimension(Integer.MAX_VALUE, 80));
        addressScroll.setAlignmentX(Component.LEFT_ALIGNMENT);

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
        formCard.add(lblPhone);
        formCard.add(Box.createVerticalStrut(5));
        formCard.add(txtPhone);
        formCard.add(Box.createVerticalStrut(15));
        formCard.add(lblAddress);
        formCard.add(Box.createVerticalStrut(5));
        formCard.add(addressScroll);
        formCard.add(Box.createVerticalStrut(25));
        formCard.add(actionButtonsPanel);
        formCard.add(Box.createVerticalGlue());

        mainContent.add(tableCard, BorderLayout.CENTER);
        mainContent.add(formCard, BorderLayout.EAST);
        add(mainContent, BorderLayout.CENTER);

        // Event Listener Aksi
        customerTable.getSelectionModel().addListSelectionListener(e -> handleTableSelection());
        
        btnAdd.addActionListener(e -> handleAdd());
        btnUpdate.addActionListener(e -> handleUpdate());
        btnDelete.addActionListener(e -> handleDelete());
        btnReset.addActionListener(e -> resetForm());
    }

    // Memuat data pelanggan dari database ke JTable
    private void loadTableData() {
        tableModel.setRowCount(0);
        List<Customer> customers = customerDAO.getAllCustomers();
        for (Customer c : customers) {
            tableModel.addRow(new Object[]{
                "CUST-" + String.format("%03d", c.getId()),
                c.getName(),
                c.getPhone(),
                c.getAddress()
            });
        }
    }

    // Memindahkan data baris terpilih ke form input
    private void handleTableSelection() {
        int row = customerTable.getSelectedRow();
        if (row != -1) {
            String codeStr = tableModel.getValueAt(row, 0).toString();
            int id = Integer.parseInt(codeStr.replace("CUST-", ""));
            String name = tableModel.getValueAt(row, 1).toString();
            String phone = tableModel.getValueAt(row, 2).toString();
            String address = tableModel.getValueAt(row, 3).toString();

            txtId.setText(String.valueOf(id));
            txtName.setText(name);
            txtPhone.setText(phone);
            txtAddress.setText(address);

            btnAdd.setEnabled(false);
            btnUpdate.setEnabled(true);
            
            // Batasan: Jangan hapus data Default Walk-in Customer
            if (id == 1 || name.equalsIgnoreCase("Walk-in Customer")) {
                btnDelete.setEnabled(false);
            } else {
                btnDelete.setEnabled(true);
            }
        }
    }

    // Tambah Pelanggan Baru
    private void handleAdd() {
        String name = txtName.getText().trim();
        String phone = txtPhone.getText().trim();
        String address = txtAddress.getText().trim();

        if (name.isEmpty() || phone.isEmpty()) {
            JOptionPane.showMessageDialog(this, "Nama dan No. Telepon harus diisi!", "Validasi Gagal", JOptionPane.WARNING_MESSAGE);
            return;
        }

        Customer customer = new Customer(0, name, phone, address);
        if (customerDAO.addCustomer(customer)) {
            JOptionPane.showMessageDialog(this, "Pelanggan berhasil ditambahkan!", "Sukses", JOptionPane.INFORMATION_MESSAGE);
            loadTableData();
            resetForm();
        } else {
            JOptionPane.showMessageDialog(this, "Gagal menambahkan pelanggan.", "Gagal", JOptionPane.ERROR_MESSAGE);
        }
    }

    // Perbarui Pelanggan
    private void handleUpdate() {
        int id = Integer.parseInt(txtId.getText());
        String name = txtName.getText().trim();
        String phone = txtPhone.getText().trim();
        String address = txtAddress.getText().trim();

        if (name.isEmpty() || phone.isEmpty()) {
            JOptionPane.showMessageDialog(this, "Nama dan No. Telepon harus diisi!", "Validasi Gagal", JOptionPane.WARNING_MESSAGE);
            return;
        }

        Customer customer = new Customer(id, name, phone, address);
        if (customerDAO.updateCustomer(customer)) {
            JOptionPane.showMessageDialog(this, "Pelanggan berhasil diperbarui!", "Sukses", JOptionPane.INFORMATION_MESSAGE);
            loadTableData();
            resetForm();
        } else {
            JOptionPane.showMessageDialog(this, "Gagal memperbarui pelanggan.", "Gagal", JOptionPane.ERROR_MESSAGE);
        }
    }

    // Hapus Pelanggan
    private void handleDelete() {
        int confirm = JOptionPane.showConfirmDialog(this, 
                "Apakah Anda yakin ingin menghapus pelanggan ini?", 
                "Konfirmasi Hapus", 
                JOptionPane.YES_NO_OPTION);
        
        if (confirm == JOptionPane.YES_OPTION) {
            int id = Integer.parseInt(txtId.getText());
            if (customerDAO.deleteCustomer(id)) {
                JOptionPane.showMessageDialog(this, "Pelanggan berhasil dihapus!", "Sukses", JOptionPane.INFORMATION_MESSAGE);
                loadTableData();
                resetForm();
            } else {
                JOptionPane.showMessageDialog(this, "Gagal menghapus pelanggan.", "Gagal", JOptionPane.ERROR_MESSAGE);
            }
        }
    }

    // Reset Form Input
    private void resetForm() {
        txtId.setText("");
        txtName.setText("");
        txtPhone.setText("");
        txtAddress.setText("");
        
        customerTable.clearSelection();
        btnAdd.setEnabled(true);
        btnUpdate.setEnabled(false);
        btnDelete.setEnabled(false);
    }
}
