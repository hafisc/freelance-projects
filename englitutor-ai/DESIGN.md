# DESIGN.md — Panduan Desain UI EngliTutor AI

## Identitas Project
**Nama:** EngliTutor AI  
**Tagline:** Learn English easier with your personal AI tutor.

## Konsep Desain
Aplikasi dibuat sebagai website edukasi sederhana yang friendly, modern, dan mudah digunakan.

Target pengguna:
- Pelajar
- Mahasiswa
- Pemula yang ingin belajar Bahasa Inggris
- User yang ingin latihan grammar, vocabulary, conversation, dan quiz

## Mood UI
- Clean
- Edukatif
- Friendly
- Modern
- Tidak terlalu ramai

## Warna
Gunakan warna yang aman dan profesional:

### Primary
- Biru: `#2563EB`

### Secondary
- Biru muda: `#DBEAFE`

### Background
- Putih: `#FFFFFF`
- Abu muda: `#F8FAFC`

### Text
- Hitam soft: `#0F172A`
- Abu teks: `#475569`

### Success
- Hijau: `#16A34A`

### Warning
- Kuning: `#F59E0B`

## Font
Karena Streamlit memiliki style default, gunakan font bawaan Streamlit. Jika ingin custom CSS, gunakan font family:
```css
font-family: "Inter", "Segoe UI", sans-serif;
```

## Layout Utama
Aplikasi menggunakan layout:
- Sidebar kiri untuk navigasi fitur.
- Konten utama untuk form input dan hasil AI.
- Header aplikasi pada bagian atas.
- Card sederhana untuk setiap fitur.

## Navigasi Sidebar
Menu yang wajib ada:
1. Home
2. AI Tutor Chat
3. Grammar Correction
4. Vocabulary Helper
5. Conversation Practice
6. Basic English Quiz
7. About

## Struktur Halaman

### Home
Isi:
- Judul EngliTutor AI
- Tagline
- Penjelasan singkat
- Card fitur utama

### AI Tutor Chat
Isi:
- Text area pertanyaan user
- Tombol submit
- Output jawaban AI

### Grammar Correction
Isi:
- Text area input kalimat
- Tombol Check Grammar
- Output:
  - Corrected sentence
  - Explanation
  - Natural version

### Vocabulary Helper
Isi:
- Input kata/frasa
- Tombol Explain Vocabulary
- Output:
  - Meaning
  - Example sentence
  - Synonyms
  - Usage tips

### Conversation Practice
Isi:
- Pilihan topik percakapan
- Text area jawaban user
- Output respons AI
- AI memberikan pertanyaan lanjutan

### Basic English Quiz
Isi:
- Pertanyaan pilihan ganda
- Radio button pilihan jawaban
- Tombol submit
- Skor akhir
- Review jawaban

### About
Isi:
- Deskripsi project
- Teknologi yang digunakan
- Skill yang dipelajari:
  - Prompt engineering
  - Large Language Models
  - NLP
  - Membuat materi belajar sederhana

## Catatan UX
- Berikan instruksi singkat di setiap halaman.
- Jangan membuat user bingung.
- Gunakan placeholder di input.
- Gunakan spinner saat menunggu jawaban AI.
- Tampilkan error yang jelas jika API key belum diatur.
- Hasil AI jangan terlalu panjang, kecuali user meminta detail.

## Contoh Copywriting
Judul:
```txt
EngliTutor AI
```

Subjudul:
```txt
Your simple AI tutor for learning English grammar, vocabulary, conversation, and quiz practice.
```

CTA:
```txt
Start Learning
Check Grammar
Explain Vocabulary
Practice Conversation
Submit Answer
```
