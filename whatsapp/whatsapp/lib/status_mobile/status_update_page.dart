import 'package:flutter/material.dart';

class StatusUpdatesPage extends StatelessWidget {
  final String statusImage;

  const StatusUpdatesPage({
    super.key,
    required this.statusImage,
  });

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFF0B141A),

      floatingActionButton: Column(
        mainAxisSize: MainAxisSize.min,
        children: [
          Container(
            width: 56,
            height: 56,
            margin: const EdgeInsets.only(bottom: 12),
            decoration: BoxDecoration(
              color: const Color(0xFF202C33),
              borderRadius: BorderRadius.circular(18),
            ),
            child: Center(
              child: Image.asset(
                "assets/icons/logo_menulis.jpg",
                width: 28,
                height: 28,
              ),
            ),
          ),

          Container(
            width: 70,
            height: 70,
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(24),
            ),
            child: Center(
              child: Image.asset(
                "assets/icons/logo_kamera.jpg",
                width: 36,
                height: 36,
              ),
            ),
          ),
        ],
      ),

      bottomNavigationBar: Container(
        height: 80,
        decoration: const BoxDecoration(
          color: Color(0xFF0B141A),
          border: Border(
            top: BorderSide(
              color: Color(0xFF1F2C34),
            ),
          ),
        ),
        child: Row(
          mainAxisAlignment: MainAxisAlignment.spaceAround,
         children: [
        _navItemImage(
          "assets/icons/logo_chats.jpg",
          "Chats",
        ),

        _navItem(Icons.call_outlined, "Calls"),

        _selectedNavItem(
          "assets/icons/update_logo.jpg",
          "Updates",
        ),

        _navItemImage(
          "assets/icons/tools_status.JPG",
          "Tools",
        ),
  ],
        ),
      ),

      body: SafeArea(
        child: SingleChildScrollView(
          child: Padding(
            padding: const EdgeInsets.symmetric(
              horizontal: 20,
            ),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                const SizedBox(height: 15),

                /// APP BAR
                Row(
                  children: [
                    const Text(
                      "Updates",
                      style: TextStyle(
                        color: Colors.white,
                        fontSize: 30,
                        fontWeight: FontWeight.w500,
                      ),
                    ),

                    const Spacer(),

                    const Icon(
                      Icons.camera_alt_outlined,
                      color: Colors.white,
                      size: 30,
                    ),

                    const SizedBox(width: 22),

                    const Icon(
                      Icons.search,
                      color: Colors.white,
                      size: 30,
                    ),

                    const SizedBox(width: 18),

                    const Icon(
                      Icons.more_vert,
                      color: Colors.white,
                      size: 30,
                    ),
                  ],
                ),

                const SizedBox(height: 42),

                const Text(
                  "Status",
                  style: TextStyle(
                    color: Colors.white,
                    fontSize: 24,
                    fontWeight: FontWeight.bold,
                  ),
                ),

                const SizedBox(height: 22),

                /// MY STATUS
                Row(
                  children: [
                    Container(
                      padding: const EdgeInsets.all(3),
                      decoration: BoxDecoration(
                        shape: BoxShape.circle,
                        border: Border.all(
                          color: Colors.green,
                          width: 3,
                        ),
                      ),
                     child: CircleAvatar(
                      radius: 34,
                      backgroundImage: AssetImage(
                        statusImage,
                      ),
                    ),
                    ),

                    const SizedBox(width: 18),

                    const Column(
                      crossAxisAlignment:
                          CrossAxisAlignment.start,
                      children: [
                        Text(
                          "My status",
                          style: TextStyle(
                            color: Colors.white,
                            fontSize: 18,
                            fontWeight: FontWeight.w600,
                          ),
                        ),
                        SizedBox(height: 4),
                        Text(
                          "Just now",
                          style: TextStyle(
                            color: Colors.grey,
                            fontSize: 15,
                          ),
                        ),
                      ],
                    ),
                  ],
                ),

                const SizedBox(height: 24),

                /// BOOST STATUS
                Container(
                  width: double.infinity,
                  height: 62,
                  decoration: BoxDecoration(
                    borderRadius:
                        BorderRadius.circular(35),
                    border: Border.all(
                      color: Colors.white24,
                    ),
                  ),
                  child: Center(
                    child: Image.asset(
                      "assets/icons/boost_status.jpg",
                      height: 28,
                    ),
                  ),
                ),

                const SizedBox(height: 35),

                const Text(
                  "Recent updates",
                  style: TextStyle(
                    color: Colors.grey,
                    fontSize: 18,
                    fontWeight: FontWeight.w600,
                  ),
                ),

                const SizedBox(height: 18),

                /// WHATSAPP BUSINESS
                Row(
                  children: [
                    Image.asset(
                      "assets/icons/logo_status_whatsapp.jpg",
                      width: 70,
                      height: 70,
                    ),

                    const SizedBox(width: 16),

                    const Column(
                      crossAxisAlignment:
                          CrossAxisAlignment.start,
                      children: [
                        Text(
                          "WhatsApp Business",
                          style: TextStyle(
                            color: Colors.white,
                            fontSize: 17,
                            fontWeight: FontWeight.w600,
                          ),
                        ),
                        SizedBox(height: 4),
                        Text(
                          "22 minutes ago",
                          style: TextStyle(
                            color: Colors.grey,
                            fontSize: 15,
                          ),
                        ),
                      ],
                    ),
                  ],
                ),

                const SizedBox(height: 40),

                const Text(
                  "Channels",
                  style: TextStyle(
                    color: Colors.white,
                    fontSize: 24,
                    fontWeight: FontWeight.bold,
                  ),
                ),

                const SizedBox(height: 10),

                const Text(
                  "Stay updated on topics that matter to you. Find channels to follow below.",
                  style: TextStyle(
                    color: Colors.grey,
                    fontSize: 16,
                    height: 1.5,
                  ),
                ),

                const SizedBox(height: 40),

                const Text(
                  "Find channels to follow",
                  style: TextStyle(
                    color: Colors.white70,
                    fontSize: 18,
                    fontWeight: FontWeight.w600,
                  ),
                ),

                const SizedBox(height: 20),

                _channelButton("Explore more"),

                const SizedBox(height: 18),

                _channelButton("Create channel"),

                const SizedBox(height: 120),
              ],
            ),
          ),
        ),
      ),
    );
  }

  static Widget _channelButton(String title) {
    return Container(
      width: double.infinity,
      height: 60,
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(35),
        border: Border.all(
          color: Colors.white24,
        ),
      ),
      child: Center(
        child: Text(
          title,
          style: const TextStyle(
            color: Color(0xFF25D366),
            fontSize: 20,
            fontWeight: FontWeight.w600,
          ),
        ),
      ),
    );
  }

    static Widget _navItemImage(
    String image,
    String label,
  ) {
    return Column(
      mainAxisAlignment: MainAxisAlignment.center,
      children: [
        Image.asset(
          image,
          width: 24,
          height: 24,
        ),
        const SizedBox(height: 4),
        Text(
          label,
          style: const TextStyle(
            color: Colors.white,
          ),
        ),
      ],
    );
  }
  static Widget _navItem(
    IconData icon,
    String label,
  ) {
    return Column(
      mainAxisAlignment: MainAxisAlignment.center,
      children: [
        Icon(
          icon,
          color: Colors.white,
        ),
        const SizedBox(height: 4),
        Text(
          label,
          style: const TextStyle(
            color: Colors.white,
          ),
        ),
      ],
    );
  }

  static Widget _selectedNavItem(
    String image,
    String label,
  ) {
    return Column(
      mainAxisAlignment: MainAxisAlignment.center,
      children: [
        Container(
          width: 74,
          height: 34,
          decoration: BoxDecoration(
            color: const Color(0xFF1F2C22),
            borderRadius:
                BorderRadius.circular(30),
          ),
          child: Center(
            child: Image.asset(
              image,
              width: 24,
              height: 24,
            ),
          ),
        ),
        const SizedBox(height: 4),
        Text(
          label,
          style: const TextStyle(
            color: Colors.white,
            fontWeight: FontWeight.bold,
          ),
        ),
      ],
    );
  }
}