# PROJECT.md — Spesifikasi Project EngliTutor AI

## Ringkasan
EngliTutor AI adalah website chatbot sederhana berbasis AI untuk membantu belajar Bahasa Inggris. Aplikasi dibuat menggunakan Python, Streamlit, dan Gemini API/OpenAI API.

## Latar Belakang
Project ini dibuat untuk menerapkan beberapa skill dasar:
1. Prompt engineering
2. Large Language Models
3. Natural Language Processing
4. Pembuatan materi belajar yang mudah dipahami
5. Pembuatan chatbot sederhana

## Teknologi
- Python
- Streamlit
- Gemini API / OpenAI API
- dotenv
- JSON untuk data quiz sederhana

## Target Output
Aplikasi web sederhana yang bisa dijalankan lokal dan memiliki beberapa fitur pembelajaran Bahasa Inggris.

## Modul Fitur

### 1. Home
Menampilkan pengenalan aplikasi dan daftar fitur.

### 2. AI Tutor Chat
Chat umum untuk bertanya materi Bahasa Inggris.

### 3. Grammar Correction
Membantu user memperbaiki kalimat Bahasa Inggris.

### 4. Vocabulary Helper
Membantu user memahami arti kata/frasa Bahasa Inggris.

### 5. Conversation Practice
Membantu user latihan percakapan Bahasa Inggris.

### 6. Basic English Quiz
Latihan soal dasar Bahasa Inggris dengan skor.

### 7. About
Menampilkan penjelasan skill yang dipelajari dan teknologi project.

## Batasan Project
- Aplikasi tidak membutuhkan database.
- Aplikasi tidak membutuhkan login/register.
- Quiz cukup menggunakan file JSON lokal.
- Fokus pada fungsi pembelajaran sederhana.
- Tidak perlu deploy hosting kecuali diminta terpisah.
- API key disediakan oleh client/user.

## Struktur Folder Final
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

## Environment Variable
```env
AI_PROVIDER=gemini
GEMINI_API_KEY=
OPENAI_API_KEY=
```

## Perintah Jalankan
```bash
pip install -r requirements.txt
streamlit run app.py
```

## Checklist Selesai
- [ ] Project bisa dijalankan.
- [ ] Sidebar navigasi tampil.
- [ ] Home tampil rapi.
- [ ] AI Tutor Chat bisa menjawab.
- [ ] Grammar Correction bisa digunakan.
- [ ] Vocabulary Helper bisa digunakan.
- [ ] Conversation Practice bisa digunakan.
- [ ] Quiz basic English bisa menampilkan skor.
- [ ] Error API key tertangani.
- [ ] README tersedia.
- [ ] Komentar Bahasa Indonesia ada di fungsi penting.
