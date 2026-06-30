package com.labmobile.kulinerku.data.local;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.text.TextUtils;
import com.labmobile.kulinerku.model.MealDetail;
import com.labmobile.kulinerku.model.MealSummary;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Date;
import java.util.List;
import java.util.Locale;

// Data Access Object (DAO) untuk mengelola data favorit di database SQLite
public class FavoriteDao {
    private final DatabaseHelper dbHelper;

    // Inisialisasi FavoriteDao menggunakan Context
    public FavoriteDao(Context context) {
        this.dbHelper = new DatabaseHelper(context);
    }

    // Memasukkan data makanan baru ke daftar favorit di SQLite
    public long insertFavorite(MealDetail meal) {
        SQLiteDatabase db = dbHelper.getWritableDatabase();
        ContentValues values = new ContentValues();
        values.put(DatabaseHelper.COLUMN_ID_MEAL, meal.getIdMeal());
        values.put(DatabaseHelper.COLUMN_NAMA, meal.getStrMeal());
        values.put(DatabaseHelper.COLUMN_THUMBNAIL_URL, meal.getStrMealThumb());
        values.put(DatabaseHelper.COLUMN_KATEGORI, meal.getStrCategory());
        values.put(DatabaseHelper.COLUMN_INSTRUKSI, meal.getStrInstructions());

        // Menggabungkan list bahan-bahan dengan delimiter newline agar dapat disimpan di SQLite
        String bahanJoined = "";
        if (meal.getIngredients() != null) {
            bahanJoined = TextUtils.join("\n", meal.getIngredients());
        }
        values.put(DatabaseHelper.COLUMN_BAHAN, bahanJoined);

        // Menambahkan tanggal saat ini untuk pelacakan tanggal simpan
        String currentDate = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss", Locale.getDefault()).format(new Date());
        values.put(DatabaseHelper.COLUMN_TANGGAL_SIMPAN, currentDate);

        long result = db.insertWithOnConflict(DatabaseHelper.TABLE_FAVORITE, null, values, SQLiteDatabase.CONFLICT_REPLACE);
        db.close();
        return result;
    }

    // Menghapus data makanan dari daftar favorit berdasarkan ID makanan
    public int deleteFavorite(String idMeal) {
        SQLiteDatabase db = dbHelper.getWritableDatabase();
        int rows = db.delete(DatabaseHelper.TABLE_FAVORITE, DatabaseHelper.COLUMN_ID_MEAL + " = ?", new String[]{idMeal});
        db.close();
        return rows;
    }

    // Memeriksa apakah makanan dengan ID tertentu sudah disimpan di favorit
    public boolean isFavorite(String idMeal) {
        SQLiteDatabase db = dbHelper.getReadableDatabase();
        Cursor cursor = db.query(DatabaseHelper.TABLE_FAVORITE,
                new String[]{DatabaseHelper.COLUMN_ID_MEAL},
                DatabaseHelper.COLUMN_ID_MEAL + " = ?",
                new String[]{idMeal}, null, null, null);

        boolean exists = (cursor != null && cursor.getCount() > 0);
        if (cursor != null) {
            cursor.close();
        }
        db.close();
        return exists;
    }

    // Mengambil semua data makanan favorit untuk ditampilkan di halaman list favorit
    public List<MealSummary> getAllFavorites() {
        List<MealSummary> list = new ArrayList<>();
        SQLiteDatabase db = dbHelper.getReadableDatabase();
        
        // Query untuk mengurutkan favorit berdasarkan tanggal simpan terbaru
        String selectQuery = "SELECT * FROM " + DatabaseHelper.TABLE_FAVORITE 
                + " ORDER BY " + DatabaseHelper.COLUMN_TANGGAL_SIMPAN + " DESC";
        
        Cursor cursor = db.rawQuery(selectQuery, null);

        if (cursor.moveToFirst()) {
            do {
                int idIndex = cursor.getColumnIndex(DatabaseHelper.COLUMN_ID_MEAL);
                int namaIndex = cursor.getColumnIndex(DatabaseHelper.COLUMN_NAMA);
                int thumbIndex = cursor.getColumnIndex(DatabaseHelper.COLUMN_THUMBNAIL_URL);

                String idMeal = (idIndex != -1) ? cursor.getString(idIndex) : "";
                String nama = (namaIndex != -1) ? cursor.getString(namaIndex) : "";
                String thumbnailUrl = (thumbIndex != -1) ? cursor.getString(thumbIndex) : "";

                list.add(new MealSummary(idMeal, nama, thumbnailUrl));
            } while (cursor.moveToNext());
        }

        if (cursor != null) {
            cursor.close();
        }
        db.close();
        return list;
    }

    // Mengambil detail lengkap makanan favorit dari SQLite saat offline
    public MealDetail getFavoriteDetail(String idMeal) {
        SQLiteDatabase db = dbHelper.getReadableDatabase();
        Cursor cursor = db.query(DatabaseHelper.TABLE_FAVORITE,
                null,
                DatabaseHelper.COLUMN_ID_MEAL + " = ?",
                new String[]{idMeal}, null, null, null);

        MealDetail meal = null;
        if (cursor != null && cursor.moveToFirst()) {
            int idIndex = cursor.getColumnIndex(DatabaseHelper.COLUMN_ID_MEAL);
            int namaIndex = cursor.getColumnIndex(DatabaseHelper.COLUMN_NAMA);
            int categoryIndex = cursor.getColumnIndex(DatabaseHelper.COLUMN_KATEGORI);
            int instructionsIndex = cursor.getColumnIndex(DatabaseHelper.COLUMN_INSTRUKSI);
            int thumbIndex = cursor.getColumnIndex(DatabaseHelper.COLUMN_THUMBNAIL_URL);
            int bahanIndex = cursor.getColumnIndex(DatabaseHelper.COLUMN_BAHAN);

            String id = (idIndex != -1) ? cursor.getString(idIndex) : "";
            String nama = (namaIndex != -1) ? cursor.getString(namaIndex) : "";
            String kategori = (categoryIndex != -1) ? cursor.getString(categoryIndex) : "";
            String instruksi = (instructionsIndex != -1) ? cursor.getString(instructionsIndex) : "";
            String thumbnail = (thumbIndex != -1) ? cursor.getString(thumbIndex) : "";
            String bahanRaw = (bahanIndex != -1) ? cursor.getString(bahanIndex) : "";

            List<String> bahanList = new ArrayList<>();
            if (!TextUtils.isEmpty(bahanRaw)) {
                bahanList = new ArrayList<>(Arrays.asList(bahanRaw.split("\n")));
            }

            meal = new MealDetail(id, nama, kategori, instruksi, thumbnail, bahanList);
        }

        if (cursor != null) {
            cursor.close();
        }
        db.close();
        return meal;
    }
}
