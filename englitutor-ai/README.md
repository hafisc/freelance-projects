# EngliTutor AI

EngliTutor AI adalah website chatbot sederhana untuk membantu belajar Bahasa Inggris menggunakan Python, Streamlit, dan Gemini API/OpenAI API.

## Fitur
1. AI Tutor Chat
2. Grammar Correction
3. Vocabulary Helper
4. Conversation Practice
5. Basic English Quiz

## Skill yang Dipelajari
1. Prompt engineering
2. Large Language Models
3. NLP
4. Membuat materi belajar yang mudah dipahami
5. Membuat chatbot sederhana

## Teknologi
- Python
- Streamlit
- Gemini API / OpenAI API
- dotenv

## Struktur Folder
```txt
englitutor-ai/
├── app.py
├── requirements.txt
├── .env.example
├── README.md
├── src/
│   ├── __init__.py
│   ├── config.py
│   ├── ai_client.py
│   ├── prompts.py
│   ├── features.py
│   └── ui.py
├── data/
│   └── sample_quiz.json
└── docs/
    ├── SETUP.md
    └── TESTING.md
```

## Cara Install
Clone atau buka folder project, lalu install dependency:

```bash
pip install -r requirements.txt
```

## Setup Environment
Copy file `.env.example` menjadi `.env`.

```bash
cp .env.example .env
```

Isi API key:

```env
AI_PROVIDER=gemini
GEMINI_API_KEY=isi_api_key_gemini
OPENAI_API_KEY=
```

## Cara Menjalankan
```bash
streamlit run app.py
```

## Catatan
API key tidak boleh ditulis langsung di kode. Gunakan file `.env` agar lebih aman.
