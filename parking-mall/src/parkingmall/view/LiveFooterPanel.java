package parkingmall.view;

import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.Locale;
import javax.swing.*;
import javax.swing.border.EmptyBorder;

public class LiveFooterPanel extends JPanel {
    private final JLabel lblInfoTitle;
    private final JLabel lblInfoText;
    private final JLabel lblDate;
    private final JLabel lblTime;
    private final Timer timer;
    private final SimpleDateFormat dateFormat = new SimpleDateFormat("dd MMMM yyyy", new Locale("id", "ID"));
    private final SimpleDateFormat timeFormat = new SimpleDateFormat("HH.mm", new Locale("id", "ID"));

    public LiveFooterPanel() {
        setOpaque(false);
        setLayout(new BorderLayout(10, 0));
        setBorder(new EmptyBorder(15, 10, 10, 10));

        // 1. Bagian Kiri: Box Informasi (Info Card)
        JPanel infoPanel = new JPanel(new FlowLayout(FlowLayout.LEFT, 10, 8));
        infoPanel.setOpaque(true);
        infoPanel.setBackground(Color.decode("#EBF5FB"));
        infoPanel.setBorder(BorderFactory.createCompoundBorder(
            BorderFactory.createLineBorder(Color.decode("#AED6F1"), 1),
            new EmptyBorder(5, 10, 5, 15)
        ));

        // Ikon Info
        JLabel lblInfoIcon = new JLabel("ℹ");
        lblInfoIcon.setFont(new Font("Segoe UI", Font.BOLD, 22));
        lblInfoIcon.setForeground(Color.decode("#1E88E5"));
        infoPanel.add(lblInfoIcon);

        // Teks Informasi
        JPanel infoTextPanel = new JPanel();
        infoTextPanel.setOpaque(false);
        infoTextPanel.setLayout(new BoxLayout(infoTextPanel, BoxLayout.Y_AXIS));

        lblInfoTitle = new JLabel("INFORMASI");
        lblInfoTitle.setFont(new Font("Segoe UI", Font.BOLD, 12));
        lblInfoTitle.setForeground(Color.decode("#0F2742"));

        lblInfoText = new JLabel("Data ringkasan diperbarui otomatis setiap hari");
        lblInfoText.setFont(new Font("Segoe UI", Font.PLAIN, 11));
        lblInfoText.setForeground(Color.DARK_GRAY);

        infoTextPanel.add(lblInfoTitle);
        infoTextPanel.add(Box.createRigidArea(new Dimension(0, 2)));
        infoTextPanel.add(lblInfoText);
        
        infoPanel.add(infoTextPanel);
        add(infoPanel, BorderLayout.WEST);

        // 2. Bagian Kanan: Live Date & Time Widget
        JPanel dateTimePanel = new JPanel(new GridBagLayout());
        dateTimePanel.setOpaque(false);
        GridBagConstraints gbc = new GridBagConstraints();
        gbc.fill = GridBagConstraints.HORIZONTAL;
        gbc.insets = new Insets(2, 5, 2, 5);

        lblDate = new JLabel("📅 -- ----- ----");
        lblDate.setFont(new Font("Segoe UI", Font.BOLD, 13));
        lblDate.setForeground(Color.decode("#0F2742"));

        lblTime = new JLabel("🕒 --.-- WIB");
        lblTime.setFont(new Font("Segoe UI", Font.BOLD, 13));
        lblTime.setForeground(Color.decode("#0F2742"));

        gbc.gridx = 0;
        gbc.gridy = 0;
        dateTimePanel.add(lblDate, gbc);

        gbc.gridy = 1;
        dateTimePanel.add(lblTime, gbc);

        add(dateTimePanel, BorderLayout.EAST);

        // Setup timer untuk update jam setiap detik
        timer = new Timer(1000, new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                updateDateTime();
            }
        });
        timer.start();
        updateDateTime(); // Jalankan pertama kali
    }

    private void updateDateTime() {
        Date sekarang = new Date();
        lblDate.setText("📅 " + dateFormat.format(sekarang));
        lblTime.setText("🕒 " + timeFormat.format(sekarang) + " WIB");
    }

    // Panggil ini saat panel ditutup/hancur agar timer berhenti
    public void stopTimer() {
        if (timer != null && timer.isRunning()) {
            timer.stop();
        }
    }
}
