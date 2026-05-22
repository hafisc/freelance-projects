package parkingmall.view.admin;

import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.MouseAdapter;
import java.awt.event.MouseEvent;
import java.util.List;
import javax.swing.*;
import javax.swing.border.EmptyBorder;
import javax.swing.table.DefaultTableModel;
import parkingmall.dao.LantaiDAO;
import parkingmall.dao.SlotParkirDAO;
import parkingmall.helper.MessageHelper;
import parkingmall.helper.UIHelper;
import parkingmall.model.Lantai;
import parkingmall.model.SlotParkir;

public class SlotParkirForm extends JPanel {
    private final SlotParkirDAO slotDAO;
    private final LantaiDAO lantaiDAO;
    
    private final JTable table;
    private final DefaultTableModel tableModel;
    
    private final JComboBox<LantaiComboItem> cbLantai;
    private final JTextField txtKodeSlot;
    private final JComboBox<String> cbStatus;
    
    private final JButton btnSimpan;
    private final JButton btnUbah;
    private final JButton btnHapus;
    private final JButton btnReset;
    
    private int selectedSlotId = -1;

    // Helper class untuk JComboBox agar bisa menyimpan ID Lantai dan Nama Lantai
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

    public SlotParkirForm() {
        this.slotDAO = new SlotParkirDAO();
        this.lantaiDAO = new LantaiDAO();
        
        setLayout(new BorderLayout(15, 15));
        setBackground(Color.decode("#85C1E9"));
        setBorder(new EmptyBorder(15, 15, 15, 15));

        // TITLE
        JLabel lblTitle = new JLabel("Kelola Slot Parkir");
        lblTitle.setFont(new Font("Segoe UI", Font.BOLD, 22));
        lblTitle.setForeground(Color.decode("#0F2742"));
        add(lblTitle, BorderLayout.NORTH);

        // FORM PANEL (LEFT)
        JPanel formPanel = new JPanel();
        formPanel.setLayout(new BoxLayout(formPanel, BoxLayout.Y_AXIS));
        formPanel.setBackground(Color.WHITE);
        formPanel.setBorder(BorderFactory.createCompoundBorder(
            BorderFactory.createLineBorder(Color.LIGHT_GRAY),
            new EmptyBorder(20, 20, 20, 20)
        ));
        formPanel.setPreferredSize(new Dimension(300, 0));

        // JComboBox Lantai
        formPanel.add(new JLabel("Pilih Lantai:"));
        formPanel.add(Box.createRigidArea(new Dimension(0, 5)));
        cbLantai = new JComboBox<>();
        cbLantai.setMaximumSize(new Dimension(300, 30));
        cbLantai.setAlignmentX(Component.LEFT_ALIGNMENT);
        formPanel.add(cbLantai);
        formPanel.add(Box.createRigidArea(new Dimension(0, 10)));

        // JTextField Kode Slot
        formPanel.add(new JLabel("Kode Slot (misal: A1, B2):"));
        formPanel.add(Box.createRigidArea(new Dimension(0, 5)));
        txtKodeSlot = new JTextField(15);
        txtKodeSlot.setMaximumSize(new Dimension(300, 30));
        txtKodeSlot.setAlignmentX(Component.LEFT_ALIGNMENT);
        formPanel.add(txtKodeSlot);
        formPanel.add(Box.createRigidArea(new Dimension(0, 10)));

        // JComboBox Status
        formPanel.add(new JLabel("Status Slot:"));
        formPanel.add(Box.createRigidArea(new Dimension(0, 5)));
        cbStatus = new JComboBox<>(new String[]{"tersedia", "dibooking", "terisi"});
        cbStatus.setMaximumSize(new Dimension(300, 30));
        cbStatus.setAlignmentX(Component.LEFT_ALIGNMENT);
        formPanel.add(cbStatus);
        formPanel.add(Box.createRigidArea(new Dimension(0, 20)));

        // Buttons
        JPanel actionPanel = new JPanel(new GridLayout(2, 2, 5, 5));
        actionPanel.setBackground(Color.WHITE);
        actionPanel.setMaximumSize(new Dimension(300, 70));
        actionPanel.setAlignmentX(Component.LEFT_ALIGNMENT);

        btnSimpan = new JButton("Simpan");
        UIHelper.styleButton(btnSimpan, Color.decode("#1E88E5"), Color.WHITE);
        
        btnUbah = new JButton("Ubah");
        UIHelper.styleButton(btnUbah, Color.decode("#1E88E5"), Color.WHITE);
        btnUbah.setEnabled(false);
        
        btnHapus = new JButton("Hapus");
        UIHelper.styleButton(btnHapus, Color.decode("#C62828"), Color.WHITE);
        btnHapus.setEnabled(false);
        
        btnReset = new JButton("Reset");
        UIHelper.styleButton(btnReset, Color.GRAY, Color.WHITE);

        actionPanel.add(btnSimpan);
        actionPanel.add(btnUbah);
        actionPanel.add(btnHapus);
        actionPanel.add(btnReset);
        formPanel.add(actionPanel);

        add(formPanel, BorderLayout.WEST);

        // TABLE PANEL (RIGHT)
        JPanel tablePanel = new JPanel(new BorderLayout());
        tablePanel.setBackground(Color.WHITE);
        tablePanel.setBorder(BorderFactory.createCompoundBorder(
            BorderFactory.createLineBorder(Color.LIGHT_GRAY),
            new EmptyBorder(10, 10, 10, 10)
        ));

        String[] columns = {"ID Slot", "Lantai", "Kode Slot", "Status", "ID Lantai"};
        tableModel = new DefaultTableModel(columns, 0) {
            @Override
            public boolean isCellEditable(int row, int column) {
                return false;
            }
        };
        table = new JTable(tableModel);
        table.setSelectionMode(ListSelectionModel.SINGLE_SELECTION);
        table.setRowHeight(25);
        
        // Hide ID Lantai column
        // table.getColumnModel().removeColumn(table.getColumnModel().getColumn(4));
        
        JScrollPane scrollTable = new JScrollPane(table);
        tablePanel.add(scrollTable, BorderLayout.CENTER);

        add(tablePanel, BorderLayout.CENTER);

        // Event Listeners
        table.addMouseListener(new MouseAdapter() {
            @Override
            public void mouseClicked(MouseEvent e) {
                int row = table.getSelectedRow();
                if (row != -1) {
                    selectedSlotId = (int) tableModel.getValueAt(row, 0);
                    String kodeSlot = (String) tableModel.getValueAt(row, 2);
                    String status = (String) tableModel.getValueAt(row, 3);
                    int idLantai = (int) tableModel.getValueAt(row, 4);

                    txtKodeSlot.setText(kodeSlot);
                    cbStatus.setSelectedItem(status);
                    
                    // Set combobox ke lantai yang sesuai
                    for (int i = 0; i < cbLantai.getItemCount(); i++) {
                        if (cbLantai.getItemAt(i).idLantai == idLantai) {
                            cbLantai.setSelectedIndex(i);
                            break;
                        }
                    }
                    
                    btnSimpan.setEnabled(false);
                    btnUbah.setEnabled(true);
                    btnHapus.setEnabled(true);
                }
            }
        });

        btnSimpan.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                simpanSlot();
            }
        });

        btnUbah.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                ubahSlot();
            }
        });

        btnHapus.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                hapusSlot();
            }
        });

        btnReset.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                resetForm();
            }
        });

        // Load combobox & table
        loadLantaiCombo();
        refreshTable();
    }

    private void loadLantaiCombo() {
        cbLantai.removeAllItems();
        List<Lantai> list = lantaiDAO.getAllLantai();
        for (Lantai l : list) {
            cbLantai.addItem(new LantaiComboItem(l.getIdLantai(), l.getNamaLantai()));
        }
    }

    private void resetForm() {
        txtKodeSlot.setText("");
        cbStatus.setSelectedIndex(0);
        if (cbLantai.getItemCount() > 0) cbLantai.setSelectedIndex(0);
        
        table.clearSelection();
        selectedSlotId = -1;
        
        btnSimpan.setEnabled(true);
        btnUbah.setEnabled(false);
        btnHapus.setEnabled(false);
    }

    private void refreshTable() {
        tableModel.setRowCount(0);
        List<SlotParkir> list = slotDAO.getAllSlot();
        for (SlotParkir s : list) {
            tableModel.addRow(new Object[]{
                s.getIdSlot(),
                s.getNamaLantai(),
                s.getKodeSlot(),
                s.getStatus(),
                s.getIdLantai()
            });
        }
    }

    private void simpanSlot() {
        LantaiComboItem lantaiItem = (LantaiComboItem) cbLantai.getSelectedItem();
        String kodeSlot = txtKodeSlot.getText().trim().toUpperCase();
        String status = (String) cbStatus.getSelectedItem();

        if (lantaiItem == null || kodeSlot.isEmpty()) {
            MessageHelper.showWarning(this, "Lantai dan Kode Slot wajib diisi!");
            return;
        }

        // Cek duplikasi kode slot di lantai yang sama
        if (slotDAO.isKodeSlotExists(lantaiItem.idLantai, kodeSlot)) {
            MessageHelper.showError(this, "Kode Slot '" + kodeSlot + "' sudah ada di " + lantaiItem.namaLantai + "!");
            return;
        }

        SlotParkir s = new SlotParkir();
        s.setIdLantai(lantaiItem.idLantai);
        s.setKodeSlot(kodeSlot);
        s.setStatus(status);

        if (slotDAO.insertSlot(s)) {
            MessageHelper.showInfo(this, "Data Slot Parkir berhasil disimpan!");
            resetForm();
            refreshTable();
        } else {
            MessageHelper.showError(this, "Gagal menyimpan data Slot Parkir!");
        }
    }

    private void ubahSlot() {
        if (selectedSlotId == -1) return;

        LantaiComboItem lantaiItem = (LantaiComboItem) cbLantai.getSelectedItem();
        String kodeSlot = txtKodeSlot.getText().trim().toUpperCase();
        String status = (String) cbStatus.getSelectedItem();

        if (lantaiItem == null || kodeSlot.isEmpty()) {
            MessageHelper.showWarning(this, "Lantai dan Kode Slot wajib diisi!");
            return;
        }

        // Ambil data slot lama untuk dicek apakah kode slot berubah
        int row = table.getSelectedRow();
        String oldKodeSlot = (String) tableModel.getValueAt(row, 2);
        int oldIdLantai = (int) tableModel.getValueAt(row, 4);

        if ((lantaiItem.idLantai != oldIdLantai || !kodeSlot.equals(oldKodeSlot)) && 
            slotDAO.isKodeSlotExists(lantaiItem.idLantai, kodeSlot)) {
            MessageHelper.showError(this, "Kode Slot '" + kodeSlot + "' sudah ada di " + lantaiItem.namaLantai + "!");
            return;
        }

        SlotParkir s = new SlotParkir();
        s.setIdSlot(selectedSlotId);
        s.setIdLantai(lantaiItem.idLantai);
        s.setKodeSlot(kodeSlot);
        s.setStatus(status);

        if (slotDAO.updateSlot(s)) {
            MessageHelper.showInfo(this, "Data Slot Parkir berhasil diubah!");
            resetForm();
            refreshTable();
        } else {
            MessageHelper.showError(this, "Gagal mengubah data Slot Parkir!");
        }
    }

    private void hapusSlot() {
        if (selectedSlotId == -1) return;

        boolean konfirmasi = MessageHelper.showConfirm(this, "Apakah Anda yakin ingin menghapus slot parkir ini?");
        if (konfirmasi) {
            if (slotDAO.deleteSlot(selectedSlotId)) {
                MessageHelper.showInfo(this, "Data Slot Parkir berhasil dihapus!");
                resetForm();
                refreshTable();
            } else {
                MessageHelper.showError(this, "Gagal menghapus data Slot Parkir!");
            }
        }
    }
}
