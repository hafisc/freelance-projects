package com.example.roommonitor;

import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.os.Looper;
import android.view.View;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.google.android.material.button.MaterialButton;

/**
 * ============================================================
 * KELAS MainActivity (Halaman Splash / Selamat Datang)
 * ============================================================
 * Activity ini adalah halaman PERTAMA yang muncul saat aplikasi dibuka.
 * Menampilkan logo, nama aplikasi, dan tombol "Mulai Sekarang".
 *
 * Fungsi utama:
 * 1. Menampilkan branding aplikasi (nama, tagline, deskripsi)
 * 2. Memberikan animasi fade-in saat pertama kali muncul
 * 3. Navigasi ke DashboardActivity saat tombol diklik
 *
 * Konsep yang digunakan:
 * - Activity Lifecycle (onCreate)
 * - Intent (perpindahan antar Activity)
 * - View Animation (animasi tampilan)
 * - EdgeToEdge (tampilan full screen)
 * ============================================================
 */
public class MainActivity extends AppCompatActivity {

    // ========== DEKLARASI VARIABEL VIEW ==========
    private MaterialButton btnGetStarted; // Tombol "Mulai Sekarang"

    /**
     * Method onCreate dipanggil saat Activity PERTAMA KALI dibuat.
     * Di sinilah kita menginisialisasi tampilan dan logika awal.
     */
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        // Mengaktifkan tampilan edge-to-edge (konten sampai ke tepi layar)
        EdgeToEdge.enable(this);

        // Menghubungkan Activity dengan layout XML (activity_main.xml)
        setContentView(R.layout.activity_main);

        // Mengatur padding agar konten tidak tertutup status bar dan navigation bar
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });

        // Menghubungkan variabel Java dengan elemen di XML menggunakan ID
        btnGetStarted = findViewById(R.id.btnGetStarted);

        // Jalankan animasi tampilan
        animateViews();

        // Atur aksi saat tombol "Mulai Sekarang" diklik
        btnGetStarted.setOnClickListener(v -> {
            // Buat Intent untuk berpindah ke DashboardActivity
            Intent intent = new Intent(MainActivity.this, DashboardActivity.class);

            // Jalankan Activity tujuan
            startActivity(intent);

            // Tambahkan animasi transisi (fade in/out)
            overridePendingTransition(android.R.anim.fade_in, android.R.anim.fade_out);

            // Tutup MainActivity agar tidak bisa kembali ke splash screen
            finish();
        });
    }

    /**
     * Menjalankan animasi tampilan saat halaman splash muncul.
     * - Layout utama: efek fade-in (transparan -> terlihat)
     * - Tombol: efek fade-in + slide-up (muncul dari bawah)
     */
    private void animateViews() {
        // Animasi layout utama: fade-in selama 800ms
        View mainLayout = findViewById(R.id.main);
        mainLayout.setAlpha(0f); // Mulai dari transparan
        mainLayout.animate()
                .alpha(1f) // Berubah menjadi terlihat penuh
                .setDuration(800) // Durasi 800 milidetik
                .start();

        // Animasi tombol: muncul dengan delay 500ms setelah layout
        btnGetStarted.setAlpha(0f); // Mulai dari transparan
        btnGetStarted.setTranslationY(60f); // Mulai dari posisi 60px di bawah

        // Handler digunakan untuk memberi delay sebelum animasi dimulai
        new Handler(Looper.getMainLooper()).postDelayed(() -> {
            btnGetStarted.animate()
                    .alpha(1f) // Menjadi terlihat
                    .translationY(0f) // Kembali ke posisi normal
                    .setDuration(600) // Durasi 600 milidetik
                    .start();
        }, 500); // Delay 500ms
    }
}