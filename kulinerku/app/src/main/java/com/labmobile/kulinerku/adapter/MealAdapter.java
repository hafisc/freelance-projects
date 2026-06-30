package com.labmobile.kulinerku.adapter;

import android.view.LayoutInflater;
import android.view.ViewGroup;
import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;
import com.bumptech.glide.Glide;
import com.bumptech.glide.load.resource.drawable.DrawableTransitionOptions;
import com.labmobile.kulinerku.R;
import com.labmobile.kulinerku.databinding.ItemMealBinding;
import com.labmobile.kulinerku.model.MealSummary;
import java.util.ArrayList;
import java.util.List;

// Adapter RecyclerView untuk menampilkan daftar makanan dalam bentuk grid dengan gambar full-bleed
public class MealAdapter extends RecyclerView.Adapter<MealAdapter.ViewHolder> {

    private final List<MealSummary> meals = new ArrayList<>();
    private final OnMealClickListener listener;

    // Interface callback untuk menangani klik pada item makanan
    public interface OnMealClickListener {
        void onMealClick(MealSummary meal);
    }

    // Konstruktor MealAdapter
    public MealAdapter(OnMealClickListener listener) {
        this.listener = listener;
    }

    // Memperbarui daftar makanan dan merender ulang RecyclerView
    public void setMeals(List<MealSummary> newMeals) {
        this.meals.clear();
        if (newMeals != null) {
            this.meals.addAll(newMeals);
        }
        notifyDataSetChanged();
    }

    @NonNull
    @Override
    public ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        ItemMealBinding binding = ItemMealBinding.inflate(
                LayoutInflater.from(parent.getContext()), parent, false);
        return new ViewHolder(binding);
    }

    @Override
    public void onBindViewHolder(@NonNull ViewHolder holder, int position) {
        MealSummary meal = meals.get(position);
        holder.bind(meal);
    }

    @Override
    public int getItemCount() {
        return meals.size();
    }

    // ViewHolder untuk mengikat data makanan ke view item card
    class ViewHolder extends RecyclerView.ViewHolder {
        private final ItemMealBinding binding;

        ViewHolder(ItemMealBinding binding) {
            super(binding.getRoot());
            this.binding = binding;
        }

        // Mengikat data MealSummary ke view dengan support Glide
        void bind(MealSummary meal) {
            binding.tvMealTitle.setText(meal.getStrMeal());

            // Memuat gambar dari URL menggunakan Glide secara halus dengan transisi fade
            Glide.with(itemView.getContext())
                    .load(meal.getStrMealThumb())
                    .transition(DrawableTransitionOptions.withCrossFade())
                    .placeholder(R.drawable.ic_home) // Placeholder sementara
                    .error(R.drawable.ic_home)
                    .into(binding.ivMealThumb);

            // Handle event klik item makanan
            itemView.setOnClickListener(v -> {
                if (listener != null) {
                    listener.onMealClick(meal);
                }
            });
        }
    }
}
