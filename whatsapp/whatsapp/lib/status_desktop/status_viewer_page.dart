import 'dart:typed_data';
import 'package:flutter/material.dart';

class StatusViewerPage extends StatelessWidget {
  final Uint8List? imageBytes;
  final String userName;
  final String time;
  final bool isMyStatus;
  final int viewCount;

  const StatusViewerPage({
    super.key,
    required this.imageBytes,
    required this.userName,
    required this.time,
    required this.isMyStatus,
    this.viewCount = 0,
  });

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.black,
      body: Stack(
        children: [
          // =========================
          // BACKGROUND IMAGE
          // =========================

          if (imageBytes != null)
            Positioned.fill(
              child: Image.memory(
                imageBytes!,
                fit: BoxFit.cover,
              ),
            ),

          // =========================
          // DARK OVERLAY
          // =========================

          Positioned.fill(
            child: Container(
              color: Colors.black.withOpacity(0.45),
            ),
          ),

          // =========================
          // STATUS IMAGE
          // =========================

          if (imageBytes != null)
            Center(
              child: Image.memory(
                imageBytes!,
                fit: BoxFit.contain,
              ),
            ),

          // =========================
          // TOP GRADIENT
          // =========================

          Positioned(
            top: 0,
            left: 0,
            right: 0,
            child: Container(
              height: 130,
              decoration: BoxDecoration(
                gradient: LinearGradient(
                  begin: Alignment.topCenter,
                  end: Alignment.bottomCenter,
                  colors: [
                    Colors.black.withOpacity(.6),
                    Colors.transparent,
                  ],
                ),
              ),
            ),
          ),

          // =========================
          // PROGRESS BAR
          // =========================

          Positioned(
            top: 12,
            left: 16,
            right: 16,
            child: SafeArea(
              child: Container(
                height: 3,
                decoration: BoxDecoration(
                  color: Colors.white24,
                  borderRadius: BorderRadius.circular(50),
                ),
                child: FractionallySizedBox(
                  alignment: Alignment.centerLeft,
                  widthFactor: 1,
                  child: Container(
                    decoration: BoxDecoration(
                      color: Colors.white,
                      borderRadius: BorderRadius.circular(50),
                    ),
                  ),
                ),
              ),
            ),
          ),

          // =========================
          // HEADER
          // =========================

          Positioned(
            top: 24,
            left: 8,
            right: 8,
            child: SafeArea(
              child: Row(
                children: [
                  IconButton(
                    icon: const Icon(
                      Icons.arrow_back,
                      color: Colors.white,
                    ),
                    onPressed: () {
                      Navigator.pop(context);
                    },
                  ),

                  const SizedBox(width: 4),

                  const CircleAvatar(
                    radius: 18,
                    backgroundColor: Color(0xffD9FDD3),
                    child: Icon(
                      Icons.person,
                      color: Color(0xff008069),
                    ),
                  ),

                  const SizedBox(width: 10),

                  Expanded(
                    child: Column(
                      crossAxisAlignment:
                          CrossAxisAlignment.start,
                      children: [
                        Text(
                          userName,
                          overflow: TextOverflow.ellipsis,
                          style: const TextStyle(
                            color: Colors.white,
                            fontSize: 15,
                            fontWeight: FontWeight.w600,
                          ),
                        ),
                        Text(
                          time,
                          style: const TextStyle(
                            color: Colors.white70,
                            fontSize: 12,
                          ),
                        ),
                      ],
                    ),
                  ),

                  const Icon(
                    Icons.play_arrow,
                    color: Colors.white,
                  ),

                  const SizedBox(width: 16),

                  const Icon(
                    Icons.volume_up,
                    color: Colors.white,
                  ),

                  const SizedBox(width: 16),

                  const Icon(
                    Icons.more_vert,
                    color: Colors.white,
                  ),

                  const SizedBox(width: 8),

                  IconButton(
                    icon: const Icon(
                      Icons.close,
                      color: Colors.white,
                    ),
                    onPressed: () {
                      Navigator.pop(context);
                    },
                  ),
                ],
              ),
            ),
          ),

          // =========================
          // MY STATUS
          // =========================

          if (isMyStatus)
            Positioned(
              bottom: 30,
              left: 0,
              right: 0,
              child: Row(
                mainAxisAlignment:
                    MainAxisAlignment.center,
                children: [
                  const Icon(
                    Icons.remove_red_eye_outlined,
                    color: Colors.white,
                    size: 20,
                  ),

                  const SizedBox(width: 8),

                  Text(
                    "$viewCount",
                    style: const TextStyle(
                      color: Colors.white,
                      fontSize: 15,
                      fontWeight: FontWeight.w500,
                    ),
                  ),
                ],
              ),
            ),

          // =========================
          // REPLY BAR
          // =========================

          if (!isMyStatus)
            Positioned(
              left: 20,
              right: 20,
              bottom: 20,
              child: SafeArea(
                child: Row(
                  children: [
                    const Icon(
                      Icons.emoji_emotions_outlined,
                      color: Colors.white,
                    ),

                    const SizedBox(width: 12),

                    Expanded(
                      child: Container(
                        height: 44,
                        padding: const EdgeInsets.symmetric(
                          horizontal: 16,
                        ),
                        decoration: BoxDecoration(
                          border: Border.all(
                            color: Colors.white54,
                          ),
                          borderRadius:
                              BorderRadius.circular(24),
                        ),
                        alignment: Alignment.centerLeft,
                        child: const Text(
                          "Type a reply...",
                          style: TextStyle(
                            color: Colors.white70,
                          ),
                        ),
                      ),
                    ),

                    const SizedBox(width: 12),

                    const Icon(
                      Icons.send_rounded,
                      color: Colors.white,
                    ),
                  ],
                ),
              ),
            ),
        ],
      ),
    );
  }
}