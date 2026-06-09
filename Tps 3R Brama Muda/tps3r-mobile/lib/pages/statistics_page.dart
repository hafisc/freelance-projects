import 'package:flutter/material.dart';
import '../widgets/chart_widgets.dart';

class StatisticsPage extends StatefulWidget {
  const StatisticsPage({super.key});

  @override
  State<StatisticsPage> createState() => _StatisticsPageState();
}

class _StatisticsPageState extends State<StatisticsPage> with SingleTickerProviderStateMixin {
  late TabController _tabController;
  int _selectedPeriod = 0; // 0 = Mingguan, 1 = Bulanan, 2 = Tahunan

  // Sample data untuk berbagai periode
  final Map<String, Map<String, double>> _periodData = {
    'mingguan': {'Organik': 44, 'Anorganik': 20, 'Daur Ulang': 36},
    'bulanan': {'Organik': 180, 'Anorganik': 85, 'Daur Ulang': 150},
    'tahunan': {'Organik': 2160, 'Anorganik': 1020, 'Daur Ulang': 1800},
  };

  // Summary data
  final List<Map<String, dynamic>> _summaryCards = [
    {'icon': Icons.delete_outline, 'label': 'Sampah Hari Ini', 'value': '127', 'unit': 'kg', 'increase': '+12%'},
    {'icon': Icons.recycling, 'label': 'Daur Ulang', 'value': '89', 'unit': 'kg', 'increase': '+8%'},
    {'icon': Icons.report_outlined, 'label': 'Laporan Masuk', 'value': '24', 'unit': 'laporan', 'increase': '+5%'},
    {'icon': Icons.people_outline, 'label': 'Warga Aktif', 'value': '156', 'unit': 'orang', 'increase': '+3%'},
  ];

  // Insight data
  final List<Map<String, dynamic>> _insights = [
    {'icon': Icons.trending_up, 'text': 'Daur ulang meningkat 12% dibanding minggu lalu', 'color': const Color(0xFF10B981)},
    {'icon': Icons.eco, 'text': 'Sampah organik mendominasi dengan 55% total sampah', 'color': const Color(0xFF34D399)},
    {'icon': Icons.check_circle_outline, 'text': 'Pengangkutan tepat waktu 98% sepanjang minggu ini', 'color': const Color(0xFF3B82F6)},
  ];

  // Edukasi data
  final List<Map<String, dynamic>> _edukasiItems = [
    {'title': 'Cara Mengolah Sampah Organik', 'subtitle': '5 menit baca', 'icon': Icons.compost},
    {'title': 'Manfaat Daur Ulang Plastik', 'subtitle': '4 menit baca', 'icon': Icons.recycling},
    {'title': 'Pisahkan Sampah dengan Benar', 'subtitle': '3 menit baca', 'icon': Icons.sort},
  ];

  // Tips data
  final List<Map<String, dynamic>> _tips = [
    {'title': 'Gunakan tas belanja sendiri', 'icon': Icons.shopping_bag_outlined},
    {'title': 'Kurangi plastik sekali pakai', 'icon': Icons.block_outlined},
    {'title': 'Buat compost dari sisa makanan', 'icon': Icons.grass_outlined},
    {'title': 'Pilah sampah sebelum buang', 'icon': Icons.category_outlined},
  ];

  @override
  void initState() {
    super.initState();
    _tabController = TabController(length: 3, vsync: this);
  }

  @override
  void dispose() {
    _tabController.dispose();
    super.dispose();
  }

  String _getCurrentPeriodKey() {
    switch (_selectedPeriod) {
      case 0: return 'mingguan';
      case 1: return 'bulanan';
      case 2: return 'tahunan';
      default: return 'mingguan';
    }
  }

  @override
  Widget build(BuildContext context) {
    final bottomPadding = MediaQuery.of(context).padding.bottom;
    final screenHeight = MediaQuery.of(context).size.height;
    final currentData = _periodData[_getCurrentPeriodKey()]!;

    return Scaffold(
      backgroundColor: const Color(0xFFF4FBF7),
      body: SafeArea(
        child: SingleChildScrollView(
          physics: const BouncingScrollPhysics(),
          child: ConstrainedBox(
            constraints: BoxConstraints(
              minHeight: screenHeight - bottomPadding - 80,
            ),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              mainAxisSize: MainAxisSize.min,
              children: [
                // Header Modern
                _buildHeader(),
                const SizedBox(height: 16),

                // Mini Summary Cards
                Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 16),
                  child: _buildSummaryCards(),
                ),
                const SizedBox(height: 16),

                // Insight Section
                Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 16),
                  child: _buildInsightSection(),
                ),
                const SizedBox(height: 16),

                // Period Tab Selector
                _buildPeriodSelector(),
                const SizedBox(height: 12),

                // Charts Section
                Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 16),
                  child: _buildChartsSection(currentData),
                ),
                const SizedBox(height: 16),

