package com.labmobile.kulinerku.fragment;

import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.LinearLayoutManager;
import com.labmobile.kulinerku.activity.DetailActivity;
import com.labmobile.kulinerku.adapter.CategoryAdapter;
import com.labmobile.kulinerku.adapter.MealAdapter;
import com.labmobile.kulinerku.databinding.FragmentHomeBinding;
import com.labmobile.kulinerku.model.Category;
import com.labmobile.kulinerku.model.MealSummary;
import com.labmobile.kulinerku.network.ApiClient;
import com.labmobile.kulinerku.network.ApiService;
import com.labmobile.kulinerku.util.NetworkUtil;
import java.util.List;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

// Fragment halaman utama untuk mengambil dan menampilkan data kategori dan menu makanan dari API
public class HomeFragment extends Fragment implements CategoryAdapter.OnCategoryClickListener, MealAdapter.OnMealClickListener {

    private FragmentHomeBinding binding;
    private CategoryAdapter categoryAdapter;
    private MealAdapter mealAdapter;

    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        binding = FragmentHomeBinding.inflate(inflater, container, false);
        return binding.getRoot();
    }

    @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

        setupRecyclerViews();

        // Mengatur tombol Coba Lagi saat gagal memuat data
        binding.btnRetry.setOnClickListener(v -> loadCategoriesData());

        // Mengatur tombol search pada keyboard (IME Action Search)
        binding.etSearch.setOnEditorActionListener((v, actionId, event) -> {
            if (actionId == android.view.inputmethod.EditorInfo.IME_ACTION_SEARCH) {
                performSearch(binding.etSearch.getText().toString().trim());
                hideKeyboard();
                return true;
            }
            return false;
        });

        // Memantau perubahan teks untuk mendeteksi penghapusan kata kunci pencarian
        binding.etSearch.addTextChangedListener(new android.text.TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {}

            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {
                if (s.toString().trim().isEmpty()) {
                    if (categoryAdapter != null) {
                        Category selectedCategory = categoryAdapter.getSelectedCategory();
                        if (selectedCategory != null) {
                            loadMealsData(selectedCategory.getStrCategory());
                        }
                    }
                }
            }

            @Override
            public void afterTextChanged(android.text.Editable s) {}
        });

        loadCategoriesData();
    }

    // Menginisialisasi adapter dan layout manager untuk RecyclerView kategori dan makanan
    private void setupRecyclerViews() {
        categoryAdapter = new CategoryAdapter(this);
        binding.rvCategories.setLayoutManager(new LinearLayoutManager(getContext(), LinearLayoutManager.HORIZONTAL, false));
        binding.rvCategories.setAdapter(categoryAdapter);

        mealAdapter = new MealAdapter(this);
        binding.rvMeals.setLayoutManager(new GridLayoutManager(getContext(), 2));
        binding.rvMeals.setAdapter(mealAdapter);
    }

    // Memeriksa internet dan mengambil daftar kategori makanan dari API
    private void loadCategoriesData() {
        if (!NetworkUtil.isNetworkAvailable(requireContext())) {
            showErrorState();
            return;
        }

        showLoadingState();

        ApiClient.getApiService().getCategories().enqueue(new Callback<ApiService.CategoryResponse>() {
            @Override
            public void onResponse(@NonNull Call<ApiService.CategoryResponse> call, @NonNull Response<ApiService.CategoryResponse> response) {
                if (response.isSuccessful() && response.body() != null) {
                    List<Category> categories = response.body().getCategories();
                    if (categories != null && !categories.isEmpty()) {
                        categoryAdapter.setCategories(categories);
                        // Secara otomatis mengambil resep untuk kategori pertama yang terpilih
                        loadMealsData(categories.get(0).getStrCategory());
                    } else {
                        showErrorState();
                    }
                } else {
                    showErrorState();
                }
            }

            @Override
            public void onFailure(@NonNull Call<ApiService.CategoryResponse> call, @NonNull Throwable t) {
                showErrorState();
            }
        });
    }

    // Mengambil daftar makanan berdasarkan nama kategori yang sedang aktif dari API
    private void loadMealsData(String categoryName) {
        if (!NetworkUtil.isNetworkAvailable(requireContext())) {
            showErrorState();
            return;
        }

        binding.progressBar.setVisibility(View.VISIBLE);
        binding.tvSectionTitle.setText("Menu " + categoryName);

        ApiClient.getApiService().getMealsByCategory(categoryName).enqueue(new Callback<ApiService.MealSummaryResponse>() {
            @Override
            public void onResponse(@NonNull Call<ApiService.MealSummaryResponse> call, @NonNull Response<ApiService.MealSummaryResponse> response) {
                binding.progressBar.setVisibility(View.GONE);
                if (response.isSuccessful() && response.body() != null) {
                    List<MealSummary> meals = response.body().getMeals();
                    mealAdapter.setMeals(meals);
                    showContentState();
                } else {
                    showErrorState();
                }
            }

            @Override
            public void onFailure(@NonNull Call<ApiService.MealSummaryResponse> call, @NonNull Throwable t) {
                binding.progressBar.setVisibility(View.GONE);
                showErrorState();
            }
        });
    }

    // Callback ketika item kategori horizontal diklik oleh pengguna
    @Override
    public void onCategoryClick(Category category) {
        loadMealsData(category.getStrCategory());
    }

    // Callback ketika item card makanan di RecyclerView diklik
    @Override
    public void onMealClick(MealSummary meal) {
        Intent intent = new Intent(getActivity(), DetailActivity.class);
        intent.putExtra("meal_id", meal.getIdMeal());
        startActivity(intent);
    }

    // Mengubah tampilan menjadi loading state
    private void showLoadingState() {
        binding.progressBar.setVisibility(View.VISIBLE);
        binding.scrollContent.setVisibility(View.GONE);
        binding.layoutError.setVisibility(View.GONE);
    }

    // Mengubah tampilan menjadi error state (offline/kegagalan API)
    private void showErrorState() {
        binding.progressBar.setVisibility(View.GONE);
        binding.scrollContent.setVisibility(View.GONE);
        binding.layoutError.setVisibility(View.VISIBLE);
    }

    // Mengubah tampilan menjadi konten normal yang terisi resep makanan
    private void showContentState() {
        binding.progressBar.setVisibility(View.GONE);
        binding.scrollContent.setVisibility(View.VISIBLE);
        binding.layoutError.setVisibility(View.GONE);
    }

    // Mencari resep makanan berdasarkan kata kunci secara dinamis melalui API
    private void performSearch(String query) {
        if (query.isEmpty()) {
            return;
        }

        if (!NetworkUtil.isNetworkAvailable(requireContext())) {
            showErrorState();
            return;
        }

        binding.progressBar.setVisibility(View.VISIBLE);
        binding.tvSectionTitle.setText("Hasil Pencarian: \"" + query + "\"");

        ApiClient.getApiService().searchMealsByName(query).enqueue(new Callback<ApiService.MealSummaryResponse>() {
            @Override
            public void onResponse(@NonNull Call<ApiService.MealSummaryResponse> call, @NonNull Response<ApiService.MealSummaryResponse> response) {
                binding.progressBar.setVisibility(View.GONE);
                if (response.isSuccessful() && response.body() != null) {
                    List<MealSummary> meals = response.body().getMeals();
                    if (meals != null && !meals.isEmpty()) {
                        mealAdapter.setMeals(meals);
                        showContentState();
                    } else {
                        mealAdapter.setMeals(new java.util.ArrayList<>());
                        binding.tvSectionTitle.setText("Tidak ada hasil untuk \"" + query + "\"");
                        showContentState();
                    }
                } else {
                    showErrorState();
                }
            }

            @Override
            public void onFailure(@NonNull Call<ApiService.MealSummaryResponse> call, @NonNull Throwable t) {
                binding.progressBar.setVisibility(View.GONE);
                showErrorState();
            }
        });
    }

    // Menyembunyikan keyboard virtual
    private void hideKeyboard() {
        View view = getActivity().getCurrentFocus();
        if (view != null) {
            android.view.inputmethod.InputMethodManager imm = (android.view.inputmethod.InputMethodManager) 
                    getActivity().getSystemService(android.content.Context.INPUT_METHOD_SERVICE);
            if (imm != null) {
                imm.hideSoftInputFromWindow(view.getWindowToken(), 0);
            }
        }
    }

    @Override
    public void onDestroyView() {
        super.onDestroyView();
        binding = null;
    }
}
