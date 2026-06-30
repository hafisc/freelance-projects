package com.labmobile.kulinerku.adapter;

import android.view.LayoutInflater;
import android.view.ViewGroup;
import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;
import com.labmobile.kulinerku.databinding.ItemCategoryBinding;
import com.labmobile.kulinerku.model.Category;
import java.util.ArrayList;
import java.util.List;

// Adapter RecyclerView untuk daftar kategori makanan horizontal
public class CategoryAdapter extends RecyclerView.Adapter<CategoryAdapter.ViewHolder> {

    private final List<Category> categories = new ArrayList<>();
    private int selectedPosition = 0;
    private final OnCategoryClickListener listener;

    // Interface callback untuk menangani klik pada item kategori
    public interface OnCategoryClickListener {
        void onCategoryClick(Category category);
    }

    // Konstruktor CategoryAdapter
    public CategoryAdapter(OnCategoryClickListener listener) {
        this.listener = listener;
    }

    // Memperbarui daftar kategori dan melakukan render ulang
    public void setCategories(List<Category> newCategories) {
        this.categories.clear();
        if (newCategories != null) {
            this.categories.addAll(newCategories);
        }
        this.selectedPosition = 0; // Reset ke item pertama
        notifyDataSetChanged();
    }

    // Mendapatkan kategori yang saat ini sedang aktif/terpilih
    public Category getSelectedCategory() {
        if (!categories.isEmpty() && selectedPosition >= 0 && selectedPosition < categories.size()) {
            return categories.get(selectedPosition);
        }
        return null;
    }

    @NonNull
    @Override
    public ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        ItemCategoryBinding binding = ItemCategoryBinding.inflate(
                LayoutInflater.from(parent.getContext()), parent, false);
        return new ViewHolder(binding);
    }

    @Override
    public void onBindViewHolder(@NonNull ViewHolder holder, int position) {
        Category category = categories.get(position);
        holder.bind(category, position == selectedPosition);
    }

    @Override
    public int getItemCount() {
        return categories.size();
    }

    // ViewHolder untuk mengikat data kategori ke view item
    class ViewHolder extends RecyclerView.ViewHolder {
        private final ItemCategoryBinding binding;

        ViewHolder(ItemCategoryBinding binding) {
            super(binding.getRoot());
            this.binding = binding;
        }

        // Mengikat data Category ke layout chip
        void bind(Category category, boolean isSelected) {
            binding.tvCategoryName.setText(category.getStrCategory());
            binding.tvCategoryName.setSelected(isSelected);

            // Handle event klik item kategori
            binding.tvCategoryName.setOnClickListener(v -> {
                int oldPos = selectedPosition;
                selectedPosition = getAdapterPosition();
                notifyItemChanged(oldPos);
                notifyItemChanged(selectedPosition);

                if (listener != null) {
                    listener.onCategoryClick(category);
                }
            });
        }
    }
}
