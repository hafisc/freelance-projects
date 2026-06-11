<h1 align="center">📊 Analisis Probabilitas & Statistika (Bahasa R)</h1>

<p align="center">
  <img src="https://img.shields.io/badge/Language-R-276F40?style=for-the-badge&logo=r&logoColor=white" alt="R Language" />
  <img src="https://img.shields.io/badge/Environment-Jupyter_Notebook-F37626?style=for-the-badge&logo=jupyter&logoColor=white" alt="Jupyter Notebook" />
  <img src="https://img.shields.io/badge/Status-Completed-success?style=for-the-badge" alt="Status" />
</p>

Repository ini berisi pengerjaan tugas Analisis Probabilitas dan Statistika menggunakan bahasa R. Analisis dikerjakan menggunakan Jupyter Notebook (`.ipynb`) dengan dataset `Questionnaire2026.csv`.

## Struktur File

```text
.
├── CbA06_solved.ipynb
├── Questionnaire2026.csv
└── README.md
```

## Kebutuhan

Pastikan sudah terpasang:

1. R 4.x
2. Jupyter Notebook atau VS Code yang mendukung notebook
3. IRkernel untuk menjalankan notebook dengan kernel R

Package R yang digunakan:

```r
library(testthat)
library(digest)
library(stringr)
library(magick)
library(png)
library(IRdisplay)
library(dplyr)
library(lubridate)
library(rstatix)
library(FSA)
library(PMCMRplus)
```

Jika ada package yang belum tersedia, install dengan contoh berikut:

```r
install.packages("nama_package")
```

Contoh:

```r
install.packages("testthat")
install.packages("magick")
```

## Cara Menjalankan

1. Buka folder project di VS Code
2. Pastikan file `CbA06_solved.ipynb` dan `Questionnaire2026.csv` berada dalam satu folder.
3. Buka file `CbA06_solved.ipynb`.
4. Pilih kernel `R` atau `R 4.x`.
5. Klik `Run All` untuk menjalankan seluruh cell dari awal sampai akhir.
6. Pastikan semua cell selesai dijalankan tanpa error.
7. Simpan notebook dengan `Ctrl + S`.

## Hal yang Dikerjakan

1. Membaca file dataset `Questionnaire2026.csv`.
2. Mengecek struktur data, tipe data, dan nilai kosong.
3. Membersihkan data yang tidak sesuai kebutuhan analisis.
4. Menangani format tanggal lahir yang tidak konsisten.
5. Menghapus data yang masuk kategori outlier sesuai instruksi soal.
6. Mengambil label kelas dari format nama kelas yang panjang.
7. Menghitung umur berdasarkan tanggal acuan yang diminta pada soal.
8. Mengecek normalitas data dengan Shapiro-Wilk dan visualisasi.
9. Memilih metode uji sesuai kondisi data.
10. Mengerjakan Case 1, Case 2, dan Case 3 sampai output akhir.
11. Mengisi nilai TRUE/FALSE, p-value, dan pasangan signifikan sesuai format notebook.
12. Menjalankan cell validasi untuk memastikan jawaban terbaca oleh notebook.

## Ringkasan Metode

### Case 1

Membandingkan tinggi badan berdasarkan gender.

Metode yang digunakan:

```text
t-test
```

Alasan: data memenuhi syarat untuk uji parametrik.

### Case 2

Membandingkan distribusi umur antar kelas.

Metode yang digunakan:

```text
Kruskal-Wallis test
```

Alasan: data umur tidak sepenuhnya memenuhi asumsi normalitas, sehingga digunakan uji non-parametrik.

### Case 3

Membandingkan tinggi badan antar kelas.

Metode yang digunakan:

```text
One-way ANOVA + Tukey HSD
```

Alasan: data memenuhi syarat untuk uji parametrik dan membutuhkan pengecekan pasangan kelas yang berbeda signifikan.

## Output Akhir

Ringkasan hasil yang muncul dari notebook:

```text
Case 1: signifikan
Case 2: tidak signifikan
Case 3: signifikan, pasangan kelas CD
```

Nilai p-value dan output detail sudah tersedia langsung di dalam notebook.

## Catatan

1. Jangan mengubah cell validasi yang diberi keterangan `Do not modify`.
2. Jika notebook error karena package belum terinstall, install package yang disebut pada pesan error.
3. File CSV harus tetap bernama `Questionnaire2026.csv` agar path di notebook terbaca.
4. Jalankan notebook dari folder yang sama dengan dataset.


## Catatan Pengerjaan

Beberapa hal yang perlu diperhatikan dari soal dan dataset:

1. Format tanggal lahir pada kolom `dob` tidak semuanya konsisten, jadi perlu dibersihkan sebelum umur dihitung.
2. Data dengan tanggal lahir setelah 1 Agustus 2011 dianggap outlier sesuai instruksi soal dan tidak digunakan.
3. Data kosong/NA perlu dihapus agar proses analisis tidak error.
4. Nama kelas pada dataset masih berbentuk teks panjang, sehingga perlu diambil label kelasnya saja, seperti A, B, C, D, E, atau F.
5. Metode uji tidak langsung ditentukan dari awal, tetapi dicek dulu melalui normalitas data.
6. Case 2 menggunakan Kruskal-Wallis karena data umur tidak memenuhi asumsi normalitas.
7. Case 3 menggunakan One-way ANOVA dan Tukey HSD karena data tinggi badan memenuhi asumsi parametrik.
8. Post-hoc hanya digunakan jika hasil uji utama signifikan.
9. Format pasangan signifikan disesuaikan dengan format notebook, contohnya `CD`.