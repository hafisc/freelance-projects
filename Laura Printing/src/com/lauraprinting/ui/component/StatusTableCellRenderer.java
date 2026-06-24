package com.lauraprinting.ui.component;

import javax.swing.*;
import javax.swing.table.DefaultTableCellRenderer;
import java.awt.*;

/**
 * Renderer khusus untuk mewarnai kolom Status pada tabel transaksi.
 * Membantu membedakan status pesanan secara visual dengan cepat.
 */
public class StatusTableCellRenderer extends DefaultTableCellRenderer {
    
    public StatusTableCellRenderer() {
        setHorizontalAlignment(SwingConstants.CENTER);
    }

    @Override
    public Component getTableCellRendererComponent(JTable table, Object value, boolean isSelected, boolean hasFocus, int row, int column) {
        super.getTableCellRendererComponent(table, value, isSelected, hasFocus, row, column);
        
        // Buat font menjadi tebal (Bold)
        setFont(getFont().deriveFont(Font.BOLD));
        
        if (value != null) {
            String status = value.toString();
            
            // Mewarnai teks berdasarkan status pesanan
            if (status.equalsIgnoreCase("Pending")) {
                setForeground(new Color(217, 119, 6)); // Amber / Jingga (Menunggu)
            } else if (status.equalsIgnoreCase("Processing")) {
                setForeground(new Color(37, 99, 235)); // Biru (Sedang Diproses)
            } else if (status.equalsIgnoreCase("Done")) {
                setForeground(new Color(22, 163, 74)); // Hijau (Selesai Cetak)
            } else if (status.equalsIgnoreCase("Picked Up")) {
                setForeground(new Color(71, 85, 105)); // Slate / Abu Gelap (Sudah Diambil)
            } else {
                setForeground(table.getForeground());
            }
        }
        
        // Mempertahankan background baris terpilih
        if (isSelected) {
            setBackground(table.getSelectionBackground());
        } else {
            setBackground(table.getBackground());
        }
        
        return this;
    }
}
