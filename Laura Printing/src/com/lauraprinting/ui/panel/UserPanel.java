package com.lauraprinting.ui.panel;

import com.lauraprinting.dao.UserDAO;
import com.lauraprinting.model.User;

import javax.swing.*;
import javax.swing.border.EmptyBorder;
import javax.swing.table.DefaultTableModel;
import java.awt.*;
import java.util.List;

public class UserPanel extends JPanel {
    private final UserDAO userDAO = new UserDAO();
    private JTable userTable;
    private DefaultTableModel tableModel;
    
    // Komponen Form Pengisian
    private JTextField txtId;
    private JTextField txtName;
    private JTextField txtUsername;
    private JTextField txtPassword;
    private JComboBox<String> cbRole;
    
    private JButton btnAdd;
    private JButton btnUpdate;
    private JButton btnDelete;
    private JButton btnReset;
    
    private final User currentUser;

    public UserPanel(User currentUser) {
        this.currentUser = currentUser;
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
        
        JLabel lblTitle = new JLabel("Kelola Akun Karyawan");
        lblTitle.setFont(new Font("Segoe UI", Font.BOLD, 24));
        lblTitle.setForeground(new Color(15, 23, 42));
        
        JLabel lblSubtitle = new JLabel("Kelola akun Admin dan Kasir yang memiliki akses ke sistem.");
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

        String[] columns = {"ID User", "Nama Lengkap", "Username", "Role/Akses"};
        tableModel = new DefaultTableModel(columns, 0) {
            @Override
            public boolean isCellEditable(int row, int column) {
                return false;
            }
        };

        userTable = new JTable(tableModel);
        userTable.setFont(new Font("Segoe UI", Font.PLAIN, 12));
        userTable.setRowHeight(35);
        userTable.setFocusable(false);
        
        // Memperbesar dan menata Header Tabel
        userTable.getTableHeader().setFont(new Font("Segoe UI", Font.BOLD, 12));
        userTable.getTableHeader().setBackground(new Color(241, 245, 249));
        userTable.getTableHeader().setForeground(new Color(71, 85, 105));
        userTable.getTableHeader().setPreferredSize(new Dimension(0, 32));
        
        userTable.setSelectionBackground(new Color(224, 231, 255));
        userTable.setSelectionForeground(new Color(79, 70, 229));
        
        // Desain modern tanpa garis vertikal
        userTable.setShowGrid(true);
        userTable.setShowVerticalLines(false);
        userTable.setGridColor(new Color(241, 245, 249));

        // Konfigurasi lebar kolom proporsional
        userTable.getColumnModel().getColumn(0).setPreferredWidth(95);   // ID User
        userTable.getColumnModel().getColumn(1).setPreferredWidth(180);  // Nama Lengkap
        userTable.getColumnModel().getColumn(2).setPreferredWidth(125);  // Username
        userTable.getColumnModel().getColumn(3).setPreferredWidth(110);  // Role

        // Penyelarasan kolom tabel secara rapi dan profesional
        javax.swing.table.DefaultTableCellRenderer centerRenderer = new javax.swing.table.DefaultTableCellRenderer();
        centerRenderer.setHorizontalAlignment(SwingConstants.CENTER);
        userTable.getColumnModel().getColumn(0).setCellRenderer(centerRenderer); // ID User
        userTable.getColumnModel().getColumn(3).setCellRenderer(centerRenderer); // Role

        JScrollPane tableScroll = new JScrollPane(userTable);
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

        JLabel lblFormTitle = new JLabel("Form Data Karyawan");
        lblFormTitle.setFont(new Font("Segoe UI", Font.BOLD, 16));
        lblFormTitle.setForeground(new Color(15, 23, 42));
        lblFormTitle.setAlignmentX(Component.LEFT_ALIGNMENT);

        // Isian Inputs
        JLabel lblId = new JLabel("ID Karyawan (Otomatis)");
        lblId.setFont(new Font("Segoe UI", Font.BOLD, 12));
        lblId.setForeground(new Color(71, 85, 105));
        lblId.setAlignmentX(Component.LEFT_ALIGNMENT);
        
        txtId = new JTextField();
        txtId.setEnabled(false);
        txtId.setFont(new Font("Segoe UI", Font.PLAIN, 13));
        txtId.putClientProperty("JComponent.roundRect", true);
        txtId.setMaximumSize(new Dimension(Integer.MAX_VALUE, 35));
        txtId.setAlignmentX(Component.LEFT_ALIGNMENT);

        JLabel lblName = new JLabel("Nama Lengkap");
        lblName.setFont(new Font("Segoe UI", Font.BOLD, 12));
        lblName.setForeground(new Color(71, 85, 105));
        lblName.setAlignmentX(Component.LEFT_ALIGNMENT);
        
        txtName = new JTextField();
        txtName.setFont(new Font("Segoe UI", Font.PLAIN, 13));
        txtName.putClientProperty("JTextField.showClearButton", true);
        txtName.putClientProperty("JComponent.roundRect", true);
        txtName.setMaximumSize(new Dimension(Integer.MAX_VALUE, 35));
        txtName.setAlignmentX(Component.LEFT_ALIGNMENT);

        JLabel lblUsername = new JLabel("Username");
        lblUsername.setFont(new Font("Segoe UI", Font.BOLD, 12));
        lblUsername.setForeground(new Color(71, 85, 105));
        lblUsername.setAlignmentX(Component.LEFT_ALIGNMENT);
        
        txtUsername = new JTextField();
        txtUsername.setFont(new Font("Segoe UI", Font.PLAIN, 13));
        txtUsername.putClientProperty("JTextField.showClearButton", true);
        txtUsername.putClientProperty("JComponent.roundRect", true);
        txtUsername.setMaximumSize(new Dimension(Integer.MAX_VALUE, 35));
        txtUsername.setAlignmentX(Component.LEFT_ALIGNMENT);

        JLabel lblPassword = new JLabel("Password");
        lblPassword.setFont(new Font("Segoe UI", Font.BOLD, 12));
        lblPassword.setForeground(new Color(71, 85, 105));
        lblPassword.setAlignmentX(Component.LEFT_ALIGNMENT);
        
        txtPassword = new JTextField();
        txtPassword.setFont(new Font("Segoe UI", Font.PLAIN, 13));
        txtPassword.putClientProperty("JTextField.showClearButton", true);
        txtPassword.putClientProperty("JComponent.roundRect", true);
        txtPassword.setMaximumSize(new Dimension(Integer.MAX_VALUE, 35));
        txtPassword.setAlignmentX(Component.LEFT_ALIGNMENT);

        JLabel lblRole = new JLabel("Role / Akses");
        lblRole.setFont(new Font("Segoe UI", Font.BOLD, 12));
        lblRole.setForeground(new Color(71, 85, 105));
        lblRole.setAlignmentX(Component.LEFT_ALIGNMENT);
        
        cbRole = new JComboBox<>(new String[]{"Admin", "Cashier"});
        cbRole.setFont(new Font("Segoe UI", Font.PLAIN, 13));
        cbRole.putClientProperty("JComponent.roundRect", true);
        cbRole.setMaximumSize(new Dimension(Integer.MAX_VALUE, 35));
        cbRole.setAlignmentX(Component.LEFT_ALIGNMENT);

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
        formCard.add(lblUsername);
        formCard.add(Box.createVerticalStrut(5));
        formCard.add(txtUsername);
        formCard.add(Box.createVerticalStrut(15));
        formCard.add(lblPassword);
        formCard.add(Box.createVerticalStrut(5));
        formCard.add(txtPassword);
        formCard.add(Box.createVerticalStrut(15));
        formCard.add(lblRole);
        formCard.add(Box.createVerticalStrut(5));
        formCard.add(cbRole);
        formCard.add(Box.createVerticalStrut(25));
        formCard.add(actionButtonsPanel);
        formCard.add(Box.createVerticalGlue());

        mainContent.add(tableCard, BorderLayout.CENTER);
        mainContent.add(formCard, BorderLayout.EAST);
        add(mainContent, BorderLayout.CENTER);

        // Event Listener Aksi
        userTable.getSelectionModel().addListSelectionListener(e -> handleTableSelection());
        
        btnAdd.addActionListener(e -> handleAdd());
        btnUpdate.addActionListener(e -> handleUpdate());
        btnDelete.addActionListener(e -> handleDelete());
        btnReset.addActionListener(e -> resetForm());
    }

