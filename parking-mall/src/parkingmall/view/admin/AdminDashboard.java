package parkingmall.view.admin;

import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.text.NumberFormat;
import java.util.Locale;
import java.util.Map;
import javax.swing.*;
import javax.swing.border.EmptyBorder;
import parkingmall.dao.TransaksiDAO;
import parkingmall.helper.MessageHelper;
import parkingmall.helper.UIHelper;
import parkingmall.model.User;
import parkingmall.view.LoginForm;
import parkingmall.view.WelcomeBanner;
import parkingmall.view.LiveFooterPanel;

public class AdminDashboard extends JFrame {
    private final User currentUser;
    private final TransaksiDAO transaksiDAO;

    // Card Layout for main content switching
    private final CardLayout cardLayout;
    private final JPanel mainContentPanel;

    // Overview components to refresh
    private JLabel lblKendaraanHariIniVal;
    private JLabel lblMotorHariIniVal;
    private JLabel lblMobilHariIniVal;
    private JLabel lblPendapatanVal;

    private LiveFooterPanel footerPanel;

    private final NumberFormat rpFormat = NumberFormat.getCurrencyInstance(new Locale("id", "ID"));

    // Sub-panels
    private PetugasForm petugasPanel;
    private LantaiForm lantaiPanel;
    private SlotParkirForm slotPanel;
    private LaporanForm laporanPanel;

