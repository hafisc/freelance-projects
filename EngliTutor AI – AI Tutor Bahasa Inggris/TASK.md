# TASK.md — Breakdown Tugas Coding Agent

## Tahap 1 — Setup Project
1. Buat struktur folder project.
2. Buat file `requirements.txt`.
3. Buat file `.env.example`.
4. Buat file `README.md`.
5. Buat folder `src`, `data`, dan `docs`.

## Tahap 2 — Config
1. Buat `src/config.py`.
2. Baca environment variable:
   - `AI_PROVIDER`
   - `GEMINI_API_KEY`
   - `OPENAI_API_KEY`
3. Buat validasi API key.
4. Buat pesan error jika API key kosong.

## Tahap 3 — Prompt AI
1. Buat `src/prompts.py`.
2. Siapkan prompt untuk:
   - General tutor
   - Grammar correction
   - Vocabulary helper
   - Conversation practice
3. Prompt harus jelas dan ringkas.

## Tahap 4 — AI Client
1. Buat `src/ai_client.py`.
2. Buat fungsi `generate_response(prompt: str) -> str`.
3. Support Gemini API sebagai default.
4. OpenAI API boleh disiapkan sebagai alternatif.
5. Tangani error API.

## Tahap 5 — Logic Fitur
1. Buat `src/features.py`.
2. Buat fungsi:
   - `ask_tutor(question)`
   - `correct_grammar(sentence)`
   - `explain_vocabulary(word)`
   - `practice_conversation(topic, user_message)`
   - `load_quiz_data()`
   - `calculate_score()`

## Tahap 6 — UI
1. Buat `src/ui.py`.
2. Buat helper UI:
   - Header
   - Card fitur
   - Footer
   - Error message
3. Gunakan style Streamlit yang rapi.

## Tahap 7 — Main App
1. Buat `app.py`.
2. Tambahkan sidebar navigation.
3. Hubungkan semua halaman:
   - Home
   - AI Tutor Chat
   - Grammar Correction
   - Vocabulary Helper
   - Conversation Practice
   - Basic English Quiz
   - About

## Tahap 8 — Quiz Data
1. Buat `data/sample_quiz.json`.
2. Minimal 5 soal basic English.
3. Format:
```json
[
  {
    "question": "She ___ a student.",
    "options": ["am", "is", "are", "be"],
    "answer": "is",
    "explanation": "She menggunakan to be 'is'."
  }
]
```

## Tahap 9 — Dokumentasi
1. Buat `docs/SETUP.md`.
2. Buat `docs/TESTING.md`.
3. Jelaskan cara install, setup API key, dan menjalankan aplikasi.

## Tahap 10 — Testing
1. Test app berjalan.
2. Test setiap menu sidebar.
3. Test grammar correction.
4. Test vocabulary.
5. Test conversation.
6. Test quiz.
7. Test kondisi API key kosong.
