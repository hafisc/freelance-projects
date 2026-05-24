import tensorflow as tf
import numpy as np

# Inisialisasi model secara global agar tidak di-load ulang setiap kali ekstraksi
_model_ekstraktor_fitur = None

def dapatkan_model_ekstraktor_fitur():
    """
    Memuat model MobileNetV3Large yang telah dilatih (pre-trained on ImageNet).
    include_top=False digunakan untuk membuang layer klasifikasi akhir.
    pooling='avg' menerapkan Global Average Pooling untuk menghasilkan representasi fitur 1D berukuran 960.
    
    Returns:
        tf.keras.Model: Model pengekstraksi fitur MobileNetV3.
    """
    global _model_ekstraktor_fitur
    if _model_ekstraktor_fitur is None:
        try:
            # Memuat MobileNetV3Large dengan bobot ImageNet
            _model_ekstraktor_fitur = tf.keras.applications.MobileNetV3Large(
                input_shape=(224, 224, 3),
                include_top=False,
                weights='imagenet',
                pooling='avg'
            )
            # Pastikan model tidak dilatih ulang (freeze weights)
            _model_ekstraktor_fitur.trainable = False
        except Exception as e:
            raise RuntimeError(f"Gagal memuat model MobileNetV3: {str(e)}")
            
    return _model_ekstraktor_fitur

def ekstrak_fitur_gambar(preprocessed_image):
    """
    Mengekstrak vektor fitur 1D dari gambar yang telah dipreproses.
    
    Parameters:
        preprocessed_image (np.ndarray): Array gambar terpreproses dengan shape (1, 224, 224, 3).
        
    Returns:
        np.ndarray: Vektor fitur 1D dengan ukuran 960 (shape: (960,)).
    """
    model = dapatkan_model_ekstraktor_fitur()
    try:
        # Lakukan forward pass untuk ekstraksi fitur
        features = model.predict(preprocessed_image, verbose=0)
        # Squeeze dimensi batch agar menghasilkan array 1D
        return np.squeeze(features)
    except Exception as e:
        raise RuntimeError(f"Gagal mengekstrak fitur dari gambar: {str(e)}")
