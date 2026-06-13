import 'dart:convert';
import 'package:http/http.dart' as http;

import 'package:flutter/material.dart';
import 'package:flutter/services.dart';

import '../desktop/desktop_login_screen.dart';
import '../models/business_registration.dart';
import 'mobile_verify_screen.dart';

class MobileInputScreen extends StatefulWidget {
  const MobileInputScreen({super.key});

  @override
  State<MobileInputScreen> createState() =>
      _MobileInputScreenState();
}

class _MobileInputScreenState
    extends State<MobileInputScreen> {
  // ======================================================
  // COUNTRY DATA
  // ======================================================

  final List<Map<String, String>> countries = [
    {
      'name': 'Indonesia',
      'code': '+62',
    },
    {
      'name': 'Malaysia',
      'code': '+60',
    },
    {
      'name': 'Singapore',
      'code': '+65',
    },
    {
      'name': 'Thailand',
      'code': '+66',
    },
    {
      'name': 'Japan',
      'code': '+81',
    },
    {
      'name': 'United States',
      'code': '+1',
    },
  ];

  int _selectedCountryIndex = 0;

  final TextEditingController
      _phoneController =
      TextEditingController();

  bool _isFilled = false;

  @override
  void initState() {
    super.initState();

    _phoneController.addListener(() {
      setState(() {
        _isFilled = _phoneController
            .text
            .trim()
            .isNotEmpty;
      });
    });
  }

  @override
  void dispose() {
    _phoneController.dispose();
    super.dispose();
  }

  // ======================================================
  // COUNTRY PICKER
  // ======================================================

  void _showCountryPicker() {
    showModalBottomSheet(
      context: context,

      backgroundColor:
          const Color(0xFF111B21),

      shape:
          const RoundedRectangleBorder(
        borderRadius:
            BorderRadius.vertical(
          top: Radius.circular(24),
        ),
      ),

      builder: (context) {
        return ListView.builder(
          itemCount: countries.length,

          itemBuilder: (context, index) {
            final country =
                countries[index];

            final isSelected =
                index ==
                    _selectedCountryIndex;

            return ListTile(
              title: Text(
                '${country['name']} (${country['code']})',

                style: TextStyle(
                  color: isSelected
                      ? const Color(
                          0xFF25D366,
                        )
                      : Colors.white,

                  fontSize: 16,

                  fontWeight: isSelected
                      ? FontWeight.w700
                      : FontWeight.w400,
                ),
              ),

              trailing: isSelected
                  ? const Icon(
                      Icons.check,
                      color: Color(
                        0xFF25D366,
                      ),
                    )
                  : null,

              onTap: () {
                setState(() {
                  _selectedCountryIndex =
                      index;
                });

                Navigator.pop(
                  context,
                );
              },
            );
          },
        );
      },
    );
  }

  // ======================================================
  // NEXT PAGE
  // ======================================================

        Future<void> _handleNext() async {
        final phone =
            _phoneController.text.trim();

        if (phone.isEmpty) {
          _showError(
            "Nomor telepon wajib diisi",
          );
          return;
        }

        if (!RegExp(r'^[0-9]+$')
            .hasMatch(phone)) {
          _showError(
            "Nomor telepon hanya boleh angka",
          );
          return;
        }

        if (phone.length < 10) {
          _showError(
            "Nomor telepon minimal 10 digit",
          );
          return;
        }

      BusinessRegistration.phoneNumber =
    countries[_selectedCountryIndex]['code']! +
    phone;

try {

  final response = await http.post(

    Uri.parse(
      'http://localhost/project-231006/API/send_otp.php',
    ),

    body: {
      'phone_number':
          BusinessRegistration.phoneNumber,
    },
  );

    print("STATUS CODE = ${response.statusCode}");
    print("RESPONSE BODY = ${response.body}");

  final result =
      jsonDecode(response.body);

  if (result['success'] == true) {

    Navigator.push(
      context,
      MaterialPageRoute(
        builder: (_) =>
            const MobileVerifyScreen(),
      ),
    );

  } else {

    _showError(
      result['message'],
    );

  }

} catch (e) {

  _showError(
    "Gagal terhubung ke server",
  );

}
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

        child: Padding(
          padding:
              const EdgeInsets.symmetric(
            horizontal: 28,
          ),

          child: Column(
            children: [
              const SizedBox(
                height: 58,
              ),

              // ======================================================
              // TITLE
              // ======================================================

              const Text(
                'Masukkan nomor\ntelepon Anda',

                textAlign:
                    TextAlign.center,

                style: TextStyle(
                  color: Colors.white,
                  fontSize: 34,
                  fontWeight:
                      FontWeight.w400,
                  height: 1.2,
                ),
              ),

              const SizedBox(
                height: 18,
              ),

              // ======================================================
              // SUBTITLE
              // ======================================================

              const Text(
                'WhatsApp perlu memverifikasi nomor\ntelepon Anda. Biaya operator mungkin\nberlaku.',

                textAlign:
                    TextAlign.center,

                style: TextStyle(
                  color: Color(
                    0xFF8796A0,
                  ),
                  fontSize: 14,
                  height: 1.5,
                ),
              ),

              const SizedBox(
                height: 24,
              ),

              // ======================================================
              // GREEN TEXT
              // ======================================================

              GestureDetector(
                onTap: () {},

                child: const Text(
                  'Berapa nomor telepon saya?',

                  style: TextStyle(
                    color: Color(
                      0xFF25D366,
                    ),
                    fontSize: 14,
                    fontWeight:
                        FontWeight.w600,
                  ),
                ),
              ),

              const SizedBox(
                height: 28,
              ),

              // ======================================================
              // COUNTRY PICKER
              // ======================================================

              GestureDetector(
                onTap:
                    _showCountryPicker,

                child: Column(
                  children: [
                    Row(
                      mainAxisAlignment:
                          MainAxisAlignment
                              .center,

                      children: [
                        Text(
                          countries[
                                  _selectedCountryIndex]
                              ['name']!,

                          style:
                              const TextStyle(
                            color:
                                Colors.white,
                            fontSize: 16,
                          ),
                        ),

                        const SizedBox(
                          width: 4,
                        ),

                        const Icon(
                          Icons
                              .arrow_drop_down,
                          color:
                              Colors.white,
                          size: 22,
                        ),
                      ],
                    ),

                    const SizedBox(
                      height: 10,
                    ),

                    Container(
                      height: 1.2,
                      color:
                          Colors.white,
                    ),
                  ],
                ),
              ),

              const SizedBox(
                height: 18,
              ),

              // ======================================================
              // PHONE INPUT
              // ======================================================

              Row(
                crossAxisAlignment:
                    CrossAxisAlignment.end,

                children: [
                  // CODE

                  SizedBox(
                    width: 50,

                    child: Column(
                      children: [
                        Text(
                          countries[
                                  _selectedCountryIndex]
                              ['code']!,

                          style:
                              const TextStyle(
                            color:
                                Colors.white,
                            fontSize: 16,
                          ),
                        ),

                        const SizedBox(
                          height: 10,
                        ),

                        Container(
                          height: 1.2,
                          color:
                              Colors.white,
                        ),
                      ],
                    ),
                  ),

                  const SizedBox(
                    width: 12,
                  ),

                  // INPUT

                  Expanded(
                    child: TextField(
                      controller:
                          _phoneController,

                      keyboardType:
                          TextInputType
                              .phone,

                      inputFormatters: [
                          FilteringTextInputFormatter.digitsOnly,
                        ],
                        
                      cursorColor:
                          Colors.white,

                      style:
                          const TextStyle(
                        color:
                            Colors.white,
                        fontSize: 16,
                      ),

                      decoration:
                          const InputDecoration(
                        hintText:
                            'Nomor telepon',

                        hintStyle:
                            TextStyle(
                          color: Color(
                            0xFF8796A0,
                          ),
                          fontSize: 16,
                        ),

                        border:
                            InputBorder.none,

                        enabledBorder:
                            UnderlineInputBorder(
                          borderSide:
                              BorderSide(
                            color:
                                Colors.white,
                          ),
                        ),

                        focusedBorder:
                            UnderlineInputBorder(
                          borderSide:
                              BorderSide(
                            color:
                                Colors.white,
                          ),
                        ),

                        contentPadding:
                            EdgeInsets.only(
                          bottom: 10,
                        ),
                      ),
                    ),
                  ),
                ],
              ),

              const Spacer(),

              // ======================================================
              // BUTTON
              // ======================================================

              Padding(
                padding:
                    const EdgeInsets.only(
                  bottom: 36,
                ),

                child: SizedBox(
                  width:
                      double.infinity,

                  height: 58,

                  child: ElevatedButton(
                    onPressed:
                        _handleNext,

                    style:
                        ElevatedButton
                            .styleFrom(
                      backgroundColor:
                          _isFilled
                              ? const Color(
                                  0xFF25D366,
                                )
                              : const Color(
                                  0xFF1F2C34,
                                ),

                      foregroundColor:
                          _isFilled
                              ? Colors.white
                              : const Color(
                                  0xFF5F6B75,
                                ),

                      elevation: 0,

                      shape:
                          RoundedRectangleBorder(
                        borderRadius:
                            BorderRadius.circular(
                          30,
                        ),
                      ),
                    ),

                    child: Text(
                      'Berikutnya',

                      style: TextStyle(
                        fontSize: 16,
                        fontWeight:
                            FontWeight
                                .w700,

                        color:
                            _isFilled
                                ? Colors
                                    .white
                                : const Color(
                                    0xFF5F6B75,
                                  ),
                      ),
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

  // ======================================================
  // DESKTOP CONTENT
  // ======================================================

  Widget _buildDesktopContent(
    BuildContext context,
  ) {
    return const DesktopLoginScreen();
  }
}