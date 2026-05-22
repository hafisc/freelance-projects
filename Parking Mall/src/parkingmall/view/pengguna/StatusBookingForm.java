package parkingmall.view.pengguna;

import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.util.List;
import javax.swing.*;
import javax.swing.border.EmptyBorder;
import javax.swing.table.DefaultTableModel;
import parkingmall.dao.BookingDAO;
import parkingmall.helper.DateHelper;
import parkingmall.helper.MessageHelper;
import parkingmall.model.Booking;
import parkingmall.model.User;

public class StatusBookingForm extends JPanel {
    private final User currentUser;
    private final BookingDAO bookingDAO;
    
    private final JTable table;
    private final DefaultTableModel tableModel;
    
    private final JButton btnBatalkan;
    private final JButton btnCetak;
    private final JButton btnRefresh;

    public StatusBookingForm(User user) {
        this.currentUser = user;
        this.bookingDAO = new BookingDAO();
        
        setLayout(new BorderLayout(15, 15));
        setBackground(Color.decode("#85C1E9"));
        setBorder(new EmptyBorder(15, 15, 15, 15));

        // TITLE
        JLabel lblTitle = new JLabel("Status & Riwayat Booking Parkir");
        lblTitle.setFont(new Font("Segoe UI", Font.BOLD, 22));
        lblTitle.setForeground(Color.decode("#0F2742"));
        add(lblTitle, BorderLayout.NORTH);

        // TABLE PANEL
        JPanel tablePanel = new JPanel(new BorderLayout());
        tablePanel.setBackground(Color.WHITE);
        tablePanel.setBorder(BorderFactory.createCompoundBorder(
            BorderFactory.createLineBorder(Color.LIGHT_GRAY),
            new EmptyBorder(10, 10, 10, 10)
        ));

        String[] columns = {"ID Booking", "Kode Booking", "Plat Nomor", "Jenis", "Lantai / Slot", "Waktu Booking", "Status", "ID Slot"};
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
                boolean hasSelection = table.getSelectedRow() != -1;
                btnCetak.setEnabled(hasSelection);
                btnBatalkan.setEnabled(hasSelection);
            }
        });
        
        // Hide ID columns
        // table.getColumnModel().removeColumn(table.getColumnModel().getColumn(7));
        // table.getColumnModel().removeColumn(table.getColumnModel().getColumn(0));

        JScrollPane scrollTable = new JScrollPane(table);
        tablePanel.add(scrollTable, BorderLayout.CENTER);

        add(tablePanel, BorderLayout.CENTER);

        // BOTTOM CONTROLS
        JPanel controlPanel = new JPanel(new FlowLayout(FlowLayout.LEFT, 10, 0));
        controlPanel.setBackground(Color.decode("#85C1E9"));

        btnRefresh = new JButton("Refresh");
        parkingmall.helper.UIHelper.styleButton(btnRefresh, Color.decode("#0F2742"), Color.WHITE);

        btnCetak = new JButton("Preview Karcis Booking");
        parkingmall.helper.UIHelper.styleButton(btnCetak, Color.decode("#1E88E5"), Color.WHITE);
        btnCetak.setEnabled(false);

        btnBatalkan = new JButton("Batalkan Booking");
        parkingmall.helper.UIHelper.styleButton(btnBatalkan, Color.decode("#C62828"), Color.WHITE);
        btnBatalkan.setEnabled(false);

        controlPanel.add(btnRefresh);
        controlPanel.add(btnCetak);
        controlPanel.add(btnBatalkan);
        add(controlPanel, BorderLayout.SOUTH);

        // Events
        btnRefresh.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                tampilkanBooking();
            }
        });

        btnCetak.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                previewKarcisBooking();
            }
        });

        btnBatalkan.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                batalkanBooking();
            }
        });

        // Load data awal
        tampilkanBooking();
    }

    // Fungsi ini digunakan untuk mengambil riwayat booking milik pengguna aktif
    public void tampilkanBooking() {
        tableModel.setRowCount(0);
        List<Booking> list = bookingDAO.getBookingByUser(currentUser.getIdUser());
        for (Booking b : list) {
            tableModel.addRow(new Object[]{
                b.getIdBooking(),
                b.getKodeBooking(),
                b.getPlatNomor(),
                b.getJenisKendaraan().toUpperCase(),
                b.getNamaLantai() + " - " + b.getKodeSlot(),
                DateHelper.toDisplayString(b.getWaktuBooking()),
                b.getStatus().toUpperCase(),
                b.getIdSlot()
            });
        }
    }

    // Fungsi ini menampilkan struk pratinjau bukti booking yang dapat ditunjukkan ke petugas
    private void previewKarcisBooking() {
        int row = table.getSelectedRow();
        if (row == -1) {
            MessageHelper.showWarning(this, "Pilih salah satu baris booking terlebih dahulu!");
            return;
        }

        String kode = (String) tableModel.getValueAt(row, 1);
        String plat = (String) tableModel.getValueAt(row, 2);
        String jenis = (String) tableModel.getValueAt(row, 3);
        String lantaiSlot = (String) tableModel.getValueAt(row, 4);
        String waktu = (String) tableModel.getValueAt(row, 5);
        String status = (String) tableModel.getValueAt(row, 6);

        StringBuilder receipt = new StringBuilder();
        receipt.append("==========================================\n");
        receipt.append("              PARKING MALL                \n");
        receipt.append("           BUKTI BOOKING PARKIR           \n");
        receipt.append("==========================================\n");
        receipt.append("KODE BOOKING  : ").append(kode).append("\n");
        receipt.append("Nama Pelanggan: ").append(currentUser.getNama()).append("\n");
        receipt.append("Plat Nomor    : ").append(plat).append("\n");
        receipt.append("Jenis         : ").append(jenis).append("\n");
        receipt.append("Lantai / Slot : ").append(lantaiSlot).append("\n");
        receipt.append("Waktu Booking : ").append(waktu).append("\n");
        receipt.append("------------------------------------------\n");
        receipt.append("Status        : ").append(status).append("\n");
        receipt.append("==========================================\n");
        if (status.equalsIgnoreCase("menunggu")) {
            receipt.append(" Tunjukkan kode booking ini kepada petugas  \n");
            receipt.append("       saat Anda tiba di pintu masuk.     \n");
        } else if (status.equalsIgnoreCase("diverifikasi")) {
            receipt.append("  Sudah Diverifikasi. Kendaraan di lokasi.  \n");
        } else {
            receipt.append("              Selesai / Batal             \n");
        }
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
            "Detail Booking", 
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

    // Fungsi ini digunakan oleh pengguna untuk membatalkan booking yang masih berstatus 'menunggu'
    private void batalkanBooking() {
        int row = table.getSelectedRow();
        if (row == -1) {
            MessageHelper.showWarning(this, "Pilih baris booking yang ingin dibatalkan!");
            return;
        }

        String status = (String) tableModel.getValueAt(row, 6);
        if (!status.equalsIgnoreCase("menunggu")) {
            MessageHelper.showError(this, "Hanya booking berstatus 'MENUNGGU' yang dapat dibatalkan!");
            return;
        }

        int idBooking = (int) tableModel.getValueAt(row, 0);
        int idSlot = (int) tableModel.getValueAt(row, 7);
        String kode = (String) tableModel.getValueAt(row, 1);

        boolean konfirmasi = MessageHelper.showConfirm(this, "Apakah Anda yakin ingin membatalkan booking " + kode + "?");
        if (konfirmasi) {
            if (bookingDAO.batalkanBooking(idBooking, idSlot)) {
                MessageHelper.showInfo(this, "Booking berhasil dibatalkan!");
                tampilkanBooking();
            } else {
                MessageHelper.showError(this, "Gagal membatalkan booking!");
            }
        }
    }
}
