import 'package:flutter/material.dart';
import 'status_preview_page.dart'; // Otomatis merujuk ke folder status_mobile yang sama
import 'video_preview_page.dart';  // Otomatis merujuk ke folder status_mobile yang sama

class AddStatusPage extends StatelessWidget {
  const AddStatusPage({super.key});

  @override
  Widget build(BuildContext context) {
    final List<Map<String, String>> mediaItems = [
      // BARIS 1
      {"type": "image", "path": "assets/image_status/status1.jpeg"},
      {"type": "image", "path": "assets/image_status/status2.jpeg"},

      // BARIS 2
      {"type": "image", "path": "assets/image_status/status3.jpeg"},
      {"type": "image", "path": "assets/image_status/status4.jpeg"},

      // BARIS 3
      {"type": "image", "path": "assets/image_status/status5.jpeg"},
      {"type": "image", "path": "assets/image_status/status6.jpeg"},
      {"type": "image", "path": "assets/image_status/status7.jpeg"},

      // BARIS 4
      {"type": "image", "path": "assets/image_status/status8.jpeg"},
      {"type": "image", "path": "assets/image_status/status9.jpeg"},
      {"type": "image", "path": "assets/image_status/status10.jpeg"},

      // BARIS 5
      {"type": "image", "path": "assets/image_status/status11.jpeg"},

      // VIDEO
      {"type": "video", "path": "assets/video_status/video1.mp4"},
      {"type": "video", "path": "assets/video_status/video2.mp4"},
      {"type": "video", "path": "assets/video_status/video3.mp4"},
      {"type": "video", "path": "assets/video_status/video4.mp4"},
      {"type": "video", "path": "assets/video_status/video5.mp4"},
      {"type": "video", "path": "assets/video_status/video6.mp4"},
    ];

    return Scaffold(
      backgroundColor: const Color(0xff0B141A),
      floatingActionButton: Container(
        width: 70,
        height: 70,
        decoration: const BoxDecoration(
          shape: BoxShape.circle,
          color: Color(0xff202C33),
        ),
        child: Center(
          child: Image.asset(
            "assets/icons/logo.jpg",
            width: 28,
            height: 28,
            fit: BoxFit.contain,
          ),
        ),
      ),
      body: SafeArea(
        child: Column(
          children: [
            const SizedBox(height: 8),

            Container(
              width: 40,
              height: 4,
              decoration: BoxDecoration(
                color: Colors.white24,
                borderRadius: BorderRadius.circular(20),
              ),
            ),

            const SizedBox(height: 15),

            Row(
              children: [
                IconButton(
                  onPressed: () => Navigator.pop(context),
                  icon: const Icon(
                    Icons.close,
                    color: Colors.white,
                    size: 32,
                  ),
                ),
                const Expanded(
                  child: Center(
                    child: Text(
                      "Add status",
                      style: TextStyle(
                        color: Colors.white,
                        fontSize: 24,
                        fontWeight: FontWeight.w500,
                      ),
                    ),
                  ),
                ),
                const SizedBox(width: 48),
              ],
            ),

            const SizedBox(height: 15),

            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 12),
              child: Row(
                children: [
                  Expanded(
                    child: _buildOption(
                      Icons.edit,
                      "Text",
                    ),
                  ),
                  const SizedBox(width: 10),
                  Expanded(
                    child: _buildOptionImage(
                      "assets/icons/logo_layout.JPG",
                      "Layout",
                    ),
                  ),
                  const SizedBox(width: 10),
                  Expanded(
                    child: _buildOptionImage(
                      "assets/icons/logo_voice.JPG",
                      "Voice",
                    ),
                  ),
                ],
              ),
            ),

            const SizedBox(height: 25),

            const Padding(
              padding: EdgeInsets.symmetric(horizontal: 16),
              child: Row(
                children: [
                  Text(
                    "Recents",
                    style: TextStyle(
                      color: Colors.white70,
                      fontSize: 18,
                      fontWeight: FontWeight.w500,
                    ),
                  ),
                  SizedBox(width: 4),
                  Icon(
                    Icons.keyboard_arrow_down,
                    color: Colors.white70,
                  ),
                ],
              ),
            ),

            const SizedBox(height: 12),

            Expanded(
              child: GridView.builder(
                padding: EdgeInsets.zero,
                itemCount: mediaItems.length + 1,
                gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
                  crossAxisCount: 3,
                  crossAxisSpacing: 1,
                  mainAxisSpacing: 1,
                ),
                itemBuilder: (context, index) {
                  // CAMERA
                  if (index == 0) {
                    return Container(
                      color: Colors.black,
                      child: const Column(
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: [
                          Icon(
                            Icons.camera_alt_outlined,
                            color: Colors.white,
                            size: 35,
                          ),
                          SizedBox(height: 8),
                          Text(
                            "Camera",
                            style: TextStyle(
                              color: Colors.white,
                              fontSize: 20,
                            ),
                          ),
                        ],
                      ),
                    );
                  }

                  final item = mediaItems[index - 1];
                  final isVideo = item["type"] == "video";

                  return GestureDetector(
                    onTap: () async {
                      if (isVideo) {
                        Navigator.push(
                          context,
                          MaterialPageRoute(
                            builder: (_) => VideoPreviewPage(
                              videoPath: item["path"]!,
                            ),
                          ),
                        );
                      } else {
                        // Menunggu hasil kirim balik data path gambar dari halaman preview
                        final result = await Navigator.push(
                          context,
                          MaterialPageRoute(
                            builder: (_) => StatusPreviewPage(
                              imagePath: item["path"]!,
                            ),
                          ),
                        );

                        // Jika data result tidak kosong, langsung oper balik ke status_page.dart
                        if (result != null && context.mounted) {
                          Navigator.pop(context, result);
                        }
                      }
                    },
                    child: Stack(
                      fit: StackFit.expand,
                      children: [
                        if (!isVideo)
                          Image.asset(
                            item["path"]!,
                            fit: BoxFit.cover,
                          ),
                        if (isVideo)
                          Container(
                            color: Colors.black87,
                            child: const Center(
                              child: Icon(
                                Icons.play_circle_fill,
                                color: Colors.white,
                                size: 55,
                              ),
                            ),
                          ),
                        if (isVideo)
                          const Positioned(
                            right: 5,
                            bottom: 5,
                            child: Icon(
                              Icons.videocam,
                              color: Colors.white,
                              size: 18,
                            ),
                          ),
                      ],
                    ),
                  );
                },
              ),
            ),
          ],
        ),
      ),
    );
  }

  static Widget _buildOption(IconData icon, String title) {
    return Container(
      height: 110,
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(18),
        border: Border.all(
          color: Colors.white12,
        ),
      ),
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Icon(
            icon,
            color: Colors.white,
            size: 32,
          ),
          const SizedBox(height: 10),
          Text(
            title,
            style: const TextStyle(
              color: Colors.white,
              fontSize: 16,
            ),
          ),
        ],
      ),
    );
  }

  static Widget _buildOptionImage(String imagePath, String title) {
    return Container(
      height: 110,
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(18),
        border: Border.all(
          color: Colors.white12,
        ),
      ),
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Image.asset(
            imagePath,
            width: 35,
            height: 35,
            fit: BoxFit.contain,
          ),
          const SizedBox(height: 10),
          Text(
            title,
            style: const TextStyle(
              color: Colors.white,
              fontSize: 16,
            ),
          ),
        ],
      ),
    );
  }
}