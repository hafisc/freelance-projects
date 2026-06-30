package com.labmobile.kulinerku.model;

import com.google.gson.annotations.SerializedName;

// Model data untuk mewakili ringkasan data Makanan (Meal) dari API
public class MealSummary {
    @SerializedName("idMeal")
    private String idMeal;

    @SerializedName("strMeal")
    private String strMeal;

    @SerializedName("strMealThumb")
    private String strMealThumb;

    // Konstruktor kosong untuk Gson
    public MealSummary() {}

    // Konstruktor dengan parameter untuk instansiasi manual dari SQLite
    public MealSummary(String idMeal, String strMeal, String strMealThumb) {
        this.idMeal = idMeal;
        this.strMeal = strMeal;
        this.strMealThumb = strMealThumb;
    }

    // Mendapatkan ID Makanan
    public String getIdMeal() {
        return idMeal;
    }

    // Mendapatkan Nama Makanan
    public String getStrMeal() {
        return strMeal;
    }

    // Mendapatkan URL Gambar/Thumbnail Makanan
    public String getStrMealThumb() {
        return strMealThumb;
    }
}
