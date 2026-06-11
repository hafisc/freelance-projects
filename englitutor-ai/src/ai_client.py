import logging
import google.generativeai as genai
from openai import OpenAI
from src import config

# Konfigurasi logging dasar
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

# Mengatur konfigurasi API Key secara global jika provider adalah gemini dan key tersedia
if config.AI_PROVIDER == "gemini" and config.GEMINI_API_KEY:
    genai.configure(api_key=config.GEMINI_API_KEY)

def generate_response(prompt: str, system_instruction: str = None) -> str:
    """
    Mengirim prompt satu kali (single-turn) ke AI Provider yang aktif.
    Mengembalikan teks respons dari AI atau pesan error jika terjadi kegagalan.
    """
    # Validasi API key terlebih dahulu sebelum memanggil API
    is_valid, err_msg = config.validate_config()
    if not is_valid:
        return f"⚠️ ERROR: {err_msg}"

    if config.AI_PROVIDER == "gemini":
        try:
            # Gunakan gemini-1.5-flash untuk respon yang cepat dan hemat resource
            model = genai.GenerativeModel(
                model_name="gemini-1.5-flash",
                system_instruction=system_instruction
            )
            response = model.generate_content(prompt)
            return response.text.strip()
        except Exception as e:
            logger.error(f"Error pada Gemini API: {e}")
            return (
                "Terjadi kesalahan saat berkomunikasi dengan Gemini API. "
                "Pastikan koneksi internet Anda stabil dan API Key yang Anda masukkan valid.\n\n"
                f"Detail Error: {str(e)}"
            )

    elif config.AI_PROVIDER == "openai":
        try:
            # Menggunakan client OpenAI dengan key dari config
            client = OpenAI(api_key=config.OPENAI_API_KEY)
            messages = []
            if system_instruction:
                messages.append({"role": "system", "content": system_instruction})
            messages.append({"role": "user", "content": prompt})

            # Gunakan gpt-4o-mini sebagai alternatif hemat biaya dan cepat
            response = client.chat.completions.create(
                model="gpt-4o-mini",
                messages=messages
            )
            return response.choices[0].message.content.strip()
        except Exception as e:
            logger.error(f"Error pada OpenAI API: {e}")
            return (
                "Terjadi kesalahan saat berkomunikasi dengan OpenAI API. "
                "Pastikan koneksi internet Anda stabil dan API Key yang Anda masukkan valid.\n\n"
                f"Detail Error: {str(e)}"
            )
            
    return "⚠️ ERROR: Provider AI tidak dikenali."

def generate_chat_response(messages: list[dict], system_instruction: str = None) -> str:
    """
    Mengirim riwayat pesan (multi-turn) ke AI Provider yang aktif.
    `messages` berformat list of dict: [{"role": "user"/"assistant", "content": "..."}]
    """
    is_valid, err_msg = config.validate_config()
    if not is_valid:
        return f"⚠️ ERROR: {err_msg}"

    if not messages:
        return "Pesan kosong."

    if config.AI_PROVIDER == "gemini":
        try:
            # Konversi format riwayat chat dari standar Streamlit/OpenAI ke format Gemini SDK
            gemini_history = []
            for msg in messages[:-1]:
                # Streamlit/OpenAI menggunakan 'assistant', sedangkan Gemini menggunakan 'model'
                role = "user" if msg["role"] == "user" else "model"
                gemini_history.append({
                    "role": role,
                    "parts": [msg["content"]]
                })
                
            model = genai.GenerativeModel(
                model_name="gemini-1.5-flash",
                system_instruction=system_instruction
            )
            
            # Memulai percakapan dengan riwayat yang ada
            chat = model.start_chat(history=gemini_history)
            last_message_content = messages[-1]["content"]
            response = chat.send_message(last_message_content)
            
            return response.text.strip()
        except Exception as e:
            logger.error(f"Error pada Gemini Chat API: {e}")
            return (
                "Terjadi kesalahan saat berkomunikasi dengan Gemini API. "
                "Pastikan koneksi internet Anda stabil dan API Key yang Anda masukkan valid.\n\n"
                f"Detail Error: {str(e)}"
            )

    elif config.AI_PROVIDER == "openai":
        try:
            client = OpenAI(api_key=config.OPENAI_API_KEY)
            openai_messages = []
            if system_instruction:
                openai_messages.append({"role": "system", "content": system_instruction})
                
            for msg in messages:
                # Menyesuaikan role agar sesuai dengan API OpenAI (user / assistant)
                role = "user" if msg["role"] == "user" else "assistant"
                openai_messages.append({"role": role, "content": msg["content"]})

            response = client.chat.completions.create(
                model="gpt-4o-mini",
                messages=openai_messages
            )
            return response.choices[0].message.content.strip()
        except Exception as e:
            logger.error(f"Error pada OpenAI Chat API: {e}")
            return (
                "Terjadi kesalahan saat berkomunikasi dengan OpenAI API. "
                "Pastikan koneksi internet Anda stabil dan API Key yang Anda masukkan valid.\n\n"
                f"Detail Error: {str(e)}"
            )

    return "⚠️ ERROR: Provider AI tidak dikenali."
