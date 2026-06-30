package com.labmobile.kulinerku.activity;

import android.os.Bundle;
import android.view.View;
import android.widget.TextView;
import android.widget.Toast;
import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;
import com.bumptech.glide.Glide;
import com.bumptech.glide.load.resource.drawable.DrawableTransitionOptions;
import com.labmobile.kulinerku.R;
import com.labmobile.kulinerku.data.local.FavoriteDao;
import com.labmobile.kulinerku.databinding.ActivityDetailBinding;
import com.labmobile.kulinerku.model.MealDetail;
import com.labmobile.kulinerku.network.ApiClient;
import com.labmobile.kulinerku.network.ApiService;
import com.labmobile.kulinerku.util.NetworkUtil;
import com.labmobile.kulinerku.util.ThreadExecutor;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

// Activity untuk menampilkan detail resep masakan, memuat data dari internet/lokal, dan menyimpan ke favorit
public class DetailActivity extends AppCompatActivity {

    private ActivityDetailBinding binding;
    private String mealId;
    private FavoriteDao favoriteDao;
    private ThreadExecutor executor;
    private MealDetail loadedMealDetail;
    private boolean isFavorite = false;

    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        binding = ActivityDetailBinding.inflate(getLayoutInflater());
        setContentView(binding.getRoot());

        mealId = getIntent().getStringExtra("meal_id");
        if (mealId == null || mealId.trim().isEmpty()) {
            Toast.makeText(this, "ID Makanan tidak valid", Toast.LENGTH_SHORT).show();
            finish();
            return;
        }

        favoriteDao = new FavoriteDao(this);
        executor = ThreadExecutor.getInstance();

        setupToolbar();
        checkFavoriteStatus();

        // Mengatur tombol Coba Lagi saat gagal memuat data
        binding.btnRetryDetail.setOnClickListener(v -> fetchMealDetail());

        fetchMealDetail();

