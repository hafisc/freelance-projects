import 'package:flutter/material.dart';
import '../../../app/theme.dart';
import '../../../core/helpers/format_helper.dart';
import '../../../core/widgets/empty_state.dart';
import '../../../core/widgets/loading_view.dart';
import '../models/application_model.dart';
import '../services/application_service.dart';

class ApplicationHistoryScreen extends StatefulWidget {
  const ApplicationHistoryScreen({super.key});

  @override
  State<ApplicationHistoryScreen> createState() =>
      _ApplicationHistoryScreenState();
}

class _ApplicationHistoryScreenState extends State<ApplicationHistoryScreen>
    with SingleTickerProviderStateMixin {
  final ApplicationService _applicationService = ApplicationService();
  late Future<List<ApplicationModel>> _applicationsFuture;
  String _activeFilter = 'Semua';

  final List<String> _filters = [
    'Semua',
    'Menunggu',
    'Diproses',
    'Diterima',
    'Ditolak',
  ];

  @override
  void initState() {
    super.initState();
    _loadApplications();
  }

  void _loadApplications() {
    setState(() {
      _applicationsFuture = _applicationService.getMyApplications();
    });
  }

  // Mengambil konfigurasi warna dan ikon untuk setiap status lamaran
  _StatusConfig _getStatusConfig(String status) {
    switch (status) {
      case 'Diproses':
        return _StatusConfig(
          color: const Color(0xff0284c7),
          bgColor: const Color(0xffe0f2fe),
          icon: Icons.sync_rounded,
          label: 'Diproses',
        );
      case 'Diterima':
        return _StatusConfig(
          color: const Color(0xff15803d),
          bgColor: const Color(0xffdcfce7),
          icon: Icons.check_circle_rounded,
          label: 'Diterima',
        );
      case 'Ditolak':
        return _StatusConfig(
          color: const Color(0xffb91c1c),
          bgColor: const Color(0xfffee2e2),
          icon: Icons.cancel_rounded,
          label: 'Ditolak',
        );
      case 'Menunggu':
      default:
        return _StatusConfig(
          color: const Color(0xff475569),
          bgColor: const Color(0xfff1f5f9),
          icon: Icons.schedule_rounded,
          label: 'Menunggu',
        );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppTheme.background,
      body: FutureBuilder<List<ApplicationModel>>(
        future: _applicationsFuture,
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return const LoadingView(
              message: 'Mengambil riwayat lamaran Anda...',
            );
          } else if (snapshot.hasError) {
            return EmptyState(
              title: 'Gagal Memuat Data',
              description:
                  'Ada kendala saat mengambil data: ${snapshot.error}',
              icon: Icons.wifi_off_outlined,
              buttonText: 'Coba Lagi',
              onButtonPressed: _loadApplications,
            );
          } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
            return const EmptyState(
              title: 'Belum Ada Lamaran',
              description:
                  'Anda belum pernah melamar lowongan kerja apa pun. Silakan cari lowongan menarik di menu Beranda.',
              icon: Icons.assignment_outlined,
            );
          }

          final allApps = snapshot.data!;

          // Hitung statistik
          final totalCount = allApps.length;
          final waitingCount =
              allApps.where((a) => a.status == 'Menunggu').length;
          final processCount =
              allApps.where((a) => a.status == 'Diproses').length;
          final acceptedCount =
              allApps.where((a) => a.status == 'Diterima').length;
          final rejectedCount =
              allApps.where((a) => a.status == 'Ditolak').length;

          // Filter data berdasarkan tab aktif
          final filteredApps = _activeFilter == 'Semua'
              ? allApps
              : allApps.where((a) => a.status == _activeFilter).toList();

          return RefreshIndicator(
            onRefresh: () async => _loadApplications(),
            color: AppTheme.primaryBlue,
            child: CustomScrollView(
              physics: const AlwaysScrollableScrollPhysics(),
              slivers: [
                // Header SliverAppBar
                SliverAppBar(
                  expandedHeight: 140,
                  floating: false,
                  pinned: true,
                  automaticallyImplyLeading: false,
                  backgroundColor: AppTheme.primaryBlue,
                  flexibleSpace: FlexibleSpaceBar(
                    background: Container(
                      decoration: const BoxDecoration(
                        gradient: LinearGradient(
                          begin: Alignment.topLeft,
                          end: Alignment.bottomRight,
                          colors: [
                            Color(0xff1d4ed8),
                            Color(0xff2563eb),
                            Color(0xff3b82f6),
                          ],
                        ),
                      ),
                      child: SafeArea(
                        bottom: false,
                        child: Padding(
                          padding: const EdgeInsets.fromLTRB(24, 16, 24, 24),
                          child: Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              Row(
                                children: [
                                  Container(
                                    padding: const EdgeInsets.all(8),
                                    decoration: BoxDecoration(
                                      color: Colors.white.withValues(alpha: 0.15),
                                      borderRadius: BorderRadius.circular(12),
                                    ),
                                    child: const Icon(
                                      Icons.assignment_rounded,
                                      color: Colors.white,
                                      size: 22,
                                    ),
                                  ),
                                  const SizedBox(width: 12),
                                  const Expanded(
                                    child: Column(
                                      crossAxisAlignment:
                                          CrossAxisAlignment.start,
                                      children: [
                                        Text(
                                          'Riwayat Lamaran',
                                          style: TextStyle(
                                            fontSize: 20,
                                            fontWeight: FontWeight.bold,
                                            color: Colors.white,
                                            letterSpacing: -0.3,
                                          ),
                                        ),
                                        SizedBox(height: 2),
                                        Text(
                                          'Pantau status lamaran kerja Anda',
                                          style: TextStyle(
                                            fontSize: 13,
                                            color: Colors.white70,
                                          ),
                                        ),
                                      ],
                                    ),
                                  ),
                                ],
                              ),
                            ],
                          ),
                        ),
                      ),
                    ),
                  ),
                ),

                // Statistik Ringkasan
                SliverToBoxAdapter(
                  child: Transform.translate(
                    offset: const Offset(0, -16),
                    child: Padding(
                      padding: const EdgeInsets.symmetric(horizontal: 24),
                      child: Container(
                        padding: const EdgeInsets.symmetric(
                          vertical: 16,
                          horizontal: 8,
                        ),
                        decoration: BoxDecoration(
                          color: Colors.white,
                          borderRadius: BorderRadius.circular(20),
                          boxShadow: [
                            BoxShadow(
                              color: const Color(0xff0f172a).withValues(alpha: 0.06),
                              blurRadius: 24,
                              offset: const Offset(0, 8),
                            ),
                          ],
                        ),
                        child: Row(
                          children: [
                            _buildStatItem(
                              'Total',
                              totalCount,
                              AppTheme.primaryBlue,
                            ),
                            _buildStatDivider(),
                            _buildStatItem(
                              'Menunggu',
                              waitingCount,
                              const Color(0xff475569),
                            ),
                            _buildStatDivider(),
                            _buildStatItem(
                              'Diproses',
                              processCount,
                              const Color(0xff0284c7),
                            ),
                            _buildStatDivider(),
                            _buildStatItem(
                              'Diterima',
                              acceptedCount,
                              const Color(0xff15803d),
                            ),
                            _buildStatDivider(),
                            _buildStatItem(
                              'Ditolak',
                              rejectedCount,
                              const Color(0xffb91c1c),
                            ),
                          ],
                        ),
                      ),
                    ),
                  ),
                ),

                // Filter Tabs
                SliverToBoxAdapter(
                  child: Padding(
                    padding: const EdgeInsets.fromLTRB(24, 0, 24, 16),
                    child: SizedBox(
                      height: 38,
                      child: ListView.separated(
                        scrollDirection: Axis.horizontal,
                        itemCount: _filters.length,
                        separatorBuilder: (_, __) => const SizedBox(width: 8),
                        itemBuilder: (context, index) {
                          final filter = _filters[index];
                          final isActive = filter == _activeFilter;

                          // Hitung jumlah per filter
                          int count;
                          if (filter == 'Semua') {
                            count = totalCount;
                          } else {
                            count = allApps
                                .where((a) => a.status == filter)
                                .length;
                          }

                          return GestureDetector(
                            onTap: () {
                              setState(() {
                                _activeFilter = filter;
                              });
                            },
                            child: AnimatedContainer(
                              duration: const Duration(milliseconds: 250),
                              curve: Curves.easeOut,
                              padding: const EdgeInsets.symmetric(
                                horizontal: 16,
                                vertical: 8,
                              ),
                              decoration: BoxDecoration(
                                color: isActive
                                    ? AppTheme.primaryBlue
                                    : Colors.white,
                                borderRadius: BorderRadius.circular(12),
                                border: Border.all(
                                  color: isActive
                                      ? AppTheme.primaryBlue
                                      : const Color(0xffe2e8f0),
                                  width: 1.2,
                                ),
                                boxShadow: isActive
                                    ? [
                                        BoxShadow(
                                          color: AppTheme.primaryBlue
                                              .withValues(alpha: 0.25),
                                          blurRadius: 8,
                                          offset: const Offset(0, 3),
                                        ),
                                      ]
                                    : [],
                              ),
                              child: Row(
                                children: [
                                  Text(
                                    filter,
                                    style: TextStyle(
                                      fontSize: 12,
                                      fontWeight: FontWeight.bold,
                                      color: isActive
                                          ? Colors.white
                                          : AppTheme.textSecondary,
                                    ),
                                  ),
                                  const SizedBox(width: 6),
                                  Container(
                                    padding: const EdgeInsets.symmetric(
                                      horizontal: 6,
                                      vertical: 1,
                                    ),
                                    decoration: BoxDecoration(
                                      color: isActive
                                          ? Colors.white.withValues(alpha: 0.25)
                                          : const Color(0xfff1f5f9),
                                      borderRadius: BorderRadius.circular(6),
                                    ),
                                    child: Text(
                                      '$count',
                                      style: TextStyle(
                                        fontSize: 11,
                                        fontWeight: FontWeight.bold,
                                        color: isActive
                                            ? Colors.white
                                            : AppTheme.textSecondary,
                                      ),
                                    ),
                                  ),
                                ],
                              ),
                            ),
                          );
                        },
                      ),
                    ),
                  ),
                ),

                // Daftar Lamaran atau Empty Filtered State
                if (filteredApps.isEmpty)
                  SliverFillRemaining(
                    hasScrollBody: false,
                    child: Center(
                      child: Padding(
                        padding: const EdgeInsets.all(40),
                        child: Column(
                          mainAxisSize: MainAxisSize.min,
                          children: [
                            Container(
                              padding: const EdgeInsets.all(16),
                              decoration: BoxDecoration(
                                color: const Color(0xfff1f5f9),
                                shape: BoxShape.circle,
                              ),
                              child: Icon(
                                Icons.filter_list_off_rounded,
                                color: AppTheme.textSecondary,
                                size: 40,
                              ),
                            ),
                            const SizedBox(height: 16),
                            Text(
                              'Tidak ada lamaran "$_activeFilter"',
                              style: const TextStyle(
                                fontSize: 15,
                                fontWeight: FontWeight.bold,
                                color: AppTheme.textPrimary,
                              ),
                            ),
                            const SizedBox(height: 6),
                            const Text(
                              'Coba pilih filter lain untuk melihat lamaran.',
                              textAlign: TextAlign.center,
                              style: TextStyle(
                                fontSize: 13,
                                color: AppTheme.textSecondary,
                              ),
                            ),
                          ],
                        ),
                      ),
                    ),
                  )
                else
                  SliverPadding(
                    padding: const EdgeInsets.fromLTRB(24, 0, 24, 110),
                    sliver: SliverList(
                      delegate: SliverChildBuilderDelegate(
                        (context, index) {
                          final app = filteredApps[index];
                          return _ApplicationCard(
                            application: app,
                            statusConfig: _getStatusConfig(app.status),
                            index: index,
                          );
                        },
                        childCount: filteredApps.length,
                      ),
                    ),
                  ),
              ],
            ),
          );
        },
      ),
    );
  }

  // Widget statistik ringkasan per item
  Widget _buildStatItem(String label, int count, Color color) {
    return Expanded(
      child: Column(
        children: [
          Text(
            '$count',
            style: TextStyle(
              fontSize: 18,
              fontWeight: FontWeight.bold,
              color: color,
            ),
          ),
          const SizedBox(height: 2),
          Text(
            label,
            style: const TextStyle(
              fontSize: 10,
              color: AppTheme.textSecondary,
              fontWeight: FontWeight.w600,
            ),
            overflow: TextOverflow.ellipsis,
          ),
        ],
      ),
    );
  }

  Widget _buildStatDivider() {
    return Container(
      width: 1,
      height: 28,
      color: const Color(0xffe2e8f0),
    );
  }
}

