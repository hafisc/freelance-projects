package parkingmall.view.petugas;

import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.List;
import javax.swing.*;
import javax.swing.border.EmptyBorder;
import parkingmall.dao.LantaiDAO;
import parkingmall.dao.SlotParkirDAO;
import parkingmall.dao.KendaraanDAO;
import parkingmall.dao.TransaksiDAO;
import parkingmall.helper.DateHelper;
import parkingmall.helper.KodeGenerator;
import parkingmall.helper.MessageHelper;
import parkingmall.model.Lantai;
import parkingmall.model.SlotParkir;
import parkingmall.model.Kendaraan;
import parkingmall.model.Transaksi;

public class KendaraanMasukForm extends JPanel {
    private final LantaiDAO lantaiDAO;
    private final SlotParkirDAO slotDAO;
    private final KendaraanDAO kendaraanDAO;
    private final TransaksiDAO transaksiDAO;
    
    private final JTextField txtPlat;
    private final JComboBox<String> cbJenis;
    private final JComboBox<LantaiComboItem> cbLantai;
    private final JComboBox<SlotComboItem> cbSlot;
    private final JTextField txtWaktuMasuk;
    
    private final JButton btnSimpan;
    private final JButton btnReset;
    private final JButton btnCetakKarcis;
    
    private String lastPrintedKarcis = "";

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

