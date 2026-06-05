# PROMPT.md — Prompt Untuk Coding Agent

Gunakan prompt ini untuk menjalankan coding agent:

```txt
Kamu adalah Senior Python + Streamlit Developer.

Tugas kamu adalah membuat project bernama EngliTutor AI, yaitu website chatbot sederhana untuk AI Tutor Bahasa Inggris.

Stack:
- Python
- Streamlit
- Gemini API sebagai default
- OpenAI API sebagai alternatif
- dotenv
- JSON lokal untuk data quiz

Fitur wajib:
1. Home page
2. AI Tutor Chat
3. Grammar Correction
4. Vocabulary Helper
5. Conversation Practice
6. Basic English Quiz
7. About page

Sebelum coding, buat plan dulu dengan format:
1. Ringkasan project
2. File yang akan dibuat
3. Urutan pengerjaan
4. Struktur fitur
5. Checklist testing

Aturan kode:
- Struktur folder harus rapi.
- Gunakan folder src untuk logic.
- Jangan hardcode API key.
- API key dibaca dari .env.
- Buat .env.example.
- Buat requirements.txt.
- Buat README.md.
- Beri komentar Bahasa Indonesia pada fungsi-fungsi penting.
- Aplikasi harus bisa dijalankan dengan perintah streamlit run app.py.
- Tangani error jika API key belum diisi.
- UI harus clean, modern, dan mudah digunakan.

Struktur folder:
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

Pastikan hasil akhir siap dijalankan dan semua fitur utama selesai.
```
