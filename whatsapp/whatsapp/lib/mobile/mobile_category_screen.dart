import 'package:flutter/material.dart';

import '../desktop/desktop_login_screen.dart';
import '../models/business_registration.dart';
import 'mobile_business_profile_screen.dart';
import 'mobile_hours_screen.dart';

class MobileCategoryScreen
    extends StatefulWidget {
  const MobileCategoryScreen({
    super.key,
  });

  @override
  State<MobileCategoryScreen>
      createState() =>
          _MobileCategoryScreenState();
}

class _MobileCategoryScreenState
    extends State<
        MobileCategoryScreen> {
  final List<String> categories = [
    'Bisnis lain',
    'Layanan Otomotif',
    'Pakaian',
    'Seni & Hiburan',
    'Kecantikan, Kosmetik & Perawatan Diri',
    'Pendidikan',
    'Event Organizer',
    'Keuangan',
    'Toko Kelontong',
    'Hotel',
    'Medis & Kesehatan',
  ];

  final List<String>
      selectedCategories = [];

  static const int maxSelections = 3;

  void _toggleCategory(
    String category,
  ) {
    setState(() {
      if (selectedCategories
          .contains(category)) {
        selectedCategories.remove(
          category,
        );
      } else if (selectedCategories
              .length <
          maxSelections) {
        selectedCategories.add(
          category,
        );
      }
    });
  }

    void _showError(String message) {
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Text(message),
        backgroundColor: Colors.red,
      ),
    );
  }

  bool get _isButtonActive =>
      selectedCategories.isNotEmpty;

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

      child: Column(
        children: [
          const SizedBox(height: 18),

          // ======================================================
          // BACK BUTTON
          // ======================================================

          Align(
            alignment: Alignment.centerLeft,

            child: GestureDetector(
              onTap: () {
                Navigator.pushReplacement(
                  context,
                  MaterialPageRoute(
                    builder: (context) =>
                        const MobileBusinessProfileScreen(),
                  ),
                );
              },

              child: const Icon(
                Icons.arrow_back,
                color: Colors.white,
                size: 34,
              ),
            ),
          ),

          const SizedBox(height: 24),

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
                      widthFactor: 0.34,

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

              // titik putih kanan

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
          // TITLE
          // ======================================================

          const Text(
            'Pilih kategori\nbisnis Anda',

            textAlign:
                TextAlign.center,

            style: TextStyle(
              color: Colors.white,
              fontSize: 34,
              fontWeight:
                  FontWeight.w400,
              height: 1.3,
            ),
          ),

          const SizedBox(height: 18),

          // ======================================================
          // SUBTITLE
          // ======================================================

          const Text(
            'Pilih sampai dengan 3 kategori\nuntuk ditampilkan di profil bisnis\nAnda.',

            textAlign:
                TextAlign.center,

            style: TextStyle(
              color: Colors.white,
              fontSize: 16,
              height: 1.7,
            ),
          ),

          const SizedBox(height: 30),

          // ======================================================
          // CATEGORY CHIPS
          // ======================================================

          Expanded(
            child: SingleChildScrollView(
              child: Wrap(
                spacing: 14,
                runSpacing: 14,

                alignment:
                    WrapAlignment.center,

                children:
                    categories.map((
                  category,
                ) {
                  final isSelected =
                      selectedCategories
                          .contains(
                    category,
                  );

                  return GestureDetector(
                    onTap: () =>
                        _toggleCategory(
                      category,
                    ),

                    child: Container(
                      padding:
                          const EdgeInsets.symmetric(
                        horizontal: 22,
                        vertical: 14,
                      ),

                      decoration:
                          BoxDecoration(
                        color: isSelected
                            ? const Color(
                                0xFF25D366,
                              )
                            : const Color(
                                0xFF1F2C34,
                              ),

                        borderRadius:
                            BorderRadius.circular(
                          30,
                        ),
                      ),

                      child: Text(
                        category,

                        style:
                            const TextStyle(
                          color:
                              Colors.white,
                          fontSize: 15,
                          fontWeight:
                              FontWeight
                                  .w600,
                        ),
                      ),
                    ),
                  );
                }).toList(),
              ),
            ),
          ),

          const SizedBox(height: 20),

          // ======================================================
          // BUTTON
          // ======================================================

          Padding(
            padding:
                const EdgeInsets.only(
              bottom: 34,
            ),

            child: SizedBox(
              height: 58,
              width: double.infinity,

              child: ElevatedButton(
              onPressed: () {
                    if (selectedCategories.isEmpty) {
                      _showError(
                        "Pilih minimal satu kategori bisnis",
                      );
                      return;
                    }

                    BusinessRegistration.category =
                      selectedCategories.join(', ');

                    Navigator.pushReplacement(
                      context,
                      MaterialPageRoute(
                        builder: (context) =>
                            const MobileHoursScreen(),
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

                  foregroundColor:
                      Colors.white,

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