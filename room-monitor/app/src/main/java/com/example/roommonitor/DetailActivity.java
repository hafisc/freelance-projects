package com.example.roommonitor;

import android.content.Intent;
import android.graphics.drawable.GradientDrawable;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageButton;
import android.widget.TextView;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.content.ContextCompat;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.google.android.material.button.MaterialButton;

/**
 * DetailActivity - Menampilkan detail dari satu data ruangan yang dipilih.
 * Bisa hapus atau masuk ke halaman edit dari sini.
 */
public class DetailActivity extends AppCompatActivity {

    private TextView tvDetailIcon, tvDetailRoomName, tvDetailCategory,
            tvDetailUser, tvDetailDate, tvDetailTime, tvDetailPurpose;
    private MaterialButton btnEdit, btnDelete;
    private ImageButton btnBack;

    private DatabaseHelper dbHelper;
    private int idData; // ID data yang ditampilkan

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_detail);

        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });

        dbHelper = DatabaseHelper.getInstance(this);

        // Ambil ID dari halaman sebelumnya (Dashboard)
        idData = getIntent().getIntExtra("USAGE_ID", -1);

        tvDetailIcon = findViewById(R.id.tvDetailIcon);
        tvDetailRoomName = findViewById(R.id.tvDetailRoomName);
        tvDetailCategory = findViewById(R.id.tvDetailCategory);
        tvDetailUser = findViewById(R.id.tvDetailUser);
        tvDetailDate = findViewById(R.id.tvDetailDate);
        tvDetailTime = findViewById(R.id.tvDetailTime);
        tvDetailPurpose = findViewById(R.id.tvDetailPurpose);
        btnEdit = findViewById(R.id.btnEdit);
        btnDelete = findViewById(R.id.btnDelete);
        btnBack = findViewById(R.id.btnBack);

        btnBack.setOnClickListener(v -> finish());
        btnEdit.setOnClickListener(v -> {
            Intent intent = new Intent(this, EditRoomUsageActivity.class);
            intent.putExtra("USAGE_ID", idData);
            startActivity(intent);
        });
        btnDelete.setOnClickListener(v -> tampilkanDialogHapus());
    }

    // Refresh data tiap kali halaman ini kembali dibuka (misal sehabis edit)
    @Override
    protected void onResume() {
        super.onResume();
        muatData();
    }

    // Ambil data dari database dan tampilkan
    private void muatData() {
        if (idData == -1) { finish(); return; }

        RoomUsage data = dbHelper.ambilDataById(idData);
        if (data == null) { finish(); return; } // Kalau udah dihapus

        // Isi tampilan
        tvDetailIcon.setText(data.getCategoryIcon());
        tvDetailRoomName.setText(data.getRoomName());
        tvDetailUser.setText(data.getUserName());
        tvDetailDate.setText(data.getDate());
        tvDetailTime.setText(data.getTimeRange());
        tvDetailPurpose.setText(data.getPurpose());
        tvDetailCategory.setText(data.getCategory());

        // Warnai tulisan kategori
        aturWarnaKategori(tvDetailCategory, data.getCategory());

        // Animasi muncul sedikit
        View card = findViewById(R.id.main);
        card.setAlpha(0f);
        card.setTranslationY(30f);
        card.animate().alpha(1f).translationY(0f).setDuration(400).start();
    }

    // Tampilkan popup konfirmasi saat hapus ditekan
    private void tampilkanDialogHapus() {
        View tampilanPopup = getLayoutInflater().inflate(R.layout.dialog_delete_confirm, null);

        AlertDialog dialog = new AlertDialog.Builder(this)
                .setView(tampilanPopup)
                .setCancelable(true)
                .create();

        if (dialog.getWindow() != null) {
            dialog.getWindow().setBackgroundDrawableResource(android.R.color.transparent);
        }

        MaterialButton btnBatal = tampilanPopup.findViewById(R.id.btnDialogCancel);
        MaterialButton btnYaHapus = tampilanPopup.findViewById(R.id.btnDialogDelete);

        btnBatal.setOnClickListener(v -> dialog.dismiss());
        btnYaHapus.setOnClickListener(v -> {
            dbHelper.hapusData(idData);
            Toast.makeText(this, "Berhasil dihapus", Toast.LENGTH_SHORT).show();
            dialog.dismiss();
            finish(); // Tutup halaman
        });

        dialog.show();
    }

    // Pewarnaan mirip di adapter
    private void aturWarnaKategori(TextView chip, String kategori) {
        int warnaText, warnaBg;
        if (kategori == null) kategori = "Lainnya";

        switch (kategori) {
            case "Kuliah":
                warnaText = ContextCompat.getColor(this, R.color.chip_kuliah);
                warnaBg = ContextCompat.getColor(this, R.color.chip_kuliah_bg);
                break;
            case "Rapat":
                warnaText = ContextCompat.getColor(this, R.color.chip_rapat);
                warnaBg = ContextCompat.getColor(this, R.color.chip_rapat_bg);
                break;
            case "Seminar":
                warnaText = ContextCompat.getColor(this, R.color.chip_seminar);
                warnaBg = ContextCompat.getColor(this, R.color.chip_seminar_bg);
                break;
            default:
                warnaText = ContextCompat.getColor(this, R.color.chip_lainnya);
                warnaBg = ContextCompat.getColor(this, R.color.chip_lainnya_bg);
                break;
        }

        chip.setTextColor(warnaText);
        GradientDrawable bg = new GradientDrawable();
        bg.setColor(warnaBg);
        bg.setCornerRadius(40f);

        float density = getResources().getDisplayMetrics().density;
        chip.setBackground(bg);
        chip.setPadding((int)(12*density), (int)(4*density), (int)(12*density), (int)(4*density));
    }
}
