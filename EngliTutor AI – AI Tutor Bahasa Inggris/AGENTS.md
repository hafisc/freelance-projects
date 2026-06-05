# AGENTS.md — Panduan Coding Agent

## Nama Project
**EngliTutor AI**  
Website chatbot sederhana untuk membantu belajar Bahasa Inggris menggunakan **Python, Streamlit, dan Gemini API/OpenAI API**.

## Tujuan Project
Membangun aplikasi web sederhana berbasis AI Tutor Bahasa Inggris yang dapat membantu user belajar grammar, vocabulary, conversation practice, dan quiz basic English.

Project ini harus dibuat rapi, mudah dijalankan, dan cocok untuk kebutuhan tugas/proyek sederhana.

## Stack Utama
- Python 3.10+
- Streamlit
- Gemini API atau OpenAI API
- python-dotenv
- Struktur kode modular

## Scope Utama
1. Membuat website chatbot sederhana menggunakan Streamlit.
2. Membuat halaman utama dengan branding **EngliTutor AI**.
3. Membuat fitur grammar correction.
4. Membuat fitur vocabulary helper.
5. Membuat fitur conversation practice.
6. Membuat fitur quiz basic English.
7. Membuat fitur general AI tutor chat.
8. Menghubungkan aplikasi dengan Gemini API/OpenAI API.
9. Menyiapkan prompt AI agar bertindak sebagai tutor Bahasa Inggris.
10. Membuat UI rapi, sederhana, dan mudah dipahami.
11. Menambahkan komentar Bahasa Indonesia pada fungsi-fungsi penting.
12. Menyiapkan dokumentasi cara menjalankan aplikasi.
13. Menyiapkan file `.env.example`.
14. Menyiapkan file `requirements.txt`.

## Aturan Coding
- Gunakan struktur folder yang rapi.
- Jangan menaruh API key langsung di dalam kode.
- API key wajib dibaca dari file `.env`.
- Semua fungsi penting diberi komentar Bahasa Indonesia.
- Pisahkan logic AI, prompt, dan tampilan Streamlit.
- Hindari kode terlalu panjang di satu file.
- Pastikan aplikasi tetap berjalan walaupun API key belum diisi, dengan pesan error yang jelas.
- Gunakan nama variabel yang mudah dipahami.
- UI harus clean, bukan asal jadi.

## Struktur Folder Wajib

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

## Penjelasan Folder
- `app.py`: Entry point utama Streamlit.
- `src/config.py`: Membaca konfigurasi dari `.env`.
- `src/ai_client.py`: Koneksi ke Gemini/OpenAI API.
- `src/prompts.py`: Kumpulan prompt untuk tutor AI.
- `src/features.py`: Logic fitur grammar, vocabulary, conversation, quiz.
- `src/ui.py`: Komponen UI Streamlit.
- `data/sample_quiz.json`: Data quiz basic English.
- `docs/SETUP.md`: Cara install dan menjalankan project.
- `docs/TESTING.md`: Checklist testing aplikasi.

## Fitur Detail

### 1. Dashboard / Home
Buat halaman awal yang berisi:
- Nama aplikasi: EngliTutor AI
- Deskripsi singkat
- Penjelasan fitur
- Sidebar navigasi fitur

### 2. AI Tutor Chat
User bisa bertanya tentang Bahasa Inggris.
Contoh:
- “Apa bedanya do dan does?”
- “Tolong jelaskan simple present tense”
- “Buatkan contoh kalimat menggunakan should”

### 3. Grammar Correction
Input:
- Kalimat Bahasa Inggris dari user.

Output:
- Kalimat yang sudah diperbaiki.
- Penjelasan kesalahan.
- Versi natural/native jika memungkinkan.

### 4. Vocabulary Helper
Input:
- Satu kata atau frasa Bahasa Inggris.

Output:
- Arti dalam Bahasa Indonesia.
- Contoh kalimat.
- Sinonim sederhana.
- Cara penggunaan.

### 5. Conversation Practice
Input:
- Topik percakapan, misalnya school, hobby, travel, daily activity.

Output:
- AI mengajak user latihan dialog.
- AI memberikan pertanyaan lanjutan.
- AI bisa memperbaiki jawaban user secara ringan.

### 6. Basic English Quiz
Fitur quiz sederhana:
- Multiple choice.
- Minimal 5 soal.
- Tampilkan skor akhir.
- Tampilkan jawaban benar.
- Bisa menggunakan data dari `data/sample_quiz.json`.

## Standar UI
- Gunakan sidebar untuk navigasi.
- Gunakan tabs/section agar rapi.
- Gunakan card sederhana dengan `st.container()`.
- Gunakan emoji secukupnya.
- Jangan terlalu ramai.
- Warna utama: biru, putih, abu muda.
- Tone aplikasi: edukatif, friendly, modern.

## Instruksi Penting Untuk Coding Agent
Sebelum mulai coding, buat plan terlebih dahulu berisi:
1. File apa saja yang akan dibuat.
2. Urutan pengerjaan.
3. Struktur fitur.
4. Cara menjalankan.
5. Checklist testing.

Setelah plan dibuat, baru mulai implementasi kode.

## Definition of Done
Project dianggap selesai jika:
- Aplikasi bisa dijalankan dengan `streamlit run app.py`.
- Semua fitur utama bisa dibuka dari sidebar.
- API key dibaca dari `.env`.
- Tidak ada API key hardcode.
- Grammar correction berjalan.
- Vocabulary helper berjalan.
- Conversation practice berjalan.
- Quiz basic English berjalan.
- README dan dokumentasi tersedia.
- Kode diberi komentar Bahasa Indonesia pada fungsi penting.
