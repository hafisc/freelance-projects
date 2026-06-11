package parkingmall.helper;

import java.awt.Color;
import java.awt.Cursor;
import java.awt.Dimension;
import java.awt.Font;
import java.awt.FontMetrics;
import java.awt.Graphics;
import java.awt.Rectangle;
import javax.swing.AbstractButton;
import javax.swing.BorderFactory;
import javax.swing.ButtonModel;
import javax.swing.JButton;
import javax.swing.JComponent;
import javax.swing.plaf.basic.BasicButtonUI;

public class UIHelper {
    // Fungsi ini digunakan untuk menghias tombol (JButton) secara seragam agar warna background dan teks tampil jelas di Windows Look & Feel
    public static void styleButton(JButton button, Color bgColor, Color fgColor, int width, int height) {
        button.setUI(new BasicButtonUI() {
            @Override
            public void paint(Graphics g, JComponent c) {
                AbstractButton b = (AbstractButton) c;
                ButtonModel model = b.getModel();
                
                Color fillBg;
                Color borderCol;
                
                if (b.isEnabled()) {
                    fillBg = b.getBackground();
                    if (model.isPressed()) {
                        fillBg = fillBg.darker();
                    } else if (model.isRollover()) {
                        fillBg = fillBg.brighter();
                    }
                    borderCol = fillBg.darker();
                } else {
                    fillBg = Color.decode("#E5E8E8");
                    borderCol = Color.decode("#BDC3C7");
                }
                
                // Draw background
                g.setColor(fillBg);
                g.fillRect(0, 0, b.getWidth(), b.getHeight());
                
                // Draw border
                g.setColor(borderCol);
                g.drawRect(0, 0, b.getWidth() - 1, b.getHeight() - 1);
                
                super.paint(g, c);
            }

            @Override
            protected void paintText(Graphics g, JComponent c, Rectangle textRect, String text) {
                AbstractButton b = (AbstractButton) c;
                FontMetrics fm = g.getFontMetrics();
                
                g.setFont(b.getFont());
                if (b.isEnabled()) {
                    g.setColor(b.getForeground());
                } else {
                    g.setColor(Color.decode("#95A5A6"));
                }
                
                int textX = textRect.x + getTextShiftOffset();
                int textY = textRect.y + fm.getAscent() + getTextShiftOffset();
                g.drawString(text, textX, textY);
            }
        });
        
        button.setBackground(bgColor);
        button.setForeground(fgColor);
        button.setFocusPainted(false);
        button.setContentAreaFilled(false);
        button.setOpaque(false);
        
        // Dynamically adjust cursor based on whether button is enabled or disabled
        button.setCursor(new Cursor(button.isEnabled() ? Cursor.HAND_CURSOR : Cursor.DEFAULT_CURSOR));
        button.addPropertyChangeListener("enabled", evt -> {
            button.setCursor(new Cursor(button.isEnabled() ? Cursor.HAND_CURSOR : Cursor.DEFAULT_CURSOR));
        });
        
        button.setBorder(BorderFactory.createEmptyBorder(6, 16, 6, 16));
        
        if (width > 0 && height > 0) {
            button.setMaximumSize(new Dimension(width, height));
            button.setPreferredSize(new Dimension(width, height));
        }
    }
    
    // Overload fungsi menghias tombol tanpa membatasi ukuran maksimum
    public static void styleButton(JButton button, Color bgColor, Color fgColor) {
        styleButton(button, bgColor, fgColor, 0, 0);
    }
}
