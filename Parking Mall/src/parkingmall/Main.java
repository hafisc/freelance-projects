package parkingmall;

import javax.swing.SwingUtilities;
import parkingmall.view.LoginForm;

public class Main {
    // Fungsi utama untuk menjalankan aplikasi desktop Parking Mall
    public static void main(String[] args) {
        // Menjalankan UI di Event Dispatch Thread agar thread-safe
        SwingUtilities.invokeLater(new Runnable() {
            @Override
            public void run() {
                try {
                    // Menggunakan System Look and Feel agar tampilan mengikuti OS dan terlihat rapi
                    javax.swing.UIManager.setLookAndFeel(
                        javax.swing.UIManager.getSystemLookAndFeelClassName()
                    );
                    // Atur ButtonUI global ke BasicButtonUI agar warna tombol kustom tidak ter-override oleh OS Windows
                    javax.swing.UIManager.put("ButtonUI", "javax.swing.plaf.basic.BasicButtonUI");
                } catch (Exception e) {
                    System.err.println("Gagal mengatur Look and Feel: " + e.getMessage());
                }
                
                // Menampilkan form login utama
                new LoginForm().setVisible(true);
            }
        });
    }
}
