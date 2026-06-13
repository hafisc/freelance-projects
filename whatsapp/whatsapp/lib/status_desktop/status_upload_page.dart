import 'dart:typed_data';
import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'dart:convert';
import 'package:http/http.dart' as http;

class StatusUploadPage extends StatefulWidget {
  final Uint8List imageBytes;
  final String fileName;

  const StatusUploadPage({
    super.key,
    required this.imageBytes,
    required this.fileName,
  });

  @override
  State<StatusUploadPage> createState() => _StatusUploadPageState();
}

class _StatusUploadPageState extends State<StatusUploadPage> {
  final TextEditingController captionController =
      TextEditingController();

  bool isLoading = false;
 Future<void> uploadStatus() async {

  setState(() {
    isLoading = true;
  });

  try {

    final prefs =
        await SharedPreferences.getInstance();

    final int idUser =
        prefs.getInt("id_user") ?? 0;

    if (idUser == 0) {

      ScaffoldMessenger.of(context)
          .showSnackBar(
        const SnackBar(
          content: Text(
            "ID User tidak ditemukan",
          ),
        ),
      );

      return;
    }

    final response =
        await http.post(
      Uri.parse(
        "http://localhost/project-231006/API/create_status.php",
      ),
      headers: {
        "Content-Type":
            "application/json",
      },
      body: jsonEncode({
        "id_user": idUser,
           "media": widget.fileName,
        "caption":
            captionController.text,
      }),
    );

    final result =
        jsonDecode(response.body);

    debugPrint(
      response.body,
    );

    if (result["success"] ==
        true) {

      if (!mounted) return;

      ScaffoldMessenger.of(context)
          .showSnackBar(
        const SnackBar(
          content: Text(
            "Status berhasil dibagikan",
          ),
        ),
      );

      Navigator.pop(
        context,
        true,
      );

    } else {

      ScaffoldMessenger.of(context)
          .showSnackBar(
        SnackBar(
          content: Text(
            result["message"],
          ),
        ),
      );
    }

  } catch (e) {

    debugPrint(
      "UPLOAD ERROR : $e",
    );
  }

  if (mounted) {

    setState(() {
      isLoading = false;
    });
  }
}
  @override
  
