package parkingmall.helper;

import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.Random;

public class KodeGenerator {
    
    // Fungsi ini digunakan untuk menghasilkan kode booking unik (Format: BKG-YYYYMMDD-XXX)
    public static String generateBooking() {
        SimpleDateFormat sdf = new SimpleDateFormat("yyyyMMdd");
        String tanggal = sdf.format(new Date());
        int acak = new Random().nextInt(900) + 100; // 3 digit angka acak (100 - 999)
        return "BKG-" + tanggal + "-" + acak;
    }

    // Fungsi ini digunakan untuk menghasilkan kode transaksi unik (Format: TRX-YYYYMMDD-XXX)
    public static String generateTransaksi() {
        SimpleDateFormat sdf = new SimpleDateFormat("yyyyMMdd");
        String tanggal = sdf.format(new Date());
        int acak = new Random().nextInt(900) + 100; // 3 digit angka acak (100 - 999)
        return "TRX-" + tanggal + "-" + acak;
    }
}
