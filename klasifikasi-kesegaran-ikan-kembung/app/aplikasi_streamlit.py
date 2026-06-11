import os
import sys
import streamlit as st
from PIL import Image

# Menambahkan root direktori proyek ke sys.path secara dinamis
BASE_DIR = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
if BASE_DIR not in sys.path:
    sys.path.append(BASE_DIR)

from src.prediktor import apakah_model_siap, prediksi_kesegaran_ikan
from src.konfigurasi import CLASS_MAPPING, SAMPLES_DIR

# ----------------- KONFIGURASI HALAMAN -----------------
st.set_page_config(
    page_title="Klasifikasi Kesegaran Ikan Kembung",
    page_icon="🐟",
    layout="centered",
    initial_sidebar_state="expanded"
)

# ----------------- CUSTOM STYLE (CSS) -----------------
st.markdown(
    """
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap');
    
    html, body, [class*="css"] {
        font-family: 'Outfit', sans-serif;
    }
    
    .main-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1d3557;
        text-align: center;
        margin-bottom: 0.2rem;
    }
    
    .sub-title {
        font-size: 1.1rem;
        color: #457b9d;
        text-align: center;
        margin-bottom: 2rem;
        font-weight: 300;
    }
    
    .card {
        background-color: #f8f9fa;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        margin-bottom: 1.5rem;
        border-left: 5px solid #1d3557;
    }
    
    .tech-pill {
        display: inline-block;
        background-color: #e2eafc;
        color: #1d3557;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.85rem;
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }
    
    .result-container {
        border-radius: 12px;
        padding: 2rem;
        color: white;
        text-align: center;
        margin-top: 1.5rem;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }
    
    .result-container:hover {
        transform: translateY(-5px);
    }
    
    .result-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .result-detail {
        font-size: 1.2rem;
        margin-bottom: 0.8rem;
        font-weight: 500;
    }
    
    .result-confidence {
        font-size: 1rem;
        background-color: rgba(255, 255, 255, 0.2);
        display: inline-block;
        padding: 0.2rem 0.8rem;
        border-radius: 15px;
        margin-bottom: 1rem;
    }
    
    .result-desc {
        font-size: 0.95rem;
        font-weight: 300;
        line-height: 1.4;
    }
    </style>
    """,
    unsafe_allow_html=True
)

# ----------------- SIDEBAR -----------------
with st.sidebar:
    st.image("https://img.icons8.com/plasticine/200/fish.png", width=120, use_container_width=False)
    st.markdown("### **Tentang Aplikasi**")
    st.markdown(
        """
        Aplikasi ini menggunakan teknologi **Machine Learning** untuk mendeteksi kesegaran ikan kembung berdasarkan foto.
        
        **Teknologi Utama:**
        - **MobileNetV3** (Feature Extractor)
        - **SVM** (Classifier)
        """
    )
    st.markdown("---")
    st.markdown("### **Petunjuk Penggunaan:**")
    st.markdown(
        """
        1. Ambil foto ikan secara jelas (sebaiknya tampak seluruh badan / mata & insang).
        2. Upload foto di area yang disediakan.
        3. Klik tombol **Prediksi Gambar** untuk melihat hasilnya.
        """
    )

# ----------------- UTAMA / HEADER -----------------
st.markdown("<h1 class='main-title'>Klasifikasi Kesegaran Ikan Kembung</h1>", unsafe_allow_html=True)
st.markdown("<p class='sub-title'>Upload gambar ikan untuk mendeteksi apakah gambar termasuk Ikan Kembung (Segar / Tidak Segar) atau Ikan Lain.</p>", unsafe_allow_html=True)

# ----------------- CEK KESIAPAN MODEL -----------------
model_ready = apakah_model_siap()

if not model_ready:
    st.error("⚠️ **Model Belum Ditemukan!**")
    st.info(
        """
        Berkas model klasifikasi belum dilatih atau belum lengkap di folder `models/`. 
        Silakan ikuti instruksi berikut untuk melatih model terlebih dahulu:
        
        1. Pastikan Anda sudah meletakkan gambar dataset di folder `dataset/train` dan `dataset/test`.
        2. Jalankan perintah ekstraksi fitur:
           ```bash
           python training/ekstrak_fitur.py
           ```
        3. Jalankan perintah training SVM:
           ```bash
           python training/latih_svm.py
           ```
        4. Muat ulang halaman website ini.
        """
    )
