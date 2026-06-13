import 'package:flutter/material.dart';

import '../desktop/desktop_login_screen.dart';
import '../models/business_registration.dart';
import 'mobile_category_screen.dart';
import 'mobile_schedule_screen.dart';

class MobileHoursScreen extends StatefulWidget {
  const MobileHoursScreen({super.key});

  @override
  State<MobileHoursScreen> createState() =>
      _MobileHoursScreenState();
}

class _MobileHoursScreenState
    extends State<MobileHoursScreen> {
  int? _selectedOption;

  final List<String> _options = [
    'Hanya buka pada jam-jam tertentu',
    'Selalu buka',
    'Hanya janji temu',
  ];

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
                        const MobileCategoryScreen(),
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
                      widthFactor: 0.52,

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

          const SizedBox(height: 42),

          // ======================================================
          // TITLE
          // ======================================================

          const Align(
            alignment:
                Alignment.centerLeft,

            child: Text(
              'Tambah jam\noperasional',

              style: TextStyle(
                color: Colors.white,
                fontSize: 34,
                fontWeight:
                    FontWeight.w400,
                height: 1.25,
              ),
            ),
          ),

          const SizedBox(height: 18),

          // ======================================================
          // SUBTITLE
          // ======================================================

          const Align(
            alignment:
                Alignment.centerLeft,

            child: Text(
              'Beri tahu pelanggan jam\noperasional bisnis Anda.',

              style: TextStyle(
                color: Colors.white,
                fontSize: 17,
                height: 1.5,
              ),
            ),
          ),

          const SizedBox(height: 40),

          // ======================================================
          // OPTIONS
          // ======================================================

          Expanded(
            child: Column(
              children: List.generate(
                _options.length,
                (index) =>
                    _buildRadioOption(
                  index,
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
                  if (_selectedOption == null) {
                    _showError(
                      "Pilih jam operasional terlebih dahulu",
                    );
                    return;
                  }

                  BusinessRegistration.businessHours =
                          _options[_selectedOption!];

                  Navigator.pushReplacement(
                    context,
                    MaterialPageRoute(
                      builder: (context) =>
                          const MobileScheduleScreen(),
                    ),
                  );
                },

                style:
                    ElevatedButton.styleFrom(
                  backgroundColor:
                      _selectedOption !=
                              null
                          ? Colors.white
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
                        _selectedOption !=
                                null
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
  // RADIO OPTION
  // ======================================================

  Widget _buildRadioOption(
    int index,
  ) {
    return Padding(
      padding:
          const EdgeInsets.only(
        bottom: 18,
      ),

      child: GestureDetector(
        onTap: () {
          setState(() {
            _selectedOption = index;
          });
        },

        child: Row(
          crossAxisAlignment:
              CrossAxisAlignment.start,

          children: [
            // RADIO

            Container(
              margin:
                  const EdgeInsets.only(
                top: 2,
              ),

              width: 38,
              height: 38,

              decoration:
                  BoxDecoration(
                shape: BoxShape.circle,

                border: Border.all(
                  color:
                      _selectedOption ==
                              index
                          ? const Color(
                              0xFF25D366,
                            )
                          : const Color(
                              0xFF7B8790,
                            ),

                  width: 2,
                ),
              ),

              child:
                  _selectedOption ==
                          index
                      ? Center(
                          child: Container(
                            width: 20,
                            height: 20,

                            decoration:
                                const BoxDecoration(
                              color: Color(
                                0xFF25D366,
                              ),

                              shape:
                                  BoxShape
                                      .circle,
                            ),
                          ),
                        )
                      : null,
            ),

            const SizedBox(width: 18),

            // TEXT

            Expanded(
              child: Text(
                _options[index],

                style:
                    const TextStyle(
                  color: Colors.white,
                  fontSize: 20,
                  height: 1.5,
                ),
              ),
            ),
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