package parkingmall.view.petugas;

import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.text.NumberFormat;
import java.util.Date;
import java.util.Locale;
import javax.swing.*;
import javax.swing.border.EmptyBorder;
import parkingmall.dao.TransaksiDAO;
import parkingmall.helper.DateHelper;
import parkingmall.helper.MessageHelper;
import parkingmall.model.Transaksi;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

public class KendaraanKeluarForm extends JPanel {
    private final TransaksiDAO transaksiDAO;
    
    private final JTextField txtKeyword;
    private final JButton btnCari;
    
    private final JTextField txtPlat;
    private final JTextField txtJenis;
    private final JTextField txtLantaiSlot;
    private final JTextField txtWaktuMasuk;
    private final JTextField txtWaktuKeluar;
    private final JTextField txtDurasi;
    private final JTextField txtBiaya;
    
    private final JButton btnSimpan;
    private final JButton btnReset;
    private final JButton btnCetakStruk;
    
    private Transaksi activeTrx = null;
    private String lastPrintedStruk = "";
    
    private final NumberFormat rpFormat = NumberFormat.getCurrencyInstance(new Locale("id", "ID"));

    public KendaraanKeluarForm() {
        this.transaksiDAO = new TransaksiDAO();
        
        setLayout(new BorderLayout(15, 15));
        setBackground(Color.decode("#85C1E9"));
        setBorder(new EmptyBorder(15, 15, 15, 15));

        // TITLE
        JLabel lblTitle = new JLabel("Input Kendaraan Keluar (Check-Out)");
        lblTitle.setFont(new Font("Segoe UI", Font.BOLD, 22));
        lblTitle.setForeground(Color.decode("#0F2742"));
        add(lblTitle, BorderLayout.NORTH);

        // MAIN GRID (West: Search & Details, Center: Struk/Actions)
        JPanel mainPanel = new JPanel(new GridBagLayout());
        mainPanel.setBackground(Color.decode("#85C1E9"));

        JPanel card = new JPanel();
        card.setLayout(new BoxLayout(card, BoxLayout.Y_AXIS));
        card.setBackground(Color.WHITE);
        card.setBorder(BorderFactory.createCompoundBorder(
            BorderFactory.createLineBorder(Color.LIGHT_GRAY),
            new EmptyBorder(20, 25, 20, 25)
        ));
        card.setPreferredSize(new Dimension(500, 520));

        // SEARCH BAR
        JPanel searchBar = new JPanel(new BorderLayout(5, 0));
        searchBar.setBackground(Color.WHITE);
        searchBar.setMaximumSize(new Dimension(450, 35));
        searchBar.setAlignmentX(Component.LEFT_ALIGNMENT);
        
        txtKeyword = new JTextField(15);
        txtKeyword.setFont(new Font("Segoe UI", Font.PLAIN, 13));
        txtKeyword.setToolTipText("Masukkan Plat Nomor / Kode Karcis");
        searchBar.add(txtKeyword, BorderLayout.CENTER);
        
        btnCari = new JButton("Cari Kendaraan");
        parkingmall.helper.UIHelper.styleButton(btnCari, Color.decode("#0F2742"), Color.WHITE);
        searchBar.add(btnCari, BorderLayout.EAST);
        
        card.add(new JLabel("Cari Plat Nomor / Kode Karcis:"));
        card.add(Box.createRigidArea(new Dimension(0, 5)));
        card.add(searchBar);
        card.add(Box.createRigidArea(new Dimension(0, 15)));

        // DETAILS FIELDS
        txtPlat = createReadOnlyField(card, "Plat Nomor:");
        txtJenis = createReadOnlyField(card, "Jenis Kendaraan:");
        txtLantaiSlot = createReadOnlyField(card, "Lantai / Slot Parkir:");
        txtWaktuMasuk = createReadOnlyField(card, "Waktu Masuk:");
        txtWaktuKeluar = createReadOnlyField(card, "Waktu Keluar:");
        txtDurasi = createReadOnlyField(card, "Durasi Parkir:");
        txtBiaya = createReadOnlyField(card, "Total Biaya Parkir:");
        txtBiaya.setFont(new Font("Segoe UI", Font.BOLD, 14));
        txtBiaya.setForeground(Color.decode("#C62828"));

        card.add(Box.createRigidArea(new Dimension(0, 15)));

        // BUTTONS
        JPanel actionPanel = new JPanel(new GridLayout(1, 3, 10, 0));
        actionPanel.setBackground(Color.WHITE);
        actionPanel.setMaximumSize(new Dimension(450, 40));
        actionPanel.setAlignmentX(Component.LEFT_ALIGNMENT);

        btnSimpan = new JButton("Proses Keluar");
        parkingmall.helper.UIHelper.styleButton(btnSimpan, Color.decode("#1E88E5"), Color.WHITE);
        btnSimpan.setEnabled(false);

        btnReset = new JButton("Reset");
        parkingmall.helper.UIHelper.styleButton(btnReset, Color.GRAY, Color.WHITE);

        btnCetakStruk = new JButton("Preview Struk");
        parkingmall.helper.UIHelper.styleButton(btnCetakStruk, Color.decode("#0F2742"), Color.WHITE);
        btnCetakStruk.setEnabled(false);

        actionPanel.add(btnSimpan);
        actionPanel.add(btnReset);
        actionPanel.add(btnCetakStruk);
        card.add(actionPanel);

        mainPanel.add(card);
        add(mainPanel, BorderLayout.CENTER);

        // Event Listeners
        btnCari.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                cariKendaraan();
            }
        });

        txtKeyword.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                cariKendaraan();
            }
        });

        btnSimpan.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                prosesKeluar();
            }
        });

        btnReset.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                resetForm();
            }
        });

        btnCetakStruk.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                tampilkanPreviewStruk();
            }
        });
    }

    private JTextField createReadOnlyField(JPanel parent, String label) {
        parent.add(new JLabel(label));
        parent.add(Box.createRigidArea(new Dimension(0, 3)));
        JTextField field = new JTextField();
        field.setEditable(false);
        field.setMaximumSize(new Dimension(450, 26));
        field.setAlignmentX(Component.LEFT_ALIGNMENT);
        parent.add(field);
        parent.add(Box.createRigidArea(new Dimension(0, 8)));
        return field;
    }

    // Fungsi ini digunakan untuk mencari kendaraan aktif dan mengkalkulasikan billing parkir secara realtime
    private void cariKendaraan() {
        String keyword = txtKeyword.getText().trim().toUpperCase();
        if (keyword.isEmpty()) {
            MessageHelper.showWarning(this, "Masukkan Plat Nomor / Kode Karcis terlebih dahulu!");
            return;
        }

        activeTrx = transaksiDAO.findTransaksiAktif(keyword);
        if (activeTrx != null) {
            txtPlat.setText(activeTrx.getPlatNomor());
            txtJenis.setText(activeTrx.getJenisKendaraan().toUpperCase());
            txtLantaiSlot.setText(activeTrx.getNamaLantai() + " - " + activeTrx.getKodeSlot());
            txtWaktuMasuk.setText(DateHelper.toDisplayString(activeTrx.getWaktuMasuk()));

            // Hitung durasi dan biaya secara dinamis
            Date keluarDate = new Date();
            txtWaktuKeluar.setText(DateHelper.toDisplayString(keluarDate));

            int durasi = DateHelper.hitungDurasiJam(activeTrx.getWaktuMasuk(), keluarDate);
            txtDurasi.setText(durasi + " Jam");

            // Aturan Tarif: Motor = Rp 2000, Mobil = Rp 5000 per jam
            int tarifPerJam = activeTrx.getJenisKendaraan().equalsIgnoreCase("mobil") ? 5000 : 2000;
            int totalBayar = durasi * tarifPerJam;
            
            txtBiaya.setText(rpFormat.format(totalBayar));

            btnSimpan.setEnabled(true);
            btnCetakStruk.setEnabled(false); // Enable after checkout
        } else {
            MessageHelper.showError(this, "Kendaraan tidak ditemukan atau sudah Checkout!");
            resetForm();
        }
    }

    // Fungsi ini digunakan untuk mengatur ulang isian form
    private void resetForm() {
        txtKeyword.setText("");
        txtPlat.setText("");
        txtJenis.setText("");
        txtLantaiSlot.setText("");
        txtWaktuMasuk.setText("");
        txtWaktuKeluar.setText("");
        txtDurasi.setText("");
        txtBiaya.setText("");
        btnSimpan.setEnabled(false);
        btnCetakStruk.setEnabled(false);
        activeTrx = null;
        lastPrintedStruk = "";
    }

    // Fungsi ini digunakan untuk memproses billing kendaraan keluar dan membebaskan kembali slot parkir secara transaksional
    private void prosesKeluar() {
        if (activeTrx == null) return;

        Date waktuKeluar = new Date();
        int durasi = DateHelper.hitungDurasiJam(activeTrx.getWaktuMasuk(), waktuKeluar);
        int tarifPerJam = activeTrx.getJenisKendaraan().equalsIgnoreCase("mobil") ? 5000 : 2000;
        int totalBayar = durasi * tarifPerJam;

        // Lakukan update checkout database
        boolean success = transaksiDAO.checkoutTransaksi(
            activeTrx.getIdTransaksi(),
            activeTrx.getIdKendaraan(),
            activeTrx.getKodeSlot() != null ? getSlotIdFromTrx(activeTrx) : null,
            activeTrx.getIdBooking(),
            waktuKeluar,
            durasi,
            totalBayar
        );

        if (success) {
            MessageHelper.showInfo(this, "Checkout Berhasil! Pembayaran selesai.");

            // Siapkan text struk
            StringBuilder strukText = new StringBuilder();
            strukText.append("==========================================\n");
            strukText.append("              PARKING MALL                \n");
            strukText.append("          STRUK PEMBAYARAN PARKIR         \n");
            strukText.append("==========================================\n");
            strukText.append("Kode Transaksi : ").append(activeTrx.getKodeTransaksi()).append("\n");
            if (activeTrx.getKodeBooking() != null) {
                strukText.append("Kode Booking   : ").append(activeTrx.getKodeBooking()).append("\n");
            }
            strukText.append("Plat Nomor     : ").append(activeTrx.getPlatNomor()).append("\n");
            strukText.append("Jenis          : ").append(activeTrx.getJenisKendaraan().toUpperCase()).append("\n");
            strukText.append("Lantai / Slot  : ").append(activeTrx.getNamaLantai()).append(" / ").append(activeTrx.getKodeSlot()).append("\n");
            strukText.append("Waktu Masuk    : ").append(DateHelper.toDisplayString(activeTrx.getWaktuMasuk())).append("\n");
            strukText.append("Waktu Keluar   : ").append(DateHelper.toDisplayString(waktuKeluar)).append("\n");
            strukText.append("Durasi Parkir  : ").append(durasi).append(" Jam\n");
            strukText.append("------------------------------------------\n");
            strukText.append("TOTAL BAYAR    : ").append(rpFormat.format(totalBayar)).append("\n");
            strukText.append("==========================================\n");
            strukText.append("      Terima Kasih Atas Kunjungan Anda    \n");
            strukText.append("==========================================\n");

            lastPrintedStruk = strukText.toString();
            btnCetakStruk.setEnabled(true);
            btnSimpan.setEnabled(false); // disable checkout again
            
            // Clear input keyword
            txtKeyword.setText("");
        } else {
            MessageHelper.showError(this, "Gagal memproses Checkout!");
        }
    }

    // Helper untuk mencari ID slot dari data transaksi aktif
    private int getSlotIdFromTrx(Transaksi trx) {
        // Query slot id di db jika transient id_slot tidak tersimpan di transaksi, 
        // tapi di model Transaksi, activeTrx.getKodeSlot() & activeTrx.getNamaLantai() di-join.
        // Untuk amannya, kita bisa update slot_parkir berdasarkan kode_slot dan lantai di database.
        // Namun, kita sudah men-join id_slot di query `findTransaksiAktif` database ke kolom `k.id_slot`!
        // Mari kita periksa: "SELECT t.*, k.plat_nomor, k.jenis_kendaraan, k.id_slot, s.kode_slot ..."
        // Ya! Kolom k.id_slot diset ke id_slot.
        // Di method findTransaksiAktif:
        // `rs.getInt("id_slot")` ? Oh, wait:
        // "rs.getObject("id_slot") != null ? rs.getInt("id_slot") : null" 
        // Wait, did we query it and bind it in Transaksi? Let's check Transaksi.java:
        // In Transaksi.java, we have `idKendaraan` and `idBooking`. But do we have a transient slot ID?
        // Let's check the code: we did NOT add idSlot in Transaksi.
        // Ah, let's see. If we don't have it, we can query it, or update it by joining on idKendaraan's slot!
        // Wait, let's look at `checkoutTransaksi`:
        // "boolean kendaraanUpdated = kendaraanDAO.updateKendaraanKeluar(idKendaraan, idSlot != null ? idSlot : 0, waktuKeluar);"
        // Inside `kendaraanDAO.updateKendaraanKeluar`:
        // "if (idSlot > 0) { boolean slotUpdated = slotDAO.updateStatusSlot(idSlot, 'tersedia'); ... }"
        // So we need the actual idSlot.
        // Wait, does Kendaraan have idSlot? Yes, Kendaraan model has `idSlot`.
        // Let's check `activeTrx`. The activeTrx has `idKendaraan`. We can load the `idSlot` of that vehicle!
        // Or in `findTransaksiAktif` we query `k.id_slot` which is the ID of the slot!
        // Wait, does the model `Transaksi` have a field where we store it?
        // Let's check: in `findTransaksiAktif` query, we selected `k.id_slot` but did we store it anywhere?
        // Let's check `TransaksiDAO.java` line 52:
        // We selected `k.id_slot`, but did we assign it? No! We assigned:
        // rs.getInt("id_transaksi"), rs.getString("kode_transaksi"), rs.getInt("id_kendaraan"), rs.getInt("id_booking"), waktu_masuk, waktu_keluar, etc.
        // We did not store `idSlot` in the Transaksi class.
        // Wait, is there a way to get it?
        // Yes, we can fetch the slot ID of the vehicle using the idKendaraan, or we can look it up in the database!
        // Let's check if we can query it directly in `checkoutTransaksi` or if we can query it here.
        // Let's look at `checkoutTransaksi` implementation in `TransaksiDAO.java`:
        // It takes `Integer idSlot`. If we pass null or 0, we can fetch it inside `checkoutTransaksi` using `idKendaraan`!
        // Let's check `TransaksiDAO.java` `checkoutTransaksi` signature:
        // `public boolean checkoutTransaksi(int idTransaksi, int idKendaraan, Integer idSlot, Integer idBooking, Date waktuKeluar, int durasiJam, int totalBayar)`
        // If we query `idSlot` from `kendaraan` where `id_kendaraan = idKendaraan` inside `checkoutTransaksi`, it would be extremely bulletproof!
        // Let's see: we can look up the slot ID dynamically in `checkoutTransaksi` if `idSlot` is null/0.
        // Let's check: does `KendaraanDAO` have a method?
        // Wait! In `KendaraanDAO.java` `updateKendaraanKeluar` we have:
        // `public boolean updateKendaraanKeluar(int idKendaraan, int idSlot, java.util.Date waktuKeluar)`
        // Wait, in `updateKendaraanKeluar`, if `idSlot == 0`, we can query the slot associated with this vehicle before updating!
        // Let's verify what we wrote in `updateKendaraanKeluar` of `KendaraanDAO.java`:
        // ```java
        //         // 2. Kembalikan status slot menjadi 'tersedia' jika ada slot
        //         if (idSlot > 0) {
        //             boolean slotUpdated = slotDAO.updateStatusSlot(idSlot, "tersedia");
        // ...
        // ```
        // Yes! If `idSlot == 0`, it does not free the slot.
        // How can we get the `idSlot`? We can query it in `getSlotIdFromTrx`!
        // Let's write `getSlotIdFromTrx` in `KendaraanKeluarForm.java`:
        // We can query: `SELECT id_slot FROM kendaraan WHERE id_kendaraan = ?`
        // Or even simpler: in `TransaksiDAO.java`, we can modify `findTransaksiAktif` to set a transient field, or just query it in `getSlotIdFromTrx`.
        // Let's write a quick database query in `getSlotIdFromTrx`! That is very simple and local.
        // Wait, let's write `getSlotIdFromTrx` using a database query:
        // ```java
        // private int getSlotIdFromTrx(Transaksi trx) {
        //     int idSlot = 0;
        //     String sql = "SELECT id_slot FROM kendaraan WHERE id_kendaraan = ?";
        //     try (PreparedStatement ps = parkingmall.config.DatabaseConnection.getConnection().prepareStatement(sql)) {
        //         ps.setInt(1, trx.getIdKendaraan());
        //         try (ResultSet rs = ps.executeQuery()) {
        //             if (rs.next()) {
        //                 idSlot = rs.getInt("id_slot");
        //             }
        //         }
        //     } catch (Exception e) {
        //         e.printStackTrace();
        //     }
        //     return idSlot;
        // }
        // ```
        // This is extremely simple, direct, and completely fixes the issue! Let's do exactly this.

        int idSlot = 0;
        String sql = "SELECT id_slot FROM kendaraan WHERE id_kendaraan = ?";
        try (PreparedStatement ps = parkingmall.config.DatabaseConnection.getConnection().prepareStatement(sql)) {
            ps.setInt(1, trx.getIdKendaraan());
            try (ResultSet rs = ps.executeQuery()) {
                if (rs.next()) {
                    idSlot = rs.getInt("id_slot");
                }
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return idSlot;
    }

    // Fungsi ini digunakan untuk menampilkan dialog pratinjau struk dengan opsi cetak fisik/PDF
    private void tampilkanPreviewStruk() {
        if (lastPrintedStruk.isEmpty()) return;

        JTextArea textArea = new JTextArea(lastPrintedStruk);
        textArea.setFont(new Font("Monospaced", Font.PLAIN, 12));
        textArea.setEditable(false);
        JScrollPane scrollPane = new JScrollPane(textArea);
        scrollPane.setPreferredSize(new Dimension(350, 320));

        Object[] options = {"Cetak ke Printer / PDF", "Tutup"};
        int result = JOptionPane.showOptionDialog(
            this, 
            scrollPane, 
            "Struk Pembayaran Parkir", 
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
