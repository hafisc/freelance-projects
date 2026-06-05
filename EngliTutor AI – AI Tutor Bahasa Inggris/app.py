import streamlit as st
from src import config, ui, features

# set_page_config harus menjadi instruksi Streamlit pertama yang dijalankan pada script
st.set_page_config(
    page_title="EngliTutor AI — Belajar Bahasa Inggris Mudah",
    page_icon="🚀",
    layout="centered"
)

# Menyuntikkan CSS kustom ke seluruh halaman
ui.inject_custom_css()

# Menampilkan Header Gradien Premium
ui.show_header()

# Navigasi Sidebar
st.sidebar.title("🧭 Navigasi Menu")
menu = st.sidebar.radio(
    "Pilih Fitur:",
    [
        "🏠 Home",
        "💬 AI Tutor Chat",
        "📝 Grammar Correction",
        "📖 Vocabulary Helper",
        "🗣️ Conversation Practice",
        "🏆 Basic English Quiz",
        "ℹ️ About"
    ]
)

# Menampilkan informasi provider AI aktif di sidebar
st.sidebar.markdown("---")
st.sidebar.markdown(f"**AI Provider:** `{config.AI_PROVIDER.upper()}`")

# ----------------- HALAMAN: HOME -----------------
if menu == "🏠 Home":
    st.subheader("Selamat Datang di EngliTutor AI! 👋")
    st.write(
        "EngliTutor AI adalah asisten belajar Bahasa Inggris pribadi Anda yang ditenagai oleh kecerdasan buatan. "
        "Pilihlah salah satu menu di sidebar untuk mulai belajar. Berikut adalah menu pembelajaran yang tersedia:"
    )
    
    # Menampilkan grid fitur utama
    col1, col2 = st.columns(2)
    with col1:
        ui.show_card(
            "AI Tutor Chat",
            "Konsultasikan pertanyaan Anda seputar tata bahasa Inggris, tenses, atau kosakata langsung dengan AI Tutor.",
            "💬"
        )
        ui.show_card(
            "Grammar Correction",
            "Masukkan kalimat bahasa Inggris Anda untuk diperiksa dan dipelajari kesalahannya secara detail.",
            "📝"
        )
    with col2:
        ui.show_card(
            "Vocabulary Helper",
            "Cari arti kata, frasa, atau idiom beserta contoh kalimat, sinonim, dan tips penggunaannya.",
            "📖"
        )
        ui.show_card(
            "Conversation Practice",
            "Latih kemampuan berbicara dan menulis Anda dengan simulasi percakapan interaktif bertopik khusus.",
            "🗣️"
        )
        
    ui.show_card(
        "Basic English Quiz",
        "Uji pemahaman dasar bahasa Inggris Anda dengan kuis interaktif pilihan ganda secara luring (offline).",
        "🏆"
    )

# ----------------- HALAMAN: AI TUTOR CHAT -----------------
elif menu == "💬 AI Tutor Chat":
    st.subheader("💬 AI Tutor Chat")
    
    # Validasi API Key
    is_valid, err_msg = config.validate_config()
    if not is_valid:
        ui.render_api_key_warning(config.AI_PROVIDER)
    else:
        ui.show_info_box(
            "Tanyakan apa saja seputar bahasa Inggris. AI Tutor akan menjelaskan aturan tata bahasa "
            "atau kosakata dengan penjelasan Bahasa Indonesia yang ramah."
        )
        
        # Inisialisasi Riwayat Chat jika belum ada
        if 'tutor_chat_history' not in st.session_state:
            st.session_state.tutor_chat_history = [
                {
                    "role": "assistant",
                    "content": (
                        "Halo! Saya adalah **EngliTutor AI**, tutor Bahasa Inggris pribadi Anda. "
                        "Ada materi atau pertanyaan bahasa Inggris yang ingin Anda diskusikan hari ini?\n\n"
                        "Anda bisa menanyakan hal-hal seperti:\n"
                        "* *\"Apa perbedaan kata 'since' dan 'for'?\"*\n"
                        "* *\"Tolong jelaskan simple present tense beserta rumusnya\"*\n"
                        "* *\"Buatkan contoh kalimat menggunakan kata 'should'\"*"
                    )
                }
            ]
            
        # Tombol hapus riwayat chat
        if st.button("Hapus Riwayat Chat"):
            st.session_state.tutor_chat_history = [
                {
                    "role": "assistant",
                    "content": "Riwayat chat telah dihapus. Ada lagi yang ingin Anda tanyakan?"
                }
            ]
            st.rerun()
            
        # Menampilkan riwayat chat
        for msg in st.session_state.tutor_chat_history:
            with st.chat_message(msg["role"]):
                st.markdown(msg["content"])
                
        # Input chat baru dari pengguna
        user_input = st.chat_input("Tulis pertanyaan Anda di sini...")
        if user_input:
            # Tampilkan pesan pengguna di layar
            with st.chat_message("user"):
                st.markdown(user_input)
            
            # Tambahkan ke session state
            st.session_state.tutor_chat_history.append({"role": "user", "content": user_input})
            
            # Panggil AI untuk menulis respons
            with st.chat_message("assistant"):
                with st.spinner("Tutor sedang memikirkan penjelasan..."):
                    response = features.ask_tutor(user_input, st.session_state.tutor_chat_history)
                    st.markdown(response)
                    
            st.session_state.tutor_chat_history.append({"role": "assistant", "content": response})
            st.rerun()

