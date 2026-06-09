package com.example.roommonitor;

import android.content.Context;
import android.graphics.drawable.GradientDrawable;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.core.content.ContextCompat;
import androidx.recyclerview.widget.RecyclerView;

import com.google.android.material.card.MaterialCardView;

import java.util.ArrayList;
import java.util.List;

/**
 * Adapter untuk RecyclerView.
 * Bertugas menampilkan data List<RoomUsage> ke dalam tampilan card.
 */
public class RoomUsageAdapter extends RecyclerView.Adapter<RoomUsageAdapter.ViewHolder> {

    private List<RoomUsage> dataList; // Data yang ditampilkan
    private Context context;
    private OnItemClickListener listener;

    // Interface untuk menangani klik item
    public interface OnItemClickListener {
        void onItemClick(RoomUsage usage);
    }

    // Konstruktor
    public RoomUsageAdapter(Context context, List<RoomUsage> dataList) {
        this.context = context;
        this.dataList = (dataList != null) ? dataList : new ArrayList<>();
    }

    // Set listener klik
    public void setOnItemClickListener(OnItemClickListener listener) {
        this.listener = listener;
    }

    // Update data baru dan refresh tampilan
    public void updateData(List<RoomUsage> dataBaru) {
        this.dataList = (dataBaru != null) ? dataBaru : new ArrayList<>();
        notifyDataSetChanged();
    }

    // Membuat tampilan item baru dari XML layout
    @NonNull
    @Override
    public ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(context).inflate(R.layout.item_room_usage, parent, false);
        return new ViewHolder(view);
    }

    // Mengisi data ke tampilan item
    @Override
    public void onBindViewHolder(@NonNull ViewHolder holder, int position) {
        RoomUsage data = dataList.get(position);

        // Set teks
        holder.tvRoomName.setText(data.getRoomName());
        holder.tvUserName.setText("👤 " + data.getUserName());
        holder.tvDate.setText("📅 " + data.getDate());
        holder.tvTime.setText("🕐 " + data.getTimeRange());
        holder.tvIcon.setText(data.getCategoryIcon());
        holder.tvCategory.setText(data.getCategory());

        // Warnai chip kategori
        aturWarnaKategori(holder.tvCategory, data.getCategory());

        // Klik item
        holder.cardItem.setOnClickListener(v -> {
            if (listener != null) {
                listener.onItemClick(data);
            }
        });
    }

    // Jumlah total item
    @Override
    public int getItemCount() {
        return dataList.size();
    }

    // Memberi warna chip sesuai kategori
    private void aturWarnaKategori(TextView chip, String kategori) {
        int warnaText, warnaBg;

        if (kategori == null) kategori = "Lainnya";

        switch (kategori) {
            case "Kuliah":
                warnaText = ContextCompat.getColor(context, R.color.chip_kuliah);
                warnaBg = ContextCompat.getColor(context, R.color.chip_kuliah_bg);
                break;
            case "Rapat":
                warnaText = ContextCompat.getColor(context, R.color.chip_rapat);
                warnaBg = ContextCompat.getColor(context, R.color.chip_rapat_bg);
                break;
            case "Seminar":
                warnaText = ContextCompat.getColor(context, R.color.chip_seminar);
                warnaBg = ContextCompat.getColor(context, R.color.chip_seminar_bg);
                break;
            default:
                warnaText = ContextCompat.getColor(context, R.color.chip_lainnya);
                warnaBg = ContextCompat.getColor(context, R.color.chip_lainnya_bg);
                break;
        }

        chip.setTextColor(warnaText);

        // Buat background bulat
        GradientDrawable bg = new GradientDrawable();
        bg.setColor(warnaBg);
        bg.setCornerRadius(40f);

        float density = context.getResources().getDisplayMetrics().density;
        chip.setBackground(bg);
        chip.setPadding((int) (12 * density), (int) (4 * density), (int) (12 * density), (int) (4 * density));
    }

    // ViewHolder - menyimpan referensi view tiap item
    public static class ViewHolder extends RecyclerView.ViewHolder {
        MaterialCardView cardItem;
        TextView tvIcon, tvRoomName, tvCategory, tvUserName, tvDate, tvTime;

        public ViewHolder(@NonNull View itemView) {
            super(itemView);
            cardItem = itemView.findViewById(R.id.cardItem);
            tvIcon = itemView.findViewById(R.id.tvIcon);
            tvRoomName = itemView.findViewById(R.id.tvRoomName);
            tvCategory = itemView.findViewById(R.id.tvCategory);
            tvUserName = itemView.findViewById(R.id.tvUserName);
            tvDate = itemView.findViewById(R.id.tvDate);
            tvTime = itemView.findViewById(R.id.tvTime);
        }
    }
}