else:
    # ----------------- AREA UPLOAD & PREVIEW -----------------
    st.markdown("### 📷 **Upload Gambar Ikan**")
    
    # Drag and Drop Uploader
    uploaded_file = st.file_uploader(
        "Pilih file gambar dengan format JPG, JPEG, atau PNG...",
        type=["jpg", "jpeg", "png"],
        help="Maksimal ukuran file disarankan di bawah 5MB"
    )
    
    # Opsi menggunakan gambar sample jika ada di folder samples/
    sample_options = ["-- Pilih Gambar Contoh --"]
    if os.path.exists(SAMPLES_DIR):
        samples = [f for f in os.listdir(SAMPLES_DIR) if f.lower().endswith(('.png', '.jpg', '.jpeg'))]
        sample_options.extend(samples)
        
    selected_sample = None
    if len(sample_options) > 1:
        st.markdown("💡 *Atau, Anda bisa menggunakan gambar contoh di bawah ini:*")
        selected_sample = st.selectbox("Pilih Gambar Contoh:", sample_options)

    # Menentukan file gambar aktif yang akan diproses
    active_image = None
    
    if uploaded_file is not None:
        active_image = uploaded_file
        # Tampilkan preview gambar yang diupload
        st.image(uploaded_file, caption="Gambar yang Anda Upload", use_container_width=True)
    elif selected_sample and selected_sample != "-- Pilih Gambar Contoh --":
        sample_path = os.path.join(SAMPLES_DIR, selected_sample)
        active_image = sample_path
        # Tampilkan preview gambar contoh
        st.image(sample_path, caption=f"Gambar Contoh: {selected_sample}", use_container_width=True)
        
    # ----------------- TOMBOL PREDIKSI & PROSES -----------------
    if active_image is not None:
        st.markdown("")
        btn_col1, btn_col2, btn_col3 = st.columns([1, 2, 1])
        
        with btn_col2:
            predict_button = st.button("🔍 Mulai Prediksi Kesegaran", use_container_width=True, type="primary")
            
        if predict_button:
            with st.spinner("Sedang memproses gambar dan mengekstrak fitur..."):
                try:
                    # Jalankan prediksi
                    result = prediksi_kesegaran_ikan(active_image)
                    
                    # ----------------- TAMPILAN HASIL PREDIKSI -----------------
                    st.success("Analisis gambar selesai!")
                    
                    # Card Hasil Klasifikasi dengan warna dinamis sesuai status
                    color = result["color"]
                    st.markdown(
                        f"""
                        <div class="result-container" style="background: linear-gradient(135deg, {color} 0%, {color}cc 100%);">
                            <div class="result-title">Hasil Klasifikasi</div>
                            <div class="result-detail">Jenis Ikan: <b>{result['jenis']}</b></div>
                            <div class="result-detail">Status Kesegaran: <b>{result['kesegaran']}</b></div>
                            <div class="result-confidence">Tingkat Keyakinan: {result['confidence'] * 100:.2f}%</div>
                            <div class="result-desc">{result['deskripsi']}</div>
                        </div>
                        """,
                        unsafe_allow_html=True
                    )
                    
                except Exception as e:
                    st.error("⚠️ **Gagal Melakukan Prediksi**")
                    st.exception(e)
    else:
        st.info("Silakan upload gambar ikan Anda terlebih dahulu untuk memulai prediksi.")

# ----------------- SECTION INFORMASI TEKNIS -----------------
st.markdown("---")
st.markdown("### 🛠️ **Informasi Arsitektur Sistem**")
col1, col2 = st.columns(2)

with col1:
    st.markdown(
        """
        <div class="card">
            <h4>1. Feature Extractor</h4>
            <p>Menggunakan arsitektur <b>MobileNetV3-Large</b> (pre-trained on ImageNet) dari Google yang di-freeze bobotnya. Berperan mengubah visual gambar menjadi 960 representasi fitur numerik.</p>
            <span class="tech-pill">TensorFlow Keras</span>
            <span class="tech-pill">Transfer Learning</span>
        </div>
        """,
        unsafe_allow_html=True
    )

with col2:
    st.markdown(
        """
        <div class="card">
            <h4>2. Classifier Model</h4>
            <p>Menggunakan <b>Support Vector Machine (SVM)</b> dengan kernel RBF yang dilatih khusus di atas fitur bentukan MobileNetV3. Membedakan ikan kembung segar, tidak segar, dan ikan lain secara akurat.</p>
            <span class="tech-pill">Scikit-Learn</span>
            <span class="tech-pill">RBF Kernel SVM</span>
        </div>
        """,
        unsafe_allow_html=True
    )
