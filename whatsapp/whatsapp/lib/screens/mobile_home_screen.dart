import 'package:flutter/material.dart';
import '../status_mobile/status_page.dart';
import '../data/dummy_chats_mobile.dart';
import '../desktop/desktop_login_screen.dart';
import '../widgets/mobile_chat_tile.dart';

class MobileHomeScreen extends StatelessWidget {
  const MobileHomeScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return LayoutBuilder(
      builder: (context, constraints) {
        final isMobile =
            constraints.maxWidth < 768;

        return isMobile
            ? Scaffold(
                backgroundColor:
                    const Color(
                  0xff000B12,
                ),

                body: SafeArea(
                  child: Column(
                    children: [
                      // HEADER
                      Padding(
                        padding:
                            const EdgeInsets.only(
                          left: 12,
                          right: 12,
                          top: 10,
                          bottom: 4,
                        ),

                        child: Row(
                          mainAxisAlignment:
                              MainAxisAlignment
                                  .spaceBetween,

                          children: [
                            const Text(
                              'WhatsApp',

                              style: TextStyle(
                                color:
                                    Colors
                                        .white,
                                fontSize: 28,
                                fontWeight:
                                    FontWeight
                                        .w700,
                                letterSpacing:
                                    -1,
                              ),
                            ),

                            Row(
                              children: const [
                                Icon(
                                  Icons
                                      .camera_alt_outlined,
                                  color:
                                      Colors
                                          .white,
                                  size: 24,
                                ),

                                SizedBox(
                                    width:
                                        16),

                                Icon(
                                  Icons
                                      .more_vert,
                                  color:
                                      Colors
                                          .white,
                                  size: 24,
                                ),
                              ],
                            ),
                          ],
                        ),
                      ),

                      // SEARCH BAR
                      Padding(
                        padding:
                            const EdgeInsets.only(
                          left: 16,
                          right: 16,
                          top: 6,
                          bottom: 10,
                        ),

                        child: Container(
                          height: 52,

                          decoration:
                              BoxDecoration(
                            color:
                                const Color(
                              0xff1F2C34,
                            ),

                            borderRadius:
                                BorderRadius.circular(
                              28,
                            ),
                          ),

                          child: TextField(
                            style:
                                const TextStyle(
                              color: Colors
                                  .white,
                              fontSize: 16,
                            ),

                            cursorColor:
                                const Color(
                              0xff25D366,
                            ),

                            decoration:
                                const InputDecoration(
                              border:
                                  InputBorder
                                      .none,

                              contentPadding:
                                  EdgeInsets.symmetric(
                                vertical:
                                    14,
                              ),

                              prefixIcon:
                                  Icon(
                                Icons.search,
                                color:
                                    Color(
                                  0xff8696A0,
                                ),
                                size:
                                    28,
                              ),

                              hintText:
                                  'Search...',

                              hintStyle:
                                  TextStyle(
                                color:
                                    Color(
                                  0xff8696A0,
                                ),
                                fontSize:
                                    16,
                                fontWeight:
                                    FontWeight
                                        .w400,
                              ),
                            ),
                          ),
                        ),
                      ),

                      // CHAT LIST
                      Expanded(
                        child:
                            ListView.builder(
                          physics:
                              const BouncingScrollPhysics(),

                          padding:
                              const EdgeInsets.only(
                            top: 2,
                            bottom: 8,
                          ),

                          itemCount:
                              mobileChats
                                  .length,

                          itemBuilder:
                              (
                            context,
                            index,
                          ) {
                            return MobileChatTile(
                              chat:
                                  mobileChats[
                                      index],
                            );
                          },
                        ),
                      ),
                    ],
                  ),
                ),

                // FLOATING BUTTONS
                floatingActionButton:
                    Padding(
                  padding:
                      const EdgeInsets.only(
                    right: 2,
                    bottom: 8,
                  ),

                  child: Column(
                    mainAxisAlignment:
                        MainAxisAlignment
                            .end,

                    crossAxisAlignment:
                        CrossAxisAlignment
                            .end,

                    children: [
                      // META
                      Container(
                        width: 52,
                        height: 52,

                        decoration:
                            BoxDecoration(
                          color:
                              const Color(
                            0xff1B262C,
                          ),

                          borderRadius:
                              BorderRadius.circular(
                            16,
                          ),
                        ),

                        child: ClipRRect(
                          borderRadius:
                              BorderRadius.circular(
                            16,
                          ),

                          child:
                              FittedBox(
                            fit: BoxFit
                                .cover,

                            child:
                                Image.asset(
                              'assets/icons/meta.png',
                            ),
                          ),
                        ),
                      ),

                      const SizedBox(
                        height: 14,
                      ),

                      // ADD BUTTON
                      SizedBox(
                        width: 62,
                        height: 62,

                        child:
                            ClipRRect(
                          borderRadius:
                              BorderRadius.circular(
                            20,
                          ),

                          child:
                              FittedBox(
                            fit: BoxFit
                                .cover,

                            child:
                                Image.asset(
                              'assets/icons/add.jpeg',
                            ),
                          ),
                        ),
                      ),
                    ],
                  ),
                ),

                // BOTTOM NAVIGATION
                bottomNavigationBar:
                    Container(
                  height: 82,

                  decoration:
                      const BoxDecoration(
                    color: Color(
                      0xff0A1014,
                    ),

                    border: Border(
                      top: BorderSide(
                        color: Color(
                          0xff111B21,
                        ),
                        width: 0.5,
                      ),
                    ),
                  ),

                  child: Padding(
                    padding:
                        const EdgeInsets.only(
                      top: 6,
                    ),

                    child: Row(
                      mainAxisAlignment:
                          MainAxisAlignment
                              .spaceAround,

                      children: [
                        _buildChatsItem(),

                        _buildCallsItem(),

                        _buildUpdatesItem(context),

                        _buildToolsItem(),
                      ],
                    ),
                  ),
                ),
              )
            : const DesktopLoginScreen();
      },
    );
  }

  // CHATS
  Widget _buildChatsItem() {
    return Column(
      mainAxisAlignment:
          MainAxisAlignment.center,

      children: [
        Stack(
          clipBehavior: Clip.none,

          children: [
            Container(
              width: 72,
              height: 32,

              decoration: BoxDecoration(
                color:
                    const Color(
                  0xff1E2F2A,
                ),

                borderRadius:
                    BorderRadius.circular(
                  20,
                ),
              ),

              child: const Center(
                child: Icon(
                  Icons.chat,
                  color:
                      Colors.white,
                  size: 18,
                ),
              ),
            ),

            Positioned(
              right: -3,
              top: -3,

              child: Container(
                width: 18,
                height: 18,

                decoration:
                    const BoxDecoration(
                  color: Color(
                    0xff25D366,
                  ),
                  shape:
                      BoxShape.circle,
                ),

                alignment:
                    Alignment.center,

                child: const Text(
                  '5',

                  style: TextStyle(
                    color:
                        Colors.black,
                    fontSize: 9,
                    fontWeight:
                        FontWeight.bold,
                  ),
                ),
              ),
            ),
          ],
        ),

        const SizedBox(height: 6),

        const Text(
          'Chats',

          style: TextStyle(
            color: Colors.white,
            fontSize: 12,
            fontWeight:
                FontWeight.w500,
          ),
        ),
      ],
    );
  }

  // CALLS
  Widget _buildCallsItem() {
    return Column(
      mainAxisAlignment:
          MainAxisAlignment.center,

      children: const [
        Icon(
          Icons.call_outlined,
          color: Colors.white,
          size: 23,
        ),

        SizedBox(height: 6),

        Text(
          'Calls',

          style: TextStyle(
            color: Colors.white,
            fontSize: 12,
            fontWeight:
                FontWeight.w500,
          ),
        ),
      ],
    );
  }

  // UPDATES
 // UPDATES
