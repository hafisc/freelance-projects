import 'package:flutter/material.dart';

class ChatModel {
  final String name;
  final String message;
  final String time;
  final String image;

  final int unreadCount;
  

  // CHAT SUDAH DIBACA
  final bool isSeen;

  final bool isPinned;
  final bool isMuted;
  final bool isSticker;
  final bool isGroup;
  final bool isTimerOn;

  // STATUS RING
  final bool hasGreenRing;
  final bool hasGreyRing;
  
  // DOUBLE CHECK
  final bool hasDoubleCheck;

  // REPLY CHAT
  final bool isReply;
  final String? replyName;

  // WARNA AVATAR
  final Color avatarColor;
  final bool hasLips;

  ChatModel({
    required this.name,
    required this.message,
    required this.time,
    required this.image,
    

    required this.unreadCount,

    // SEEN
    this.isSeen = false,

    required this.isPinned,
    required this.isMuted,
    required this.isSticker,
    required this.isTimerOn,

    // STATUS RING
    this.hasGreenRing = false,
    this.hasGreyRing = false,

    // DOUBLE CHECK
    this.hasDoubleCheck = false,
    this.isGroup = false,
    
    // REPLY
    this.isReply = false,
    this.replyName,
    this.hasLips = false,

    // DEFAULT AVATAR COLOR
    this.avatarColor = const Color(
      0xff42A5F5,
    ),

  });
}