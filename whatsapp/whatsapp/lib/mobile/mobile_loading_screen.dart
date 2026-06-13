import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:shared_preferences/shared_preferences.dart';

import '../models/business_registration.dart';
import '../desktop/desktop_login_screen.dart';
import '../screens/mobile_home_screen.dart';

class MobileLoadingScreen
    extends StatefulWidget {
  const MobileLoadingScreen({
    super.key,
  });

  @override
  State<MobileLoadingScreen>
      createState() =>
          _MobileLoadingScreenState();
}

class _MobileLoadingScreenState
    extends State<
        MobileLoadingScreen> {
          Future<void> registerUser() async {
  try {
    final response = await http.post(
      Uri.parse(
        'http://localhost/project-231006/API/register.php',
      ),
      headers: {
        'Content-Type': 'application/json',
      },
      body: jsonEncode({
        'phone_number': BusinessRegistration.phoneNumber,
        'otp_code': BusinessRegistration.otpCode,
        'business_name': BusinessRegistration.businessName,
        'category': BusinessRegistration.category,
        'business_hours': BusinessRegistration.businessHours,
        'schedule': BusinessRegistration.schedule,
        'profile_photo': BusinessRegistration.profilePhoto,
        'address': BusinessRegistration.address,
        'website': BusinessRegistration.website,
        'description': BusinessRegistration.description,
      }),
    );

    debugPrint(response.body);

    final result = jsonDecode(response.body);

          if (result['success'] == true) {

            final prefs =
    await SharedPreferences.getInstance();

await prefs.setInt(
  "id_user",
  result["id_user"],
);

await prefs.setString(
  "phone_number",
  result["phone_number"] ?? "",
);

await prefs.setString(
  "business_name",
  result["business_name"] ?? "",
);

          if (!mounted) return;

          final String loginCode =
              result['login_code'] ?? '';

          await showDialog(
        context: context,
        barrierDismissible: false,
        builder: (context) {
          return AlertDialog(
            insetPadding: const EdgeInsets.symmetric(
              horizontal: 120,
            ),

            title: const Text(
              'Login Desktop',
              textAlign: TextAlign.center,
            ),

            content: SizedBox(
              width: 180,
              child: Column(
                mainAxisSize: MainAxisSize.min,
                children: [
                  Text(
                    BusinessRegistration.phoneNumber,
                    textAlign: TextAlign.center,
                  ),

                  const SizedBox(height: 12),

                  Text(
                    loginCode,
                    textAlign: TextAlign.center,
                    style: const TextStyle(
                      fontSize: 22,
                      fontWeight: FontWeight.bold,
                      letterSpacing: 2,
                    ),
                  ),
                ],
              ),
            ),

      actions: [
        TextButton(
          onPressed: () {
            Navigator.pop(context);
          },
          child: const Text('OK'),
        ),
      ],
    );
  },
);

          if (!mounted) return;

          Navigator.pushReplacement(
            context,
            MaterialPageRoute(
              builder: (_) =>
                  const MobileHomeScreen(),
            ),
          );

        } else {

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
      'REGISTER ERROR : $e',
    );
  }
}

  @override
  void initState() {
    super.initState();

    _startLoadingTimer();
  }

  // ======================================================
  // PRECACHE IMAGE
  // ======================================================

  @override
  void didChangeDependencies() {
    super.didChangeDependencies();

    precacheImage(
      const AssetImage(
        'assets/icons/icon_whatsapp.jpg',
      ),
      context,
    );
  }

  // ======================================================
  // AUTO NAVIGATION
  // ======================================================

  void _startLoadingTimer() {
  Future.delayed(
    const Duration(seconds: 2),
    () {

      debugPrint(
        'PHONE : ${BusinessRegistration.phoneNumber}',
      );

      debugPrint(
        'OTP : ${BusinessRegistration.otpCode}',
      );

      debugPrint(
        'NAME : ${BusinessRegistration.businessName}',
      );

      debugPrint(
        'CATEGORY : ${BusinessRegistration.category}',
      );

      debugPrint(
        'HOURS : ${BusinessRegistration.businessHours}',
      );

      debugPrint(
        'SCHEDULE : ${BusinessRegistration.schedule}',
      );

      debugPrint(
        'PHOTO : ${BusinessRegistration.profilePhoto}',
      );

      debugPrint(
        'ADDRESS : ${BusinessRegistration.address}',
      );

      debugPrint(
        'WEBSITE : ${BusinessRegistration.website}',
      );

      debugPrint(
        'DESCRIPTION : ${BusinessRegistration.description}',
      );

      registerUser();

    },
  );
}

  @override
  Widget build(BuildContext context) {
    // STATUS BAR

    SystemChrome.setSystemUIOverlayStyle(
      const SystemUiOverlayStyle(
        statusBarColor:
            Color(0xFF0B141A),

        statusBarIconBrightness:
            Brightness.light,
      ),
    );

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
    return Center(
      child: ConstrainedBox(
        constraints:
            const BoxConstraints(
          maxWidth: 360,
        ),

        child: SizedBox(
          height:
              MediaQuery.of(context)
                  .size
                  .height,

          child: Column(
            crossAxisAlignment:
                CrossAxisAlignment
                    .start,

            children: [
              // ======================================================
              // TITLE
              // ======================================================

              Padding(
                padding:
                    EdgeInsets.only(
                  left: 35,
                  top:
                      MediaQuery.of(
                                context,
                              )
                              .padding
                              .top +
                          80,
                ),

                child: const Text(
                  'Menyelesaikan penyiapan',

                  style: TextStyle(
                    color:
                        Colors.white,

                    fontSize: 34,

                    fontWeight:
                        FontWeight.w500,

                    height: 1.2,
                  ),
                ),
              ),

              // ======================================================
              // CENTER AREA
              // ======================================================

              const Spacer(),

              // ======================================================
              // IMAGE
              // ======================================================

              Center(
                child: Image.asset(
                  'assets/icons/icon_whatsapp.jpg',

                  width: 280,

                  fit: BoxFit.contain,

                  gaplessPlayback:
                      true,

                  filterQuality:
                      FilterQuality.high,

                  errorBuilder:
                      (
                        context,
                        error,
                        stackTrace,
                      ) {
                    return Container(
                      width: 280,
                      height: 280,

                      color:
                          Colors.grey[800],

                      child:
                          const Icon(
                        Icons.chat,

                        color:
                            Colors.white,

                        size: 150,
                      ),
                    );
                  },
                ),
              ),

              const SizedBox(
                height: 20,
              ),

              // ======================================================
              // LOADING
              // ======================================================

              Center(
                child: SizedBox(
                  width: 40,
                  height: 40,

                  child:
                      CircularProgressIndicator(
                    color:
                        const Color(
                      0xFF25D366,
                    ),

                    strokeWidth: 2.5,

                    backgroundColor:
                        Colors
                            .transparent,
                  ),
                ),
              ),

              const Spacer(),
            ],
          ),
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