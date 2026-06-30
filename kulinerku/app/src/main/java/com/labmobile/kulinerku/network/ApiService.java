package com.labmobile.kulinerku.network;

import com.google.gson.annotations.SerializedName;
import com.labmobile.kulinerku.model.Category;
import com.labmobile.kulinerku.model.MealDetail;
import com.labmobile.kulinerku.model.MealSummary;
import java.util.List;
import retrofit2.Call;
import retrofit2.http.GET;
import retrofit2.http.Query;

// Interface Retrofit untuk mendefinisikan seluruh endpoint API dari TheMealDB
public interface ApiService {

    // Mengambil daftar kategori makanan dari API
    @GET("categories.php")
    Call<CategoryResponse> getCategories();

    // Mengambil daftar makanan berdasarkan kategori tertentu
    @GET("filter.php")
    Call<MealSummaryResponse> getMealsByCategory(@Query("c") String category);

    // Mengambil detail lengkap suatu makanan berdasarkan ID makanan
    @GET("lookup.php")
    Call<MealDetailResponse> getMealDetail(@Query("i") String mealId);

    // Mencari makanan berdasarkan kata kunci nama makanan
    @GET("search.php")
    Call<MealSummaryResponse> searchMealsByName(@Query("s") String query);

    // Wrapper response untuk mendapatkan daftar kategori
    class CategoryResponse {
        @SerializedName("categories")
        private List<Category> categories;

        // Mendapatkan list kategori makanan
        public List<Category> getCategories() {
            return categories;
        }
    }

    // Wrapper response untuk mendapatkan daftar ringkasan makanan
    class MealSummaryResponse {
        @SerializedName("meals")
        private List<MealSummary> meals;

        // Mendapatkan list ringkasan makanan
        public List<MealSummary> getMeals() {
            return meals;
        }
    }

    // Wrapper response untuk mendapatkan detail lengkap makanan
    class MealDetailResponse {
        @SerializedName("meals")
        private List<MealDetail> meals;

        // Mendapatkan list detail makanan (biasanya berisi 1 item)
        public List<MealDetail> getMeals() {
            return meals;
        }
    }
}
