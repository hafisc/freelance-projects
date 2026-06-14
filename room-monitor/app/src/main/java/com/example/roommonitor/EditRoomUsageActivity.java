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
 * EditRoomUsageActivity - Halaman untuk mengubah/edit data.
 * Form ini sudah terisi dari awal (loadExistingData)
 */
public class EditRoomUsageActivity extends AppCompatActivity {

    private TextInputEditText etRoomName, etUserName, etDate, etTimeStart, etTimeEnd, etPurpose;
    private ChipGroup chipGroupCategory;
    private MaterialButton btnUpdate;
    private ImageButton btnBack;

    private DatabaseHelper dbHelper;
    private int idData;
    private RoomUsage dataLama;
    private String kategoriPilihan = "Kuliah";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_edit_room_usage);

        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });

        dbHelper = DatabaseHelper.getInstance(this);

        // ID data dikirim dari DetailActivity
        idData = getIntent().getIntExtra("USAGE_ID", -1);

        etRoomName = findViewById(R.id.etRoomName);
        etUserName = findViewById(R.id.etUserName);
        etDate = findViewById(R.id.etDate);
        etTimeStart = findViewById(R.id.etTimeStart);
        etTimeEnd = findViewById(R.id.etTimeEnd);
        etPurpose = findViewById(R.id.etPurpose);
        chipGroupCategory = findViewById(R.id.chipGroupCategory);
        btnUpdate = findViewById(R.id.btnUpdate);
        btnBack = findViewById(R.id.btnBack);

        // Panggil fungsi-fungsi urutan
        muatDataLama();
        aturPemilihWaktu();
        aturPilihanKategori();

        btnBack.setOnClickListener(v -> finish());
        btnUpdate.setOnClickListener(v -> {
            if (formValid()) perbaruiData();
        });
    }

    // Menampilkan isi data sebelumnya ke kolom isian
    private void muatDataLama() {
        if (idData == -1) { finish(); return; }

        dataLama = dbHelper.ambilDataById(idData);
        if (dataLama == null) { finish(); return; }

        // Isi form dari data database
        etRoomName.setText(dataLama.getRoomName());
        etUserName.setText(dataLama.getUserName());
        etDate.setText(dataLama.getDate());
        etTimeStart.setText(dataLama.getTimeStart());
        etTimeEnd.setText(dataLama.getTimeEnd());
        etPurpose.setText(dataLama.getPurpose());

        kategoriPilihan = dataLama.getCategory();
        pilihChipOtomatis(kategoriPilihan);
    }

    // Centang kategori secara otomatis
    private void pilihChipOtomatis(String kategori) {
        if (kategori == null) return;
        switch (kategori) {
            case "Kuliah": ((Chip) findViewById(R.id.chipKuliah)).setChecked(true); break;
            case "Rapat": ((Chip) findViewById(R.id.chipRapat)).setChecked(true); break;
            case "Seminar": ((Chip) findViewById(R.id.chipSeminar)).setChecked(true); break;
            case "Lainnya": ((Chip) findViewById(R.id.chipLainnya)).setChecked(true); break;
        }
    }

    // Tanggal dan Waktu (sama kayak halaman tambah)
    private void aturPemilihWaktu() {
        Calendar cal = Calendar.getInstance();

        etDate.setOnClickListener(v -> new DatePickerDialog(this, (view, year, month, day) -> {
            etDate.setText(String.format(Locale.getDefault(), "%02d/%02d/%04d", day, month + 1, year));
        }, cal.get(Calendar.YEAR), cal.get(Calendar.MONTH), cal.get(Calendar.DAY_OF_MONTH)).show());

        etTimeStart.setOnClickListener(v -> new TimePickerDialog(this, (view, hour, minute) -> {
            etTimeStart.setText(String.format(Locale.getDefault(), "%02d:%02d", hour, minute));
        }, cal.get(Calendar.HOUR_OF_DAY), cal.get(Calendar.MINUTE), true).show());

        etTimeEnd.setOnClickListener(v -> new TimePickerDialog(this, (view, hour, minute) -> {
            etTimeEnd.setText(String.format(Locale.getDefault(), "%02d:%02d", hour, minute));
        }, cal.get(Calendar.HOUR_OF_DAY), cal.get(Calendar.MINUTE), true).show());
    }

    private void aturPilihanKategori() {
        chipGroupCategory.setOnCheckedStateChangeListener((group, checkedIds) -> {
            if (!checkedIds.isEmpty()) {
                Chip chip = findViewById(checkedIds.get(0));
                if (chip != null) kategoriPilihan = chip.getText().toString();
            }
        });
    }

    private boolean formValid() {
        String nama = ambilTeks(etRoomName);
        String user = ambilTeks(etUserName);
        String tgl = ambilTeks(etDate);
        String jamMulai = ambilTeks(etTimeStart);
        String jamSelesai = ambilTeks(etTimeEnd);
        String keperluan = ambilTeks(etPurpose);

        if (nama.isEmpty() || user.isEmpty() || tgl.isEmpty() ||
                jamMulai.isEmpty() || jamSelesai.isEmpty() || keperluan.isEmpty()) {
            Toast.makeText(this, "Tolong isi semua data!", Toast.LENGTH_SHORT).show();
            return false;
        }

        if (jamMulai.compareTo(jamSelesai) >= 0) {
            Toast.makeText(this, "Jam Selesai harus sesudah Jam Mulai", Toast.LENGTH_SHORT).show();
            return false;
        }

        return true;
    }

    // Timpa (update) isi database
    private void perbaruiData() {
        dataLama.setRoomName(ambilTeks(etRoomName));
        dataLama.setUserName(ambilTeks(etUserName));
        dataLama.setDate(ambilTeks(etDate));
        dataLama.setTimeStart(ambilTeks(etTimeStart));
        dataLama.setTimeEnd(ambilTeks(etTimeEnd));
        dataLama.setPurpose(ambilTeks(etPurpose));
        dataLama.setCategory(kategoriPilihan);

        int hasil = dbHelper.updateData(dataLama);

        if (hasil > 0) {
            Toast.makeText(this, "Berhasil Diperbarui", Toast.LENGTH_SHORT).show();
            finish(); // Tutup dan kembali ke detail
        }
    }

    private String ambilTeks(TextInputEditText et) {
        return et.getText() != null ? et.getText().toString().trim() : "";
    }
}
