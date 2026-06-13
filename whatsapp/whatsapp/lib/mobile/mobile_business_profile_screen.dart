import 'package:flutter/material.dart';

import '../desktop/desktop_login_screen.dart';
import '../models/business_registration.dart';
import 'mobile_category_screen.dart';

// ======================================================
// MAIN SCREEN
// ======================================================

class MobileBusinessProfileScreen
    extends StatefulWidget {
  const MobileBusinessProfileScreen({
    super.key,
  });

  @override
  State<MobileBusinessProfileScreen>
      createState() =>
          _MobileBusinessProfileScreenState();
}

class _MobileBusinessProfileScreenState
    extends State<
        MobileBusinessProfileScreen> {
  final TextEditingController
      _namaBisnisController =
      TextEditingController();

  bool _isButtonActive = false;

  @override
  void initState() {
    super.initState();

    _namaBisnisController.addListener(() {
      setState(() {
        _isButtonActive =
            _namaBisnisController
                .text
                .trim()
                .isNotEmpty;
      });
    });
  }

  @override
  void dispose() {
    _namaBisnisController.dispose();
    super.dispose();
  }

  void _showError(String message) {
  ScaffoldMessenger.of(context).showSnackBar(
    SnackBar(
      content: Text(message),
      backgroundColor: Colors.red,
    ),
  );
}

  @override
  Widget build(BuildContext context) {
    return LayoutBuilder(
      builder: (
        context,
        constraints,
      ) {
        final isMobile =
            constraints.maxWidth < 768;

        return Scaffold(
          backgroundColor:
              const Color(0xFF0B141A),

          body: SafeArea(
            child: isMobile
                ? _buildMobileContent(
                    context,
                  )
                : _buildDesktopContent(
                    context,
                  ),
          ),
        );
      },
    );
  }

  // ======================================================
  // MOBILE CONTENT
  // ======================================================

  Widget _buildMobileContent(
    BuildContext context,
  ) {
    return Padding(
      padding:
          const EdgeInsets.symmetric(
        horizontal: 24,
      ),

      child: SingleChildScrollView(
        child: Column(
          children: [
            const SizedBox(height: 18),

            // ======================================================
            // PROGRESS TOP
            // ======================================================

            Row(
              children: [
                Expanded(
                  child: Stack(
                    alignment:
                        Alignment.centerLeft,

                    children: [
                      // background line

                      Container(
                        height: 4,

                        decoration:
                            BoxDecoration(
                          color:
                              const Color(
                            0xFF1F2C34,
                          ),

                          borderRadius:
                              BorderRadius.circular(
                            20,
                          ),
                        ),
                      ),

                      // active line

                      FractionallySizedBox(
                        widthFactor: 0.17,

                        child: Container(
                          height: 4,

                          decoration:
                              BoxDecoration(
                            color:
                                Colors.white,

                            borderRadius:
                                BorderRadius.circular(
                              20,
                            ),
                          ),
                        ),
                      ),
                    ],
                  ),
                ),

                // titik kanan kecil

                Container(
                  margin:
                      const EdgeInsets.only(
                    left: 4,
                  ),

                  width: 7,
                  height: 7,

                  decoration:
                      const BoxDecoration(
                    color: Colors.white,
                    shape: BoxShape.circle,
                  ),
                ),
              ],
            ),

            const SizedBox(height: 42),

            // ======================================================
            // ICON
            // ======================================================

            Image.asset(
              'assets/icons/icon_register.png',

              width: 285,

              fit: BoxFit.contain,

              errorBuilder:
                  (
                    context,
                    error,
                    stackTrace,
                  ) {
                return Container(
                  width: 285,
                  height: 160,

                  decoration:
                      BoxDecoration(
                    color:
                        Colors.grey[900],

                    borderRadius:
                        BorderRadius.circular(
                      18,
                    ),
                  ),

                  child: const Icon(
                    Icons.storefront,
                    size: 80,
                    color:
                        Colors.white54,
                  ),
                );
              },
            ),

            const SizedBox(height: 34),

            // ======================================================
            // TITLE
            // ======================================================

            const Text(
              'Buat profil bisnis\nAnda',

              textAlign:
                  TextAlign.center,

              style: TextStyle(
                color: Colors.white,
                fontSize: 33,
                fontWeight:
                    FontWeight.w400,
                height: 1.18,
              ),
            ),

            const SizedBox(height: 20),

            // ======================================================
            // SUBTITLE
            // ======================================================

            const Text(
              'Beri tahu calon pelanggan\nmengenai bisnis Anda dengan profil\nprofesional yang mudah dibuat.',

              textAlign:
                  TextAlign.center,

              style: TextStyle(
                color: Color(
                  0xFFDFE5E7,
                ),
                fontSize: 16,
                height: 1.55,
              ),
            ),

            const SizedBox(height: 42),

            // ======================================================
            // INPUT
            // ======================================================

            TextField(
              controller:
                  _namaBisnisController,

              style: const TextStyle(
                color: Colors.white,
                fontSize: 18,
              ),

              cursorColor:
                  const Color(
                0xFF25D366,
              ),

              decoration:
                  InputDecoration(
                hintText:
                    'Nama bisnis',

                hintStyle:
                    const TextStyle(
                  color: Color(
                    0xFF8796A0,
                  ),
                  fontSize: 18,
                ),

                filled: true,

                fillColor:
                    Colors.transparent,

                contentPadding:
                    const EdgeInsets.symmetric(
                  horizontal: 24,
                  vertical: 22,
                ),

                enabledBorder:
                    OutlineInputBorder(
                  borderRadius:
                      BorderRadius.circular(
                    20,
                  ),

                  borderSide:
                      const BorderSide(
                    color:
                        Colors.white70,
                    width: 1.5,
                  ),
                ),

                focusedBorder:
                    OutlineInputBorder(
                  borderRadius:
                      BorderRadius.circular(
                    20,
                  ),

                  borderSide:
                      const BorderSide(
                    color: Color(
                      0xFF25D366,
                    ),
                    width: 2,
                  ),
                ),
              ),
            ),

            const SizedBox(height: 220),

            // ======================================================
            // INFO TEXT
            // ======================================================

            Column(
              children: [
                const Text(
                  'Profil WhatsApp Business Anda akan bersifat publik.',

                  textAlign:
                      TextAlign.center,

                  style: TextStyle(
                    color: Color(
                      0xFF879BA3,
                    ),
                    fontSize: 13,
                  ),
                ),

                const SizedBox(height: 2),

                GestureDetector(
                  onTap: () {},

                  child: const Text(
                    'Pelajari selengkapnya',

                    style: TextStyle(
                      color: Color(
                        0xFF53BDEB,
                      ),
                      fontSize: 13,
                      fontWeight:
                          FontWeight.w600,
                    ),
                  ),
                ),
              ],
            ),

            const SizedBox(height: 18),

            // ======================================================
            // BUTTON
            // ======================================================

            SizedBox(
              width: double.infinity,
              height: 62,

              child: ElevatedButton(
               onPressed: () {
                  if (_namaBisnisController.text
                      .trim()
                      .isEmpty) {
                    _showError(
                      "Nama bisnis wajib diisi",
                    );
                    return;
                  }

                BusinessRegistration.businessName =
                     _namaBisnisController.text.trim();

                  Navigator.pushReplacement(
                    context,
                    MaterialPageRoute(
                      builder: (context) =>
                          const MobileCategoryScreen(),
                    ),
                  );
                },

                style:
                    ElevatedButton.styleFrom(
                  backgroundColor:
                      _isButtonActive
                          ? const Color(
                              0xFF25D366,
                            )
                          : const Color(
                              0xFF1F2C34,
                            ),

                  disabledBackgroundColor:
                      const Color(
                    0xFF1F2C34,
                  ),

                  elevation: 0,

                  shape:
                      RoundedRectangleBorder(
                    borderRadius:
                        BorderRadius.circular(
                      32,
                    ),
                  ),
                ),

                child: Text(
                  'Berikutnya',

                  style: TextStyle(
                    fontSize: 18,
                    fontWeight:
                        FontWeight.w700,

                    color:
                        _isButtonActive
                            ? Colors.white
                            : const Color(
                                0xFF5D6D79,
                              ),
                  ),
                ),
              ),
            ),

            const SizedBox(height: 24),
          ],
        ),
      ),
    );
  }

  // ======================================================
  // DESKTOP CONTENT
  // ======================================================

  Widget _buildDesktopContent(
    BuildContext context,
  ) {
    return const DesktopLoginScreen();
  }
}