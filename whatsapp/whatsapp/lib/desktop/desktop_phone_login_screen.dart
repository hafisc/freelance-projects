import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';

import '../mobile/mobile_welcome_screen.dart';
import '../models/login_data.dart';
import 'desktop_code_screen.dart';
import 'desktop_login_screen.dart';

class DesktopPhoneLoginScreen
    extends StatefulWidget {
  const DesktopPhoneLoginScreen({
    super.key,
  });

  @override
  State<DesktopPhoneLoginScreen>
      createState() =>
          _DesktopPhoneLoginScreenState();
}

class _DesktopPhoneLoginScreenState
    extends State<
        DesktopPhoneLoginScreen> {
  final TextEditingController
      phoneController =
      TextEditingController();

  // =====================================================
  // COUNTRY LIST
  // =====================================================

  final List<Map<String, String>>
      countries = [
    {
      "name": "Indonesia",
      "code": "+62",
      "flag": "🇮🇩",
    },
    {
      "name": "United States",
      "code": "+1",
      "flag": "🇺🇸",
    },
    {
      "name": "Malaysia",
      "code": "+60",
      "flag": "🇲🇾",
    },
    {
      "name": "Singapore",
      "code": "+65",
      "flag": "🇸🇬",
    },
  ];

  late Map<String, String>
      selectedCountry;

  @override
  void initState() {
    super.initState();

    selectedCountry = countries[0];
  }

  // =====================================================
  // COLORS
  // =====================================================

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

  // =====================================================
  // MOBILE CONTENT
  // =====================================================

  Widget _buildMobileContent(
    BuildContext context,
  ) {
    return const WhatsAppBusinessOnboarding();
  }

  // =====================================================
  // DESKTOP CONTENT
  // =====================================================

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
            // HEADER LOGO
            // =====================================

            buildHeaderLogo(),

            const SizedBox(height: 34),

            // =====================================
            // CENTER CONTENT
            // =====================================

            Center(
              child: Column(
                children: [
                  buildDownloadCard(),

                  const SizedBox(
                    height: 12,
                  ),

                  buildMainCard(),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }

  // =====================================================
  // HEADER LOGO
  // =====================================================

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

  // =====================================================
  // DOWNLOAD CARD
  // =====================================================

  Widget buildDownloadCard() {
    return Container(
      width: 760,

      padding:
          const EdgeInsets.symmetric(
        horizontal: 26,
        vertical: 18,
      ),

      decoration: BoxDecoration(
        color: kCardBgColor,

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

            width: 44,
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

  // =====================================================
  // MAIN CARD
  // =====================================================

  Widget buildMainCard() {
    return Container(
      width: 760,

      padding:
          const EdgeInsets.symmetric(
        horizontal: 34,
        vertical: 30,
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
        children: [
          const Text(
            'Enter phone number',

            textAlign:
                TextAlign.center,

            style: TextStyle(
              color: kTextDark,
              fontSize: 24,
              fontWeight:
                  FontWeight.w400,
            ),
          ),

          const SizedBox(height: 6),

          const Text(
            'Select a country and enter your phone number.',

            style: TextStyle(
              color: kTextSecondary,
              fontSize: 13,
            ),
          ),

          const SizedBox(height: 24),

          // =====================================
          // COUNTRY DROPDOWN
          // =====================================

          Container(
            width: 390,
            height: 48,

            padding:
                const EdgeInsets.symmetric(
              horizontal: 18,
            ),

            decoration: BoxDecoration(
              borderRadius:
                  BorderRadius.circular(
                30,
              ),

              border: Border.all(
                color: const Color(
                  0xFF8696A0,
                ),
              ),
            ),

            child:
                DropdownButtonHideUnderline(
              child:
                  DropdownButton<
                      Map<String, String>>(
                value: selectedCountry,

                isExpanded: true,

                icon: const Icon(
                  Icons
                      .keyboard_arrow_down,
                  color: kTextDark,
                ),

                items:
                    countries.map(
                  (country) {
                    return DropdownMenuItem(
                      value: country,

                      child: Row(
                        children: [
                          Text(
                            country[
                                "flag"]!,

                            style:
                                const TextStyle(
                              fontSize:
                                  18,
                            ),
                          ),

                          const SizedBox(
                            width: 12,
                          ),

                          Text(
                            country[
                                "name"]!,
                          ),
                        ],
                      ),
                    );
                  },
                ).toList(),

                onChanged: (
                  value,
                ) {
                  setState(() {
                    selectedCountry =
                        value!;
                  });
                },
              ),
            ),
          ),

          const SizedBox(height: 12),

          // =====================================
          // PHONE INPUT
          // =====================================

          Container(
            width: 390,
            height: 48,

            padding:
                const EdgeInsets.symmetric(
              horizontal: 18,
            ),

            decoration: BoxDecoration(
              borderRadius:
                  BorderRadius.circular(
                30,
              ),

              border: Border.all(
                color: const Color(
                  0xFF8696A0,
                ),
              ),
            ),

            child: Row(
              children: [
                Text(
                  selectedCountry[
                      "code"]!,

                  style:
                      const TextStyle(
                    color: kTextDark,
                    fontSize: 15,
                  ),
                ),

                const SizedBox(width: 12),

                Container(
                  width: 1,
                  height: 20,
                  color: kBorderColor,
                ),

                const SizedBox(width: 12),

                Expanded(
                  child: TextField(
                    controller:
                        phoneController,

                    keyboardType:
                        TextInputType
                            .number,

                    inputFormatters: [
                      FilteringTextInputFormatter
                          .digitsOnly,
                    ],

                    decoration:
                        const InputDecoration(
                      border:
                          InputBorder.none,

                      hintText:
                          'Enter phone number',

                      hintStyle:
                          TextStyle(
                        color:
                            kTextSecondary,
                        fontSize: 13,
                      ),
                    ),
                  ),
                ),
              ],
            ),
          ),

          const SizedBox(height: 28),

          // =====================================
          // NEXT BUTTON
          // =====================================

          SizedBox(
            width: 84,
            height: 40,

            child: ElevatedButton(
              onPressed: () async {

                  final phone =
                      phoneController.text.trim();

                  if (phone.isEmpty) {
                    _showError(
                      "Nomor telepon wajib diisi",
                    );
                    return;
                  }

                  if (phone.length < 10) {
                    _showError(
                      "Nomor telepon minimal 10 digit",
                    );
                    return;
                  }

                  LoginData.phoneNumber =
                      "${selectedCountry["code"]}$phone";

                  debugPrint(
                    "LOGIN PHONE : ${LoginData.phoneNumber}",
                  );

                 final response = await http.post(
            Uri.parse(
              'http://localhost/project-231006/API/send_login_code.php',
            ),
            body: {
              'phone_number': LoginData.phoneNumber,
            },
          );

          final data = jsonDecode(response.body);

          if (data['success'] == true) {

            Navigator.push(
              context,
              MaterialPageRoute(
                builder: (_) =>
                    const DesktopCodeScreen(),
              ),
            );

} else {

  _showError(
    data['message'] ??
        'Gagal mengirim kode login',
  );

}
                },
                
              style:
                  ElevatedButton.styleFrom(
                backgroundColor:
                    kAccentGreen,

                foregroundColor:
                    Colors.black,

                elevation: 0,

                shape:
                    RoundedRectangleBorder(
                  borderRadius:
                      BorderRadius.circular(
                    24,
                  ),
                ),
              ),

              child: const Text(
                'Next',

                style: TextStyle(
                  fontSize: 13,
                  fontWeight:
                      FontWeight.w600,
                ),
              ),
            ),
          ),

          const SizedBox(height: 22),

          // =====================================
          // LOGIN QR
          // =====================================

          TextButton(
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
                    fontSize: 13,

                    decoration:
                        TextDecoration
                            .underline,
                  ),
                ),

                SizedBox(width: 8),

                Icon(
                  Icons.arrow_forward_ios,
                  size: 11,
                  color: kTextDark,
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}