  Widget build(BuildContext context) {
    return Scaffold(
        backgroundColor: Colors.white,

      body: Column(
        children: [

          // =========================
          // TOP BAR
          // =========================

          Container(
            height: 64,
            padding: const EdgeInsets.symmetric(
              horizontal: 24,
            ),
            child: Row(
              children: [

                IconButton(
                  icon: const Icon(
                    Icons.close,
                    color: Color(0xff54656F),
                  ),
                  onPressed: () {
                    Navigator.pop(context);
                  },
                ),

                const Spacer(),

                const Icon(Icons.crop_rotate,
                    color: Color(0xff54656F)),
                const SizedBox(width: 24),

                const Icon(Icons.auto_fix_high,
                    color: Color(0xff54656F)),
                const SizedBox(width: 24),

                const Icon(Icons.edit,
                    color: Color(0xff54656F)),
                const SizedBox(width: 24),

                const Text(
                  "Aa",
                  style: TextStyle(
                    color: Color(0xff54656F),
                    fontWeight: FontWeight.w500,
                  ),
                ),

                const SizedBox(width: 24),

                const Icon(Icons.crop_square,
                    color: Color(0xff54656F)),

                const SizedBox(width: 24),

                const Icon(Icons.blur_on,
                    color: Color(0xff54656F)),

                const SizedBox(width: 24),

                const Icon(Icons.emoji_emotions_outlined,
                    color: Color(0xff54656F)),

                const SizedBox(width: 24),

                const Icon(Icons.sticky_note_2_outlined,
                    color: Color(0xff54656F)),

                const SizedBox(width: 24),

                const Icon(Icons.hd_outlined,
                    color: Color(0xff54656F)),

                const Spacer(),

                IconButton(
                  icon: const Icon(
                    Icons.download,
                    color: Color(0xff54656F),
                  ),
                  onPressed: () {},
                ),
              ],
            ),
          ),

          // =========================
          // CONTENT
          // =========================

          Expanded(
            child: SingleChildScrollView(
              child: Column(
                children: [

                  const SizedBox(height: 10),

                  Container(
                    constraints: const BoxConstraints(
                      maxHeight: 500,
                      maxWidth: 420,
                    ),
                    decoration: BoxDecoration(
                      color: Colors.white,
                      boxShadow: [
                        BoxShadow(
                          blurRadius: 10,
                          color: Colors.black.withOpacity(.08),
                        ),
                      ],
                    ),
                    child: Image.memory(
                      widget.imageBytes,
                      fit: BoxFit.contain,
                    ),
                  ),

                  const SizedBox(height: 40),

                  Container(
                    width: 540,
                    height: 40,
                    decoration: BoxDecoration(
                      color: const Color.fromARGB(255, 214, 212, 212),
                      borderRadius:
                          BorderRadius.circular(8),
                    ),
                    padding: const EdgeInsets.symmetric(
                      horizontal: 12,
                    ),
                    child: Row(
                      children: [

                        Expanded(
                          child: TextField(
                            controller: captionController,
                            decoration:
                                const InputDecoration(
                              hintText: "Add a caption",
                              border: InputBorder.none,
                            ),
                          ),
                        ),

                        const Icon(
                          Icons.emoji_emotions_outlined,
                          color: Color(0xff54656F),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
            ),
          ),

          // =========================
          // BOTTOM BAR
          // =========================

         Container(
  height: 76,
  padding: const EdgeInsets.symmetric(horizontal: 16),
  decoration: const BoxDecoration(
    border: Border(
      top: BorderSide(
        color: Color(0xffD1D7DB),
      ),
    ),
  ),

  child: Row(
    children: [

      // STATUS CONTACTS
      Container(
        padding: const EdgeInsets.symmetric(
          horizontal: 16,
          vertical: 8,
        ),
        decoration: BoxDecoration(
          borderRadius: BorderRadius.circular(20),
          border: Border.all(
            color: const Color(0xff25D366),
          ),
        ),
        child: Row(
          children: [

            Image.asset(
              'assets/icons/status_kontak.JPG',
              width: 18,
              height: 18,
            ),

            const SizedBox(width: 8),

            const Text(
              "Status (Contacts)",
              style: TextStyle(
                color: Color(0xff008069),
                fontSize: 13,
              ),
            ),
          ],
        ),
      ),

      const Spacer(),

      // THUMBNAIL
      Row(
        children: [

          Container(
            width: 42,
            height: 42,
            decoration: BoxDecoration(
              borderRadius: BorderRadius.circular(4),
              border: Border.all(
                color: const Color(0xff25D366),
                width: 2,
              ),
            ),
            child: ClipRRect(
              borderRadius: BorderRadius.circular(3),
              child: Image.memory(
                widget.imageBytes,
                fit: BoxFit.cover,
              ),
            ),
          ),

          const SizedBox(width: 12),

          Container(
            width: 42,
            height: 42,
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(4),
              border: Border.all(
                color: const Color(0xffD1D7DB),
              ),
            ),
            child: const Icon(Icons.add),
          ),
        ],
      ),

      const Spacer(),

      // SEND BUTTON
      GestureDetector(
 onTap: isLoading
    ? null
    : uploadStatus,
  child: Container(
    width: 52,
    height: 52,
    decoration: const BoxDecoration(
      color: Color(0xff111B21),
      shape: BoxShape.circle,
    ),
   child: isLoading
    ? const SizedBox(
        width: 22,
        height: 22,
        child: CircularProgressIndicator(
          color: Colors.white,
          strokeWidth: 2,
        ),
      )
    : const Icon(
        Icons.send_rounded,
        color: Colors.white,
      ),
  ),
),
    ],
  ),
),

        ],
      ),
    );
  }
}