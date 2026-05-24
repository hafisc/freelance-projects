import os
import logging
from datetime import datetime

# Inisialisasi logger standar untuk memantau aktivitas proses ML dan Aplikasi Web
logging.basicConfig(
    level=logging.INFO,
    format='%(asctime)s - %(levelname)s - %(message)s',
    handlers=[
        logging.StreamHandler()
    ]
)
logger = logging.getLogger("LoggerKesegaranIkan")

def log_info(message):
    """
    Mencetak log informasi dengan timestamp ke console.
    """
    logger.info(message)

def log_warning(message):
    """
    Mencetak log peringatan (warning) dengan timestamp ke console.
    """
    logger.warning(message)

def log_error(message):
    """
    Mencetak log error dengan timestamp ke console.
    """
    logger.error(message)

def dapatkan_file_gambar(directory_path):
    """
    Mendapatkan seluruh path file gambar dengan format yang didukung (.jpg, .jpeg, .png)
    dalam sebuah direktori secara rekursif.
    
    Parameters:
        directory_path (str): Path direktori tujuan pemindaian.
        
    Returns:
        list: Daftar path lengkap file gambar yang didukung.
    """
    supported_extensions = ('.jpg', '.jpeg', '.png')
    image_paths = []
    
    if not os.path.exists(directory_path):
        return image_paths
        
    for root, _, files in os.walk(directory_path):
        for file in files:
            if file.lower().endswith(supported_extensions):
                image_paths.append(os.path.join(root, file))
                
    return image_paths
