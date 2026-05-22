package parkingmall.helper;

import java.awt.Component;
import javax.swing.JOptionPane;

public class MessageHelper {

    // Fungsi ini digunakan untuk menampilkan pesan informasi/sukses
    public static void showInfo(Component parent, String message) {
        JOptionPane.showMessageDialog(parent, message, "Informasi", JOptionPane.INFORMATION_MESSAGE);
    }

    // Fungsi ini digunakan untuk menampilkan pesan error/gagal
    public static void showError(Component parent, String message) {
        JOptionPane.showMessageDialog(parent, message, "Error", JOptionPane.ERROR_MESSAGE);
    }

    // Fungsi ini digunakan untuk menampilkan pesan peringatan
    public static void showWarning(Component parent, String message) {
        JOptionPane.showMessageDialog(parent, message, "Peringatan", JOptionPane.WARNING_MESSAGE);
    }

    // Fungsi ini digunakan untuk menampilkan dialog konfirmasi yes/no
    public static boolean showConfirm(Component parent, String message) {
        int pilihan = JOptionPane.showConfirmDialog(parent, message, "Konfirmasi", JOptionPane.YES_NO_OPTION);
        return pilihan == JOptionPane.YES_OPTION;
    }
}
