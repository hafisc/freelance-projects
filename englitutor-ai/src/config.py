import os
from dotenv import load_dotenv

# Memuat environment variables dari file .env
load_dotenv()

# Konfigurasi Provider AI dan API Key
AI_PROVIDER = os.getenv("AI_PROVIDER", "gemini").lower()
GEMINI_API_KEY = os.getenv("GEMINI_API_KEY", "").strip()
OPENAI_API_KEY = os.getenv("OPENAI_API_KEY", "").strip()

def validate_config() -> tuple[bool, str]:
    """
    Memvalidasi apakah API Key yang dibutuhkan berdasarkan AI_PROVIDER sudah terisi.
    Mengembalikan (True, "") jika valid, atau (False, "pesan_error") jika tidak valid.
    """
    if AI_PROVIDER not in ["gemini", "openai"]:
        return False, "Provider AI tidak valid. Harap atur AI_PROVIDER menjadi 'gemini' atau 'openai' di file .env."
    
    if AI_PROVIDER == "gemini":
        if not GEMINI_API_KEY:
            return False, (
                "Gemini API Key tidak ditemukan! Harap ikuti langkah-langkah berikut:\n"
                "1. Salin file `.env.example` menjadi `.env` di folder root project.\n"
                "2. Isi variabel `GEMINI_API_KEY` dengan API Key dari Google AI Studio.\n"
                "3. Restart aplikasi Streamlit jika perlu."
            )
    elif AI_PROVIDER == "openai":
        if not OPENAI_API_KEY:
            return False, (
                "OpenAI API Key tidak ditemukan! Harap ikuti langkah-langkah berikut:\n"
                "1. Salin file `.env.example` menjadi `.env` di folder root project.\n"
                "2. Isi variabel `OPENAI_API_KEY` dengan OpenAI API Key Anda yang valid.\n"
                "3. Restart aplikasi Streamlit jika perlu."
            )
            
    return True, ""
