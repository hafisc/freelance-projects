package com.lauraprinting.ui;

import com.lauraprinting.model.User;
import com.lauraprinting.ui.panel.*;

import javax.swing.*;
import javax.swing.border.EmptyBorder;
import java.awt.*;

public class MainFrame extends JFrame {
    private final User currentUser;
    
    // Komponen Sidebar (Navigasi Kiri)
    private JPanel sidebarPanel;
    private JLabel lblUserProfile;
    
    // Tombol-tombol Navigasi Sidebar
    private JButton btnDashboard;
    private JButton btnOrder;
    private JButton btnService;
    private JButton btnCustomer;
    private JButton btnReport;
    private JButton btnUser;
    private JButton btnLogout;
    
    // Komponen Navigasi Halaman (Kanan)
    private JPanel contentPanel;
    private CardLayout cardLayout;
    
    // Panel Halaman Aktif
    private DashboardPanel dashboardPanel;
    private OrderPanel orderPanel;
    private ServicePanel servicePanel;
    private CustomerPanel customerPanel;
    private ReportPanel reportPanel;
    private UserPanel userPanel;

    public MainFrame(User currentUser) {
        this.currentUser = currentUser;
        initComponents();
    }

    private void initComponents() {
        setTitle("Laura Printing - Sistem CRUD & POS Percetakan");
        setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        setSize(1150, 720);
        setMinimumSize(new Dimension(1000, 650));
        setLocationRelativeTo(null);

        // Layout utama frame shell
        JPanel shellPanel = new JPanel(new BorderLayout());
        setContentPane(shellPanel);

        // 1. Panel Sidebar (Bagian Kiri - Premium Dark Theme)
        sidebarPanel = new JPanel();
        sidebarPanel.setLayout(new BoxLayout(sidebarPanel, BoxLayout.Y_AXIS));
        sidebarPanel.setBackground(new Color(15, 23, 42)); // Slate 900 (Lebih gelap & premium)
        sidebarPanel.setPreferredSize(new Dimension(245, 0));
        sidebarPanel.setBorder(new EmptyBorder(25, 18, 25, 18));

        // Logo & Identitas Brand Toko
        JLabel lblLogo = new JLabel("LAURA PRINTING");
        lblLogo.setFont(new Font("Segoe UI", Font.BOLD, 18));
        lblLogo.setForeground(Color.WHITE);
        lblLogo.setAlignmentX(Component.CENTER_ALIGNMENT);
        
        JLabel lblTagline = new JLabel("Sistem Kasir & CRUD");
        lblTagline.setFont(new Font("Segoe UI", Font.PLAIN, 11));
        lblTagline.setForeground(new Color(148, 163, 184)); // Slate 400
        lblTagline.setAlignmentX(Component.CENTER_ALIGNMENT);

        // Pembatas Visual 1
        JSeparator divider1 = new JSeparator();
        divider1.setMaximumSize(new Dimension(Integer.MAX_VALUE, 1));
        divider1.setForeground(new Color(30, 41, 59)); // Slate 800
        divider1.setBackground(new Color(30, 41, 59));

        // Informasi Pengguna Aktif (Profil Kasir/Admin)
        JPanel profileBox = new JPanel();
        profileBox.setLayout(new BoxLayout(profileBox, BoxLayout.Y_AXIS));
        profileBox.setOpaque(false);
        profileBox.setAlignmentX(Component.CENTER_ALIGNMENT);
        profileBox.setBorder(new EmptyBorder(10, 0, 10, 0));

        lblUserProfile = new JLabel(currentUser.getName());
        lblUserProfile.setFont(new Font("Segoe UI", Font.BOLD, 13));
        lblUserProfile.setForeground(Color.WHITE);
        lblUserProfile.setAlignmentX(Component.CENTER_ALIGNMENT);

        JLabel lblRole = new JLabel(currentUser.getRole().toUpperCase());
        lblRole.setFont(new Font("Segoe UI", Font.BOLD, 10));
        lblRole.setForeground(new Color(56, 189, 248)); // Sky Blue 400
        lblRole.setAlignmentX(Component.CENTER_ALIGNMENT);
        
        profileBox.add(lblUserProfile);
        profileBox.add(Box.createVerticalStrut(2));
        profileBox.add(lblRole);

        // Pembatas Visual 2
        JSeparator divider2 = new JSeparator();
        divider2.setMaximumSize(new Dimension(Integer.MAX_VALUE, 1));
        divider2.setForeground(new Color(30, 41, 59));
        divider2.setBackground(new Color(30, 41, 59));

        // Inisialisasi Tombol Navigasi Sidebar
        btnDashboard = createSidebarButton("Dashboard Utama", "dashboard");
        btnOrder = createSidebarButton("Transaksi Baru (POS)", "order");
        btnService = createSidebarButton("Kelola Layanan Cetak", "service");
        btnCustomer = createSidebarButton("Kelola Pelanggan", "customer");
        btnReport = createSidebarButton("Laporan Penjualan", "report");
        btnUser = createSidebarButton("Kelola Karyawan", "user");
        btnLogout = createSidebarButton("Keluar Sistem", "logout");

        // Batasan Akses: Sembunyikan menu kelola karyawan untuk Kasir
        if (!currentUser.getRole().equalsIgnoreCase("Admin")) {
            btnUser.setVisible(false);
        }

        // Menyusun Komponen ke dalam Sidebar
        sidebarPanel.add(lblLogo);
        sidebarPanel.add(Box.createVerticalStrut(3));
        sidebarPanel.add(lblTagline);
        sidebarPanel.add(Box.createVerticalStrut(15));
        sidebarPanel.add(divider1);
        sidebarPanel.add(Box.createVerticalStrut(10));
        sidebarPanel.add(profileBox);
        sidebarPanel.add(Box.createVerticalStrut(10));
        sidebarPanel.add(divider2);
        sidebarPanel.add(Box.createVerticalStrut(20));

        sidebarPanel.add(btnDashboard);
        sidebarPanel.add(Box.createVerticalStrut(8));
        sidebarPanel.add(btnOrder);
        sidebarPanel.add(Box.createVerticalStrut(8));
        sidebarPanel.add(btnService);
        sidebarPanel.add(Box.createVerticalStrut(8));
        sidebarPanel.add(btnCustomer);
        sidebarPanel.add(Box.createVerticalStrut(8));
        sidebarPanel.add(btnReport);
        sidebarPanel.add(Box.createVerticalStrut(8));
        sidebarPanel.add(btnUser);
        
        sidebarPanel.add(Box.createVerticalGlue());
        sidebarPanel.add(btnLogout);

        shellPanel.add(sidebarPanel, BorderLayout.WEST);

        // 2. Panel Konten Utama (Bagian Kanan dengan CardLayout)
        cardLayout = new CardLayout();
        contentPanel = new JPanel(cardLayout);
        contentPanel.setBackground(new Color(248, 250, 252));

        // Inisialisasi Panel Halaman
        dashboardPanel = new DashboardPanel();
        orderPanel = new OrderPanel();
        servicePanel = new ServicePanel();
        customerPanel = new CustomerPanel();
        reportPanel = new ReportPanel(currentUser);
        userPanel = new UserPanel(currentUser);

        // Mendaftarkan panel ke wadah CardLayout
        contentPanel.add(dashboardPanel, "dashboard");
        contentPanel.add(orderPanel, "order");
        contentPanel.add(servicePanel, "service");
        contentPanel.add(customerPanel, "customer");
        contentPanel.add(reportPanel, "report");
        contentPanel.add(userPanel, "user");

        shellPanel.add(contentPanel, BorderLayout.CENTER);

        // Tampilkan halaman default pertama kali
        showPanel("dashboard");
    }

