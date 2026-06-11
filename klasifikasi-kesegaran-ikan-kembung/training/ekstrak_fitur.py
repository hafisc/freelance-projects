import os
import sys
import numpy as np

# Menambahkan root direktori proyek ke sys.path secara dinamis
BASE_DIR = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
if BASE_DIR not in sys.path:
    sys.path.append(BASE_DIR)

from src.konfigurasi import CLASSES, TRAIN_DIR, TEST_DIR, MODELS_DIR
from src.praproses import validasi_file_gambar, baca_dan_praproses_gambar
from src.ekstraktor_fitur import ekstrak_fitur_gambar

def pastikan_struktur_dataset():
    """
    Memastikan struktur folder dataset train dan test beserta kelas-kelasnya telah dibuat.
    Jika belum ada, folder akan dibuat agar user tahu di mana harus menaruh datanya.
    """
    folders_created = False
    for base_folder in [TRAIN_DIR, TEST_DIR]:
        for cls in CLASSES:
            folder_path = os.path.join(base_folder, cls)
            if not os.path.exists(folder_path):
                os.makedirs(folder_path, exist_ok=True)
                print(f"Membuat folder dataset kosong: {folder_path}")
                folders_created = True
                
    if folders_created:
        print("\n[INFO] Struktur folder dataset kosong berhasil dibuat.")
        print("[INFO] Silakan salin gambar dataset Anda ke subfolder yang sesuai di dalam folder 'dataset/' sebelum melanjutkan.")

def proses_folder_dataset(dataset_path):
    """
    Menelusuri subfolder kelas di dalam folder dataset, memproses gambar,
    dan mengekstrak vektor fitur.
    
    Parameters:
        dataset_path (str): Path ke folder dataset (train atau test).
        
    Returns:
        tuple: (features_list, labels_list)
    """
    features_list = []
    labels_list = []
    
    # Periksa apakah folder dataset ada
    if not os.path.exists(dataset_path):
        print(f"[ERROR] Folder {dataset_path} tidak ditemukan.")
        return np.array([]), np.array([])
        
    print(f"Mulai mengekstrak fitur dari folder: {os.path.basename(dataset_path)}")
    
    # Iterasi setiap kelas
    for label in CLASSES:
        class_folder = os.path.join(dataset_path, label)
        if not os.path.exists(class_folder):
            print(f"[WARNING] Subfolder kelas {label} tidak ditemukan di {dataset_path}")
            continue
            
        file_list = [f for f in os.listdir(class_folder) if os.path.isfile(os.path.join(class_folder, f))]
        print(f"  Memproses kelas '{label}': ditemukan {len(file_list)} berkas.")
        
        processed_count = 0
        skipped_count = 0
        
        for file_name in file_list:
            file_path = os.path.join(class_folder, file_name)
            
            # Validasi file gambar
            if not validasi_file_gambar(file_path):
                print(f"    [SKIP] File tidak valid atau rusak: {file_name}")
                skipped_count += 1
                continue
                
            try:
                # Preprocess dan ekstrak fitur
                preprocessed = baca_dan_praproses_gambar(file_path)
                feature_vector = ekstrak_fitur_gambar(preprocessed)
                
                features_list.append(feature_vector)
                labels_list.append(label)
                processed_count += 1
            except Exception as e:
                print(f"    [ERROR] Gagal memproses {file_name}: {str(e)}")
                skipped_count += 1
                
        print(f"  Selesai kelas '{label}': {processed_count} diproses, {skipped_count} dilewati.")
        
    return np.array(features_list), np.array(labels_list)

def main():
    # Pastikan direktori model ada
    os.makedirs(MODELS_DIR, exist_ok=True)
    
    # Buat struktur folder jika belum ada
    pastikan_struktur_dataset()
    
    print("\n--- Ekstraksi Fitur Dataset Training ---")
    train_features, train_labels = proses_folder_dataset(TRAIN_DIR)
    
    print("\n--- Ekstraksi Fitur Dataset Testing ---")
    test_features, test_labels = proses_folder_dataset(TEST_DIR)
    
    # Validasi jika tidak ada gambar yang berhasil diekstrak
    if len(train_features) == 0:
        print("\n[PERINGATAN] Tidak ada data training yang ditemukan. Ekstraksi dihentikan.")
        print("Silakan masukkan dataset gambar ke dalam folder 'dataset/train' sesuai dengan subfolder masing-masing kelas.")
        return
        
    # Simpan hasil ekstraksi fitur
    np.save(os.path.join(MODELS_DIR, "train_features.npy"), train_features)
    np.save(os.path.join(MODELS_DIR, "train_labels.npy"), train_labels)
    print(f"\n[SUKSES] Berhasil mengekstrak {len(train_features)} data training.")
    
    if len(test_features) > 0:
        np.save(os.path.join(MODELS_DIR, "test_features.npy"), test_features)
        np.save(os.path.join(MODELS_DIR, "test_labels.npy"), test_labels)
        print(f"[SUKSES] Berhasil mengekstrak {len(test_features)} data testing.")
    else:
        print("[INFO] Tidak ada data testing yang ditemukan untuk diekstrak.")
        
    print(f"\nSemua file hasil ekstraksi disimpan di folder: {MODELS_DIR}")
    print("Silakan jalankan script training SVM berikutnya.")

if __name__ == "__main__":
    main()