# ----------------- HALAMAN: GRAMMAR CORRECTION -----------------
elif menu == "📝 Grammar Correction":
    st.subheader("📝 Grammar Correction")
    
    # Validasi API Key
    is_valid, err_msg = config.validate_config()
    if not is_valid:
        ui.render_api_key_warning(config.AI_PROVIDER)
    else:
        ui.show_info_box(
            "Masukkan kalimat Bahasa Inggris Anda yang ingin diperiksa tata bahasanya. "
            "AI akan mengoreksi ejaan, grammar, serta memberikan penjelasan detail."
        )
        
        # Text area input kalimat
        sentence = st.text_area(
            "Masukkan kalimat Anda di bawah ini:",
            placeholder="Contoh: She don't likes apple because she think it is sour.",
            height=120
        )
        
        # Tombol submit
        if st.button("Check Grammar"):
            if not sentence.strip():
                st.warning("⚠️ Harap masukkan kalimat terlebih dahulu sebelum memeriksa.")
            else:
                with st.spinner("AI sedang memeriksa tata bahasa kalimat Anda..."):
                    result = features.correct_grammar(sentence)
                    st.markdown("---")
                    st.markdown(result)

# ----------------- HALAMAN: VOCABULARY HELPER -----------------
elif menu == "📖 Vocabulary Helper":
    st.subheader("📖 Vocabulary Helper")
    
    # Validasi API Key
    is_valid, err_msg = config.validate_config()
    if not is_valid:
        ui.render_api_key_warning(config.AI_PROVIDER)
    else:
        ui.show_info_box(
            "Masukkan sebuah kata, kata kerja frasa (phrasal verb), atau idiom bahasa Inggris. "
            "AI akan menerangkan kelas kata, arti, memberikan contoh kalimat beserta tips penggunaan."
        )
        
        # Input kata
        word = st.text_input(
            "Masukkan kata atau frasa bahasa Inggris:",
            placeholder="Contoh: Accomplish, Break a leg, Get along"
        )
        
        # Tombol submit
        if st.button("Explain Vocabulary"):
            if not word.strip():
                st.warning("⚠️ Harap masukkan kata atau frasa terlebih dahulu.")
            else:
                with st.spinner("AI sedang menyusun informasi kosakata..."):
                    result = features.explain_vocabulary(word)
                    st.markdown("---")
                    st.markdown(result)