    // Fungsi pembantu untuk membuat tombol navigasi bergaya pill tab modern
    private JButton createSidebarButton(String text, String cardName) {
        JButton btn = new JButton(text);
        btn.setFont(new Font("Segoe UI", Font.BOLD, 12));
        btn.setForeground(new Color(148, 163, 184)); // Slate 400 (Warna teks pasif)
        btn.setBackground(new Color(15, 23, 42));    // Latar belakang pasif
        btn.setBorderPainted(false);
        btn.setFocusPainted(false);
        btn.setContentAreaFilled(false); // Mengaktifkan area transparan agar hover/highlight bekerja
        btn.setOpaque(false);
        btn.setCursor(new Cursor(Cursor.HAND_CURSOR));
        btn.setAlignmentX(Component.CENTER_ALIGNMENT);
        btn.setMaximumSize(new Dimension(Integer.MAX_VALUE, 40));
        btn.setHorizontalAlignment(SwingConstants.LEFT);
        btn.setBorder(new EmptyBorder(10, 18, 10, 18));
        btn.putClientProperty("JComponent.roundRect", true); // Membuat tombol bertipe pill rounded
 
        // Efek Hover (Sorot Kursor)
        btn.addMouseListener(new java.awt.event.MouseAdapter() {
            public void mouseEntered(java.awt.event.MouseEvent evt) {
                // Hanya aktifkan efek hover jika tombol tidak sedang aktif/terpilih
                if (btn.isEnabled() && !btn.getBackground().equals(new Color(79, 70, 229))) {
                    btn.setOpaque(true);
                    btn.setContentAreaFilled(true);
                    btn.setBackground(new Color(30, 41, 59)); // Slate 800 (Hover)
                    btn.setForeground(Color.WHITE);
                }
            }
 
            public void mouseExited(java.awt.event.MouseEvent evt) {
                // Kembalikan ke visual normal jika tidak terpilih
                if (btn.isEnabled() && !btn.getBackground().equals(new Color(79, 70, 229))) {
                    btn.setOpaque(false);
                    btn.setContentAreaFilled(false);
                    btn.setBackground(new Color(15, 23, 42));
                    btn.setForeground(new Color(148, 163, 184));
                }
            }
        });
 
        // Aksi klik navigasi
        btn.addActionListener(e -> {
            if (cardName.equalsIgnoreCase("logout")) {
                handleLogout();
            } else {
                showPanel(cardName);
            }
        });
 
        return btn;
    }

