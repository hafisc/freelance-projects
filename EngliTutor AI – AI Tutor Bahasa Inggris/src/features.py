import json
import os
from src import ai_client, prompts

def ask_tutor(question: str, history: list[dict] = None) -> str:
    """
    Mengirimkan pertanyaan pengguna ke AI Tutor.
    Jika history disediakan, percakapan akan bersifat multi-turn (ingat konteks).
    """
    # Fungsi ini meneruskan pertanyaan umum tentang Bahasa Inggris ke AI Client
    if history:
        # Menambahkan pesan baru ke history sebelum dikirim
        chat_messages = history + [{"role": "user", "content": question}]
        return ai_client.generate_chat_response(chat_messages, prompts.SYSTEM_PROMPT_GENERAL_TUTOR)
    else:
        return ai_client.generate_response(question, prompts.SYSTEM_PROMPT_GENERAL_TUTOR)

def correct_grammar(sentence: str) -> str:
    """
    Mengirim kalimat bahasa Inggris dari pengguna untuk dianalisis dan dikoreksi tata bahasanya.
    """
    # Mengirim kalimat ke model AI dengan instruksi sistem koreksi grammar
    return ai_client.generate_response(sentence, prompts.SYSTEM_PROMPT_GRAMMAR_CORRECTION)

def explain_vocabulary(word: str) -> str:
    """
    Mengirimkan kata atau frasa bahasa Inggris ke AI untuk mendapatkan arti, contoh kalimat, dan sinonim.
    """
    # Mengirim kosakata ke model AI dengan instruksi sistem vocabulary helper
    return ai_client.generate_response(word, prompts.SYSTEM_PROMPT_VOCABULARY_HELPER)

def get_conversation_starter(topic: str) -> str:
    """
    Menghasilkan kalimat pembuka percakapan (starter) yang natural berdasarkan topik yang dipilih.
    """
    # Menggunakan AI untuk generate kalimat pembuka agar dinamis dan natural
    system_instruction = (
        "You are a friendly English conversation tutor. Generate only a single, warm, brief conversation "
        "starter (1-2 sentences) in English to invite the user to talk about the given topic. "
        "Do not include any translations, greetings in Indonesian, or extra text."
    )
    prompt = f"Topic: {topic}"
    response = ai_client.generate_response(prompt, system_instruction)
    
    # Fallback jika terjadi error
    if response.startswith("⚠️ ERROR") or "Terjadi kesalahan" in response:
        starters = {
            "Job Interview": "Hello! I am ready to conduct your job interview practice today. Shall we begin with your self-introduction?",
            "Daily Activities": "Hi there! I would love to hear about your day. What is your typical morning routine like?",
            "Asking Directions": "Excuse me, I seem to be lost. Could you help me find the nearest train station?",
            "Hobby & Travel": "Hello! Travelling is always exciting. What is the most memorable trip you have ever taken?",
            "Ordering Food": "Welcome to our restaurant! Are you ready to order, or do you need a few more minutes with the menu?"
        }
        return starters.get(topic, f"Hi! Let's start practicing our conversation about {topic}. What are your thoughts on this topic?")
    
    return response

def practice_conversation(messages: list[dict], topic: str) -> str:
    """
    Melanjutkan percakapan latihan bahasa Inggris berdasarkan topik yang dipilih dan riwayat percakapan.
    """
    # Menyertakan topik ke dalam system instruction agar AI tetap konsisten pada topik tersebut
    custom_system_prompt = prompts.SYSTEM_PROMPT_CONVERSATION_PRACTICE + f"\nThe topic of conversation is: '{topic}'."
    return ai_client.generate_chat_response(messages, custom_system_prompt)

def load_quiz_data() -> list:
    """
    Membaca data kuis pilihan ganda dari file lokal JSON.
    """
    # Menentukan path absolute file JSON agar aman dijalankan dari direktori manapun
    base_dir = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
    quiz_path = os.path.join(base_dir, "data", "sample_quiz.json")
    
    try:
        with open(quiz_path, "r", encoding="utf-8") as file:
            return json.load(file)
    except Exception as e:
        # Mengembalikan list default sebagai cadangan jika file tidak ditemukan/error
        print(f"Error loading quiz data: {e}")
        return [
            {
                "question": "She ___ a student. (Default)",
                "options": ["am", "is", "are", "be"],
                "answer": "is",
                "explanation": "Subject 'She' menggunakan to be 'is'."
            }
        ]

def calculate_score(user_answers: dict, quiz_data: list) -> tuple[int, int]:
    """
    Menghitung skor berdasarkan jawaban pengguna.
    Mengembalikan tuple: (jumlah_benar, skor_persentase).
    """
    # Menghitung berapa banyak jawaban user yang sesuai dengan jawaban benar di JSON
    correct_count = 0
    total_questions = len(quiz_data)
    
    for i, item in enumerate(quiz_data):
        # Kunci jawaban pada session state biasanya diidentifikasi dengan indeks soal
        user_ans = user_answers.get(i)
        if user_ans == item["answer"]:
            correct_count += 1
            
    percentage = int((correct_count / total_questions) * 100) if total_questions > 0 else 0
    return correct_count, percentage
