package com.example.roommonitor;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

import java.util.ArrayList;
import java.util.List;

/**
 * DatabaseHelper - Mengelola database SQLite.
 * Operasi: Tambah, Ambil, Update, Hapus, dan Cari data.
 */
public class DatabaseHelper extends SQLiteOpenHelper {

    // Nama dan versi database
    private static final String NAMA_DATABASE = "room_monitor.db";
    private static final int VERSI_DATABASE = 1;

    // Nama tabel dan kolom
    private static final String TABEL = "room_usage";
    private static final String KOL_ID = "id";
    private static final String KOL_RUANGAN = "room_name";
    private static final String KOL_PENGGUNA = "user_name";
    private static final String KOL_TANGGAL = "date";
    private static final String KOL_WAKTU_MULAI = "time_start";
    private static final String KOL_WAKTU_SELESAI = "time_end";
    private static final String KOL_KEPERLUAN = "purpose";
    private static final String KOL_KATEGORI = "category";

    // Singleton instance
    private static DatabaseHelper instance;

    // Singleton - pastikan hanya ada 1 objek DatabaseHelper
    public static synchronized DatabaseHelper getInstance(Context context) {
        if (instance == null) {
            instance = new DatabaseHelper(context.getApplicationContext());
        }
        return instance;
    }

    private DatabaseHelper(Context context) {
        super(context, NAMA_DATABASE, null, VERSI_DATABASE);
    }

    // Membuat tabel saat database pertama kali dibuat
    @Override
    public void onCreate(SQLiteDatabase db) {
        String buatTabel = "CREATE TABLE " + TABEL + " ("
                + KOL_ID + " INTEGER PRIMARY KEY AUTOINCREMENT, "
                + KOL_RUANGAN + " TEXT NOT NULL, "
                + KOL_PENGGUNA + " TEXT NOT NULL, "
                + KOL_TANGGAL + " TEXT NOT NULL, "
                + KOL_WAKTU_MULAI + " TEXT NOT NULL, "
                + KOL_WAKTU_SELESAI + " TEXT NOT NULL, "
                + KOL_KEPERLUAN + " TEXT NOT NULL, "
                + KOL_KATEGORI + " TEXT NOT NULL)";
        db.execSQL(buatTabel);
    }

    // Dipanggil saat versi database berubah
    @Override
    public void onUpgrade(SQLiteDatabase db, int versiLama, int versiBaru) {
        db.execSQL("DROP TABLE IF EXISTS " + TABEL);
        onCreate(db);
    }

    // ==================== TAMBAH DATA ====================
    public long tambahData(RoomUsage data) {
        SQLiteDatabase db = this.getWritableDatabase();
        ContentValues values = isiContentValues(data);
        long hasil = db.insert(TABEL, null, values);
        db.close();
        return hasil;
    }

    // ==================== AMBIL SEMUA DATA ====================
    public List<RoomUsage> ambilSemuaData() {
        List<RoomUsage> list = new ArrayList<>();
        SQLiteDatabase db = this.getReadableDatabase();

        // Ambil semua data, urutkan dari yang terbaru
        Cursor cursor = db.rawQuery("SELECT * FROM " + TABEL
                + " ORDER BY " + KOL_TANGGAL + " DESC, "
                + KOL_WAKTU_MULAI + " DESC", null);

        while (cursor.moveToNext()) {
            list.add(cursorKeObjek(cursor));
        }

        cursor.close();
        db.close();
        return list;
    }

    // ==================== AMBIL DATA BERDASARKAN ID ====================
    public RoomUsage ambilDataById(int id) {
        SQLiteDatabase db = this.getReadableDatabase();
        Cursor cursor = db.query(TABEL, null,
                KOL_ID + "=?", new String[]{String.valueOf(id)},
                null, null, null);

        RoomUsage data = null;
        if (cursor.moveToFirst()) {
            data = cursorKeObjek(cursor);
        }

        cursor.close();
        db.close();
        return data;
    }

