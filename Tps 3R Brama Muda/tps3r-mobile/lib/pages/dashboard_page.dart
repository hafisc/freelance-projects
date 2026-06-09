// lib/pages/dashboard_page.dart
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../services/api_service.dart';
import '../models/waste_item.dart';
import 'waste_report_page.dart';

class DashboardPage extends StatefulWidget {
  const DashboardPage({super.key});

  @override
  State<DashboardPage> createState() => _DashboardPageState();
}

class _DashboardPageState extends State<DashboardPage> {
  // Data dari API
  List<Map<String, dynamic>> _members = [];
  List<Map<String, dynamic>> _wasteItems = [];
  Map<String, dynamic>? _tpsInfo;
  Map<String, dynamic>? _statistics;
  
  // State
  bool _isLoading = true;
  bool _isInitialized = false;
  String? _errorMessage;

  @override
  void initState() {
    super.initState();
    _loadDashboardData();
  }

  Future<void> _loadDashboardData() async {
    if (_isInitialized) {
      setState(() => _isLoading = true);
    }
    
    try {
      // Ambil data secara parallel untuk performa lebih baik
      final results = await Future.wait([
        ApiService.getMembers(),
        ApiService.getWasteItems(),
        ApiService.getTpsInfo(),
        ApiService.getStatistics(),
      ]);

      setState(() {
        // Parse members
        final membersResult = results[0];
        if (membersResult['success'] == true) {
          _members = List<Map<String, dynamic>>.from(membersResult['members'] ?? []);
        }

        // Parse waste items
        final wasteResult = results[1];
        if (wasteResult['success'] == true) {
          _wasteItems = List<Map<String, dynamic>>.from(wasteResult['waste_items'] ?? []);
        }

        // Parse TPS info
        final tpsResult = results[2];
        if (tpsResult['success'] == true) {
          _tpsInfo = tpsResult['tps_info'];
        }

        // Parse statistics
        final statsResult = results[3];
        if (statsResult['success'] == true) {
          _statistics = statsResult['statistics'];
        }

        _isInitialized = true;
        _isLoading = false;
        _errorMessage = null;
      });
    } catch (e) {
      setState(() {
        _isLoading = false;
        _errorMessage = 'Gagal memuat data. Periksa koneksi internet.';
      });
      debugPrint('Load dashboard error: $e');
    }
  }

  Future<void> _refreshData() async {
    setState(() => _isInitialized = false);
    await _loadDashboardData();
  }

