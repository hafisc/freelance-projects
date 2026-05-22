package parkingmall.view.petugas;

import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.MouseAdapter;
import java.awt.event.MouseEvent;
import java.util.List;
import javax.swing.*;
import javax.swing.border.EmptyBorder;
import javax.swing.table.DefaultTableModel;
import parkingmall.dao.BookingDAO;
import parkingmall.helper.DateHelper;
import parkingmall.helper.KodeGenerator;
import parkingmall.helper.MessageHelper;
import parkingmall.model.Booking;

public class VerifikasiBookingForm extends JPanel {
    private final BookingDAO bookingDAO;
    
    private final JTextField txtSearch;
    private final JButton btnCari;
    
    private final JTable table;
    private final DefaultTableModel tableModel;
    
    private final JTextField txtKode;
    private final JTextField txtNama;
    private final JTextField txtPlat;
    private final JTextField txtJenis;
    private final JTextField txtSlot;
    private final JTextField txtWaktu;
    
    private final JButton btnVerifikasi;
    private final JButton btnBatalkan;
    private final JButton btnCetakKarcis;
    private final JButton btnReset;
    
    private Booking selectedBooking = null;
    private String lastPrintedKarcis = "";

    public VerifikasiBookingForm() {
        this.bookingDAO = new BookingDAO();
        
        setLayout(new BorderLayout(15, 15));
        setBackground(Color.decode("#85C1E9"));
        setBorder(new EmptyBorder(15, 15, 15, 15));

        // TITLE
        JLabel lblTitle = new JLabel("Verifikasi Booking Parkir Pengguna");
        lblTitle.setFont(new Font("Segoe UI", Font.BOLD, 22));
        lblTitle.setForeground(Color.decode("#0F2742"));
        add(lblTitle, BorderLayout.NORTH);

        // LEFT PANEL (SEARCH & DETAILS)
        JPanel leftPanel = new JPanel();
        leftPanel.setLayout(new BoxLayout(leftPanel, BoxLayout.Y_AXIS));
        leftPanel.setBackground(Color.WHITE);
        leftPanel.setBorder(BorderFactory.createCompoundBorder(
            BorderFactory.createLineBorder(Color.LIGHT_GRAY),
            new EmptyBorder(15, 15, 15, 15)
        ));
        leftPanel.setPreferredSize(new Dimension(320, 0));

        // Search
        JPanel searchBar = new JPanel(new BorderLayout(5, 0));
        searchBar.setBackground(Color.WHITE);
        searchBar.setMaximumSize(new Dimension(290, 30));
        searchBar.setAlignmentX(Component.LEFT_ALIGNMENT);
        
        txtSearch = new JTextField();
        searchBar.add(txtSearch, BorderLayout.CENTER);
        
        btnCari = new JButton("Cari");
        parkingmall.helper.UIHelper.styleButton(btnCari, Color.decode("#0F2742"), Color.WHITE);
        searchBar.add(btnCari, BorderLayout.EAST);
        
        leftPanel.add(new JLabel("Cari Kode Booking:"));
        leftPanel.add(Box.createRigidArea(new Dimension(0, 5)));
        leftPanel.add(searchBar);
        leftPanel.add(Box.createRigidArea(new Dimension(0, 15)));

        // Details
        txtKode = createReadOnlyField(leftPanel, "Kode Booking:");
        txtNama = createReadOnlyField(leftPanel, "Nama Pengguna:");
        txtPlat = createReadOnlyField(leftPanel, "Plat Nomor:");
        txtJenis = createReadOnlyField(leftPanel, "Jenis Kendaraan:");
        txtSlot = createReadOnlyField(leftPanel, "Lantai / Slot:");
        txtWaktu = createReadOnlyField(leftPanel, "Waktu Booking:");

        leftPanel.add(Box.createRigidArea(new Dimension(0, 15)));

        // Buttons
        JPanel actionPanel = new JPanel(new GridLayout(2, 2, 5, 5));
        actionPanel.setBackground(Color.WHITE);
        actionPanel.setMaximumSize(new Dimension(290, 70));
        actionPanel.setAlignmentX(Component.LEFT_ALIGNMENT);

        btnVerifikasi = new JButton("Verifikasi");
        parkingmall.helper.UIHelper.styleButton(btnVerifikasi, Color.decode("#2E7D32"), Color.WHITE);
        btnVerifikasi.setEnabled(false);

        btnBatalkan = new JButton("Batalkan");
        parkingmall.helper.UIHelper.styleButton(btnBatalkan, Color.decode("#C62828"), Color.WHITE);
        btnBatalkan.setEnabled(false);

        btnCetakKarcis = new JButton("Preview Karcis");
        parkingmall.helper.UIHelper.styleButton(btnCetakKarcis, Color.decode("#0F2742"), Color.WHITE);
        btnCetakKarcis.setEnabled(false);

        btnReset = new JButton("Reset");
        parkingmall.helper.UIHelper.styleButton(btnReset, Color.GRAY, Color.WHITE);

        actionPanel.add(btnVerifikasi);
        actionPanel.add(btnBatalkan);
        actionPanel.add(btnCetakKarcis);
        actionPanel.add(btnReset);
        leftPanel.add(actionPanel);

        add(leftPanel, BorderLayout.WEST);

        // RIGHT PANEL (TABLE OF PENDING BOOKINGS)
        JPanel tablePanel = new JPanel(new BorderLayout());
        tablePanel.setBackground(Color.WHITE);
        tablePanel.setBorder(BorderFactory.createCompoundBorder(
            BorderFactory.createLineBorder(Color.LIGHT_GRAY),
            new EmptyBorder(10, 10, 10, 10)
        ));

        tablePanel.add(new JLabel("Daftar Booking Menunggu Verifikasi:"), BorderLayout.NORTH);
        
        String[] columns = {"Kode Booking", "Nama Pengguna", "Plat Nomor", "Jenis", "Slot", "Waktu Booking"};
        tableModel = new DefaultTableModel(columns, 0) {
            @Override
            public boolean isCellEditable(int row, int column) {
                return false;
            }
        };
        table = new JTable(tableModel);
        table.setSelectionMode(ListSelectionModel.SINGLE_SELECTION);
        table.setRowHeight(25);
        
        JScrollPane scrollTable = new JScrollPane(table);
        tablePanel.add(scrollTable, BorderLayout.CENTER);

        add(tablePanel, BorderLayout.CENTER);

        // Events
        table.addMouseListener(new MouseAdapter() {
            @Override
            public void mouseClicked(MouseEvent e) {
                int row = table.getSelectedRow();
                if (row != -1) {
                    String kode = (String) tableModel.getValueAt(row, 0);
                    cariDanSetBooking(kode);
                }
            }
        });

        btnCari.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                String kode = txtSearch.getText().trim();
                if (kode.isEmpty()) {
                    MessageHelper.showWarning(VerifikasiBookingForm.this, "Masukkan kode booking untuk dicari!");
                    return;
                }
                cariDanSetBooking(kode);
            }
        });

        btnVerifikasi.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                verifikasiKedatangan();
            }
        });

        btnBatalkan.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                batalkanBooking();
            }
        });

        btnCetakKarcis.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                tampilkanPreviewKarcis();
            }
        });

        btnReset.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                resetForm();
            }
        });

        // Load data awal
        refreshTable();
    }

    private JTextField createReadOnlyField(JPanel parent, String label) {
        parent.add(new JLabel(label));
        parent.add(Box.createRigidArea(new Dimension(0, 3)));
        JTextField field = new JTextField();
        field.setEditable(false);
        field.setMaximumSize(new Dimension(290, 26));
        field.setAlignmentX(Component.LEFT_ALIGNMENT);
        parent.add(field);
        parent.add(Box.createRigidArea(new Dimension(0, 5)));
        return field;
    }

    private void resetForm() {
        txtSearch.setText("");
        txtKode.setText("");
        txtNama.setText("");
        txtPlat.setText("");
        txtJenis.setText("");
        txtSlot.setText("");
        txtWaktu.setText("");
        
        btnVerifikasi.setEnabled(false);
        btnBatalkan.setEnabled(false);
        btnCetakKarcis.setEnabled(false);
        selectedBooking = null;
        lastPrintedKarcis = "";
        table.clearSelection();
    }

    // Fungsi ini digunakan untuk menyegarkan isi tabel booking yang berstatus 'menunggu'
    private void refreshTable() {
        tableModel.setRowCount(0);
        List<Booking> list = bookingDAO.getPendingBooking();
        for (Booking b : list) {
            tableModel.addRow(new Object[]{
                b.getKodeBooking(),
                b.getNamaPengguna(),
                b.getPlatNomor(),
                b.getJenisKendaraan().toUpperCase(),
                b.getNamaLantai() + " - " + b.getKodeSlot(),
                DateHelper.toDisplayString(b.getWaktuBooking())
            });
        }
    }

    // Fungsi ini mencari booking berdasarkan kode booking dan menampilkan detailnya di panel samping
    private void cariDanSetBooking(String kode) {
        selectedBooking = bookingDAO.findBookingByKode(kode);
        if (selectedBooking != null) {
            txtKode.setText(selectedBooking.getKodeBooking());
            txtNama.setText(selectedBooking.getNamaPengguna());
            txtPlat.setText(selectedBooking.getPlatNomor());
            txtJenis.setText(selectedBooking.getJenisKendaraan().toUpperCase());
            txtSlot.setText(selectedBooking.getNamaLantai() + " - " + selectedBooking.getKodeSlot());
            txtWaktu.setText(DateHelper.toDisplayString(selectedBooking.getWaktuBooking()));
            
            btnVerifikasi.setEnabled(true);
            btnBatalkan.setEnabled(true);
        } else {
            MessageHelper.showError(this, "Kode Booking '" + kode + "' tidak ditemukan atau sudah diproses!");
            resetForm();
        }
    }

    // Fungsi ini digunakan untuk memverifikasi kedatangan pengguna booking, mencatat check-in kendaraan, dan memulai billing
    private void verifikasiKedatangan() {
        if (selectedBooking == null) return;

        boolean konfirmasi = MessageHelper.showConfirm(this, "Apakah Anda yakin ingin memverifikasi booking " + selectedBooking.getKodeBooking() + "?");
        if (konfirmasi) {
            String kodeTransaksi = KodeGenerator.generateTransaksi();
            boolean success = bookingDAO.verifikasiBooking(
                selectedBooking.getIdBooking(),
                selectedBooking.getIdSlot(),
                selectedBooking.getPlatNomor(),
                selectedBooking.getJenisKendaraan(),
                kodeTransaksi
            );

            if (success) {
                MessageHelper.showInfo(this, "Booking berhasil diverifikasi! Kendaraan masuk dicatat.");
                
                // Siapkan String Karcis
                StringBuilder karcisText = new StringBuilder();
                karcisText.append("==========================================\n");
                karcisText.append("              PARKING MALL                \n");
                karcisText.append("             KARCIS PARKIR                \n");
                karcisText.append("             (VIA BOOKING)                \n");
                karcisText.append("==========================================\n");
                karcisText.append("Kode Karcis   : ").append(kodeTransaksi).append("\n");
                karcisText.append("Kode Booking  : ").append(selectedBooking.getKodeBooking()).append("\n");
                karcisText.append("Plat Nomor    : ").append(selectedBooking.getPlatNomor()).append("\n");
                karcisText.append("Jenis         : ").append(selectedBooking.getJenisKendaraan().toUpperCase()).append("\n");
                karcisText.append("Lantai / Slot : ").append(selectedBooking.getNamaLantai()).append(" / ").append(selectedBooking.getKodeSlot()).append("\n");
                karcisText.append("Waktu Masuk   : ").append(DateHelper.toDisplayString(new java.util.Date())).append("\n");
                karcisText.append("------------------------------------------\n");
                karcisText.append("Tarif Parkir  : \n");
                karcisText.append("- Mobil       : Rp 5.000 / Jam\n");
                karcisText.append("- Motor       : Rp 2.000 / Jam\n");
                karcisText.append("==========================================\n");
                karcisText.append("        SIMPAN KARCIS INI DENGAN BAIK     \n");
                karcisText.append("==========================================\n");
                
                resetForm();
                
                lastPrintedKarcis = karcisText.toString();
                btnCetakKarcis.setEnabled(true);
                
                refreshTable();
                
                // Tampilkan struk otomatis
                SwingUtilities.invokeLater(new Runnable() {
                    @Override
                    public void run() {
                        tampilkanPreviewKarcis();
                    }
                });
            } else {
                MessageHelper.showError(this, "Gagal memverifikasi booking!");
            }
        }
    }

    // Fungsi ini digunakan untuk membatalkan booking pengguna dan melepaskan kembali slot parkir yang sudah dibooking
    private void batalkanBooking() {
        if (selectedBooking == null) return;

        boolean konfirmasi = MessageHelper.showConfirm(this, "Apakah Anda yakin ingin membatalkan booking " + selectedBooking.getKodeBooking() + "?");
        if (konfirmasi) {
            boolean success = bookingDAO.batalkanBooking(
                selectedBooking.getIdBooking(),
                selectedBooking.getIdSlot()
            );

            if (success) {
                MessageHelper.showInfo(this, "Booking berhasil dibatalkan. Slot parkir kembali tersedia.");
                resetForm();
                refreshTable();
            } else {
                MessageHelper.showError(this, "Gagal membatalkan booking!");
            }
        }
    }

    // Fungsi ini digunakan untuk menampilkan dialog pratinjau karcis dengan opsi cetak fisik/PDF
    private void tampilkanPreviewKarcis() {
        if (lastPrintedKarcis.isEmpty()) return;

        JTextArea textArea = new JTextArea(lastPrintedKarcis);
        textArea.setFont(new Font("Monospaced", Font.PLAIN, 12));
        textArea.setEditable(false);
        JScrollPane scrollPane = new JScrollPane(textArea);
        scrollPane.setPreferredSize(new Dimension(350, 320));

        Object[] options = {"Cetak ke Printer / PDF", "Tutup"};
        int result = JOptionPane.showOptionDialog(
            this, 
            scrollPane, 
            "Karcis Parkir (Booking)", 
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
                    MessageHelper.showInfo(this, "Pencetakan karcis selesai!");
                } else {
                    MessageHelper.showInfo(this, "Pencetakan karcis dibatalkan.");
                }
            } catch (java.awt.print.PrinterException ex) {
                MessageHelper.showError(this, "Gagal mencetak karcis: " + ex.getMessage());
            }
        }
    }
}
