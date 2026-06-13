import 'package:flutter/material.dart';
import 'mobile_input_screen.dart';
import '../models/business_registration.dart';
import 'mobile_verify_screen.dart';

class WhatsAppNumberScreen extends StatelessWidget {
  const WhatsAppNumberScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return LayoutBuilder(
      builder: (context, constraints) {
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

  // ================= MOBILE LAYOUT =================

  Widget _buildMobileContent(
    BuildContext context,
  ) {
    return SingleChildScrollView(
      child: Padding(
        padding:
            const EdgeInsets.symmetric(
          horizontal: 24.0,
        ),

        child: Column(
          mainAxisAlignment:
              MainAxisAlignment.center,

          crossAxisAlignment:
              CrossAxisAlignment.center,

          children: [
            const SizedBox(height: 40),

            // ================= TITLE =================

            const Text(
              'Gunakan +62',

              textAlign:
                  TextAlign.center,

              style: TextStyle(
                color: Colors.white,
                fontSize: 27,
                fontWeight:
                    FontWeight.w500,
                height: 1.4,
              ),
            ),

            const Text(
              '852-4232-4669 untuk',

              textAlign:
                  TextAlign.center,

              style: TextStyle(
                color: Colors.white,
                fontSize: 27,
                fontWeight:
                    FontWeight.w500,
                height: 1.4,
              ),
            ),

            const Text(
              'WhatsApp Business?',

              textAlign:
                  TextAlign.center,

              style: TextStyle(
                color: Colors.white,
                fontSize: 27,
                fontWeight:
                    FontWeight.w500,
                height: 1.4,
              ),
            ),

            const SizedBox(height: 22),

            // ================= SUBTITLE =================

            const Padding(
              padding:
                  EdgeInsets.symmetric(
                horizontal: 12.0,
              ),

              child: Text(
                'Riwayat chat dan media akan otomatis dipindahkan ke aplikasi WhatsApp Business',

                textAlign:
                    TextAlign.center,

                style: TextStyle(
                  color: Color(
                    0xFFABB4BD,
                  ),
                  fontSize: 15,
                  height: 1.4,
                ),
              ),
            ),

            const SizedBox(height: 18),

            // ================= RICH TEXT =================

            RichText(
              textAlign:
                  TextAlign.center,

              text: const TextSpan(
                style: TextStyle(
                  fontSize: 13,
                  height: 1.5,
                ),

                children: [
                  TextSpan(
                    text:
                        'Profil WhatsApp Business Anda akan bersifat publik.',

                    style: TextStyle(
                      color: Color(
                        0xFFABB4BD,
                      ),

                      fontWeight:
                          FontWeight
                              .w400,
                    ),
                  ),

                  TextSpan(text: ' '),

                  TextSpan(
                    text:
                        'Pelajari selengkapnya.',

                    style: TextStyle(
                      color: Color(
                        0xFF53BDEB,
                      ),

                      fontWeight:
                          FontWeight
                              .w500,
                    ),
                  ),
                ],
              ),
            ),

            const SizedBox(height: 38),

            // ================= LOGO =================

            Center(
              child: Image.asset(
                'assets/icons/logo_register2.png',

                width: 190,

                fit: BoxFit.contain,

                errorBuilder: (
                  context,
                  error,
                  stackTrace,
                ) {
                  return Container(
                    width: 190,
                    height: 190,

                    color:
                        Colors.grey[800],

                    child: const Icon(
                      Icons.business,
                      size: 90,
                      color:
                          Colors.white54,
                    ),
                  );
                },
              ),
            ),

            const SizedBox(height: 35),

            // ================= BUTTON 1 =================

            SizedBox(
              width: double.infinity,
              height: 58,

              child: ElevatedButton(
              onPressed: () {
                 BusinessRegistration.phoneNumber =
                "85242324669";

            Navigator.pushReplacement(
              context,
              MaterialPageRoute(
                builder: (context) =>
                    const MobileVerifyScreen(),
              ),
            );
          },

                style:
                    ElevatedButton.styleFrom(
                  backgroundColor:
                      Colors.white,

                  foregroundColor:
                      Colors.black,

                  elevation: 0,

                  shape:
                      RoundedRectangleBorder(
                    borderRadius:
                        BorderRadius.circular(
                      30,
                    ),
                  ),
                ),

                child: const Text(
                  'Gunakan +62 852-4232-4669',

                  textAlign:
                      TextAlign.center,

                  style: TextStyle(
                    fontSize: 17,
                    fontWeight:
                        FontWeight.w600,
                  ),
                ),
              ),
            ),

            const SizedBox(height: 14),

            // ================= BUTTON 2 =================

            SizedBox(
              width: double.infinity,
              height: 58,

              child: OutlinedButton(
                onPressed: () {
                  Navigator.pushReplacement(
                    context,

                    MaterialPageRoute(
                      builder:
                          (context) =>
                              const MobileInputScreen(),
                    ),
                  );
                },

                style:
                    OutlinedButton.styleFrom(
                  backgroundColor:
                      Colors.transparent,

                  foregroundColor:
                      const Color(
                    0xFF25D366,
                  ),

                  side: const BorderSide(
                    color: Color(
                      0xFF3D4C53,
                    ),
                    width: 1.2,
                  ),

                  shape:
                      RoundedRectangleBorder(
                    borderRadius:
                        BorderRadius.circular(
                      30,
                    ),
                  ),
                ),

                child: const Text(
                  'Gunakan nomor lain',

                  textAlign:
                      TextAlign.center,

                  style: TextStyle(
                    fontSize: 17,
                    fontWeight:
                        FontWeight.w600,
                  ),
                ),
              ),
            ),

            const SizedBox(height: 40),
          ],
        ),
      ),
    );
  }

  // ================= DESKTOP LAYOUT =================

  Widget _buildDesktopContent(
    BuildContext context,
  ) {
    return Center(
      child: Container(
        width: 420,

        padding:
            const EdgeInsets.all(32),

        decoration: BoxDecoration(
          color:
              const Color(0xFF0B141A),

          borderRadius:
              BorderRadius.circular(
            12,
          ),
        ),

        child: _buildMobileContent(
          context,
        ),
      ),
    );
  }
}