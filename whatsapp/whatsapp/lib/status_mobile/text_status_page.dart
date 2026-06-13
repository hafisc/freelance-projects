import 'package:flutter/material.dart';

class TextStatusPage extends StatefulWidget {
  const TextStatusPage({super.key});

  @override
  State<TextStatusPage> createState() => _TextStatusPageState();
}

class _TextStatusPageState extends State<TextStatusPage> {
  final TextEditingController _controller = TextEditingController();

  Color backgroundColor = const Color(0xFF58C466);

  final List<Color> colors = [
    Color(0xFF58C466),
    Color(0xFF0B141A),
    Color(0xFF7B1FA2),
    Color(0xFF1565C0),
    Color(0xFFD84315),
    Color(0xFF00897B),
    Color(0xFF5D4037),
  ];

  int currentColor = 0;

  void changeColor() {
    setState(() {
      currentColor++;

      if (currentColor >= colors.length) {
        currentColor = 0;
      }

      backgroundColor = colors[currentColor];
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: backgroundColor,

      body: SafeArea(
        child: Column(
          children: [

            // ==========================
            // TOP BAR
            // ==========================

            Padding(
              padding: const EdgeInsets.symmetric(
                horizontal: 20,
                vertical: 20,
              ),
              child: Row(
                children: [

                  Container(
                    width: 58,
                    height: 58,
                    decoration: BoxDecoration(
                      color: Colors.black38,
                      borderRadius: BorderRadius.circular(29),
                    ),
                    child: IconButton(
                      onPressed: () {
                        Navigator.pop(context);
                      },
                      icon: const Icon(
                        Icons.close,
                        color: Colors.white,
                        size: 34,
                      ),
                    ),
                  ),

                  const Spacer(),

                  Container(
                    width: 58,
                    height: 58,
                    decoration: BoxDecoration(
                      color: Colors.black38,
                      borderRadius: BorderRadius.circular(29),
                    ),
                    child: const Center(
                      child: Text(
                        "Aa",
                        style: TextStyle(
                          color: Colors.white,
                          fontSize: 22,
                          fontWeight: FontWeight.w600,
                        ),
                      ),
                    ),
                  ),

                  const SizedBox(width: 12),

                  Container(
                    width: 58,
                    height: 58,
                    decoration: BoxDecoration(
                      color: Colors.black38,
                      borderRadius: BorderRadius.circular(29),
                    ),
                    child: IconButton(
                      onPressed: changeColor,
                      icon: const Icon(
                        Icons.palette_outlined,
                        color: Colors.white,
                        size: 30,
                      ),
                    ),
                  ),
                ],
              ),
            ),

            // ==========================
            // TEXT AREA
            // ==========================

            Expanded(
              child: Center(
                child: Padding(
                  padding: const EdgeInsets.symmetric(
                    horizontal: 40,
                  ),
                  child: TextField(
                    controller: _controller,
                    textAlign: TextAlign.center,
                    maxLines: null,
                    style: const TextStyle(
                      color: Colors.white,
                      fontSize: 28,
                      fontWeight: FontWeight.w500,
                    ),
                    decoration: const InputDecoration(
                      border: InputBorder.none,
                      hintText: "Type a status",
                      hintStyle: TextStyle(
                        color: Colors.white54,
                        fontSize: 32,
                      ),
                    ),
                  ),
                ),
              ),
            ),

            // ==========================
            // BOTTOM MENU
            // ==========================

            Container(
              height: 90,
              color: Colors.black38,
              child: const Row(
                mainAxisAlignment:
                    MainAxisAlignment.spaceEvenly,
                children: [
                  Text(
                    "Video",
                    style: TextStyle(
                      color: Colors.white,
                      fontSize: 18,
                      fontWeight: FontWeight.w600,
                    ),
                  ),
                  Text(
                    "Photo",
                    style: TextStyle(
                      color: Colors.white,
                      fontSize: 18,
                      fontWeight: FontWeight.w600,
                    ),
                  ),

                  // ACTIVE
                  DecoratedBox(
                    decoration: BoxDecoration(
                      color: Colors.white10,
                      borderRadius:
                          BorderRadius.all(
                        Radius.circular(30),
                      ),
                    ),
                    child: Padding(
                      padding: EdgeInsets.symmetric(
                        horizontal: 28,
                        vertical: 12,
                      ),
                      child: Text(
                        "Text",
                        style: TextStyle(
                          color: Colors.white,
                          fontSize: 18,
                          fontWeight:
                              FontWeight.bold,
                        ),
                      ),
                    ),
                  ),

                  Text(
                    "Voice",
                    style: TextStyle(
                      color: Colors.white,
                      fontSize: 18,
                      fontWeight: FontWeight.w600,
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}