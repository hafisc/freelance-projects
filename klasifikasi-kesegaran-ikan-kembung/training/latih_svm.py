import os
import sys
import joblib
import numpy as np
from sklearn.svm import SVC
from sklearn.preprocessing import LabelEncoder, StandardScaler

# Menambahkan root direktori proyek ke sys.path secara dinamis
BASE_DIR = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
if BASE_DIR not in sys.path:
    sys.path.append(BASE_DIR)

from src.konfigurasi import MODELS_DIR, SVM_MODEL_PATH, LABEL_ENCODER_PATH, SCALER_PATH

def main():
    train_features_path = os.path.join(MODELS_DIR, "train_features.npy")
    train_labels_path = os.path.join(MODELS_DIR, "train_labels.npy")
    
    # Validasi keberadaan file fitur
    if not os.path.exists(train_features_path) or not os.path.exists(train_labels_path):
        print("[ERROR] File fitur training tidak ditemukan di folder models/.")
        print("Silakan jalankan script ekstraksi fitur terlebih dahulu dengan perintah:")
        print("python training/ekstrak_fitur.py")
        return
        
    print("Memuat data fitur training...")
    X_train = np.load(train_features_path)
    y_train = np.load(train_labels_path)
    
    print(f"Data training dimuat: {X_train.shape[0]} sampel dengan {X_train.shape[1]} fitur.")
    
    # 1. Encoding Label Kelas (mengubah teks kelas menjadi angka)
    print("Melakukan encoding label kelas...")
    label_encoder = LabelEncoder()
    y_train_encoded = label_encoder.fit_transform(y_train)
    
    # Tampilkan mapping label
    for index, class_name in enumerate(label_encoder.classes_):
        print(f"  Label {index} -> {class_name}")
        
    # 2. Normalisasi Fitur (Feature Scaling)
    print("Melakukan scaling fitur dengan StandardScaler...")
    scaler = StandardScaler()
    X_train_scaled = scaler.fit_transform(X_train)
    
    # 3. Training SVM Classifier
    print("Melatih model SVM (Support Vector Machine)...")
    svm_model = SVC(
        kernel='rbf',
        C=1.0,
        gamma='scale',
        probability=True,
        random_state=42
    )
    
    svm_model.fit(X_train_scaled, y_train_encoded)
    
    # Evaluasi sederhana pada data training
    train_accuracy = svm_model.score(X_train_scaled, y_train_encoded)
    print(f"\nAkurasi pada data training: {train_accuracy * 100:.2f}%")
    
    # 4. Menyimpan Model dan Komponen Pendukung
    print("\nMenyimpan model ke direktori models/...")
    os.makedirs(MODELS_DIR, exist_ok=True)
    
    joblib.dump(svm_model, SVM_MODEL_PATH)
    joblib.dump(label_encoder, LABEL_ENCODER_PATH)
    joblib.dump(scaler, SCALER_PATH)
    
    print(f"[SUKSES] Model SVM disimpan di: {SVM_MODEL_PATH}")
    print(f"[SUKSES] Label Encoder disimpan di: {LABEL_ENCODER_PATH}")
    print(f"[SUKSES] Scaler disimpan di: {SCALER_PATH}")
    print("\nSilakan jalankan script evaluasi model untuk melihat performa pada data testing.")

if __name__ == "__main__":
    main()
