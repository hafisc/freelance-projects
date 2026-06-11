# Website Klasifikasi Kesegaran Ikan Kembung Menggunakan MobileNetV3 dan SVM

Proyek ini adalah aplikasi web berbasis Python yang dirancang untuk mendeteksi kesegaran ikan kembung menggunakan teknik deep learning dan machine learning. Sistem mengekstrak fitur gambar menggunakan model pre-trained **MobileNetV3-Large** dan mengklasifikasikannya menggunakan **Support Vector Machine (SVM)**.

---

## Fitur Utama

1. **Upload Gambar**: Mendukung pengunggahan berkas gambar dengan format JPG, JPEG, dan PNG.
2. **Preview Gambar**: Menampilkan gambar ikan secara langsung setelah diunggah sebelum dianalisis.
3. **Prediksi Klasifikasi**:
   - Membedakan apakah gambar yang diunggah merupakan **Ikan Kembung** atau **Ikan Lain**.
   - Jika terdeteksi sebagai Ikan Kembung, sistem akan mendeteksi status kesegarannya (**Segar** atau **Tidak Segar**).
4. **Tampilan Persentase Keyakinan (*Confidence Score*)**: Menampilkan tingkat keyakinan prediksi model.
5. **Indikator Visual Premium**: Kartu hasil analisis dengan warna dinamis (Hijau untuk Segar, Merah untuk Tidak Segar, Biru-Abu untuk Ikan Lain).
6. **Informasi Arsitektur**: Deskripsi ringkas mengenai jalannya ekstraksi fitur dan klasifikasi di antarmuka web.

---

## Teknologi yang Digunakan

* **Python 3.10+** (Bahasa pemrograman utama)
* **Streamlit** (Framework antarmuka website)
* **TensorFlow / Keras** (Arsitektur MobileNetV3Large)
* **Scikit-learn** (Model SVM, StandardScaler, dan LabelEncoder)
* **Joblib** (Penyimpanan dan pemuatan model hasil training)
* **Pillow (PIL)** (Pengolahan gambar)
* **NumPy & Pandas** (Pengolahan matriks data fitur)

---

## Struktur Folder Proyek

```text
fish-freshness-classification/
  ├── app/
  │   └── aplikasi_streamlit.py   # Antarmuka web Streamlit
  │
  ├── src/
  │   ├── __init__.py             # Inisialisasi package python
  │   ├── konfigurasi.py          # Konfigurasi path, parameter gambar, & mapping kelas
  │   ├── praproses.py            # Validasi & praproses gambar
  │   ├── ekstraktor_fitur.py     # Ekstraksi fitur MobileNetV3
  │   ├── prediktor.py            # Logic load model & prediksi gambar baru
  │   └── utilitas.py             # Log helper & utilitas umum
  │
  ├── training/
  │   ├── ekstrak_fitur.py        # Skrip ekstraksi fitur dataset gambar ke .npy
  │   ├── latih_svm.py            # Skrip training model SVM
  │   └── evaluasi_model.py       # Skrip evaluasi performa model di data test
  │
  ├── dataset/                    # Folder dataset gambar dari client
  │   ├── train/                  # Dataset untuk training model
  │   │   ├── ikan_kembung_segar/
  │   │   ├── ikan_kembung_tidak_segar/
  │   │   └── ikan_lain/
  │   └── test/                   # Dataset untuk testing evaluasi
  │       ├── ikan_kembung_segar/
  │       ├── ikan_kembung_tidak_segar/
  │       └── ikan_lain/
  │
  ├── models/                     # Tempat menyimpan berkas model (.joblib & .npy)
  │   ├── model_svm.joblib        # Classifier SVM
  │   ├── encoder_label.joblib    # Encoder nama kelas ke angka
  │   └── scaler.joblib           # StandardScaler fitur
  │
  ├── samples/                    # Gambar contoh untuk pengujian web
  │   ├── sample_ikan_kembung_segar.png
  │   ├── sample_ikan_kembung_tidak_segar.png
  │   └── sample_ikan_lain.png
  │
  ├── requirements.txt            # Daftar pustaka dependency proyek
  └── README.md                   # Dokumentasi panduan ini
```

---

## Langkah Instalasi & Persiapan

### 1. Kloning / Buka Folder Proyek
Pastikan terminal Anda aktif pada root direktori proyek `klasifikasi-kesegaran-ikan-kembung`.

