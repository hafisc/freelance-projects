import 'package:flutter/material.dart';

import '../desktop/desktop_login_screen.dart';
import 'mobile_hours_screen.dart';
import '../models/business_registration.dart';
import 'mobile_photo_screen.dart';

class MobileScheduleScreen extends StatefulWidget {
  const MobileScheduleScreen({super.key});

  @override
  State<MobileScheduleScreen> createState() =>
      _MobileScheduleScreenState();
}

class _MobileScheduleScreenState
    extends State<MobileScheduleScreen> {
  final Map<String, bool> _daySchedule = {
    'Minggu': false,
    'Senin': true,
    'Selasa': true,
    'Rabu': true,
    'Kamis': true,
    'Jumat': true,
    'Sabtu': false,
  };

    final List<String> _days = [
    'Minggu',
    'Senin',
    'Selasa',
    'Rabu',
    'Kamis',
    'Jumat',
    'Sabtu',
  ];

  bool _hasActiveDay() {
    return _daySchedule.values.any(
      (value) => value,
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
                        const MobileHoursScreen(),
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
                      widthFactor: 0.7,

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

          const SizedBox(height: 34),

          // ======================================================
          // TITLE
          // ======================================================

          const Align(
            alignment:
                Alignment.centerLeft,

            child: Text(
              'Pilih jam',

              style: TextStyle(
                color: Colors.white,
                fontSize: 34,
                fontWeight:
                    FontWeight.w400,
              ),
            ),
          ),

          const SizedBox(height: 20),

          // ======================================================
          // DAYS LIST
          // ======================================================

          Expanded(
            child: ListView.separated(
              itemCount: _days.length,

              separatorBuilder:
                  (context, index) {
                return Container(
                  height: 1,
                  color: const Color(
                    0xFF2C3E50,
                  ),
                );
              },

              itemBuilder:
                  (context, index) {
                final day = _days[index];

                final isActive =
                    _daySchedule[day] ??
                        false;

                return Container(
                  padding:
                      const EdgeInsets
                          .symmetric(
                    vertical: 16,
                  ),

                  child: Row(
                    mainAxisAlignment:
                        MainAxisAlignment
                            .spaceBetween,

                    children: [
                      Column(
                        crossAxisAlignment:
                            CrossAxisAlignment
                                .start,

                        children: [
                          Text(
                            day,

                            style:
                                const TextStyle(
                              color:
                                  Colors
                                      .white,
                              fontSize:
                                  18,
                              fontWeight:
                                  FontWeight
                                      .w500,
                            ),
                          ),

                          const SizedBox(
                            height: 4,
                          ),

                          Text(
                            isActive
                                ? 'Buka 24 jam'
                                : 'Tutup',

                            style:
                                const TextStyle(
                              color: Color(
                                0xFF5F6B75,
                              ),
                              fontSize:
                                  16,
                            ),
                          ),
                        ],
                      ),

                      Switch(
                        value: isActive,

                        onChanged: (
                          value,
                        ) {
                          setState(() {
                            _daySchedule[
                                    day] =
                                value;
                          });
                        },

                        activeColor:
                            Colors.black,

                        activeTrackColor:
                            Colors.white,

                        inactiveThumbColor:
                            Colors.black,

                        inactiveTrackColor:
                            const Color(
                          0xFF5F6B75,
                        ),
                      ),
                    ],
                  ),
                );
              },
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
                      if (!_hasActiveDay()) {
                        _showError(
                          "Pilih minimal satu hari operasional",
                        );
                        return;
                      }

                      BusinessRegistration.schedule =
                            _daySchedule.entries
                                .where((entry) => entry.value)
                                .map((entry) => entry.key)
                                .join(', ');
                                
                      Navigator.pushReplacement(
                        context,
                        MaterialPageRoute(
                          builder: (context) =>
                              const MobilePhotoScreen(),
                        ),
                      );
                    },

                style:
                    ElevatedButton.styleFrom(
                  backgroundColor:
                      Colors.white,

                  foregroundColor:
                      Colors.black,

                  shape:
                      RoundedRectangleBorder(
                    borderRadius:
                        BorderRadius.circular(
                      30,
                    ),
                  ),

                  elevation: 0,
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