package parkingmall.view;

import java.awt.*;
import javax.swing.*;
import javax.swing.border.EmptyBorder;

public class WelcomeBanner extends JPanel {
    private final JLabel lblTitle;
    private final JLabel lblSubtitle;

    public WelcomeBanner(String userName, String appName) {
        setOpaque(false);
        setLayout(new BorderLayout(20, 0));
        setBorder(new EmptyBorder(15, 25, 15, 25));

        // Panel Teks di sebelah kiri
        JPanel textPanel = new JPanel();
        textPanel.setOpaque(false);
        textPanel.setLayout(new BoxLayout(textPanel, BoxLayout.Y_AXIS));

        lblTitle = new JLabel("SELAMAT DATANG, " + userName.toUpperCase());
        lblTitle.setFont(new Font("Segoe UI", Font.BOLD, 22));
        lblTitle.setForeground(Color.decode("#0F2742"));

        lblSubtitle = new JLabel(appName);
        lblSubtitle.setFont(new Font("Segoe UI", Font.BOLD, 15));
        lblSubtitle.setForeground(Color.decode("#1E88E5"));

        textPanel.add(Box.createVerticalGlue());
        textPanel.add(lblTitle);
        textPanel.add(Box.createRigidArea(new Dimension(0, 5)));
        textPanel.add(lblSubtitle);
        textPanel.add(Box.createVerticalGlue());

        add(textPanel, BorderLayout.CENTER);

        // Panel Grafik di sebelah kanan
        CityGraphicPanel graphicPanel = new CityGraphicPanel();
        graphicPanel.setPreferredSize(new Dimension(280, 110));
        add(graphicPanel, BorderLayout.EAST);
    }

    @Override
    protected void paintComponent(Graphics g) {
        super.paintComponent(g);
        Graphics2D g2 = (Graphics2D) g.create();
        g2.setRenderingHint(RenderingHints.KEY_ANTIALIASING, RenderingHints.VALUE_ANTIALIAS_ON);

        // Menggambar background kartu putih bulat (rounded card)
        g2.setColor(Color.WHITE);
        g2.fillRoundRect(0, 0, getWidth(), getHeight(), 15, 15);

        // Menggambar border abu-abu tipis
        g2.setColor(Color.decode("#E0E0E0"));
        g2.drawRoundRect(0, 0, getWidth() - 1, getHeight() - 1, 15, 15);

        g2.dispose();
    }

    // Panel khusus untuk menggambar kota flat vector dan mobil
    private static class CityGraphicPanel extends JPanel {
        public CityGraphicPanel() {
            setOpaque(false);
        }

        @Override
        protected void paintComponent(Graphics g) {
            super.paintComponent(g);
            Graphics2D g2 = (Graphics2D) g.create();
            g2.setRenderingHint(RenderingHints.KEY_ANTIALIASING, RenderingHints.VALUE_ANTIALIAS_ON);

            int w = getWidth();
            int h = getHeight();

            // 1. Gambar kliping background biru muda melengkung di sebelah kanan seperti di referensi
            g2.setColor(Color.decode("#EBF5FB"));
            g2.fillRoundRect(5, 5, w - 10, h - 10, 10, 10);

            // 2. Gambar Gedung Kota (City Skyline)
            // Gedung 1 (kiri, abu-abu muda)
            g2.setColor(Color.decode("#BDC3C7"));
            g2.fillRect(30, 20, 25, 70);
            g2.setColor(Color.WHITE);
            // Jendela gedung 1
            for (int y = 25; y < 85; y += 12) {
                g2.fillRect(35, y, 5, 6);
                g2.fillRect(45, y, 5, 6);
            }

            // Gedung 2 (tengah-kiri, cyan)
            g2.setColor(Color.decode("#95A5A6"));
            g2.fillRect(65, 10, 35, 80);
            g2.setColor(Color.WHITE);
            // Jendela gedung 2
            for (int y = 15; y < 85; y += 10) {
                g2.fillRect(71, y, 6, 5);
                g2.fillRect(81, y, 6, 5);
                g2.fillRect(91, y, 6, 5);
            }

            // Gedung 3 (tengah-kanan, biru/abu gelap)
            g2.setColor(Color.decode("#7F8C8D"));
            g2.fillRect(110, 30, 30, 60);
            g2.setColor(Color.WHITE);
            for (int y = 35; y < 85; y += 12) {
                g2.fillRect(116, y, 6, 6);
                g2.fillRect(128, y, 6, 6);
            }

            // Gedung 4 (kanan, abu tipis)
            g2.setColor(Color.decode("#D5D8DC"));
            g2.fillRect(150, 40, 20, 50);

            // 3. Menggambar Awan
            g2.setColor(Color.WHITE);
            g2.fillOval(40, 12, 16, 12);
            g2.fillOval(50, 10, 20, 15);
            g2.fillOval(64, 12, 16, 12);

            g2.fillOval(140, 22, 14, 10);
            g2.fillOval(148, 20, 18, 12);
            g2.fillOval(160, 22, 14, 10);

            // 4. Menggambar Jalan Raya di bagian bawah
            g2.setColor(Color.decode("#34495E"));
            g2.fillRect(15, 82, w - 30, 8);
            
            // Rambu Parkir "P"
            g2.setColor(Color.decode("#0F2742"));
            g2.fillRect(210, 35, 4, 50); // Tiang rambu
            g2.fillRoundRect(197, 20, 30, 25, 6, 6); // Papan rambu
            g2.setColor(Color.WHITE);
            g2.drawRoundRect(199, 22, 26, 21, 4, 4);
            g2.setFont(new Font("Segoe UI", Font.BOLD, 15));
            g2.drawString("P", 207, 38);

            // 5. Menggambar Mobil (3 Mobil: Merah, Kuning, Orange)
            // Mobil 1 (Kiri - Merah)
            drawCar(g2, 25, 70, Color.decode("#E74C3C"));
            // Mobil 2 (Tengah - Kuning)
            drawCar(g2, 75, 70, Color.decode("#F1C40F"));
            // Mobil 3 (Kanan - Orange)
            drawCar(g2, 125, 70, Color.decode("#E67E22"));

            g2.dispose();
        }

        private void drawCar(Graphics2D g2, int x, int y, Color carColor) {
            // Roda
            g2.setColor(Color.BLACK);
            g2.fillOval(x + 5, y + 10, 8, 8);
            g2.fillOval(x + 22, y + 10, 8, 8);
            g2.setColor(Color.LIGHT_GRAY);
            g2.fillOval(x + 7, y + 12, 4, 4);
            g2.fillOval(x + 24, y + 12, 4, 4);

            // Body Mobil bawah
            g2.setColor(carColor);
            g2.fillRoundRect(x, y + 4, 35, 8, 4, 4);

            // Body Mobil atas (kabin)
            g2.fillRoundRect(x + 6, y, 22, 6, 3, 3);

            // Kaca jendela kabin
            g2.setColor(Color.decode("#AED6F1"));
            g2.fillRect(x + 9, y + 1, 7, 3);
            g2.fillRect(x + 18, y + 1, 7, 3);

            // Lampu depan (kuning)
            g2.setColor(Color.WHITE);
            g2.fillRect(x + 32, y + 5, 3, 2);
        }
    }
}