### 2. Buat Virtual Environment (Rekomendasi)
Untuk mengisolasi pustaka agar tidak bentrok dengan sistem global:
```bash
python -m venv .venv
```

Aktifkan virtual environment:
* **Windows (Command Prompt):**
  ```cmd
  .venv\Scripts\activate.bat
  ```
* **Windows (PowerShell):**
  ```powershell
  .venv\Scripts\Activate.ps1
  ```
* **Linux / macOS:**
  ```bash
  source .venv/bin/activate
  ```

### 3. Install Dependensi
Pasang seluruh library yang dibutuhkan dengan perintah berikut:
```bash
pip install -r requirements.txt
```

---

## Langkah Melatih Model (Training)

Sebelum menjalankan website, pastikan model klasifikasi sudah dilatih dengan dataset gambar Anda.

### 1. Menaruh Gambar Dataset
Masukkan gambar Anda ke subfolder kelas masing-masing di dalam direktori `dataset/`:
* Letakkan gambar training pada folder:
  `dataset/train/ikan_kembung_segar/`, `dataset/train/ikan_kembung_tidak_segar/`, dan `dataset/train/ikan_lain/`.
* Letakkan gambar testing pada folder:
  `dataset/test/ikan_kembung_segar/`, `dataset/test/ikan_kembung_tidak_segar/`, dan `dataset/test/ikan_lain/`.

*(Catatan: Proyek ini sudah diinisialisasi dengan gambar contoh berkualitas tinggi di folder `samples/` yang telah diduplikasi secara otomatis ke folder `dataset/` untuk pengujian instan pertama).*

### 2. Ekstraksi Fitur Dataset
Ekstrak fitur visual dari gambar-gambar dataset menggunakan MobileNetV3:
```bash
python training/ekstrak_fitur.py
```
Proses ini akan menghasilkan berkas biner `.npy` berisi representasi fitur di folder `models/`.

### 3. Melatih Model SVM
Latih classifier SVM di atas fitur yang sudah diekstrak:
```bash
python training/latih_svm.py
```
Ini akan menghasilkan file model `model_svm.joblib`, `scaler.joblib`, dan `encoder_label.joblib` di folder `models/`.

### 4. Mengevaluasi Performa Model
Lihat hasil metrik evaluasi model (akurasi, precision, recall, confusion matrix) pada data testing:
```bash
python training/evaluasi_model.py
```

---

## Cara Menjalankan Website (Inference)

Untuk menjalankan antarmuka web Streamlit:
```bash
streamlit run app/aplikasi_streamlit.py
```
Aplikasi akan otomatis terbuka di browser Anda pada alamat:
`http://localhost:8501`

Di halaman web, Anda dapat:
* Memilih salah satu gambar contoh dari dropdown menu.
* Mengunggah gambar baru milik Anda.
* Menekan tombol **Mulai Prediksi Kesegaran** untuk melihat analisis kesegaran ikan.

---

## Troubleshooting (Penyelesaian Masalah)

1. **`ModuleNotFoundError: No module named 'tensorflow'`**
   * *Penyebab*: Virtual environment belum diaktifkan atau instalasi package gagal.
   * *Solusi*: Pastikan Anda sudah mengaktifkan venv (`.venv\Scripts\activate`) dan menjalankan kembali `pip install -r requirements.txt`.
2. **Model Belum Ditemukan di Halaman Website**
   * *Penyebab*: Folder `models/` belum berisi file `.joblib` karena Anda belum menjalankan proses training.
   * *Solusi*: Jalankan perintah `python training/ekstrak_fitur.py` lalu `python training/latih_svm.py` sebelum membuka website.
3. **`UnidentifiedImageError` saat Upload Gambar**
   * *Penyebab*: Gambar yang Anda upload rusak atau format filenya tidak valid (bukan JPG/JPEG/PNG sesungguhnya).
   * *Solusi*: Upload gambar lain yang utuh dan valid.

---

## Catatan Akurasi Model

Akurasi model sangat dipengaruhi oleh **kualitas gambar** dan **keseimbangan jumlah data** pada setiap folder kelas di `dataset/train/`. 
* Disarankan menggunakan gambar dengan pencahayaan yang merata, latar belakang netral, dan sudut pengambilan gambar yang konsisten.
* Jika hasil akurasi dirasa kurang, tambahkan jumlah variasi gambar di masing-masing subfolder kelas dataset, lalu jalankan kembali langkah training dari awal.