  @override
  Widget build(BuildContext context) {
    final now = DateTime.now();
    final months = [
      'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
      'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    final days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
    final monthName = months[now.month - 1];
    final dayName = days[now.weekday - 1];

    return Container(
      width: double.infinity,
      color: const Color(0xFFF0FDF4),
      child: SafeArea(
        child: LayoutBuilder(
          builder: (context, constraints) {
            final isSmallScreen = constraints.maxWidth < 360;
            final horizontalPadding = isSmallScreen ? 12.0 : 16.0;

            // Loading State
            if (_isLoading && !_isInitialized) {
              return Center(
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    CircularProgressIndicator(
                      color: Color(0xFF10B981),
                    ),
                    const SizedBox(height: 16),
                    Text(
                      'Memuat data...',
                      style: TextStyle(
                        color: Color(0xFF6B7280),
                        fontSize: 14,
                      ),
                    ),
                  ],
                ),
              );
            }

            // Error State
            if (_errorMessage != null && !_isInitialized) {
              return Center(
                child: Padding(
                  padding: const EdgeInsets.all(24),
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Container(
                        padding: EdgeInsets.all(20),
                        decoration: BoxDecoration(
                          color: Color(0xFFEF4444).withValues(alpha: 0.1),
                          shape: BoxShape.circle,
                        ),
                        child: Icon(
                          Icons.cloud_off,
                          size: 48,
                          color: Color(0xFFEF4444),
                        ),
                      ),
                      const SizedBox(height: 20),
                      Text(
                        'Gagal Memuat Data',
                        style: TextStyle(
                          fontSize: 18,
                          fontWeight: FontWeight.w700,
                          color: Color(0xFF111827),
                        ),
                      ),
                      const SizedBox(height: 8),
                      Text(
                        _errorMessage!,
                        textAlign: TextAlign.center,
                        style: TextStyle(
                          color: Color(0xFF6B7280),
                          fontSize: 14,
                        ),
                      ),
                      const SizedBox(height: 24),
                      ElevatedButton.icon(
                        onPressed: _refreshData,
                        icon: Icon(Icons.refresh),
                        label: Text('Coba Lagi'),
                        style: ElevatedButton.styleFrom(
                          backgroundColor: Color(0xFF10B981),
                          foregroundColor: Colors.white,
                          padding: EdgeInsets.symmetric(horizontal: 24, vertical: 12),
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(12),
                          ),
                        ),
                      ),
                    ],
                  ),
                ),
              );
            }

            // Content
            return RefreshIndicator(
              onRefresh: _refreshData,
              color: Color(0xFF10B981),
              child: SingleChildScrollView(
                physics: const AlwaysScrollableScrollPhysics(),
                padding: EdgeInsets.symmetric(
                  horizontal: horizontalPadding,
                  vertical: 16,
                ),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    // Header Section
                    _buildWelcomeHeader(context, dayName, monthName, now, isSmallScreen),
                    const SizedBox(height: 16),

                    // Today's Collection Summary
                    _buildTodaySummary(isSmallScreen),
                    const SizedBox(height: 16),

                    // Quick Stats
                    _buildQuickStats(isSmallScreen),
                    const SizedBox(height: 16),

                    // 3R Progress
                    _build3RProgress(isSmallScreen),
                    const SizedBox(height: 16),

                    // Quick Actions
                    _buildQuickActions(context, isSmallScreen),
                    const SizedBox(height: 16),

                    // Recent Waste
                    _buildRecentWaste(isSmallScreen),
                    const SizedBox(height: 16),

                    // Team Status
                    _buildTeamStatus(isSmallScreen),
                    const SizedBox(height: 16),

                    // Environmental Tips
                    _buildEnvironmentalTips(isSmallScreen),
                    const SizedBox(height: 24),
                  ],
                ),
              ),
            );
          },
        ),
      ),
    );
  }

  // ============================================
  // GET DATA HELPERS
  // ============================================

  List<Map<String, dynamic>> get _activeMembers {
    return _members.where((m) => m['active'] == true || m['active'] == 1).toList();
  }

  double get _todayWeight {
    final today = DateTime.now();
    return _wasteItems
        .where((item) {
          final dateStr = item['date'] ?? item['created_at'];
          if (dateStr == null) return false;
          final date = DateTime.tryParse(dateStr.toString());
          if (date == null) return false;
          return date.year == today.year &&
                 date.month == today.month &&
                 date.day == today.day;
        })
        .fold<double>(0, (sum, item) => sum + ((item['weight'] ?? 0).toDouble()));
  }

  double get _todayOrganic {
    final today = DateTime.now();
    return _wasteItems
        .where((item) {
          final dateStr = item['date'] ?? item['created_at'];
          if (dateStr == null) return false;
          final date = DateTime.tryParse(dateStr.toString());
          if (date == null) return false;
          final category = (item['category'] ?? '').toString().toLowerCase();
          return date.year == today.year &&
                 date.month == today.month &&
                 date.day == today.day &&
                 category == 'organic';
        })
        .fold<double>(0, (sum, item) => sum + ((item['weight'] ?? 0).toDouble()));
  }

  double get _todayRecycle {
    final today = DateTime.now();
    return _wasteItems
        .where((item) {
          final dateStr = item['date'] ?? item['created_at'];
          if (dateStr == null) return false;
          final date = DateTime.tryParse(dateStr.toString());
          if (date == null) return false;
          final category = (item['category'] ?? '').toString().toLowerCase();
          return date.year == today.year &&
                 date.month == today.month &&
                 date.day == today.day &&
                 (category == 'recycle' || category == 'anorganic');
        })
        .fold<double>(0, (sum, item) => sum + ((item['weight'] ?? 0).toDouble()));
  }

  int get _todayCount {
    final today = DateTime.now();
    return _wasteItems.where((item) {
      final dateStr = item['date'] ?? item['created_at'];
      if (dateStr == null) return false;
      final date = DateTime.tryParse(dateStr.toString());
      if (date == null) return false;
      return date.year == today.year &&
             date.month == today.month &&
             date.day == today.day;
    }).length;
  }

  double get _totalWeight {
    return _wasteItems.fold<double>(0, (sum, item) => sum + ((item['weight'] ?? 0).toDouble()));
  }

  double get _organicStat {
    return _statistics?['organic']?.toDouble() ?? 
           _wasteItems
               .where((item) => (item['category'] ?? '').toString().toLowerCase() == 'organic')
               .fold<double>(0, (sum, item) => sum + ((item['weight'] ?? 0).toDouble()));
  }

  double get _recycleStat {
    return _statistics?['recycle']?.toDouble() ?? 
           _wasteItems
               .where((item) {
                 final cat = (item['category'] ?? '').toString().toLowerCase();
                 return cat == 'recycle' || cat == 'anorganic';
               })
               .fold<double>(0, (sum, item) => sum + ((item['weight'] ?? 0).toDouble()));
  }

  double get _inorganicStat {
    return _statistics?['inorganic']?.toDouble() ?? 0;
  }

  // ============================================
  // HEADER SECTION
  // ============================================

  Widget _buildWelcomeHeader(
    BuildContext context,
    String dayName,
    String monthName,
    DateTime now,
    bool isSmallScreen,
  ) {
    final tpsName = _tpsInfo?['name'] ?? 'TPS 3R Brama Muda';
    final tpsAddress = _tpsInfo?['address'] ?? 'Jl. Hijau Berseri No. 7';

    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        gradient: const LinearGradient(
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
          colors: [Color(0xFF10B981), Color(0xFF059669)],
        ),
        borderRadius: BorderRadius.circular(20),
        boxShadow: [
          BoxShadow(
            color: const Color(0xFF10B981).withValues(alpha: 0.3),
            blurRadius: 20,
            offset: const Offset(0, 8),
          ),
        ],
      ),
      child: Column(
        mainAxisSize: MainAxisSize.min,
        crossAxisAlignment: CrossAxisAlignment.center,
        children: [
          Container(
            width: 72,
            height: 72,
            decoration: BoxDecoration(
              color: Colors.white.withValues(alpha: 0.25),
              borderRadius: BorderRadius.circular(18),
            ),
            child: const Icon(Icons.recycling, color: Colors.white, size: 40),
          ),
          const SizedBox(height: 12),
          Text(
            tpsName,
            style: const TextStyle(
              color: Colors.white,
              fontSize: 20,
              fontWeight: FontWeight.w800,
              height: 1.2,
            ),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 4),
          Text(
            'Dashboard Operasional',
            style: TextStyle(
              color: Colors.white.withValues(alpha: 0.85),
              fontSize: 12,
              fontWeight: FontWeight.w500,
            ),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 8),
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
            decoration: BoxDecoration(
              color: Colors.white.withValues(alpha: 0.2),
              borderRadius: BorderRadius.circular(20),
            ),
            child: Row(
              mainAxisSize: MainAxisSize.min,
              children: [
                const Icon(Icons.location_on, color: Colors.white, size: 14),
                const SizedBox(width: 4),
                Flexible(
                  child: Text(
                    tpsAddress,
                    style: const TextStyle(
                      color: Colors.white,
                      fontSize: 11,
                      fontWeight: FontWeight.w500,
                    ),
                    overflow: TextOverflow.ellipsis,
                  ),
                ),
              ],
            ),
          ),
          const SizedBox(height: 16),
          Row(
            children: [
              Expanded(
                child: Container(
                  padding: const EdgeInsets.symmetric(vertical: 10),
                  decoration: BoxDecoration(
                    color: Colors.white.withValues(alpha: 0.2),
                    borderRadius: BorderRadius.circular(12),
                  ),
                  child: Row(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      const Icon(Icons.eco, color: Colors.white, size: 14),
                      const SizedBox(width: 6),
                      Flexible(
                        child: Text(
                          '$dayName, ${now.day} $monthName',
                          style: const TextStyle(
                            color: Colors.white,
                            fontSize: 11,
                            fontWeight: FontWeight.w700,
                          ),
                          overflow: TextOverflow.ellipsis,
                        ),
                      ),
                    ],
                  ),
                ),
              ),
              const SizedBox(width: 8),
              Expanded(
                child: Container(
                  padding: const EdgeInsets.symmetric(vertical: 10),
                  decoration: BoxDecoration(
                    color: Colors.white.withValues(alpha: 0.2),
                    borderRadius: BorderRadius.circular(12),
                  ),
                  child: Row(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      const Icon(Icons.wb_sunny, color: Colors.white, size: 14),
                      const SizedBox(width: 4),
                      Flexible(
                        child: Text(
                          _getGreeting(),
                          style: const TextStyle(
                            color: Colors.white,
                            fontSize: 11,
                            fontWeight: FontWeight.w600,
                          ),
                          overflow: TextOverflow.ellipsis,
                        ),
                      ),
                    ],
                  ),
                ),
              ),
            ],
          ),
        ],
      ),
    );
  }

  // ============================================
  // TODAY'S SUMMARY
  // ============================================

  Widget _buildTodaySummary(bool isSmallScreen) {
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [
          BoxShadow(
            color: const Color(0xFF10B981).withValues(alpha: 0.06),
            blurRadius: 16,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Column(
        children: [
          Row(
            children: [
              Container(
                padding: const EdgeInsets.all(10),
                decoration: BoxDecoration(
                  color: const Color(0xFFECFDF5),
                  borderRadius: BorderRadius.circular(12),
                ),
                child: const Icon(Icons.today, color: Color(0xFF059669), size: 18),
              ),
              const SizedBox(width: 12),
              const Expanded(
                child: Text(
                  'Ringkasan Hari Ini',
                  style: TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.w700,
                    color: Color(0xFF111827),
                  ),
                ),
              ),
              Container(
                padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                decoration: BoxDecoration(
                  color: const Color(0xFF10B981).withValues(alpha: 0.1),
                  borderRadius: BorderRadius.circular(20),
                ),
                child: Text(
                  _todayCount == 0 ? 'Belum ada' : '$_todayCount input',
                  style: const TextStyle(
                    color: Color(0xFF059669),
                    fontSize: 11,
                    fontWeight: FontWeight.w600,
                  ),
                ),
              ),
            ],
          ),
          const SizedBox(height: 16),
          Row(
            children: [
              Expanded(
                child: _SummaryCard(
                  icon: Icons.scale,
                  value: '${_todayWeight.toStringAsFixed(1)} kg',
                  label: 'Total Masuk',
                  color: const Color(0xFF10B981),
                  isSmallScreen: isSmallScreen,
                ),
              ),
              const SizedBox(width: 12),
              Expanded(
                child: _SummaryCard(
                  icon: Icons.grass,
                  value: '${_todayOrganic.toStringAsFixed(1)} kg',
                  label: 'Organik',
                  color: const Color(0xFF8B5CF6),
                  isSmallScreen: isSmallScreen,
                ),
              ),
              const SizedBox(width: 12),
              Expanded(
                child: _SummaryCard(
                  icon: Icons.recycling,
                  value: '${_todayRecycle.toStringAsFixed(1)} kg',
                  label: 'Daur Ulang',
                  color: const Color(0xFF3B82F6),
                  isSmallScreen: isSmallScreen,
                ),
              ),
            ],
          ),
        ],
      ),
    );
  }

  // ============================================
  // QUICK STATS
  // ============================================

  Widget _buildQuickStats(bool isSmallScreen) {
    return Row(
      children: [
        Expanded(
          child: _StatCard(
            icon: Icons.people_outline,
            value: '${_members.length}',
            label: 'Total Tim',
            color: const Color(0xFF10B981),
            bgColor: const Color(0xFFECFDF5),
            trend: '+${_activeMembers.length} Aktif',
            isSmallScreen: isSmallScreen,
          ),
        ),
        const SizedBox(width: 12),
        Expanded(
          child: _StatCard(
            icon: Icons.check_circle_outline,
            value: '${_activeMembers.length}',
            label: 'Member Aktif',
            color: const Color(0xFF3B82F6),
            bgColor: const Color(0xFFE0F2FE),
            trend: '${_members.length - _activeMembers.length} Non-Aktif',
            isSmallScreen: isSmallScreen,
          ),
        ),
        const SizedBox(width: 12),
        Expanded(
          child: _StatCard(
            icon: Icons.delete_sweep,
            value: '${_wasteItems.length}',
            label: 'Total Input',
            color: const Color(0xFFF59E0B),
            bgColor: const Color(0xFFFEF3C7),
            trend: '${_totalWeight.toStringAsFixed(0)}kg Total',
            isSmallScreen: isSmallScreen,
          ),
        ),
      ],
    );
  }

  // ============================================
  // 3R PROGRESS
  // ============================================

  Widget _build3RProgress(bool isSmallScreen) {
    final organic = _organicStat;
    final recycle = _recycleStat;
    final inorganic = _inorganicStat;
    final total = organic + recycle + inorganic;
    final organicPct = total > 0 ? (organic / total * 100).clamp(0.0, 100.0) : 0.0;
    final recyclePct = total > 0 ? (recycle / total * 100).clamp(0.0, 100.0) : 0.0;
    final inorganicPct = total > 0 ? (inorganic / total * 100).clamp(0.0, 100.0) : 0.0;

    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [
          BoxShadow(
            color: const Color(0xFF10B981).withValues(alpha: 0.06),
            blurRadius: 16,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Column(
        children: [
          Row(
            children: [
              Container(
                padding: const EdgeInsets.all(10),
                decoration: BoxDecoration(
                  color: const Color(0xFFECFDF5),
                  borderRadius: BorderRadius.circular(12),
                ),
                child: const Icon(Icons.pie_chart, color: Color(0xFF059669), size: 18),
              ),
              const SizedBox(width: 12),
              const Expanded(
                child: Text(
                  'Alur Pengelolaan 3R',
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
              final screenWidth = constraints.maxWidth;

              if (screenWidth < 300) {
                return Wrap(
                  spacing: 8,
                  runSpacing: 8,
                  children: [
                    SizedBox(
                      width: (screenWidth - 32) / 3 - 4,
                      child: _R3Card(
                        title: 'REDUCE',
                        subtitle: 'Kurangi',
                        icon: Icons.remove_circle_outline,
                        color: const Color(0xFFEF4444),
                        progress: inorganicPct,
                        value: '${inorganic.toStringAsFixed(1)} kg',
                        desc: 'Dikurangi',
                      ),
                    ),
                    SizedBox(
                      width: (screenWidth - 32) / 3 - 4,
                      child: _R3Card(
                        title: 'REUSE',
                        subtitle: 'Gunakan',
                        icon: Icons.refresh,
                        color: const Color(0xFFF59E0B),
                        progress: recyclePct,
                        value: '${recycle.toStringAsFixed(1)} kg',
                        desc: 'Dipakai ulang',
                      ),
                    ),
                    SizedBox(
                      width: (screenWidth - 32) / 3 - 4,
                      child: _R3Card(
                        title: 'RECYCLE',
                        subtitle: 'Daur Ulang',
                        icon: Icons.eco,
                        color: const Color(0xFF10B981),
                        progress: organicPct,
                        value: '${organic.toStringAsFixed(1)} kg',
                        desc: 'Jadi kompos',
                      ),
                    ),
                  ],
                );
              }

              if (screenWidth < 360) {
                return Row(
                  children: [
                    Expanded(child: _R3CardCompact(
                      title: 'REDUCE',
                      subtitle: 'Kurangi',
                      icon: Icons.remove_circle_outline,
                      color: const Color(0xFFEF4444),
                      progress: inorganicPct,
                      value: '${inorganic.toStringAsFixed(1)} kg',
                      desc: 'Dikurangi',
                    )),
                    const SizedBox(width: 8),
                    Expanded(child: _R3CardCompact(
                      title: 'REUSE',
                      subtitle: 'Gunakan',
                      icon: Icons.refresh,
                      color: const Color(0xFFF59E0B),
                      progress: recyclePct,
                      value: '${recycle.toStringAsFixed(1)} kg',
                      desc: 'Dipakai ulang',
                    )),
                    const SizedBox(width: 8),
                    Expanded(child: _R3CardCompact(
                      title: 'RECYCLE',
                      subtitle: 'Daur Ulang',
                      icon: Icons.eco,
                      color: const Color(0xFF10B981),
                      progress: organicPct,
                      value: '${organic.toStringAsFixed(1)} kg',
                      desc: 'Jadi kompos',
                    )),
                  ],
                );
              }

              return Row(
                children: [
                  Expanded(child: _R3Card(
                    title: 'REDUCE',
                    subtitle: 'Kurangi',
                    icon: Icons.remove_circle_outline,
                    color: const Color(0xFFEF4444),
                    progress: inorganicPct,
                    value: '${inorganic.toStringAsFixed(1)} kg',
                    desc: 'Sampah dikurangi',
                  )),
                  const SizedBox(width: 12),
                  Expanded(child: _R3Card(
                    title: 'REUSE',
                    subtitle: 'Gunakan Kembali',
                    icon: Icons.refresh,
                    color: const Color(0xFFF59E0B),
                    progress: recyclePct,
                    value: '${recycle.toStringAsFixed(1)} kg',
                    desc: 'Sampah dipakai ulang',
                  )),
                  const SizedBox(width: 12),
                  Expanded(child: _R3Card(
                    title: 'RECYCLE',
                    subtitle: 'Daur Ulang',
                    icon: Icons.eco,
                    color: const Color(0xFF10B981),
                    progress: organicPct,
                    value: '${organic.toStringAsFixed(1)} kg',
                    desc: 'Jadi kompos',
                  )),
                ],
              );
            },
          ),
        ],
      ),
    );
  }

  // ============================================
  // QUICK ACTIONS
  // ============================================

  Widget _buildQuickActions(BuildContext context, bool isSmallScreen) {
    final actions = [
      {
        'title': 'Kelola Member',
        'subtitle': '${_members.length} anggota tim',
        'icon': Icons.people_alt,
        'color': const Color(0xFF10B981),
        'bgColor': const Color(0xFFECFDF5),
      },
      {
        'title': 'Input Sampah',
        'subtitle': 'Catat sampah masuk',
        'icon': Icons.add_circle,
        'color': const Color(0xFF3B82F6),
        'bgColor': const Color(0xFFE0F2FE),
      },
      {
        'title': 'Profil TPS',
        'subtitle': 'Info TPS 3R',
        'icon': Icons.info_outline,
        'color': const Color(0xFFF59E0B),
        'bgColor': const Color(0xFFFEF3C7),
      },
      {
        'title': 'Lihat Statistik',
        'subtitle': 'Grafik & Analisis',
        'icon': Icons.bar_chart,
        'color': const Color(0xFF8B5CF6),
        'bgColor': const Color(0xFFF3E8FF),
      },
    ];

    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const Padding(
          padding: EdgeInsets.only(left: 4),
          child: Text(
            'Aksi Cepat',
            style: TextStyle(
              fontSize: 16,
              fontWeight: FontWeight.w700,
              color: Color(0xFF111827),
            ),
          ),
        ),
        const SizedBox(height: 12),
        LayoutBuilder(
          builder: (context, constraints) {
            final crossAxisCount = constraints.maxWidth < 400 ? 2 : 2;
            final aspectRatio = constraints.maxWidth < 360 ? 0.95 : 1.05;

            return GridView.builder(
              shrinkWrap: true,
              physics: const NeverScrollableScrollPhysics(),
              gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
                crossAxisCount: crossAxisCount,
                mainAxisSpacing: 12,
                crossAxisSpacing: 12,
                childAspectRatio: aspectRatio,
              ),
              itemCount: actions.length,
              itemBuilder: (context, index) {
                final action = actions[index];
                return _ActionCard(
                  title: action['title'] as String,
                  subtitle: action['subtitle'] as String,
                  icon: action['icon'] as IconData,
                  color: action['color'] as Color,
                  bgColor: action['bgColor'] as Color,
                  isSmallScreen: isSmallScreen,
                  onTap: () {
                    if (action['title'] == 'Input Sampah') {
                      Navigator.push(
                        context,
                        MaterialPageRoute(builder: (context) => const WasteReportPage()),
                      );
                    }
                  },
                );
              },
            );
          },
        ),
      ],
    );
  }

  // ============================================
  // RECENT WASTE
  // ============================================

  Widget _buildRecentWaste(bool isSmallScreen) {
    // Ambil 4 item terbaru
    final recentItems = _wasteItems.take(4).toList();

    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [
          BoxShadow(
            color: const Color(0xFF10B981).withValues(alpha: 0.06),
            blurRadius: 16,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Column(
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Row(
                children: [
                  Container(
                    padding: const EdgeInsets.all(10),
                    decoration: BoxDecoration(
                      color: const Color(0xFFECFDF5),
                      borderRadius: BorderRadius.circular(12),
                    ),
                    child: const Icon(Icons.history, color: Color(0xFF059669), size: 18),
                  ),
                  const SizedBox(width: 12),
                  const Text(
                    'Input Terbaru',
                    style: TextStyle(
                      fontSize: 16,
                      fontWeight: FontWeight.w700,
                      color: Color(0xFF111827),
                    ),
                  ),
                ],
              ),
              Container(
                padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                decoration: BoxDecoration(
                  color: const Color(0xFFECFDF5),
                  borderRadius: BorderRadius.circular(20),
                ),
                child: const Row(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    Icon(Icons.filter_list, size: 14, color: Color(0xFF059669)),
                    SizedBox(width: 4),
                    Text(
                      'Terbaru',
                      style: TextStyle(
                        color: Color(0xFF059669),
                        fontSize: 12,
                        fontWeight: FontWeight.w600,
                      ),
                    ),
                  ],
                ),
              ),
            ],
          ),
          const SizedBox(height: 16),
          if (recentItems.isEmpty)
            const Padding(
              padding: EdgeInsets.symmetric(vertical: 24),
              child: Center(
                child: Column(
                  children: [
                    Icon(Icons.inbox, size: 40, color: Color(0xFFE5E7EB)),
                    SizedBox(height: 12),
                    Text(
                      'Belum ada data sampah',
                      style: TextStyle(
                        color: Color(0xFF9CA3AF),
                        fontSize: 14,
                      ),
                    ),
                  ],
                ),
              ),
            )
          else
            ...List.generate(recentItems.length, (index) {
              final item = recentItems[index];
              final isLast = index == recentItems.length - 1;
              final category = (item['category'] ?? 'recycle').toString().toLowerCase();
              final status = (item['status'] ?? 'pending').toString().toLowerCase();
              final dateStr = item['date'] ?? item['created_at'];
              final date = dateStr != null ? DateTime.tryParse(dateStr.toString()) : null;

              return Column(
                children: [
                  _WasteItem(
                    icon: _getCategoryIcon(category),
                    title: item['type'] ?? 'Sampah',
                    subtitle: '${(item['weight'] ?? 0).toStringAsFixed(1)} kg • ${_formatDate(date)}',
                    status: _getStatusLabel(status),
                    color: _getCategoryColor(category),
                    categoryColor: _getCategoryBgColor(category),
                    isSmallScreen: isSmallScreen,
                  ),
                  if (!isLast) ...[
                    const SizedBox(height: 12),
                    Divider(color: Colors.grey.shade100, height: 1),
                    const SizedBox(height: 12),
                  ],
                ],
              );
            }),
        ],
      ),
    );
  }

  // ============================================
  // TEAM STATUS
  // ============================================

  Widget _buildTeamStatus(bool isSmallScreen) {
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [
          BoxShadow(
            color: const Color(0xFF10B981).withValues(alpha: 0.06),
            blurRadius: 16,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Column(
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Row(
                children: [
                  Container(
                    padding: const EdgeInsets.all(10),
                    decoration: BoxDecoration(
                      color: const Color(0xFFECFDF5),
                      borderRadius: BorderRadius.circular(12),
                    ),
                    child: const Icon(Icons.groups, color: Color(0xFF059669), size: 18),
                  ),
                  const SizedBox(width: 12),
                  const Text(
                    'Status Tim',
                    style: TextStyle(
                      fontSize: 16,
                      fontWeight: FontWeight.w700,
                      color: Color(0xFF111827),
                    ),
                  ),
                ],
              ),
              Container(
                padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                decoration: BoxDecoration(
                  color: const Color(0xFF10B981).withValues(alpha: 0.1),
                  borderRadius: BorderRadius.circular(20),
                ),
                child: Text(
                  '${_activeMembers.length}/${_members.length} Aktif',
                  style: const TextStyle(
                    color: Color(0xFF059669),
                    fontSize: 12,
                    fontWeight: FontWeight.w600,
                  ),
                ),
              ),
            ],
          ),
          const SizedBox(height: 16),
          if (_members.isEmpty)
            const Padding(
              padding: EdgeInsets.symmetric(vertical: 24),
              child: Center(
                child: Column(
                  children: [
                    Icon(Icons.people_outline, size: 40, color: Color(0xFFE5E7EB)),
                    SizedBox(height: 12),
                    Text(
                      'Belum ada data member',
                      style: TextStyle(
                        color: Color(0xFF9CA3AF),
                        fontSize: 14,
                      ),
                    ),
                  ],
                ),
              ),
            )
          else
            GridView.builder(
              shrinkWrap: true,
              physics: const NeverScrollableScrollPhysics(),
              gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
                crossAxisCount: 2,
                crossAxisSpacing: 14,
                mainAxisSpacing: 14,
                childAspectRatio: 0.78,
              ),
              itemCount: _members.length > 6 ? 6 : _members.length,
              itemBuilder: (context, index) {
                final member = _members[index];
                final name = member['name'] ?? 'Member';
                final role = member['role'] ?? 'Tim';
                final isActive = member['active'] == true || member['active'] == 1;
                final avatarInitial = name.isNotEmpty ? name[0].toUpperCase() : '?';

                return _TeamMemberCard(
                  name: name,
                  role: role,
                  avatarInitial: avatarInitial,
                  isActive: isActive,
                );
              },
            ),
        ],
      ),
    );
  }

  // ============================================
  // ENVIRONMENTAL TIPS
  // ============================================

  Widget _buildEnvironmentalTips(bool isSmallScreen) {
    final tips = [
      {
        'icon': Icons.lightbulb_outline,
        'title': 'Pilah dari Sumber',
        'desc': 'Pisahkan sampah organik & anorganik',
      },
      {
        'icon': Icons.shopping_bag_outlined,
        'title': 'Bawa Tas Sendiri',
        'desc': 'Kurangi plastik sekali pakai',
      },
      {
        'icon': Icons.compost,
        'title': 'Buat Kompos',
        'desc': 'Sisa sayur jadi pupuk',
      },
    ];

    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        gradient: const LinearGradient(
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
          colors: [Color(0xFF059669), Color(0xFF10B981)],
        ),
        borderRadius: BorderRadius.circular(20),
        boxShadow: [
          BoxShadow(
            color: const Color(0xFF10B981).withValues(alpha: 0.25),
            blurRadius: 16,
            offset: const Offset(0, 6),
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            children: [
              Container(
                padding: const EdgeInsets.all(10),
                decoration: BoxDecoration(
                  color: Colors.white.withValues(alpha: 0.2),
                  borderRadius: BorderRadius.circular(12),
                ),
                child: const Icon(Icons.tips_and_updates, color: Colors.white, size: 20),
              ),
              const SizedBox(width: 12),
              const Text(
                'Tips Lingkungan',
                style: TextStyle(
                  fontSize: 16,
                  fontWeight: FontWeight.w700,
                  color: Colors.white,
                ),
              ),
            ],
          ),
          const SizedBox(height: 16),
          ...tips.map((tip) {
            return Padding(
              padding: const EdgeInsets.only(bottom: 12),
              child: Row(
                children: [
                  Container(
                    padding: const EdgeInsets.all(8),
                    decoration: BoxDecoration(
                      color: Colors.white.withValues(alpha: 0.2),
                      borderRadius: BorderRadius.circular(10),
                    ),
                    child: Icon(
                      tip['icon'] as IconData,
                      color: Colors.white,
                      size: 16,
                    ),
                  ),
                  const SizedBox(width: 12),
                  Expanded(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          tip['title'] as String,
                          style: const TextStyle(
                            color: Colors.white,
                            fontSize: 13,
                            fontWeight: FontWeight.w700,
                          ),
                        ),
                        const SizedBox(height: 2),
                        Text(
                          tip['desc'] as String,
                          style: TextStyle(
                            color: Colors.white.withValues(alpha: 0.8),
                            fontSize: 11,
                          ),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
            );
          }),
          const SizedBox(height: 4),
          Container(
            width: double.infinity,
            padding: const EdgeInsets.symmetric(vertical: 12, horizontal: 16),
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(12),
            ),
            child: const Row(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                Icon(Icons.eco, size: 16, color: Color(0xFF059669)),
                SizedBox(width: 8),
                Text(
                  'Kurangi • Gunakan Kembali • Daur Ulang',
                  style: TextStyle(
                    color: Color(0xFF059669),
                    fontSize: 12,
                    fontWeight: FontWeight.w700,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  // ============================================
  // HELPER FUNCTIONS
  // ============================================

  String _getGreeting() {
    final hour = DateTime.now().hour;
    if (hour < 12) return 'Selamat Pagi';
    if (hour < 15) return 'Selamat Siang';
    if (hour < 18) return 'Selamat Sore';
    return 'Selamat Malam';
  }

  String _formatDate(DateTime? date) {
    if (date == null) return 'Tanggal tidak valid';
    final months = [
      'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
      'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
    ];
    return '${date.day} ${months[date.month - 1]}';
  }

  IconData _getCategoryIcon(String category) {
    switch (category) {
      case 'organic':
        return Icons.grass;
      case 'inorganic':
        return Icons.flash_on;
      case 'recycle':
      default:
        return Icons.recycling;
    }
  }

  Color _getCategoryColor(String category) {
    switch (category) {
      case 'organic':
        return const Color(0xFF10B981);
      case 'inorganic':
        return const Color(0xFF3B82F6);
      case 'recycle':
      default:
        return const Color(0xFFF59E0B);
    }
  }

  Color _getCategoryBgColor(String category) {
    switch (category) {
      case 'organic':
        return const Color(0xFFECFDF5);
      case 'inorganic':
        return const Color(0xFFE0F2FE);
      case 'recycle':
      default:
        return const Color(0xFFFEF3C7);
    }
  }

  String _getStatusLabel(String status) {
    switch (status) {
      case 'processing':
        return 'Diproses';
      case 'recycled':
      case 'completed':
      case 'selesai':
        return 'Selesai';
      case 'pending':
      default:
        return 'Pending';
    }
  }
}

// ============================================
// REUSABLE WIDGETS
// ============================================

class _SummaryCard extends StatelessWidget {
  final IconData icon;
  final String value;
  final String label;
  final Color color;
  final bool isSmallScreen;

  const _SummaryCard({
    required this.icon,
    required this.value,
    required this.label,
    required this.color,
    required this.isSmallScreen,
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(12),
      decoration: BoxDecoration(
        color: color.withValues(alpha: 0.08),
        borderRadius: BorderRadius.circular(14),
      ),
      child: Column(
        children: [
          Icon(icon, color: color, size: isSmallScreen ? 18 : 20),
          const SizedBox(height: 8),
          Text(
            value,
            style: TextStyle(
              fontSize: isSmallScreen ? 14 : 16,
              fontWeight: FontWeight.w800,
              color: color,
            ),
          ),
          const SizedBox(height: 4),
          Text(
            label,
            style: TextStyle(
              fontSize: isSmallScreen ? 9 : 10,
              color: const Color(0xFF6B7280),
              fontWeight: FontWeight.w500,
            ),
            textAlign: TextAlign.center,
          ),
        ],
      ),
    );
  }
}

class _StatCard extends StatelessWidget {
  final IconData icon;
  final String value;
  final String label;
  final Color color;
  final Color bgColor;
  final String trend;
  final bool isSmallScreen;

  const _StatCard({
    required this.icon,
    required this.value,
    required this.label,
    required this.color,
    required this.bgColor,
    required this.trend,
    required this.isSmallScreen,
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(12),
      decoration: BoxDecoration(
        color: bgColor,
        borderRadius: BorderRadius.circular(16),
        border: Border.all(
          color: color.withValues(alpha: 0.15),
        ),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Container(
            padding: const EdgeInsets.all(8),
            decoration: BoxDecoration(
              color: color.withValues(alpha: 0.15),
              borderRadius: BorderRadius.circular(10),
            ),
            child: Icon(icon, color: color, size: isSmallScreen ? 14 : 16),
          ),
          const SizedBox(height: 10),
          Text(
            value,
            style: TextStyle(
              fontSize: isSmallScreen ? 18 : 20,
              fontWeight: FontWeight.w800,
              color: color,
            ),
          ),
          const SizedBox(height: 4),
          Text(
            label,
            style: TextStyle(
              fontSize: isSmallScreen ? 9 : 10,
              color: const Color(0xFF6B7280),
              fontWeight: FontWeight.w600,
            ),
          ),
          const SizedBox(height: 8),
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
            decoration: BoxDecoration(
              color: color.withValues(alpha: 0.1),
              borderRadius: BorderRadius.circular(8),
            ),
            child: Text(
              trend,
              style: TextStyle(
                fontSize: isSmallScreen ? 8 : 9,
                fontWeight: FontWeight.w700,
                color: color,
              ),
            ),
          ),
        ],
      ),
    );
  }
}

class _R3Card extends StatelessWidget {
  final String title;
  final String subtitle;
  final IconData icon;
  final Color color;
  final double progress;
  final String value;
  final String desc;

  const _R3Card({
    required this.title,
    required this.subtitle,
    required this.icon,
    required this.color,
    required this.progress,
    required this.value,
    required this.desc,
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(12),
      decoration: BoxDecoration(
        color: color.withValues(alpha: 0.08),
        borderRadius: BorderRadius.circular(16),
        border: Border.all(
          color: color.withValues(alpha: 0.15),
        ),
        boxShadow: [
          BoxShadow(
            color: color.withValues(alpha: 0.05),
            blurRadius: 8,
            offset: const Offset(0, 2),
          ),
        ],
      ),
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        crossAxisAlignment: CrossAxisAlignment.center,
        mainAxisSize: MainAxisSize.min,
        children: [
          Container(
            width: 40,
            height: 40,
            decoration: BoxDecoration(
              color: color.withValues(alpha: 0.15),
              borderRadius: BorderRadius.circular(12),
            ),
            child: Icon(icon, color: color, size: 22),
          ),
          const SizedBox(height: 8),
          Flexible(
            child: Text(
              title,
              style: TextStyle(
                fontSize: 10,
                fontWeight: FontWeight.w800,
                color: color,
                letterSpacing: 0.5,
              ),
              textAlign: TextAlign.center,
              overflow: TextOverflow.ellipsis,
            ),
          ),
          const SizedBox(height: 2),
          Flexible(
            child: Text(
              subtitle,
              style: TextStyle(
                fontSize: 9,
                color: color.withValues(alpha: 0.8),
              ),
              textAlign: TextAlign.center,
              overflow: TextOverflow.ellipsis,
            ),
          ),
          const SizedBox(height: 8),
          ClipRRect(
            borderRadius: BorderRadius.circular(4),
            child: LinearProgressIndicator(
              value: progress / 100,
              backgroundColor: color.withValues(alpha: 0.15),
              valueColor: AlwaysStoppedAnimation(color),
              minHeight: 5,
            ),
          ),
          const SizedBox(height: 8),
          Flexible(
            child: Text(
              value,
              style: TextStyle(
                fontSize: 14,
                fontWeight: FontWeight.w800,
                color: color,
              ),
              textAlign: TextAlign.center,
              overflow: TextOverflow.ellipsis,
            ),
          ),
          const SizedBox(height: 2),
          Flexible(
            child: Text(
              desc,
              style: TextStyle(
                fontSize: 8,
                color: color.withValues(alpha: 0.7),
              ),
              textAlign: TextAlign.center,
              overflow: TextOverflow.ellipsis,
              maxLines: 1,
            ),
          ),
        ],
      ),
    );
  }
}

class _R3CardCompact extends StatelessWidget {
  final String title;
  final String subtitle;
  final IconData icon;
  final Color color;
  final double progress;
  final String value;
  final String desc;

  const _R3CardCompact({
    required this.title,
    required this.subtitle,
    required this.icon,
    required this.color,
    required this.progress,
    required this.value,
    required this.desc,
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(8),
      decoration: BoxDecoration(
        color: color.withValues(alpha: 0.08),
        borderRadius: BorderRadius.circular(12),
        border: Border.all(
          color: color.withValues(alpha: 0.12),
        ),
      ),
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        crossAxisAlignment: CrossAxisAlignment.center,
        mainAxisSize: MainAxisSize.min,
        children: [
          Container(
            width: 32,
            height: 32,
            decoration: BoxDecoration(
              color: color.withValues(alpha: 0.15),
              borderRadius: BorderRadius.circular(8),
            ),
            child: Icon(icon, color: color, size: 18),
          ),
          const SizedBox(height: 6),
          Flexible(
            child: Text(
              title,
              style: TextStyle(
                fontSize: 9,
                fontWeight: FontWeight.w800,
                color: color,
                letterSpacing: 0.3,
              ),
              textAlign: TextAlign.center,
              overflow: TextOverflow.ellipsis,
            ),
          ),
          const SizedBox(height: 1),
          Flexible(
            child: Text(
              subtitle,
              style: TextStyle(
                fontSize: 8,
                color: color.withValues(alpha: 0.8),
              ),
              textAlign: TextAlign.center,
              overflow: TextOverflow.ellipsis,
            ),
          ),
          const SizedBox(height: 6),
          ClipRRect(
            borderRadius: BorderRadius.circular(3),
            child: LinearProgressIndicator(
              value: progress / 100,
              backgroundColor: color.withValues(alpha: 0.15),
              valueColor: AlwaysStoppedAnimation(color),
              minHeight: 4,
            ),
          ),
          const SizedBox(height: 6),
          Flexible(
            child: Text(
              value,
              style: TextStyle(
                fontSize: 12,
                fontWeight: FontWeight.w800,
                color: color,
              ),
              textAlign: TextAlign.center,
              overflow: TextOverflow.ellipsis,
            ),
          ),
          const SizedBox(height: 1),
          Flexible(
            child: Text(
              desc,
              style: TextStyle(
                fontSize: 7,
                color: color.withValues(alpha: 0.7),
              ),
              textAlign: TextAlign.center,
              overflow: TextOverflow.ellipsis,
              maxLines: 1,
            ),
          ),
        ],
      ),
    );
  }
}

class _ActionCard extends StatelessWidget {
  final String title;
  final String subtitle;
  final IconData icon;
  final Color color;
  final Color bgColor;
  final bool isSmallScreen;
  final VoidCallback? onTap;

  const _ActionCard({
    required this.title,
    required this.subtitle,
    required this.icon,
    required this.color,
    required this.bgColor,
    required this.isSmallScreen,
    this.onTap,
  });

  @override
  Widget build(BuildContext context) {
    return Material(
      color: Colors.transparent,
      child: InkWell(
        onTap: onTap,
        borderRadius: BorderRadius.circular(18),
        child: Container(
          padding: const EdgeInsets.all(16),
          decoration: BoxDecoration(
            color: Colors.white,
            borderRadius: BorderRadius.circular(18),
            boxShadow: [
              BoxShadow(
                color: Colors.black.withValues(alpha: 0.04),
                blurRadius: 12,
                offset: const Offset(0, 4),
              ),
            ],
          ),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Container(
                padding: const EdgeInsets.all(10),
                decoration: BoxDecoration(
                  color: bgColor,
                  borderRadius: BorderRadius.circular(12),
                ),
                child: Icon(icon, color: color, size: isSmallScreen ? 18 : 20),
              ),
              const Spacer(),
              Text(
                title,
                style: TextStyle(
                  fontSize: isSmallScreen ? 12 : 14,
                  fontWeight: FontWeight.w700,
                  color: const Color(0xFF111827),
                ),
                maxLines: 1,
                overflow: TextOverflow.ellipsis,
              ),
              const SizedBox(height: 4),
              Text(
                subtitle,
                style: TextStyle(
                  fontSize: isSmallScreen ? 10 : 11,
                  color: const Color(0xFF6B7280),
                ),
                maxLines: 1,
                overflow: TextOverflow.ellipsis,
              ),
              const Spacer(),
              Row(
                children: [
                  Text(
                    'Akses',
                    style: TextStyle(
                      fontSize: isSmallScreen ? 9 : 10,
                      color: const Color(0xFF10B981),
                      fontWeight: FontWeight.w600,
                    ),
                  ),
                  const SizedBox(width: 4),
                  Icon(Icons.arrow_forward, color: color, size: isSmallScreen ? 10 : 12),
                ],
              ),
            ],
          ),
        ),
      ),
    );
  }
}

class _WasteItem extends StatelessWidget {
  final IconData icon;
  final String title;
  final String subtitle;
  final String status;
  final Color color;
  final Color categoryColor;
  final bool isSmallScreen;

  const _WasteItem({
    required this.icon,
    required this.title,
    required this.subtitle,
    required this.status,
    required this.color,
    required this.categoryColor,
    required this.isSmallScreen,
  });

  @override
  Widget build(BuildContext context) {
    return Row(
      children: [
        Container(
          padding: const EdgeInsets.all(10),
          decoration: BoxDecoration(
            color: categoryColor,
            borderRadius: BorderRadius.circular(12),
          ),
          child: Icon(icon, color: color, size: isSmallScreen ? 16 : 18),
        ),
        const SizedBox(width: 12),
        Expanded(
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                title,
                style: TextStyle(
                  fontSize: isSmallScreen ? 12 : 13,
                  fontWeight: FontWeight.w600,
                  color: const Color(0xFF111827),
                ),
                maxLines: 1,
                overflow: TextOverflow.ellipsis,
              ),
              const SizedBox(height: 2),
              Text(
                subtitle,
                style: TextStyle(
                  fontSize: isSmallScreen ? 10 : 11,
                  color: const Color(0xFF6B7280),
                ),
                maxLines: 1,
                overflow: TextOverflow.ellipsis,
              ),
            ],
          ),
        ),
        const SizedBox(width: 8),
        Container(
          padding: EdgeInsets.symmetric(
            horizontal: isSmallScreen ? 8 : 10,
            vertical: isSmallScreen ? 4 : 6,
          ),
          decoration: BoxDecoration(
            color: categoryColor,
            borderRadius: BorderRadius.circular(10),
          ),
          child: Text(
            status,
            style: TextStyle(
              fontSize: isSmallScreen ? 9 : 10,
              fontWeight: FontWeight.w600,
              color: color,
            ),
          ),
        ),
      ],
    );
  }
}

