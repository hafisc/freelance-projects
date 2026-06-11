import os
import sys
import joblib
import numpy as np
from sklearn.metrics import classification_report, confusion_matrix, accuracy_score

# Menambahkan root direktori proyek ke sys.path secara dinamis
BASE_DIR = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
if BASE_DIR not in sys.path:
    sys.path.append(BASE_DIR)

from src.konfigurasi import MODELS_DIR, SVM_MODEL_PATH, LABEL_ENCODER_PATH, SCALER_PATH

def main():
    test_features_path = os.path.join(MODELS_DIR, "test_features.npy")
    test_labels_path = os.path.join(MODELS_DIR, "test_labels.npy")
    
    # Validasi keberadaan model
    if not (os.path.exists(SVM_MODEL_PATH) and os.path.exists(LABEL_ENCODER_PATH) and os.path.exists(SCALER_PATH)):
        print("[ERROR] Model hasil training belum lengkap atau belum ada di folder models/.")
        print("Silakan jalankan script training SVM terlebih dahulu.")
        return
        
    # Validasi keberadaan file fitur testing
    if not os.path.exists(test_features_path) or not os.path.exists(test_labels_path):
        print("[INFO] File fitur testing tidak ditemukan di folder models/.")
        print("Pastikan Anda memiliki data testing di folder 'dataset/test' dan jalankan:")
        print("python training/ekstrak_fitur.py")
        return
        
    print("Memuat model dan data testing...")
    svm_model = joblib.load(SVM_MODEL_PATH)
    label_encoder = joblib.load(LABEL_ENCODER_PATH)
    scaler = joblib.load(SCALER_PATH)
    
    X_test = np.load(test_features_path)
    y_test = np.load(test_labels_path)
    
    print(f"Data testing dimuat: {X_test.shape[0]} sampel dengan {X_test.shape[1]} fitur.")
    
    # 1. Transformasi label teks ke angka menggunakan LabelEncoder yang sudah dilatih
    try:
        y_test_encoded = label_encoder.transform(y_test)
    except ValueError as e:
        print(f"[ERROR] Ditemukan kelas baru pada data testing yang tidak ada saat training: {str(e)}")
        return
        
    # 2. Scaling fitur testing menggunakan StandardScaler yang sudah dilatih
    X_test_scaled = scaler.transform(X_test)
    
    # 3. Prediksi menggunakan SVM
    print("Menjalankan prediksi pada data testing...")
    y_pred = svm_model.predict(X_test_scaled)
    
    # 4. Perhitungan Metrik Evaluasi
    accuracy = accuracy_score(y_test_encoded, y_pred)
    conf_matrix = confusion_matrix(y_test_encoded, y_pred)
    class_report = classification_report(
        y_test_encoded, 
        y_pred, 
        target_names=label_encoder.classes_
    )
    
    # Tampilkan hasil evaluasi
    print("\n==================================================")
    print("               HASIL EVALUASI MODEL               ")
    print("==================================================")
    print(f"Akurasi Keseluruhan: {accuracy * 100:.2f}%")
    print("\nLaporan Klasifikasi (Classification Report):")
    print(class_report)
    
    print("Confusion Matrix:")
    print("Baris menunjukkan kelas Aktual, Kolom menunjukkan kelas Prediksi.")
    print("Urutan kelas:", label_encoder.classes_)
    print(conf_matrix)
    print("==================================================")

if __name__ == "__main__":
    main()
