import 'package:flutter/material.dart';
import '../data/chat_model.dart';

class MobileChatTile extends StatelessWidget {
  final ChatModel chat;

  const MobileChatTile({
    super.key,
    required this.chat,
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.only(
        left: 16,
        right: 14,
        top: 10,
        bottom: 10,
      ),

      child: Row(
        crossAxisAlignment:
            CrossAxisAlignment.start,

        children: [

          // PROFILE
          Stack(
            children: [

              Container(
                padding:
                    const EdgeInsets.all(2),

                decoration: BoxDecoration(
                  shape: BoxShape.circle,

                  border: Border.all(
                    color: chat.hasGreenRing
                        ? const Color(
                            0xff25D366,
                          )
                        : chat.hasGreyRing
                            ? Colors.grey
                            : Colors.transparent,

                    width: (chat.hasGreenRing ||
                            chat.hasGreyRing)
                        ? 2
                        : 0,
                  ),
                ),

                child: CircleAvatar(
                  radius: 29,

                  backgroundColor:
                      chat.avatarColor,

                  backgroundImage:
                      chat.image.isNotEmpty
                          ? AssetImage(
                              chat.image,
                            )
                          : null,

                  child: chat.image.isEmpty
                      ? Text(
                          chat.name[0]
                              .toUpperCase(),

                          style:
                              const TextStyle(
                            color:
                                Colors.white,
                            fontSize: 24,
                            fontWeight:
                                FontWeight.bold,
                          ),
                        )
                      : null,
                ),
              ),

              // TIMER
              if (chat.isTimerOn)
                Positioned(
                  right: 0,
                  bottom: 0,

                  child: Container(
                    width: 18,
                    height: 18,

                    decoration: BoxDecoration(
                      color: const Color(
                        0xff0B141A,
                      ),
                      borderRadius:
                          BorderRadius.circular(
                        20,
                      ),
                    ),

                    child: const Icon(
                      Icons.timer_outlined,
                      color: Colors.grey,
                      size: 11,
                    ),
                  ),
                ),
            ],
          ),

          const SizedBox(width: 14),

          // CONTENT
          Expanded(
            child: Padding(
              padding:
                  const EdgeInsets.only(
                top: 2,
              ),

              child: Column(
                crossAxisAlignment:
                    CrossAxisAlignment.start,

                children: [

                  // TOP ROW
                  Row(
                    crossAxisAlignment:
                        CrossAxisAlignment
                            .start,

                    children: [

                      // NAME
                      Expanded(
                        child: Row(
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
                                  color:
                                      Colors.white,
                                  fontSize: 15,
                                  fontWeight:
                                      FontWeight.bold,
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
                                  top: 1,
                                ),

                                child:
                                    Image.asset(
                                  'assets/icons/emoji bibir.png',
                                  width: 20,
                                  height: 20,
                                  fit: BoxFit.contain,
                                ),
                              ),
                          ],
                        ),
                      ),

                      const SizedBox(width: 8),

                      // DATE
                      Text(
                        chat.time,

                        style: TextStyle(
                          fontSize: 11,

                          fontWeight:
                              chat.unreadCount >
                                      0
                                  ? FontWeight
                                      .bold
                                  : FontWeight
                                      .normal,

                          color:
                              chat.unreadCount >
                                      0
                                  ? const Color(
                                      0xff25D366,
                                    )
                                  : const Color(
                                      0xff8696A0,
                                    ),
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

                      // LEFT SIDE
                      Expanded(
                        child: Row(
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
                                  size: 16,
                                  color: Color(
                                    0xff8696A0,
                                  ),
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
                                    border:
                                        Border.all(
                                      color:
                                          const Color(
                                        0xff8696A0,
                                      ),
                                      width: 1,
                                    ),

                                    shape:
                                        BoxShape.circle,
                                  ),

                                  child:
                                      const Center(
                                    child: Icon(
                                      Icons
                                          .reply_rounded,
                                      size: 7,
                                      color:
                                          Color(
                                        0xff8696A0,
                                      ),
                                    ),
                                  ),
                                ),
                              ),

                            // MESSAGE + STICKER
                            Expanded(
                              child: Row(
                                crossAxisAlignment:
                                    CrossAxisAlignment.center,

                                children: [

                                  // NORMAL MESSAGE
                                  if (!chat.isSticker)
                                    Flexible(
                                      child: Text(
                                        chat.message,
                                        maxLines: 1,
                                        overflow:
                                            TextOverflow
                                                .ellipsis,

                                        style:
                                            const TextStyle(
                                          color:
                                              Color(
                                            0xff8696A0,
                                          ),
                                          fontSize:
                                              13,
                                          fontWeight:
                                              FontWeight
                                                  .w400,
                                          height:
                                              1.1,
                                        ),
                                      ),
                                    ),

                                  // STICKER MESSAGE
                                  if (chat.isSticker)
                                    Flexible(
                                      child: Row(
                                        mainAxisSize:
                                            MainAxisSize
                                                .min,

                                        crossAxisAlignment:
                                            CrossAxisAlignment
                                                .center,

                                        children: [

                                          // PREFIX
                                          if (chat
                                              .message
                                              .isNotEmpty)
                                            Text(
                                              '${chat.message} ',

                                              style:
                                                  const TextStyle(
                                                color:
                                                    Color(
                                                  0xff8696A0,
                                                ),
                                                fontSize:
                                                    13,
                                                fontWeight:
                                                    FontWeight
                                                        .w400,
                                                height:
                                                    1.1,
                                              ),
                                            ),

                                          // STICKER ICON
                                          Padding(
                                            padding:
                                                const EdgeInsets.only(
                                              right:
                                                  4,
                                              top:
                                                  1,
                                            ),

                                            child:
                                                Image.asset(
                                              'assets/icons/sticker.png',
                                              width:  20, 
                                              height:20,
                                              fit: BoxFit
                                                  .contain,
                                            ),
                                          ),

                                          // STICKER TEXT
                                          const Text(
                                            'Sticker',

                                            style:
                                                TextStyle(
                                              color:
                                                  Color(
                                                0xff8696A0,
                                              ),
                                              fontSize:
                                                  13,
                                              fontWeight:
                                                  FontWeight
                                                      .w400,
                                              height:
                                                  1.1,
                                            ),
                                          ),
                                        ],
                                      ),
                                    ),
                                ],
                              ),
                            ),
                          ],
                        ),
                      ),

                      const SizedBox(width: 8),

                      // RIGHT SIDE
                      Row(
                        mainAxisSize:
                            MainAxisSize.min,

                        crossAxisAlignment:
                            CrossAxisAlignment
                                .center,

                        children: [

                          // PIN
                          if (chat.isPinned)
                            const Padding(
                              padding:
                                  EdgeInsets.only(
                                right: 6,
                              ),

                              child: Icon(
                                Icons.push_pin,
                                size: 14,
                                color: Color(
                                  0xff8696A0,
                                ),
                              ),
                            ),

                          // MUTE
                          if (chat.isMuted)
                            Padding(
                              padding:
                                  const EdgeInsets.only(
                                right: 6,
                              ),

                              child: Image.asset(
                                'assets/icons/mute_mobile.png',
                                width: 20,
                                height: 20,
                                fit: BoxFit.contain,
                              ),
                            ),

                          // UNREAD BADGE
                          if (chat.unreadCount >
                              0)
                            Container(
                              width: 21,
                              height: 21,

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

                              child: Text(
                                chat.unreadCount
                                    .toString(),

                                style:
                                    const TextStyle(
                                  color:
                                      Colors.black,
                                  fontSize: 11,
                                  fontWeight:
                                      FontWeight
                                          .bold,
                                ),
                              ),
                            ),
                        ],
                      ),
                    ],
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