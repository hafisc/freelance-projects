package com.lauraprinting.ui;

import com.formdev.flatlaf.FlatLightLaf;
import com.lauraprinting.dao.UserDAO;
import com.lauraprinting.model.User;

import javax.swing.*;
import javax.swing.border.EmptyBorder;
import java.awt.*;
import java.awt.event.ActionEvent;

public class LoginFrame extends JFrame {
    private JTextField txtUsername;
    private JPasswordField txtPassword;
    private JButton btnLogin;
    private final UserDAO userDAO = new UserDAO();

    public LoginFrame() {
        initComponents();
    }

    private void initComponents() {
        setTitle("Laura Printing - Login");
        setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        setSize(420, 520);
        setLocationRelativeTo(null);
        setResizable(false);

        // Panel utama dengan latar belakang abu-abu Slate yang bersih
        JPanel mainPanel = new JPanel(new GridBagLayout());
        mainPanel.setBackground(new Color(241, 245, 249)); // Slate 100
        setContentPane(mainPanel);

        // Panel Kartu Login (Putih dengan bayangan tipis border)
        JPanel cardPanel = new JPanel(new GridBagLayout());
        cardPanel.setBackground(Color.WHITE);
        cardPanel.setBorder(BorderFactory.createCompoundBorder(
            BorderFactory.createLineBorder(new Color(226, 232, 240), 1, true),
            new EmptyBorder(35, 35, 35, 35)
        ));
        
        GridBagConstraints gbc = new GridBagConstraints();
        gbc.fill = GridBagConstraints.HORIZONTAL;
        gbc.insets = new Insets(6, 0, 6, 0);

        // 1. Judul Aplikasi (Logo)
        JLabel lblTitle = new JLabel("LAURA PRINTING", SwingConstants.CENTER);
        lblTitle.setFont(new Font("Segoe UI", Font.BOLD, 28));
        lblTitle.setForeground(new Color(79, 70, 229)); // Indigo 600
        
        gbc.gridx = 0;
        gbc.gridy = 0;
        gbc.gridwidth = 2;
        gbc.weightx = 1.0;
        cardPanel.add(lblTitle, gbc);

        // 2. Sub-judul
        JLabel lblSubtitle = new JLabel("Sistem Kasir & Manajemen Percetakan", SwingConstants.CENTER);
        lblSubtitle.setFont(new Font("Segoe UI", Font.PLAIN, 12));
        lblSubtitle.setForeground(new Color(100, 116, 139)); // Slate 500
        
        gbc.gridy = 1;
        cardPanel.add(lblSubtitle, gbc);

        // Spacer / Jarak
        gbc.gridy = 2;
        cardPanel.add(Box.createVerticalStrut(25), gbc);

        // 3. Label Username
        JLabel lblUsername = new JLabel("Username");
        lblUsername.setFont(new Font("Segoe UI", Font.BOLD, 12));
        lblUsername.setForeground(new Color(71, 85, 105)); // Slate 600
        
        gbc.gridy = 3;
        cardPanel.add(lblUsername, gbc);

        // 4. Input Username
        txtUsername = new JTextField();
        txtUsername.setFont(new Font("Segoe UI", Font.PLAIN, 14));
        txtUsername.setPreferredSize(new Dimension(300, 38)); // Padding tinggi field yang pas
        txtUsername.putClientProperty("JTextField.placeholderText", "Masukkan username Anda");
        txtUsername.putClientProperty("JTextField.showClearButton", true);
        txtUsername.putClientProperty("JComponent.roundRect", true);
        
        gbc.gridy = 4;
        cardPanel.add(txtUsername, gbc);

        // Spacer / Jarak
        gbc.gridy = 5;
        cardPanel.add(Box.createVerticalStrut(10), gbc);

        // 5. Label Password
        JLabel lblPassword = new JLabel("Password");
        lblPassword.setFont(new Font("Segoe UI", Font.BOLD, 12));
        lblPassword.setForeground(new Color(71, 85, 105)); // Slate 600
        
        gbc.gridy = 6;
        cardPanel.add(lblPassword, gbc);

        // 6. Input Password
        txtPassword = new JPasswordField();
        txtPassword.setFont(new Font("Segoe UI", Font.PLAIN, 14));
        txtPassword.setPreferredSize(new Dimension(300, 38));
        txtPassword.putClientProperty("JTextField.placeholderText", "Masukkan password Anda");
        txtPassword.putClientProperty("JComponent.roundRect", true);
        
        gbc.gridy = 7;
        cardPanel.add(txtPassword, gbc);

        // Spacer / Jarak
        gbc.gridy = 8;
        cardPanel.add(Box.createVerticalStrut(25), gbc);

        // 7. Tombol Masuk
        btnLogin = new JButton("Masuk ke Sistem");
        btnLogin.setFont(new Font("Segoe UI", Font.BOLD, 14));
        btnLogin.setForeground(Color.WHITE);
        btnLogin.setBackground(new Color(79, 70, 229)); // Indigo 600
        btnLogin.setPreferredSize(new Dimension(300, 42));
        btnLogin.putClientProperty("JButton.buttonType", "accent");
        btnLogin.putClientProperty("JComponent.roundRect", true);
        btnLogin.setCursor(new Cursor(Cursor.HAND_CURSOR));
        
        gbc.gridy = 9;
        cardPanel.add(btnLogin, gbc);

        // Hubungkan ke Layout Utama Frame
        mainPanel.add(cardPanel, new GridBagConstraints());

        // Event Listener Aksi
        btnLogin.addActionListener(this::handleLogin);
        txtPassword.addActionListener(this::handleLogin);
        txtUsername.addActionListener(this::handleLogin);
    }

    private void handleLogin(ActionEvent e) {
        String username = txtUsername.getText().trim();
        String password = new String(txtPassword.getPassword()).trim();

        if (username.isEmpty() || password.isEmpty()) {
            JOptionPane.showMessageDialog(this, 
                "Username dan password harus diisi!", 
                "Peringatan", 
                JOptionPane.WARNING_MESSAGE);
            return;
        }

        User user = userDAO.login(username, password);
        if (user != null) {
            JOptionPane.showMessageDialog(this, 
                "Login berhasil! Selamat datang, " + user.getName() + ".", 
                "Sukses", 
                JOptionPane.INFORMATION_MESSAGE);
            
            // Buka Dashboard Frame Utama
            SwingUtilities.invokeLater(() -> {
                new MainFrame(user).setVisible(true);
            });
            this.dispose();
        } else {
            JOptionPane.showMessageDialog(this, 
                "Username atau password salah!", 
                "Login Gagal", 
                JOptionPane.ERROR_MESSAGE);
        }
    }

    public static void main(String[] args) {
        // Mengatur tema FlatLightLaf
        try {
            FlatLightLaf.setup();
            UIManager.put("Button.arc", 12);
            UIManager.put("Component.arc", 12);
            UIManager.put("TextComponent.arc", 12);
        } catch (Exception e) {
            e.printStackTrace();
        }

        SwingUtilities.invokeLater(() -> {
            new LoginFrame().setVisible(true);
        });
    }
}
