import 'package:flutter/material.dart';

class AvatarColors {

  static const List<Color> colors = [

    Color(0xff1F6FEB),
    Color(0xff7C3AED),
    Color(0xffDC2626),
    Color(0xff059669),
    Color(0xffEA580C),
    Color(0xff0891B2),
    Color(0xff9333EA),
    Color(0xffBE185D),
  ];

  static Color getColor(String name) {
    return colors[
      name.length % colors.length
    ];
  }
}