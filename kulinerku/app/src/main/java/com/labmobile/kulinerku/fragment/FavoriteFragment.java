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
import com.labmobile.kulinerku.activity.DetailActivity;
import com.labmobile.kulinerku.adapter.MealAdapter;
import com.labmobile.kulinerku.data.local.FavoriteDao;
import com.labmobile.kulinerku.databinding.FragmentFavoriteBinding;
import com.labmobile.kulinerku.model.MealSummary;
import com.labmobile.kulinerku.util.ThreadExecutor;
import java.util.List;

// Fragment untuk menampilkan seluruh daftar resep masakan yang difavoritkan oleh pengguna dari SQLite (berjalan offline)
public class FavoriteFragment extends Fragment implements MealAdapter.OnMealClickListener {

    private FragmentFavoriteBinding binding;
    private MealAdapter adapter;
    private FavoriteDao favoriteDao;
    private ThreadExecutor executor;

    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        binding = FragmentFavoriteBinding.inflate(inflater, container, false);
        return binding.getRoot();
    }

    @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

        favoriteDao = new FavoriteDao(requireContext());
        executor = ThreadExecutor.getInstance();

        setupRecyclerView();
    }

    @Override
    public void onResume() {
        super.onResume();
        // Load data favorit setiap kali fragment aktif kembali untuk memastikan sinkronisasi realtime
        loadFavoriteMeals();
    }

    // Menginisialisasi adapter dan layout manager grid untuk list favorit
    private void setupRecyclerView() {
        adapter = new MealAdapter(this);
        binding.rvFavorites.setLayoutManager(new GridLayoutManager(getContext(), 2));
        binding.rvFavorites.setAdapter(adapter);
    }

    // Membaca database SQLite di background thread untuk mengambil daftar resep favorit
    private void loadFavoriteMeals() {
        executor.execute(() -> {
            List<MealSummary> favorites = favoriteDao.getAllFavorites();
            // Posting data hasil query ke main thread untuk pembaruan UI
            if (getActivity() != null) {
                getActivity().runOnUiThread(() -> {
                    if (favorites != null && !favorites.isEmpty()) {
                        adapter.setMeals(favorites);
                        showContentState();
                    } else {
                        showEmptyState();
                    }
                });
            }
        });
    }

    // Callback ketika resep makanan favorit diklik untuk membuka halaman detail
    @Override
    public void onMealClick(MealSummary meal) {
        Intent intent = new Intent(getActivity(), DetailActivity.class);
        intent.putExtra("meal_id", meal.getIdMeal());
        startActivity(intent);
    }

    // Menampilkan state empty (belum ada resep yang difavoritkan)
    private void showEmptyState() {
        binding.scrollFavoriteContent.setVisibility(View.GONE);
        binding.layoutEmptyFavorite.setVisibility(View.VISIBLE);
    }

    // Menampilkan daftar konten favorit
    private void showContentState() {
        binding.scrollFavoriteContent.setVisibility(View.VISIBLE);
        binding.layoutEmptyFavorite.setVisibility(View.GONE);
    }

    @Override
    public void onDestroyView() {
        super.onDestroyView();
        binding = null;
    }
}
