import 'package:flutter/material.dart';
import 'theme.dart';
import 'routes.dart';

class GloriaJobApp extends StatelessWidget {
  const GloriaJobApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Gloria Job',
      theme: AppTheme.lightTheme,
      debugShowCheckedModeBanner: false,
      onGenerateRoute: AppRoutes.generateRoute,
      // Kita akan memulai dari splash screen
      initialRoute: AppRoutes.splash,
    );
  }
}
