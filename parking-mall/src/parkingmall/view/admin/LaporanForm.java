package parkingmall.view.admin;

import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.text.NumberFormat;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.List;
import java.util.Locale;
import javax.swing.*;
import javax.swing.border.EmptyBorder;
import javax.swing.table.DefaultTableModel;
import parkingmall.dao.TransaksiDAO;
import parkingmall.helper.DateHelper;
import parkingmall.helper.MessageHelper;
import parkingmall.helper.UIHelper;
import parkingmall.model.Transaksi;

public class LaporanForm extends JPanel {
    private final TransaksiDAO transaksiDAO;
    
    private final JTable table;
    private final DefaultTableModel tableModel;
    
    private final JTextField txtTglMulai;
    private final JTextField txtTglSelesai;
    private final JComboBox<String> cbJenis;
    
    private final JButton btnFilter;
    private final JButton btnReset;
    private final JButton btnCetak;
    private final JButton btnCetakTabel;
    
    private final JLabel lblTotalKendaraan;
    private final JLabel lblTotalPendapatan;
    
    private final NumberFormat rpFormat = NumberFormat.getCurrencyInstance(new Locale("id", "ID"));

    public LaporanForm() {
        this.transaksiDAO = new TransaksiDAO();
        
        setLayout(new BorderLayout(15, 15));
        setBackground(Color.decode("#85C1E9"));
        setBorder(new EmptyBorder(15, 15, 15, 15));

        // TITLE
        JLabel lblTitle = new JLabel("Laporan Transaksi Parkir");
        lblTitle.setFont(new Font("Segoe UI", Font.BOLD, 22));
        lblTitle.setForeground(Color.decode("#0F2742"));
        add(lblTitle, BorderLayout.NORTH);

        // FILTER PANEL (TOP)
        JPanel filterPanel = new JPanel(new FlowLayout(FlowLayout.LEFT, 15, 10));
        filterPanel.setBackground(Color.WHITE);
        filterPanel.setBorder(BorderFactory.createLineBorder(Color.LIGHT_GRAY));

        // Date format helper string
        SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd");
        String todayStr = sdf.format(new Date());

        filterPanel.add(new JLabel("Mulai Tanggal (YYYY-MM-DD):"));
        txtTglMulai = new JTextField(todayStr, 10);
        filterPanel.add(txtTglMulai);

        filterPanel.add(new JLabel("Sampai Tanggal (YYYY-MM-DD):"));
        txtTglSelesai = new JTextField(todayStr, 10);
        filterPanel.add(txtTglSelesai);

        filterPanel.add(new JLabel("Jenis Kendaraan:"));
        cbJenis = new JComboBox<>(new String[]{"Semua", "Motor", "Mobil"});
        filterPanel.add(cbJenis);

        btnFilter = new JButton("Filter");
        UIHelper.styleButton(btnFilter, Color.decode("#1E88E5"), Color.WHITE);
        filterPanel.add(btnFilter);
 
        btnReset = new JButton("Reset");
        UIHelper.styleButton(btnReset, Color.GRAY, Color.WHITE);
        filterPanel.add(btnReset);
 
        btnCetak = new JButton("Preview Struk Pilihan");
        UIHelper.styleButton(btnCetak, Color.decode("#0F2742"), Color.WHITE);
        btnCetak.setEnabled(false);
        filterPanel.add(btnCetak);

        btnCetakTabel = new JButton("Cetak Tabel Laporan");
        UIHelper.styleButton(btnCetakTabel, Color.decode("#2E7D32"), Color.WHITE);
        filterPanel.add(btnCetakTabel);

        add(filterPanel, BorderLayout.NORTH);

        // TABLE PANEL (CENTER)
        JPanel tablePanel = new JPanel(new BorderLayout());
        tablePanel.setBackground(Color.WHITE);
        tablePanel.setBorder(BorderFactory.createCompoundBorder(
            BorderFactory.createLineBorder(Color.LIGHT_GRAY),
            new EmptyBorder(10, 10, 10, 10)
        ));

        String[] columns = {
            "Kode Transaksi", "Plat Nomor", "Jenis", "Lantai", "Slot", 
            "Kode Booking", "Waktu Masuk", "Waktu Keluar", "Durasi (Jam)", "Total Bayar"
        };
        tableModel = new DefaultTableModel(columns, 0) {
            @Override
            public boolean isCellEditable(int row, int column) {
                return false;
            }
        };
        table = new JTable(tableModel);
        table.setSelectionMode(ListSelectionModel.SINGLE_SELECTION);
        table.setRowHeight(25);
        
        table.getSelectionModel().addListSelectionListener(new javax.swing.event.ListSelectionListener() {
            @Override
            public void valueChanged(javax.swing.event.ListSelectionEvent e) {
                btnCetak.setEnabled(table.getSelectedRow() != -1);
            }
        });
        
        JScrollPane scrollTable = new JScrollPane(table);
        tablePanel.add(scrollTable, BorderLayout.CENTER);

        add(tablePanel, BorderLayout.CENTER);

        // STATS SUMMARY PANEL (BOTTOM)
        JPanel summaryPanel = new JPanel(new GridLayout(1, 2, 20, 0));
        summaryPanel.setBackground(Color.decode("#0F2742"));
        summaryPanel.setBorder(new EmptyBorder(15, 20, 15, 20));

        lblTotalKendaraan = new JLabel("Total Kendaraan Keluar: 0");
        lblTotalKendaraan.setFont(new Font("Segoe UI", Font.BOLD, 16));
        lblTotalKendaraan.setForeground(Color.WHITE);

        lblTotalPendapatan = new JLabel("Total Pendapatan: Rp 0");
        lblTotalPendapatan.setFont(new Font("Segoe UI", Font.BOLD, 16));
        lblTotalPendapatan.setForeground(Color.WHITE);
        lblTotalPendapatan.setHorizontalAlignment(SwingConstants.RIGHT);

        summaryPanel.add(lblTotalKendaraan);
        summaryPanel.add(lblTotalPendapatan);

        add(summaryPanel, BorderLayout.SOUTH);

        // Event Listeners
        btnFilter.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                tampilkanLaporan();
            }
        });

        btnReset.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                txtTglMulai.setText(todayStr);
                txtTglSelesai.setText(todayStr);
                cbJenis.setSelectedIndex(0);
                tampilkanLaporan();
            }
        });

        btnCetak.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                previewStrukPilihan();
            }
        });

        btnCetakTabel.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                cetakTabelLaporan();
            }
        });

        // Load data awal
        tampilkanLaporan();
    }

    // Fungsi ini digunakan untuk menampilkan data laporan parkir ke tabel berdasarkan filter
    private void tampilkanLaporan() {
        String tglMulai = txtTglMulai.getText().trim();
        String tglSelesai = txtTglSelesai.getText().trim();
        String jenis = (String) cbJenis.getSelectedItem();

        // Validasi format tanggal sederhana
        if (!tglMulai.isEmpty() && !tglMulai.matches("\\d{4}-\\d{2}-\\d{2}")) {
            MessageHelper.showError(this, "Format Tanggal Mulai tidak valid! Gunakan YYYY-MM-DD.");
            return;
        }
        if (!tglSelesai.isEmpty() && !tglSelesai.matches("\\d{4}-\\d{2}-\\d{2}")) {
            MessageHelper.showError(this, "Format Tanggal Selesai tidak valid! Gunakan YYYY-MM-DD.");
            return;
        }

        tableModel.setRowCount(0);
        List<Transaksi> list = transaksiDAO.getLaporanParkir(tglMulai, tglSelesai, jenis);
        
        int totalKendaraan = 0;
        int totalPendapatan = 0;

        for (Transaksi t : list) {
            totalKendaraan++;
            totalPendapatan += t.getTotalBayar();

            tableModel.addRow(new Object[]{
                t.getKodeTransaksi(),
                t.getPlatNomor(),
                t.getJenisKendaraan().toUpperCase(),
                t.getNamaLantai() != null ? t.getNamaLantai() : "-",
                t.getKodeSlot() != null ? t.getKodeSlot() : "-",
                t.getKodeBooking() != null ? t.getKodeBooking() : "-",
                DateHelper.toDisplayString(t.getWaktuMasuk()),
                DateHelper.toDisplayString(t.getWaktuKeluar()),
                t.getDurasiJam() + " Jam",
                rpFormat.format(t.getTotalBayar())
            });
        }

        lblTotalKendaraan.setText("Total Kendaraan Keluar: " + totalKendaraan);
        lblTotalPendapatan.setText("Total Pendapatan: " + rpFormat.format(totalPendapatan));
    }

    // Fungsi ini digunakan untuk menampilkan struk parkir sederhana dari baris transaksi yang dipilih
    private void previewStrukPilihan() {
        int row = table.getSelectedRow();
        if (row == -1) {
            MessageHelper.showWarning(this, "Pilih satu transaksi di tabel terlebih dahulu!");
            return;
        }

        String kodeTrx = (String) tableModel.getValueAt(row, 0);
        String plat = (String) tableModel.getValueAt(row, 1);
        String jenis = (String) tableModel.getValueAt(row, 2);
        String lantai = (String) tableModel.getValueAt(row, 3);
        String slot = (String) tableModel.getValueAt(row, 4);
        String booking = (String) tableModel.getValueAt(row, 5);
        String masuk = (String) tableModel.getValueAt(row, 6);
        String keluar = (String) tableModel.getValueAt(row, 7);
        String durasi = (String) tableModel.getValueAt(row, 8);
        String bayar = (String) tableModel.getValueAt(row, 9);

        // Buat String struk
        StringBuilder receipt = new StringBuilder();
        receipt.append("==========================================\n");
        receipt.append("              PARKING MALL                \n");
        receipt.append("          STRUK TRANSAKSI PARKIR          \n");
        receipt.append("==========================================\n");
        receipt.append("Kode Transaksi : ").append(kodeTrx).append("\n");
        if (!booking.equals("-")) {
            receipt.append("Kode Booking   : ").append(booking).append("\n");
        }
        receipt.append("Plat Nomor     : ").append(plat).append("\n");
        receipt.append("Jenis Kendaraan: ").append(jenis).append("\n");
        receipt.append("Lantai / Slot  : ").append(lantai).append(" / ").append(slot).append("\n");
        receipt.append("Waktu Masuk    : ").append(masuk).append("\n");
        receipt.append("Waktu Keluar   : ").append(keluar).append("\n");
        receipt.append("Durasi Parkir  : ").append(durasi).append("\n");
        receipt.append("------------------------------------------\n");
        receipt.append("TOTAL BAYAR    : ").append(bayar).append("\n");
        receipt.append("==========================================\n");
        receipt.append("      Terima Kasih Atas Kunjungan Anda    \n");
        receipt.append("==========================================\n");

        JTextArea textArea = new JTextArea(receipt.toString());
        textArea.setFont(new Font("Monospaced", Font.PLAIN, 12));
        textArea.setEditable(false);
        JScrollPane scrollPane = new JScrollPane(textArea);
        scrollPane.setPreferredSize(new Dimension(350, 320));

        Object[] options = {"Cetak ke Printer / PDF", "Tutup"};
        int result = JOptionPane.showOptionDialog(
            this, 
            scrollPane, 
            "Preview Struk Karcis", 
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
                    MessageHelper.showInfo(this, "Pencetakan struk selesai!");
                } else {
                    MessageHelper.showInfo(this, "Pencetakan struk dibatalkan.");
                }
            } catch (java.awt.print.PrinterException ex) {
                MessageHelper.showError(this, "Gagal mencetak struk: " + ex.getMessage());
            }
        }
    }

    // Fungsi ini digunakan untuk mencetak seluruh tabel laporan ke printer fisik atau PDF
    private void cetakTabelLaporan() {
        try {
            java.text.MessageFormat header = new java.text.MessageFormat("Laporan Transaksi Parkir - Parking Mall");
            java.text.MessageFormat footer = new java.text.MessageFormat("Halaman {0}");
            boolean complete = table.print(JTable.PrintMode.FIT_WIDTH, header, footer);
            if (complete) {
                MessageHelper.showInfo(this, "Pencetakan laporan selesai!");
            } else {
                MessageHelper.showInfo(this, "Pencetakan laporan dibatalkan.");
            }
        } catch (java.awt.print.PrinterException ex) {
            MessageHelper.showError(this, "Gagal mencetak laporan: " + ex.getMessage());
        }
    }
}
