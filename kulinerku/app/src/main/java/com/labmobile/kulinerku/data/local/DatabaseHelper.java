package com.labmobile.kulinerku.data.local;

import android.content.Context;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

// Helper SQLite database untuk mengelola pembuatan dan upgrade tabel favorit
public class DatabaseHelper extends SQLiteOpenHelper {
    private static final String DATABASE_NAME = "kulinerku.db";
    private static final int DATABASE_VERSION = 1;

    // Nama tabel
    public static final String TABLE_FAVORITE = "favorite_meals";

    // Nama kolom
    public static final String COLUMN_ID_MEAL = "id_meal";
    public static final String COLUMN_NAMA = "nama";
    public static final String COLUMN_THUMBNAIL_URL = "thumbnail_url";
    public static final String COLUMN_KATEGORI = "kategori";
    public static final String COLUMN_INSTRUKSI = "instruksi";
    public static final String COLUMN_BAHAN = "bahan";
    public static final String COLUMN_TANGGAL_SIMPAN = "tanggal_simpan";

    // SQL Query untuk membuat tabel
    private static final String CREATE_TABLE_FAVORITE = "CREATE TABLE " + TABLE_FAVORITE + " ("
            + COLUMN_ID_MEAL + " TEXT PRIMARY KEY, "
            + COLUMN_NAMA + " TEXT, "
            + COLUMN_THUMBNAIL_URL + " TEXT, "
            + COLUMN_KATEGORI + " TEXT, "
            + COLUMN_INSTRUKSI + " TEXT, "
            + COLUMN_BAHAN + " TEXT, "
            + COLUMN_TANGGAL_SIMPAN + " TEXT"
            + ");";

    // Konstruktor DatabaseHelper
    public DatabaseHelper(Context context) {
        super(context, DATABASE_NAME, null, DATABASE_VERSION);
    }

    @Override
    public void onCreate(SQLiteDatabase db) {
        // Membuat tabel favorite_meals di SQLite
        db.execSQL(CREATE_TABLE_FAVORITE);
    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
        // Menghapus tabel lama jika ada pembaruan versi database
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_FAVORITE);
        onCreate(db);
    }
}