                // Pie Chart Section
                Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 16),
                  child: _buildPieChartSection(currentData),
                ),
                const SizedBox(height: 16),

                // Edukasi Section
                Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 16),
                  child: _buildEdukasiSection(),
                ),
                const SizedBox(height: 16),

                // Tips Section
                Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 16),
                  child: _buildTipsSection(),
                ),
                const SizedBox(height: 16),

                // Data Summary Card
                Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 16),
                  child: _buildDataSummaryCard(),
                ),
                const SizedBox(height: 24),

                // Extra padding for bottom nav
                SizedBox(height: bottomPadding + 60),
              ],
            ),
          ),
        ),
      ),
    );
  }

  Widget _buildHeader() {
    return LayoutBuilder(
      builder: (context, constraints) {
        final isSmall = constraints.maxWidth < 380;
        final isVerySmall = constraints.maxWidth < 320;

        return Container(
          margin: const EdgeInsets.all(16),
          padding: EdgeInsets.all(isVerySmall ? 16 : (isSmall ? 20 : 24)),
          decoration: BoxDecoration(
            gradient: LinearGradient(
              begin: Alignment.topLeft,
              end: Alignment.bottomRight,
              colors: [
                const Color(0xFF10B981),
                const Color(0xFF059669).withValues(alpha: 0.9),
              ],
            ),
            borderRadius: BorderRadius.circular(24),
            boxShadow: [
              BoxShadow(
                color: const Color(0xFF10B981).withValues(alpha: 0.3),
                blurRadius: 20,
                offset: const Offset(0, 10),
              ),
            ],
          ),
          child: Row(
            children: [
              // Left content
              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    // Logo badge
                    Container(
                      padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                      decoration: BoxDecoration(
                        color: Colors.white.withValues(alpha: 0.2),
                        borderRadius: BorderRadius.circular(20),
                      ),
                      child: const Row(
                        mainAxisSize: MainAxisSize.min,
                        children: [
                          Icon(Icons.eco, color: Colors.white, size: 12),
                          SizedBox(width: 4),
                          Text(
                            'Smart Analytics',
                            style: TextStyle(
                              color: Colors.white,
                              fontSize: 10,
                              fontWeight: FontWeight.w700,
                            ),
                          ),
                        ],
                      ),
                    ),
                    SizedBox(height: isVerySmall ? 8 : 12),
                    Text(
                      isVerySmall ? 'Statistik' : (isSmall ? 'Statistik\nLingkungan' : 'Statistik\nLingkungan'),
                      style: TextStyle(
                        color: Colors.white,
                        fontSize: isVerySmall ? 18 : (isSmall ? 22 : 28),
                        fontWeight: FontWeight.w900,
                        height: 1.2,
                      ),
                    ),
                    SizedBox(height: isVerySmall ? 4 : 8),
                    if (!isVerySmall)
                      Text(
                        isSmall ? 'Pantau pengelolaan sampah' : 'Pantau perkembangan pengelolaan\nsampah warga secara real-time',
                        style: TextStyle(
                          color: Colors.white.withValues(alpha: 0.9),
                          fontSize: isSmall ? 10 : 13,
                          fontWeight: FontWeight.w500,
                          height: 1.4,
                        ),
                      ),
                  ],
                ),
              ),
              // Right illustration (only on medium+ screens)
              if (!isSmall)
                Padding(
                  padding: const EdgeInsets.only(left: 8),
                  child: Column(
                    mainAxisSize: MainAxisSize.min,
                    children: [
                      _buildMiniIcon(Icons.recycling, Colors.white.withValues(alpha: 0.9)),
                      const SizedBox(height: 6),
                      _buildMiniIcon(Icons.park, Colors.white.withValues(alpha: 0.7)),
                      const SizedBox(height: 6),
                      _buildMiniIcon(Icons.compost, Colors.white.withValues(alpha: 0.5)),
                    ],
                  ),
                ),
            ],
          ),
        );
      },
    );
  }

  Widget _buildMiniIcon(IconData icon, Color color) {
    return Container(
      padding: const EdgeInsets.all(8),
      decoration: BoxDecoration(
        color: Colors.white.withValues(alpha: 0.15),
        borderRadius: BorderRadius.circular(10),
      ),
      child: Icon(icon, color: color, size: 20),
    );
  }

  Widget _buildSummaryCards() {
    return LayoutBuilder(
      builder: (context, constraints) {
        final isSmall = constraints.maxWidth < 400;
        final isVerySmall = constraints.maxWidth < 320;

        return GridView.builder(
          shrinkWrap: true,
          physics: const NeverScrollableScrollPhysics(),
          gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
            crossAxisCount: isVerySmall ? 2 : (isSmall ? 2 : 4),
            mainAxisSpacing: 10,
            crossAxisSpacing: 10,
            childAspectRatio: isVerySmall ? 1.0 : (isSmall ? 1.1 : 1.3),
          ),
          itemCount: _summaryCards.length,
          itemBuilder: (context, index) {
            final item = _summaryCards[index];
            return _buildSummaryCard(
              icon: item['icon'] as IconData,
              label: item['label'] as String,
              value: item['value'] as String,
              unit: item['unit'] as String,
              increase: item['increase'] as String,
              isSmall: isSmall,
            );
          },
        );
      },
    );
  }

  Widget _buildSummaryCard({
    required IconData icon,
    required String label,
    required String value,
    required String unit,
    required String increase,
    bool isSmall = false,
  }) {
    return Container(
      padding: const EdgeInsets.all(12),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withValues(alpha: 0.04),
            blurRadius: 10,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Container(
            padding: const EdgeInsets.all(8),
            decoration: BoxDecoration(
              color: const Color(0xFFECFDF5),
              borderRadius: BorderRadius.circular(10),
            ),
            child: Icon(icon, color: const Color(0xFF10B981), size: 16),
          ),
          Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Row(
                crossAxisAlignment: CrossAxisAlignment.end,
                children: [
                  Flexible(
                    child: Text(
                      value,
                      style: const TextStyle(
                        fontSize: 20,
                        fontWeight: FontWeight.w900,
                        color: Color(0xFF111827),
                      ),
                    ),
                  ),
                  const SizedBox(width: 2),
                  Padding(
                    padding: const EdgeInsets.only(bottom: 2),
                    child: Text(
                      unit,
                      style: const TextStyle(
                        fontSize: 10,
                        fontWeight: FontWeight.w500,
                        color: Color(0xFF9CA3AF),
                      ),
                    ),
                  ),
                ],
              ),
              const SizedBox(height: 2),
              Text(
                label,
                style: const TextStyle(
                  fontSize: 10,
                  fontWeight: FontWeight.w600,
                  color: Color(0xFF6B7280),
                ),
                maxLines: 1,
                overflow: TextOverflow.ellipsis,
              ),
              const SizedBox(height: 4),
              Container(
                padding: const EdgeInsets.symmetric(horizontal: 5, vertical: 2),
                decoration: BoxDecoration(
                  color: const Color(0xFF10B981).withValues(alpha: 0.1),
                  borderRadius: BorderRadius.circular(6),
                ),
                child: Text(
                  increase,
                  style: const TextStyle(
                    fontSize: 9,
                    fontWeight: FontWeight.w700,
                    color: Color(0xFF10B981),
                  ),
                ),
              ),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildInsightSection() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Row(
          children: [
            Container(
              padding: const EdgeInsets.all(8),
              decoration: BoxDecoration(
                color: const Color(0xFFECFDF5),
                borderRadius: BorderRadius.circular(10),
              ),
              child: const Icon(Icons.lightbulb_outline, color: Color(0xFF10B981), size: 18),
            ),
            const SizedBox(width: 10),
            const Text(
              'Insight',
              style: TextStyle(
                fontSize: 18,
                fontWeight: FontWeight.w800,
                color: Color(0xFF111827),
              ),
            ),
          ],
        ),
        const SizedBox(height: 12),
        ...List.generate(_insights.length, (index) {
          final insight = _insights[index];
          return Container(
            margin: EdgeInsets.only(bottom: index < _insights.length - 1 ? 10 : 0),
            padding: const EdgeInsets.all(14),
            decoration: BoxDecoration(
              color: (insight['color'] as Color).withValues(alpha: 0.08),
              borderRadius: BorderRadius.circular(14),
              border: Border.all(
                color: (insight['color'] as Color).withValues(alpha: 0.15),
              ),
            ),
            child: Row(
              children: [
                Container(
                  padding: const EdgeInsets.all(8),
                  decoration: BoxDecoration(
                    color: (insight['color'] as Color).withValues(alpha: 0.15),
                    borderRadius: BorderRadius.circular(10),
                  ),
                  child: Icon(insight['icon'] as IconData, color: insight['color'] as Color, size: 18),
                ),
                const SizedBox(width: 12),
                Expanded(
                  child: Text(
                    insight['text'] as String,
                    style: const TextStyle(
                      fontSize: 13,
                      fontWeight: FontWeight.w500,
                      color: Color(0xFF374151),
                    ),
                  ),
                ),
              ],
            ),
          );
        }),
      ],
    );
  }

  Widget _buildPeriodSelector() {
    return Container(
      margin: const EdgeInsets.symmetric(horizontal: 16),
      padding: const EdgeInsets.all(4),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withValues(alpha: 0.04),
            blurRadius: 12,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Row(
        children: [
          _buildPeriodTab(0, 'Mingguan'),
          _buildPeriodTab(1, 'Bulanan'),
          _buildPeriodTab(2, 'Tahunan'),
        ],
      ),
    );
  }

  Widget _buildPeriodTab(int index, String label) {
    final isSelected = _selectedPeriod == index;
    return Expanded(
      child: GestureDetector(
        onTap: () => setState(() => _selectedPeriod = index),
        child: AnimatedContainer(
          duration: const Duration(milliseconds: 200),
          padding: const EdgeInsets.symmetric(vertical: 12),
          decoration: BoxDecoration(
            gradient: isSelected
                ? const LinearGradient(
                    colors: [Color(0xFF10B981), Color(0xFF059669)],
                  )
                : null,
            borderRadius: BorderRadius.circular(14),
          ),
          child: Text(
            label,
            textAlign: TextAlign.center,
            style: TextStyle(
              fontSize: 13,
              fontWeight: FontWeight.w700,
              color: isSelected ? Colors.white : const Color(0xFF6B7280),
            ),
          ),
        ),
      ),
    );
  }

  Widget _buildChartsSection(Map<String, double> data) {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(20),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withValues(alpha: 0.04),
            blurRadius: 16,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            children: [
              Container(
                padding: const EdgeInsets.all(8),
                decoration: BoxDecoration(
                  color: const Color(0xFFECFDF5),
                  borderRadius: BorderRadius.circular(10),
                ),
                child: const Icon(Icons.bar_chart, color: Color(0xFF10B981), size: 18),
              ),
              const SizedBox(width: 10),
              const Text(
                'Tren Sampah',
                style: TextStyle(
                  fontSize: 16,
                  fontWeight: FontWeight.w700,
                  color: Color(0xFF111827),
                ),
              ),
            ],
          ),
          const SizedBox(height: 16),
          SizedBox(
            height: 180,
            child: BarChartWidget(data: data),
          ),
        ],
      ),
    );
  }

  Widget _buildPieChartSection(Map<String, double> data) {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(20),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withValues(alpha: 0.04),
            blurRadius: 16,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            children: [
              Container(
                padding: const EdgeInsets.all(8),
                decoration: BoxDecoration(
                  color: const Color(0xFFECFDF5),
                  borderRadius: BorderRadius.circular(10),
                ),
                child: const Icon(Icons.pie_chart_outline, color: Color(0xFF10B981), size: 18),
              ),
              const SizedBox(width: 10),
              const Expanded(
                child: Text(
                  'Distribusi Sampah',
                  style: TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.w700,
                    color: Color(0xFF111827),
                  ),
                ),
              ),
            ],
          ),
          const SizedBox(height: 16),
          LayoutBuilder(
            builder: (context, constraints) {
              final isWide = constraints.maxWidth > 500;
              final chartSize = isWide ? 140.0 : 120.0;
              if (isWide) {
                return Row(
                  crossAxisAlignment: CrossAxisAlignment.center,
                  children: [
                    SizedBox(
                      width: chartSize,
                      height: chartSize,
                      child: PieChartWidget(data: data),
                    ),
                    const SizedBox(width: 16),
                    Expanded(
                      child: _buildLegendSection(data),
                    ),
                  ],
                );
              } else {
                return Column(
                  children: [
                    SizedBox(
                      width: chartSize,
                      height: chartSize,
                      child: Center(child: PieChartWidget(data: data)),
                    ),
                    const SizedBox(height: 12),
                    _buildLegendSection(data),
                  ],
                );
              }
            },
          ),
          const SizedBox(height: 12),
          Container(
            padding: const EdgeInsets.all(10),
            decoration: BoxDecoration(
              color: const Color(0xFFECFDF5),
              borderRadius: BorderRadius.circular(12),
            ),
            child: Row(
              children: [
                const Icon(Icons.eco, color: Color(0xFF10B981), size: 14),
                const SizedBox(width: 6),
                const Expanded(
                  child: Text(
                    'Sampah organik paling banyak dikelola',
                    style: TextStyle(
                      fontSize: 11,
                      fontWeight: FontWeight.w500,
                      color: Color(0xFF059669),
                    ),
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildLegendSection(Map<String, double> data) {
    final legendItems = [
      {'label': 'Organik', 'value': data['Organik']!, 'color': const Color(0xFF10B981)},
      {'label': 'Anorganik', 'value': data['Anorganik']!, 'color': const Color(0xFF3B82F6)},
      {'label': 'Daur Ulang', 'value': data['Daur Ulang']!, 'color': const Color(0xFFF59E0B)},
    ];

    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: legendItems.map((item) {
        return Container(
          margin: const EdgeInsets.only(bottom: 10),
          padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 10),
          decoration: BoxDecoration(
            color: (item['color'] as Color).withValues(alpha: 0.08),
            borderRadius: BorderRadius.circular(10),
          ),
          child: Row(
            children: [
              Container(
                width: 12,
                height: 12,
                decoration: BoxDecoration(
                  color: item['color'] as Color,
                  borderRadius: BorderRadius.circular(4),
                ),
              ),
              const SizedBox(width: 10),
              Expanded(
                child: Text(
                  item['label'] as String,
                  style: const TextStyle(
                    fontSize: 13,
                    fontWeight: FontWeight.w600,
                    color: Color(0xFF374151),
                  ),
                ),
              ),
              Text(
                '${(item['value'] as double).toStringAsFixed(0)}kg',
                style: TextStyle(
                  fontSize: 13,
                  fontWeight: FontWeight.w700,
                  color: item['color'] as Color,
                ),
              ),
            ],
          ),
        );
      }).toList(),
    );
  }

  Widget _buildEdukasiSection() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      mainAxisSize: MainAxisSize.min,
      children: [
        Row(
          mainAxisSize: MainAxisSize.min,
          children: [
            Container(
              padding: const EdgeInsets.all(8),
              decoration: BoxDecoration(
                color: const Color(0xFFFEF3C7),
                borderRadius: BorderRadius.circular(10),
              ),
              child: const Icon(Icons.school_outlined, color: Color(0xFFF59E0B), size: 18),
            ),
            const SizedBox(width: 10),
            const Text(
              'Edukasi Daur Ulang',
              style: TextStyle(
                fontSize: 18,
                fontWeight: FontWeight.w800,
                color: Color(0xFF111827),
              ),
            ),
          ],
        ),
        const SizedBox(height: 12),
        SizedBox(
          height: 115,
          child: ListView.builder(
            scrollDirection: Axis.horizontal,
            itemCount: _edukasiItems.length,
            itemBuilder: (context, index) {
              final item = _edukasiItems[index];
              return Container(
                width: 170,
                margin: EdgeInsets.only(right: index < _edukasiItems.length - 1 ? 10 : 0),
                padding: const EdgeInsets.all(12),
                decoration: BoxDecoration(
                  gradient: LinearGradient(
                    begin: Alignment.topLeft,
                    end: Alignment.bottomRight,
                    colors: [
                      const Color(0xFF10B981).withValues(alpha: 0.1),
                      const Color(0xFF34D399).withValues(alpha: 0.05),
                    ],
                  ),
                  borderRadius: BorderRadius.circular(16),
                  border: Border.all(color: const Color(0xFF10B981).withValues(alpha: 0.15)),
                ),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    Container(
                      padding: const EdgeInsets.all(8),
                      decoration: BoxDecoration(
                        color: const Color(0xFF10B981).withValues(alpha: 0.15),
                        borderRadius: BorderRadius.circular(10),
                      ),
                      child: Icon(item['icon'] as IconData, color: const Color(0xFF10B981), size: 20),
                    ),
                    const SizedBox(height: 10),
                    Flexible(
                      child: Text(
                        item['title'] as String,
                        style: const TextStyle(
                          fontSize: 12,
                          fontWeight: FontWeight.w700,
                          color: Color(0xFF111827),
                        ),
                        maxLines: 2,
                        overflow: TextOverflow.ellipsis,
                      ),
                    ),
                    const Spacer(),
                    Row(
                      mainAxisSize: MainAxisSize.min,
                      children: [
                        const Icon(Icons.schedule, color: Color(0xFF6B7280), size: 11),
                        const SizedBox(width: 4),
                        Text(
                          item['subtitle'] as String,
                          style: const TextStyle(
                            fontSize: 10,
                            color: Color(0xFF6B7280),
                            fontWeight: FontWeight.w500,
                          ),
                        ),
                      ],
                    ),
                  ],
                ),
              );
            },
          ),
        ),
      ],
    );
  }

  Widget _buildTipsSection() {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(20),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withValues(alpha: 0.04),
            blurRadius: 16,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            children: [
              Container(
                padding: const EdgeInsets.all(8),
                decoration: BoxDecoration(
                  color: const Color(0xFFECFDF5),
                  borderRadius: BorderRadius.circular(10),
                ),
                child: const Icon(Icons.tips_and_updates, color: Color(0xFF10B981), size: 18),
              ),
              const SizedBox(width: 10),
              const Text(
                'Tips Lingkungan',
                style: TextStyle(
                  fontSize: 16,
                  fontWeight: FontWeight.w700,
                  color: Color(0xFF111827),
                ),
              ),
            ],
          ),
          const SizedBox(height: 12),
          ...List.generate(_tips.length, (index) {
            final tip = _tips[index];
            final isLast = index == _tips.length - 1;
            return Column(
              children: [
                Padding(
                  padding: const EdgeInsets.symmetric(vertical: 10),
                  child: Row(
                    children: [
                      Container(
                        padding: const EdgeInsets.all(8),
                        decoration: BoxDecoration(
                          color: const Color(0xFFF0FDF4),
                          borderRadius: BorderRadius.circular(10),
                        ),
                        child: Icon(tip['icon'] as IconData, color: const Color(0xFF10B981), size: 18),
                      ),
                      const SizedBox(width: 12),
                      Expanded(
                        child: Text(
                          tip['title'] as String,
                          style: const TextStyle(
                            fontSize: 13,
                            fontWeight: FontWeight.w600,
                            color: Color(0xFF374151),
                          ),
                        ),
                      ),
                      const Icon(Icons.chevron_right, color: Color(0xFF9CA3AF), size: 18),
                    ],
                  ),
                ),
                if (!isLast) Divider(height: 1, color: Colors.grey.shade100),
              ],
            );
          }),
        ],
      ),
    );
  }

  Widget _buildDataSummaryCard() {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(20),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withValues(alpha: 0.04),
            blurRadius: 16,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            children: [
              Container(
                padding: const EdgeInsets.all(8),
                decoration: BoxDecoration(
                  color: const Color(0xFFECFDF5),
                  borderRadius: BorderRadius.circular(10),
                ),
                child: const Icon(Icons.summarize_outlined, color: Color(0xFF10B981), size: 18),
              ),
              const SizedBox(width: 10),
              const Text(
                'Ringkasan Data',
                style: TextStyle(
                  fontSize: 16,
                  fontWeight: FontWeight.w700,
                  color: Color(0xFF111827),
                ),
              ),
            ],
          ),
          const SizedBox(height: 12),
          LayoutBuilder(
            builder: (context, constraints) {
              final isSmall = constraints.maxWidth < 350;
              return Wrap(
                spacing: 8,
                runSpacing: 8,
                children: [
                  _buildSummaryBadge('Organik', '44kg', const Color(0xFF10B981)),
                  _buildSummaryBadge('Anorganik', '20kg', const Color(0xFF3B82F6)),
                  _buildSummaryBadge('Daur Ulang', '36kg', const Color(0xFFF59E0B)),
                  if (!isSmall) _buildSummaryBadge('Total', '100kg', const Color(0xFF8B5CF6)),
                ],
              );
            },
          ),
        ],
      ),
    );
  }

  Widget _buildSummaryBadge(String label, String value, Color color) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 8),
      decoration: BoxDecoration(
        color: color.withValues(alpha: 0.1),
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: color.withValues(alpha: 0.2)),
      ),
      child: Column(
        mainAxisSize: MainAxisSize.min,
        children: [
          Text(
            label,
            style: TextStyle(
              fontSize: 10,
              fontWeight: FontWeight.w600,
              color: color,
            ),
          ),
          const SizedBox(height: 2),
          Text(
            value,
            style: TextStyle(
              fontSize: 14,
              fontWeight: FontWeight.w800,
              color: color,
            ),
          ),
        ],
      ),
    );
  }
}