# ----------------- HALAMAN: CONVERSATION PRACTICE -----------------
elif menu == "🗣️ Conversation Practice":
    st.subheader("🗣️ Conversation Practice")
    
    # Validasi API Key
    is_valid, err_msg = config.validate_config()
    if not is_valid:
        ui.render_api_key_warning(config.AI_PROVIDER)
    else:
        ui.show_info_box(
            "Pilih topik percakapan yang Anda minati. AI akan berperan sebagai partner Anda. "
            "Cobalah untuk membalas dalam Bahasa Inggris. AI juga akan memberikan koreksi ringan "
            "atas tata bahasa Anda di bagian akhir tanggapan secara ramah."
        )
        
        # Pilihan Topik Percakapan
        topics = [
            "Job Interview",
            "Daily Activities",
            "Asking Directions",
            "Hobby & Travel",
            "Ordering Food"
        ]
        
        selected_topic = st.selectbox("Pilih Topik Latihan:", topics)
        
        # Inisialisasi session state conversation
        if 'conversation_started' not in st.session_state:
            st.session_state.conversation_started = False
            st.session_state.conversation_topic = ""
            st.session_state.conversation_chat_history = []
            
        col1, col2 = st.columns([1, 3])
        with col1:
            start_btn = st.button("Mulai Percakapan Baru")
            
        # Mengatur pemicu reset atau perubahan topik
        topic_changed = st.session_state.conversation_topic != selected_topic
        
        if start_btn or not st.session_state.conversation_started or topic_changed:
            with st.spinner("Menyiapkan partner percakapan AI..."):
                st.session_state.conversation_topic = selected_topic
                starter = features.get_conversation_starter(selected_topic)
                st.session_state.conversation_chat_history = [
                    {"role": "assistant", "content": starter}
                ]
                st.session_state.conversation_started = True
                st.rerun()
                
        # Menampilkan riwayat chat percakapan
        for msg in st.session_state.conversation_chat_history:
            with st.chat_message(msg["role"]):
                st.markdown(msg["content"])
                
        # Input chat dari user
        user_reply = st.chat_input("Tulis balasan Anda dalam Bahasa Inggris di sini...")
        if user_reply:
            # Tampilkan pesan user segera
            with st.chat_message("user"):
                st.markdown(user_reply)
                
            st.session_state.conversation_chat_history.append({"role": "user", "content": user_reply})
            
            # Panggil AI untuk merespons
            with st.chat_message("assistant"):
                with st.spinner("Tutor sedang mengetik balasan..."):
                    response = features.practice_conversation(
                        st.session_state.conversation_chat_history,
                        selected_topic
                    )
                    st.markdown(response)
                    
            st.session_state.conversation_chat_history.append({"role": "assistant", "content": response})
            st.rerun()

# ----------------- HALAMAN: BASIC ENGLISH QUIZ -----------------
elif menu == "🏆 Basic English Quiz":
    st.subheader("🏆 Basic English Quiz")
    
    quiz_data = features.load_quiz_data()
    
    # Inisialisasi status kuis di session state
    if 'quiz_started' not in st.session_state:
        st.session_state.quiz_started = False
        st.session_state.current_question_idx = 0
        st.session_state.user_answers = {}
        st.session_state.quiz_submitted = False
        
    if not st.session_state.quiz_started:
        st.write(
            "Uji pemahaman dasar tata bahasa Inggris Anda di sini secara offline. "
            "Kuis terdiri dari 5 soal pilihan ganda. Di akhir kuis, Anda akan mendapatkan skor dan pembahasan lengkap."
        )
        if st.button("Mulai Kuis Sekarang"):
            st.session_state.quiz_started = True
            st.session_state.current_question_idx = 0
            st.session_state.user_answers = {}
            st.session_state.quiz_submitted = False
            st.rerun()
    else:
        # Jika kuis sedang berlangsung dan belum di-submit
        if not st.session_state.quiz_submitted:
            idx = st.session_state.current_question_idx
            q = quiz_data[idx]
            
            st.markdown(f"### Pertanyaan {idx + 1} dari {len(quiz_data)}")
            # Progress bar kuis
            st.progress((idx) / len(quiz_data))
            
            # Tampilkan Soal
            st.info(q["question"])
            
            # Pilihan jawaban
            default_selection = 0
            if idx in st.session_state.user_answers:
                default_selection = q["options"].index(st.session_state.user_answers[idx])
                
            selected_option = st.radio(
                "Pilih jawaban yang benar:",
                q["options"],
                index=default_selection,
                key=f"quiz_radio_{idx}"
            )
            
            # Simpan jawaban sementara ke session state
            st.session_state.user_answers[idx] = selected_option
            
            # Navigasi tombol
            col1, col2, col3 = st.columns([1, 1, 2])
            with col1:
                if idx > 0:
                    if st.button("Sebelumnya"):
                        st.session_state.current_question_idx -= 1
                        st.rerun()
            with col2:
                if idx < len(quiz_data) - 1:
                    if st.button("Selanjutnya"):
                        st.session_state.current_question_idx += 1
                        st.rerun()
            with col3:
                # Tampilkan tombol submit jika di soal terakhir
                if idx == len(quiz_data) - 1:
                    if st.button("Submit Seluruh Jawaban"):
                        st.session_state.quiz_submitted = True
                        st.rerun()
        else:
            # Menghitung skor akhir kuis
            correct_count, percentage = features.calculate_score(st.session_state.user_answers, quiz_data)
            
            st.success("🎉 **Kuis Selesai!** Berikut adalah hasil pengerjaan Anda:")
            
            # Tampilkan Nilai
            st.markdown(
                f"""
                <div style="background-color: #F1F5F9; border: 1px solid #CBD5E1; border-radius: 8px; padding: 20px; text-align: center; margin-bottom: 24px;">
                    <span style="font-size: 1.2rem; color: #475569; font-weight: 500;">Skor Anda</span><br/>
                    <span style="font-size: 3rem; color: #2563EB; font-weight: 700;">{percentage}/100</span><br/>
                    <span style="font-size: 1rem; color: #475569;">({correct_count} dari {len(quiz_data)} soal dijawab benar)</span>
                </div>
                """,
                unsafe_allow_html=True
            )
            
            # Pesan motivasi berdasarkan skor
            if percentage == 100:
                st.balloons()
                st.success("Sempurna! Nilai Anda 100. Anda menguasai tata bahasa dasar ini dengan sangat baik! 🏆")
            elif percentage >= 60:
                st.info("Bagus sekali! Anda telah memahami sebagian besar konsep dasar. Teruskan belajar! 📚")
            else:
                st.warning("Perlu latihan lagi. Bacalah penjelasan di bawah ini untuk belajar lebih dalam. Tetap semangat! 💪")
                
            # Pembahasan soal
            st.markdown("### 🔍 Pembahasan Soal Detail:")
            for i, q in enumerate(quiz_data):
                user_ans = st.session_state.user_answers.get(i)
                is_correct = user_ans == q["answer"]
                
                with st.container():
                    st.markdown(f"**Soal {i+1}:** {q['question']}")
                    if is_correct:
                        st.markdown(f"✅ Jawaban Anda: **{user_ans}** *(Benar)*")
                    else:
                        st.markdown(f"❌ Jawaban Anda: **{user_ans}** *(Salah)*")
                        st.markdown(f"🔑 Jawaban Benar: **{q['answer']}**")
                    
                    st.markdown(f"💡 **Penjelasan:** {q['explanation']}")
                    st.markdown("---")
                    
            # Tombol ulangi kuis
            if st.button("Ulangi Kuis Dari Awal"):
                st.session_state.quiz_started = False
                st.session_state.quiz_submitted = False
                st.rerun()