    // ==================== UPDATE DATA ====================
    public int updateData(RoomUsage data) {
        SQLiteDatabase db = this.getWritableDatabase();
        int hasil = db.update(TABEL, isiContentValues(data),
                KOL_ID + "=?", new String[]{String.valueOf(data.getId())});
        db.close();
        return hasil;
    }

    // ==================== HAPUS DATA ====================
    public int hapusData(int id) {
        SQLiteDatabase db = this.getWritableDatabase();
        int hasil = db.delete(TABEL,
                KOL_ID + "=?", new String[]{String.valueOf(id)});
        db.close();
        return hasil;
    }

    // ==================== CARI DATA ====================
    public List<RoomUsage> cariData(String katakunci) {
        List<RoomUsage> list = new ArrayList<>();
        SQLiteDatabase db = this.getReadableDatabase();
        String pola = "%" + katakunci + "%";

        Cursor cursor = db.rawQuery("SELECT * FROM " + TABEL
                + " WHERE " + KOL_RUANGAN + " LIKE ? OR " + KOL_PENGGUNA + " LIKE ?"
                + " ORDER BY " + KOL_TANGGAL + " DESC",
                new String[]{pola, pola});

        while (cursor.moveToNext()) {
            list.add(cursorKeObjek(cursor));
        }

        cursor.close();
        db.close();
        return list;
    }

    // ==================== STATISTIK ====================

    // Hitung total semua data
    public int hitungTotal() {
        return hitungJumlah("SELECT COUNT(*) FROM " + TABEL, null);
    }

    // Hitung data hari ini
    public int hitungHariIni(String tanggalHariIni) {
        return hitungJumlah("SELECT COUNT(*) FROM " + TABEL
                + " WHERE " + KOL_TANGGAL + "=?", new String[]{tanggalHariIni});
    }

    // Hitung jumlah ruangan berbeda
    public int hitungRuanganUnik() {
        return hitungJumlah("SELECT COUNT(DISTINCT " + KOL_RUANGAN + ") FROM " + TABEL, null);
    }

    // ==================== METHOD PEMBANTU ====================

    // Helper: hitung jumlah dari query
    private int hitungJumlah(String query, String[] args) {
        SQLiteDatabase db = this.getReadableDatabase();
        Cursor cursor = db.rawQuery(query, args);
        int jumlah = 0;
        if (cursor.moveToFirst()) jumlah = cursor.getInt(0);
        cursor.close();
        db.close();
        return jumlah;
    }

    // Helper: isi ContentValues dari objek RoomUsage
    private ContentValues isiContentValues(RoomUsage data) {
        ContentValues values = new ContentValues();
        values.put(KOL_RUANGAN, data.getRoomName());
        values.put(KOL_PENGGUNA, data.getUserName());
        values.put(KOL_TANGGAL, data.getDate());
        values.put(KOL_WAKTU_MULAI, data.getTimeStart());
        values.put(KOL_WAKTU_SELESAI, data.getTimeEnd());
        values.put(KOL_KEPERLUAN, data.getPurpose());
        values.put(KOL_KATEGORI, data.getCategory());
        return values;
    }

    // Helper: ubah baris Cursor jadi objek RoomUsage
    private RoomUsage cursorKeObjek(Cursor c) {
        return new RoomUsage(
                c.getInt(c.getColumnIndexOrThrow(KOL_ID)),
                c.getString(c.getColumnIndexOrThrow(KOL_RUANGAN)),
                c.getString(c.getColumnIndexOrThrow(KOL_PENGGUNA)),
                c.getString(c.getColumnIndexOrThrow(KOL_TANGGAL)),
                c.getString(c.getColumnIndexOrThrow(KOL_WAKTU_MULAI)),
                c.getString(c.getColumnIndexOrThrow(KOL_WAKTU_SELESAI)),
                c.getString(c.getColumnIndexOrThrow(KOL_KEPERLUAN)),
                c.getString(c.getColumnIndexOrThrow(KOL_KATEGORI)));
    }
}
