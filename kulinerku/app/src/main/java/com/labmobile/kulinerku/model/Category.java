package com.labmobile.kulinerku.model;

import com.google.gson.annotations.SerializedName;

// Model data untuk mewakili Kategori makanan dari API TheMealDB
public class Category {
    @SerializedName("idCategory")
    private String idCategory;

    @SerializedName("strCategory")
    private String strCategory;

    @SerializedName("strCategoryThumb")
    private String strCategoryThumb;

    @SerializedName("strCategoryDescription")
    private String strCategoryDescription;

    // Mendapatkan ID Kategori
    public String getIdCategory() {
        return idCategory;
    }

    // Mendapatkan Nama Kategori
    public String getStrCategory() {
        return strCategory;
    }

    // Mendapatkan URL Gambar/Thumbnail Kategori
    public String getStrCategoryThumb() {
        return strCategoryThumb;
    }

    // Mendapatkan Deskripsi Kategori
    public String getStrCategoryDescription() {
        return strCategoryDescription;
    }
}
