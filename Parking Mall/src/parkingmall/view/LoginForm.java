package parkingmall.view;

import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import javax.swing.*;
import javax.swing.border.EmptyBorder;
import parkingmall.dao.UserDAO;
import parkingmall.helper.MessageHelper;
import parkingmall.model.User;
import parkingmall.view.admin.AdminDashboard;
import parkingmall.view.pengguna.PenggunaDashboard;
import parkingmall.view.petugas.PetugasDashboard;

public class LoginForm extends JFrame {
    private final UserDAO userDAO;
    
    // Panel utama dengan CardLayout untuk berpindah antara Login dan Register
    private final CardLayout cardLayout;
    private final JPanel containerPanel;
    
    // Warna tema sesuai referensi client
    private final Color bgLightBlue = Color.decode("#85C1E9"); // Medium sky-blue untuk background form
    private final Color darkBlue = Color.decode("#0F2742");    // Dark blue untuk sidebar
    private final Color btnBlue = Color.decode("#1E88E5");

    public LoginForm() {
        this.userDAO = new UserDAO();
        
        setTitle("Parking Mall - Login");
        setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        setSize(550, 480); // Ukuran disesuaikan agar proporsional dengan sidebar kiri dan form side-by-side
        setLocationRelativeTo(null);
        setResizable(false);

        cardLayout = new CardLayout();
        containerPanel = new JPanel(cardLayout);
        containerPanel.setBackground(bgLightBlue);

        // Buat panel login dan register
        JPanel loginPanel = createLoginPanel();
        JPanel registerPanel = createRegisterPanel();

        containerPanel.add(loginPanel, "LOGIN");
        containerPanel.add(registerPanel, "REGISTER");

        add(containerPanel);
        
        // Tampilkan panel login sebagai default
        cardLayout.show(containerPanel, "LOGIN");
    }