    public AdminDashboard(User user) {
        this.currentUser = user;
        this.transaksiDAO = new TransaksiDAO();

        setTitle("Parking Mall - Admin Dashboard (" + user.getNama() + ")");
        setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        setSize(1024, 700);
        setLocationRelativeTo(null);

        // Main layout split into Sidebar (WEST) and Content (CENTER)
        setLayout(new BorderLayout());

        // SIDEBAR
        JPanel sidebar = new JPanel();
        sidebar.setLayout(new BoxLayout(sidebar, BoxLayout.Y_AXIS));
        sidebar.setBackground(Color.decode("#0F2742"));
        sidebar.setPreferredSize(new Dimension(250, 0));
        sidebar.setBorder(new EmptyBorder(20, 15, 20, 15));

        // Sidebar Header: Logo "P" dan Nama Aplikasi
        JPanel headerPanel = new JPanel(new FlowLayout(FlowLayout.LEFT, 10, 0));
        headerPanel.setOpaque(false);
        headerPanel.setMaximumSize(new Dimension(220, 55));
        headerPanel.setAlignmentX(Component.CENTER_ALIGNMENT);

        LogoPanel logo = new LogoPanel();
        headerPanel.add(logo);

        JPanel labelPanel = new JPanel();
        labelPanel.setOpaque(false);
        labelPanel.setLayout(new BoxLayout(labelPanel, BoxLayout.Y_AXIS));

        JLabel lblName = new JLabel("PARKING MALL");
        lblName.setFont(new Font("Segoe UI", Font.BOLD, 16));
        lblName.setForeground(Color.WHITE);

        JLabel lblDesc = new JLabel("Sistem Informasi Parkir");
        lblDesc.setFont(new Font("Segoe UI", Font.PLAIN, 10));
        lblDesc.setForeground(Color.decode("#BFEFFF"));

        labelPanel.add(lblName);
        labelPanel.add(Box.createRigidArea(new Dimension(0, 2)));
        labelPanel.add(lblDesc);

        headerPanel.add(labelPanel);

        sidebar.add(headerPanel);
        sidebar.add(Box.createRigidArea(new Dimension(0, 30)));

        // Navigation Buttons
        JButton btnDash = new JButton("🏠 Dashboard");
        JButton btnPetugas = new JButton("👥 Petugas Parkir");
        JButton btnLantai = new JButton("🏢 Kelola Lantai");
        JButton btnSlot = new JButton("🅿 Slot Parkir");
        JButton btnLaporan = new JButton("📊 Laporan Parkir");
        
        // Style buttons
        UIHelper.styleButton(btnDash, Color.WHITE, Color.decode("#0F2742"), 220, 40);
        UIHelper.styleButton(btnPetugas, Color.WHITE, Color.decode("#0F2742"), 220, 40);
        UIHelper.styleButton(btnLantai, Color.WHITE, Color.decode("#0F2742"), 220, 40);
        UIHelper.styleButton(btnSlot, Color.WHITE, Color.decode("#0F2742"), 220, 40);
        UIHelper.styleButton(btnLaporan, Color.WHITE, Color.decode("#0F2742"), 220, 40);

        // Align components to center for BoxLayout
        btnDash.setAlignmentX(Component.CENTER_ALIGNMENT);
        btnPetugas.setAlignmentX(Component.CENTER_ALIGNMENT);
        btnLantai.setAlignmentX(Component.CENTER_ALIGNMENT);
        btnSlot.setAlignmentX(Component.CENTER_ALIGNMENT);
        btnLaporan.setAlignmentX(Component.CENTER_ALIGNMENT);

        // Logout Button
        JButton btnLogout = new JButton("🚪 Logout");
        UIHelper.styleButton(btnLogout, Color.decode("#C62828"), Color.WHITE, 220, 40);
        btnLogout.setAlignmentX(Component.CENTER_ALIGNMENT);

        sidebar.add(btnDash);
        sidebar.add(Box.createRigidArea(new Dimension(0, 10)));
        sidebar.add(btnPetugas);
        sidebar.add(Box.createRigidArea(new Dimension(0, 10)));
        sidebar.add(btnLantai);
        sidebar.add(Box.createRigidArea(new Dimension(0, 10)));
        sidebar.add(btnSlot);
        sidebar.add(Box.createRigidArea(new Dimension(0, 10)));
        sidebar.add(btnLaporan);
        sidebar.add(Box.createGlue()); // pushes logout to the bottom
        sidebar.add(btnLogout);

        add(sidebar, BorderLayout.WEST);

        // MAIN CONTENT (CARD LAYOUT)
        cardLayout = new CardLayout();
        mainContentPanel = new JPanel(cardLayout);
        mainContentPanel.setBackground(Color.decode("#85C1E9")); // Sky Blue background

        // Create Sub-Panels
        JPanel overviewPanel = createOverviewPanel();
        
        mainContentPanel.add(overviewPanel, "DASHBOARD");

        add(mainContentPanel, BorderLayout.CENTER);

        // Sidebar Navigation actions
        btnDash.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                refreshStats();
                cardLayout.show(mainContentPanel, "DASHBOARD");
            }
        });

        btnPetugas.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                if (petugasPanel == null) {
                    petugasPanel = new PetugasForm();
                    mainContentPanel.add(petugasPanel, "PETUGAS");
                }
                cardLayout.show(mainContentPanel, "PETUGAS");
            }
        });

        btnLantai.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                if (lantaiPanel == null) {
                    lantaiPanel = new LantaiForm();
                    mainContentPanel.add(lantaiPanel, "LANTAI");
                }
                cardLayout.show(mainContentPanel, "LANTAI");
            }
        });

        btnSlot.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                if (slotPanel == null) {
                    slotPanel = new SlotParkirForm();
                    mainContentPanel.add(slotPanel, "SLOT");
                }
                cardLayout.show(mainContentPanel, "SLOT");
            }
        });

        btnLaporan.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                if (laporanPanel == null) {
                    laporanPanel = new LaporanForm();
                    mainContentPanel.add(laporanPanel, "LAPORAN");
                }
                cardLayout.show(mainContentPanel, "LAPORAN");
            }
        });

        btnLogout.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                boolean konfirmasi = MessageHelper.showConfirm(AdminDashboard.this, "Apakah Anda yakin ingin keluar?");
                if (konfirmasi) {
                    if (footerPanel != null) {
                        footerPanel.stopTimer();
                    }
                    AdminDashboard.this.dispose();
                    new LoginForm().setVisible(true);
                }
            }
        });

        // Load awal statistik
        refreshStats();
    }

    // Merancang panel ringkasan/dashboard statistik
    private JPanel createOverviewPanel() {
        JPanel panel = new JPanel(new BorderLayout(15, 15));
        panel.setBackground(Color.decode("#85C1E9"));
        panel.setBorder(new EmptyBorder(15, 20, 15, 20));

        // 1. Bagian Atas: Profile Bar (Top Right) + Welcome Card
        JPanel topPanel = new JPanel();
        topPanel.setOpaque(false);
        topPanel.setLayout(new BoxLayout(topPanel, BoxLayout.Y_AXIS));

        // Profile Bar
        JPanel profileBar = new JPanel(new FlowLayout(FlowLayout.RIGHT, 10, 0));
        profileBar.setOpaque(false);

        JLabel lblAvatar = new JLabel("👤");
        lblAvatar.setFont(new Font("Segoe UI", Font.PLAIN, 18));
        lblAvatar.setForeground(Color.decode("#0F2742"));

        JButton btnProfile = new JButton("Admin");
        UIHelper.styleButton(btnProfile, Color.WHITE, Color.decode("#0F2742"), 80, 28);
        btnProfile.setFont(new Font("Segoe UI", Font.BOLD, 12));

        profileBar.add(lblAvatar);
        profileBar.add(btnProfile);

        topPanel.add(profileBar);
        topPanel.add(Box.createRigidArea(new Dimension(0, 10)));

        // Welcome Banner
        WelcomeBanner welcomeBanner = new WelcomeBanner(currentUser.getNama(), "Di Aplikasi Parking Mall");
        welcomeBanner.setPreferredSize(new Dimension(0, 140));
        topPanel.add(welcomeBanner);

        panel.add(topPanel, BorderLayout.NORTH);

        // 2. Bagian Tengah: Title "Ringkasan Hari Ini" + Grid Cards
        JPanel centerPanel = new JPanel(new BorderLayout(10, 10));
        centerPanel.setOpaque(false);

        JLabel lblRingkasanTitle = new JLabel("Ringkasan Hari Ini");
        lblRingkasanTitle.setFont(new Font("Segoe UI", Font.BOLD, 15));
        lblRingkasanTitle.setForeground(Color.decode("#0F2742"));
        centerPanel.add(lblRingkasanTitle, BorderLayout.NORTH);

        // 4 Cards Side by Side
        JPanel cardsGrid = new JPanel(new GridLayout(1, 4, 15, 0));
        cardsGrid.setOpaque(false);

        // Create Card Elements
        JPanel cardKendaraan = createStatCard("🚗", "KENDARAAN HARI INI", "0", "Kendaraan", Color.decode("#0F2742"));
        lblKendaraanHariIniVal = (JLabel) cardKendaraan.getClientProperty("valueLabel");

        JPanel cardMotor = createStatCard("🏍", "MOTOR", "0", "Kendaraan", Color.decode("#0F2742"));
        lblMotorHariIniVal = (JLabel) cardMotor.getClientProperty("valueLabel");

        JPanel cardMobil = createStatCard("🚗", "MOBIL", "0", "Kendaraan", Color.decode("#0F2742"));
        lblMobilHariIniVal = (JLabel) cardMobil.getClientProperty("valueLabel");

        JPanel cardPendapatan = createStatCard("💳", "PENDAPATAN HARI INI", "Rp 0", "Rupiah", Color.decode("#0F2742"));
        lblPendapatanVal = (JLabel) cardPendapatan.getClientProperty("valueLabel");

        cardsGrid.add(cardKendaraan);
        cardsGrid.add(cardMotor);
        cardsGrid.add(cardMobil);
        cardsGrid.add(cardPendapatan);

        centerPanel.add(cardsGrid, BorderLayout.CENTER);
        panel.add(centerPanel, BorderLayout.CENTER);

        // 3. Bagian Bawah: LiveFooterPanel (INFORMASI + Waktu/Tanggal Live)
        footerPanel = new LiveFooterPanel();
        panel.add(footerPanel, BorderLayout.SOUTH);

        return panel;
    }

    // Helper untuk membuat panel kartu statistik (Card) sesuai dengan desain referensi
    private JPanel createStatCard(String iconStr, String title, String val, String unit, Color textColor) {
        JPanel card = new JPanel();
        card.setLayout(new BoxLayout(card, BoxLayout.Y_AXIS));
        card.setBackground(Color.WHITE);
        card.setBorder(BorderFactory.createCompoundBorder(
            BorderFactory.createLineBorder(Color.decode("#E0E0E0"), 1),
            new EmptyBorder(15, 10, 15, 10)
        ));

        // Icon
        JLabel lblIcon = new JLabel(iconStr);
        lblIcon.setFont(new Font("Segoe UI", Font.PLAIN, 28));
        lblIcon.setAlignmentX(Component.CENTER_ALIGNMENT);

        // Title
        JLabel lblTitle = new JLabel(title);
        lblTitle.setFont(new Font("Segoe UI", Font.BOLD, 10));
        lblTitle.setForeground(Color.decode("#0F2742"));
        lblTitle.setAlignmentX(Component.CENTER_ALIGNMENT);

        // Value
        JLabel lblVal = new JLabel(val);
        lblVal.setFont(new Font("Segoe UI", Font.BOLD, 18));
        lblVal.setForeground(textColor);
        lblVal.setAlignmentX(Component.CENTER_ALIGNMENT);

        // Unit
        JLabel lblUnit = new JLabel(unit);
        lblUnit.setFont(new Font("Segoe UI", Font.PLAIN, 10));
        lblUnit.setForeground(Color.GRAY);
        lblUnit.setAlignmentX(Component.CENTER_ALIGNMENT);

        card.add(lblIcon);
        card.add(Box.createRigidArea(new Dimension(0, 8)));
        card.add(lblTitle);
        card.add(Box.createRigidArea(new Dimension(0, 15)));
        card.add(lblVal);
        card.add(Box.createRigidArea(new Dimension(0, 4)));
        card.add(lblUnit);

        // Simpan referensi ke label value agar bisa direfresh
        card.putClientProperty("valueLabel", lblVal);

        return card;
    }

    // Fungsi ini digunakan untuk memperbarui data statistik dashboard secara realtime
    private void refreshStats() {
        Map<String, Integer> stats = transaksiDAO.getStatistikDashboard();
        
        lblKendaraanHariIniVal.setText(String.valueOf(stats.getOrDefault("kendaraan_hari_ini", 0)));
        lblMotorHariIniVal.setText(String.valueOf(stats.getOrDefault("motor_hari_ini", 0)));
        lblMobilHariIniVal.setText(String.valueOf(stats.getOrDefault("mobil_hari_ini", 0)));
        
        int pendapatan = stats.get("pendapatan_hari_ini") != null ? stats.get("pendapatan_hari_ini") : 0;
        lblPendapatanVal.setText(rpFormat.format(pendapatan));
    }

    // Canvas Kustom Logo "P" Bulat
    private static class LogoPanel extends JPanel {
        public LogoPanel() {
            setPreferredSize(new Dimension(46, 46));
            setMinimumSize(new Dimension(46, 46));
            setMaximumSize(new Dimension(46, 46));
            setOpaque(false);
        }

        @Override
        protected void paintComponent(Graphics g) {
            super.paintComponent(g);
            Graphics2D g2 = (Graphics2D) g.create();
            g2.setRenderingHint(RenderingHints.KEY_ANTIALIASING, RenderingHints.VALUE_ANTIALIAS_ON);
            
            // Draw background rounded square
            g2.setColor(Color.decode("#0F2742"));
            g2.fillRoundRect(2, 2, 42, 42, 8, 8);
            
            // Draw white border
            g2.setColor(Color.WHITE);
            g2.setStroke(new BasicStroke(2));
            g2.drawRoundRect(2, 2, 42, 42, 8, 8);
            
            // Draw white letter "P"
            g2.setFont(new Font("Segoe UI", Font.BOLD, 26));
            FontMetrics fm = g2.getFontMetrics();
            int x = (46 - fm.stringWidth("P")) / 2;
            int y = ((46 - fm.getHeight()) / 2) + fm.getAscent();
            g2.drawString("P", x, y);
            
            g2.dispose();
        }
    }
}
