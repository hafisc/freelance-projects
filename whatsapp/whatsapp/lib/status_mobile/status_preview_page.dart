import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:http/http.dart' as http;

class StatusPreviewPage extends StatefulWidget {
  final String imagePath;

  const StatusPreviewPage({super.key, required this.imagePath});

  @override
  State<StatusPreviewPage> createState() => _StatusPreviewPageState();
}

class _StatusPreviewPageState extends State<StatusPreviewPage> {
  final TextEditingController _captionController = TextEditingController();
  bool _isLoading = false;

  // Fungsi untuk mengirim data status ke backend Native PHP Laragon
  Future<void> _kirimStatusKeDatabase() async {
    setState(() {
      _isLoading = true;
    });

    final String url = "http://localhost/project-231006/API/create_status.php";

    final prefs =
    await SharedPreferences.getInstance();

  final int idUser =
    prefs.getInt("id_user") ?? 0;

    try {
      final response = await http.post(
        Uri.parse(url),
        headers: {"Content-Type": "application/json"},
        // SUDAH DISINKRONKAN: Mengubah key JSON agar pas dengan kolom database di phpMyAdmin
         body: jsonEncode({
        "id_user": idUser,
        "media": widget.imagePath,
        "caption": _captionController.text,
      }),
      );

      print("STATUS CODE : ${response.statusCode}");
print("BODY : ${response.body}");

if (response.body.isEmpty) {
  throw Exception("Response kosong dari server");
}

final dataRespon = jsonDecode(response.body);

      if (response.statusCode == 200 && dataRespon['success'] == true) {
        if (mounted) {
          _showSnackBar("Status berhasil dibagikan!");
          // Sukses menyimpan, kembalikan data path gambar ke halaman utama
          Navigator.pop(context, widget.imagePath);
        }
      } else {
        _showSnackBar("Gagal menyimpan: ${dataRespon['message']}");
      }
    } catch (e) {
      _showSnackBar("Gagal menghubungkan ke server Laragon.");
      debugPrint("Error: $e");
    } finally {
      if (mounted) {
        setState(() {
          _isLoading = false;
        });
      }
    }
  }

  void _showSnackBar(String message) {
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(content: Text(message)),
    );
  }

  @override
  void dispose() {
    _captionController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.black,
      body: SafeArea(
        child: Stack(
          children: [
            // ================= GBR PREVIEW =================
            Positioned.fill(
              child: Image.asset(
                widget.imagePath,
                fit: BoxFit.cover,
              ),
            ),

            // ================= TOMBOL ATAS =================
            Positioned(
              top: 10,
              left: 10,
              right: 10,
              child: Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  IconButton(
                    onPressed: () => Navigator.pop(context),
                    icon: const Icon(Icons.close, color: Colors.white, size: 28),
                  ),
                  Row(
                    children: [
                      _buildHeaderIcon(Icons.music_note),
                      const SizedBox(width: 15),
                      _buildHeaderIcon(Icons.add_photo_alternate_outlined),
                      const SizedBox(width: 15),
                      _buildHeaderIcon(Icons.sticky_note_2_outlined),
                      const SizedBox(width: 15),
                      _buildHeaderIcon(Icons.text_fields),
                      const SizedBox(width: 15),
                      _buildHeaderIcon(Icons.edit_outlined),
                    ],
                  ),
                ],
              ),
            ),

            // ================= FILTER TEXT =================
            Positioned(
              bottom: 150,
              left: 0,
              right: 0,
              child: Column(
                children: const [
                  Icon(Icons.keyboard_arrow_up, color: Colors.white, size: 24),
                  Text(
                    "Swipe up for filters",
                    style: TextStyle(color: Colors.white, fontSize: 14),
                  ),
                ],
              ),
            ),

            // ================= CAPTION & SEND BUTTON =================
            Positioned(
              bottom: 0,
              left: 0,
              right: 0,
              child: Container(
                padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 20),
                color: Colors.black45,
                child: Column(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    // Input Caption
                    Container(
                      padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 8),
                      decoration: BoxDecoration(
                        color: const Color(0xff0B141A),
                        borderRadius: BorderRadius.circular(25),
                      ),
                      child: Row(
                        children: [
                          const Icon(Icons.add_photo_alternate, color: Colors.grey),
                          const SizedBox(width: 10),
                          Expanded(
                            child: TextField(
                              controller: _captionController,
                              style: const TextStyle(color: Colors.white),
                              decoration: const InputDecoration(
                                hintText: "Add a caption...",
                                hintStyle: TextStyle(color: Colors.grey),
                                border: InputBorder.none,
                                isDense: true,
                              ),
                            ),
                          ),
                          const Icon(Icons.alternate_email, color: Colors.grey),
                        ],
                      ),
                    ),
                    const SizedBox(height: 20),

                    // Baris Tombol Kirim
                    Row(
                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                      children: [
                        // Status (Contacts) Badge
                        Container(
                          padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 10),
                          decoration: BoxDecoration(
                            color: const Color(0xff202C33),
                            borderRadius: BorderRadius.circular(20),
                          ),
                          child: Row(
                            children: const [
                              Icon(Icons.published_with_changes, color: Colors.grey, size: 18),
                              SizedBox(width: 8),
                              Text(
                                "Status (Contacts)",
                                style: TextStyle(color: Colors.white, fontWeight: FontWeight.bold),
                              ),
                            ],
                          ),
                        ),

                        // TOMBOL PANAH PUTIH (KIRIM)
                        GestureDetector(
                          onTap: _isLoading ? null : _kirimStatusKeDatabase,
                          child: Container(
                            width: 55,
                            height: 55,
                            decoration: const BoxDecoration(
                              shape: BoxShape.circle,
                              color: Colors.white,
                            ),
                            child: Center(
                              child: _isLoading
                                  ? const SizedBox(
                                      width: 24,
                                      height: 24,
                                      child: CircularProgressIndicator(
                                        color: Colors.black,
                                        strokeWidth: 2.5,
                                      ),
                                    )
                                  : const Icon(
                                      Icons.send,
                                      color: Colors.black,
                                      size: 26,
                                    ),
                            ),
                          ),
                        ),
                      ],
                    ),
                  ],
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildHeaderIcon(IconData icon) {
    return Container(
      padding: const EdgeInsets.all(6),
      decoration: const BoxDecoration(
        shape: BoxShape.circle,
        color: Colors.black45,
      ),
      child: Icon(icon, color: Colors.white, size: 20),
    );
  }
}