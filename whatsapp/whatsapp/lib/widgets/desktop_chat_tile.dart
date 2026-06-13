
import 'package:flutter/material.dart';

import '../core/app_colors.dart';
import '../data/chat_model.dart';

class DesktopChatTile extends StatelessWidget {
  final ChatModel chat;

  const DesktopChatTile({
    super.key,
    required this.chat,
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(
        horizontal: 12,
        vertical: 8,
      ),

      child: Row(
        children: [

          // PROFILE
          Stack(
            children: [

              Container(
                padding: const EdgeInsets.all(2),

                decoration: BoxDecoration(
                  shape: BoxShape.circle,

                  border: Border.all(
                    color: chat.hasGreenRing
                        ? const Color(
                            0xFF25D366,
                          )
                        : chat.hasGreyRing
                            ? Colors.grey
                            : Colors.transparent,

                    width:
                        (chat.hasGreenRing ||
                                chat
                                    .hasGreyRing)
                            ? 2
                            : 0,
                  ),
                ),

                child: CircleAvatar(
                  radius: 24,

                  backgroundColor:
                      chat.avatarColor,

                  backgroundImage:
                      chat.image.isNotEmpty
                          ? AssetImage(
                              chat.image,
                            )
                          : null,

                  child: chat.image.isEmpty
                      ? Icon(
                          Icons.person,
                          color:
                              _getIconColor(
                            chat.avatarColor,
                          ),
                          size: 24,
                        )
                      : null,
                ),
              ),

              // TIMER
              if (chat.isTimerOn)
                Positioned(
                  bottom: 0,
                  right: 0,

                  child: Container(
                    width: 15,
                    height: 15,

                    decoration:
                        const BoxDecoration(
                      color: Colors.white,
                      shape: BoxShape.circle,
                    ),

                    child: const Icon(
                      Icons.timer_outlined,
                      size: 10,
                      color: Colors.grey,
                    ),
                  ),
                ),
            ],
          ),

          const SizedBox(width: 12),

          // CONTENT
          Expanded(
            child: Column(
              crossAxisAlignment:
                  CrossAxisAlignment.start,

              children: [

                // NAME
                Row(
                  mainAxisSize:
                      MainAxisSize.min,

                  children: [

                    Flexible(
                      child: Text(
                        chat.name,
                        maxLines: 1,
                        overflow:
                            TextOverflow
                                .ellipsis,

                        style:
                            const TextStyle(
                          fontSize: 14,
                          fontWeight:
                              FontWeight.bold,
                          color:
                              Colors.black,
                          height: 1.0,
                        ),
                      ),
                    ),

                    // LIPS
                    if (chat.hasLips)
                      Padding(
                        padding:
                            const EdgeInsets.only(
                          left: 3,
                        ),

                        child: Image.asset(
                          'assets/icons/emoji bibir.png',
                          width: 20,
                          height: 20,
                          fit:
                              BoxFit.contain,
                        ),
                      ),
                  ],
                ),

                const SizedBox(height: 2),

                // MESSAGE ROW
                Row(
                  crossAxisAlignment:
                      CrossAxisAlignment.center,

                  children: [

                    // DOUBLE CHECK
                    if (chat.hasDoubleCheck)
                      const Padding(
                        padding:
                            EdgeInsets.only(
                          right: 4,
                        ),

                        child: Icon(
                          Icons.done_all,
                          size: 13,
                          color: Colors.grey,
                        ),
                      ),

                    // STICKER
                      if (chat.isSticker)
                        Padding(
                          padding: EdgeInsets.only(
                            right: 4,

                            // KHUSUS GROUP
                            top: chat.isGroup ? 1.5 : 0,
                          ),

                          child: Image.asset(
                            'assets/icons/sticker.png',
                            width: 20,
                            height: 20,
                            fit: BoxFit.contain,
                          ),
                        ),

                    // REPLY
                    if (chat.isReply)
                      Padding(
                        padding:
                            const EdgeInsets.only(
                          right: 4,
                        ),

                        child: Container(
                          width: 13,
                          height: 13,

                          decoration:
                              BoxDecoration(
                            border: Border.all(
                              color:
                                  Colors.grey,
                              width: 1,
                            ),

                            shape:
                                BoxShape.circle,
                          ),

                          child: const Center(
                            child: Icon(
                              Icons
                                  .reply_rounded,
                              size: 7,
                              color:
                                  Colors.grey,
                            ),
                          ),
                        ),
                      ),

                    // MESSAGE
                    Flexible(
                      child: Text(
                        chat.message,
                        maxLines: 1,
                        overflow:
                            TextOverflow
                                .ellipsis,

                        style:
                            const TextStyle(
                          fontSize: 12,
                          color: AppColors
                              .textSecondary,
                          height: 1.0,
                        ),
                      ),
                    ),
                  ],
                ),
              ],
            ),
          ),

          const SizedBox(width: 8),

          // RIGHT
          Column(
            crossAxisAlignment:
                CrossAxisAlignment.end,

            children: [

              // TIME
              Text(
                chat.time,

                style: TextStyle(
                  fontSize: 10,

                  fontWeight:
                      chat.unreadCount > 0
                          ? FontWeight.bold
                          : FontWeight.normal,

                  color:
                      chat.unreadCount > 0
                          ? Colors.black
                          : AppColors.timeGrey,
                ),
              ),

              const SizedBox(height: 6),

              Row(
                mainAxisSize:
                    MainAxisSize.min,

                children: [

                  // PIN
                  if (chat.isPinned)
                    const Padding(
                      padding:
                          EdgeInsets.only(
                        right: 4,
                      ),

                      child: Icon(
                        Icons.push_pin,
                        size: 13,
                        color: Colors.grey,
                      ),
                    ),

                  // MUTE
                  if (chat.isMuted)
                    Padding(
                      padding:
                          const EdgeInsets.only(
                        right: 2,
                      ),

                      child: Image.asset(
                        'assets/icons/mute.png',
                        width: 20,
                        height: 20,
                        fit:
                            BoxFit.contain,
                      ),
                    ),

                  // UNREAD
                  if (chat.unreadCount > 0)
                    Container(
                      width: 20,
                      height: 20,

                      decoration:
                          const BoxDecoration(
                        color: AppColors
                            .unreadGreen,
                        shape:
                            BoxShape.circle,
                      ),

                      alignment:
                          Alignment.center,

                      child: Text(
                        chat.unreadCount
                            .toString(),

                        style:
                            const TextStyle(
                          color:
                              Colors.white,
                          fontSize: 10,
                          fontWeight:
                              FontWeight.bold,
                        ),
                      ),
                    ),
                ],
              ),
            ],
          ),
        ],
      ),
    );
  }

  Color _getIconColor(
    Color bgColor,
  ) {

    if (bgColor ==
        const Color(
          0xffF8BBD0,
        )) {
      return const Color(
        0xffD81B60,
      );
    }

    if (bgColor ==
        const Color(
          0xffBBDEFB,
        )) {
      return const Color(
        0xff1565C0,
      );
    }

    if (bgColor ==
        const Color(
          0xffC8E6C9,
        )) {
      return const Color(
        0xff00897B,
      );
    }

    return Colors.white;
  }
}
