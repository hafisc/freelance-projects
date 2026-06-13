import 'package:flutter/material.dart';

class ImagePreviewPage extends StatelessWidget {
  final String imagePath;

  const ImagePreviewPage({
    super.key,
    required this.imagePath,
  });

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.black,

      body: Stack(
        children: [

          Center(
            child: InteractiveViewer(
              minScale: 0.5,
              maxScale: 4,
              child: Image.asset(
                imagePath,
                fit: BoxFit.contain,
              ),
            ),
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

          Positioned(
            bottom: 20,
            left: 16,
            right: 16,
            child: Container(
              height: 55,
              decoration: BoxDecoration(
                color: Colors.white10,
                borderRadius: BorderRadius.circular(30),
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
                    margin: const EdgeInsets.all(3),
                    decoration: const BoxDecoration(
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