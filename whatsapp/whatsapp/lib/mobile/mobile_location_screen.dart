import 'package:flutter/material.dart';

import '../desktop/desktop_login_screen.dart';
import '../models/business_registration.dart';
import 'mobile_description_screen.dart';
import 'mobile_photo_screen.dart';

class MobileLocationScreen extends StatefulWidget {
  const MobileLocationScreen({super.key});

  @override
  State<MobileLocationScreen> createState() =>
      _MobileLocationScreenState();
}

class _MobileLocationScreenState
    extends State<MobileLocationScreen> {
  final TextEditingController _addressController =
      TextEditingController();

  final TextEditingController _websiteController =
      TextEditingController();

  bool _noPhysicalLocation = false;

  bool get _isButtonActive {
    return _addressController.text.trim().isNotEmpty ||
        _websiteController.text.trim().isNotEmpty ||
        _noPhysicalLocation;
  }

  @override
  void initState() {
    super.initState();

    _addressController.addListener(() {
      setState(() {});
    });

    _websiteController.addListener(() {
      setState(() {});
    });
  }

  @override
  void dispose() {
    _addressController.dispose();
    _websiteController.dispose();
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
    return Padding(
      padding:
          const EdgeInsets.symmetric(
        horizontal: 32,
      ),

      child: Column(
        children: [
          const SizedBox(height: 18),

          // ======================================================
          // HEADER
          // ======================================================

          Row(
            mainAxisAlignment:
                MainAxisAlignment
                    .spaceBetween,

            children: [
              GestureDetector(
                onTap: () {
                  Navigator.pushReplacement(
                    context,
                    MaterialPageRoute(
                      builder: (context) =>
                          const MobilePhotoScreen(),
                    ),
                  );
                },

                child: const Icon(
                  Icons.arrow_back,
                  color: Colors.white,
                  size: 34,
                ),
              ),

              GestureDetector(
                onTap: () {
                  Navigator.pushReplacement(
                    context,
                    MaterialPageRoute(
                      builder: (context) =>
                          const MobileDescriptionScreen(),
                    ),
                  );
                },

                child: const Text(
                  'Lewati',

                  style: TextStyle(
                    color:
                        Color(0xFF8796A0),
                    fontSize: 17,
                    fontWeight:
                        FontWeight.w600,
                  ),
                ),
              ),
            ],
          ),

          const SizedBox(height: 26),

          // ======================================================
          // PROGRESS BAR
          // ======================================================

          Row(
            children: [
              Expanded(
                child: Stack(
                  alignment:
                      Alignment.centerLeft,

                  children: [
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

                    FractionallySizedBox(
                      widthFactor: 0.84,

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

          const SizedBox(height: 46),

          // ======================================================
          // TITLE
          // ======================================================

          const Text(
            'Cara lain untuk\nmenemukan Anda',

            textAlign:
                TextAlign.center,

            style: TextStyle(
              color: Colors.white,
              fontSize: 36,
              fontWeight:
                  FontWeight.w400,
              height: 1.35,
            ),
          ),

          const SizedBox(height: 20),

          // ======================================================
          // SUBTITLE
          // ======================================================

          const Text(
            'Beri tahu pelanggan lokasi bisnis\natau operasional Anda.',

            textAlign:
                TextAlign.center,

            style: TextStyle(
              color: Colors.white,
              fontSize: 16,
              height: 1.7,
            ),
          ),

          const SizedBox(height: 34),

          // ======================================================
          // ADDRESS FIELD
          // ======================================================

          SizedBox(
            height: 72,

            child: TextField(
              controller:
                  _addressController,

              cursorColor:
                  Colors.white,

              style: const TextStyle(
                color: Colors.white,
                fontSize: 17,
              ),

              decoration:
                  InputDecoration(
                hintText:
                    'Alamat atau wilayah',

                hintStyle:
                    const TextStyle(
                  color: Color(
                    0xFFB7BDC2,
                  ),
                  fontSize: 17,
                ),

                contentPadding:
                    const EdgeInsets
                        .symmetric(
                  horizontal: 22,
                  vertical: 22,
                ),

                enabledBorder:
                    OutlineInputBorder(
                  borderRadius:
                      BorderRadius
                          .circular(
                    14,
                  ),

                  borderSide:
                      const BorderSide(
                    color:
                        Colors.white,
                    width: 1.4,
                  ),
                ),

                focusedBorder:
                    OutlineInputBorder(
                  borderRadius:
                      BorderRadius
                          .circular(
                    14,
                  ),

                  borderSide:
                      const BorderSide(
                    color:
                        Colors.white,
                    width: 1.4,
                  ),
                ),
              ),
            ),
          ),

          const SizedBox(height: 28),

          // ======================================================
          // CHECKBOX
          // ======================================================

          Row(
            crossAxisAlignment:
                CrossAxisAlignment
                    .start,

            children: [
              SizedBox(
                width: 24,
                height: 24,

                child: Checkbox(
                  value:
                      _noPhysicalLocation,

                  onChanged: (
                    value,
                  ) {
                    setState(() {
                      _noPhysicalLocation =
                          value ??
                              false;
                    });
                  },

                  side:
                      const BorderSide(
                    color: Color(
                      0xFF8E9AA3,
                    ),
                    width: 1.4,
                  ),

                  activeColor:
                      const Color(
                    0xFF25D366,
                  ),

                  checkColor:
                      Colors.white,
                ),
              ),

              const SizedBox(width: 16),

              const Expanded(
                child: Text(
                  'Bisnis saya tidak memiliki lokasi fisik',

                  style: TextStyle(
                    color:
                        Colors.white,
                    fontSize: 16,
                    height: 1.5,
                  ),
                ),
              ),
            ],
          ),

          const SizedBox(height: 30),

          // ======================================================
          // WEBSITE FIELD
          // ======================================================

          Stack(
            clipBehavior: Clip.none,

            children: [
              Container(
                height: 64,

                decoration:
                    BoxDecoration(
                  borderRadius:
                      BorderRadius
                          .circular(
                    14,
                  ),

                  border: Border.all(
                    color: const Color(
                      0xFFB7BDC2,
                    ),
                    width: 1.4,
                  ),
                ),

                child: TextField(
                  controller:
                      _websiteController,

                  cursorColor:
                      Colors.white,

                  style:
                      const TextStyle(
                    color:
                        Colors.white,
                    fontSize: 17,
                    fontWeight:
                        FontWeight.w400,
                  ),

                  decoration:
                      const InputDecoration(
                    border:
                        InputBorder.none,

                    hintText:
                        'https://',

                    hintStyle:
                        TextStyle(
                      color:
                          Colors.white,
                      fontSize: 17,
                      fontWeight:
                          FontWeight
                              .w400,
                    ),

                    contentPadding:
                        EdgeInsets.symmetric(
                      horizontal: 22,
                      vertical: 20,
                    ),
                  ),
                ),
              ),

              Positioned(
                left: 14,
                top: -10,

                child: Container(
                  padding:
                      const EdgeInsets
                          .symmetric(
                    horizontal: 6,
                  ),

                  color: const Color(
                    0xFF0B141A,
                  ),

                  child: const Text(
                    'Situs web',

                    style: TextStyle(
                      color: Color(
                        0xFFB7BDC2,
                      ),
                      fontSize: 14,
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
              bottom: 34,
            ),

            child: SizedBox(
              width: double.infinity,
              height: 58,

              child: ElevatedButton(
                  onPressed: () {
                    if (!_isButtonActive) {
                      _showError(
                        "Isi alamat, website, atau centang lokasi fisik",
                      );
                      return;
                    }
                  BusinessRegistration.address =
                      _noPhysicalLocation
                          ? "Tidak memiliki lokasi fisik"
                          : _addressController.text.trim();

                  BusinessRegistration.website =
                      _websiteController.text.trim();
                      
                    Navigator.pushReplacement(
                      context,
                      MaterialPageRoute(
                        builder: (context) =>
                            const MobileDescriptionScreen(),
                      ),
                    );
                  },
                  
                style:
                    ElevatedButton.styleFrom(
                  backgroundColor:
                      _isButtonActive
                          ? Colors.white
                          : const Color(
                              0xFF1F2C34,
                            ),

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

                child: Text(
                  'Berikutnya',

                  style: TextStyle(
                    fontSize: 18,
                    fontWeight:
                        FontWeight.w600,

                    color:
                        _isButtonActive
                            ? Colors.black
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