class _TeamMemberCard extends StatelessWidget {
  final String name;
  final String role;
  final String avatarInitial;
  final bool isActive;

  const _TeamMemberCard({
    required this.name,
    required this.role,
    required this.avatarInitial,
    required this.isActive,
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: isActive ? const Color(0xFFECFDF5) : const Color(0xFFFFFBEB),
        borderRadius: BorderRadius.circular(16),
        border: Border.all(
          color: isActive
              ? const Color(0xFF10B981).withValues(alpha: 0.2)
              : const Color(0xFFF59E0B).withValues(alpha: 0.2),
        ),
        boxShadow: [
          BoxShadow(
            color: (isActive ? const Color(0xFF10B981) : const Color(0xFFF59E0B))
                .withValues(alpha: 0.08),
            blurRadius: 8,
            offset: const Offset(0, 2),
          ),
        ],
      ),
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        crossAxisAlignment: CrossAxisAlignment.center,
        mainAxisSize: MainAxisSize.min,
        children: [
          Container(
            width: 48,
            height: 48,
            decoration: BoxDecoration(
              gradient: LinearGradient(
                begin: Alignment.topLeft,
                end: Alignment.bottomRight,
                colors: isActive
                    ? [const Color(0xFF10B981), const Color(0xFF059669)]
                    : [const Color(0xFFF59E0B), const Color(0xFFD97706)],
              ),
              borderRadius: BorderRadius.circular(14),
              boxShadow: [
                BoxShadow(
                  color: (isActive ? const Color(0xFF10B981) : const Color(0xFFF59E0B))
                      .withValues(alpha: 0.3),
                  blurRadius: 6,
                  offset: const Offset(0, 2),
                ),
              ],
            ),
            child: Center(
              child: Text(
                avatarInitial,
                style: const TextStyle(
                  fontSize: 18,
                  fontWeight: FontWeight.bold,
                  color: Colors.white,
                ),
              ),
            ),
          ),
          const SizedBox(height: 12),
          Text(
            name,
            style: const TextStyle(
              fontSize: 13,
              fontWeight: FontWeight.w700,
              color: Color(0xFF111827),
            ),
            textAlign: TextAlign.center,
            maxLines: 1,
            overflow: TextOverflow.ellipsis,
          ),
          const SizedBox(height: 4),
          Text(
            role,
            style: TextStyle(
              fontSize: 11,
              color: const Color(0xFF6B7280).withValues(alpha: 0.9),
            ),
            textAlign: TextAlign.center,
            maxLines: 1,
            overflow: TextOverflow.ellipsis,
          ),
          const SizedBox(height: 10),
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 5),
            decoration: BoxDecoration(
              color: isActive
                  ? const Color(0xFF10B981).withValues(alpha: 0.15)
                  : const Color(0xFFF59E0B).withValues(alpha: 0.15),
              borderRadius: BorderRadius.circular(20),
            ),
            child: Row(
              mainAxisSize: MainAxisSize.min,
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                Container(
                  width: 7,
                  height: 7,
                  decoration: BoxDecoration(
                    color: isActive
                        ? const Color(0xFF10B981)
                        : const Color(0xFFF59E0B),
                    shape: BoxShape.circle,
                  ),
                ),
                const SizedBox(width: 5),
                Text(
                  isActive ? 'Aktif' : 'Offline',
                  style: TextStyle(
                    fontSize: 10,
                    fontWeight: FontWeight.w600,
                    color: isActive
                        ? const Color(0xFF059669)
                        : const Color(0xFFD97706),
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}
