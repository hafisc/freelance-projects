import 'package:flutter/material.dart';
import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

import '../models/login_data.dart';
import '../mobile/mobile_welcome_screen.dart';
import '../screens/desktop_home_screen.dart';

class DesktopLoadingScreen
    extends StatefulWidget {
  const DesktopLoadingScreen({
    super.key,
  });


  @override
  State<DesktopLoadingScreen>
      createState() =>
          _DesktopLoadingScreenState();
}

class _DesktopLoadingScreenState
    extends State<
        DesktopLoadingScreen>
    with SingleTickerProviderStateMixin {
  late AnimationController
      _animationController;

  late Animation<double>
      _progressAnimation;

  // =========================================
  // COLORS
  // =========================================

  static const Color kBgColor =
      Color(0xFFF6F1EA);


  static const Color kTextDark =
      Color(0xFF3B4B56);

  static const Color kTextSecondary =
      Color(0xFF667781);

  static const Color kAccentGreen =
      Color(0xFF25D366);

  Future<void> loginUser() async {

  try {

    debugPrint(
      "PHONE : ${LoginData.phoneNumber}",
    );

    debugPrint(
      "LOGIN CODE : ${LoginData.loginCode}",
    );

    final response = await http.post(
      Uri.parse(
        'http://localhost/project-231006/API/login.php',
      ),
      headers: {
        'Content-Type': 'application/json',
      },
      body: jsonEncode({
        'phone_number':
            LoginData.phoneNumber,

        'login_code':
            LoginData.loginCode,
      }),
    );

    debugPrint(
      response.body,
    );

    final result =
        jsonDecode(response.body);

   if (result['success'] == true) {

  final prefs =
      await SharedPreferences.getInstance();

  await prefs.setInt(
    "id_user",
    result["user"]["id_user"],
  );

  await prefs.setString(
    "phone_number",
    result["user"]["phone_number"],
  );

  await prefs.setString(
    "business_name",
    result["user"]["business_name"] ?? "",
  );

  debugPrint(
    "DESKTOP ID USER : ${result["user"]["id_user"]}",
  );

  if (!mounted) return;

  Navigator.pushReplacement(
    context,
    MaterialPageRoute(
      builder: (_) =>
          const DesktopHomeScreen(),
    ),
  );
} else {

      if (!mounted) return;

      ScaffoldMessenger.of(context)
          .showSnackBar(
        SnackBar(
          content: Text(
            result['message'],
          ),
        ),
      );
    }

  } catch (e) {

    debugPrint(
      'LOGIN ERROR : $e',
    );
  }
}
  @override
  void initState() {
    super.initState();

    // =====================================
    // ANIMATION
    // =====================================

    _animationController =
        AnimationController(
      vsync: this,

      duration:
          const Duration(seconds: 8),
    );

    _progressAnimation =
        Tween<double>(
      begin: 0.0,
      end: 1.0,
    ).animate(
      CurvedAnimation(
        parent:
            _animationController,

        curve: Curves.linear,
      ),
    );

    _animationController
        .addListener(() {
      setState(() {});
    });

    _animationController.forward();
    loginUser();
  }

  @override
  void dispose() {
    _animationController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    final progress =
        _progressAnimation.value;

    return LayoutBuilder(
      builder: (
        context,
        constraints,
      ) {
        final isDesktop =
            constraints.maxWidth >= 768;

        return Scaffold(
          backgroundColor:
              isDesktop
                  ? kBgColor
                  : const Color(
                      0xFF0B141A,
                    ),

          body: SafeArea(
            child: isDesktop
                ? _buildDesktopContent(
                    context,
                    progress,
                  )
                : _buildMobileContent(
                    context,
                  ),
          ),
        );
      },
    );
  }

  // =========================================
  // MOBILE CONTENT
  // =========================================

  Widget _buildMobileContent(
    BuildContext context,
  ) {
    return const WhatsAppBusinessOnboarding();
  }

  // =========================================
  // DESKTOP CONTENT
  // =========================================

  Widget _buildDesktopContent(
    BuildContext context,
    double progress,
  ) {
    return Center(
      child: Column(
        mainAxisAlignment:
            MainAxisAlignment.center,

        children: [
          // =====================================
          // WHATSAPP LOGO
          // =====================================

          Image.asset(
            'assets/icons/whatsapp_loading.png',

            width: 64,
            height: 64,

            fit: BoxFit.contain,
          ),

          const SizedBox(height: 18),

          // =====================================
          // WHATSAPP TEXT
          // =====================================

          const Text(
            'WhatsApp',

            style: TextStyle(
              color: kTextDark,
              fontSize: 24,
              fontWeight:
                  FontWeight.w400,
              letterSpacing: 0.4,
            ),
          ),

          const SizedBox(height: 28),

          // =====================================
          // LOADING BAR
          // =====================================

          SizedBox(
            width: 220,

            child: Container(
              height: 4,

              decoration: BoxDecoration(
                color:
                    const Color(
                  0xFFE4E6E8,
                ),

                borderRadius:
                    BorderRadius.circular(
                  20,
                ),
              ),

              child: Align(
                alignment:
                    Alignment.centerLeft,

                child:
                    FractionallySizedBox(
                  widthFactor:
                      progress,

                  child: Container(
                    decoration:
                        BoxDecoration(
                      color:
                          kAccentGreen,

                      borderRadius:
                          BorderRadius.circular(
                        20,
                      ),
                    ),
                  ),
                ),
              ),
            ),
          ),

          const SizedBox(height: 34),

          // =====================================
          // ENCRYPT TEXT
          // =====================================

          Row(
            mainAxisSize:
                MainAxisSize.min,

            children: [
              const Icon(
                Icons.lock_outline,

                color:
                    kTextSecondary,

                size: 13,
              ),

              const SizedBox(width: 6),

              const Text(
                'End-to-end encrypted',

                style: TextStyle(
                  color:
                      kTextSecondary,

                  fontSize: 12,
                  fontWeight:
                      FontWeight.w400,
                ),
              ),
            ],
          ),
        ],
      ),
    );
  }
}