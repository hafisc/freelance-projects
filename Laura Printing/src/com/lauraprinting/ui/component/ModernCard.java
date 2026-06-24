package com.lauraprinting.ui.component;

import javax.swing.*;
import javax.swing.border.EmptyBorder;
import java.awt.*;

public class ModernCard extends JPanel {
    private final JLabel titleLabel;
    private final JLabel valueLabel;
    private final Color accentColor;

    public ModernCard(String title, String value, Color accentColor) {
        this.accentColor = accentColor;
        
        // Mematikan opasitas agar sudut rounded transparan terhadap latar belakang parent
        setOpaque(false);
        
        setLayout(new BorderLayout());
        setBackground(Color.WHITE);
        setBorder(new EmptyBorder(18, 22, 18, 22)); // Padding dalam kartu
        
        titleLabel = new JLabel(title);
        titleLabel.setFont(new Font("Segoe UI", Font.BOLD, 12));
        titleLabel.setForeground(new Color(148, 163, 184)); // Slate 400
        
        valueLabel = new JLabel(value);
        valueLabel.setFont(new Font("Segoe UI", Font.BOLD, 26));
        valueLabel.setForeground(new Color(15, 23, 42)); // Slate 900
        
        add(titleLabel, BorderLayout.NORTH);
        add(valueLabel, BorderLayout.CENTER);
    }

    public void setValue(String value) {
        valueLabel.setText(value);
    }

    @Override
    protected void paintComponent(Graphics g) {
        Graphics2D g2 = (Graphics2D) g.create();
        g2.setRenderingHint(RenderingHints.KEY_ANTIALIASING, RenderingHints.VALUE_ANTIALIAS_ON);
        
        // Menggambar latar belakang kartu rounded berwarna putih
        g2.setColor(Color.WHITE);
        g2.fillRoundRect(0, 0, getWidth(), getHeight(), 16, 16);
        
        // Menggambar garis aksen warna di sebelah kiri kartu
        g2.setColor(accentColor);
        g2.fillRoundRect(0, 0, 6, getHeight(), 6, 6);
        
        // Menggambar border tipis berwarna Slate 200 di sekeliling kartu
        g2.setColor(new Color(226, 232, 240));
        g2.drawRoundRect(0, 0, getWidth() - 1, getHeight() - 1, 16, 16);
        
        g2.dispose();
        
        super.paintComponent(g);
    }
}
