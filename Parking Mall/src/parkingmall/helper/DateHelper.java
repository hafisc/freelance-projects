package parkingmall.helper;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;

public class DateHelper {
    private static final SimpleDateFormat sdfDatabase = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
    private static final SimpleDateFormat sdfDisplay = new SimpleDateFormat("dd-MM-yyyy HH:mm");

    // Fungsi ini digunakan untuk memformat objek Date menjadi String untuk kebutuhan database
    public static String toDatabaseString(Date date) {
        if (date == null) return null;
        return sdfDatabase.format(date);
    }

    // Fungsi ini digunakan untuk memformat objek Date menjadi String tampilan user interface
    public static String toDisplayString(Date date) {
        if (date == null) return "-";
        return sdfDisplay.format(date);
    }

    // Fungsi ini digunakan untuk mengubah String database ke objek Date
    public static Date toDate(String dateStr) {
        if (dateStr == null || dateStr.trim().isEmpty()) return null;
        try {
            return sdfDatabase.parse(dateStr);
        } catch (ParseException e) {
            try {
                return sdfDisplay.parse(dateStr);
            } catch (ParseException ex) {
                ex.printStackTrace();
                return null;
            }
        }
    }

    // Fungsi ini digunakan untuk menghitung selisih durasi jam antara waktu masuk dan keluar (dibulatkan ke atas)
    public static int hitungDurasiJam(Date masuk, Date keluar) {
        if (masuk == null || keluar == null) return 0;
        long diffMs = keluar.getTime() - masuk.getTime();
        if (diffMs <= 0) return 1; // Minimal dihitung 1 jam
        
        double diffHours = (double) diffMs / (1000 * 60 * 60);
        return (int) Math.ceil(diffHours);
    }
}
