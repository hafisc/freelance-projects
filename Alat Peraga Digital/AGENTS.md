# AGENTS.md

## Identitas Project

Nama project: MAMITOR 3D - Matriks Minor & Kofaktor  
Jenis project: Website media digital alat peraga interaktif  
Target deploy: Vercel  
Tech stack utama: Vite, HTML, CSS, JavaScript Native, KaTeX

Project ini adalah lanjutan dari kode HTML/CSS/JavaScript yang sudah diberikan client. Fokus pengerjaan adalah memperbaiki, merapikan, dan memperbagus tampilan tanpa mengubah konsep utama media digital alat peraga.

## Tujuan Utama

Buat website alat peraga digital untuk pembelajaran matriks minor dan kofaktor 3x3. Website harus interaktif, mudah digunakan, responsif, dan memiliki tampilan yang lebih rapi serta menarik.

Fitur utama yang wajib ada:

1. Halaman awal / landing sederhana.
2. Tombol atau animasi “Mulai Bermain”.
3. Input nilai matriks 3x3.
4. Pemilihan baris dan kolom.
5. Visualisasi baris dan kolom yang dipilih.
6. Tampilan matriks sisa setelah baris dan kolom dipilih.
7. Perhitungan minor matriks.
8. Perhitungan kofaktor matriks.
9. Input jawaban manual dari user.
10. Fitur cek jawaban.
11. Feedback jawaban benar/salah.
12. Tampilan responsif untuk desktop dan mobile.
13. Deploy ke Vercel.

## Aturan Pengerjaan Untuk Coding Agent

1. Jangan mengubah konsep utama project.
2. Jangan membuat fitur di luar scope tanpa kebutuhan jelas.
3. Gunakan struktur folder yang rapi dan mudah dipahami.
4. Pisahkan file HTML, CSS, dan JavaScript.
5. Hindari menulis semua kode dalam satu file besar.
6. Gunakan nama file, folder, class, id, dan function yang jelas.
7. Tambahkan komentar Bahasa Indonesia pada fungsi-fungsi penting.
8. Pastikan semua logic perhitungan minor dan kofaktor benar.
9. Pastikan website tetap berjalan walaupun user mengganti nilai matriks.
10. Pastikan tidak ada error di browser console.
11. Pastikan tampilan tetap nyaman di layar kecil.
12. Jangan memakai framework berat seperti React/Vue kecuali diminta ulang.
13. Gunakan KaTeX untuk tampilan rumus matematika.
14. Jangan hardcode hasil perhitungan jika bisa dihitung secara dinamis.
15. Selesaikan project dalam bentuk yang siap deploy.

## Standar Kualitas Kode

- Gunakan JavaScript Native modular.
- Setiap fungsi harus punya satu tanggung jawab utama.
- Hindari duplikasi kode.
- Gunakan validasi input sederhana.
- Gunakan constant untuk selector atau konfigurasi yang sering dipakai.
- Gunakan komentar Bahasa Indonesia untuk fungsi utama.
- Gunakan format kode yang konsisten.

Contoh komentar fungsi:

```js
/**
 * Mengambil nilai matriks 3x3 dari input user.
 * Nilai kosong akan dianggap sebagai 0 agar perhitungan tetap berjalan.
 */
function getMatrixValues() {
  // isi function
}
```

## Prioritas Pengerjaan

Urutan prioritas:

1. Setup project Vite + Vanilla JS.
2. Pindahkan kode lama ke struktur file yang rapi.
3. Perbaiki error syntax dari kode lama.
4. Buat halaman awal dan tombol “Mulai Bermain”.
5. Rapikan UI utama MAMITOR 3D.
6. Rapikan logic matriks, minor, kofaktor, dan cek jawaban.
7. Tambahkan feedback user.
8. Tambahkan responsive layout.
9. Testing manual.
10. Deploy ke Vercel.

## Definisi Selesai

Project dianggap selesai jika:

1. Website bisa dibuka tanpa error.
2. Tombol “Mulai Bermain” berjalan.
3. User bisa input matriks 3x3.
4. User bisa memilih baris dan kolom.
5. Baris dan kolom terpilih tampil secara visual.
6. Matriks sisa muncul sesuai pilihan user.
7. Perhitungan minor benar.
8. Perhitungan kofaktor benar.
9. Fitur cek jawaban berjalan.
10. Website responsif.
11. Source code rapi.
12. Sudah siap deploy ke Vercel.
13. Ada dokumentasi cara menjalankan project.
