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
import parkingmall.helper.MessageHelper;
import parkingmall.helper.UIHelper;
import parkingmall.model.Lantai;

public class LantaiForm extends JPanel {
    private final LantaiDAO lantaiDAO;
    
    private final JTable table;
    private final DefaultTableModel tableModel;
    
    private final JTextField txtNamaLantai;
    private final JTextField txtKeterangan;
    
    private final JButton btnSimpan;
    private final JButton btnUbah;
    private final JButton btnHapus;
    private final JButton btnReset;
    
    private int selectedLantaiId = -1;

    public LantaiForm() {
        this.lantaiDAO = new LantaiDAO();
        
        setLayout(new BorderLayout(15, 15));
        setBackground(Color.decode("#85C1E9"));
        setBorder(new EmptyBorder(15, 15, 15, 15));

        // TITLE
        JLabel lblTitle = new JLabel("Kelola Lantai Parkir");
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

        // Inputs
        txtNamaLantai = createField(formPanel, "Nama Lantai (contoh: Lantai 1):");
        txtKeterangan = createField(formPanel, "Keterangan Lantai:");

        formPanel.add(Box.createRigidArea(new Dimension(0, 15)));

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

        String[] columns = {"ID Lantai", "Nama Lantai", "Keterangan"};
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

        // Event Listeners
        table.addMouseListener(new MouseAdapter() {
            @Override
            public void mouseClicked(MouseEvent e) {
                int row = table.getSelectedRow();
                if (row != -1) {
                    selectedLantaiId = (int) tableModel.getValueAt(row, 0);
                    String nama = (String) tableModel.getValueAt(row, 1);
                    String keterangan = (String) tableModel.getValueAt(row, 2);

                    txtNamaLantai.setText(nama);
                    txtKeterangan.setText(keterangan);
                    
                    btnSimpan.setEnabled(false);
                    btnUbah.setEnabled(true);
                    btnHapus.setEnabled(true);
                }
            }
        });

        btnSimpan.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                simpanLantai();
            }
        });

        btnUbah.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                ubahLantai();
            }
        });

        btnHapus.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                hapusLantai();
            }
        });

        btnReset.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                resetForm();
            }
        });

        // Load awal data
        refreshTable();
    }

    private JTextField createField(JPanel parent, String label) {
        parent.add(new JLabel(label));
        parent.add(Box.createRigidArea(new Dimension(0, 5)));
        JTextField field = new JTextField(15);
        field.setMaximumSize(new Dimension(300, 30));
        field.setAlignmentX(Component.LEFT_ALIGNMENT);
        parent.add(field);
        parent.add(Box.createRigidArea(new Dimension(0, 10)));
        return field;
    }

    private void resetForm() {
        txtNamaLantai.setText("");
        txtKeterangan.setText("");
        table.clearSelection();
        selectedLantaiId = -1;
        
        btnSimpan.setEnabled(true);
        btnUbah.setEnabled(false);
        btnHapus.setEnabled(false);
    }

    private void refreshTable() {
        tableModel.setRowCount(0);
        List<Lantai> list = lantaiDAO.getAllLantai();
        for (Lantai l : list) {
            tableModel.addRow(new Object[]{
                l.getIdLantai(),
                l.getNamaLantai(),
                l.getKeterangan()
            });
        }
    }

    private void simpanLantai() {
        String nama = txtNamaLantai.getText().trim();
        String keterangan = txtKeterangan.getText().trim();

        // Validasi input kosong
        if (nama.isEmpty()) {
            MessageHelper.showWarning(this, "Nama Lantai tidak boleh kosong!");
            return;
        }

        Lantai l = new Lantai();
        l.setNamaLantai(nama);
        l.setKeterangan(keterangan);

        if (lantaiDAO.insertLantai(l)) {
            MessageHelper.showInfo(this, "Data Lantai berhasil disimpan!");
            resetForm();
            refreshTable();
        } else {
            MessageHelper.showError(this, "Gagal menyimpan data Lantai!");
        }
    }

    private void ubahLantai() {
        if (selectedLantaiId == -1) return;

        String nama = txtNamaLantai.getText().trim();
        String keterangan = txtKeterangan.getText().trim();

        if (nama.isEmpty()) {
            MessageHelper.showWarning(this, "Nama Lantai tidak boleh kosong!");
            return;
        }

        Lantai l = new Lantai();
        l.setIdLantai(selectedLantaiId);
        l.setNamaLantai(nama);
        l.setKeterangan(keterangan);

        if (lantaiDAO.updateLantai(l)) {
            MessageHelper.showInfo(this, "Data Lantai berhasil diubah!");
            resetForm();
            refreshTable();
        } else {
            MessageHelper.showError(this, "Gagal mengubah data Lantai!");
        }
    }

    private void hapusLantai() {
        if (selectedLantaiId == -1) return;

        boolean konfirmasi = MessageHelper.showConfirm(this, "Apakah Anda yakin ingin menghapus lantai ini? Semua slot parkir di lantai ini juga akan terhapus.");
        if (konfirmasi) {
            if (lantaiDAO.deleteLantai(selectedLantaiId)) {
                MessageHelper.showInfo(this, "Data Lantai berhasil dihapus!");
                resetForm();
                refreshTable();
            } else {
                MessageHelper.showError(this, "Gagal menghapus data Lantai!");
            }
        }
    }
}