# ----------------- HALAMAN: ABOUT -----------------
elif menu == "ℹ️ About":
    st.subheader("ℹ️ About EngliTutor AI")
    
    st.markdown(
        """
        **EngliTutor AI** adalah proyek aplikasi web sederhana berbasis chatbot cerdas untuk 
        membantu siapa saja belajar Bahasa Inggris secara mandiri dengan bimbingan kecerdasan buatan.
        """
    )
    
    st.markdown("### 🛠️ Tech Stack yang Digunakan")
    st.markdown(
        """
        - **Python 3.10+**: Bahasa pemrograman utama yang efisien.
        - **Streamlit**: Framework modern untuk membangun UI web interaktif dalam hitungan menit.
        - **Gemini API (Default)**: Layanan LLM gratis dari Google AI Studio untuk pemrosesan teks.
        - **OpenAI API (Alternatif)**: Engine model bahasa cadangan (seperti GPT-4o-mini).
        - **python-dotenv**: Mengamankan pembacaan kredensial API key dari file `.env`.
        """
    )
    
    st.markdown("### 🧠 Konsep & Skill yang Dipelajari")
    st.markdown(
        """
        1. **Prompt Engineering**: Membuat system instruction terstruktur untuk memandu kepribadian AI Tutor agar sabar, ramah, dan edukatif.
        2. **State Management**: Mengelola alur navigasi multi-halaman, sesi obrolan (chat history), dan pengerjaan kuis menggunakan `st.session_state` di Streamlit.
        3. **Graceful Error Handling**: Menangani error secara halus jika API key kosong dengan menonaktifkan fitur AI secara aman dan memandu pengguna cara setup file `.env` tanpa crash.
        4. **Modular Architecture**: Memisahkan antarmuka (UI), konfigurasi dasar, penulisan prompt, dan logika fungsional untuk memudahkan pengembangan berkelanjutan.
        """
    )

# Menampilkan Footer Reusable
ui.show_footer()
