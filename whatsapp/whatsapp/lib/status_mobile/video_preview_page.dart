import 'package:flutter/material.dart';
import 'package:video_player/video_player.dart';

class VideoPreviewPage extends StatefulWidget {
  final String videoPath;

  const VideoPreviewPage({
    super.key,
    required this.videoPath,
  });

  @override
  State<VideoPreviewPage> createState() =>
      _VideoPreviewPageState();
}

class _VideoPreviewPageState
    extends State<VideoPreviewPage> {
  late VideoPlayerController controller;

  bool isReady = false;

  @override
  void initState() {
    super.initState();

    controller =
        VideoPlayerController.asset(
      widget.videoPath,
    )
          ..initialize().then((_) {
            setState(() {
              isReady = true;
            });

            controller.play();
            controller.setLooping(true);
          });
  }

  @override
  void dispose() {
    controller.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.black,

      body: Stack(
        children: [

          Center(
            child: isReady
                ? AspectRatio(
                    aspectRatio:
                        controller.value.aspectRatio,
                    child: VideoPlayer(
                      controller,
                    ),
                  )
                : const CircularProgressIndicator(),
          ),

          GestureDetector(
            onTap: () {
              if (controller.value.isPlaying) {
                controller.pause();
              } else {
                controller.play();
              }

              setState(() {});
            },
          ),

          SafeArea(
            child: Padding(
              padding: const EdgeInsets.all(10),
              child: Row(
                children: [

                  CircleAvatar(
                    backgroundColor: Colors.black54,
                    child: IconButton(
                      onPressed: () {
                        Navigator.pop(context);
                      },
                      icon: const Icon(
                        Icons.arrow_back,
                        color: Colors.white,
                      ),
                    ),
                  ),

                  const Spacer(),

                  CircleAvatar(
                    backgroundColor: Colors.black54,
                    child: IconButton(
                      onPressed: () {},
                      icon: const Icon(
                        Icons.crop_rotate,
                        color: Colors.white,
                      ),
                    ),
                  ),

                  const SizedBox(width: 8),

                  CircleAvatar(
                    backgroundColor: Colors.black54,
                    child: IconButton(
                      onPressed: () {},
                      icon: const Icon(
                        Icons.emoji_emotions_outlined,
                        color: Colors.white,
                      ),
                    ),
                  ),

                  const SizedBox(width: 8),

                  CircleAvatar(
                    backgroundColor: Colors.black54,
                    child: IconButton(
                      onPressed: () {},
                      icon: const Icon(
                        Icons.text_fields,
                        color: Colors.white,
                      ),
                    ),
                  ),
                ],
              ),
            ),
          ),

          if (isReady)
            Center(
              child: AnimatedOpacity(
                duration:
                    const Duration(milliseconds: 300),
                opacity:
                    controller.value.isPlaying
                        ? 0
                        : 1,
                child: const Icon(
                  Icons.play_circle_fill,
                  color: Colors.white,
                  size: 90,
                ),
              ),
            ),

          Positioned(
            bottom: 90,
            left: 15,
            right: 15,
            child: VideoProgressIndicator(
              controller,
              allowScrubbing: true,
              padding:
                  const EdgeInsets.symmetric(
                vertical: 8,
              ),
            ),
          ),

          Positioned(
            bottom: 20,
            left: 16,
            right: 16,
            child: Container(
              height: 55,
              decoration: BoxDecoration(
                color: Colors.white10,
                borderRadius:
                    BorderRadius.circular(30),
              ),
              child: Row(
                children: [

                  const SizedBox(width: 15),

                  const Icon(
                    Icons.edit,
                    color: Colors.white70,
                  ),

                  const SizedBox(width: 10),

                  const Expanded(
                    child: Text(
                      "Add a caption...",
                      style: TextStyle(
                        color: Colors.white70,
                        fontSize: 16,
                      ),
                    ),
                  ),

                  Container(
                    width: 50,
                    height: 50,
                    margin:
                        const EdgeInsets.all(3),
                    decoration:
                        const BoxDecoration(
                      color: Color(0xff25D366),
                      shape: BoxShape.circle,
                    ),
                    child: const Icon(
                      Icons.send,
                      color: Colors.white,
                    ),
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