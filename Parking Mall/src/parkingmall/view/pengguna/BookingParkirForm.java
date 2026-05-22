package parkingmall.view.pengguna;

import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.util.Date;
import java.util.List;
import javax.swing.*;
import javax.swing.border.EmptyBorder;
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
    
    private final JTextField txtNama;
    private final JTextField txtPlat;
    private final JComboBox<String> cbJenis;
    private final JComboBox<LantaiComboItem> cbLantai;
    private final JComboBox<SlotComboItem> cbSlot;
    
    private final JButton btnBooking;
    private final JButton btnReset;
    
    private static class LantaiComboItem {
        int idLantai;
        String namaLantai;

        public LantaiComboItem(int idLantai, String namaLantai) {
            this.idLantai = idLantai;
            this.namaLantai = namaLantai;
        }

        @Override
        public String toString() {
            return namaLantai;
        }
    }

    private static class SlotComboItem {
        int idSlot;
        String kodeSlot;

        public SlotComboItem(int idSlot, String kodeSlot) {
            this.idSlot = idSlot;
            this.kodeSlot = kodeSlot;
        }

        @Override
        public String toString() {
            return kodeSlot;
        }
    }

    public BookingParkirForm(User user) {
        this.currentUser = user;
        this.lantaiDAO = new LantaiDAO();
        this.slotDAO = new SlotParkirDAO();
        this.bookingDAO = new BookingDAO();
        
        setLayout(new BorderLayout(15, 15));
        setBackground(Color.decode("#85C1E9"));
        setBorder(new EmptyBorder(20, 20, 20, 20));

        // TITLE
        JLabel lblTitle = new JLabel("Form Booking Slot Parkir");
        lblTitle.setFont(new Font("Segoe UI", Font.BOLD, 22));
        lblTitle.setForeground(Color.decode("#0F2742"));
        add(lblTitle, BorderLayout.NORTH);

        // FORM PANEL (CENTERED)
        JPanel centerPanel = new JPanel(new GridBagLayout());
        centerPanel.setBackground(Color.decode("#85C1E9"));
        
        JPanel card = new JPanel();
        card.setLayout(new BoxLayout(card, BoxLayout.Y_AXIS));
        card.setBackground(Color.WHITE);
        card.setBorder(BorderFactory.createCompoundBorder(
            BorderFactory.createLineBorder(Color.LIGHT_GRAY),
            new EmptyBorder(25, 30, 25, 30)
        ));
        card.setPreferredSize(new Dimension(420, 420));

        // Inputs
        card.add(new JLabel("Nama Pengguna:"));
        card.add(Box.createRigidArea(new Dimension(0, 3)));
        txtNama = new JTextField(currentUser.getNama());
        txtNama.setEditable(false);
        txtNama.setMaximumSize(new Dimension(360, 30));
        txtNama.setAlignmentX(Component.LEFT_ALIGNMENT);
        card.add(txtNama);
        card.add(Box.createRigidArea(new Dimension(0, 12)));

        card.add(new JLabel("Plat Nomor Kendaraan:"));
        card.add(Box.createRigidArea(new Dimension(0, 3)));
        txtPlat = new JTextField();
        txtPlat.setFont(new Font("Segoe UI", Font.BOLD, 13));
        txtPlat.setMaximumSize(new Dimension(360, 30));
        txtPlat.setAlignmentX(Component.LEFT_ALIGNMENT);
        card.add(txtPlat);
        card.add(Box.createRigidArea(new Dimension(0, 12)));

        card.add(new JLabel("Jenis Kendaraan:"));
        card.add(Box.createRigidArea(new Dimension(0, 3)));
        cbJenis = new JComboBox<>(new String[]{"Motor", "Mobil"});
        cbJenis.setMaximumSize(new Dimension(360, 30));
        cbJenis.setAlignmentX(Component.LEFT_ALIGNMENT);
        card.add(cbJenis);
        card.add(Box.createRigidArea(new Dimension(0, 12)));

        card.add(new JLabel("Pilih Lantai Parkir:"));
        card.add(Box.createRigidArea(new Dimension(0, 3)));
        cbLantai = new JComboBox<>();
        cbLantai.setMaximumSize(new Dimension(360, 30));
        cbLantai.setAlignmentX(Component.LEFT_ALIGNMENT);
        card.add(cbLantai);
        card.add(Box.createRigidArea(new Dimension(0, 12)));

        card.add(new JLabel("Pilih Slot Parkir (Tersedia):"));
        card.add(Box.createRigidArea(new Dimension(0, 3)));
        cbSlot = new JComboBox<>();
        cbSlot.setMaximumSize(new Dimension(360, 30));
        cbSlot.setAlignmentX(Component.LEFT_ALIGNMENT);
        card.add(cbSlot);
        card.add(Box.createRigidArea(new Dimension(0, 20)));

        // Action Buttons
        JPanel actionPanel = new JPanel(new GridLayout(1, 2, 10, 0));
        actionPanel.setBackground(Color.WHITE);
        actionPanel.setMaximumSize(new Dimension(360, 38));
        actionPanel.setAlignmentX(Component.LEFT_ALIGNMENT);

        btnBooking = new JButton("Booking Sekarang");
        parkingmall.helper.UIHelper.styleButton(btnBooking, Color.decode("#1E88E5"), Color.WHITE);

        btnReset = new JButton("Reset");
        parkingmall.helper.UIHelper.styleButton(btnReset, Color.GRAY, Color.WHITE);

        actionPanel.add(btnBooking);
        actionPanel.add(btnReset);
        card.add(actionPanel);

        centerPanel.add(card);
        add(centerPanel, BorderLayout.CENTER);

        // Events
        cbLantai.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                loadSlotTersedia();
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
        loadLantaiCombo();
        loadSlotTersedia();
    }

    private void loadLantaiCombo() {
        cbLantai.removeAllItems();
        List<Lantai> list = lantaiDAO.getAllLantai();
        for (Lantai l : list) {
            cbLantai.addItem(new LantaiComboItem(l.getIdLantai(), l.getNamaLantai()));
        }
    }

    // Fungsi ini digunakan untuk memuat daftar slot parkir kosong berdasarkan lantai
    private void loadSlotTersedia() {
        cbSlot.removeAllItems();
        LantaiComboItem item = (LantaiComboItem) cbLantai.getSelectedItem();
        if (item == null) return;

        List<SlotParkir> list = slotDAO.getAvailableSlotByLantai(item.idLantai);
        for (SlotParkir s : list) {
            cbSlot.addItem(new SlotComboItem(s.getIdSlot(), s.getKodeSlot()));
        }

        if (cbSlot.getItemCount() == 0) {
            btnBooking.setEnabled(false);
            cbSlot.addItem(new SlotComboItem(-1, "Penuh"));
        } else {
            btnBooking.setEnabled(true);
        }
    }

    private void resetForm() {
        txtPlat.setText("");
        cbJenis.setSelectedIndex(0);
        if (cbLantai.getItemCount() > 0) cbLantai.setSelectedIndex(0);
        loadSlotTersedia();
    }

    // Fungsi ini digunakan untuk membuat booking baru pengguna dan memperbarui status slot parkir secara transaksional
    private void prosesBooking() {
        String plat = txtPlat.getText().trim().toUpperCase();
        String jenis = ((String) cbJenis.getSelectedItem()).toLowerCase();
        LantaiComboItem lantaiItem = (LantaiComboItem) cbLantai.getSelectedItem();
        SlotComboItem slotItem = (SlotComboItem) cbSlot.getSelectedItem();

        // Validasi input kosong
        if (plat.isEmpty()) {
            MessageHelper.showWarning(this, "Plat Nomor kendaraan wajib diisi!");
            return;
        }

        if (slotItem == null || slotItem.idSlot == -1) {
            MessageHelper.showError(this, "Slot Parkir di lantai ini penuh!");
            return;
        }

        String kodeBooking = KodeGenerator.generateBooking();
        Date waktuBooking = new Date();

        Booking b = new Booking();
        b.setKodeBooking(kodeBooking);
        b.setIdUser(currentUser.getIdUser());
        b.setIdSlot(slotItem.idSlot);
        b.setPlatNomor(plat);
        b.setJenisKendaraan(jenis);
        b.setWaktuBooking(waktuBooking);

        if (bookingDAO.insertBooking(b)) {
            // Tampilkan info booking
            StringBuilder struk = new StringBuilder();
            struk.append("==========================================\n");
            struk.append("              PARKING MALL                \n");
            struk.append("           BUKTI BOOKING PARKIR           \n");
            struk.append("==========================================\n");
            struk.append("KODE BOOKING  : ").append(kodeBooking).append("\n");
            struk.append("Nama Pelanggan: ").append(currentUser.getNama()).append("\n");
            struk.append("Plat Nomor    : ").append(plat).append("\n");
            struk.append("Jenis         : ").append(jenis.toUpperCase()).append("\n");
            struk.append("Lantai / Slot : ").append(lantaiItem.namaLantai).append(" / ").append(slotItem.kodeSlot).append("\n");
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
