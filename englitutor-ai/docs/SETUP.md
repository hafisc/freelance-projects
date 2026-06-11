# SETUP.md — Cara Menjalankan EngliTutor AI

## 1. Masuk ke Folder Project
```bash
cd englitutor-ai
```

## 2. Buat Virtual Environment
Windows:
```bash
python -m venv venv
venv\Scripts\activate
```

Mac/Linux:
```bash
python3 -m venv venv
source venv/bin/activate
```

## 3. Install Dependency
```bash
pip install -r requirements.txt
```

## 4. Setup Environment
Copy `.env.example` menjadi `.env`.

Windows:
```bash
copy .env.example .env
```

Mac/Linux:
```bash
cp .env.example .env
```

Isi API key:
```env
AI_PROVIDER=gemini
GEMINI_API_KEY=isi_api_key_gemini
OPENAI_API_KEY=
```

## 5. Jalankan Project
```bash
streamlit run app.py
```

## 6. Buka Browser
Usually, Streamlit will open:
```txt
http://localhost:8501
```

## Troubleshooting

### API Key Belum Diisi
Jika muncul pesan API key kosong, isi file `.env` terlebih dahulu.

### Module Tidak Ditemukan
Jalankan ulang:
```bash
pip install -r requirements.txt
```

### Streamlit Tidak Jalan
Pastikan Python sudah terinstall dan virtual environment aktif.