    // Fungsi ini digunakan untuk merancang panel login sesuai referensi UI client
    private JPanel createLoginPanel() {
        JPanel panel = new JPanel(new BorderLayout());
        panel.setBackground(bgLightBlue);

        // Sidebar Kiri (Dark Blue Strip) - Sesuai referensi
        JPanel leftSidebar = new JPanel();
        leftSidebar.setBackground(darkBlue);
        leftSidebar.setPreferredSize(new Dimension(90, 0));
        panel.add(leftSidebar, BorderLayout.WEST);

        // Area Form (Center) - Sesuai referensi
        JPanel formArea = new JPanel(new GridBagLayout());
        formArea.setBackground(bgLightBlue);
        
        GridBagConstraints gbc = new GridBagConstraints();
        gbc.insets = new Insets(8, 8, 8, 8);
        gbc.fill = GridBagConstraints.HORIZONTAL;

        // 1. Logo "P" rounded square (Sesuai referensi)
        JLabel lblLogoP = new JLabel("P", SwingConstants.CENTER) {
            @Override
            protected void paintComponent(Graphics g) {
                Graphics2D g2 = (Graphics2D) g.create();
                g2.setRenderingHint(RenderingHints.KEY_ANTIALIASING, RenderingHints.VALUE_ANTIALIAS_ON);
                g2.setColor(darkBlue);
                g2.fillRoundRect(0, 0, getWidth(), getHeight(), 20, 20);
                g2.setColor(Color.WHITE);
                g2.setStroke(new BasicStroke(3));
                g2.drawRoundRect(2, 2, getWidth() - 5, getHeight() - 5, 20, 20);
                super.paintComponent(g);
                g2.dispose();
            }
        };
        lblLogoP.setFont(new Font("Segoe UI", Font.BOLD, 48));
        lblLogoP.setForeground(Color.WHITE);
        lblLogoP.setPreferredSize(new Dimension(85, 85));

        gbc.gridx = 0;
        gbc.gridy = 0;
        gbc.gridwidth = 2;
        gbc.anchor = GridBagConstraints.CENTER;
        gbc.fill = GridBagConstraints.NONE;
        gbc.insets = new Insets(10, 8, 10, 8);
        formArea.add(lblLogoP, gbc);

        // 2. Judul: LOGIN PARKING MALL (Sesuai referensi)
        JLabel titleLabel = new JLabel("LOGIN PARKING MALL");
        titleLabel.setFont(new Font("Segoe UI", Font.BOLD, 22));
        titleLabel.setForeground(darkBlue);
        
        gbc.gridy = 1;
        gbc.insets = new Insets(5, 8, 25, 8);
        formArea.add(titleLabel, gbc);

        // 3. Username Label & Field (Side-by-side - Sesuai referensi)
        JLabel userLabel = new JLabel("Username");
        userLabel.setFont(new Font("Segoe UI", Font.BOLD, 13));
        userLabel.setForeground(darkBlue);

        JTextField userField = new JTextField(15);
        userField.setFont(new Font("Segoe UI", Font.PLAIN, 13));
        userField.setPreferredSize(new Dimension(180, 28));

        gbc.gridwidth = 1;
        gbc.gridy = 2;
        gbc.insets = new Insets(6, 6, 6, 6);
        
        gbc.gridx = 0;
        gbc.anchor = GridBagConstraints.EAST;
        gbc.fill = GridBagConstraints.NONE;
        formArea.add(userLabel, gbc);

        gbc.gridx = 1;
        gbc.anchor = GridBagConstraints.WEST;
        gbc.fill = GridBagConstraints.HORIZONTAL;
        formArea.add(userField, gbc);

        // 4. Password Label & Field (Side-by-side - Sesuai referensi)
        JLabel passLabel = new JLabel("Password");
        passLabel.setFont(new Font("Segoe UI", Font.BOLD, 13));
        passLabel.setForeground(darkBlue);

        JPasswordField passField = new JPasswordField(15);
        passField.setFont(new Font("Segoe UI", Font.PLAIN, 13));
        passField.setPreferredSize(new Dimension(180, 28));

        gbc.gridy = 3;
        
        gbc.gridx = 0;
        gbc.anchor = GridBagConstraints.EAST;
        gbc.fill = GridBagConstraints.NONE;
        formArea.add(passLabel, gbc);

        gbc.gridx = 1;
        gbc.anchor = GridBagConstraints.WEST;
        gbc.fill = GridBagConstraints.HORIZONTAL;
        formArea.add(passField, gbc);

        // 5. Button Login (White background with Lock icon - Sesuai referensi)
        JButton btnLogin = new JButton("🔒 Login");
        btnLogin.setFont(new Font("Segoe UI", Font.BOLD, 13));
        parkingmall.helper.UIHelper.styleButton(btnLogin, Color.WHITE, Color.BLACK, 120, 34);

        gbc.gridy = 4;
        gbc.gridx = 0;
        gbc.gridwidth = 2;
        gbc.anchor = GridBagConstraints.CENTER;
        gbc.fill = GridBagConstraints.NONE;
        gbc.insets = new Insets(20, 8, 10, 8);
        formArea.add(btnLogin, gbc);

        // 6. Link ke Register
        JButton btnGoRegister = new JButton("Belum punya akun? Daftar di sini");
        btnGoRegister.setFont(new Font("Segoe UI", Font.ITALIC, 11));
        btnGoRegister.setForeground(darkBlue);
        btnGoRegister.setBorderPainted(false);
        btnGoRegister.setContentAreaFilled(false);
        btnGoRegister.setCursor(new Cursor(Cursor.HAND_CURSOR));

        gbc.gridy = 5;
        gbc.insets = new Insets(5, 8, 8, 8);
        formArea.add(btnGoRegister, gbc);

        // Action Listeners
        btnLogin.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                String username = userField.getText().trim();
                String password = new String(passField.getPassword()).trim();

                if (username.isEmpty() || password.isEmpty()) {
                    MessageHelper.showWarning(LoginForm.this, "Username dan Password tidak boleh kosong!");
                    return;
                }

                User user = userDAO.login(username, password);
                if (user != null) {
                    MessageHelper.showInfo(LoginForm.this, "Login Berhasil! Selamat datang " + user.getNama());
                    LoginForm.this.dispose();
                    
                    switch (user.getRole()) {
                        case "admin":
                            new AdminDashboard(user).setVisible(true);
                            break;
                        case "petugas":
                            new PetugasDashboard(user).setVisible(true);
                            break;
                        case "pengguna":
                            new PenggunaDashboard(user).setVisible(true);
                            break;
                        default:
                            MessageHelper.showError(LoginForm.this, "Role tidak valid!");
                            LoginForm.this.setVisible(true);
                    }
                } else {
                    MessageHelper.showError(LoginForm.this, "Username atau Password salah!");
                }
            }
        });

        btnGoRegister.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                cardLayout.show(containerPanel, "REGISTER");
            }
        });

        panel.add(formArea, BorderLayout.CENTER);
        return panel;
    }

    // Fungsi ini digunakan untuk merancang panel register sesuai referensi UI client
    private JPanel createRegisterPanel() {
        JPanel panel = new JPanel(new BorderLayout());
        panel.setBackground(bgLightBlue);

        // Sidebar Kiri (Dark Blue Strip) - Sesuai referensi
        JPanel leftSidebar = new JPanel();
        leftSidebar.setBackground(darkBlue);
        leftSidebar.setPreferredSize(new Dimension(90, 0));
        panel.add(leftSidebar, BorderLayout.WEST);

        // Area Form (Center)
        JPanel formArea = new JPanel(new GridBagLayout());
        formArea.setBackground(bgLightBlue);
        
        GridBagConstraints gbc = new GridBagConstraints();
        gbc.insets = new Insets(5, 5, 5, 5);
        gbc.fill = GridBagConstraints.HORIZONTAL;

        // 1. Logo "P" rounded square (Sesuai referensi)
        JLabel lblLogoP = new JLabel("P", SwingConstants.CENTER) {
            @Override
            protected void paintComponent(Graphics g) {
                Graphics2D g2 = (Graphics2D) g.create();
                g2.setRenderingHint(RenderingHints.KEY_ANTIALIASING, RenderingHints.VALUE_ANTIALIAS_ON);
                g2.setColor(darkBlue);
                g2.fillRoundRect(0, 0, getWidth(), getHeight(), 15, 15);
                g2.setColor(Color.WHITE);
                g2.setStroke(new BasicStroke(2));
                g2.drawRoundRect(2, 2, getWidth() - 5, getHeight() - 5, 15, 15);
                super.paintComponent(g);
                g2.dispose();
            }
        };
        lblLogoP.setFont(new Font("Segoe UI", Font.BOLD, 36));
        lblLogoP.setForeground(Color.WHITE);
        lblLogoP.setPreferredSize(new Dimension(65, 65));

        gbc.gridx = 0;
        gbc.gridy = 0;
        gbc.gridwidth = 2;
        gbc.anchor = GridBagConstraints.CENTER;
        gbc.fill = GridBagConstraints.NONE;
        gbc.insets = new Insets(10, 5, 5, 5);
        formArea.add(lblLogoP, gbc);

        // 2. Judul: DAFTAR PENGGUNA BARU
        JLabel titleLabel = new JLabel("DAFTAR PENGGUNA BARU");
        titleLabel.setFont(new Font("Segoe UI", Font.BOLD, 18));
        titleLabel.setForeground(darkBlue);
        
        gbc.gridy = 1;
        gbc.insets = new Insets(2, 5, 15, 5);
        formArea.add(titleLabel, gbc);

        // Inputs
        gbc.gridwidth = 1;
        gbc.insets = new Insets(4, 5, 4, 5);

        // Nama Lengkap
        JLabel namaLabel = new JLabel("Nama Lengkap");
        namaLabel.setFont(new Font("Segoe UI", Font.BOLD, 12));
        namaLabel.setForeground(darkBlue);
        JTextField namaField = new JTextField(15);
        namaField.setFont(new Font("Segoe UI", Font.PLAIN, 12));
        namaField.setPreferredSize(new Dimension(180, 26));

        gbc.gridy = 2;
        gbc.gridx = 0;
        gbc.anchor = GridBagConstraints.EAST;
        gbc.fill = GridBagConstraints.NONE;
        formArea.add(namaLabel, gbc);
        gbc.gridx = 1;
        gbc.anchor = GridBagConstraints.WEST;
        gbc.fill = GridBagConstraints.HORIZONTAL;
        formArea.add(namaField, gbc);

        // Username
        JLabel userLabel = new JLabel("Username");
        userLabel.setFont(new Font("Segoe UI", Font.BOLD, 12));
        userLabel.setForeground(darkBlue);
        JTextField userField = new JTextField(15);
        userField.setFont(new Font("Segoe UI", Font.PLAIN, 12));
        userField.setPreferredSize(new Dimension(180, 26));

        gbc.gridy = 3;
        gbc.gridx = 0;
        gbc.anchor = GridBagConstraints.EAST;
        gbc.fill = GridBagConstraints.NONE;
        formArea.add(userLabel, gbc);
        gbc.gridx = 1;
        gbc.anchor = GridBagConstraints.WEST;
        gbc.fill = GridBagConstraints.HORIZONTAL;
        formArea.add(userField, gbc);

        // Password
        JLabel passLabel = new JLabel("Password");
        passLabel.setFont(new Font("Segoe UI", Font.BOLD, 12));
        passLabel.setForeground(darkBlue);
        JPasswordField passField = new JPasswordField(15);
        passField.setFont(new Font("Segoe UI", Font.PLAIN, 12));
        passField.setPreferredSize(new Dimension(180, 26));

        gbc.gridy = 4;
        gbc.gridx = 0;
        gbc.anchor = GridBagConstraints.EAST;
        gbc.fill = GridBagConstraints.NONE;
        formArea.add(passLabel, gbc);
        gbc.gridx = 1;
        gbc.anchor = GridBagConstraints.WEST;
        gbc.fill = GridBagConstraints.HORIZONTAL;
        formArea.add(passField, gbc);

        // Konfirmasi Password
        JLabel confLabel = new JLabel("Konfirmasi");
        confLabel.setFont(new Font("Segoe UI", Font.BOLD, 12));
        confLabel.setForeground(darkBlue);
        JPasswordField confField = new JPasswordField(15);
        confField.setFont(new Font("Segoe UI", Font.PLAIN, 12));
        confField.setPreferredSize(new Dimension(180, 26));

        gbc.gridy = 5;
        gbc.gridx = 0;
        gbc.anchor = GridBagConstraints.EAST;
        gbc.fill = GridBagConstraints.NONE;
        formArea.add(confLabel, gbc);
        gbc.gridx = 1;
        gbc.anchor = GridBagConstraints.WEST;
        gbc.fill = GridBagConstraints.HORIZONTAL;
        formArea.add(confField, gbc);

        // Button Register (White style - Sesuai referensi)
        JButton btnRegister = new JButton("🔒 Daftar");
        btnRegister.setFont(new Font("Segoe UI", Font.BOLD, 12));
        parkingmall.helper.UIHelper.styleButton(btnRegister, Color.WHITE, Color.BLACK, 120, 32);

        gbc.gridy = 6;
        gbc.gridx = 0;
        gbc.gridwidth = 2;
        gbc.anchor = GridBagConstraints.CENTER;
        gbc.fill = GridBagConstraints.NONE;
        gbc.insets = new Insets(15, 5, 5, 5);
        formArea.add(btnRegister, gbc);

        // Link ke Login
        JButton btnGoLogin = new JButton("Sudah punya akun? Login");
        btnGoLogin.setFont(new Font("Segoe UI", Font.ITALIC, 11));
        btnGoLogin.setForeground(darkBlue);
        btnGoLogin.setBorderPainted(false);
        btnGoLogin.setContentAreaFilled(false);
        btnGoLogin.setCursor(new Cursor(Cursor.HAND_CURSOR));

        gbc.gridy = 7;
        gbc.insets = new Insets(2, 5, 5, 5);
        formArea.add(btnGoLogin, gbc);

        // Action Listeners
        btnRegister.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                String nama = namaField.getText().trim();
                String username = userField.getText().trim();
                String password = new String(passField.getPassword()).trim();
                String konfirmasi = new String(confField.getPassword()).trim();

                if (nama.isEmpty() || username.isEmpty() || password.isEmpty()) {
                    MessageHelper.showWarning(LoginForm.this, "Semua input wajib diisi!");
                    return;
                }

                if (!password.equals(konfirmasi)) {
                    MessageHelper.showError(LoginForm.this, "Konfirmasi password tidak cocok!");
                    return;
                }

                if (userDAO.isUsernameTaken(username)) {
                    MessageHelper.showError(LoginForm.this, "Username sudah digunakan oleh akun lain!");
                    return;
                }

                User newUser = new User();
                newUser.setNama(nama);
                newUser.setUsername(username);
                newUser.setPassword(password);

                if (userDAO.register(newUser)) {
                    MessageHelper.showInfo(LoginForm.this, "Registrasi sukses! Silakan login.");
                    
                    namaField.setText("");
                    userField.setText("");
                    passField.setText("");
                    confField.setText("");
                    
                    cardLayout.show(containerPanel, "LOGIN");
                } else {
                    MessageHelper.showError(LoginForm.this, "Registrasi gagal, coba lagi nanti.");
                }
            }
        });

        btnGoLogin.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                cardLayout.show(containerPanel, "LOGIN");
            }
        });

        panel.add(formArea, BorderLayout.CENTER);
        return panel;
    }
}
