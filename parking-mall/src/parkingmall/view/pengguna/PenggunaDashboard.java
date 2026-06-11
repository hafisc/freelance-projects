package parkingmall.view.pengguna;

import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import javax.swing.*;
import javax.swing.border.EmptyBorder;
import parkingmall.helper.MessageHelper;
import parkingmall.helper.UIHelper;
import parkingmall.model.User;
import parkingmall.view.LoginForm;
import parkingmall.view.WelcomeBanner;
import parkingmall.view.LiveFooterPanel;

public class PenggunaDashboard extends JFrame {
    private final User currentUser;

    private final CardLayout cardLayout;
    private final JPanel mainContentPanel;

    private LiveFooterPanel footerPanel;

    // Sub-panels
    private BookingParkirForm bookingPanel;
    private StatusBookingForm statusPanel;

    public PenggunaDashboard(User user) {
        this.currentUser = user;

        setTitle("Parking Mall - Pengguna Dashboard (" + user.getNama() + ")");
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
        JButton btnBooking = new JButton("📝 Booking Parkir");
        JButton btnStatus = new JButton("🔍 Status Booking");

        // Style buttons
        UIHelper.styleButton(btnDash, Color.WHITE, Color.decode("#0F2742"), 220, 40);
        UIHelper.styleButton(btnBooking, Color.WHITE, Color.decode("#0F2742"), 220, 40);
        UIHelper.styleButton(btnStatus, Color.WHITE, Color.decode("#0F2742"), 220, 40);

        btnDash.setAlignmentX(Component.CENTER_ALIGNMENT);
        btnBooking.setAlignmentX(Component.CENTER_ALIGNMENT);
        btnStatus.setAlignmentX(Component.CENTER_ALIGNMENT);

        // Logout Button
        JButton btnLogout = new JButton("🚪 Logout");
        UIHelper.styleButton(btnLogout, Color.decode("#C62828"), Color.WHITE, 220, 40);
        btnLogout.setAlignmentX(Component.CENTER_ALIGNMENT);

        sidebar.add(btnDash);
        sidebar.add(Box.createRigidArea(new Dimension(0, 10)));
        sidebar.add(btnBooking);
        sidebar.add(Box.createRigidArea(new Dimension(0, 10)));
        sidebar.add(btnStatus);
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
                cardLayout.show(mainContentPanel, "DASHBOARD");
            }
        });

        btnBooking.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                if (bookingPanel == null) {
                    bookingPanel = new BookingParkirForm(currentUser);
                    mainContentPanel.add(bookingPanel, "BOOKING");
                }
                cardLayout.show(mainContentPanel, "BOOKING");
            }
        });

        btnStatus.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                if (statusPanel == null) {
                    statusPanel = new StatusBookingForm(currentUser);
                    mainContentPanel.add(statusPanel, "STATUS");
                } else {
                    // Refresh data booking list
                    statusPanel.tampilkanBooking();
                }
                cardLayout.show(mainContentPanel, "STATUS");
            }
        });

        btnLogout.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                boolean konfirmasi = MessageHelper.showConfirm(PenggunaDashboard.this, "Apakah Anda yakin ingin keluar?");
                if (konfirmasi) {
                    if (footerPanel != null) {
                        footerPanel.stopTimer();
                    }
                    PenggunaDashboard.this.dispose();
                    new LoginForm().setVisible(true);
                }
            }
        });
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

        JButton btnProfile = new JButton("Pengguna");
        UIHelper.styleButton(btnProfile, Color.WHITE, Color.decode("#0F2742"), 90, 28);
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

        // 2. Bagian Tengah: Panduan Booking (Rounded White Card)
        JPanel centerPanel = new JPanel(new BorderLayout(10, 10));
        centerPanel.setOpaque(false);

        JPanel card = new JPanel();
        card.setLayout(new BoxLayout(card, BoxLayout.Y_AXIS));
        card.setBackground(Color.WHITE);
        card.setBorder(BorderFactory.createCompoundBorder(
            BorderFactory.createLineBorder(Color.decode("#E0E0E0"), 1),
            new EmptyBorder(20, 20, 20, 20)
        ));

        JLabel lblGuideTitle = new JLabel("Panduan Booking Slot Parkir:");
        lblGuideTitle.setFont(new Font("Segoe UI", Font.BOLD, 15));
        lblGuideTitle.setForeground(Color.decode("#0F2742"));
        lblGuideTitle.setAlignmentX(Component.LEFT_ALIGNMENT);
        card.add(lblGuideTitle);
        card.add(Box.createRigidArea(new Dimension(0, 10)));

        String[] steps = {
            "1. Masuk ke menu 'Booking Parkir' di menu sebelah kiri.",
            "2. Masukkan plat nomor kendaraan Anda dan jenis kendaraan.",
            "3. Pilih lantai parkir dan pilih slot parkir kosong yang tersedia.",
            "4. Klik tombol 'Booking Sekarang' untuk membuat pesanan.",
            "5. Sistem akan menampilkan kode booking unik Anda.",
            "6. Tunjukkan bukti kode booking kepada petugas di pintu masuk parkir untuk divalidasi.",
            "7. Status booking dapat Anda pantau di menu 'Status Booking'."
        };

        for (String step : steps) {
            JLabel lblStep = new JLabel(step);
            lblStep.setFont(new Font("Segoe UI", Font.PLAIN, 12));
            lblStep.setForeground(Color.decode("#333333"));
            lblStep.setAlignmentX(Component.LEFT_ALIGNMENT);
            card.add(lblStep);
            card.add(Box.createRigidArea(new Dimension(0, 6)));
        }

        card.add(Box.createRigidArea(new Dimension(0, 15)));

        JButton btnStartBooking = new JButton("Mulai Booking Sekarang");
        btnStartBooking.setBackground(Color.decode("#1E88E5"));
        btnStartBooking.setForeground(Color.WHITE);
        btnStartBooking.setFont(new Font("Segoe UI", Font.BOLD, 12));
        btnStartBooking.setMaximumSize(new Dimension(200, 35));
        btnStartBooking.setAlignmentX(Component.LEFT_ALIGNMENT);
        btnStartBooking.setFocusPainted(false);
        btnStartBooking.setCursor(new Cursor(Cursor.HAND_CURSOR));
        
        // Custom button style override for modern look
        btnStartBooking.setBorder(BorderFactory.createCompoundBorder(
            BorderFactory.createLineBorder(Color.decode("#1976D2"), 1),
            BorderFactory.createEmptyBorder(5, 15, 5, 15)
        ));
        
        card.add(btnStartBooking);

        btnStartBooking.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                if (bookingPanel == null) {
                    bookingPanel = new BookingParkirForm(currentUser);
                    mainContentPanel.add(bookingPanel, "BOOKING");
                }
                cardLayout.show(mainContentPanel, "BOOKING");
            }
        });

        centerPanel.add(card, BorderLayout.CENTER);
        panel.add(centerPanel, BorderLayout.CENTER);

        // 3. Bagian Bawah: LiveFooterPanel
        footerPanel = new LiveFooterPanel();
        panel.add(footerPanel, BorderLayout.SOUTH);

        return panel;
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
