import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:shared_preferences/shared_preferences.dart';

import '../desktop/desktop_login_screen.dart';
import '../models/business_registration.dart';
import 'mobile_business_profile_screen.dart';


class MobileVerifyScreen extends StatefulWidget {
  const MobileVerifyScreen({super.key});

  @override
  State<MobileVerifyScreen> createState() =>
      _MobileVerifyScreenState();
}

class _MobileVerifyScreenState
    extends State<MobileVerifyScreen> {
  final TextEditingController _otpController =
      TextEditingController();

  // ================= COLORS =================

  static const Color kBgColor =
      Color(0xFF0B141A);

  static const Color kTextGrey =
      Color(0xFFA7AEB5);

  static const Color kBlue =
      Color(0xFF53BDEB);

  static const Color kGreen =
      Color(0xFF25D366);

  static const Color kWhite =
      Colors.white;

  @override
  void dispose() {
    _otpController.dispose();
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
  // ================= OTP CHECK =================
    Future<void> _checkOTP() async {
        final otp = _otpController.text.replaceAll(" ", "");

        if (otp.isEmpty) {
          _showError("Kode OTP wajib diisi");
          return;
        }

        if (otp.length != 6) {
          _showError("Kode OTP harus 6 digit");
          return;
        }

        if (!RegExp(r'^[0-9]{6}$').hasMatch(otp)) {
          _showError("Kode OTP hanya boleh angka");
          return;
        }

        BusinessRegistration.otpCode = otp;

              try {
        final response = await http.post(
          Uri.parse(
           'http://localhost/project-231006/API/verify_otp.php',
          ),
          body: {
            'phone_number':
                BusinessRegistration.phoneNumber,
            'otp_code': otp,
          },
        );

        final data =
            jsonDecode(response.body);

            print("VERIFY RESPONSE = $data");

       if (data['success'] == true) {

  final user = data["user"];

  final prefs =
      await SharedPreferences.getInstance();

  await prefs.setInt(
    "id_user",
    int.parse(
      user["id_user"].toString(),
    ),
  );

  await prefs.setString(
    "phone_number",
    user["phone_number"] ?? "",
  );

  await prefs.setString(
    "business_name",
    user["business_name"] ?? "",
  );

  await prefs.setString(
    "profile_photo",
    user["profile_photo"] ?? "",
  );

  Navigator.pushReplacement(
    context,
    MaterialPageRoute(
      builder: (context) =>
          const MobileBusinessProfileScreen(),
    ),
  );
} else {
          _showError(
            data['message'] ??
                'OTP tidak valid',
          );
        }
      } catch (e) {
  print("ERROR OTP: $e");

  _showError(
    'Gagal terhubung ke server',
  );
}
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
          backgroundColor: kBgColor,

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

  // ================= MOBILE =================

  Widget _buildMobileContent(
    BuildContext context,
  ) {
    return Center(
      child: ConstrainedBox(
        constraints:
            const BoxConstraints(
          maxWidth: 390,
        ),

        child: Padding(
          padding:
              const EdgeInsets.symmetric(
            horizontal: 28,
          ),

          child: Column(
            crossAxisAlignment:
                CrossAxisAlignment.start,

            children: [
              // ================= TOP =================

              Align(
                alignment:
                    Alignment.topRight,

                child: IconButton(
                  onPressed: () {},

                  icon: const Icon(
                    Icons.more_vert,
                    color: kWhite,
                    size: 30,
                  ),
                ),
              ),

              const SizedBox(height: 40),

              // ================= TITLE =================

              const Text(
                "Memverifikasi nomor Anda",

                style: TextStyle(
                  color: kTextGrey,
                  fontSize: 25,
                  fontWeight:
                      FontWeight.w400,
                  height: 1.2,
                ),
              ),

              const SizedBox(height: 26),

              // ================= SUBTITLE =================

              Center(
                child: Column(
                  children: [
                    const Text(
                      "Menunggu untuk mendeteksi secara otomatis",

                      textAlign:
                          TextAlign.center,

                      style: TextStyle(
                        color: kTextGrey,
                        fontSize: 14,
                        height: 1.4,
                      ),
                    ),

                    const Text(
                      "kode 6 digit yang dikirim melalui SMS ke",

                      textAlign:
                          TextAlign.center,

                      style: TextStyle(
                        color: kTextGrey,
                        fontSize: 16,
                        height: 1.4,
                      ),
                    ),

                    const SizedBox(
                      height: 10,
                    ),

                    // ================= NUMBER =================

                    Row(
                      mainAxisAlignment:
                          MainAxisAlignment
                              .center,

                      children: [
                                              Text(
                          BusinessRegistration.phoneNumber,
                          style: const TextStyle(
                            color: kWhite,
                            fontSize: 17,
                            fontWeight: FontWeight.w700,
                          ),
                        ),

                        const SizedBox(
                          width: 6,
                        ),

                        GestureDetector(
                          onTap: () {},

                          child: const Text(
                            "Nomor salah?",

                            style:
                                TextStyle(
                              color: kBlue,
                              fontSize: 17,
                              fontWeight:
                                  FontWeight
                                      .w700,
                            ),
                          ),
                        ),
                      ],
                    ),
                  ],
                ),
              ),

              const SizedBox(height: 70),

              // ================= OTP =================

              Center(
                child: SizedBox(
                  width: 280,

                  child: TextField(
                    controller:
                        _otpController,

                    keyboardType:
                        TextInputType
                            .number,

                    inputFormatters: [
                    FilteringTextInputFormatter.digitsOnly,
                    ],
                    
                    autofocus: true,

                    textAlign:
                        TextAlign.center,

                    maxLength: 7,

                    cursorColor: kWhite,

                    style:
                        const TextStyle(
                      color: kWhite,
                      fontSize: 36,
                      fontWeight:
                          FontWeight.w400,
                      letterSpacing: 12,
                    ),

                    decoration:
                        const InputDecoration(
                      counterText: "",

                      hintText:
                          "___   ___",

                      hintStyle:
                          TextStyle(
                        color: kWhite,
                        fontSize: 36,
                        letterSpacing: 8,
                        fontWeight:
                            FontWeight
                                .w300,
                      ),

                      enabledBorder:
                          UnderlineInputBorder(
                        borderSide:
                            BorderSide(
                          color: Color(
                            0xFF1F2C34,
                          ),
                          width: 2,
                        ),
                      ),

                      focusedBorder:
                          UnderlineInputBorder(
                        borderSide:
                            BorderSide(
                          color: Color(
                            0xFF1F2C34,
                          ),
                          width: 2,
                        ),
                      ),

                      contentPadding:
                          EdgeInsets.only(
                        bottom: 12,
                      ),
                    ),

                    onChanged: (value) {
                      if (value.length <
                          _otpController.text.length) {
                        _otpController.value =
                            TextEditingValue(
                          text: value,
                          selection:
                              TextSelection.collapsed(
                            offset: value.length,
                          ),
                        );
                      }

                      if (value.length == 3 &&
                          !value.contains(" ")) {
                        _otpController.text =
                            "$value ";

                        _otpController.selection =
                            TextSelection.fromPosition(
                          TextPosition(
                            offset:
                                _otpController.text.length,
                          ),
                        );
                      }

                      if (_otpController.text
                              .replaceAll(" ", "")
                              .length ==
                          6) {
                        _checkOTP();
                      }
                    },
                  ),
                ),
              ),

              const SizedBox(height: 70),

              // ================= HELP =================

              Center(
                child: GestureDetector(
                  onTap: () {},

                  child: const Text(
                    "Tidak menerima kode?",

                    style: TextStyle(
                      color: kGreen,
                      fontSize: 18,
                      fontWeight:
                          FontWeight.w700,
                    ),
                  ),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }

  // ================= DESKTOP =================

  Widget _buildDesktopContent(
    BuildContext context,
  ) {
    return const DesktopLoginScreen();
  }
}