    // Memuat data karyawan dari database ke JTable
    private void loadTableData() {
        tableModel.setRowCount(0);
        List<User> users = userDAO.getAllUsers();
        for (User u : users) {
            tableModel.addRow(new Object[]{
                "USR-" + String.format("%03d", u.getId()),
                u.getName(),
                u.getUsername(),
                u.getRole()
            });
        }
    }

    // Memindahkan data baris terpilih ke form input
    private void handleTableSelection() {
        int row = userTable.getSelectedRow();
        if (row != -1) {
            String codeStr = tableModel.getValueAt(row, 0).toString();
            int id = Integer.parseInt(codeStr.replace("USR-", ""));
            
            // Mengambil password asli dari daftar karyawan
            List<User> users = userDAO.getAllUsers();
            User selectedUser = null;
            for (User u : users) {
                if (u.getId() == id) {
                    selectedUser = u;
                    break;
                }
            }

            if (selectedUser != null) {
                txtId.setText(String.valueOf(selectedUser.getId()));
                txtName.setText(selectedUser.getName());
                txtUsername.setText(selectedUser.getUsername());
                txtPassword.setText(selectedUser.getPassword());
                cbRole.setSelectedItem(selectedUser.getRole());

                btnAdd.setEnabled(false);
                btnUpdate.setEnabled(true);
                
                // Aturan bisnis:
                // 1. Tidak bisa menghapus akun sendiri
                // 2. Default admin ('admin') tidak bisa dihapus demi keamanan sistem
                if (id == currentUser.getId() || selectedUser.getUsername().equals("admin")) {
                    btnDelete.setEnabled(false);
                } else {
                    btnDelete.setEnabled(true);
                }
            }
        }
    }

