package parkingmall.view.petugas;

import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import javax.swing.*;
import javax.swing.border.EmptyBorder;
import parkingmall.config.DatabaseConnection;
import parkingmall.helper.MessageHelper;
import parkingmall.helper.UIHelper;
import parkingmall.model.User;
import parkingmall.view.LoginForm;
import parkingmall.view.WelcomeBanner;
import parkingmall.view.LiveFooterPanel;

public class PetugasDashboard extends JFrame {
    private final User currentUser;
    private final Connection conn;

    private final CardLayout cardLayout;
    private final JPanel mainContentPanel;

    // Stat Label references
    private JLabel lblMasukVal;
    private JLabel lblKeluarVal;
    private JLabel lblBookingVal;
    private JLabel lblTersediaVal;

    private LiveFooterPanel footerPanel;

    // Sub-panels
    private KendaraanMasukForm masukPanel;
    private KendaraanKeluarForm keluarPanel;
    private VerifikasiBookingForm verifikasiPanel;
    private SlotTersediaForm tersediaPanel;

    public PetugasDashboard(User user) {
        this.currentUser = user;
        this.conn = DatabaseConnection.getConnection();

        setTitle("Parking Mall - Petugas Dashboard (" + user.getNama() + ")");
        setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        setSize(1024, 700);
        setLocationRelativeTo(null);

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
        JButton btnMasuk = new JButton("📥 Kendaraan Masuk");
        JButton btnKeluar = new JButton("📤 Kendaraan Keluar");
        JButton btnVerify = new JButton("✔ Verifikasi Booking");
        JButton btnSlot = new JButton("🅿 Slot Tersedia");

        // Style buttons
        UIHelper.styleButton(btnDash, Color.WHITE, Color.decode("#0F2742"), 220, 40);
        UIHelper.styleButton(btnMasuk, Color.WHITE, Color.decode("#0F2742"), 220, 40);
        UIHelper.styleButton(btnKeluar, Color.WHITE, Color.decode("#0F2742"), 220, 40);
        UIHelper.styleButton(btnVerify, Color.WHITE, Color.decode("#0F2742"), 220, 40);
        UIHelper.styleButton(btnSlot, Color.WHITE, Color.decode("#0F2742"), 220, 40);

        btnDash.setAlignmentX(Component.CENTER_ALIGNMENT);
        btnMasuk.setAlignmentX(Component.CENTER_ALIGNMENT);
        btnKeluar.setAlignmentX(Component.CENTER_ALIGNMENT);
        btnVerify.setAlignmentX(Component.CENTER_ALIGNMENT);
        btnSlot.setAlignmentX(Component.CENTER_ALIGNMENT);

        // Logout Button
        JButton btnLogout = new JButton("🚪 Logout");
        UIHelper.styleButton(btnLogout, Color.decode("#C62828"), Color.WHITE, 220, 40);
        btnLogout.setAlignmentX(Component.CENTER_ALIGNMENT);

        sidebar.add(btnDash);
        sidebar.add(Box.createRigidArea(new Dimension(0, 10)));
        sidebar.add(btnMasuk);
        sidebar.add(Box.createRigidArea(new Dimension(0, 10)));
        sidebar.add(btnKeluar);
        sidebar.add(Box.createRigidArea(new Dimension(0, 10)));
        sidebar.add(btnVerify);
        sidebar.add(Box.createRigidArea(new Dimension(0, 10)));
        sidebar.add(btnSlot);
        sidebar.add(Box.createGlue());
        sidebar.add(btnLogout);

        add(sidebar, BorderLayout.WEST);

        // MAIN CONTENT
        cardLayout = new CardLayout();
        mainContentPanel = new JPanel(cardLayout);
        mainContentPanel.setBackground(Color.decode("#85C1E9")); // Sky Blue background

        // Overview Panel
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

        btnMasuk.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                if (masukPanel == null) {
                    masukPanel = new KendaraanMasukForm();
                    mainContentPanel.add(masukPanel, "MASUK");
                }
                cardLayout.show(mainContentPanel, "MASUK");
            }
        });

        btnKeluar.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                if (keluarPanel == null) {
                    keluarPanel = new KendaraanKeluarForm();
                    mainContentPanel.add(keluarPanel, "KELUAR");
                }
                cardLayout.show(mainContentPanel, "KELUAR");
            }
        });

        btnVerify.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                if (verifikasiPanel == null) {
                    verifikasiPanel = new VerifikasiBookingForm();
                    mainContentPanel.add(verifikasiPanel, "VERIFY");
                }
                cardLayout.show(mainContentPanel, "VERIFY");
            }
        });

        btnSlot.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                if (tersediaPanel == null) {
                    tersediaPanel = new SlotTersediaForm();
                    mainContentPanel.add(tersediaPanel, "SLOT");
                }
                cardLayout.show(mainContentPanel, "SLOT");
            }
        });

        btnLogout.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                boolean konfirmasi = MessageHelper.showConfirm(PetugasDashboard.this, "Apakah Anda yakin ingin keluar?");
                if (konfirmasi) {
                    if (footerPanel != null) {
                        footerPanel.stopTimer();
                    }
                    PetugasDashboard.this.dispose();
                    new LoginForm().setVisible(true);
                }
            }
        });

        // Load stats
        refreshStats();
    }

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

        JButton btnProfile = new JButton("Petugas");
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

        JPanel cardMasuk = createStatCard("📥", "KENDARAAN MASUK", "0", "Kendaraan", Color.decode("#0F2742"));
        lblMasukVal = (JLabel) cardMasuk.getClientProperty("valueLabel");

        JPanel cardKeluar = createStatCard("📤", "KENDARAAN KELUAR", "0", "Kendaraan", Color.decode("#0F2742"));
        lblKeluarVal = (JLabel) cardKeluar.getClientProperty("valueLabel");

        JPanel cardBooking = createStatCard("📋", "BOOKING MENUNGGU", "0", "Booking", Color.decode("#0F2742"));
        lblBookingVal = (JLabel) cardBooking.getClientProperty("valueLabel");

        JPanel cardTersedia = createStatCard("🅿", "SLOT TERSEDIA", "0", "Slot", Color.decode("#0F2742"));
        lblTersediaVal = (JLabel) cardTersedia.getClientProperty("valueLabel");

        cardsGrid.add(cardMasuk);
        cardsGrid.add(cardKeluar);
        cardsGrid.add(cardBooking);
        cardsGrid.add(cardTersedia);

        centerPanel.add(cardsGrid, BorderLayout.CENTER);
        panel.add(centerPanel, BorderLayout.CENTER);

        // 3. Bagian Bawah: LiveFooterPanel
        footerPanel = new LiveFooterPanel();
        panel.add(footerPanel, BorderLayout.SOUTH);

        return panel;
    }

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

    // Fungsi ini digunakan untuk memperbarui data ringkasan dashboard petugas langsung dari query database
    private void refreshStats() {
        int masuk = 0;
        int keluar = 0;
        int booking = 0;
        int tersedia = 0;

        try {
            // 1. Kendaraan masuk hari ini
            String sqlMasuk = "SELECT COUNT(*) FROM kendaraan WHERE DATE(waktu_masuk) = CURDATE()";
            try (PreparedStatement ps = conn.prepareStatement(sqlMasuk);
                 ResultSet rs = ps.executeQuery()) {
                if (rs.next()) masuk = rs.getInt(1);
            }

            // 2. Kendaraan keluar hari ini
            String sqlKeluar = "SELECT COUNT(*) FROM kendaraan WHERE DATE(waktu_keluar) = CURDATE() AND status = 'keluar'";
            try (PreparedStatement ps = conn.prepareStatement(sqlKeluar);
                 ResultSet rs = ps.executeQuery()) {
                if (rs.next()) keluar = rs.getInt(1);
            }

            // 3. Booking menunggu verifikasi
            String sqlBooking = "SELECT COUNT(*) FROM booking WHERE status = 'menunggu'";
            try (PreparedStatement ps = conn.prepareStatement(sqlBooking);
                 ResultSet rs = ps.executeQuery()) {
                if (rs.next()) booking = rs.getInt(1);
            }

            // 4. Slot tersedia
            String sqlSlot = "SELECT COUNT(*) FROM slot_parkir WHERE status = 'tersedia'";
            try (PreparedStatement ps = conn.prepareStatement(sqlSlot);
                 ResultSet rs = ps.executeQuery()) {
                if (rs.next()) tersedia = rs.getInt(1);
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }

        lblMasukVal.setText(String.valueOf(masuk));
        lblKeluarVal.setText(String.valueOf(keluar));
        lblBookingVal.setText(String.valueOf(booking));
        lblTersediaVal.setText(String.valueOf(tersedia));
    }

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
