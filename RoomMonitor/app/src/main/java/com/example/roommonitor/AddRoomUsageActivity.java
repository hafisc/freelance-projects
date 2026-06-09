package com.example.roommonitor;

import android.app.DatePickerDialog;
import android.app.TimePickerDialog;
import android.os.Bundle;
import android.widget.ImageButton;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.google.android.material.button.MaterialButton;
import com.google.android.material.chip.Chip;
import com.google.android.material.chip.ChipGroup;
import com.google.android.material.textfield.TextInputEditText;

import java.util.Calendar;
import java.util.Locale;

/**
 * AddRoomUsageActivity - Halaman untuk mencatat/menambahkan data baru.
 */
public class AddRoomUsageActivity extends AppCompatActivity {

    private TextInputEditText etRoomName, etUserName, etDate, etTimeStart, etTimeEnd, etPurpose;
    private ChipGroup chipGroupCategory;
    private MaterialButton btnSave;
    private ImageButton btnBack;

    private DatabaseHelper dbHelper;
    private String kategoriPilihan = "Kuliah"; // Default

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_add_room_usage);

        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });

        dbHelper = DatabaseHelper.getInstance(this);

        // Inisialisasi tampilan
        etRoomName = findViewById(R.id.etRoomName);
        etUserName = findViewById(R.id.etUserName);
        etDate = findViewById(R.id.etDate);
        etTimeStart = findViewById(R.id.etTimeStart);
        etTimeEnd = findViewById(R.id.etTimeEnd);
        etPurpose = findViewById(R.id.etPurpose);
        chipGroupCategory = findViewById(R.id.chipGroupCategory);
        btnSave = findViewById(R.id.btnSave);
        btnBack = findViewById(R.id.btnBack);

        aturPemilihWaktu();
        aturPilihanKategori();

        btnBack.setOnClickListener(v -> finish());
        btnSave.setOnClickListener(v -> {
            if (formValid()) simpanData();
        });
    }

    // Atur dialog kalender & jam
    private void aturPemilihWaktu() {
        Calendar cal = Calendar.getInstance();

        // Pemilih Tanggal
        etDate.setOnClickListener(v -> {
            new DatePickerDialog(this, (view, year, month, day) -> {
                String tgl = String.format(Locale.getDefault(), "%02d/%02d/%04d", day, month + 1, year);
                etDate.setText(tgl);
            }, cal.get(Calendar.YEAR), cal.get(Calendar.MONTH), cal.get(Calendar.DAY_OF_MONTH)).show();
        });

        // Pemilih Jam Mulai
        etTimeStart.setOnClickListener(v -> {
            new TimePickerDialog(this, (view, hour, minute) -> {
                String jam = String.format(Locale.getDefault(), "%02d:%02d", hour, minute);
                etTimeStart.setText(jam);
            }, cal.get(Calendar.HOUR_OF_DAY), cal.get(Calendar.MINUTE), true).show();
        });

        // Pemilih Jam Selesai
        etTimeEnd.setOnClickListener(v -> {
            new TimePickerDialog(this, (view, hour, minute) -> {
                String jam = String.format(Locale.getDefault(), "%02d:%02d", hour, minute);
                etTimeEnd.setText(jam);
            }, cal.get(Calendar.HOUR_OF_DAY), cal.get(Calendar.MINUTE), true).show();
        });
    }

    // Menangani saat chip kategori ditekan
    private void aturPilihanKategori() {
        chipGroupCategory.setOnCheckedStateChangeListener((group, checkedIds) -> {
            if (!checkedIds.isEmpty()) {
                Chip chip = findViewById(checkedIds.get(0));
                if (chip != null) kategoriPilihan = chip.getText().toString();
            }
        });
    }

    // Pastikan semua kolom sudah diisi
    private boolean formValid() {
        String nama = ambilTeks(etRoomName);
        String user = ambilTeks(etUserName);
        String tgl = ambilTeks(etDate);
        String jamMulai = ambilTeks(etTimeStart);
        String jamSelesai = ambilTeks(etTimeEnd);
        String keperluan = ambilTeks(etPurpose);

        // Kalau ada yang kosong, tolak
        if (nama.isEmpty() || user.isEmpty() || tgl.isEmpty() ||
                jamMulai.isEmpty() || jamSelesai.isEmpty() || keperluan.isEmpty()) {
            Toast.makeText(this, "Tolong isi semua data!", Toast.LENGTH_SHORT).show();
            return false;
        }

        // Kalau jam selesai lebih awal dari jam mulai, tolak
        if (jamMulai.compareTo(jamSelesai) >= 0) {
            Toast.makeText(this, "Jam Selesai harus sesudah Jam Mulai", Toast.LENGTH_SHORT).show();
            return false;
        }

        return true;
    }

    // Simpan ke database
    private void simpanData() {
        RoomUsage dataBaru = new RoomUsage(
                ambilTeks(etRoomName),
                ambilTeks(etUserName),
                ambilTeks(etDate),
                ambilTeks(etTimeStart),
                ambilTeks(etTimeEnd),
                ambilTeks(etPurpose),
                kategoriPilihan
        );

        long hasil = dbHelper.tambahData(dataBaru);

        if (hasil != -1) {
            Toast.makeText(this, "Berhasil Disimpan", Toast.LENGTH_SHORT).show();
            finish(); // Tutup halaman
        }
    }

    // Helper pembantu agar nggak error kalau null
    private String ambilTeks(TextInputEditText et) {
        return et.getText() != null ? et.getText().toString().trim() : "";
    }
}