    public KendaraanMasukForm() {
        this.lantaiDAO = new LantaiDAO();
        this.slotDAO = new SlotParkirDAO();
        this.kendaraanDAO = new KendaraanDAO();
        this.transaksiDAO = new TransaksiDAO();
        
        setLayout(new BorderLayout(15, 15));
        setBackground(Color.decode("#85C1E9"));
        setBorder(new EmptyBorder(20, 20, 20, 20));

        // TITLE
        JLabel lblTitle = new JLabel("Input Kendaraan Masuk (Check-In)");
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
            new EmptyBorder(30, 40, 30, 40)
        ));
        card.setPreferredSize(new Dimension(450, 450));

        // Inputs
        card.add(new JLabel("Plat Nomor Kendaraan:"));
        card.add(Box.createRigidArea(new Dimension(0, 5)));
        txtPlat = new JTextField(15);
        txtPlat.setFont(new Font("Segoe UI", Font.BOLD, 14));
        txtPlat.setMaximumSize(new Dimension(400, 35));
        txtPlat.setAlignmentX(Component.LEFT_ALIGNMENT);
        card.add(txtPlat);
        card.add(Box.createRigidArea(new Dimension(0, 15)));

        card.add(new JLabel("Jenis Kendaraan:"));
        card.add(Box.createRigidArea(new Dimension(0, 5)));
        cbJenis = new JComboBox<>(new String[]{"Motor", "Mobil"});
        cbJenis.setMaximumSize(new Dimension(400, 35));
        cbJenis.setAlignmentX(Component.LEFT_ALIGNMENT);
        card.add(cbJenis);
        card.add(Box.createRigidArea(new Dimension(0, 15)));

        card.add(new JLabel("Pilih Lantai Parkir:"));
        card.add(Box.createRigidArea(new Dimension(0, 5)));
        cbLantai = new JComboBox<>();
        cbLantai.setMaximumSize(new Dimension(400, 35));
        cbLantai.setAlignmentX(Component.LEFT_ALIGNMENT);
        card.add(cbLantai);
        card.add(Box.createRigidArea(new Dimension(0, 15)));

        card.add(new JLabel("Pilih Slot Parkir (Tersedia):"));
        card.add(Box.createRigidArea(new Dimension(0, 5)));
        cbSlot = new JComboBox<>();
        cbSlot.setMaximumSize(new Dimension(400, 35));
        cbSlot.setAlignmentX(Component.LEFT_ALIGNMENT);
        card.add(cbSlot);
        card.add(Box.createRigidArea(new Dimension(0, 15)));

        card.add(new JLabel("Waktu Masuk:"));
        card.add(Box.createRigidArea(new Dimension(0, 5)));
        txtWaktuMasuk = new JTextField();
        txtWaktuMasuk.setEditable(false);
        txtWaktuMasuk.setMaximumSize(new Dimension(400, 35));
        txtWaktuMasuk.setAlignmentX(Component.LEFT_ALIGNMENT);
        card.add(txtWaktuMasuk);
        card.add(Box.createRigidArea(new Dimension(0, 25)));

        // Action Buttons
        JPanel actionPanel = new JPanel(new GridLayout(1, 3, 10, 0));
        actionPanel.setBackground(Color.WHITE);
        actionPanel.setMaximumSize(new Dimension(400, 40));
        actionPanel.setAlignmentX(Component.LEFT_ALIGNMENT);

        btnSimpan = new JButton("Check-In");
        parkingmall.helper.UIHelper.styleButton(btnSimpan, Color.decode("#1E88E5"), Color.WHITE);

        btnReset = new JButton("Reset");
        parkingmall.helper.UIHelper.styleButton(btnReset, Color.GRAY, Color.WHITE);

        btnCetakKarcis = new JButton("Preview Karcis");
        parkingmall.helper.UIHelper.styleButton(btnCetakKarcis, Color.decode("#0F2742"), Color.WHITE);
        btnCetakKarcis.setEnabled(false);

        actionPanel.add(btnSimpan);
        actionPanel.add(btnReset);
        actionPanel.add(btnCetakKarcis);
        card.add(actionPanel);

        centerPanel.add(card);
        add(centerPanel, BorderLayout.CENTER);

        // Timer for waktu masuk
        Timer timeTimer = new Timer(1000, new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                txtWaktuMasuk.setText(new SimpleDateFormat("dd-MM-yyyy HH:mm:ss").format(new Date()));
            }
        });
        timeTimer.start();

        // Event listeners
        cbLantai.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                loadSlotTersedia();
            }
        });

        btnSimpan.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                prosesCheckIn();
            }
        });

        btnReset.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                resetForm();
            }
        });

        btnCetakKarcis.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                tampilkanPreviewKarcis();
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

    // Fungsi ini digunakan untuk mengambil slot parkir berstatus 'tersedia' berdasarkan lantai terpilih
    private void loadSlotTersedia() {
        cbSlot.removeAllItems();
        LantaiComboItem item = (LantaiComboItem) cbLantai.getSelectedItem();
        if (item == null) return;

        List<SlotParkir> list = slotDAO.getAvailableSlotByLantai(item.idLantai);
        for (SlotParkir s : list) {
            cbSlot.addItem(new SlotComboItem(s.getIdSlot(), s.getKodeSlot()));
        }
        
        if (cbSlot.getItemCount() == 0) {
            btnSimpan.setEnabled(false);
            cbSlot.addItem(new SlotComboItem(-1, "Penuh"));
        } else {
            btnSimpan.setEnabled(true);
        }
    }

    // Fungsi ini digunakan untuk mengatur ulang isi form input
    private void resetForm() {
        txtPlat.setText("");
        cbJenis.setSelectedIndex(0);
        if (cbLantai.getItemCount() > 0) cbLantai.setSelectedIndex(0);
        loadSlotTersedia();
        btnCetakKarcis.setEnabled(false);
        lastPrintedKarcis = "";
    }

    // Fungsi ini digunakan untuk memproses pencatatan kendaraan masuk dan billing awal secara transaksional
    private void prosesCheckIn() {
        String plat = txtPlat.getText().trim().toUpperCase();
        String jenis = ((String) cbJenis.getSelectedItem()).toLowerCase();
        LantaiComboItem lantaiItem = (LantaiComboItem) cbLantai.getSelectedItem();
        SlotComboItem slotItem = (SlotComboItem) cbSlot.getSelectedItem();

        // Validasi input kosong
        if (plat.isEmpty()) {
            MessageHelper.showWarning(this, "Plat Nomor tidak boleh kosong!");
            return;
        }

        if (slotItem == null || slotItem.idSlot == -1) {
            MessageHelper.showError(this, "Slot Parkir di lantai ini sudah penuh!");
            return;
        }

        // Cek apakah kendaraan dengan plat tersebut sudah terparkir (masuk tapi belum keluar)
        Kendaraan kCheck = kendaraanDAO.findKendaraanAktif(plat);
        if (kCheck != null) {
            MessageHelper.showError(this, "Kendaraan dengan plat " + plat + " terdeteksi sudah terparkir di " + kCheck.getNamaLantai() + " - " + kCheck.getKodeSlot() + "!");
            return;
        }

        Date waktuMasuk = new Date();
        
        Kendaraan k = new Kendaraan();
        k.setPlatNomor(plat);
        k.setJenisKendaraan(jenis);
        k.setIdSlot(slotItem.idSlot);
        k.setWaktuMasuk(waktuMasuk);

        int idKendaraan = kendaraanDAO.insertKendaraanMasuk(k);
        if (idKendaraan != -1) {
            // Buat transaksi awal
            String kodeTrx = KodeGenerator.generateTransaksi();
            
            Transaksi t = new Transaksi();
            t.setKodeTransaksi(kodeTrx);
            t.setIdKendaraan(idKendaraan);
            t.setWaktuMasuk(waktuMasuk);

            if (transaksiDAO.insertTransaksiMasuk(t)) {
                MessageHelper.showInfo(this, "Check-In Berhasil! Karcis parkir siap dicetak.");
                
                // Siapkan String Karcis
                StringBuilder karcisText = new StringBuilder();
                karcisText.append("==========================================\n");
                karcisText.append("              PARKING MALL                \n");
                karcisText.append("             KARCIS PARKIR                \n");
                karcisText.append("==========================================\n");
                karcisText.append("Kode Karcis   : ").append(kodeTrx).append("\n");
                karcisText.append("Plat Nomor    : ").append(plat).append("\n");
                karcisText.append("Jenis         : ").append(jenis.toUpperCase()).append("\n");
                karcisText.append("Lantai / Slot : ").append(lantaiItem.namaLantai).append(" / ").append(slotItem.kodeSlot).append("\n");
                karcisText.append("Waktu Masuk   : ").append(DateHelper.toDisplayString(waktuMasuk)).append("\n");
                karcisText.append("------------------------------------------\n");
                karcisText.append("Tarif Parkir  : \n");
                karcisText.append("- Mobil       : Rp 5.000 / Jam\n");
                karcisText.append("- Motor       : Rp 2.000 / Jam\n");
                karcisText.append("==========================================\n");
                karcisText.append("        SIMPAN KARCIS INI DENGAN BAIK     \n");
                karcisText.append("==========================================\n");
                
                lastPrintedKarcis = karcisText.toString();
                btnCetakKarcis.setEnabled(true);
                
                // Tampilkan struk otomatis dengan invokeLater agar EDT merender tombol aktif sebelum dialog modal muncul
                SwingUtilities.invokeLater(new Runnable() {
                    @Override
                    public void run() {
                        tampilkanPreviewKarcis();
                    }
                });
                
                // Reset untuk kendaraan berikutnya
                txtPlat.setText("");
                loadSlotTersedia();
            } else {
                MessageHelper.showError(this, "Gagal membuat transaksi parkir!");
            }
        } else {
            MessageHelper.showError(this, "Gagal mencatat kendaraan masuk!");
        }
    }

    // Fungsi ini digunakan untuk menampilkan dialog pratinjau karcis dengan opsi cetak fisik/PDF
    private void tampilkanPreviewKarcis() {
        if (lastPrintedKarcis.isEmpty()) return;

        JTextArea textArea = new JTextArea(lastPrintedKarcis);
        textArea.setFont(new Font("Monospaced", Font.PLAIN, 12));
        textArea.setEditable(false);
        JScrollPane scrollPane = new JScrollPane(textArea);
        scrollPane.setPreferredSize(new Dimension(350, 300));

        Object[] options = {"Cetak ke Printer / PDF", "Tutup"};
        int result = JOptionPane.showOptionDialog(
            this, 
            scrollPane, 
            "Karcis Parkir", 
            JOptionPane.DEFAULT_OPTION, 
            JOptionPane.PLAIN_MESSAGE, 
            null, 
            options, 
            options[0]
        );

        if (result == 0) {
            try {
                boolean complete = textArea.print();
                if (complete) {
                    MessageHelper.showInfo(this, "Pencetakan selesai!");
                } else {
                    MessageHelper.showInfo(this, "Pencetakan dibatalkan.");
                }
            } catch (java.awt.print.PrinterException ex) {
                MessageHelper.showError(this, "Gagal mencetak: " + ex.getMessage());
            }
        }
    }
}