    // Tambah Karyawan Baru
    private void handleAdd() {
        String name = txtName.getText().trim();
        String username = txtUsername.getText().trim();
        String password = txtPassword.getText().trim();
        String role = cbRole.getSelectedItem().toString();

        if (name.isEmpty() || username.isEmpty() || password.isEmpty()) {
            JOptionPane.showMessageDialog(this, "Semua field harus diisi!", "Validasi Gagal", JOptionPane.WARNING_MESSAGE);
            return;
        }

        User user = new User(0, username, password, role, name);
        if (userDAO.addUser(user)) {
            JOptionPane.showMessageDialog(this, "Karyawan berhasil ditambahkan!", "Sukses", JOptionPane.INFORMATION_MESSAGE);
            loadTableData();
            resetForm();
        } else {
            JOptionPane.showMessageDialog(this, "Gagal menambahkan karyawan. Pastikan username belum terdaftar.", "Gagal", JOptionPane.ERROR_MESSAGE);
        }
    }

    // Perbarui Karyawan
    private void handleUpdate() {
        int id = Integer.parseInt(txtId.getText());
        String name = txtName.getText().trim();
        String username = txtUsername.getText().trim();
        String password = txtPassword.getText().trim();
        String role = cbRole.getSelectedItem().toString();

        if (name.isEmpty() || username.isEmpty() || password.isEmpty()) {
            JOptionPane.showMessageDialog(this, "Semua field harus diisi!", "Validasi Gagal", JOptionPane.WARNING_MESSAGE);
            return;
        }

        User user = new User(id, username, password, role, name);
        if (userDAO.updateUser(user)) {
            JOptionPane.showMessageDialog(this, "Data karyawan berhasil diperbarui!", "Sukses", JOptionPane.INFORMATION_MESSAGE);
            loadTableData();
            resetForm();
        } else {
            JOptionPane.showMessageDialog(this, "Gagal memperbarui data karyawan.", "Gagal", JOptionPane.ERROR_MESSAGE);
        }
    }

    // Hapus Karyawan
    private void handleDelete() {
        int confirm = JOptionPane.showConfirmDialog(this, 
                "Apakah Anda yakin ingin menghapus akun karyawan ini?", 
                "Konfirmasi Hapus", 
                JOptionPane.YES_NO_OPTION);
        
        if (confirm == JOptionPane.YES_OPTION) {
            int id = Integer.parseInt(txtId.getText());
            if (userDAO.deleteUser(id)) {
                JOptionPane.showMessageDialog(this, "Akun karyawan berhasil dihapus!", "Sukses", JOptionPane.INFORMATION_MESSAGE);
                loadTableData();
                resetForm();
            } else {
                JOptionPane.showMessageDialog(this, "Gagal menghapus akun karyawan.", "Gagal", JOptionPane.ERROR_MESSAGE);
            }
        }
    }

    // Reset Form Input
    private void resetForm() {
        txtId.setText("");
        txtName.setText("");
        txtUsername.setText("");
        txtPassword.setText("");
        cbRole.setSelectedIndex(0);
        
        userTable.clearSelection();
        btnAdd.setEnabled(true);
        btnUpdate.setEnabled(false);
        btnDelete.setEnabled(false);
    }
}
