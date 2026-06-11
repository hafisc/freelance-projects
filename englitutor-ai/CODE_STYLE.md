# CODE_STYLE.md — Standar Penulisan Kode

## Bahasa
- Kode menggunakan Bahasa Inggris untuk nama variabel/fungsi.
- Komentar fungsi menggunakan Bahasa Indonesia.

## Naming
Gunakan snake_case untuk Python:
```python
def correct_grammar(sentence):
    pass
```

## Komentar
Berikan komentar pada fungsi penting.

Contoh:
```python
def load_quiz_data():
    # Fungsi ini digunakan untuk membaca data quiz dari file JSON lokal.
    pass
```

## Struktur Function
- Satu fungsi fokus pada satu tugas.
- Hindari fungsi terlalu panjang.
- Logic API jangan dicampur langsung dengan UI.

## Error Handling
Gunakan try-except untuk request API:
```python
try:
    response = model.generate_content(prompt)
except Exception as error:
    return f"Terjadi error: {error}"
```

## Environment
Jangan hardcode API key:
```python
api_key = os.getenv("GEMINI_API_KEY")
```

## Streamlit
Gunakan:
- `st.sidebar`
- `st.text_area`
- `st.button`
- `st.spinner`
- `st.success`
- `st.warning`
- `st.error`
