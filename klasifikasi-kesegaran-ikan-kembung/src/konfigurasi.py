import os

# Menentukan root direktori proyek secara dinamis berbasis letak berkas konfigurasi.py ini
BASE_DIR = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))

# Konfigurasi path untuk folder utama
DATASET_DIR = os.path.join(BASE_DIR, "dataset")
MODELS_DIR = os.path.join(BASE_DIR, "models")
SAMPLES_DIR = os.path.join(BASE_DIR, "samples")

# Detail path dataset training dan testing
TRAIN_DIR = os.path.join(DATASET_DIR, "train")
TEST_DIR = os.path.join(DATASET_DIR, "test")

# Detail path penyimpanan model machine learning
SVM_MODEL_PATH = os.path.join(MODELS_DIR, "model_svm.joblib")
LABEL_ENCODER_PATH = os.path.join(MODELS_DIR, "encoder_label.joblib")
SCALER_PATH = os.path.join(MODELS_DIR, "scaler.joblib")

# Konfigurasi parameter pemrosesan gambar
IMAGE_SIZE = (224, 224)  # Ukuran input standar untuk MobileNetV3
INPUT_SHAPE = (224, 224, 3)

# Daftar kelas target klasifikasi
CLASSES = ["ikan_kembung_segar", "ikan_kembung_tidak_segar", "ikan_lain"]

# Mapping label kelas ke deskripsi user-friendly di website
CLASS_MAPPING = {
    "ikan_kembung_segar": {
        "jenis": "Ikan Kembung",
        "kesegaran": "Segar",
        "deskripsi": "Ikan masih dalam kondisi segar, memiliki mata bening dan insang merah cerah. Layak dikonsumsi.",
        "color": "#2ec4b6"  # Tosca / Hijau segar
    },
    "ikan_kembung_tidak_segar": {
        "jenis": "Ikan Kembung",
        "kesegaran": "Tidak Segar",
        "deskripsi": "Ikan sudah tidak segar lagi, ditandai dengan mata suram atau insang kecokelatan. Tidak disarankan untuk dikonsumsi.",
        "color": "#e63946"  # Merah / Tidak segar
    },
    "ikan_lain": {
        "jenis": "Ikan Lain",
        "kesegaran": "Tidak Berlaku (N/A)",
        "deskripsi": "Gambar terdeteksi bukan sebagai ikan kembung. Sistem tidak dapat menilai kesegarannya.",
        "color": "#a8dadc"  # Abu-abu kebiruan
    }
}
