import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../services/app_state.dart';
import '../services/auth_service.dart';
import '../pages/dashboard_page.dart';
import '../pages/member_page.dart';
import '../pages/profile_page.dart';
import '../pages/edukasi_page.dart';
import '../pages/statistics_page.dart';
import '../pages/my_profile_page.dart';

class AppShell extends StatefulWidget {
  final int initialIndex;
  const AppShell({super.key, this.initialIndex = 0});

  @override
  State<AppShell> createState() => _AppShellState();
}

class _AppShellState extends State<AppShell> {
  late int selectedIndex;

  final List<_NavItem> navItems = [
    _NavItem(label: 'Dashboard', icon: Icons.grid_view_rounded, page: const DashboardPage()),
    _NavItem(label: 'Member', icon: Icons.people_alt_rounded, page: const MemberPage()),
    _NavItem(label: 'Profil TPS', icon: Icons.location_on_outlined, page: const ProfilePage()),
    _NavItem(label: 'Profil Member', icon: Icons.person_pin_rounded, page: const MyProfilePage()),
    _NavItem(label: 'Edukasi', icon: Icons.school_rounded, page: const EdukasiPage()),
    _NavItem(label: 'Statistik', icon: Icons.bar_chart_rounded, page: const StatisticsPage()),
  ];

  @override
  void initState() {
    super.initState();
    selectedIndex = widget.initialIndex.clamp(0, navItems.length - 1);
  }

  @override
  Widget build(BuildContext context) {
    return LayoutBuilder(builder: (context, constraints) {
      final isDesktop = constraints.maxWidth >= 900;
      return Scaffold(
        backgroundColor: const Color(0xFFF0FDF4),
        body: isDesktop ? _buildDesktopBody() : _buildMobileBody(),
      );
    });
  }

