import 'dart:io';

import 'package:flutter/material.dart';
import 'package:video_player/video_player.dart';

class StatusViewerPage extends StatefulWidget {
  final String mediaPath;

  final bool isVideo;

  final bool isAsset;

  final String businessName;

  const StatusViewerPage({
    super.key,
    required this.mediaPath,
    required this.isVideo,
    required this.businessName,
    this.isAsset = false,
  });

  @override
  State<StatusViewerPage> createState() =>
      _StatusViewerPageState();
}

class _StatusViewerPageState
    extends State<StatusViewerPage>
    with SingleTickerProviderStateMixin {
  late AnimationController _imageController;

  VideoPlayerController? _videoController;

  double progress = 0;

  @override
  void initState() {
    super.initState();

    if (widget.isVideo) {
      _initializeVideo();
    } else {
      _initializeImage();
    }
  }

  Future<void> _initializeVideo() async {
    if (widget.isAsset) {
      _videoController =
          VideoPlayerController.asset(
        widget.mediaPath,
      );
    } else {
      _videoController =
          VideoPlayerController.file(
        File(widget.mediaPath),
      );
    }

    await _videoController!.initialize();

    await _videoController!.play();

    _videoController!.addListener(() {
      if (!mounted) return;

      final position =
          _videoController!.value.position;

      final duration =
          _videoController!.value.duration;

      if (duration.inMilliseconds > 0) {
        setState(() {
          progress =
              position.inMilliseconds /
              duration.inMilliseconds;
        });
      }

      if (position >= duration) {
        Navigator.pop(context);
      }
    });

    setState(() {});
  }

  void _initializeImage() {
    _imageController = AnimationController(
      vsync: this,
      duration: const Duration(seconds: 5),
    );

    _imageController.forward();

    _imageController.addListener(() {
      setState(() {
        progress = _imageController.value;
      });
    });

    _imageController.addStatusListener((status) {
      if (status ==
          AnimationStatus.completed) {
        Navigator.pop(context);
      }
    });
  }

  @override
  void dispose() {
    if (widget.isVideo) {
      _videoController?.dispose();
    } else {
      _imageController.dispose();
    }

    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.black,

      body: SafeArea(
        child: Column(
          children: [
            Padding(
              padding:
                  const EdgeInsets.symmetric(
                horizontal: 6,
                vertical: 8,
              ),
              child: LinearProgressIndicator(
                value: progress,
                minHeight: 3,
                backgroundColor:
                    Colors.white24,
                valueColor:
                    const AlwaysStoppedAnimation(
                  Colors.white,
                ),
              ),
            ),

            Padding(
              padding:
                  const EdgeInsets.symmetric(
                horizontal: 12,
              ),
              child: Row(
                children: [
                  IconButton(
                    onPressed: () {
                      Navigator.pop(context);
                    },
                    icon: const Icon(
                      Icons.arrow_back,
                      color: Colors.white,
                    ),
                  ),

                  const CircleAvatar(
                    radius: 22,
                    backgroundColor:
                        Colors.grey,
                  ),

                  const SizedBox(width: 12),

                  Expanded(
                    child: Column(
                      crossAxisAlignment:
                          CrossAxisAlignment.start,
                      children: [
                        Text(
                          widget.businessName,
                          style:
                              const TextStyle(
                            color: Colors.white,
                            fontSize: 18,
                            fontWeight:
                                FontWeight.bold,
                          ),
                        ),
                        const Text(
                          "Barusan",
                          style: TextStyle(
                            color:
                                Colors.white70,
                          ),
                        ),
                      ],
                    ),
                  ),

                  const Icon(
                    Icons.more_vert,
                    color: Colors.white,
                  ),
                ],
              ),
            ),

            const SizedBox(height: 10),

            Expanded(
              child: Center(
                child: widget.isVideo
                    ? (_videoController !=
                                null &&
                            _videoController!
                                .value
                                .isInitialized)
                        ? AspectRatio(
                            aspectRatio:
                                _videoController!
                                    .value
                                    .aspectRatio,
                            child: VideoPlayer(
                              _videoController!,
                            ),
                          )
                        : const CircularProgressIndicator()
                    : widget.isAsset
                        ? Image.asset(
                            widget.mediaPath,
                            fit:
                                BoxFit.contain,
                          )
                        : Image.asset(
                            widget.mediaPath,
                            fit:
                                BoxFit.contain,
                          ),
              ),
            ),
          ],
        ),
      ),
    );
  }
}