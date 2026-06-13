import 'package:flutter/material.dart';

import '../mobile/mobile_welcome_screen.dart';
import 'desktop_phone_login_screen.dart';

class DesktopLoginScreen
    extends StatefulWidget {
  const DesktopLoginScreen({
    super.key,
  });

  @override
  State<DesktopLoginScreen>
      createState() =>
          _DesktopLoginScreenState();
}

class _DesktopLoginScreenState
    extends State<
        DesktopLoginScreen> {
  bool isChecked = true;

  // =========================================
  // COLORS
  // =========================================

  static const Color kBgColor =
      Color(0xFFF6F1EA);

  static const Color kCardBgColor =
      Colors.white;

  static const Color kTextDark =
      Color(0xFF111B21);

  static const Color kTextSecondary =
      Color(0xFF667781);

  static const Color kAccentGreen =
      Color(0xFF25D366);

  static const Color kBorderColor =
      Color(0xFFD1D7DB);

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

            const SizedBox(height: 40),

            // =====================================
            // CENTER CONTENT
            // =====================================

            Center(
              child: Column(
                children: [
                  // DOWNLOAD CARD

                  buildDownloadCard(),

                  const SizedBox(
                    height: 16,
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
  // HEADER LOGO
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

            width: 26,
          ),

          const SizedBox(width: 8),

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
      width: 760,

      padding:
          const EdgeInsets.symmetric(
        horizontal: 24,
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

                SizedBox(height: 4),

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
              horizontal: 28,
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
      width: 760,

      padding:
          const EdgeInsets.symmetric(
        horizontal: 36,
        vertical: 36,
      ),

      decoration: BoxDecoration(
        color: kCardBgColor,

        borderRadius:
            BorderRadius.circular(
          26,
        ),

        border: Border.all(
          color: kBorderColor,
        ),
      ),

      child: Row(
        crossAxisAlignment:
            CrossAxisAlignment.start,

        children: [
          // =================================
          // LEFT SIDE
          // =================================

          Expanded(
            flex: 5,

            child: Column(
              crossAxisAlignment:
                  CrossAxisAlignment
                      .start,

              children: [
                const Text(
                  'Scan to log in',

                  style: TextStyle(
                    color: kTextDark,
                    fontSize: 24,
                    fontWeight:
                        FontWeight.w400,
                  ),
                ),

                const SizedBox(height: 28),

                buildStepItem(
                  number: 1,

                  text:
                      'Scan the QR code with your phone\'s camera',
                ),

                buildStepItem(
                  number: 2,

                  text:
                      'Tap the link to open WhatsApp',
                ),

                buildStepItem(
                  number: 3,

                  text:
                      'Scan the QR code again to link to your account',

                  isLast: true,
                ),

                const SizedBox(height: 18),

                InkWell(
                  onTap: () {},

                  child: Row(
                    mainAxisSize:
                        MainAxisSize.min,

                    children: [
                      const Text(
                        'Need help?',

                        style: TextStyle(
                          color:
                              kTextSecondary,

                          fontSize: 14,

                          decoration:
                              TextDecoration
                                  .underline,
                        ),
                      ),

                      const SizedBox(width: 4),

                      const Icon(
                        Icons.arrow_outward,
                        size: 14,
                        color:
                            kTextSecondary,
                      ),
                    ],
                  ),
                ),

                const SizedBox(height: 28),

                InkWell(
                  onTap: () {
                    setState(() {
                      isChecked =
                          !isChecked;
                    });
                  },

                  child: Row(
                    children: [
                      Container(
                        width: 18,
                        height: 18,

                        decoration:
                            BoxDecoration(
                          color: isChecked
                              ? kAccentGreen
                              : Colors.white,

                          border: Border.all(
                            color: isChecked
                                ? kAccentGreen
                                : kTextSecondary,
                          ),

                          borderRadius:
                              BorderRadius.circular(
                            4,
                          ),
                        ),

                        child: isChecked
                            ? const Icon(
                                Icons.check,
                                color:
                                    Colors.white,
                                size: 12,
                              )
                            : null,
                      ),

                      const SizedBox(width: 12),

                      const Text(
                        'Stay logged in on this browser',

                        style: TextStyle(
                          color: kTextDark,
                          fontSize: 14,
                        ),
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ),

          const SizedBox(width: 40),

          // =================================
          // RIGHT SIDE
          // =================================

          Expanded(
            flex: 4,

            child: Column(
              children: [
                Container(
                  width: 220,
                  height: 220,

                  padding:
                      const EdgeInsets.all(
                    12,
                  ),

                  decoration:
                      BoxDecoration(
                    color: Colors.white,

                    border: Border.all(
                      color: kBorderColor,
                    ),

                    borderRadius:
                        BorderRadius.circular(
                      12,
                    ),
                  ),

                  child: Image.asset(
                    'assets/icons/barcode.JPG',

                    fit: BoxFit.contain,
                  ),
                ),

                const SizedBox(height: 24),

                TextButton(
                  onPressed: () {
                    Navigator.push(
                      context,

                      MaterialPageRoute(
                        builder:
                            (_) =>
                                const DesktopPhoneLoginScreen(),
                      ),
                    );
                  },

                  child: Row(
                    mainAxisSize:
                        MainAxisSize.min,

                    children: [
                      const Text(
                        'Log in with phone number',

                        style: TextStyle(
                          color: kTextDark,
                          fontSize: 14,

                          decoration:
                              TextDecoration
                                  .underline,
                        ),
                      ),

                      const SizedBox(width: 6),

                      const Icon(
                        Icons.arrow_forward_ios,
                        size: 12,
                        color: kTextDark,
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  // =========================================
  // STEP ITEM
  // =========================================

  Widget buildStepItem({
    required int number,
    required String text,
    bool isLast = false,
  }) {
    return Padding(
      padding:
          const EdgeInsets.only(
        bottom: 16,
      ),

      child: Row(
        crossAxisAlignment:
            CrossAxisAlignment.start,

        children: [
          Column(
            children: [
              Container(
                width: 24,
                height: 24,

                decoration: BoxDecoration(
                  shape: BoxShape.circle,

                  border: Border.all(
                    color:
                        const Color(
                      0xFF667781,
                    ),
                  ),
                ),

                child: Center(
                  child: Text(
                    number.toString(),

                    style:
                        const TextStyle(
                      fontSize: 12,
                      color: kTextDark,
                      fontWeight:
                          FontWeight.w600,
                    ),
                  ),
                ),
              ),

              if (!isLast)
                Container(
                  width: 1,
                  height: 40,

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

          const SizedBox(width: 14),

          Expanded(
            child: Padding(
              padding:
                  const EdgeInsets.only(
                top: 2,
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