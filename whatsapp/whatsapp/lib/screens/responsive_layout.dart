
import 'package:flutter/material.dart';

import '../mobile/mobile_welcome_screen.dart';
import '../desktop/desktop_login_screen.dart';

class ResponsiveLayout extends StatelessWidget {
  const ResponsiveLayout({super.key});

  @override
  Widget build(BuildContext context) {

    final width =
        MediaQuery.of(context).size.width;

    // MOBILE
    if (width < 800) {
      return const WhatsAppBusinessOnboarding();
    }

    // DESKTOP
    return const DesktopLoginScreen();
  }
}