package com.labmobile.kulinerku.model;

import com.google.gson.annotations.SerializedName;
import java.util.ArrayList;
import java.util.List;

// Model data untuk mewakili detail lengkap satu Makanan dari API
public class MealDetail {
    @SerializedName("idMeal")
    private String idMeal;

    @SerializedName("strMeal")
    private String strMeal;

    @SerializedName("strCategory")
    private String strCategory;

    @SerializedName("strInstructions")
    private String strInstructions;

    @SerializedName("strMealThumb")
    private String strMealThumb;

    // Mapping 20 bahan-bahan dari API TheMealDB
    @SerializedName("strIngredient1") private String strIngredient1;
    @SerializedName("strIngredient2") private String strIngredient2;
    @SerializedName("strIngredient3") private String strIngredient3;
    @SerializedName("strIngredient4") private String strIngredient4;
    @SerializedName("strIngredient5") private String strIngredient5;
    @SerializedName("strIngredient6") private String strIngredient6;
    @SerializedName("strIngredient7") private String strIngredient7;
    @SerializedName("strIngredient8") private String strIngredient8;
    @SerializedName("strIngredient9") private String strIngredient9;
    @SerializedName("strIngredient10") private String strIngredient10;
    @SerializedName("strIngredient11") private String strIngredient11;
    @SerializedName("strIngredient12") private String strIngredient12;
    @SerializedName("strIngredient13") private String strIngredient13;
    @SerializedName("strIngredient14") private String strIngredient14;
    @SerializedName("strIngredient15") private String strIngredient15;
    @SerializedName("strIngredient16") private String strIngredient16;
    @SerializedName("strIngredient17") private String strIngredient17;
    @SerializedName("strIngredient18") private String strIngredient18;
    @SerializedName("strIngredient19") private String strIngredient19;
    @SerializedName("strIngredient20") private String strIngredient20;

    // Mapping 20 takaran bahan dari API TheMealDB
    @SerializedName("strMeasure1") private String strMeasure1;
    @SerializedName("strMeasure2") private String strMeasure2;
    @SerializedName("strMeasure3") private String strMeasure3;
    @SerializedName("strMeasure4") private String strMeasure4;
    @SerializedName("strMeasure5") private String strMeasure5;
    @SerializedName("strMeasure6") private String strMeasure6;
    @SerializedName("strMeasure7") private String strMeasure7;
    @SerializedName("strMeasure8") private String strMeasure8;
    @SerializedName("strMeasure9") private String strMeasure9;
    @SerializedName("strMeasure10") private String strMeasure10;
    @SerializedName("strMeasure11") private String strMeasure11;
    @SerializedName("strMeasure12") private String strMeasure12;
    @SerializedName("strMeasure13") private String strMeasure13;
    @SerializedName("strMeasure14") private String strMeasure14;
    @SerializedName("strMeasure15") private String strMeasure15;
    @SerializedName("strMeasure16") private String strMeasure16;
    @SerializedName("strMeasure17") private String strMeasure17;
    @SerializedName("strMeasure18") private String strMeasure18;
    @SerializedName("strMeasure19") private String strMeasure19;
    @SerializedName("strMeasure20") private String strMeasure20;

    private List<String> sqliteIngredients = null;

    // Konstruktor kosong untuk Gson
    public MealDetail() {}

    // Konstruktor dengan parameter untuk instansiasi dari SQLite
    public MealDetail(String idMeal, String strMeal, String strCategory, String strInstructions, String strMealThumb, List<String> sqliteIngredients) {
        this.idMeal = idMeal;
        this.strMeal = strMeal;
        this.strCategory = strCategory;
        this.strInstructions = strInstructions;
        this.strMealThumb = strMealThumb;
        this.sqliteIngredients = sqliteIngredients;
    }

    // Mendapatkan ID Makanan
    public String getIdMeal() {
        return idMeal;
    }

    // Mendapatkan Nama Makanan
    public String getStrMeal() {
        return strMeal;
    }

    // Mendapatkan Kategori Makanan
    public String getStrCategory() {
        return strCategory;
    }

    // Mendapatkan Instruksi Cara Memasak Makanan
    public String getStrInstructions() {
        return strInstructions;
    }

    // Mendapatkan URL Gambar/Thumbnail Makanan
    public String getStrMealThumb() {
        return strMealThumb;
    }

    // Menggabungkan dan memformat daftar bahan-bahan beserta takarannya
    public List<String> getIngredients() {
        if (sqliteIngredients != null) {
            return sqliteIngredients;
        }
        List<String> list = new ArrayList<>();
        addIngredient(list, strIngredient1, strMeasure1);
        addIngredient(list, strIngredient2, strMeasure2);
        addIngredient(list, strIngredient3, strMeasure3);
        addIngredient(list, strIngredient4, strMeasure4);
        addIngredient(list, strIngredient5, strMeasure5);
        addIngredient(list, strIngredient6, strMeasure6);
        addIngredient(list, strIngredient7, strMeasure7);
        addIngredient(list, strIngredient8, strMeasure8);
        addIngredient(list, strIngredient9, strMeasure9);
        addIngredient(list, strIngredient10, strMeasure10);
        addIngredient(list, strIngredient11, strMeasure11);
        addIngredient(list, strIngredient12, strMeasure12);
        addIngredient(list, strIngredient13, strMeasure13);
        addIngredient(list, strIngredient14, strMeasure14);
        addIngredient(list, strIngredient15, strMeasure15);
        addIngredient(list, strIngredient16, strMeasure16);
        addIngredient(list, strIngredient17, strMeasure17);
        addIngredient(list, strIngredient18, strMeasure18);
        addIngredient(list, strIngredient19, strMeasure19);
        addIngredient(list, strIngredient20, strMeasure20);
        return list;
    }

    // Validasi dan format bahan yang tidak kosong ke dalam list
    private void addIngredient(List<String> list, String ingredient, String measure) {
        if (ingredient != null && !ingredient.trim().isEmpty()) {
            String formatted = ingredient.trim();
            if (measure != null && !measure.trim().isEmpty()) {
                formatted = measure.trim() + " " + formatted;
            }
            list.add(formatted);
        }
    }
}
