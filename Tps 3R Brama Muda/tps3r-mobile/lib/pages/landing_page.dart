import 'package:flutter/material.dart';

class LandingPage extends StatefulWidget {
  const LandingPage({super.key});

  @override
  State<LandingPage> createState() => _LandingPageState();
}

class _LandingPageState extends State<LandingPage> with SingleTickerProviderStateMixin {
  late AnimationController _animationController;
  late Animation<double> _fadeAnimation;

  @override
  void initState() {
    super.initState();
    _animationController = AnimationController(
      duration: const Duration(milliseconds: 800),
      vsync: this,
    );
    _fadeAnimation = CurvedAnimation(
      parent: _animationController,
      curve: Curves.easeOut,
    );
    _animationController.forward();
  }

  @override
  void dispose() {
    _animationController.dispose();
    super.dispose();
  }

  // Responsive sizing helper
  double r(double small, [double medium = 0, double large = 0]) {
    return medium == 0 ? small : (large == 0 ? small : large);
  }

  @override
  Widget build(BuildContext context) {
    final screenWidth = MediaQuery.of(context).size.width;
    final screenHeight = MediaQuery.of(context).size.height;
    final bottomPadding = MediaQuery.of(context).padding.bottom;

    // Calculate responsive multipliers
    final widthScale = screenWidth / 400;
    final heightScale = screenHeight / 800;
    final baseScale = widthScale < heightScale ? widthScale : heightScale;

    return Scaffold(
      backgroundColor: const Color(0xFFF4FBF7),
      body: SafeArea(
        child: FadeTransition(
          opacity: _fadeAnimation,
          child: SingleChildScrollView(
            physics: const BouncingScrollPhysics(),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.stretch,
              mainAxisSize: MainAxisSize.min,
              children: [
                // 1. Header Navbar
                _buildNavbar(context, widthScale),
                SizedBox(height: screenHeight * 0.01),

                // 2. Hero Section
                _buildHeroSection(context, screenHeight, widthScale, baseScale),
                SizedBox(height: screenHeight * 0.02),

                // 3. Statistics Section
                _buildStatisticsSection(widthScale),
                SizedBox(height: screenHeight * 0.02),

                // 4. Collection Schedule
                _buildScheduleSection(widthScale),
                SizedBox(height: screenHeight * 0.02),

                // 5. How It Works
                _buildHowItWorksSection(widthScale),
                SizedBox(height: screenHeight * 0.02),

                // 6. TPS Activities Gallery
                _buildActivitiesSection(widthScale),
                SizedBox(height: screenHeight * 0.02),

                // 7. Testimonials
                _buildTestimonialsSection(widthScale),
                SizedBox(height: screenHeight * 0.02),

                // 8. About TPS
                _buildAboutSection(widthScale),
                SizedBox(height: screenHeight * 0.02),

                // 9. Footer
                _buildFooter(widthScale, bottomPadding),
              ],
            ),
          ),
        ),
      ),
    );
  }

  Widget _buildNavbar(BuildContext context, double scale) {
    final pad = 12.0 * scale;
    final logoPad = 8.0 * scale;
    final logoSize = 20.0 * scale;
    final btnPadH = 14.0 * scale;
    final btnPadV = 8.0 * scale;

    return Container(
      margin: EdgeInsets.symmetric(horizontal: pad, vertical: pad * 0.6),
      padding: EdgeInsets.symmetric(horizontal: pad, vertical: pad * 0.8),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16 * scale),
        boxShadow: [
          BoxShadow(
            color: const Color(0xFF10B981).withValues(alpha: 0.08),
            blurRadius: 16,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Row(
        children: [
          Container(
            padding: EdgeInsets.all(logoPad),
            decoration: BoxDecoration(
              gradient: const LinearGradient(
                colors: [Color(0xFF10B981), Color(0xFF059669)],
              ),
              borderRadius: BorderRadius.circular(10 * scale),
            ),
            child: Icon(Icons.eco, color: Colors.white, size: logoSize),
          ),
          SizedBox(width: 10 * scale),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              mainAxisSize: MainAxisSize.min,
              children: [
                Text(
                  'TPS 3R Brama Muda',
                  style: TextStyle(
                    fontSize: 14 * scale,
                    fontWeight: FontWeight.w800,
                    color: const Color(0xFF111827),
                  ),
                ),
                Text(
                  'Smart Waste Platform',
                  style: TextStyle(
                    fontSize: 10 * scale,
                    color: const Color(0xFF10B981),
                    fontWeight: FontWeight.w600,
                  ),
                ),
              ],
            ),
          ),
          GestureDetector(
            onTap: () => Navigator.of(context).pushNamed('/login'),
            child: Container(
              padding: EdgeInsets.symmetric(horizontal: btnPadH, vertical: btnPadV),
              decoration: BoxDecoration(
                gradient: const LinearGradient(
                  colors: [Color(0xFF10B981), Color(0xFF059669)],
                ),
                borderRadius: BorderRadius.circular(10 * scale),
              ),
              child: Row(
                mainAxisSize: MainAxisSize.min,
                children: [
                  Text(
                    'Masuk',
                    style: TextStyle(
                      fontSize: 12 * scale,
                      fontWeight: FontWeight.w600,
                      color: Colors.white,
                    ),
                  ),
                  SizedBox(width: 4 * scale),
                  Icon(Icons.arrow_forward, color: Colors.white, size: 14 * scale),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildHeroSection(BuildContext context, double screenHeight, double widthScale, double baseScale) {
    final heroHeight = screenHeight * 0.38 * baseScale;
    final contentPad = 18.0 * widthScale;
    final badgePadH = 12.0 * widthScale;
    final badgePadV = 6.0 * widthScale;
    final titleSize = 32.0 * widthScale;
    final subtitleSize = 12.0 * widthScale;
    final descSize = 12.0 * widthScale;

    return Container(
      margin: const EdgeInsets.symmetric(horizontal: 16),
      height: heroHeight.clamp(200.0, 400.0),
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(24 * widthScale),
        boxShadow: [
          BoxShadow(
            color: const Color(0xFF10B981).withValues(alpha: 0.15),
            blurRadius: 24,
            offset: const Offset(0, 10),
          ),
        ],
      ),
      child: ClipRRect(
        borderRadius: BorderRadius.circular(24 * widthScale),
        child: Stack(
          fit: StackFit.expand,
          children: [
            // ============================================
            // GAMBAR BACKGROUND
            // ============================================
            // Opsi 1: Gunakan Image.asset (gambar lokal)
            // Image.asset(
            //   'assets/images/hero_tps.png',
            //   fit: BoxFit.cover,
            //   width: double.infinity,
            //   height: double.infinity,
            // ),

            // Opsi 2: Gunakan NetworkImage (gambar dari internet)
            Container(
              decoration: BoxDecoration(
                image: DecorationImage(
                  image: AssetImage(
                    'assets/images/17c6e4f6-692b-4973-afcd-58a4b478cbab.png',
                  ),
                  fit: BoxFit.cover,
                  colorFilter: ColorFilter.mode(
  Colors.black.withOpacity(0.25),
  BlendMode.darken,
                  ),
                ),
              ),
            ),

            // Overlay gradient untuk keterbacaan text
            Container(
  decoration: BoxDecoration(
    gradient: LinearGradient(
      begin: Alignment.topLeft,
      end: Alignment.bottomRight,
      colors: [
        Colors.black.withOpacity(0.15),
        Colors.black.withOpacity(0.2),
        Colors.black.withOpacity(0.25),
      ],
    ),
  ),
),

            // ============================================
            // GAMBAR/ILUSTRASI DECORATIVE
            // ============================================
            // Posisi kanan atas - Tong daur ulang
            Positioned(
              right: -40 * widthScale,
              top: -40 * widthScale,
              child: Container(
                width: 200 * widthScale,
                height: 200 * widthScale,
                decoration: BoxDecoration(
                  shape: BoxShape.circle,
                  color: Colors.white.withValues(alpha: 0.08),
                ),
              ),
            ),

            // Posisi kiri atas - Tanaman hijau
            Positioned(
              left: -30 * widthScale,
              top: -20 * widthScale,
              child: Container(
                width: 150 * widthScale,
                height: 150 * widthScale,
                decoration: BoxDecoration(
                  shape: BoxShape.circle,
                  color: Colors.white.withValues(alpha: 0.06),
                ),
              ),
            ),

            // Posisi kanan bawah - Icon daur ulang
            Positioned(
              right: 20 * widthScale,
              bottom: 20 * widthScale,
              child: Container(
                width: 80 * widthScale,
                height: 80 * widthScale,
                decoration: BoxDecoration(
                  shape: BoxShape.circle,
                  color: Colors.white.withValues(alpha: 0.1),
                ),
                child: Icon(
                  Icons.recycling,
                  size: 40 * widthScale,
                  color: Colors.white.withValues(alpha: 0.3),
                ),
              ),
            ),

            // Posisi kiri bawah - Daun
            Positioned(
              left: 30 * widthScale,
              bottom: -20 * widthScale,
              child: Container(
                width: 120 * widthScale,
                height: 120 * widthScale,
                decoration: BoxDecoration(
                  shape: BoxShape.circle,
                  color: Colors.white.withValues(alpha: 0.05),
                ),
              ),
            ),

            // ============================================
            // DECORATIVE SHAPES
            // ============================================
            // Garis diagonal
            Positioned(
              right: 60 * widthScale,
              top: 30 * widthScale,
              child: Transform.rotate(
                angle: 0.3,
                child: Container(
                  width: 3 * widthScale,
                  height: 100 * widthScale,
                  decoration: BoxDecoration(
                    color: Colors.white.withValues(alpha: 0.1),
                    borderRadius: BorderRadius.circular(2 * widthScale),
                  ),
                ),
              ),
            ),

            // Titik-titik decorative
            ...List.generate(5, (index) {
              return Positioned(
                right: (40 + index * 15) * widthScale,
                top: (60 + index * 20) * widthScale,
                child: Container(
                  width: 6 * widthScale,
                  height: 6 * widthScale,
                  decoration: BoxDecoration(
                    shape: BoxShape.circle,
                    color: Colors.white.withValues(alpha: 0.15 + index * 0.03),
                  ),
                ),
              );
            }),

            // Overlay gradient
            Container(
              decoration: BoxDecoration(
                gradient: LinearGradient(
                  begin: Alignment.topCenter,
                  end: Alignment.bottomCenter,
                  colors: [Colors.black.withValues(alpha: 0.1), Colors.black.withValues(alpha: 0.35)],
                ),
              ),
            ),

            // Content
            Padding(
              padding: EdgeInsets.all(contentPad),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  Container(
                    padding: EdgeInsets.symmetric(horizontal: badgePadH, vertical: badgePadV),
                    decoration: BoxDecoration(
                      color: Colors.white.withValues(alpha: 0.2),
                      borderRadius: BorderRadius.circular(20 * widthScale),
                    ),
                    child: Row(
                      mainAxisSize: MainAxisSize.min,
                      children: [
                        Icon(Icons.verified, color: Colors.white, size: 14 * widthScale),
                        SizedBox(width: 4 * widthScale),
                        Text(
                          'Platform Resmi',
                          style: TextStyle(color: Colors.white, fontSize: 10 * widthScale, fontWeight: FontWeight.w700),
                        ),
                      ],
                    ),
                  ),
                  SizedBox(height: 12 * widthScale),
                  Text(
                    'TPS 3R',
                    style: TextStyle(color: Colors.white, fontSize: titleSize, fontWeight: FontWeight.w900, height: 1.1),
                  ),
                  Text(
                    'Brama Muda',
                    style: TextStyle(color: Colors.white, fontSize: titleSize, fontWeight: FontWeight.w900, height: 1.1),
                  ),
                  SizedBox(height: 8 * widthScale),
                  Container(
                    padding: EdgeInsets.symmetric(horizontal: badgePadH, vertical: badgePadV),
                    decoration: BoxDecoration(
                      color: Colors.white.withValues(alpha: 0.15),
                      borderRadius: BorderRadius.circular(10 * widthScale),
                    ),
                    child: Text(
                      'Bersama Kelola Sampah',
                      style: TextStyle(color: Colors.white, fontSize: subtitleSize, fontWeight: FontWeight.w600),
                    ),
                  ),
                  SizedBox(height: 8 * widthScale),
                  Expanded(
                    child: Text(
                      'Platform digital pengelolaan sampah untuk warga yang lebih bersih dan berkelanjutan.',
                      style: TextStyle(color: Colors.white.withValues(alpha: 0.9), fontSize: descSize, height: 1.4),
                      maxLines: 3,
                      overflow: TextOverflow.ellipsis,
                    ),
                  ),
                  Row(
                    children: [
                      Expanded(
                        child: _buildHeroButton(
                          label: 'Laporkan',
                          icon: Icons.report_problem_outlined,
                          isPrimary: true,
                          onTap: () => Navigator.of(context).pushNamed('/login'),
                          scale: widthScale,
                        ),
                      ),
                      SizedBox(width: 10 * widthScale),
                      Expanded(
                        child: _buildHeroButton(
                          label: 'Pelajari',
                          icon: Icons.school_outlined,
                          isPrimary: false,
                          onTap: () {},
                          scale: widthScale,
                        ),
                      ),
                    ],
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildHeroButton({required String label, required IconData icon, required bool isPrimary, required VoidCallback onTap, required double scale}) {
    final padV = 10.0 * scale;
    final fontSize = 12.0 * scale;
    final iconSize = 16.0 * scale;

    if (isPrimary) {
      return GestureDetector(
        onTap: onTap,
        child: Container(
          padding: EdgeInsets.symmetric(vertical: padV),
          decoration: BoxDecoration(
            color: Colors.white,
            borderRadius: BorderRadius.circular(12 * scale),
            boxShadow: [BoxShadow(color: Colors.black.withValues(alpha: 0.15), blurRadius: 10, offset: const Offset(0, 4))],
          ),
          child: Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Icon(icon, color: const Color(0xFF059669), size: iconSize),
              SizedBox(width: 6 * scale),
              Text(label, style: TextStyle(fontSize: fontSize, fontWeight: FontWeight.w700, color: const Color(0xFF059669))),
            ],
          ),
        ),
      );
    }

    return GestureDetector(
      onTap: onTap,
      child: Container(
        padding: EdgeInsets.symmetric(vertical: padV),
        decoration: BoxDecoration(
          color: Colors.white.withValues(alpha: 0.15),
          borderRadius: BorderRadius.circular(12 * scale),
          border: Border.all(color: Colors.white.withValues(alpha: 0.3)),
        ),
        child: Row(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Text(label, style: TextStyle(fontSize: fontSize, fontWeight: FontWeight.w600, color: Colors.white)),
            SizedBox(width: 4 * scale),
            Icon(icon, color: Colors.white, size: iconSize),
          ],
        ),
      ),
    );
  }

  Widget _buildStatisticsSection(double scale) {
    final padH = 14.0 * scale;
    final titleSize = 16.0 * scale;
    final subtitleSize = 11.0 * scale;
    final gridAR = 1.2 * scale;
    final cardPad = 12.0 * scale;
    final iconSize = 16.0 * scale;
    final valueSize = 16.0 * scale;
    final labelSize = 10.0 * scale;

    final stats = [
      {'value': '120+', 'label': 'Warga Aktif', 'icon': Icons.people},
      {'value': '5 Ton', 'label': 'Sampah Dikelola', 'icon': Icons.delete_sweep},
      {'value': '85%', 'label': 'Daur Ulang', 'icon': Icons.recycling},
      {'value': '200+', 'label': 'Laporan Selesai', 'icon': Icons.check_circle},
    ];

    return Padding(
      padding: EdgeInsets.symmetric(horizontal: padH),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        mainAxisSize: MainAxisSize.min,
        children: [
          Text('Dampak Kami', style: TextStyle(fontSize: titleSize, fontWeight: FontWeight.w800, color: const Color(0xFF111827))),
          SizedBox(height: 4 * scale),
          Text('Kontribusi positif untuk lingkungan', style: TextStyle(fontSize: subtitleSize, color: Colors.grey.shade600)),
          SizedBox(height: 12 * scale),
          GridView.builder(
            shrinkWrap: true,
            physics: const NeverScrollableScrollPhysics(),
            gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
              crossAxisCount: 2,
              mainAxisSpacing: 10 * scale,
              crossAxisSpacing: 10 * scale,
              childAspectRatio: gridAR,
            ),
            itemCount: stats.length,
            itemBuilder: (context, index) {
              final stat = stats[index];
              return Container(
                padding: EdgeInsets.all(cardPad),
                decoration: BoxDecoration(
                  color: Colors.white,
                  borderRadius: BorderRadius.circular(14 * scale),
                  boxShadow: [BoxShadow(color: const Color(0xFF10B981).withValues(alpha: 0.06), blurRadius: 12, offset: const Offset(0, 4))],
                ),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    Container(
                      padding: EdgeInsets.all(6 * scale),
                      decoration: BoxDecoration(color: const Color(0xFFECFDF5), borderRadius: BorderRadius.circular(8 * scale)),
                      child: Icon(stat['icon'] as IconData, color: const Color(0xFF10B981), size: iconSize),
                    ),
                    SizedBox(height: 6 * scale),
                    Text(stat['value'] as String, style: TextStyle(fontSize: valueSize, fontWeight: FontWeight.w900, color: const Color(0xFF10B981))),
                    Text(stat['label'] as String, style: TextStyle(fontSize: labelSize, color: Colors.grey.shade600, fontWeight: FontWeight.w500)),
                  ],
                ),
              );
            },
          ),
        ],
      ),
    );
  }

  Widget _buildScheduleSection(double scale) {
    final padH = 14.0 * scale;
    final titleSize = 14.0 * scale;
    final subtitleSize = 10.0 * scale;
    final cardPad = 12.0 * scale;
    final iconSize = 20.0 * scale;
    final iconContainerSize = 40.0 * scale;
    final daySize = 12.0 * scale;
    final typeSize = 10.0 * scale;

    final schedules = [
      {'day': 'Senin', 'type': 'Sampah Organik', 'time': '07.00 - 10.00'},
      {'day': 'Rabu', 'type': 'Sampah Anorganik', 'time': '08.00 - 11.00'},
      {'day': 'Sabtu', 'type': 'Sampah B3', 'time': '09.00 - 12.00'},
    ];

    return Padding(
      padding: EdgeInsets.symmetric(horizontal: padH),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        mainAxisSize: MainAxisSize.min,
        children: [
          Row(
            mainAxisSize: MainAxisSize.min,
            children: [
              Container(
                padding: EdgeInsets.all(6 * scale),
                decoration: BoxDecoration(color: const Color(0xFFECFDF5), borderRadius: BorderRadius.circular(8 * scale)),
                child: const Icon(Icons.calendar_today, color: Color(0xFF10B981), size: 16),
              ),
              SizedBox(width: 8 * scale),
              Text('Jadwal Pengangkutan', style: TextStyle(fontSize: titleSize, fontWeight: FontWeight.w700, color: const Color(0xFF111827))),
            ],
          ),
          SizedBox(height: 4 * scale),
          Text('Jadwal pengambilan sampah terdekat', style: TextStyle(fontSize: subtitleSize, color: Colors.grey.shade600)),
          SizedBox(height: 12 * scale),
          ...schedules.map((schedule) {
            return Container(
              margin: EdgeInsets.only(bottom: 8 * scale),
              padding: EdgeInsets.all(cardPad),
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(12 * scale),
                boxShadow: [BoxShadow(color: Colors.black.withValues(alpha: 0.04), blurRadius: 10, offset: const Offset(0, 3))],
              ),
              child: Row(
                children: [
                  Container(
                    width: iconContainerSize,
                    height: iconContainerSize,
                    decoration: BoxDecoration(color: const Color(0xFFECFDF5), borderRadius: BorderRadius.circular(10 * scale)),
                    child: Icon(Icons.calendar_month, color: const Color(0xFF10B981), size: iconSize),
                  ),
                  SizedBox(width: 12 * scale),
                  Expanded(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(schedule['day'] as String, style: TextStyle(fontSize: daySize, fontWeight: FontWeight.w700, color: const Color(0xFF111827))),
                        Text(schedule['type'] as String, style: TextStyle(fontSize: typeSize, color: Colors.grey.shade600)),
                      ],
                    ),
                  ),
                  Container(
                    padding: EdgeInsets.symmetric(horizontal: 8 * scale, vertical: 4 * scale),
                    decoration: BoxDecoration(color: const Color(0xFFECFDF5), borderRadius: BorderRadius.circular(16 * scale)),
                    child: Text(schedule['time'] as String, style: TextStyle(fontSize: 9 * scale, fontWeight: FontWeight.w600, color: const Color(0xFF059669))),
                  ),
                ],
              ),
            );
          }),
        ],
      ),
    );
  }

  Widget _buildHowItWorksSection(double scale) {
    final padH = 14.0 * scale;
    final titleSize = 14.0 * scale;
    final subtitleSize = 10.0 * scale;
    final iconPad = 12.0 * scale;
    final iconSize = 20.0 * scale;
    final numSize = 16.0 * scale;
    final titleStepSize = 10.0 * scale;
    final descStepSize = 9.0 * scale;

    final steps = [
      {'num': '01', 'title': 'Laporkan', 'desc': 'Warga upload laporan', 'icon': Icons.campaign, 'color': const Color(0xFF10B981)},
      {'num': '02', 'title': 'Diproses', 'desc': 'Petugas verifikasi', 'icon': Icons.engineering, 'color': const Color(0xFF3B82F6)},
      {'num': '03', 'title': 'Diangkut', 'desc': 'Sampah diambil', 'icon': Icons.local_shipping, 'color': const Color(0xFF8B5CF6)},
    ];

    return Padding(
      padding: EdgeInsets.symmetric(horizontal: padH),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        mainAxisSize: MainAxisSize.min,
        children: [
          Row(
            mainAxisSize: MainAxisSize.min,
            children: [
              Container(
                padding: EdgeInsets.all(6 * scale),
                decoration: BoxDecoration(color: const Color(0xFFF3E8FF), borderRadius: BorderRadius.circular(8 * scale)),
                child: const Icon(Icons.auto_awesome, color: Color(0xFF8B5CF6), size: 16),
              ),
              SizedBox(width: 8 * scale),
              Text('Cara Kerja', style: TextStyle(fontSize: titleSize, fontWeight: FontWeight.w700, color: const Color(0xFF111827))),
            ],
          ),
          SizedBox(height: 4 * scale),
          Text('3 langkah mudah berkontribusi', style: TextStyle(fontSize: subtitleSize, color: Colors.grey.shade600)),
          SizedBox(height: 12 * scale),
          LayoutBuilder(
            builder: (context, constraints) {
              if (constraints.maxWidth < 300) {
                return Column(
                  children: steps.map((step) {
                    return Container(
                      margin: EdgeInsets.only(bottom: 10 * scale),
                      padding: EdgeInsets.all(iconPad),
                      decoration: BoxDecoration(
                        color: Colors.white,
                        borderRadius: BorderRadius.circular(14 * scale),
                        boxShadow: [BoxShadow(color: (step['color'] as Color).withValues(alpha: 0.1), blurRadius: 10, offset: const Offset(0, 3))],
                      ),
                      child: Row(
                        children: [
                          Container(
                            padding: EdgeInsets.all(iconPad * 0.7),
                            decoration: BoxDecoration(
                              gradient: LinearGradient(colors: [step['color'] as Color, (step['color'] as Color).withValues(alpha: 0.7)]),
                              borderRadius: BorderRadius.circular(10 * scale),
                            ),
                            child: Icon(step['icon'] as IconData, color: Colors.white, size: iconSize * 0.8),
                          ),
                          SizedBox(width: 12 * scale),
                          Expanded(
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                Row(
                                  children: [
                                    Text(step['num'] as String, style: TextStyle(fontSize: numSize, fontWeight: FontWeight.w900, color: step['color'] as Color)),
                                    SizedBox(width: 8 * scale),
                                    Text(step['title'] as String, style: TextStyle(fontSize: titleStepSize, fontWeight: FontWeight.w700, color: const Color(0xFF111827))),
                                  ],
                                ),
                                Text(step['desc'] as String, style: TextStyle(fontSize: descStepSize, color: Colors.grey.shade600)),
                              ],
                            ),
                          ),
                        ],
                      ),
                    );
                  }).toList(),
                );
              }
              return Row(
                children: steps.map((step) {
                  return Expanded(
                    child: Column(
                      children: [
                        Container(
                          padding: EdgeInsets.all(iconPad),
                          decoration: BoxDecoration(
                            gradient: LinearGradient(colors: [step['color'] as Color, (step['color'] as Color).withValues(alpha: 0.7)]),
                            borderRadius: BorderRadius.circular(14 * scale),
                            boxShadow: [BoxShadow(color: (step['color'] as Color).withValues(alpha: 0.3), blurRadius: 10, offset: const Offset(0, 3))],
                          ),
                          child: Icon(step['icon'] as IconData, color: Colors.white, size: iconSize),
                        ),
                        SizedBox(height: 8 * scale),
                        Text(step['num'] as String, style: TextStyle(fontSize: numSize, fontWeight: FontWeight.w900, color: step['color'] as Color)),
                        Text(step['title'] as String, textAlign: TextAlign.center, style: TextStyle(fontSize: titleStepSize, fontWeight: FontWeight.w700, color: const Color(0xFF111827))),
                        Text(step['desc'] as String, textAlign: TextAlign.center, style: TextStyle(fontSize: descStepSize, color: Colors.grey.shade600, height: 1.3)),
                      ],
                    ),
                  );
                }).toList(),
              );
            },
          ),
        ],
      ),
    );
  }

  Widget _buildActivitiesSection(double scale) {
    final padH = 14.0 * scale;
    final titleSize = 14.0 * scale;
    final subtitleSize = 10.0 * scale;
    final gridAR = 0.95 * scale;
    final iconPad = 8.0 * scale;
    final iconSize = 20.0 * scale;
    final labelSize = 10.0 * scale;

    final activities = [
      {'icon': Icons.groups, 'label': 'Gotong Royong', 'color': const Color(0xFF10B981)},
      {'icon': Icons.recycling, 'label': 'Pilah Sampah', 'color': const Color(0xFF3B82F6)},
      {'icon': Icons.school, 'label': 'Edukasi', 'color': const Color(0xFF8B5CF6)},
      {'icon': Icons.eco, 'label': 'Hijaukan', 'color': const Color(0xFFF59E0B)},
      {'icon': Icons.compost, 'label': 'Buat Kompos', 'color': const Color(0xFFEC4899)},
      {'icon': Icons.volunteer_activism, 'label': 'Komunitas', 'color': const Color(0xFF06B6D4)},
    ];

    return Padding(
      padding: EdgeInsets.symmetric(horizontal: padH),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        mainAxisSize: MainAxisSize.min,
        children: [
          Row(
            mainAxisSize: MainAxisSize.min,
            children: [
              Container(
                padding: EdgeInsets.all(6 * scale),
                decoration: BoxDecoration(color: const Color(0xFFFEF3C7), borderRadius: BorderRadius.circular(8 * scale)),
                child: const Icon(Icons.photo_library, color: Color(0xFFF59E0B), size: 16),
              ),
              SizedBox(width: 8 * scale),
              Text('Kegiatan TPS', style: TextStyle(fontSize: titleSize, fontWeight: FontWeight.w700, color: const Color(0xFF111827))),
            ],
          ),
          SizedBox(height: 4 * scale),
          Text('Aktivitas warga dalam menjaga lingkungan', style: TextStyle(fontSize: subtitleSize, color: Colors.grey.shade600)),
          SizedBox(height: 12 * scale),
          GridView.builder(
            shrinkWrap: true,
            physics: const NeverScrollableScrollPhysics(),
            gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
              crossAxisCount: 3,
              mainAxisSpacing: 8 * scale,
              crossAxisSpacing: 8 * scale,
              childAspectRatio: gridAR,
            ),
            itemCount: activities.length,
            itemBuilder: (context, index) {
              final activity = activities[index];
              return Container(
                decoration: BoxDecoration(
                  gradient: LinearGradient(
                    begin: Alignment.topLeft,
                    end: Alignment.bottomRight,
                    colors: [(activity['color'] as Color).withValues(alpha: 0.15), (activity['color'] as Color).withValues(alpha: 0.05)],
                  ),
                  borderRadius: BorderRadius.circular(12 * scale),
                  border: Border.all(color: (activity['color'] as Color).withValues(alpha: 0.2)),
                ),
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    Container(
                      padding: EdgeInsets.all(iconPad),
                      decoration: BoxDecoration(
                        color: (activity['color'] as Color).withValues(alpha: 0.2),
                        shape: BoxShape.circle,
                      ),
                      child: Icon(activity['icon'] as IconData, color: activity['color'] as Color, size: iconSize),
                    ),
                    SizedBox(height: 6 * scale),
                    Padding(
                      padding: EdgeInsets.symmetric(horizontal: 4 * scale),
                      child: Text(
                        activity['label'] as String,
                        textAlign: TextAlign.center,
                        style: TextStyle(fontSize: labelSize, fontWeight: FontWeight.w600, color: activity['color'] as Color),
                        maxLines: 1,
                        overflow: TextOverflow.ellipsis,
                      ),
                    ),
                  ],
                ),
              );
            },
          ),
        ],
      ),
    );
  }

  Widget _buildTestimonialsSection(double scale) {
    final padH = 14.0 * scale;
    final titleSize = 14.0 * scale;
    final subtitleSize = 10.0 * scale;
    final cardPad = 14.0 * scale;
    final avatarSize = 40.0 * scale;
    final avatarFontSize = 16.0 * scale;
    final nameSize = 12.0 * scale;
    final roleSize = 9.0 * scale;
    final messageSize = 11.0 * scale;

    final testimonials = [
      {'name': 'Ibu Sari', 'role': 'Warga RT 03', 'message': 'Aplikasi ini sangat membantu kami melaporkan sampah. Responsnya cepat.', 'avatar': 'S', 'color': const Color(0xFF10B981)},
      {'name': 'Pak Budi', 'role': 'Ketua RW 02', 'message': 'Platform digital ini membuat pengelolaan sampah lebih terstruktur.', 'avatar': 'B', 'color': const Color(0xFF3B82F6)},
    ];

    return Padding(
      padding: EdgeInsets.symmetric(horizontal: padH),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        mainAxisSize: MainAxisSize.min,
        children: [
          Row(
            mainAxisSize: MainAxisSize.min,
            children: [
              Container(
                padding: EdgeInsets.all(6 * scale),
                decoration: BoxDecoration(color: const Color(0xFFEFF6FF), borderRadius: BorderRadius.circular(8 * scale)),
                child: const Icon(Icons.format_quote, color: Color(0xFF3B82F6), size: 16),
              ),
              SizedBox(width: 8 * scale),
              Text('Testimoni Warga', style: TextStyle(fontSize: titleSize, fontWeight: FontWeight.w700, color: const Color(0xFF111827))),
            ],
          ),
          SizedBox(height: 4 * scale),
          Text('Apa kata mereka tentang aplikasi kami', style: TextStyle(fontSize: subtitleSize, color: Colors.grey.shade600)),
          SizedBox(height: 12 * scale),
          ...testimonials.map((t) {
            return Container(
              margin: EdgeInsets.only(bottom: 10 * scale),
              padding: EdgeInsets.all(cardPad),
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(16 * scale),
                boxShadow: [BoxShadow(color: Colors.black.withValues(alpha: 0.04), blurRadius: 12, offset: const Offset(0, 3))],
              ),
              child: Row(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Container(
                    width: avatarSize,
                    height: avatarSize,
                    decoration: BoxDecoration(
                      gradient: LinearGradient(colors: [t['color'] as Color, (t['color'] as Color).withValues(alpha: 0.7)]),
                      borderRadius: BorderRadius.circular(12 * scale),
                    ),
                    child: Center(child: Text(t['avatar'] as String, style: TextStyle(fontSize: avatarFontSize, fontWeight: FontWeight.w800, color: Colors.white))),
                  ),
                  SizedBox(width: 12 * scale),
                  Expanded(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Row(
                          children: [
                            Text(t['name'] as String, style: TextStyle(fontSize: nameSize, fontWeight: FontWeight.w700, color: const Color(0xFF111827))),
                            SizedBox(width: 6 * scale),
                            Container(
                              padding: EdgeInsets.symmetric(horizontal: 6 * scale, vertical: 2 * scale),
                              decoration: BoxDecoration(
                                color: (t['color'] as Color).withValues(alpha: 0.1),
                                borderRadius: BorderRadius.circular(6 * scale),
                              ),
                              child: Text(t['role'] as String, style: TextStyle(fontSize: roleSize, color: t['color'] as Color, fontWeight: FontWeight.w600)),
                            ),
                          ],
                        ),
                        SizedBox(height: 6 * scale),
                        Row(children: List.generate(5, (i) => Icon(Icons.star, size: 11 * scale, color: Colors.orange.shade400))),
                        SizedBox(height: 6 * scale),
                        Text(t['message'] as String, style: TextStyle(fontSize: messageSize, color: Colors.grey.shade600, height: 1.4)),
                      ],
                    ),
                  ),
                ],
              ),
            );
          }),
        ],
      ),
    );
  }

  Widget _buildAboutSection(double scale) {
    final marginH = 14.0 * scale;
    final pad = 16.0 * scale;
    final titleSize = 14.0 * scale;
    final subtitleSize = 10.0 * scale;
    final iconPad = 10.0 * scale;
    final iconSize = 20.0 * scale;
    final textSize = 11.0 * scale;
    final chipPadH = 8.0 * scale;
    final chipPadV = 6.0 * scale;
    final chipIconSize = 12.0 * scale;
    final chipTextSize = 10.0 * scale;

    return Container(
      margin: EdgeInsets.symmetric(horizontal: marginH),
      padding: EdgeInsets.all(pad),
      decoration: BoxDecoration(
        gradient: const LinearGradient(
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
          colors: [Color(0xFFECFDF5), Color(0xFFDCFCE7)],
        ),
        borderRadius: BorderRadius.circular(20 * scale),
        border: Border.all(color: const Color(0xFFD1FAE5)),
        boxShadow: [BoxShadow(color: const Color(0xFF10B981).withValues(alpha: 0.08), blurRadius: 16, offset: const Offset(0, 6))],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        mainAxisSize: MainAxisSize.min,
        children: [
          Row(
            children: [
              Container(
                padding: EdgeInsets.all(iconPad),
                decoration: BoxDecoration(
                  color: const Color(0xFF10B981),
                  borderRadius: BorderRadius.circular(12 * scale),
                  boxShadow: [BoxShadow(color: const Color(0xFF10B981).withValues(alpha: 0.3), blurRadius: 6, offset: const Offset(0, 3))],
                ),
                child: Icon(Icons.eco, color: Colors.white, size: iconSize),
              ),
              SizedBox(width: 12 * scale),
              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text('Tentang TPS 3R Brama Muda', style: TextStyle(fontSize: titleSize, fontWeight: FontWeight.w800, color: const Color(0xFF065F46))),
                    Text('Pusat Pengelolaan Sampah Ramah Lingkungan', style: TextStyle(fontSize: subtitleSize, color: const Color(0xFF047857), fontWeight: FontWeight.w500)),
                  ],
                ),
              ),
            ],
          ),
          SizedBox(height: 14 * scale),
          Text(
            'TPS 3R Brama Muda adalah pusat pengelolaan sampah reduce, reuse, recycle yang melayani warga untuk lingkungan yang lebih bersih.',
            style: TextStyle(fontSize: textSize, color: const Color(0xFF374151), height: 1.5),
          ),
          SizedBox(height: 12 * scale),
          Wrap(
            spacing: 6 * scale,
            runSpacing: 6 * scale,
            children: [
              _buildChip(Icons.location_on_outlined, 'Jl. Hijau Berseri', chipPadH, chipPadV, chipIconSize, chipTextSize, scale),
              _buildChip(Icons.phone, '+62 812-3456-7890', chipPadH, chipPadV, chipIconSize, chipTextSize, scale),
              _buildChip(Icons.email, 'info@bramamuda.id', chipPadH, chipPadV, chipIconSize, chipTextSize, scale),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildChip(IconData icon, String label, double padH, double padV, double iconSize, double textSize, double scale) {
    return Container(
      padding: EdgeInsets.symmetric(horizontal: padH, vertical: padV),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16 * scale),
        border: Border.all(color: const Color(0xFFD1FAE5)),
      ),
      child: Row(
        mainAxisSize: MainAxisSize.min,
        children: [
          Icon(icon, size: iconSize, color: const Color(0xFF059669)),
          SizedBox(width: 4 * scale),
          Text(label, style: TextStyle(fontSize: textSize, color: const Color(0xFF374151), fontWeight: FontWeight.w500)),
        ],
      ),
    );
  }

  Widget _buildFooter(double scale, double bottomPadding) {
    final pad = 16.0 * scale;
    final iconSize = 16.0 * scale;
    final logoPad = 8.0 * scale;
    final titleSize = 12.0 * scale;
    final subtitleSize = 10.0 * scale;
    final copySize = 10.0 * scale;

    return Container(
      padding: EdgeInsets.all(pad),
      decoration: BoxDecoration(color: Colors.white, border: Border(top: BorderSide(color: Color(0xFFE5E7EB)))),
      child: Column(
        children: [
          Row(
            children: [
              Container(
                padding: EdgeInsets.all(logoPad),
                decoration: BoxDecoration(color: const Color(0xFFECFDF5), borderRadius: BorderRadius.circular(10 * scale)),
                child: Icon(Icons.eco, color: const Color(0xFF10B981), size: iconSize),
              ),
              SizedBox(width: 10 * scale),
              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text('TPS 3R Brama Muda', style: TextStyle(fontSize: titleSize, fontWeight: FontWeight.w800, color: const Color(0xFF111827))),
                    Text('Smart Waste Platform', style: TextStyle(fontSize: subtitleSize, color: const Color(0xFF10B981), fontWeight: FontWeight.w600)),
                  ],
                ),
              ),
            ],
          ),
          SizedBox(height: 16 * scale),
          Container(
            padding: EdgeInsets.symmetric(vertical: 12 * scale, horizontal: 16 * scale),
            decoration: BoxDecoration(color: const Color(0xFFF0FDF4), borderRadius: BorderRadius.circular(12 * scale)),
            child: Row(
              mainAxisAlignment: MainAxisAlignment.spaceAround,
              children: [
                Icon(Icons.public, size: iconSize, color: Colors.grey.shade400),
                Icon(Icons.play_circle_outline, size: iconSize, color: Colors.grey.shade400),
                Icon(Icons.chat_bubble_outline, size: iconSize, color: Colors.grey.shade400),
                Icon(Icons.link, size: iconSize, color: Colors.grey.shade400),
              ],
            ),
          ),
          SizedBox(height: 16 * scale),
          const Divider(color: Color(0xFFE5E7EB)),
          SizedBox(height: 12 * scale),
          Text(
            '© 2026 TPS 3R Brama Muda. All rights reserved.',
            textAlign: TextAlign.center,
            style: TextStyle(fontSize: copySize, color: Colors.grey.shade500),
          ),
          SizedBox(height: bottomPadding + 12),
        ],
      ),
    );
  }
}