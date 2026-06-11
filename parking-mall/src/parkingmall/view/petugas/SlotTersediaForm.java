package parkingmall.view.petugas;

import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.util.List;
import javax.swing.*;
import javax.swing.border.EmptyBorder;
import javax.swing.table.DefaultTableModel;
import parkingmall.dao.LantaiDAO;
import parkingmall.dao.SlotParkirDAO;
import parkingmall.model.Lantai;
import parkingmall.model.SlotParkir;

public class SlotTersediaForm extends JPanel {
    private final SlotParkirDAO slotDAO;
    private final LantaiDAO lantaiDAO;
    
    private final JComboBox<LantaiComboItem> cbLantai;
    private final JTable table;
    private final DefaultTableModel tableModel;
    
    private final JLabel lblTersedia;
    private final JLabel lblDibooking;
    private final JLabel lblTerisi;

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

    public SlotTersediaForm() {
        this.slotDAO = new SlotParkirDAO();
        this.lantaiDAO = new LantaiDAO();
        
        setLayout(new BorderLayout(15, 15));
        setBackground(Color.decode("#85C1E9"));
        setBorder(new EmptyBorder(15, 15, 15, 15));

        // TITLE
        JLabel lblTitle = new JLabel("Informasi Ketersediaan Slot Parkir");
        lblTitle.setFont(new Font("Segoe UI", Font.BOLD, 22));
        lblTitle.setForeground(Color.decode("#0F2742"));
        add(lblTitle, BorderLayout.NORTH);

        // TOP CONTROLS (COMBOBOX & STATS)
        JPanel topPanel = new JPanel(new BorderLayout(15, 10));
        topPanel.setBackground(Color.WHITE);
        topPanel.setBorder(BorderFactory.createCompoundBorder(
            BorderFactory.createLineBorder(Color.LIGHT_GRAY),
            new EmptyBorder(10, 15, 10, 15)
        ));

        // Floor selector (Left)
        JPanel floorPanel = new JPanel(new FlowLayout(FlowLayout.LEFT, 5, 0));
        floorPanel.setBackground(Color.WHITE);
        floorPanel.add(new JLabel("Pilih Lantai:"));
        cbLantai = new JComboBox<>();
        cbLantai.setPreferredSize(new Dimension(150, 25));
        floorPanel.add(cbLantai);
        topPanel.add(floorPanel, BorderLayout.WEST);

        // Stats panel (Right)
        JPanel statsPanel = new JPanel(new FlowLayout(FlowLayout.RIGHT, 15, 0));
        statsPanel.setBackground(Color.WHITE);
        
        lblTersedia = new JLabel("Tersedia: 0");
        lblTersedia.setFont(new Font("Segoe UI", Font.BOLD, 12));
        lblTersedia.setForeground(Color.decode("#2E7D32"));
        
        lblDibooking = new JLabel("Dibooking: 0");
        lblDibooking.setFont(new Font("Segoe UI", Font.BOLD, 12));
        lblDibooking.setForeground(Color.decode("#F9A825"));
        
        lblTerisi = new JLabel("Terisi: 0");
        lblTerisi.setFont(new Font("Segoe UI", Font.BOLD, 12));
        lblTerisi.setForeground(Color.decode("#D32F2F"));

        statsPanel.add(lblTersedia);
        statsPanel.add(lblDibooking);
        statsPanel.add(lblTerisi);
        topPanel.add(statsPanel, BorderLayout.EAST);

        add(topPanel, BorderLayout.NORTH);

        // TABLE PANEL (CENTER)
        JPanel tablePanel = new JPanel(new BorderLayout());
        tablePanel.setBackground(Color.WHITE);
        tablePanel.setBorder(BorderFactory.createCompoundBorder(
            BorderFactory.createLineBorder(Color.LIGHT_GRAY),
            new EmptyBorder(10, 10, 10, 10)
        ));

        String[] columns = {"Kode Slot", "Lantai", "Status"};
        tableModel = new DefaultTableModel(columns, 0) {
            @Override
            public boolean isCellEditable(int row, int column) {
                return false;
            }
        };
        table = new JTable(tableModel);
        table.setRowHeight(25);
        table.setFont(new Font("Segoe UI", Font.PLAIN, 13));
        
        JScrollPane scrollTable = new JScrollPane(table);
        tablePanel.add(scrollTable, BorderLayout.CENTER);

        add(tablePanel, BorderLayout.CENTER);

        // Events
        cbLantai.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                tampilkanSlot();
            }
        });

        // Load floors and data
        loadLantaiCombo();
        tampilkanSlot();
    }

    private void loadLantaiCombo() {
        cbLantai.removeAllItems();
        List<Lantai> list = lantaiDAO.getAllLantai();
        for (Lantai l : list) {
            cbLantai.addItem(new LantaiComboItem(l.getIdLantai(), l.getNamaLantai()));
        }
    }

    // Fungsi ini digunakan untuk memuat data slot berdasarkan lantai yang dipilih dan merangkum jumlahnya
    private void tampilkanSlot() {
        LantaiComboItem selected = (LantaiComboItem) cbLantai.getSelectedItem();
        if (selected == null) return;

        tableModel.setRowCount(0);
        List<SlotParkir> slots = slotDAO.getSlotByLantai(selected.idLantai);

        int tersediaCount = 0;
        int dibookingCount = 0;
        int terisiCount = 0;

        for (SlotParkir s : slots) {
            switch (s.getStatus()) {
                case "tersedia":
                    tersediaCount++;
                    break;
                case "dibooking":
                    dibookingCount++;
                    break;
                case "terisi":
                    terisiCount++;
                    break;
            }

            tableModel.addRow(new Object[]{
                s.getKodeSlot(),
                s.getNamaLantai(),
                s.getStatus().toUpperCase()
            });
        }

        lblTersedia.setText("Tersedia: " + tersediaCount);
        lblDibooking.setText("Dibooking: " + dibookingCount);
        lblTerisi.setText("Terisi: " + terisiCount);
    }
}
