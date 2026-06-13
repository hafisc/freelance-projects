import 'dart:io';

import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';

import '../desktop/desktop_login_screen.dart';
import '../models/business_registration.dart';
import 'mobile_location_screen.dart';
import 'mobile_schedule_screen.dart';

class MobilePhotoScreen extends StatefulWidget {
  const MobilePhotoScreen({super.key});

  @override
  State<MobilePhotoScreen> createState() =>
      _MobilePhotoScreenState();
}

class _MobilePhotoScreenState
    extends State<MobilePhotoScreen> {
  File? _selectedImage;

  final ImagePicker _picker = ImagePicker();

  bool get _hasPhoto =>
      _selectedImage != null;

  // ======================================================
  // PICK IMAGE
  // ======================================================

  Future<void> _pickImage(
    ImageSource source,
  ) async {
    final XFile? pickedFile =
        await _picker.pickImage(
      source: source,
      imageQuality: 80,
    );

    if (pickedFile != null) {

    BusinessRegistration.profilePhoto =
        pickedFile.path;

    setState(() {
      _selectedImage = File(
        pickedFile.path,
      );
    });
  }
  }

  // ======================================================
  // BOTTOM SHEET
  // ======================================================

  void _showImagePicker() {
    showModalBottomSheet(
      context: context,

      backgroundColor:
          const Color(0xFF111B21),

      shape:
          const RoundedRectangleBorder(
        borderRadius:
            BorderRadius.vertical(
          top: Radius.circular(26),
        ),
      ),

      builder: (context) {
        return SafeArea(
          child: Padding(
            padding:
                const EdgeInsets.all(20),

            child: Column(
              mainAxisSize:
                  MainAxisSize.min,

              children: [
                Container(
                  width: 52,
                  height: 5,

                  decoration: BoxDecoration(
                    color: Colors.white24,

                    borderRadius:
                        BorderRadius.circular(
                      20,
                    ),
                  ),
                ),

                const SizedBox(height: 28),

                const Text(
                  'Pilih Foto',

                  style: TextStyle(
                    color: Colors.white,
                    fontSize: 22,
                    fontWeight:
                        FontWeight.w600,
                  ),
                ),

                const SizedBox(height: 26),

                ListTile(
                  onTap: () {
                    Navigator.pop(context);

                    _pickImage(
                      ImageSource.camera,
                    );
                  },

                  leading: const Icon(
                    Icons.camera_alt,
                    color: Colors.white,
                  ),

                  title: const Text(
                    'Kamera',

                    style: TextStyle(
                      color: Colors.white,
                    ),
                  ),
                ),

                ListTile(
                  onTap: () {
                    Navigator.pop(context);

                    _pickImage(
                      ImageSource.gallery,
                    );
                  },

                  leading: const Icon(
                    Icons.photo_library,
                    color: Colors.white,
                  ),

                  title: const Text(
                    'Galeri',

                    style: TextStyle(
                      color: Colors.white,
                    ),
                  ),
                ),

                const SizedBox(height: 12),
              ],
            ),
          ),
        );
      },
    );
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
              // BACK

              GestureDetector(
                onTap: () {
                  Navigator.pushReplacement(
                    context,
                    MaterialPageRoute(
                      builder: (context) =>
                          const MobileScheduleScreen(),
                    ),
                  );
                },

                child: const Icon(
                  Icons.arrow_back,
                  color: Colors.white,
                  size: 34,
                ),
              ),

              // SKIP

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
                      widthFactor: 0.68,

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

          const SizedBox(height: 48),

          // ======================================================
          // TITLE
          // ======================================================

          const Text(
            'Tambah foto\nprofil',

            textAlign:
                TextAlign.center,

            style: TextStyle(
              color: Colors.white,
              fontSize: 36,
              fontWeight:
                  FontWeight.w400,
              height: 1.2,
            ),
          ),

          const SizedBox(height: 18),

          // ======================================================
          // SUBTITLE
          // ======================================================

          const Text(
            'Gambar yang jelas bisa membantu\nmenarik calon pelanggan.',

            textAlign:
                TextAlign.center,

            style: TextStyle(
              color: Colors.white,
              fontSize: 15,
              height: 1.55,
            ),
          ),

          const SizedBox(height: 40),

          // ======================================================
          // PROFILE IMAGE
          // ======================================================

          Expanded(
            child: Align(
              alignment:
                  Alignment.topCenter,

              child: GestureDetector(
                onTap:
                    _showImagePicker,

                child: SizedBox(
                  width: 220,
                  height: 220,

                  child: _hasPhoto
                      ? ClipOval(
                          child:
                              Image.file(
                            _selectedImage!,
                            fit: BoxFit
                                .cover,
                          ),
                        )
                      : Image.asset(
                          'assets/icons/tools2.JPG',

                          width: 220,
                          height: 220,

                          fit: BoxFit
                              .cover,
                        ),
                ),
              ),
            ),
          ),

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
                  if (!_hasPhoto) {
                    _showError(
                      "Silakan pilih foto profil terlebih dahulu",
                    );
                    return;
                  }



                  Navigator.pushReplacement(
                    context,
                    MaterialPageRoute(
                      builder: (context) =>
                          const MobileLocationScreen(),
                    ),
                  );
                },

                style:
                    ElevatedButton.styleFrom(
                  backgroundColor:
                      Colors.white,

                  foregroundColor:
                      const Color.fromARGB(255, 3, 2, 2),

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
                  'Berikutnya',

                  style: TextStyle(
                    fontSize: 18,
                    fontWeight:
                        FontWeight.w600,
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