  Widget _buildDesktopBody() {
    return Row(
      children: [
        // Sidebar
        Container(
          width: 300,
          padding: const EdgeInsets.symmetric(vertical: 28, horizontal: 20),
          decoration: BoxDecoration(
            color: Colors.white,
            border: Border(right: BorderSide(color: const Color(0xFF10B981).withValues(alpha: 0.15))),
            boxShadow: [
              BoxShadow(
                color: const Color(0xFF10B981).withValues(alpha: 0.05),
                blurRadius: 30,
                offset: const Offset(0, 12),
              ),
            ],
          ),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              // Logo Section
              _buildLogoSection(),
              const SizedBox(height: 32),

              // Menu Label
              const Padding(
                padding: EdgeInsets.only(left: 4, bottom: 12),
                child: Text(
                  'Menu Utama',
                  style: TextStyle(
                    fontSize: 12,
                    fontWeight: FontWeight.w700,
                    color: Color(0xFF6B7280),
                    letterSpacing: 0.5,
                  ),
                ),
              ),

              // Navigation Items
              ...navItems.asMap().entries.map((entry) {
                final index = entry.key;
                final item = entry.value;
                final isActive = index == selectedIndex;
                return _buildNavItem(item, index, isActive);
              }),

              const Spacer(),

              // Bottom Section
              _buildBottomSection(),
            ],
          ),
        ),

        // Main Content
        Expanded(
          child: Column(
            children: [
              // Top Bar
              _buildTopBar(),

              // Page Content
              Expanded(
                child: navItems[selectedIndex].page,
              ),
            ],
          ),
        ),
      ],
    );
  }

  Widget _buildLogoSection() {
    return Container(
      padding: const EdgeInsets.all(4),
      child: Row(
        children: [
          Container(
            padding: const EdgeInsets.all(12),
            decoration: BoxDecoration(
              gradient: const LinearGradient(
                colors: [Color(0xFF10B981), Color(0xFF059669)],
              ),
              borderRadius: BorderRadius.circular(16),
              boxShadow: [
                BoxShadow(
                  color: const Color(0xFF10B981).withValues(alpha: 0.3),
                  blurRadius: 12,
                  offset: const Offset(0, 4),
                ),
              ],
            ),
            child: const Icon(Icons.recycling, color: Colors.white, size: 24),
          ),
          const SizedBox(width: 14),
          const Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                'WasteAnalytics',
                style: TextStyle(
                  fontSize: 18,
                  fontWeight: FontWeight.w800,
                  color: Color(0xFF111827),
                ),
              ),
              Text(
                'TPS 3R Brama Muda',
                style: TextStyle(
                  fontSize: 12,
                  color: Color(0xFF10B981),
                  fontWeight: FontWeight.w600,
                ),
              ),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildNavItem(_NavItem item, int index, bool isActive) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 4),
      child: AnimatedContainer(
        duration: const Duration(milliseconds: 200),
        curve: Curves.easeOut,
        decoration: BoxDecoration(
          color: isActive ? const Color(0xFFECFDF5) : Colors.transparent,
          borderRadius: BorderRadius.circular(16),
          border: isActive
              ? Border.all(color: const Color(0xFF10B981).withValues(alpha: 0.3))
              : null,
        ),
        child: Material(
          color: Colors.transparent,
          child: InkWell(
            borderRadius: BorderRadius.circular(16),
            onTap: () => setState(() => selectedIndex = index),
            child: Container(
              padding: const EdgeInsets.symmetric(vertical: 14, horizontal: 16),
              child: Row(
                children: [
                  Container(
                    padding: const EdgeInsets.all(8),
                    decoration: BoxDecoration(
                      color: isActive
                          ? const Color(0xFF10B981).withValues(alpha: 0.15)
                          : const Color(0xFFF3F4F6),
                      borderRadius: BorderRadius.circular(10),
                    ),
                    child: Icon(
                      item.icon,
                      color: isActive ? const Color(0xFF059669) : const Color(0xFF6B7280),
                      size: 20,
                    ),
                  ),
                  const SizedBox(width: 14),
                  Text(
                    item.label,
                    style: TextStyle(
                      fontSize: 14,
                      fontWeight: isActive ? FontWeight.w700 : FontWeight.w600,
                      color: isActive ? const Color(0xFF059669) : const Color(0xFF4B5563),
                    ),
                  ),
                  if (isActive) ...[
                    const Spacer(),
                    Container(
                      width: 6,
                      height: 6,
                      decoration: const BoxDecoration(
                        color: Color(0xFF10B981),
                        shape: BoxShape.circle,
                      ),
                    ),
                  ],
                ],
              ),
            ),
          ),
        ),
      ),
    );
  }

  Widget _buildBottomSection() {
    return Column(
      children: [
        // Profile Card with gradient
        Container(
          width: double.infinity,
          padding: const EdgeInsets.all(16),
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
                blurRadius: 12,
                offset: const Offset(0, 4),
              ),
            ],
          ),
          child: Column(
            children: [
              // Avatar
              Container(
                width: 56,
                height: 56,
                decoration: BoxDecoration(
                  color: Colors.white.withValues(alpha: 0.2),
                  borderRadius: BorderRadius.circular(16),
                ),
                child: const Icon(Icons.person, color: Colors.white, size: 28),
              ),
              const SizedBox(height: 12),
              // Name & Role
              const Text(
                'Warga TPS 3R',
                style: TextStyle(
                  fontSize: 16,
                  fontWeight: FontWeight.w800,
                  color: Colors.white,
                ),
              ),
              const SizedBox(height: 4),
              Container(
                padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 4),
                decoration: BoxDecoration(
                  color: Colors.white.withValues(alpha: 0.2),
                  borderRadius: BorderRadius.circular(12),
                ),
                child: const Text(
                  'Member Aktif',
                  style: TextStyle(
                    fontSize: 11,
                    fontWeight: FontWeight.w600,
                    color: Colors.white,
                  ),
                ),
              ),
            ],
          ),
        ),
        const SizedBox(height: 14),
        // Logout Button
        SizedBox(
          width: double.infinity,
          child: Container(
            decoration: BoxDecoration(
              gradient: LinearGradient(
                begin: Alignment.topLeft,
                end: Alignment.bottomRight,
                colors: [
                  const Color(0xFF14532D),
                  const Color(0xFF166534),
                ],
              ),
              borderRadius: BorderRadius.circular(16),
              boxShadow: [
                BoxShadow(
                  color: const Color(0xFF14532D).withValues(alpha: 0.3),
                  blurRadius: 8,
                  offset: const Offset(0, 4),
                ),
              ],
            ),
            child: Material(
              color: Colors.transparent,
              child: InkWell(
                onTap: () => _showLogoutDialog(),
                borderRadius: BorderRadius.circular(16),
                child: Padding(
                  padding: const EdgeInsets.symmetric(vertical: 16, horizontal: 20),
                  child: Row(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Container(
                        padding: const EdgeInsets.all(8),
                        decoration: BoxDecoration(
                          color: Colors.white.withValues(alpha: 0.2),
                          borderRadius: BorderRadius.circular(10),
                        ),
                        child: const Icon(Icons.logout, color: Colors.white, size: 18),
                      ),
                      const SizedBox(width: 12),
                      const Text(
                        'Keluar dari Akun',
                        style: TextStyle(
                          fontSize: 14,
                          fontWeight: FontWeight.w700,
                          color: Colors.white,
                        ),
                      ),
                    ],
                  ),
                ),
              ),
            ),
          ),
        ),
      ],
    );
  }

  void _showLogoutDialog() {
    showDialog(
      context: context,
      builder: (context) => Dialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(24)),
        child: Padding(
          padding: const EdgeInsets.all(24),
          child: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              // Icon
              Container(
                width: 72,
                height: 72,
                decoration: BoxDecoration(
                  gradient: const LinearGradient(
                    begin: Alignment.topLeft,
                    end: Alignment.bottomRight,
                    colors: [Color(0xFF10B981), Color(0xFF059669)],
                  ),
                  borderRadius: BorderRadius.circular(20),
                ),
                child: const Icon(Icons.logout, color: Colors.white, size: 32),
              ),
              const SizedBox(height: 20),
              // Title
              const Text(
                'Konfirmasi Keluar',
                style: TextStyle(
                  fontSize: 20,
                  fontWeight: FontWeight.w800,
                  color: Color(0xFF111827),
                ),
              ),
              const SizedBox(height: 8),
              // Description
              const Text(
                'Apakah Anda yakin ingin keluar dari akun member?',
                style: TextStyle(
                  fontSize: 14,
                  color: Color(0xFF6B7280),
                ),
                textAlign: TextAlign.center,
              ),
              const SizedBox(height: 28),
              // Buttons
              Row(
                children: [
                  // Batal Button
                  Expanded(
                    child: Container(
                      decoration: BoxDecoration(
                        color: const Color(0xFFF3F4F6),
                        borderRadius: BorderRadius.circular(14),
                      ),
                      child: Material(
                        color: Colors.transparent,
                        child: InkWell(
                          onTap: () => Navigator.of(context).pop(),
                          borderRadius: BorderRadius.circular(14),
                          child: const Padding(
                            padding: EdgeInsets.symmetric(vertical: 14),
                            child: Text(
                              'Batal',
                              style: TextStyle(
                                fontSize: 14,
                                fontWeight: FontWeight.w600,
                                color: Color(0xFF374151),
                              ),
                              textAlign: TextAlign.center,
                            ),
                          ),
                        ),
                      ),
                    ),
                  ),
                  const SizedBox(width: 12),
                  // Keluar Button
                  Expanded(
                    child: Container(
                      decoration: BoxDecoration(
                        gradient: const LinearGradient(
                          begin: Alignment.topLeft,
                          end: Alignment.bottomRight,
                          colors: [Color(0xFF10B981), Color(0xFF059669)],
                        ),
                        borderRadius: BorderRadius.circular(14),
                        boxShadow: [
                          BoxShadow(
                            color: const Color(0xFF10B981).withValues(alpha: 0.3),
                            blurRadius: 8,
                            offset: const Offset(0, 4),
                          ),
                        ],
                      ),
                      child: Material(
                        color: Colors.transparent,
                        child: InkWell(
                          onTap: () async {
                            // Tutup dialog
                            Navigator.of(context).pop();

                            // Logout dengan AuthService
                            await AuthService.logoutUser();

                            if (!mounted) return;

                            // Tampilkan snackbar
                            if (!mounted) return;
                            ScaffoldMessenger.of(context).showSnackBar(
                              const SnackBar(
                                content: Row(
                                  children: [
                                    Icon(
                                      Icons.check_circle,
                                      color: Colors.white,
                                      size: 20,
                                    ),
                                    SizedBox(width: 12),
                                    Expanded(
                                      child: Text('Berhasil keluar dari akun'),
                                    ),
                                  ],
                                ),
                                backgroundColor: Color(0xFF10B981),
                                behavior: SnackBarBehavior.floating,
                                shape: RoundedRectangleBorder(
                                  borderRadius: BorderRadius.all(Radius.circular(12)),
                                ),
                                margin: EdgeInsets.all(16),
                              ),
                            );

                            // Navigasi ke landing page
                            Navigator.of(context).pushReplacementNamed('/landing');
                          },
                          borderRadius: BorderRadius.circular(14),
                          child: const Padding(
                            padding: EdgeInsets.symmetric(vertical: 14),
                            child: Text(
                              'Keluar',
                              style: TextStyle(
                                fontSize: 14,
                                fontWeight: FontWeight.w700,
                                color: Colors.white,
                              ),
                              textAlign: TextAlign.center,
                            ),
                          ),
                        ),
                      ),
                    ),
                  ),
                ],
              ),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildTopBar() {
    return Consumer<AppState>(
      builder: (context, appState, child) {
        final now = DateTime.now();
        final months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        final monthName = months[now.month - 1];

        return Container(
          height: 80,
          padding: const EdgeInsets.symmetric(horizontal: 28),
          decoration: BoxDecoration(
            color: Colors.white,
            boxShadow: [
              BoxShadow(
                color: const Color(0xFF10B981).withValues(alpha: 0.08),
                blurRadius: 20,
                offset: const Offset(0, 8),
              ),
            ],
          ),
          child: Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  Text(
                    navItems[selectedIndex].label,
                    style: const TextStyle(
                      fontSize: 22,
                      fontWeight: FontWeight.w800,
                      color: Color(0xFF111827),
                    ),
                  ),
                  const SizedBox(height: 4),
                  const Text(
                    'Panel operasional TPS 3R Brama Muda',
                    style: TextStyle(
                      fontSize: 13,
                      color: Color(0xFF6B7280),
                    ),
                  ),
                ],
              ),
              Row(
                children: [
                  Container(
                    padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 10),
                    decoration: BoxDecoration(
                      color: const Color(0xFFECFDF5),
                      borderRadius: BorderRadius.circular(14),
                      border: Border.all(color: const Color(0xFFD1FAE5)),
                    ),
                    child: Row(
                      children: [
                        const Icon(Icons.eco, size: 18, color: Color(0xFF059669)),
                        const SizedBox(width: 8),
                        Text(
                          '$monthName ${now.year}',
                          style: const TextStyle(
                            color: Color(0xFF059669),
                            fontWeight: FontWeight.w700,
                            fontSize: 13,
                          ),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
            ],
          ),
        );
      },
    );
  }

  Widget _buildMobileBody() {
    return Scaffold(
      appBar: AppBar(
        backgroundColor: Colors.white,
        elevation: 0,
        title: Row(
          children: [
            Container(
              padding: const EdgeInsets.all(8),
              decoration: BoxDecoration(
                gradient: const LinearGradient(
                  colors: [Color(0xFF10B981), Color(0xFF059669)],
                ),
                borderRadius: BorderRadius.circular(10),
              ),
              child: const Icon(Icons.recycling, color: Colors.white, size: 20),
            ),
            const SizedBox(width: 12),
            const Text(
              'WasteAnalytics',
              style: TextStyle(
                fontSize: 18,
                fontWeight: FontWeight.w800,
                color: Color(0xFF111827),
              ),
            ),
          ],
        ),
        actions: [
          IconButton(
            icon: const Icon(Icons.logout, color: Color(0xFF6B7280)),
            onPressed: () => _showLogoutDialog(),
          ),
        ],
      ),
      body: navItems[selectedIndex].page,
      bottomNavigationBar: Container(
        decoration: BoxDecoration(
          color: Colors.white,
          boxShadow: [
            BoxShadow(
              color: Colors.black.withValues(alpha: 0.08),
              blurRadius: 20,
              offset: const Offset(0, -8),
            ),
          ],
        ),
        child: SafeArea(
          child: Padding(
            padding: const EdgeInsets.only(top: 8, bottom: 12, left: 4, right: 4),
            child: Row(
              children: navItems.asMap().entries.map((entry) {
                final index = entry.key;
                final item = entry.value;
                final isActive = index == selectedIndex;
                return Expanded(
                  child: _buildMobileNavItem(item, index, isActive),
                );
              }).toList(),
            ),
          ),
        ),
      ),
    );
  }

  Widget _buildMobileNavItem(_NavItem item, int index, bool isActive) {
    return GestureDetector(
      onTap: () => setState(() => selectedIndex = index),
      child: Container(
        margin: const EdgeInsets.symmetric(horizontal: 2),
        padding: const EdgeInsets.symmetric(vertical: 8, horizontal: 4),
        decoration: BoxDecoration(
          color: isActive ? const Color(0xFFECFDF5) : Colors.transparent,
          borderRadius: BorderRadius.circular(12),
        ),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            Container(
              padding: const EdgeInsets.all(6),
              decoration: BoxDecoration(
                color: isActive
                    ? const Color(0xFF10B981).withValues(alpha: 0.15)
                    : Colors.transparent,
                borderRadius: BorderRadius.circular(8),
              ),
              child: Icon(
                item.icon,
                color: isActive ? const Color(0xFF059669) : const Color(0xFF9CA3AF),
                size: 20,
              ),
            ),
            const SizedBox(height: 4),
            SizedBox(
              width: double.infinity,
              child: Text(
                item.label,
                style: TextStyle(
                  fontSize: 10,
                  fontWeight: isActive ? FontWeight.w700 : FontWeight.w500,
                  color: isActive ? const Color(0xFF059669) : const Color(0xFF9CA3AF),
                ),
                textAlign: TextAlign.center,
                maxLines: 1,
                overflow: TextOverflow.ellipsis,
              ),
            ),
          ],
        ),
      ),
    );
  }
}

class _NavItem {
  final String label;
  final IconData icon;
  final Widget page;

  const _NavItem({required this.label, required this.icon, required this.page});
}