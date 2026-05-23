package parkingmall.view.pengguna;

import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;
import javax.swing.*;
import javax.swing.border.EmptyBorder;
import javax.swing.border.TitledBorder;
import parkingmall.dao.BookingDAO;
import parkingmall.dao.LantaiDAO;
import parkingmall.dao.SlotParkirDAO;
import parkingmall.helper.KodeGenerator;
import parkingmall.helper.MessageHelper;
import parkingmall.model.Booking;
import parkingmall.model.Lantai;
import parkingmall.model.SlotParkir;
import parkingmall.model.User;

public class BookingParkirForm extends JPanel {
    private final User currentUser;
    private final LantaiDAO lantaiDAO;
    private final SlotParkirDAO slotDAO;
    private final BookingDAO bookingDAO;
    
    private final JTextField txtPlat;
    private final JComboBox<String> cbJenis;
    private final JLabel lblSelectedSlotInfo;
    
    private final JButton btnBooking;
    private final JButton btnReset;
    
    private final JPanel pnlFloorTabs;
    private final JPanel pnlMapContainer;
    
    private int selectedLantaiId;
    private SlotParkir selectedSlot;
    private List<Lantai> lantaiList;

    public BookingParkirForm(User user) {
        this.currentUser = user;
        this.lantaiDAO = new LantaiDAO();
        this.slotDAO = new SlotParkirDAO();
        this.bookingDAO = new BookingDAO();
        this.selectedLantaiId = -1;
        this.selectedSlot = null;
        
        // Auto-seed slots if database has few records for testing
        autoSeedDatabase();
        
        setLayout(new BorderLayout(15, 15));
        setBackground(Color.decode("#85C1E9"));
        setBorder(new EmptyBorder(20, 20, 20, 20));

        // TITLE
        JLabel lblTitle = new JLabel("Form Booking Slot Parkir");
        lblTitle.setFont(new Font("Segoe UI", Font.BOLD, 22));
        lblTitle.setForeground(Color.decode("#0F2742"));
        add(lblTitle, BorderLayout.NORTH);

        // SPLIT CONTENT PANEL (CENTER)
        JPanel contentPanel = new JPanel(new BorderLayout(15, 15));
        contentPanel.setOpaque(false);

        // LEFT PANEL: Info & Inputs
        JPanel leftPanel = new JPanel();
        leftPanel.setLayout(new BoxLayout(leftPanel, BoxLayout.Y_AXIS));
        leftPanel.setBackground(Color.WHITE);
        leftPanel.setBorder(BorderFactory.createCompoundBorder(
            BorderFactory.createLineBorder(Color.LIGHT_GRAY),
            new EmptyBorder(20, 20, 20, 20)
        ));
        leftPanel.setPreferredSize(new Dimension(300, 0));

        // User info
        JLabel lblUserHeader = new JLabel("INFORMASI PENGGUNA");
        lblUserHeader.setFont(new Font("Segoe UI", Font.BOLD, 11));
        lblUserHeader.setForeground(Color.GRAY);
        lblUserHeader.setAlignmentX(Component.LEFT_ALIGNMENT);
        leftPanel.add(lblUserHeader);
        leftPanel.add(Box.createRigidArea(new Dimension(0, 3)));
        
        JLabel lblUserVal = new JLabel(currentUser.getNama());
        lblUserVal.setFont(new Font("Segoe UI", Font.BOLD, 15));
        lblUserVal.setForeground(Color.decode("#0F2742"));
        lblUserVal.setAlignmentX(Component.LEFT_ALIGNMENT);
        leftPanel.add(lblUserVal);
        leftPanel.add(Box.createRigidArea(new Dimension(0, 15)));

        // Vehicle Plat Input
        JLabel lblPlat = new JLabel("Plat Nomor Kendaraan:");
        lblPlat.setFont(new Font("Segoe UI", Font.BOLD, 12));
        lblPlat.setForeground(Color.decode("#333333"));
        lblPlat.setAlignmentX(Component.LEFT_ALIGNMENT);
        leftPanel.add(lblPlat);
        leftPanel.add(Box.createRigidArea(new Dimension(0, 5)));
        
        txtPlat = new JTextField();
        txtPlat.setFont(new Font("Segoe UI", Font.BOLD, 14));
        txtPlat.setMaximumSize(new Dimension(300, 35));
        txtPlat.setPreferredSize(new Dimension(300, 35));
        txtPlat.setAlignmentX(Component.LEFT_ALIGNMENT);
        leftPanel.add(txtPlat);
        leftPanel.add(Box.createRigidArea(new Dimension(0, 15)));

        // Vehicle Type Select
        JLabel lblJenis = new JLabel("Jenis Kendaraan:");
        lblJenis.setFont(new Font("Segoe UI", Font.BOLD, 12));
        lblJenis.setForeground(Color.decode("#333333"));
        lblJenis.setAlignmentX(Component.LEFT_ALIGNMENT);
        leftPanel.add(lblJenis);
        leftPanel.add(Box.createRigidArea(new Dimension(0, 5)));
        
        cbJenis = new JComboBox<>(new String[]{"Mobil", "Motor"});
        cbJenis.setFont(new Font("Segoe UI", Font.PLAIN, 13));
        cbJenis.setMaximumSize(new Dimension(300, 35));
        cbJenis.setPreferredSize(new Dimension(300, 35));
        cbJenis.setAlignmentX(Component.LEFT_ALIGNMENT);
        leftPanel.add(cbJenis);
        leftPanel.add(Box.createRigidArea(new Dimension(0, 15)));

        // Selected Slot Panel
        JLabel lblSelectedHeader = new JLabel("Slot Parkir Dipilih:");
        lblSelectedHeader.setFont(new Font("Segoe UI", Font.BOLD, 12));
        lblSelectedHeader.setForeground(Color.decode("#333333"));
        lblSelectedHeader.setAlignmentX(Component.LEFT_ALIGNMENT);
        leftPanel.add(lblSelectedHeader);
        leftPanel.add(Box.createRigidArea(new Dimension(0, 5)));
        
        JPanel pnlSelectedDisplay = new JPanel(new GridBagLayout());
        pnlSelectedDisplay.setBackground(Color.decode("#F2F4F4"));
        pnlSelectedDisplay.setBorder(BorderFactory.createLineBorder(Color.decode("#BDC3C7"), 1));
        pnlSelectedDisplay.setMaximumSize(new Dimension(300, 45));
        pnlSelectedDisplay.setPreferredSize(new Dimension(300, 45));
        pnlSelectedDisplay.setAlignmentX(Component.LEFT_ALIGNMENT);
        
        lblSelectedSlotInfo = new JLabel("Belum Memilih Slot");
        lblSelectedSlotInfo.setFont(new Font("Segoe UI", Font.BOLD, 14));
        lblSelectedSlotInfo.setForeground(Color.GRAY);
        pnlSelectedDisplay.add(lblSelectedSlotInfo);
        
        leftPanel.add(pnlSelectedDisplay);
        leftPanel.add(Box.createRigidArea(new Dimension(0, 20)));

        // Legend Title
        JLabel lblLegendHeader = new JLabel("Keterangan Warna Slot:");
        lblLegendHeader.setFont(new Font("Segoe UI", Font.BOLD, 11));
        lblLegendHeader.setForeground(Color.GRAY);
        lblLegendHeader.setAlignmentX(Component.LEFT_ALIGNMENT);
        leftPanel.add(lblLegendHeader);
        leftPanel.add(Box.createRigidArea(new Dimension(0, 8)));

        // Legend 1: Available
        JPanel legAvailable = createLegendRow(Color.decode("#2ECC71"), "Slot Tersedia (Kosong)");
        leftPanel.add(legAvailable);
        leftPanel.add(Box.createRigidArea(new Dimension(0, 8)));

        // Legend 2: Occupied
        JPanel legOccupied = createLegendRow(Color.decode("#EF5350"), "Slot Terisi / Booking");
        leftPanel.add(legOccupied);
        leftPanel.add(Box.createRigidArea(new Dimension(0, 8)));

        // Legend 3: Selected
        JPanel legSelected = createLegendRow(Color.decode("#FFCA28"), "Pilihan Anda");
        leftPanel.add(legSelected);
        leftPanel.add(Box.createRigidArea(new Dimension(0, 25)));

        // Action Buttons
        JPanel actionPanel = new JPanel(new GridLayout(1, 2, 10, 0));
        actionPanel.setBackground(Color.WHITE);
        actionPanel.setMaximumSize(new Dimension(300, 38));
        actionPanel.setAlignmentX(Component.LEFT_ALIGNMENT);

        btnBooking = new JButton("Booking");
        parkingmall.helper.UIHelper.styleButton(btnBooking, Color.decode("#1E88E5"), Color.WHITE);
        btnBooking.setEnabled(false);

        btnReset = new JButton("Reset");
        parkingmall.helper.UIHelper.styleButton(btnReset, Color.GRAY, Color.WHITE);

        actionPanel.add(btnBooking);
        actionPanel.add(btnReset);
        leftPanel.add(actionPanel);

        contentPanel.add(leftPanel, BorderLayout.WEST);

        // RIGHT PANEL: Floor Map Area
        JPanel rightPanel = new JPanel(new BorderLayout(10, 10));
        rightPanel.setOpaque(false);

        // Dynamic Floor selection tabs
        pnlFloorTabs = new JPanel(new FlowLayout(FlowLayout.LEFT, 10, 0));
        pnlFloorTabs.setOpaque(false);
        rightPanel.add(pnlFloorTabs, BorderLayout.NORTH);

        // Map container
        pnlMapContainer = new JPanel(new BorderLayout(10, 10));
        pnlMapContainer.setBackground(Color.WHITE);
        pnlMapContainer.setBorder(BorderFactory.createCompoundBorder(
            BorderFactory.createLineBorder(Color.LIGHT_GRAY),
            new EmptyBorder(15, 15, 15, 15)
        ));
        rightPanel.add(pnlMapContainer, BorderLayout.CENTER);

        contentPanel.add(rightPanel, BorderLayout.CENTER);
        add(contentPanel, BorderLayout.CENTER);

        // Events
        cbJenis.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                selectedSlot = null;
                lblSelectedSlotInfo.setText("Belum Memilih Slot");
                lblSelectedSlotInfo.setForeground(Color.GRAY);
                btnBooking.setEnabled(false);
                loadFloorMap();
            }
        });

        btnBooking.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                prosesBooking();
            }
        });

        btnReset.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                resetForm();
            }
        });

        // Initialize lists
        loadFloorTabs();
        loadFloorMap();
    }

    private void autoSeedDatabase() {
        try {
            List<SlotParkir> allSlots = slotDAO.getAllSlot();
            // Seed if slot count is less than 30 (representing empty/default database)
            if (allSlots.size() < 30) {
                System.out.println("Seeding database with realistic number of slots...");
                List<Lantai> lantais = lantaiDAO.getAllLantai();
                for (Lantai l : lantais) {
                    int idLantai = l.getIdLantai();
                    char floorChar = (idLantai == 1) ? 'A' : (idLantai == 2 ? 'B' : 'C');
                    char motorChar = (idLantai == 1) ? 'S' : (idLantai == 2 ? 'M' : 'T');
                    
                    // Seed 10 Mobil slots: e.g. A01 to A10
                    for (int i = 1; i <= 10; i++) {
                        String kode = String.format("%c%02d", floorChar, i);
                        if (!slotDAO.isKodeSlotExists(idLantai, kode)) {
                            SlotParkir s = new SlotParkir();
                            s.setIdLantai(idLantai);
                            s.setKodeSlot(kode);
                            s.setStatus("tersedia");
                            slotDAO.insertSlot(s);
                        }
                    }
                    // Seed 10 Motor slots: e.g. S01 to S10
                    for (int i = 1; i <= 10; i++) {
                        String kode = String.format("%c%02d", motorChar, i);
                        if (!slotDAO.isKodeSlotExists(idLantai, kode)) {
                            SlotParkir s = new SlotParkir();
                            s.setIdLantai(idLantai);
                            s.setKodeSlot(kode);
                            s.setStatus("tersedia");
                            slotDAO.insertSlot(s);
                        }
                    }
                }
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    private JPanel createLegendRow(Color color, String text) {
        JPanel row = new JPanel(new FlowLayout(FlowLayout.LEFT, 10, 0));
        row.setOpaque(false);
        row.setAlignmentX(Component.LEFT_ALIGNMENT);

        // Circular badge for legend
        JPanel indicator = new JPanel() {
            @Override
            protected void paintComponent(Graphics g) {
                super.paintComponent(g);
                Graphics2D g2 = (Graphics2D) g.create();
                g2.setRenderingHint(RenderingHints.KEY_ANTIALIASING, RenderingHints.VALUE_ANTIALIAS_ON);
                g2.setColor(color);
                g2.fillOval(1, 1, getWidth() - 3, getHeight() - 3);
                g2.setColor(color.darker());
                g2.setStroke(new BasicStroke(1));
                g2.drawOval(1, 1, getWidth() - 3, getHeight() - 3);
                g2.dispose();
            }
        };
        indicator.setOpaque(false);
        indicator.setPreferredSize(new Dimension(18, 18));
        indicator.setMinimumSize(new Dimension(18, 18));
        indicator.setMaximumSize(new Dimension(18, 18));

        JLabel label = new JLabel(text);
        label.setFont(new Font("Segoe UI", Font.PLAIN, 12));
        label.setForeground(Color.decode("#333333"));

        row.add(indicator);
        row.add(label);
        return row;
    }

    private void loadFloorTabs() {
        pnlFloorTabs.removeAll();
        lantaiList = lantaiDAO.getAllLantai();
        
        if (lantaiList.isEmpty()) return;
        
        if (selectedLantaiId == -1) {
            selectedLantaiId = lantaiList.get(0).getIdLantai();
        }
        
        for (Lantai l : lantaiList) {
            JButton btnTab = new JButton(l.getNamaLantai().toUpperCase());
            btnTab.setFont(new Font("Segoe UI", Font.BOLD, 12));
            btnTab.setPreferredSize(new Dimension(110, 35));
            
            boolean isActive = l.getIdLantai() == selectedLantaiId;
            Color bg = isActive ? Color.decode("#1E88E5") : Color.decode("#0F2742");
            Color fg = Color.WHITE;
            
            btnTab.setBackground(bg);
            btnTab.setForeground(fg);
            
            btnTab.setUI(new javax.swing.plaf.basic.BasicButtonUI() {
                @Override
                public void paint(Graphics g, JComponent c) {
                    g.setColor(bg);
                    g.fillRect(0, 0, c.getWidth(), c.getHeight());
                    
                    if (isActive) {
                        g.setColor(Color.decode("#F1C40F"));
                        g.fillRect(0, c.getHeight() - 4, c.getWidth(), 4);
                    }
                    super.paint(g, c);
                }
            });
            
            btnTab.addActionListener(new ActionListener() {
                @Override
                public void actionPerformed(ActionEvent e) {
                    selectedLantaiId = l.getIdLantai();
                    selectedSlot = null;
                    lblSelectedSlotInfo.setText("Belum Memilih Slot");
                    lblSelectedSlotInfo.setForeground(Color.GRAY);
                    btnBooking.setEnabled(false);
                    loadFloorTabs();
                    loadFloorMap();
                }
            });
            
            pnlFloorTabs.add(btnTab);
        }
        
        pnlFloorTabs.revalidate();
        pnlFloorTabs.repaint();
    }

    private void loadFloorMap() {
        pnlMapContainer.removeAll();
        
        // Add Header Info
        JPanel headerPanel = new JPanel(new BorderLayout(5, 5));
        headerPanel.setOpaque(false);
        
        String lantaiName = "Lantai";
        for (Lantai l : lantaiList) {
            if (l.getIdLantai() == selectedLantaiId) {
                lantaiName = l.getNamaLantai();
                break;
            }
        }
        
        JLabel lblFloorTitle = new JLabel("PETA PARKIR - " + lantaiName.toUpperCase());
        lblFloorTitle.setFont(new Font("Segoe UI", Font.BOLD, 18));
        lblFloorTitle.setForeground(Color.decode("#0F2742"));
        headerPanel.add(lblFloorTitle, BorderLayout.WEST);
        
        JLabel lblFloorSubtitle = new JLabel("Pilih jenis kendaraan Anda dan klik slot hijau yang tersedia.");
        lblFloorSubtitle.setFont(new Font("Segoe UI", Font.ITALIC, 11));
        lblFloorSubtitle.setForeground(Color.GRAY);
        headerPanel.add(lblFloorSubtitle, BorderLayout.SOUTH);
        
        pnlMapContainer.add(headerPanel, BorderLayout.NORTH);
        
        // Fetch Slots
        List<SlotParkir> slots = slotDAO.getSlotByLantai(selectedLantaiId);
        
        // Filter Motor & Mobil
        List<SlotParkir> motorSlots = new ArrayList<>();
        List<SlotParkir> mobilSlots = new ArrayList<>();
        
        for (SlotParkir s : slots) {
            String code = s.getKodeSlot().toUpperCase();
            if (code.startsWith("M") || code.startsWith("S") || code.startsWith("T") || code.startsWith("GM") || code.contains("MOTOR") || code.contains("SISWA")) {
                motorSlots.add(s);
            } else {
                mobilSlots.add(s);
            }
        }
        
        // Design Map panel containing slot groups
        JPanel mapDesignPanel = new JPanel();
        mapDesignPanel.setLayout(new BoxLayout(mapDesignPanel, BoxLayout.Y_AXIS));
        mapDesignPanel.setBackground(Color.WHITE);
        mapDesignPanel.setBorder(BorderFactory.createEmptyBorder(15, 5, 15, 5));
        
        // 1. Motor Area Panel
        JPanel motorArea = new JPanel(new BorderLayout(5, 5));
        motorArea.setBackground(Color.WHITE);
        motorArea.setBorder(BorderFactory.createTitledBorder(
            BorderFactory.createLineBorder(Color.decode("#BDC3C7")), 
            " AREA PARKIR MOTOR (MOTORCYCLE AREA) ", 
            TitledBorder.LEADING, 
            TitledBorder.TOP, 
            new Font("Segoe UI", Font.BOLD, 12), 
            Color.decode("#0F2742")
        ));
        
        if (motorSlots.isEmpty()) {
            JLabel lblNoMotor = new JLabel("Tidak ada area parkir motor di lantai ini");
            lblNoMotor.setFont(new Font("Segoe UI", Font.ITALIC, 11));
            lblNoMotor.setForeground(Color.GRAY);
            lblNoMotor.setBorder(BorderFactory.createEmptyBorder(10, 10, 10, 10));
            motorArea.add(lblNoMotor, BorderLayout.CENTER);
        } else {
            // Symmetrical grid of 5 columns
            JPanel motorGrid = new JPanel(new GridLayout(0, 5, 10, 10));
            motorGrid.setBackground(Color.WHITE);
            motorGrid.setBorder(BorderFactory.createEmptyBorder(10, 10, 10, 10));
            for (SlotParkir s : motorSlots) {
                motorGrid.add(createSlotButton(s, false));
            }
            motorArea.add(motorGrid, BorderLayout.CENTER);
        }
        mapDesignPanel.add(motorArea);
        mapDesignPanel.add(Box.createRigidArea(new Dimension(0, 15)));
        
        // 2. Mobil Area Panel
        JPanel mobilArea = new JPanel(new BorderLayout(5, 5));
        mobilArea.setBackground(Color.WHITE);
        mobilArea.setBorder(BorderFactory.createTitledBorder(
            BorderFactory.createLineBorder(Color.decode("#BDC3C7")), 
            " AREA PARKIR MOBIL (CAR AREA) ", 
            TitledBorder.LEADING, 
            TitledBorder.TOP, 
            new Font("Segoe UI", Font.BOLD, 12), 
            Color.decode("#0F2742")
        ));
        
        if (mobilSlots.isEmpty()) {
            JLabel lblNoMobil = new JLabel("Tidak ada area parkir mobil di lantai ini");
            lblNoMobil.setFont(new Font("Segoe UI", Font.ITALIC, 11));
            lblNoMobil.setForeground(Color.GRAY);
            lblNoMobil.setBorder(BorderFactory.createEmptyBorder(10, 10, 10, 10));
            mobilArea.add(lblNoMobil, BorderLayout.CENTER);
        } else {
            JPanel mobilLayout = new JPanel();
            mobilLayout.setLayout(new BoxLayout(mobilLayout, BoxLayout.Y_AXIS));
            mobilLayout.setBackground(Color.WHITE);
            mobilLayout.setBorder(BorderFactory.createEmptyBorder(10, 10, 10, 10));
            
            // Align in two symmetrical rows of 5 columns
            int half = (int) Math.ceil(mobilSlots.size() / 2.0);
            
            JPanel row1 = new JPanel(new GridLayout(1, 5, 10, 10));
            row1.setBackground(Color.WHITE);
            for (int i = 0; i < half; i++) {
                row1.add(createSlotButton(mobilSlots.get(i), true));
            }
            // Fill empty grid cells if any to maintain sizing
            if (half < 5) {
                for (int i = half; i < 5; i++) {
                    row1.add(new Box.Filler(new Dimension(80, 50), new Dimension(80, 50), new Dimension(80, 50)));
                }
            }
            mobilLayout.add(row1);
            
            // Decorative Asphalt Road Lane Panel (No emojis)
            JPanel lanePanel = new JPanel() {
                @Override
                protected void paintComponent(Graphics g) {
                    super.paintComponent(g);
                    Graphics2D g2 = (Graphics2D) g.create();
                    g2.setRenderingHint(RenderingHints.KEY_ANTIALIASING, RenderingHints.VALUE_ANTIALIAS_ON);
                    g2.setColor(Color.decode("#566573")); // Slate Asphalt Gray
                    g2.fillRect(0, 0, getWidth(), getHeight());
                    
                    // Draw dashed lines
                    g2.setColor(Color.WHITE);
                    g2.setStroke(new BasicStroke(2, BasicStroke.CAP_BUTT, BasicStroke.JOIN_MITER, 10.0f, new float[]{10.0f, 10.0f}, 0.0f));
                    g2.drawLine(0, getHeight() / 2, getWidth(), getHeight() / 2);
                    g2.dispose();
                }
            };
            lanePanel.setPreferredSize(new Dimension(0, 30));
            lanePanel.setMinimumSize(new Dimension(0, 30));
            lanePanel.setMaximumSize(new Dimension(32767, 30));
            lanePanel.setLayout(new BorderLayout());
            
            JLabel lblLane = new JLabel("<<<  JALUR SIRKULASI UTAMA (SATU ARAH)  >>>", JLabel.CENTER);
            lblLane.setFont(new Font("Segoe UI", Font.BOLD, 10));
            lblLane.setForeground(Color.decode("#F1C40F")); // Yellow lane line text
            lanePanel.add(lblLane, BorderLayout.CENTER);
            
            mobilLayout.add(Box.createRigidArea(new Dimension(0, 10)));
            mobilLayout.add(lanePanel);
            mobilLayout.add(Box.createRigidArea(new Dimension(0, 10)));
            
            JPanel row2 = new JPanel(new GridLayout(1, 5, 10, 10));
            row2.setBackground(Color.WHITE);
            int row2Count = 0;
            for (int i = half; i < mobilSlots.size(); i++) {
                row2.add(createSlotButton(mobilSlots.get(i), true));
                row2Count++;
            }
            // Fill empty cells
            if (row2Count < 5) {
                for (int i = row2Count; i < 5; i++) {
                    row2.add(new Box.Filler(new Dimension(80, 50), new Dimension(80, 50), new Dimension(80, 50)));
                }
            }
            mobilLayout.add(row2);
            
            mobilArea.add(mobilLayout, BorderLayout.CENTER);
        }
        mapDesignPanel.add(mobilArea);
        mapDesignPanel.add(Box.createRigidArea(new Dimension(0, 15)));
        
        // 3. Facilty and Utility indicators (clean ASCII labels instead of emojis)
        JPanel facilityPanel = new JPanel(new FlowLayout(FlowLayout.CENTER, 15, 5));
        facilityPanel.setBackground(Color.decode("#F2F4F4"));
        facilityPanel.setBorder(BorderFactory.createLineBorder(Color.decode("#BDC3C7")));
        facilityPanel.setMaximumSize(new Dimension(32767, 40));
        
        JLabel lblFacility = new JLabel("Fasilitas Terdekat:");
        lblFacility.setFont(new Font("Segoe UI", Font.BOLD, 11));
        facilityPanel.add(lblFacility);
        
        JLabel lblLift = new JLabel("[ LIFT & LOBBY ]");
        lblLift.setFont(new Font("Segoe UI", Font.BOLD, 10));
        lblLift.setForeground(Color.decode("#2E4053"));
        facilityPanel.add(lblLift);
        
        JLabel lblToilet = new JLabel("[ TOILET ]");
        lblToilet.setFont(new Font("Segoe UI", Font.BOLD, 10));
        lblToilet.setForeground(Color.decode("#2E4053"));
        facilityPanel.add(lblToilet);
        
        JLabel lblTangga = new JLabel("[ TANGGA DARURAT ]");
        lblTangga.setFont(new Font("Segoe UI", Font.BOLD, 10));
        lblTangga.setForeground(Color.decode("#C0392B"));
        facilityPanel.add(lblTangga);
        
        JLabel lblPos = new JLabel("[ POS JAGA ]");
        lblPos.setFont(new Font("Segoe UI", Font.BOLD, 10));
        lblPos.setForeground(Color.decode("#D35400"));
        facilityPanel.add(lblPos);
        
        mapDesignPanel.add(facilityPanel);
        
        // Scrollable container for map to handle large parking configurations smoothly
        JScrollPane scrollMap = new JScrollPane(mapDesignPanel);
        scrollMap.setBorder(null);
        scrollMap.setBackground(Color.WHITE);
        scrollMap.getVerticalScrollBar().setUnitIncrement(12);
        
        pnlMapContainer.add(scrollMap, BorderLayout.CENTER);
        
        pnlMapContainer.revalidate();
        pnlMapContainer.repaint();
    }

    private JButton createSlotButton(SlotParkir s, boolean isMobil) {
        JButton btn = new JButton(s.getKodeSlot());
        Dimension size = isMobil ? new Dimension(80, 50) : new Dimension(70, 45);
        btn.setPreferredSize(size);
        btn.setMaximumSize(size);
        btn.setFont(new Font("Segoe UI", Font.BOLD, 12));
        
        String selectedJenis = ((String) cbJenis.getSelectedItem()).toLowerCase();
        String code = s.getKodeSlot().toUpperCase();
        boolean isMotorSlot = code.startsWith("M") || code.startsWith("S") || code.startsWith("T") || code.startsWith("GM") || code.contains("MOTOR") || code.contains("SISWA");
        
        boolean typeMatches = (selectedJenis.equals("motor") && isMotorSlot) || (selectedJenis.equals("mobil") && !isMotorSlot);
        
        btn.setContentAreaFilled(false);
        btn.setBorderPainted(false);
        btn.setOpaque(false);
        
        Color bg;
        if (s.getStatus().equals("dibooking") || s.getStatus().equals("terisi")) {
            bg = Color.decode("#EF5350"); // Red
            btn.setForeground(Color.WHITE);
            btn.setEnabled(false);
            btn.setToolTipText("Slot " + s.getKodeSlot() + " (Terisi / Booking)");
        } else if (!typeMatches) {
            bg = Color.decode("#E5E8E8"); // Greyed out due to filter
            btn.setForeground(Color.decode("#BDC3C7"));
            btn.setEnabled(false);
            btn.setToolTipText("Khusus " + (isMotorSlot ? "Motor" : "Mobil"));
        } else if (selectedSlot != null && selectedSlot.getIdSlot() == s.getIdSlot()) {
            bg = Color.decode("#FFCA28"); // Yellow/Orange Selected
            btn.setForeground(Color.BLACK);
            btn.setToolTipText("Slot pilihan Anda");
            btn.setCursor(new Cursor(Cursor.HAND_CURSOR));
        } else {
            bg = Color.decode("#2ECC71"); // Green Available
            btn.setForeground(Color.WHITE);
            btn.setCursor(new Cursor(Cursor.HAND_CURSOR));
            btn.setToolTipText("Klik untuk memilih Slot " + s.getKodeSlot());
        }

        btn.setUI(new javax.swing.plaf.basic.BasicButtonUI() {
            @Override
            public void paint(Graphics g, JComponent c) {
                AbstractButton b = (AbstractButton) c;
                ButtonModel model = b.getModel();
                Graphics2D g2 = (Graphics2D) g.create();
                g2.setRenderingHint(RenderingHints.KEY_ANTIALIASING, RenderingHints.VALUE_ANTIALIAS_ON);
                
                // Adjust color slightly on hover/press if button is enabled
                Color fillBg = bg;
                if (b.isEnabled() && s.getStatus().equals("tersedia") && typeMatches) {
                    if (model.isPressed()) {
                        fillBg = bg.darker();
                    } else if (model.isRollover()) {
                        fillBg = bg.brighter();
                    }
                }
                
                // Draw background rectangle
                g2.setColor(fillBg);
                g2.fillRect(0, 0, c.getWidth(), c.getHeight());
                
                // Draw flat dashed parking lines on left and right borders of the bay
                if (b.isEnabled() && s.getStatus().equals("tersedia") && typeMatches) {
                    g2.setColor(Color.WHITE);
                } else if (s.getStatus().equals("dibooking") || s.getStatus().equals("terisi")) {
                    g2.setColor(Color.decode("#F5B7B1")); // lighter red line
                } else {
                    g2.setColor(Color.decode("#D5D8DC")); // muted grey line
                }
                g2.setStroke(new BasicStroke(2.0f, BasicStroke.CAP_BUTT, BasicStroke.JOIN_MITER, 10.0f, new float[]{4.0f, 4.0f}, 0.0f));
                g2.drawLine(2, 0, 2, c.getHeight());
                g2.drawLine(c.getWidth() - 3, 0, c.getWidth() - 3, c.getHeight());
                
                // Draw border line
                if (selectedSlot != null && selectedSlot.getIdSlot() == s.getIdSlot()) {
                    g2.setColor(Color.decode("#E67E22")); // Orange active border
                    g2.setStroke(new BasicStroke(3));
                    g2.drawRect(1, 1, c.getWidth() - 3, c.getHeight() - 3);
                } else {
                    g2.setColor(fillBg.darker());
                    g2.setStroke(new BasicStroke(1));
                    g2.drawRect(0, 0, c.getWidth() - 1, c.getHeight() - 1);
                }
                
                g2.dispose();
                super.paint(g, c);
            }
        });

        if (btn.isEnabled() && s.getStatus().equals("tersedia") && typeMatches) {
            btn.addActionListener(new ActionListener() {
                @Override
                public void actionPerformed(ActionEvent e) {
                    selectedSlot = s;
                    lblSelectedSlotInfo.setText(s.getKodeSlot());
                    lblSelectedSlotInfo.setForeground(Color.decode("#1E8449"));
                    btnBooking.setEnabled(true);
                    loadFloorMap(); // Refresh colors/borders
                }
            });
        }
        
        return btn;
    }

    private void resetForm() {
        txtPlat.setText("");
        cbJenis.setSelectedIndex(0);
        selectedSlot = null;
        lblSelectedSlotInfo.setText("Belum Memilih Slot");
        lblSelectedSlotInfo.setForeground(Color.GRAY);
        btnBooking.setEnabled(false);
        
        if (lantaiList != null && !lantaiList.isEmpty()) {
            selectedLantaiId = lantaiList.get(0).getIdLantai();
        }
        
        loadFloorTabs();
        loadFloorMap();
    }

    private void prosesBooking() {
        String plat = txtPlat.getText().trim().toUpperCase();
        String jenis = ((String) cbJenis.getSelectedItem()).toLowerCase();

        if (plat.isEmpty()) {
            MessageHelper.showWarning(this, "Plat Nomor kendaraan wajib diisi!");
            return;
        }

        if (selectedSlot == null) {
            MessageHelper.showError(this, "Silakan pilih slot parkir kosong pada denah terlebih dahulu!");
            return;
        }

        String kodeBooking = KodeGenerator.generateBooking();
        Date waktuBooking = new Date();

        Booking b = new Booking();
        b.setKodeBooking(kodeBooking);
        b.setIdUser(currentUser.getIdUser());
        b.setIdSlot(selectedSlot.getIdSlot());
        b.setPlatNomor(plat);
        b.setJenisKendaraan(jenis);
        b.setWaktuBooking(waktuBooking);

        if (bookingDAO.insertBooking(b)) {
            String namaLantai = "";
            for (Lantai l : lantaiList) {
                if (l.getIdLantai() == selectedLantaiId) {
                    namaLantai = l.getNamaLantai();
                    break;
                }
            }

            StringBuilder struk = new StringBuilder();
            struk.append("==========================================\n");
            struk.append("              PARKING MALL                \n");
            struk.append("           BUKTI BOOKING PARKIR           \n");
            struk.append("==========================================\n");
            struk.append("KODE BOOKING  : ").append(kodeBooking).append("\n");
            struk.append("Nama Pelanggan: ").append(currentUser.getNama()).append("\n");
            struk.append("Plat Nomor    : ").append(plat).append("\n");
            struk.append("Jenis         : ").append(jenis.toUpperCase()).append("\n");
            struk.append("Lantai / Slot : ").append(namaLantai).append(" / ").append(selectedSlot.getKodeSlot()).append("\n");
            struk.append("Waktu Booking : ").append(parkingmall.helper.DateHelper.toDisplayString(waktuBooking)).append("\n");
            struk.append("------------------------------------------\n");
            struk.append("Status        : MENUNGGU VERIFIKASI\n");
            struk.append("==========================================\n");
            struk.append(" Tunjukkan kode booking ini kepada petugas  \n");
            struk.append("       saat Anda tiba di pintu masuk.     \n");
            struk.append("==========================================\n");

            JTextArea textArea = new JTextArea(struk.toString());
            textArea.setFont(new Font("Monospaced", Font.PLAIN, 12));
            textArea.setEditable(false);
            JScrollPane scrollPane = new JScrollPane(textArea);
            scrollPane.setPreferredSize(new Dimension(350, 320));

            MessageHelper.showInfo(this, "Booking Slot Berhasil!");
            JOptionPane.showMessageDialog(this, scrollPane, "Bukti Booking", JOptionPane.PLAIN_MESSAGE);
            
            resetForm();
        } else {
            MessageHelper.showError(this, "Gagal memproses booking parkir!");
        }
    }
}
