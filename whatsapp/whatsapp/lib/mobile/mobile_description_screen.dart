import 'package:flutter/material.dart';

import '../desktop/desktop_login_screen.dart';
import '../models/business_registration.dart';
import 'mobile_loading_screen.dart';
import 'mobile_location_screen.dart';

class MobileDescriptionScreen extends StatefulWidget {
  const MobileDescriptionScreen({super.key});

  @override
  State<MobileDescriptionScreen> createState() =>
      _MobileDescriptionScreenState();
}

class _MobileDescriptionScreenState
    extends State<MobileDescriptionScreen> {
  final TextEditingController
      _descriptionController =
      TextEditingController();

  int _charCount = 0;

  static const int _maxChars = 512;

  bool get _isFilled =>
      _descriptionController.text
          .trim()
          .isNotEmpty;

  @override
  void initState() {
    super.initState();

    _descriptionController.addListener(() {
      setState(() {});
    });
  }

  @override
  void dispose() {
    _descriptionController.dispose();
    super.dispose();
  }

  // ======================================================
  // NEXT PAGE
  // ======================================================

      void _goNext() {

      BusinessRegistration.description =
          _descriptionController.text.trim();

      Navigator.pushReplacement(
        context,
        MaterialPageRoute(
          builder: (context) =>
              const MobileLoadingScreen(),
        ),
      );
    }

      void _validateAndNext() {
      if (_descriptionController.text
          .trim()
          .isEmpty) {
        _showError(
          "Deskripsi bisnis wajib diisi",
        );
        return;
      }

      _goNext();
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
              // BACK BUTTON

              GestureDetector(
                onTap: () {
                  Navigator.pushReplacement(
                    context,
                    MaterialPageRoute(
                      builder: (context) =>
                          const MobileLocationScreen(),
                    ),
                  );
                },

                child: const Icon(
                  Icons.arrow_back,
                  color: Colors.white,
                  size: 34,
                ),
              ),

              // SKIP BUTTON

              GestureDetector(
                onTap: _goNext,

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

          Container(
            height: 4,
            width: double.infinity,

            decoration: BoxDecoration(
              color: Colors.white,

              borderRadius:
                  BorderRadius.circular(
                20,
              ),
            ),
          ),

          const SizedBox(height: 42),

          // ======================================================
          // TITLE
          // ======================================================

          const Text(
            'Tambah deskripsi\nbisnis',

            textAlign:
                TextAlign.center,

            style: TextStyle(
              color: Colors.white,
              fontSize: 36,
              fontWeight:
                  FontWeight.w400,
              height: 1.25,
            ),
          ),

          const SizedBox(height: 22),

          // ======================================================
          // SUBTITLE
          // ======================================================

          const Text(
            'Beri tahu calon pelanggan hal yang\nAnda lakukan dan alasan mereka\nharus memilih bisnis Anda.',

            textAlign:
                TextAlign.center,

            style: TextStyle(
              color: Colors.white,
              fontSize: 16,
              height: 1.55,
            ),
          ),

          const SizedBox(height: 30),

          // ======================================================
          // DESCRIPTION FIELD
          // ======================================================

          SizedBox(
            height: 290,

            child: Stack(
              children: [
                TextField(
                  controller:
                      _descriptionController,

                  maxLength:
                      _maxChars,

                  maxLines: null,

                  expands: true,

                  keyboardType:
                      TextInputType
                          .multiline,

                  textAlignVertical:
                      TextAlignVertical.top,

                  cursorColor:
                      Colors.white,

                  style:
                      const TextStyle(
                    color: Colors.white,
                    fontSize: 18,
                    height: 1.5,
                  ),

                  onChanged: (
                    value,
                  ) {
                    setState(() {
                      _charCount =
                          value.length;
                    });
                  },

                  decoration:
                      InputDecoration(
                    counterText: '',

                    hintText:
                        'Deskripsi',

                    hintStyle:
                        const TextStyle(
                      color: Color(
                        0xFF8796A0,
                      ),
                      fontSize: 18,
                    ),

                    filled: true,

                    fillColor:
                        const Color(
                      0xFF0B141A,
                    ),

                    contentPadding:
                        const EdgeInsets.only(
                      left: 22,
                      top: 24,
                      right: 22,
                      bottom: 55,
                    ),

                    enabledBorder:
                        OutlineInputBorder(
                      borderRadius:
                          BorderRadius.circular(
                        18,
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
                          BorderRadius.circular(
                        18,
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

                // CHARACTER COUNT

                Positioned(
                  right: 18,
                  bottom: 18,

                  child: Text(
                    '$_charCount / $_maxChars',

                    style:
                        const TextStyle(
                      color: Color(
                        0xFF8796A0,
                      ),
                      fontSize: 14,
                      fontWeight:
                          FontWeight.w500,
                    ),
                  ),
                ),
              ],
            ),
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
                  onPressed: _validateAndNext,

                style:
                    ElevatedButton.styleFrom(
                  backgroundColor:
                      _isFilled
                          ? Colors.white
                          : const Color(
                              0xFF1F2C34,
                            ),

                  foregroundColor:
                      _isFilled
                          ? Colors.black
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
                    fontSize: 18,
                    fontWeight:
                        FontWeight.w600,

                    color:
                        _isFilled
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