// Helper class untuk konfigurasi status
class _StatusConfig {
  final Color color;
  final Color bgColor;
  final IconData icon;
  final String label;

  _StatusConfig({
    required this.color,
    required this.bgColor,
    required this.icon,
    required this.label,
  });
}

// Widget Card terpisah untuk setiap lamaran pekerjaan
class _ApplicationCard extends StatefulWidget {
  final ApplicationModel application;
  final _StatusConfig statusConfig;
  final int index;

  const _ApplicationCard({
    required this.application,
    required this.statusConfig,
    required this.index,
  });

  @override
  State<_ApplicationCard> createState() => _ApplicationCardState();
}

class _ApplicationCardState extends State<_ApplicationCard>
    with SingleTickerProviderStateMixin {
  bool _isExpanded = false;
  late AnimationController _animController;
  late Animation<double> _fadeAnim;

  @override
  void initState() {
    super.initState();
    _animController = AnimationController(
      vsync: this,
      duration: const Duration(milliseconds: 500),
    );
    _fadeAnim = CurvedAnimation(
      parent: _animController,
      curve: Curves.easeOut,
    );

    // Staggered animation berdasarkan index
    Future.delayed(Duration(milliseconds: 80 * widget.index), () {
      if (mounted) _animController.forward();
    });
  }

  @override
  void dispose() {
    _animController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    final app = widget.application;
    final config = widget.statusConfig;

    return FadeTransition(
      opacity: _fadeAnim,
      child: SlideTransition(
        position: Tween<Offset>(
          begin: const Offset(0, 0.08),
          end: Offset.zero,
        ).animate(_fadeAnim),
        child: Container(
          margin: const EdgeInsets.only(bottom: 14),
          decoration: BoxDecoration(
            color: Colors.white,
            borderRadius: BorderRadius.circular(20),
            border: Border.all(
              color: _isExpanded
                  ? config.color.withValues(alpha: 0.2)
                  : const Color(0xfff1f5f9),
              width: 1.2,
            ),
            boxShadow: [
              BoxShadow(
                color: _isExpanded
                    ? config.color.withValues(alpha: 0.06)
                    : const Color(0xff0f172a).withValues(alpha: 0.03),
                blurRadius: _isExpanded ? 20 : 12,
                offset: const Offset(0, 6),
              ),
            ],
          ),
          child: Column(
            children: [
              // Header Card (Selalu tampil)
              InkWell(
                borderRadius: BorderRadius.circular(20),
                onTap: () {
                  setState(() {
                    _isExpanded = !_isExpanded;
                  });
                },
                child: Padding(
                  padding: const EdgeInsets.all(16),
                  child: Column(
                    children: [
                      Row(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          // Ikon status dengan lingkaran berwarna
                          Container(
                            padding: const EdgeInsets.all(10),
                            decoration: BoxDecoration(
                              color: config.bgColor,
                              borderRadius: BorderRadius.circular(14),
                            ),
                            child: Icon(
                              config.icon,
                              color: config.color,
                              size: 22,
                            ),
                          ),
                          const SizedBox(width: 12),

                          // Info utama posisi dan perusahaan
                          Expanded(
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                Text(
                                  app.job?.title ?? 'Posisi Terhapus',
                                  style: const TextStyle(
                                    fontSize: 15,
                                    fontWeight: FontWeight.bold,
                                    color: AppTheme.textPrimary,
                                    height: 1.2,
                                  ),
                                  maxLines: 2,
                                  overflow: TextOverflow.ellipsis,
                                ),
                                const SizedBox(height: 4),
                                Row(
                                  children: [
                                    const Icon(
                                      Icons.business_rounded,
                                      size: 13,
                                      color: AppTheme.textSecondary,
                                    ),
                                    const SizedBox(width: 4),
                                    Expanded(
                                      child: Text(
                                        app.job?.companyName ??
                                            'PT. Gloria Jasa Mandiri',
                                        style: const TextStyle(
                                          fontSize: 12,
                                          color: AppTheme.textSecondary,
                                          fontWeight: FontWeight.w500,
                                        ),
                                        overflow: TextOverflow.ellipsis,
                                      ),
                                    ),
                                  ],
                                ),
                              ],
                            ),
                          ),

                          // Ikon expand/collapse
                          AnimatedRotation(
                            turns: _isExpanded ? 0.5 : 0,
                            duration: const Duration(milliseconds: 250),
                            child: Container(
                              padding: const EdgeInsets.all(4),
                              decoration: BoxDecoration(
                                color: const Color(0xfff1f5f9),
                                borderRadius: BorderRadius.circular(8),
                              ),
                              child: const Icon(
                                Icons.keyboard_arrow_down_rounded,
                                size: 18,
                                color: AppTheme.textSecondary,
                              ),
                            ),
                          ),
                        ],
                      ),
                      const SizedBox(height: 12),

                      // Baris info: status badge + lokasi + tanggal
                      Row(
                        children: [
                          // Status badge
                          Container(
                            padding: const EdgeInsets.symmetric(
                              horizontal: 10,
                              vertical: 5,
                            ),
                            decoration: BoxDecoration(
                              color: config.bgColor,
                              borderRadius: BorderRadius.circular(8),
                            ),
                            child: Row(
                              mainAxisSize: MainAxisSize.min,
                              children: [
                                Icon(
                                  config.icon,
                                  size: 12,
                                  color: config.color,
                                ),
                                const SizedBox(width: 4),
                                Text(
                                  config.label,
                                  style: TextStyle(
                                    fontSize: 11,
                                    fontWeight: FontWeight.bold,
                                    color: config.color,
                                  ),
                                ),
                              ],
                            ),
                          ),

                          // Lokasi jika ada
                          if (app.job?.location != null &&
                              app.job!.location.isNotEmpty) ...[
                            const SizedBox(width: 8),
                            Icon(
                              Icons.location_on_outlined,
                              size: 13,
                              color: AppTheme.textSecondary.withValues(alpha: 0.7),
                            ),
                            const SizedBox(width: 2),
                            Flexible(
                              child: Text(
                                app.job!.location,
                                style: TextStyle(
                                  fontSize: 11,
                                  color: AppTheme.textSecondary.withValues(alpha: 0.7),
                                  fontWeight: FontWeight.w500,
                                ),
                                overflow: TextOverflow.ellipsis,
                              ),
                            ),
                          ],

                          const Spacer(),

                          // Tanggal melamar
                          Row(
                            mainAxisSize: MainAxisSize.min,
                            children: [
                              Icon(
                                Icons.calendar_today_rounded,
                                size: 11,
                                color: AppTheme.textSecondary.withValues(alpha: 0.6),
                              ),
                              const SizedBox(width: 4),
                              Text(
                                FormatHelper.formatDateTime(app.createdAt),
                                style: TextStyle(
                                  fontSize: 10,
                                  color: AppTheme.textSecondary.withValues(alpha: 0.7),
                                  fontWeight: FontWeight.w500,
                                ),
                              ),
                            ],
                          ),
                        ],
                      ),
                    ],
                  ),
                ),
              ),

              // Detail Expanded Section
              AnimatedCrossFade(
                firstChild: const SizedBox.shrink(),
                secondChild: _buildExpandedDetail(app, config),
                crossFadeState: _isExpanded
                    ? CrossFadeState.showSecond
                    : CrossFadeState.showFirst,
                duration: const Duration(milliseconds: 300),
                sizeCurve: Curves.easeInOut,
              ),
            ],
          ),
        ),
      ),
    );
  }

  // Konten detail yang muncul saat card diklik (expanded)
  Widget _buildExpandedDetail(ApplicationModel app, _StatusConfig config) {
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.fromLTRB(16, 0, 16, 16),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // Garis pemisah
          Container(
            height: 1,
            color: const Color(0xfff1f5f9),
          ),
          const SizedBox(height: 16),

          // Informasi Pelamar
          const Text(
            'Data yang Dikirimkan',
            style: TextStyle(
              fontSize: 13,
              fontWeight: FontWeight.bold,
              color: AppTheme.textPrimary,
            ),
          ),
          const SizedBox(height: 12),

          // Detail rows
          _buildInfoRow(Icons.person_rounded, 'Nama', app.fullName),
          _buildInfoRow(Icons.email_rounded, 'Email', app.email),
          _buildInfoRow(Icons.phone_rounded, 'No. HP', app.phone),
          _buildInfoRow(
              Icons.location_on_rounded, 'Alamat', app.address),
          if (app.note != null && app.note!.isNotEmpty)
            _buildInfoRow(
                Icons.sticky_note_2_rounded, 'Catatan', app.note!),

          const SizedBox(height: 16),

          // Catatan Review Admin
          Container(
            width: double.infinity,
            padding: const EdgeInsets.all(14),
            decoration: BoxDecoration(
              color: config.bgColor,
              borderRadius: BorderRadius.circular(14),
              border: Border.all(
                color: config.color.withValues(alpha: 0.12),
                width: 1,
              ),
            ),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Row(
                  children: [
                    Icon(
                      Icons.admin_panel_settings_rounded,
                      size: 16,
                      color: config.color,
                    ),
                    const SizedBox(width: 6),
                    Text(
                      'Catatan dari Admin',
                      style: TextStyle(
                        fontSize: 12,
                        fontWeight: FontWeight.bold,
                        color: config.color,
                      ),
                    ),
                  ],
                ),
                const SizedBox(height: 8),
                Text(
                  app.adminNote ??
                      'Lamaran Anda sedang dalam tahap antrean review admin. Mohon cek status secara berkala.',
                  style: TextStyle(
                    fontSize: 13,
                    color: config.color.withValues(alpha: 0.85),
                    height: 1.5,
                  ),
                ),
              ],
            ),
          ),

          // Jenis pekerjaan dan kategori jika tersedia
          if (app.job != null &&
              (app.job!.jobType.isNotEmpty ||
                  app.job!.category.isNotEmpty)) ...[
            const SizedBox(height: 12),
            Wrap(
              spacing: 8,
              runSpacing: 8,
              children: [
                if (app.job!.jobType.isNotEmpty)
                  _buildTagChip(
                    Icons.work_outline_rounded,
                    app.job!.jobType,
                  ),
                if (app.job!.category.isNotEmpty)
                  _buildTagChip(
                    Icons.category_outlined,
                    app.job!.category,
                  ),
                if (app.job!.experience.isNotEmpty)
                  _buildTagChip(
                    Icons.stars_outlined,
                    app.job!.experience,
                  ),
              ],
            ),
          ],
        ],
      ),
    );
  }

  // Baris informasi dengan ikon
  Widget _buildInfoRow(IconData icon, String label, String value) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 10),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Container(
            padding: const EdgeInsets.all(6),
            decoration: BoxDecoration(
              color: const Color(0xfff1f5f9),
              borderRadius: BorderRadius.circular(8),
            ),
            child: Icon(icon, size: 14, color: AppTheme.textSecondary),
          ),
          const SizedBox(width: 10),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  label,
                  style: const TextStyle(
                    fontSize: 11,
                    color: AppTheme.textSecondary,
                    fontWeight: FontWeight.w500,
                  ),
                ),
                const SizedBox(height: 2),
                Text(
                  value,
                  style: const TextStyle(
                    fontSize: 13,
                    color: AppTheme.textPrimary,
                    fontWeight: FontWeight.w600,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  // Chip tag untuk informasi jenis pekerjaan, kategori, dll
  Widget _buildTagChip(IconData icon, String label) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 6),
      decoration: BoxDecoration(
        color: const Color(0xfff8fafc),
        borderRadius: BorderRadius.circular(10),
        border: Border.all(
          color: const Color(0xffe2e8f0),
          width: 1,
        ),
      ),
      child: Row(
        mainAxisSize: MainAxisSize.min,
        children: [
          Icon(icon, size: 12, color: AppTheme.textSecondary),
          const SizedBox(width: 5),
          Text(
            label,
            style: const TextStyle(
              fontSize: 11,
              color: AppTheme.textSecondary,
              fontWeight: FontWeight.w600,
            ),
          ),
        ],
      ),
    );
  }
}