Widget _buildUpdatesItem(
  BuildContext context,
) {
  return GestureDetector(
    onTap: () {
      Navigator.push(
        context,
        MaterialPageRoute(
          builder: (_) => const StatusMobilePage(),
        ),
      );
    },
    child: Column(
      mainAxisAlignment:
          MainAxisAlignment.center,
      children: [
        SizedBox(
          width: 30,
          height: 30,
          child: ClipRRect(
            borderRadius:
                BorderRadius.circular(8),
            child: FittedBox(
              fit: BoxFit.cover,
              child: Image.asset(
                'assets/icons/updates.png',
              ),
            ),
          ),
        ),

        const SizedBox(height: 6),

        const Text(
          'Updates',
          style: TextStyle(
            color: Colors.white,
            fontSize: 12,
            fontWeight:
                FontWeight.w500,
          ),
        ),
      ],
    ),
  );
}
  // TOOLS
  Widget _buildToolsItem() {
    return Column(
      mainAxisAlignment:
          MainAxisAlignment.center,

      children: [
        Stack(
          clipBehavior: Clip.none,

          children: [
            SizedBox(
              width: 30,
              height: 30,

              child: ClipRRect(
                borderRadius:
                    BorderRadius.circular(
                  8,
                ),

                child: FittedBox(
                  fit: BoxFit.cover,

                  child: Image.asset(
                    'assets/icons/tools.png',
                  ),
                ),
              ),
            ),
          ],
        ),

        const SizedBox(height: 6),

        const Text(
          'Tools',

          style: TextStyle(
            color: Colors.white,
            fontSize: 12,
            fontWeight:
                FontWeight.w500,
          ),
        ),
      ],
    );
  }
}