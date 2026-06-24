package com.lauraprinting;

import com.formdev.flatlaf.FlatLightLaf;
import com.lauraprinting.config.DatabaseConfig;
import com.lauraprinting.ui.LoginFrame;

import javax.swing.*;

public class App {
    public static void main(String[] args) {
        System.out.println("Memulai aplikasi Laura Printing...");

        // 1. Inisialisasi Database & Jalankan Migrasi Otomatis
        DatabaseConfig.initializeDatabase();

        // 2. Konfigurasi Tema/Tampilan GUI dengan FlatLaf
        try {
            FlatLightLaf.setup();
            
            // Mengatur setelan visual modern (sudut melengkung & padding lapang)
            UIManager.put("Button.arc", 16);
            UIManager.put("Component.arc", 16);
            UIManager.put("TextComponent.arc", 16);
            UIManager.put("ComboBox.arc", 16);
            UIManager.put("Spinner.arc", 16);
            
            // Pengaturan fokus border agar lebih tipis
            UIManager.put("Component.focusWidth", 1);
            UIManager.put("Component.innerFocusWidth", 0);
            UIManager.put("Button.innerFocusWidth", 0);
            
            // Pengaturan margin dan padding lapang pada komponen input & tombol
            UIManager.put("TextComponent.margin", new java.awt.Insets(6, 12, 6, 12));
            UIManager.put("Button.margin", new java.awt.Insets(6, 16, 6, 16));
            UIManager.put("ComboBox.padding", new java.awt.Insets(4, 10, 4, 10));
            
            // Estetika Header Tabel JTable
            UIManager.put("TableHeader.background", new java.awt.Color(241, 245, 249)); // Slate 100
            UIManager.put("TableHeader.foreground", new java.awt.Color(71, 85, 105)); // Slate 600
            UIManager.put("TableHeader.font", new java.awt.Font("Segoe UI", java.awt.Font.BOLD, 12));
            UIManager.put("TableHeader.height", 38);
            UIManager.put("TableHeader.separatorColor", new java.awt.Color(241, 245, 249));
            
            // Estetika Sel Tabel JTable
            UIManager.put("Table.rowHeight", 38);
            UIManager.put("Table.font", new java.awt.Font("Segoe UI", java.awt.Font.PLAIN, 13));
            UIManager.put("Table.selectionBackground", new java.awt.Color(238, 242, 255)); // Indigo 50
            UIManager.put("Table.selectionForeground", new java.awt.Color(79, 70, 229)); // Indigo 600
            UIManager.put("Table.gridColor", new java.awt.Color(241, 245, 249)); // Slate 100
            UIManager.put("Table.showHorizontalLines", true);
            UIManager.put("Table.showVerticalLines", false);
            UIManager.put("Table.intercellSpacing", new java.awt.Dimension(0, 1));
            
            // Estetika Scrollbar
            UIManager.put("ScrollBar.thumbArc", 999);
            UIManager.put("ScrollBar.trackArc", 999);
            UIManager.put("ScrollBar.thumbColor", new java.awt.Color(203, 213, 225)); // Slate 300
            UIManager.put("ScrollBar.trackColor", new java.awt.Color(248, 250, 252)); // Slate 50
            UIManager.put("ScrollBar.width", 10);
            
            System.out.println("Tampilan UI FlatLaf berhasil dikonfigurasi.");
        } catch (Exception e) {
            System.err.println("Gagal mengatur Tampilan UI FlatLaf, menggunakan tema bawaan.");
            e.printStackTrace();
        }

        // 3. Jalankan Layar Login pada Event Dispatch Thread Swing
        SwingUtilities.invokeLater(() -> {
            new LoginFrame().setVisible(true);
        });
    }
}
