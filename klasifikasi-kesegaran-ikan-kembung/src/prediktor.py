import os
import joblib
import numpy as np

from src.konfigurasi import (
    SVM_MODEL_PATH, 
    LABEL_ENCODER_PATH, 
    SCALER_PATH,
    CLASS_MAPPING
)
from src.praproses import baca_dan_praproses_gambar
from src.ekstraktor_fitur import ekstrak_fitur_gambar

# Cache model agar tidak dimuat berulang-ulang di Streamlit
_model_termuat = None
_encoder_termuat = None
_scaler_termuat = None

def apakah_model_siap():
    """
    Memeriksa apakah seluruh berkas model SVM, scaler, dan label encoder lengkap.
    
    Returns:
        bool: True jika model siap digunakan, False jika salah satu berkas hilang.
    """
    return (
        os.path.exists(SVM_MODEL_PATH) and
        os.path.exists(LABEL_ENCODER_PATH) and
        os.path.exists(SCALER_PATH)
    )

def muat_model_prediksi():
    """
    Memuat model SVM, label encoder, dan scaler dari disk (menggunakan cache memory).
    
    Returns:
        tuple: (svm_model, label_encoder, scaler)
    """
    global _model_termuat, _encoder_termuat, _scaler_termuat
    
    if not apakah_model_siap():
        raise FileNotFoundError(
            "Berkas model tidak lengkap di folder 'models/'. "
            "Silakan jalankan proses training terlebih dahulu."
        )
        
    if _model_termuat is None or _encoder_termuat is None or _scaler_termuat is None:
        _model_termuat = joblib.load(SVM_MODEL_PATH)
        _encoder_termuat = joblib.load(LABEL_ENCODER_PATH)
        _scaler_termuat = joblib.load(SCALER_PATH)
        
    return _model_termuat, _encoder_termuat, _scaler_termuat

def prediksi_kesegaran_ikan(image_path_or_file):
    """
    Menjalankan pipeline prediksi lengkap pada gambar baru:
    1. Baca dan praproses gambar.
    2. Ekstraksi fitur menggunakan MobileNetV3.
    3. Normalisasi fitur dengan StandardScaler.
    4. Klasifikasi menggunakan SVM dan estimasi skor probabilitas.
    5. Pemetaan hasil kelas ke teks deskriptif.
    
    Parameters:
        image_path_or_file (str or file-like): File gambar yang di-upload atau path gambarnya.
        
    Returns:
        dict: Detail hasil prediksi berisi jenis ikan, kesegaran, skor confidence, dan visual color.
    """
    # 1. Pemuatan dan Preprocessing Gambar
    preprocessed_img = baca_dan_praproses_gambar(image_path_or_file)
    
    # 2. Ekstraksi Fitur MobileNetV3
    feature_vector = ekstrak_fitur_gambar(preprocessed_img)
    
    # Reshape ke bentuk 2D karena scaler & SVM menerima input baris (1, n_features)
    feature_vector_2d = feature_vector.reshape(1, -1)
    
    # 3. Load Model & Normalisasi Fitur
    svm_model, label_encoder, scaler = muat_model_prediksi()
    feature_vector_scaled = scaler.transform(feature_vector_2d)
    
    # 4. Klasifikasi & Probabilitas (Confidence Score)
    predicted_class_encoded = svm_model.predict(feature_vector_scaled)[0]
    predicted_class_name = label_encoder.inverse_transform([predicted_class_encoded])[0]
    
    # Mendapatkan nilai kepastian (probabilitas) untuk kelas yang diprediksi
    probabilities = svm_model.predict_proba(feature_vector_scaled)[0]
    class_index = list(label_encoder.classes_).index(predicted_class_name)
    confidence = float(probabilities[class_index])
    
    # 5. Pemetaan Hasil
    # Ambil metadata hasil prediksi dari konfigurasi.py
    result_meta = CLASS_MAPPING.get(predicted_class_name, {
        "jenis": "Tidak Diketahui",
        "kesegaran": "Tidak Diketahui",
        "deskripsi": "Hasil klasifikasi tidak terdaftar dalam konfigurasi sistem.",
        "color": "#6c757d"
    })
    
    # Return dictionary hasil akhir
    return {
        "class_name": predicted_class_name,
        "confidence": confidence,
        "jenis": result_meta["jenis"],
        "kesegaran": result_meta["kesegaran"],
        "deskripsi": result_meta["deskripsi"],
        "color": result_meta["color"]
    }
