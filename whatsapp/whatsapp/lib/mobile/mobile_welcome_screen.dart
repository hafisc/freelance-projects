import 'package:flutter/material.dart';
import 'mobile_use_number_screen.dart'; 

class WhatsAppBusinessOnboarding extends StatelessWidget {
  const WhatsAppBusinessOnboarding({super.key});

  @override
  Widget build(BuildContext context) {
    return LayoutBuilder(
      builder: (context, constraints) {
        final isMobile = constraints.maxWidth < 768;

        return Scaffold(
          backgroundColor: const Color(0xFF0B141A),
          body: SafeArea(
            child: isMobile 
              ? _buildMobileContent(context) 
              : _buildDesktopContent(context),
          ),
        );
      },
    );
  }

  // === LAYOUT MOBILE (KODE ASLI) ===
  Widget _buildMobileContent(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 24.0),
      child: Column(
        children: [
          // Spacer atas untuk mendorong logo agar berada di tengah area kosong atas (jika desired) 
          // atau bisa dihapus jika ingin logo di paling atas.
          // Berdasarkan request "Semua konten di tengah", kami menggunakan Spacer elastis.
          const Spacer(flex: 2),

          // 1. GAMBAR LOGO
          // Di tengah horizontally karena column defaultnya center
          Center(
            child: Image.asset(
              'assets/icons/logo_register_mobile.png', // Pastikan file ada di folder assets
              width: 180, // Ukuran yang requested (170-190)
              fit: BoxFit.contain,
              errorBuilder: (context, error, stackTrace) {
                // Widget placeholder jika gambar tidak ditemukan (opsional)
                return Container(
                  width: 180,
                  height: 180,
                  color: Colors.grey[800],
                  child: const Icon(Icons.business, size: 80, color: Colors.white54),
                );
              },
            ),
          ),

          const SizedBox(height: 36), // Jarak preset antara logo dan judul

          // 2. JUDUL
          const Text(
            'WhatsApp Business',
            textAlign: TextAlign.center,
            style: TextStyle(
              color: Colors.white,
              fontSize: 28, // Sedikit lebih besar dari 26-30 untuk aksen
              fontWeight: FontWeight.w600, // SemiBold
              letterSpacing: 0.5,
            ),
          ),

          const SizedBox(height: 16), // Jarak judul ke subjudul

          // 3. SUBTITLE
          const Text(
            'Cara yang simpel, aman, dan andal bagi bisnis Anda untuk terhubung dengan pelanggan',
            textAlign: TextAlign.center,
            style: TextStyle(
              color: Color(0xFFABB4BD), // Warna abu terang (Light Gray)
              fontSize: 16,
              height: 1.4, // Line height mirip screenshot
              fontWeight: FontWeight.w400,
            ),
          ),

          const SizedBox(height: 28), // Jarak subtitle ke info text

          // 4. DESKRIPSI KECIL & LINK (RichText)
          RichText(
            textAlign: TextAlign.center,
            text: TextSpan(
              style: const TextStyle(
                fontSize: 14, // Font size kecil
                height: 1.5,
              ),
              children: [
                const TextSpan(
                  text: 'Untuk membantu meningkatkan pengalaman Anda dan pelanggan, perusahaan induk WhatsApp, Meta, menerima informasi seperti profil bisnis dan katalog Anda.\n\n',
                  style: TextStyle(
                    color: Color(0xFFABB4BD), // Abu terang
                    fontWeight: FontWeight.w400,
                  ),
                ),
                TextSpan(
                  text: 'Pelajari selengkapnya',
                  style: const TextStyle(
                    color: Color(0xFF53BDEB), // Biru WhatsApp
                    fontWeight: FontWeight.w600,
                  ),
                  // Jika ingin ada underline saat di-tap, bisa wrap dengan GestureDetector
                ),
              ],
            ),
          ),

          const SizedBox(height: 28), // Jarak ke Privacy Policy

          // 5. PRIVACY POLICY (RichText)
          RichText(
            textAlign: TextAlign.center,
            text: TextSpan(
              style: const TextStyle(
                fontSize: 13, // Sedikit lebih kecil
                color: Color(0xFFABB4BD),
                height: 1.6,
              ),
              children: [
                const TextSpan(text: 'Silakan baca '),
                const TextSpan(
                  text: 'Kebijakan Privasi Aplikasi WhatsApp Business',
                  style: TextStyle(
                    color: Color(0xFF53BDEB), // Link biru
                    fontWeight: FontWeight.w500,
                  ),
                ),
                const TextSpan(text: ' kami.\n'),
                const TextSpan(text: 'Dengan melanjutkan, Anda menyetujui '),
                const TextSpan(
                  text: 'Ketentuan Layanan WhatsApp Business.',
                  style: TextStyle(
                    color: Color(0xFF53BDEB), // Link biru
                    fontWeight: FontWeight.w500,
                  ),
                ),
              ],
            ),
          ),

          // Spacer untuk mendorong button ke bawah dan menyeimbangkan tata letak
          const Spacer(flex: 2),

          // 6. BUTTON
          SizedBox(
            width: double.infinity, // Mengambil lebar penuh sesuai margin
            height: 60, // Tinggi button 58-62
            child: ElevatedButton(
              onPressed: () {
                Navigator.pushReplacement(
                  context,
                  MaterialPageRoute(
                    builder: (context) => const WhatsAppNumberScreen(),
                  ),
                );
              },
              style: ElevatedButton.styleFrom(
                backgroundColor: Colors.white, // Background putih
                foregroundColor: Colors.black, // Text hitam
                elevation: 0, // Tanpa shadow
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(30), // Radius sangat bulat
                ),
                padding: const EdgeInsets.symmetric(vertical: 18),
              ),
              child: const Text(
                'Setuju dan lanjutkan',
                style: TextStyle(
                  fontSize: 18, // Font size button
                  fontWeight: FontWeight.w600, // SemiBold
                  letterSpacing: 0.5,
                ),
              ),
            ),
          ),
          
          // Bottom spacer untuk keamanan di HP dengan aspect ratio kecil
          const SizedBox(height: 20),
        ],
      ),
    );
  }

  // === LAYOUT DESKTOP (TAMBAHAN) ===
  Widget _buildDesktopContent(BuildContext context) {
    return Center(
      child: Container(
        width: 420,
        padding: const EdgeInsets.all(32),
        decoration: BoxDecoration(
          color: const Color(0xFF1E2A32),
          borderRadius: BorderRadius.circular(12),
        ),
        child: _buildMobileContent(context),
      ),
    );
  }
}