        // Mengatur tombol klik favorit
        binding.fabFavorite.setOnClickListener(v -> toggleFavorite());
    }

    // Mengkonfigurasi Toolbar back navigation
    private void setupToolbar() {
        setSupportActionBar(binding.detailToolbar);
        if (getSupportActionBar() != null) {
            getSupportActionBar().setDisplayHomeAsUpEnabled(true);
            getSupportActionBar().setTitle("");
        }
        binding.detailToolbar.setNavigationOnClickListener(v -> onBackPressed());
    }

    // Mengecek apakah makanan sudah disimpan sebagai favorit secara asinkron di database SQLite
    private void checkFavoriteStatus() {
        executor.execute(() -> {
            boolean fav = favoriteDao.isFavorite(mealId);
            runOnUiThread(() -> {
                isFavorite = fav;
                updateFavoriteFabIcon();
            });
        });
    }

    // Mengambil data detail makanan dari internet, atau dari SQLite jika sedang offline
    private void fetchMealDetail() {
        showLoadingState();

        if (!NetworkUtil.isNetworkAvailable(this)) {
            // Jika offline, coba load dari SQLite lokal
            loadFromLocalDatabase();
            return;
        }

        // Jika online, ambil dari API TheMealDB
        ApiClient.getApiService().getMealDetail(mealId).enqueue(new Callback<ApiService.MealDetailResponse>() {
            @Override
            public void onResponse(@NonNull Call<ApiService.MealDetailResponse> call, @NonNull Response<ApiService.MealDetailResponse> response) {
                if (response.isSuccessful() && response.body() != null && response.body().getMeals() != null && !response.body().getMeals().isEmpty()) {
                    loadedMealDetail = response.body().getMeals().get(0);
                    populateUi(loadedMealDetail);
                    showContentState();
                } else {
                    // Jika gagal memuat dari API, coba fallback ke SQLite
                    loadFromLocalDatabase();
                }
            }

            @Override
            public void onFailure(@NonNull Call<ApiService.MealDetailResponse> call, @NonNull Throwable t) {
                // Jika gagal koneksi API, coba fallback ke SQLite
                loadFromLocalDatabase();
            }
        });
    }

    // Mencoba memuat detail resep makanan dari database lokal SQLite
    private void loadFromLocalDatabase() {
        executor.execute(() -> {
            MealDetail localMeal = favoriteDao.getFavoriteDetail(mealId);
            runOnUiThread(() -> {
                if (localMeal != null) {
                    loadedMealDetail = localMeal;
                    populateUi(localMeal);
                    showContentState();
                    Toast.makeText(DetailActivity.this, "Menampilkan resep yang disimpan secara offline", Toast.LENGTH_LONG).show();
                } else {
                    showErrorState();
                }
            });
        });
    }

    // Mengisi komponen UI dengan data resep masakan yang telah diambil
    private void populateUi(MealDetail meal) {
        binding.tvMealName.setText(meal.getStrMeal());
        binding.tvMealCategory.setText(meal.getStrCategory());
        binding.tvMealInstructions.setText(meal.getStrInstructions());

        // Load gambar makanan menggunakan Glide secara smooth dengan crossfade
        Glide.with(this)
                .load(meal.getStrMealThumb())
                .transition(DrawableTransitionOptions.withCrossFade())
                .placeholder(R.drawable.ic_home)
                .error(R.drawable.ic_home)
                .into(binding.ivMealImage);

        // Bersihkan dan tambahkan daftar bahan-bahan secara dinamis
        binding.layoutIngredients.removeAllViews();
        if (meal.getIngredients() != null) {
            for (String ingredient : meal.getIngredients()) {
                TextView tvIngredient = new TextView(this);
                tvIngredient.setText("•  " + ingredient);
                tvIngredient.setTextColor(getResources().getColor(R.color.gray_muted));
                if (android.os.Build.VERSION.SDK_INT >= android.os.Build.VERSION_CODES.M) {
                    tvIngredient.setTextColor(getColor(R.color.gray_muted));
                }
                tvIngredient.setTextSize(14);
                tvIngredient.setPadding(0, 6, 0, 6);
                binding.layoutIngredients.addView(tvIngredient);
            }
        }
    }

    // Menangani aksi klik tombol favorit untuk menambah atau menghapus resep dari SQLite
    private void toggleFavorite() {
        if (loadedMealDetail == null) {
            Toast.makeText(this, "Resep belum selesai dimuat", Toast.LENGTH_SHORT).show();
            return;
        }

        executor.execute(() -> {
            if (isFavorite) {
                favoriteDao.deleteFavorite(mealId);
                runOnUiThread(() -> {
                    isFavorite = false;
                    updateFavoriteFabIcon();
                    Toast.makeText(DetailActivity.this, "Dihapus dari favorit", Toast.LENGTH_SHORT).show();
                });
            } else {
                favoriteDao.insertFavorite(loadedMealDetail);
                runOnUiThread(() -> {
                    isFavorite = true;
                    updateFavoriteFabIcon();
                    Toast.makeText(DetailActivity.this, "Disimpan ke favorit", Toast.LENGTH_SHORT).show();
                });
            }
        });
    }

    // Mengubah ikon Floating Action Button berdasarkan status favorit saat ini
    private void updateFavoriteFabIcon() {
        if (isFavorite) {
            binding.fabFavorite.setImageResource(R.drawable.ic_favorite_filled);
        } else {
            binding.fabFavorite.setImageResource(R.drawable.ic_favorite);
        }
    }

    // Menampilkan state loading
    private void showLoadingState() {
        binding.progressBar.setVisibility(View.VISIBLE);
        binding.appBarLayout.setVisibility(View.GONE);
        binding.scrollDetailContent.setVisibility(View.GONE);
        binding.fabFavorite.setVisibility(View.GONE);
        binding.layoutErrorDetail.setVisibility(View.GONE);
    }

    // Menampilkan state error/gagal koneksi
    private void showErrorState() {
        binding.progressBar.setVisibility(View.GONE);
        binding.appBarLayout.setVisibility(View.GONE);
        binding.scrollDetailContent.setVisibility(View.GONE);
        binding.fabFavorite.setVisibility(View.GONE);
        binding.layoutErrorDetail.setVisibility(View.VISIBLE);
    }

    // Menampilkan state konten resep masakan normal
    private void showContentState() {
        binding.progressBar.setVisibility(View.GONE);
        binding.appBarLayout.setVisibility(View.VISIBLE);
        binding.scrollDetailContent.setVisibility(View.VISIBLE);
        binding.fabFavorite.setVisibility(View.VISIBLE);
        binding.layoutErrorDetail.setVisibility(View.GONE);
    }
}
