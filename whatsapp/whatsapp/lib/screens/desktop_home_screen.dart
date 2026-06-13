import 'package:flutter/material.dart';

import '../data/dummy_chats_desktop.dart';
import '../widgets/desktop_chat_tile.dart';
import '../mobile/mobile_welcome_screen.dart';
import '../status_desktop/my_status_page.dart';

class DesktopHomeScreen extends StatelessWidget {
  const DesktopHomeScreen({super.key});

  @override
  Widget build(BuildContext context) {

    final width =
        MediaQuery.of(context).size.width;

    // =====================================
    // MOBILE VIEW
    // =====================================

    if (width < 800) {
      return const WhatsAppBusinessOnboarding();
    }

    // =====================================
    // DESKTOP VIEW
    // =====================================

    return Scaffold(
      backgroundColor: const Color(0xffF0F2F5),

      body: Row(
        children: [

          // =================================
          // SIDEBAR
          // =================================

                  Container(
            width: 68,

            decoration: const BoxDecoration(
              color: Colors.white,
              border: Border(
                right: BorderSide(
                  color: Color(0xffD1D7DB),
                  width: 1,
                ),
              ),
            ),

            child: Column(
              children: [

                const SizedBox(height: 30),

                // CHAT
                _sidebarIcon(
                    context,
                  'assets/icons/logo_chat.jpg',
                    null,
                ),

                const SizedBox(height: 30),

                // STATUS / UPDATES
               _sidebarIcon(
                  context,
                  'assets/icons/logo_updates.jpg',
                  const StatusWebPage(),
                ),

                const SizedBox(height: 30),

                // SIARAN
                _sidebarIcon(
                  context,
                  'assets/icons/logo_siaran.jpg',
                    null,
                ),

                const SizedBox(height: 30),

                // KOMUNITAS
                _sidebarIcon(
                  context,
                  'assets/icons/logo_komunitas.jpg',
                  null,
                ),

                const SizedBox(height: 30),

                // TOOLS
                _sidebarIcon(
                  context,
                  'assets/icons/logo_tools.jpg',
                  null,
                ),

                const Spacer(),
                // FOTO
                _sidebarIcon(
                  context,
                  'assets/icons/logo_foto.jpg',
                  null,
                ),

                const SizedBox(height: 30),

                // SETTING
                _sidebarIcon(
                  context,
                  'assets/icons/logo_setting.jpg',
                  null,
                ),

                const SizedBox(height: 30),

                // PROFILE
                _sidebarIcon(
                  context,
                  'assets/icons/logo_profile.jpg',
                  null,
                ),

                const SizedBox(height: 30),
              ],
            ),
          ),

          // =================================
          // CHAT LIST
          // =================================

          Container(
            width: 430,
            color: Colors.white,

            child: Column(
              children: [

                // HEADER

                Container(
                  height: 70,

                  padding:
                      const EdgeInsets.symmetric(
                    horizontal: 20,
                  ),

                  child: Row(
                    mainAxisAlignment:
                        MainAxisAlignment.spaceBetween,

                    children: [

                      const Text(
                        'WhatsApp',

                        style: TextStyle(
                          fontSize: 20,
                          fontWeight:
                              FontWeight.bold,
                          color: Colors.black,
                        ),
                      ),

                      Row(
                        children: const [

                          Icon(
                            Icons.add_box_outlined,
                            color: Colors.black,
                            size: 22,
                          ),

                          SizedBox(width: 20),

                          Icon(
                            Icons.more_vert,
                            color: Colors.black,
                            size: 22,
                          ),
                        ],
                      ),
                    ],
                  ),
                ),

                // SEARCH

                Padding(
                  padding:
                      const EdgeInsets.symmetric(
                    horizontal: 16,
                  ),

                  child: Container(
                    height: 42,

                    decoration: BoxDecoration(
                      color:
                          const Color(0xffF0F2F5),

                      borderRadius:
                          BorderRadius.circular(
                        25,
                      ),
                    ),

                    child: TextField(
                      style: const TextStyle(
                        color: Colors.black,
                        fontSize: 14,
                      ),

                      cursorColor:
                          const Color(
                        0xff25D366,
                      ),

                      decoration:
                          const InputDecoration(
                        border: InputBorder.none,

                        contentPadding:
                            EdgeInsets.symmetric(
                          vertical: 10,
                        ),

                        prefixIcon: Icon(
                          Icons.search,
                          color: Colors.grey,
                          size: 20,
                        ),

                        hintText:
                            'Search or start a new chat',

                        hintStyle: TextStyle(
                          color: Colors.grey,
                          fontSize: 14,
                        ),
                      ),
                    ),
                  ),
                ),

                const SizedBox(height: 15),

                // FILTER BUTTON

                Padding(
                  padding:
                      const EdgeInsets.symmetric(
                    horizontal: 16,
                  ),

                  child: Row(
                    children: [

                      _buildFilterButton(
                        'All',
                        true,
                      ),

                      const SizedBox(width: 10),

                      _buildFilterButton(
                        'Unread',
                        false,
                      ),

                      const SizedBox(width: 10),

                      _buildFilterButton(
                        'Favourites',
                        false,
                      ),

                      const SizedBox(width: 10),

                      _buildFilterButton(
                        'Groups',
                        false,
                      ),
                    ],
                  ),
                ),

                const SizedBox(height: 10),

                // CHAT LIST

                Expanded(
                  child: ListView.builder(
                    physics:
                        const BouncingScrollPhysics(),

                    itemCount:
                        desktopChats.length,

                    itemBuilder:
                        (context, index) {

                      return DesktopChatTile(
                        chat:
                            desktopChats[index],
                      );
                    },
                  ),
                ),
              ],
            ),
          ),

          // =================================
          // RIGHT PANEL
          // =================================

          Expanded(
            child: Container(
              color: const Color(0xffF0F2F5),

              child: Center(
                child: Column(
                  mainAxisAlignment:
                      MainAxisAlignment.center,

                  children: [

                    Image.asset(
                      'assets/images/web_intro.jpeg',
                      width: 340,
                    ),

                    const SizedBox(height: 35),

                    const Text(
                      'WhatsApp Business on Web',

                      style: TextStyle(
                        fontSize: 32,
                        color: Colors.black,
                        fontWeight:
                            FontWeight.w300,
                      ),
                    ),

                    const SizedBox(height: 15),

                    const Text(
                      'Grow, organise and manage your business account.',

                      style: TextStyle(
                        fontSize: 14,
                        color: Colors.grey,
                      ),
                    ),

                    const SizedBox(height: 280),

                    Row(
                      mainAxisAlignment:
                          MainAxisAlignment.center,

                      children: const [

                        Icon(
                          Icons.lock_outline,
                          size: 14,
                          color: Colors.grey,
                        ),

                        SizedBox(width: 6),

                        Text(
                          'Your personal messages are end-to-end encrypted',

                          style: TextStyle(
                            fontSize: 13,
                            color: Colors.grey,
                          ),
                        ),
                      ],
                    ),
                  ],
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }

  // =========================================
  // FILTER BUTTON
  // =========================================

  static Widget _buildFilterButton(
    String text,
    bool active,
  ) {

    return Container(
      padding: const EdgeInsets.symmetric(
        horizontal: 16,
        vertical: 8,
      ),

      decoration: BoxDecoration(
        color: active
            ? const Color(0xffD9FDD3)
            : Colors.white,

        borderRadius:
            BorderRadius.circular(20),

        border: Border.all(
          color: Colors.grey.shade300,
        ),
      ),

      child: Text(
        text,

        style: TextStyle(
          color: active
              ? Colors.black
              : Colors.grey[700],

          fontWeight: FontWeight.w500,
          fontSize: 13,
        ),
      ),

          );
  }

  // =========================================
  // SIDEBAR ICON
  // =========================================

  static Widget _sidebarIcon(
  BuildContext context,
  String imagePath,
  Widget? page,
) {
  return InkWell(
    onTap: () {
      if (page != null) {
        Navigator.push(
          context,
          MaterialPageRoute(
            builder: (context) => page,
          ),
        );
      }
    },
    child: Container(
      width: 40,
      height: 40,
      alignment: Alignment.center,
      child: Image.asset(
        imagePath,
        width: 24,
        height: 24,
        fit: BoxFit.contain,
      ),
    ),
  );
}
}
   