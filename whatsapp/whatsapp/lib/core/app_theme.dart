import 'package:flutter/material.dart';

import 'app_colors.dart';

class AppTheme {
  static ThemeData darkTheme = ThemeData(
    brightness: Brightness.dark,

    scaffoldBackgroundColor: AppColors.background,

    appBarTheme: const AppBarTheme(
      backgroundColor: AppColors.appBar,
      elevation: 0,
    ),

    dividerColor: AppColors.divider,
  );
}