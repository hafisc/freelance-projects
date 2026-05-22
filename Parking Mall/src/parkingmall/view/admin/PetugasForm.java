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
import parkingmall.dao.PetugasDAO;
import parkingmall.dao.UserDAO;
import parkingmall.helper.MessageHelper;
import parkingmall.helper.UIHelper;
import parkingmall.model.Petugas;
import parkingmall.model.User;

public class PetugasForm extends JPanel {
    private final PetugasDAO petugasDAO;
    private final UserDAO userDAO;
    
    private final JTable table;
    private final DefaultTableModel tableModel;
    
    private final JTextField txtNama;
    private final JTextField txtNoHp;
    private final JTextArea txtAlamat;
    private final JTextField txtUsername;
    private final JPasswordField txtPassword;
    
    private final JButton btnSimpan;
    private final JButton btnUbah;
    private final JButton btnHapus;
    private final JButton btnReset;
    
    private int selectedPetugasId = -1;
    private int selectedUserId = -1;

    public PetugasForm() {
        this.petugasDAO = new PetugasDAO();
        this.userDAO = new UserDAO();
        
        setLayout(new BorderLayout(15, 15));
        setBackground(Color.decode("#85C1E9"));
        setBorder(new EmptyBorder(15, 15, 15, 15));

        // TITLE
        JLabel lblTitle = new JLabel("Kelola Data Petugas");
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
        formPanel.setPreferredSize(new Dimension(320, 0));

        // Inputs
        txtNama = createField(formPanel, "Nama Petugas:");
        txtNoHp = createField(formPanel, "No. Handphone:");
        
        formPanel.add(new JLabel("Alamat:"));
        formPanel.add(Box.createRigidArea(new Dimension(0, 5)));
        txtAlamat = new JTextArea(3, 20);
        txtAlamat.setLineWrap(true);
        txtAlamat.setWrapStyleWord(true);
        JScrollPane scrollAlamat = new JScrollPane(txtAlamat);
        scrollAlamat.setMaximumSize(new Dimension(300, 70));
        scrollAlamat.setAlignmentX(Component.LEFT_ALIGNMENT);
        formPanel.add(scrollAlamat);
        formPanel.add(Box.createRigidArea(new Dimension(0, 10)));
        
        txtUsername = createField(formPanel, "Username Login:");
        txtPassword = new JPasswordField(15);
        txtPassword.setMaximumSize(new Dimension(300, 30));
        txtPassword.setAlignmentX(Component.LEFT_ALIGNMENT);
        formPanel.add(new JLabel("Password Login:"));
        formPanel.add(Box.createRigidArea(new Dimension(0, 5)));
        formPanel.add(txtPassword);
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

        String[] columns = {"ID Petugas", "Nama Petugas", "No HP", "Alamat", "ID User"};
        tableModel = new DefaultTableModel(columns, 0) {
            @Override
            public boolean isCellEditable(int row, int column) {
                return false;
            }
        };
        table = new JTable(tableModel);
        table.setSelectionMode(ListSelectionModel.SINGLE_SELECTION);
        table.setRowHeight(25);
        
        // Hide ID columns for cleaner look (optional but simple)
        // TableColumnModel tcm = table.getColumnModel();
        // tcm.removeColumn(tcm.getColumn(4));
        
        JScrollPane scrollTable = new JScrollPane(table);
        tablePanel.add(scrollTable, BorderLayout.CENTER);

        add(tablePanel, BorderLayout.CENTER);

        // Event Listeners
        table.addMouseListener(new MouseAdapter() {
            @Override
            public void mouseClicked(MouseEvent e) {
                int row = table.getSelectedRow();
                if (row != -1) {
                    selectedPetugasId = (int) tableModel.getValueAt(row, 0);
                    String nama = (String) tableModel.getValueAt(row, 1);
                    String noHp = (String) tableModel.getValueAt(row, 2);
                    String alamat = (String) tableModel.getValueAt(row, 3);
                    selectedUserId = (int) tableModel.getValueAt(row, 4);

                    txtNama.setText(nama);
                    txtNoHp.setText(noHp);
                    txtAlamat.setText(alamat);
                    
                    // Ambil detail User untuk username
                    User u = petugasDAO.getUserByPetugas(selectedUserId);
                    if (u != null) {
                        txtUsername.setText(u.getUsername());
                        txtPassword.setText(u.getPassword());
                    }
                    
                    txtUsername.setEnabled(false); // Username tidak boleh diedit
                    btnSimpan.setEnabled(false);
                    btnUbah.setEnabled(true);
                    btnHapus.setEnabled(true);
                }
            }
        });

        btnSimpan.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                simpanPetugas();
            }
        });

        btnUbah.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                ubahPetugas();
            }
        });

        btnHapus.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                hapusPetugas();
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

    // Helper untuk membuat field input berlabel
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

    // Fungsi ini digunakan untuk mereset input form
    private void resetForm() {
        txtNama.setText("");
        txtNoHp.setText("");
        txtAlamat.setText("");
        txtUsername.setText("");
        txtUsername.setEnabled(true);
        txtPassword.setText("");
        
        table.clearSelection();
        selectedPetugasId = -1;
        selectedUserId = -1;
        
        btnSimpan.setEnabled(true);
        btnUbah.setEnabled(false);
        btnHapus.setEnabled(false);
    }

    // Fungsi ini digunakan untuk menyegarkan isi tabel petugas
    private void refreshTable() {
        tableModel.setRowCount(0);
        List<Petugas> list = petugasDAO.getAllPetugas();
        for (Petugas p : list) {
            tableModel.addRow(new Object[]{
                p.getIdPetugas(),
                p.getNamaPetugas(),
                p.getNoHp(),
                p.getAlamat(),
                p.getIdUser()
            });
        }
    }

    // Fungsi ini digunakan untuk menyimpan data petugas baru
    private void simpanPetugas() {
        String nama = txtNama.getText().trim();
        String noHp = txtNoHp.getText().trim();
        String alamat = txtAlamat.getText().trim();
        String username = txtUsername.getText().trim();
        String password = new String(txtPassword.getPassword()).trim();

        // Validasi input kosong
        if (nama.isEmpty() || noHp.isEmpty() || alamat.isEmpty() || username.isEmpty() || password.isEmpty()) {
            MessageHelper.showWarning(this, "Semua input wajib diisi!");
            return;
        }

        if (userDAO.isUsernameTaken(username)) {
            MessageHelper.showError(this, "Username sudah digunakan oleh akun lain!");
            return;
        }

        User u = new User();
        u.setNama(nama);
        u.setUsername(username);
        u.setPassword(password);
        u.setRole("petugas");

        Petugas p = new Petugas();
        p.setNamaPetugas(nama);
        p.setNoHp(noHp);
        p.setAlamat(alamat);

        if (petugasDAO.insertPetugas(p, u)) {
            MessageHelper.showInfo(this, "Data Petugas berhasil disimpan!");
            resetForm();
            refreshTable();
        } else {
            MessageHelper.showError(this, "Gagal menyimpan data Petugas!");
        }
    }

    // Fungsi ini digunakan untuk mengubah data petugas terpilih
    private void ubahPetugas() {
        if (selectedPetugasId == -1 || selectedUserId == -1) return;

        String nama = txtNama.getText().trim();
        String noHp = txtNoHp.getText().trim();
        String alamat = txtAlamat.getText().trim();
        String password = new String(txtPassword.getPassword()).trim();

        if (nama.isEmpty() || noHp.isEmpty() || alamat.isEmpty() || password.isEmpty()) {
            MessageHelper.showWarning(this, "Nama, No HP, Alamat, dan Password login tidak boleh kosong!");
            return;
        }

        User u = new User();
        u.setIdUser(selectedUserId);
        u.setNama(nama);
        u.setPassword(password);

        Petugas p = new Petugas();
        p.setIdPetugas(selectedPetugasId);
        p.setNamaPetugas(nama);
        p.setNoHp(noHp);
        p.setAlamat(alamat);

        if (petugasDAO.updatePetugas(p, u)) {
            MessageHelper.showInfo(this, "Data Petugas berhasil diubah!");
            resetForm();
            refreshTable();
        } else {
            MessageHelper.showError(this, "Gagal mengubah data Petugas!");
        }
    }

    // Fungsi ini digunakan untuk menghapus data petugas terpilih
    private void hapusPetugas() {
        if (selectedPetugasId == -1 || selectedUserId == -1) return;

        boolean konfirmasi = MessageHelper.showConfirm(this, "Apakah Anda yakin ingin menghapus petugas ini? Akun login terkait juga akan dihapus.");
        if (konfirmasi) {
            if (petugasDAO.deletePetugas(selectedPetugasId, selectedUserId)) {
                MessageHelper.showInfo(this, "Data Petugas berhasil dihapus!");
                resetForm();
                refreshTable();
            } else {
                MessageHelper.showError(this, "Gagal menghapus data Petugas!");
            }
        }
    }
}
