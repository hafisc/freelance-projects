import os
import numpy as np
from PIL import Image
import tensorflow as tf
from src.konfigurasi import IMAGE_SIZE

def validasi_file_gambar(file_path):
    """
    Memvalidasi apakah file merupakan gambar yang valid dan tidak rusak (corrupt).
    
    Parameters:
        file_path (str): Path absolut atau relatif ke file gambar.
        
    Returns:
        bool: True jika gambar valid, False jika tidak.
    """
    if not os.path.exists(file_path):
        return False
    
    # Periksa ekstensi file
    valid_extensions = ['.jpg', '.jpeg', '.png']
    ext = os.path.splitext(file_path)[1].lower()
    if ext not in valid_extensions:
        return False
        
    try:
        # Coba buka gambar menggunakan Pillow
        with Image.open(file_path) as img:
            img.verify()  # Memverifikasi integritas gambar tanpa me-load data pikselnya
        return True
    except Exception:
        # Jika gambar rusak atau bukan file gambar, return False
        return False

def baca_dan_praproses_gambar(image_path_or_file):
    """
    Membaca gambar, melakukan resize ke ukuran input MobileNetV3 (224x224),
    dan melakukan normalisasi/preprocessing Keras.
    
    Parameters:
        image_path_or_file (str or file-like object): Path gambar atau objek file dari Streamlit.
        
    Returns:
        np.ndarray: Array numpy gambar yang siap dimasukkan ke MobileNetV3 dengan shape (1, 224, 224, 3).
    """
    try:
        # Buka gambar (mendukung path string maupun file-like object dari streamlit)
        if isinstance(image_path_or_file, str):
            img = Image.open(image_path_or_file)
        else:
            img = Image.open(image_path_or_file)
            
        # Konversi ke format RGB (jika gambar grayscale atau RGBA)
        if img.mode != 'RGB':
            img = img.convert('RGB')
            
        # Resize gambar ke ukuran target (224, 224)
        img = img.resize(IMAGE_SIZE, Image.Resampling.BILINEAR)
        
        # Konversi gambar ke numpy array
        img_array = np.array(img, dtype=np.float32)
        
        # Tambahkan dimensi batch: (224, 224, 3) -> (1, 224, 224, 3)
        img_array = np.expand_dims(img_array, axis=0)
        
        # Lakukan preprocessing standar MobileNetV3 menggunakan TensorFlow Keras
        preprocessed_img = tf.keras.applications.mobilenet_v3.preprocess_input(img_array)
        
        return preprocessed_img
    except Exception as e:
        raise ValueError(f"Gagal memproses gambar: {str(e)}")
