import streamlit as st

def inject_custom_css():
    """
    Menyuntikkan CSS kustom ke aplikasi Streamlit untuk memberikan estetika modern,
    clean, dan ramah pengguna dengan skema warna biru profesional.
    """
    custom_css = """
    <style>
        /* Import Google Font 'Inter' */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        /* Terapkan font Inter secara global */
        html, body, [class*="css"], .stMarkdown {
            font-family: 'Inter', 'Segoe UI', sans-serif;
        }
        
        /* Warna Background Halaman Utama */
        .main {
            background-color: #F8FAFC;
        }
        
        /* Custom Card Container */
        .tutor-card {
            background-color: #FFFFFF;
            border-radius: 12px;
            padding: 24px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            margin-bottom: 20px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .tutor-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.03);
            border-color: #CBD5E1;
        }
        
        /* Custom Info Box */
        .info-box {
            background-color: #DBEAFE;
            color: #1E40AF;
            border-radius: 8px;
            padding: 16px;
            border-left: 5px solid #2563EB;
            margin-bottom: 20px;
            font-size: 0.95rem;
        }
        
        /* Custom Title Banner */
        .header-banner {
            background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%);
            color: #FFFFFF;
            border-radius: 12px;
            padding: 32px;
            margin-bottom: 28px;
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.2);
            text-align: center;
        }
        .header-banner h1 {
            color: #FFFFFF !important;
            font-size: 2.5rem !important;
            font-weight: 700 !important;
            margin-bottom: 8px !important;
        }
        .header-banner p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 0px;
        }
        
        /* Tombol Streamlit Kustom */
        div.stButton > button {
            background-color: #2563EB !important;
            color: #FFFFFF !important;
            border: 1px solid #2563EB !important;
            border-radius: 8px !important;
            padding: 8px 20px !important;
            font-weight: 500 !important;
            transition: all 0.2s ease !important;
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.1) !important;
        }
        div.stButton > button:hover {
            background-color: #1D4ED8 !important;
            border-color: #1D4ED8 !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2) !important;
        }
        div.stButton > button:active {
            transform: translateY(0px) !important;
        }
        
        /* Sidebar styling */
        section[data-testid="stSidebar"] {
            background-color: #0F172A;
            color: #F8FAFC;
        }
        section[data-testid="stSidebar"] [data-testid="stMarkdownContainer"] p {
            color: #E2E8F0;
        }
        
        /* Footer styling */
        .footer {
            text-align: center;
            padding: 20px 0px;
            color: #64748B;
            font-size: 0.85rem;
            border-top: 1px solid #E2E8F0;
            margin-top: 40px;
        }
    </style>
    """
    st.markdown(custom_css, unsafe_allow_html=True)

def show_header():
    """
    Menampilkan header utama aplikasi dengan desain gradien biru premium.
    """
    st.markdown(
        """
        <div class="header-banner">
            <h1>🚀 EngliTutor AI</h1>
            <p>Learn English easier with your personal AI tutor.</p>
        </div>
        """,
        unsafe_allow_html=True
    )

def show_footer():
    """
    Menampilkan footer sederhana di bagian bawah halaman.
    """
    st.markdown(
        """
        <div class="footer">
            EngliTutor AI © 2026 • Dirancang untuk Pembelajaran Mandiri Bahasa Inggris yang Efektif.
        </div>
        """,
        unsafe_allow_html=True
    )

def show_card(title: str, content: str, icon: str = "💡"):
    """
    Menampilkan container card kustom untuk dashboard home.
    """
    st.markdown(
        f"""
        <div class="tutor-card">
            <h3 style="margin-top: 0px; color: #0F172A; font-size: 1.25rem;">{icon} {title}</h3>
            <p style="color: #475569; font-size: 0.95rem; margin-bottom: 0px; line-height: 1.5;">{content}</p>
        </div>
        """,
        unsafe_allow_html=True
    )

def show_info_box(message: str):
    """
    Menampilkan kotak informasi pemandu berwarna biru.
    """
    st.markdown(
        f"""
        <div class="info-box">
            {message}
        </div>
        """,
        unsafe_allow_html=True
    )

def render_api_key_warning(provider: str):
    """
    Menampilkan pesan error/warning yang rapi dan interaktif jika API Key belum dikonfigurasi.
    """
    st.warning(f"⚠️ **API Key untuk {provider.capitalize()} Belum Dikonfigurasi!**")
    
    st.markdown(
        f"""
        <div style="background-color: #FFFBEB; border-left: 5px solid #F59E0B; padding: 16px; border-radius: 8px; margin-bottom: 20px;">
            <h4 style="margin-top: 0px; color: #92400E; font-size: 1rem;">Cara Mengaktifkan Fitur AI:</h4>
            <ol style="color: #B45309; font-size: 0.9rem; margin-bottom: 0px; padding-left: 20px;">
                <li>Buat file bernama <b>.env</b> di direktori utama proyek ini (sejajar dengan app.py).</li>
                <li>Salin isi dari file <b>.env.example</b> ke dalam file <b>.env</b> baru tersebut.</li>
                <li>Masukkan API Key Anda yang valid pada variabel:
                    <br/><code>AI_PROVIDER={provider}</code>
                    <br/><code>GEMINI_API_KEY=your_gemini_api_key_here</code> (jika memakai Gemini)
                    <br/>atau
                    <br/><code>OPENAI_API_KEY=your_openai_api_key_here</code> (jika memakai OpenAI)
                </li>
                <li>Simpan file tersebut dan restart aplikasi (atau segarkan halaman browser).</li>
            </ol>
            <p style="margin-top: 10px; margin-bottom: 0px; font-size: 0.9rem; color: #B45309;">
                <i>Catatan: Fitur <b>Basic English Quiz</b> (Kuis Luring) tetap dapat Anda gunakan sepenuhnya meskipun tanpa API Key AI.</i>
            </p>
        </div>
        """,
        unsafe_allow_html=True
    )
