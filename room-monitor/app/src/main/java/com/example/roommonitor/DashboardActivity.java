package com.example.roommonitor;

import android.content.Intent;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.View;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.google.android.material.floatingactionbutton.ExtendedFloatingActionButton;

import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.List;
import java.util.Locale;

/**
 * DashboardActivity - Halaman Utama.
 * Menampilkan daftar ruangan yang dipakai dan info statistik.
 */
public class DashboardActivity extends AppCompatActivity {

    private RecyclerView rvRoomUsage;
    private LinearLayout layoutEmpty;
    private EditText etSearch;
    private TextView tvTotalUsage, tvTodayUsage, tvTotalRooms;
    private ExtendedFloatingActionButton fabAdd;

    private DatabaseHelper dbHelper;
    private RoomUsageAdapter adapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_dashboard);

        // Atur batas layar biar gak ketutupan status bar
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });

        dbHelper = DatabaseHelper.getInstance(this);

        // Hubungkan variabel dengan tampilan di XML
        rvRoomUsage = findViewById(R.id.rvRoomUsage);
        layoutEmpty = findViewById(R.id.layoutEmpty);
        etSearch = findViewById(R.id.etSearch);
        tvTotalUsage = findViewById(R.id.tvTotalUsage);
        tvTodayUsage = findViewById(R.id.tvTodayUsage);
        tvTotalRooms = findViewById(R.id.tvTotalRooms);
        fabAdd = findViewById(R.id.fabAdd);

        aturRecyclerView();
        aturPencarian();

        // Tombol Tambah Data diklik
        fabAdd.setOnClickListener(v -> {
            startActivity(new Intent(this, AddRoomUsageActivity.class));
        });

        // Efek tombol mengecil saat list di-scroll ke bawah
        rvRoomUsage.addOnScrollListener(new RecyclerView.OnScrollListener() {
            @Override
            public void onScrolled(RecyclerView recyclerView, int dx, int dy) {
                if (dy > 0) fabAdd.shrink();
                else if (dy < 0) fabAdd.extend();
            }
        });
    }

    // Dipanggil setiap kali halaman ini muncul kembali
    @Override
    protected void onResume() {
        super.onResume();
        muatData();
        updateStatistik();
    }

    // Persiapan list data
    private void aturRecyclerView() {
        adapter = new RoomUsageAdapter(this, dbHelper.ambilSemuaData());
        rvRoomUsage.setLayoutManager(new LinearLayoutManager(this));
        rvRoomUsage.setAdapter(adapter);

        // Kalau list diklik, buka halaman Detail
        adapter.setOnItemClickListener(data -> {
            Intent intent = new Intent(this, DetailActivity.class);
            intent.putExtra("USAGE_ID", data.getId());
            startActivity(intent);
        });
    }

    // Logika pencarian data
    private void aturPencarian() {
        etSearch.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {}

            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {
                String kataKunci = s.toString().trim();
                if (kataKunci.isEmpty()) {
                    muatData(); // Kalau kosong, tampilkan semua
                } else {
                    List<RoomUsage> hasilCari = dbHelper.cariData(kataKunci);
                    adapter.updateData(hasilCari);
                    tampilGambarKosong(hasilCari.isEmpty());
                }
            }

            @Override
            public void afterTextChanged(Editable s) {}
        });
    }

    // Ambil semua data dari database
    private void muatData() {
        List<RoomUsage> semuaData = dbHelper.ambilSemuaData();
        adapter.updateData(semuaData);
        tampilGambarKosong(semuaData.isEmpty());
    }

    // Tampilkan / sembunyikan gambar kalau data kosong
    private void tampilGambarKosong(boolean kosong) {
        if (kosong) {
            rvRoomUsage.setVisibility(View.GONE);
            layoutEmpty.setVisibility(View.VISIBLE);
        } else {
            rvRoomUsage.setVisibility(View.VISIBLE);
            layoutEmpty.setVisibility(View.GONE);
        }
    }

    // Update angka-angka di atas
    private void updateStatistik() {
        String tglHariIni = new SimpleDateFormat("dd/MM/yyyy", Locale.getDefault()).format(new Date());

        tvTotalUsage.setText(String.valueOf(dbHelper.hitungTotal()));
        tvTodayUsage.setText(String.valueOf(dbHelper.hitungHariIni(tglHariIni)));
        tvTotalRooms.setText(String.valueOf(dbHelper.hitungRuanganUnik()));

        animasiAngka(tvTotalUsage);
        animasiAngka(tvTodayUsage);
        animasiAngka(tvTotalRooms);
    }

    // Efek zoom in kecil untuk angka statistik
    private void animasiAngka(View view) {
        view.setScaleX(0.5f);
        view.setScaleY(0.5f);
        view.animate().scaleX(1f).scaleY(1f).setDuration(400).start();
    }
}