    // Membuka panel dan memperbarui highlight tab navigasi
    private void showPanel(String cardName) {
        if (cardName.equalsIgnoreCase("dashboard")) {
            dashboardPanel.refreshData();
        } else if (cardName.equalsIgnoreCase("order")) {
            orderPanel.loadFormData();
        }
        
        cardLayout.show(contentPanel, cardName);
        highlightActiveButton(cardName);
    }

    // Mewarnai tab terpilih dengan warna Indigo solid dan menonaktifkan tombol lainnya
    private void highlightActiveButton(String cardName) {
        JButton[] buttons = {btnDashboard, btnOrder, btnService, btnCustomer, btnReport, btnUser};
        String[] cards = {"dashboard", "order", "service", "customer", "report", "user"};
        
        for (int i = 0; i < buttons.length; i++) {
            JButton btn = buttons[i];
            if (btn == null) continue;
            
            if (cards[i].equalsIgnoreCase(cardName)) {
                btn.setOpaque(true);
                btn.setContentAreaFilled(true);
                btn.setBackground(new Color(79, 70, 229)); // Indigo 600 (Warna aktif)
                btn.setForeground(Color.WHITE);
            } else {
                btn.setOpaque(false);
                btn.setContentAreaFilled(false);
                btn.setBackground(new Color(15, 23, 42));   // Slate 900 (Warna pasif)
                btn.setForeground(new Color(148, 163, 184)); // Slate 400
            }
        }
    }

    private void handleLogout() {
        int confirm = JOptionPane.showConfirmDialog(this, 
                "Apakah Anda yakin ingin keluar dari sistem?", 
                "Konfirmasi Logout", 
                JOptionPane.YES_NO_OPTION);
        
        if (confirm == JOptionPane.YES_OPTION) {
            SwingUtilities.invokeLater(() -> {
                new LoginFrame().setVisible(true);
            });
            this.dispose();
        }
    }
}
