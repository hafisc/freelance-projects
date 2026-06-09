import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'waste_page.dart';
import '../services/profile_service.dart';
import '../services/auth_service.dart';

/// ============================================================
/// MyProfilePage - Halaman Profil Member
/// ============================================================
/// Menampilkan profil member dengan data dari AuthService/API
/// Menggunakan FutureBuilder untuk loading
///
/// Author: Claude
/// ============================================================

class MyProfilePage extends StatefulWidget {
  const MyProfilePage({super.key});

  @override
  State<MyProfilePage> createState() => _MyProfilePageState();
}

class _MyProfilePageState extends State<MyProfilePage> {
  // State untuk loading dan error
  bool _isLoading = false;
  bool _isSaving = false;
  String? _errorMessage;

  // Data profil
  Map<String, dynamic>? _profileData;

  @override
  void initState() {
    super.initState();
    _loadProfileData();
  }

  // ============================================================
  // LOAD PROFILE DATA - Ambil data dari API
  // ============================================================
  Future<void> _loadProfileData() async {
    setState(() {
      _isLoading = true;
      _errorMessage = null;
    });

    try {
      final profile = await ProfileService.getUserProfile();

      if (!mounted) return;

      setState(() {
        _profileData = profile ?? _getDefaultProfile();
        _isLoading = false;
      });
    } catch (e) {
      if (!mounted) return;

      setState(() {
        _errorMessage = 'Gagal memuat data profil.';
        _isLoading = false;
      });
    }
  }

  // ============================================================
  // DEFAULT PROFILE - Profile fallback jika tidak ada data
  // ============================================================
  Map<String, dynamic> _getDefaultProfile() {
    return {
      'id': 0,
      'name': 'Member',
      'email': '-',
      'phone': '-',
      'address': '-',
      'role': 'member',
      'status': 'aktif',
      'tier': 'BRONZE',
      'poin': 0,
      'totalReports': 0,
      'completedReports': 0,
      'processedReports': 0,
    };
  }

  // ============================================================
  // SHOW EDIT PROFILE DIALOG - Dialog edit profil
  // ============================================================
  void _showEditProfileDialog() {
    final nameController = TextEditingController(
      text: _profileData?['name'] ?? 'Member',
    );
    final emailController = TextEditingController(
      text: _profileData?['email'] ?? '-',
    );
    final phoneController = TextEditingController(
      text: _profileData?['phone'] ?? '-',
    );
    final addressController = TextEditingController(
      text: _profileData?['address'] ?? '-',
    );

    showDialog(
      context: context,
      builder: (context) => Dialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(24)),
        child: SingleChildScrollView(
          child: Padding(
            padding: const EdgeInsets.all(24),
            child: Column(
              mainAxisSize: MainAxisSize.min,
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                // Header
                Row(
                  children: [
                    Container(
                      padding: const EdgeInsets.all(12),
                      decoration: BoxDecoration(
                        gradient: const LinearGradient(
                          colors: [Color(0xFF10B981), Color(0xFF059669)],
                        ),
                        borderRadius: BorderRadius.circular(14),
                      ),
                      child: const Icon(Icons.edit, color: Colors.white, size: 24),
                    ),
                    const SizedBox(width: 14),
                    const Expanded(
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Text(
                            'Edit Profil',
                            style: TextStyle(
                              fontSize: 20,
                              fontWeight: FontWeight.w800,
                              color: Color(0xFF111827),
                            ),
                          ),
                          Text(
                            'Perbarui informasi member',
                            style: TextStyle(
                              fontSize: 12,
                              color: Color(0xFF6B7280),
                            ),
                          ),
                        ],
                      ),
                    ),
                    IconButton(
                      onPressed: () => Navigator.pop(context),
                      icon: const Icon(Icons.close, color: Color(0xFF6B7280)),
                    ),
                  ],
                ),
                const SizedBox(height: 24),

                // Form Fields
                _buildFormField(
                  controller: nameController,
                  label: 'Nama Lengkap',
                  icon: Icons.person_outline,
                  hint: 'Masukkan nama lengkap',
                ),
                const SizedBox(height: 16),

                _buildFormField(
                  controller: emailController,
                  label: 'Email',
                  icon: Icons.email_outlined,
                  hint: 'Masukkan email',
                  enabled: false, // Email tidak bisa diubah
                ),
                const SizedBox(height: 16),

                _buildFormField(
                  controller: phoneController,
                  label: 'Nomor HP',
                  icon: Icons.phone_outlined,
                  hint: 'Masukkan nomor HP',
                  keyboardType: TextInputType.phone,
                ),
                const SizedBox(height: 16),

                _buildFormField(
                  controller: addressController,
                  label: 'Alamat',
                  icon: Icons.location_on_outlined,
                  hint: 'Masukkan alamat lengkap',
                  maxLines: 2,
                ),
                const SizedBox(height: 28),

                // Buttons
                Row(
                  children: [
                    Expanded(
                      child: Container(
                        decoration: BoxDecoration(
                          color: const Color(0xFFF3F4F6),
                          borderRadius: BorderRadius.circular(14),
                        ),
                        child: Material(
                          color: Colors.transparent,
                          child: InkWell(
                            onTap: () => Navigator.pop(context),
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
                    Expanded(
                      child: Container(
                        decoration: BoxDecoration(
                          gradient: _isSaving
                              ? null
                              : const LinearGradient(
                                  colors: [Color(0xFF10B981), Color(0xFF059669)],
                                ),
                          color: _isSaving ? Colors.grey.shade300 : null,
                          borderRadius: BorderRadius.circular(14),
                          boxShadow: _isSaving
                              ? null
                              : [
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
                            onTap: _isSaving
                                ? null
                                : () async {
                                    // Simpan perubahan
                                    final result = await ProfileService.updateUserProfile(
                                      name: nameController.text,
                                      phone: phoneController.text,
                                      address: addressController.text,
                                    );

                                    if (!mounted) return;

                                    // Tutup dialog
                                    Navigator.pop(context);

                                    // Tampilkan snackbar
                                    ScaffoldMessenger.of(context).showSnackBar(
                                      SnackBar(
                                        content: Row(
                                          children: [
                                            Icon(
                                              result['success']
                                                  ? Icons.check_circle
                                                  : Icons.error,
                                              color: Colors.white,
                                              size: 20,
                                            ),
                                            const SizedBox(width: 12),
                                            Expanded(
                                              child: Text(result['message']),
                                            ),
                                          ],
                                        ),
                                        backgroundColor: result['success']
                                            ? const Color(0xFF10B981)
                                            : const Color(0xFFEF4444),
                                        behavior: SnackBarBehavior.floating,
                                        shape: RoundedRectangleBorder(
                                          borderRadius: BorderRadius.circular(12),
                                        ),
                                        margin: const EdgeInsets.all(16),
                                      ),
                                    );

                                    // Refresh data jika berhasil
                                    if (result['success']) {
                                      _loadProfileData();
                                    }
                                  },
                            borderRadius: BorderRadius.circular(14),
                            child: Padding(
                              padding: const EdgeInsets.symmetric(vertical: 14),
                              child: _isSaving
                                  ? const SizedBox(
                                      width: 20,
                                      height: 20,
                                      child: CircularProgressIndicator(
                                        color: Colors.white,
                                        strokeWidth: 2,
                                      ),
                                    )
                                  : const Text(
                                      'Simpan',
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
      ),
    );
  }

  Widget _buildFormField({
    required TextEditingController controller,
    required String label,
    required IconData icon,
    required String hint,
    TextInputType keyboardType = TextInputType.text,
    int maxLines = 1,
    bool enabled = true,
  }) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          label,
          style: const TextStyle(
            fontSize: 12,
            fontWeight: FontWeight.w600,
            color: Color(0xFF6B7280),
          ),
        ),
        const SizedBox(height: 8),
        Container(
          decoration: BoxDecoration(
            color: const Color(0xFFF9FAFB),
            borderRadius: BorderRadius.circular(14),
            border: Border.all(
              color: enabled ? const Color(0xFFE5E7EB) : const Color(0xFFE5E7EB),
            ),
          ),
          child: TextField(
            controller: controller,
            keyboardType: keyboardType,
            maxLines: maxLines,
            enabled: enabled,
            style: TextStyle(
              color: enabled ? const Color(0xFF111827) : const Color(0xFF9CA3AF),
            ),
            decoration: InputDecoration(
              prefixIcon: Icon(icon, color: const Color(0xFF10B981), size: 20),
              hintText: hint,
              hintStyle: const TextStyle(
                fontSize: 14,
                color: Color(0xFF9CA3AF),
              ),
              border: InputBorder.none,
              contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 14),
            ),
          ),
        ),
      ],
    );
  }

  // ============================================================
  // SHOW LOGOUT DIALOG - Dialog konfirmasi logout
  // ============================================================
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
              Container(
                width: 72,
                height: 72,
                decoration: BoxDecoration(
                  gradient: const LinearGradient(
                    colors: [Color(0xFFEF4444), Color(0xFFDC2626)],
                  ),
                  borderRadius: BorderRadius.circular(20),
                ),
                child: const Icon(Icons.logout, color: Colors.white, size: 32),
              ),
              const SizedBox(height: 20),
              const Text(
                'Konfirmasi Keluar',
                style: TextStyle(
                  fontSize: 20,
                  fontWeight: FontWeight.w800,
                  color: Color(0xFF111827),
                ),
              ),
              const SizedBox(height: 8),
              const Text(
                'Apakah Anda yakin ingin keluar dari akun?',
                style: TextStyle(
                  fontSize: 14,
                  color: Color(0xFF6B7280),
                ),
                textAlign: TextAlign.center,
              ),
              const SizedBox(height: 28),
              Row(
                children: [
                  Expanded(
                    child: Container(
                      decoration: BoxDecoration(
                        color: const Color(0xFFF3F4F6),
                        borderRadius: BorderRadius.circular(14),
                      ),
                      child: Material(
                        color: Colors.transparent,
                        child: InkWell(
                          onTap: () => Navigator.pop(context),
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
                  Expanded(
                    child: Container(
                      decoration: BoxDecoration(
                        gradient: const LinearGradient(
                          colors: [Color(0xFFEF4444), Color(0xFFDC2626)],
                        ),
                        borderRadius: BorderRadius.circular(14),
                      ),
                      child: Material(
                        color: Colors.transparent,
                        child: InkWell(
                          onTap: () async {
                            // Tutup dialog
                            Navigator.pop(context);

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

                            // Navigasi ke landing
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

  void _showMenuDialog(String title) {
    showDialog(
      context: context,
      builder: (context) => Dialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(24)),
        child: Padding(
          padding: const EdgeInsets.all(24),
          child: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              Container(
                width: 72,
                height: 72,
                decoration: BoxDecoration(
                  color: const Color(0xFFECFDF5),
                  borderRadius: BorderRadius.circular(20),
                ),
                child: const Icon(Icons.construction, color: Color(0xFF10B981), size: 32),
              ),
              const SizedBox(height: 20),
              Text(
                title,
                style: const TextStyle(
                  fontSize: 20,
                  fontWeight: FontWeight.w800,
                  color: Color(0xFF111827),
                ),
              ),
              const SizedBox(height: 8),
              const Text(
                'Fitur sedang dalam pengembangan',
                style: TextStyle(
                  fontSize: 14,
                  color: Color(0xFF6B7280),
                ),
                textAlign: TextAlign.center,
              ),
              const SizedBox(height: 24),
              Container(
                decoration: BoxDecoration(
                  gradient: const LinearGradient(
                    colors: [Color(0xFF10B981), Color(0xFF059669)],
                  ),
                  borderRadius: BorderRadius.circular(14),
                ),
                child: Material(
                  color: Colors.transparent,
                  child: InkWell(
                    onTap: () => Navigator.pop(context),
                    borderRadius: BorderRadius.circular(14),
                    child: const Padding(
                      padding: EdgeInsets.symmetric(vertical: 14, horizontal: 40),
                      child: Text(
                        'OK',
                        style: TextStyle(
                          fontSize: 14,
                          fontWeight: FontWeight.w700,
                          color: Colors.white,
                        ),
                      ),
                    ),
                  ),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    // ============================================================
    // LOADING STATE - Tampilkan loading saat fetch data
    // ============================================================
    if (_isLoading) {
      return Scaffold(
        backgroundColor: const Color(0xFFF4FBF7),
        body: Center(
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Container(
                padding: const EdgeInsets.all(20),
                decoration: const BoxDecoration(
                  color: Color(0xFFECFDF5),
                  shape: BoxShape.circle,
                ),
                child: const SizedBox(
                  width: 40,
                  height: 40,
                  child: CircularProgressIndicator(
                    color: Color(0xFF10B981),
                    strokeWidth: 3,
                  ),
                ),
              ),
              const SizedBox(height: 16),
              const Text(
                'Memuat profil...',
                style: TextStyle(
                  fontSize: 14,
                  color: Color(0xFF6B7280),
                ),
              ),
            ],
          ),
        ),
      );
    }

    // ============================================================
    // ERROR STATE - Tampilkan error jika ada
    // ============================================================
    if (_errorMessage != null) {
      return Scaffold(
        backgroundColor: const Color(0xFFF4FBF7),
        body: Center(
          child: Padding(
            padding: const EdgeInsets.all(24),
            child: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                Container(
                  padding: const EdgeInsets.all(20),
                  decoration: const BoxDecoration(
                    color: Color(0xFFFEE2E2),
                    shape: BoxShape.circle,
                  ),
                  child: const Icon(
                    Icons.error_outline,
                    color: Color(0xFFEF4444),
                    size: 40,
                  ),
                ),
                const SizedBox(height: 16),
                const Text(
                  'Gagal memuat profil',
                  style: TextStyle(
                    fontSize: 18,
                    fontWeight: FontWeight.w700,
                    color: Color(0xFF111827),
                  ),
                ),
                const SizedBox(height: 8),
                Text(
                  _errorMessage!,
                  style: const TextStyle(
                    fontSize: 14,
                    color: Color(0xFF6B7280),
                  ),
                  textAlign: TextAlign.center,
                ),
                const SizedBox(height: 24),
                GestureDetector(
                  onTap: _loadProfileData,
                  child: Container(
                    padding: const EdgeInsets.symmetric(
                      horizontal: 24,
                      vertical: 14,
                    ),
                    decoration: BoxDecoration(
                      gradient: const LinearGradient(
                        colors: [Color(0xFF10B981), Color(0xFF059669)],
                      ),
                      borderRadius: BorderRadius.circular(14),
                    ),
                    child: const Text(
                      'Coba Lagi',
                      style: TextStyle(
                        fontSize: 14,
                        fontWeight: FontWeight.w700,
                        color: Colors.white,
                      ),
                    ),
                  ),
                ),
              ],
            ),
          ),
        ),
      );
    }

    // ============================================================
    // SUCCESS STATE - Tampilkan profil
    // ============================================================
    final profile = _profileData ?? _getDefaultProfile();
    final name = profile['name'] ?? 'Member';
    final email = profile['email'] ?? '-';
    final phone = profile['phone'] ?? '-';
    final address = profile['address'] ?? '-';
    final tier = profile['tier'] ?? 'BRONZE';
    final status = profile['status'] ?? 'aktif';
    final poin = profile['poin'] ?? 0;
    final totalReports = profile['totalReports'] ?? 0;
    final completedReports = profile['completedReports'] ?? 0;
    final processedReports = profile['processedReports'] ?? 0;

    return Scaffold(
      backgroundColor: const Color(0xFFF4FBF7),
      body: SafeArea(
        child: SingleChildScrollView(
          physics: const BouncingScrollPhysics(),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.stretch,
            children: [
              // Header Profil
              _buildProfileHeader(
                name: name,
                status: status,
                tier: tier,
              ),
              const SizedBox(height: 20),

              // Info Profil
              _buildProfileInfo(
                name: name,
                email: email,
                phone: phone,
                address: address,
                status: status,
              ),
              const SizedBox(height: 20),

              // Ringkasan Aktivitas
              _buildSectionTitle('Ringkasan Aktivitas', Icons.insights_outlined),
              _buildActivitySummary(
                totalReports: totalReports,
                completedReports: completedReports,
                processedReports: processedReports,
                poin: poin,
              ),
              const SizedBox(height: 20),

              // Menu List
              _buildSectionTitle('Menu', Icons.menu_outlined),
              _buildMenuList(),
              const SizedBox(height: 20),

              // Tombol Logout
              _buildLogoutButton(),
              const SizedBox(height: 32),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildProfileHeader({
    required String name,
    required String status,
    required String tier,
  }) {
    return LayoutBuilder(
      builder: (context, constraints) {
        final isSmallScreen = constraints.maxWidth < 360;
        final isLargeScreen = constraints.maxWidth > 600;

        return Container(
          margin: EdgeInsets.all(isSmallScreen ? 12 : 16),
          padding: EdgeInsets.all(isLargeScreen ? 32 : 24),
          decoration: BoxDecoration(
            gradient: const LinearGradient(
              begin: Alignment.topLeft,
              end: Alignment.bottomRight,
              colors: [Color(0xFF10B981), Color(0xFF059669)],
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
          child: Column(
            children: [
              // Avatar dengan Tier Badge
              Stack(
                alignment: Alignment.bottomRight,
                children: [
                  Container(
                    width: isSmallScreen ? 70 : 90,
                    height: isSmallScreen ? 70 : 90,
                    decoration: BoxDecoration(
                      color: Colors.white.withValues(alpha: 0.2),
                      shape: BoxShape.circle,
                      border: Border.all(color: Colors.white.withValues(alpha: 0.5), width: 3),
                    ),
                    child: const Icon(Icons.person, color: Colors.white, size: 48),
                  ),
                  // Tier Badge
                  Container(
                    padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                    decoration: BoxDecoration(
                      color: const Color(0xFFFFD700),
                      borderRadius: BorderRadius.circular(12),
                      border: Border.all(color: Colors.white, width: 2),
                    ),
                    child: Row(
                      mainAxisSize: MainAxisSize.min,
                      children: [
                        const Icon(Icons.star, color: Color(0xFFB8860B), size: 12),
                        const SizedBox(width: 2),
                        Text(
                          tier,
                          style: const TextStyle(
                            color: Color(0xFFB8860B),
                            fontSize: 9,
                            fontWeight: FontWeight.w800,
                          ),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
              SizedBox(height: isSmallScreen ? 12 : 16),

              // Nama
              Text(
                name,
                style: TextStyle(
                  color: Colors.white,
                  fontSize: isSmallScreen ? 18 : 22,
                  fontWeight: FontWeight.w800,
                ),
                textAlign: TextAlign.center,
                maxLines: 2,
                overflow: TextOverflow.ellipsis,
              ),
              const SizedBox(height: 8),

              // Status Badge
              Container(
                padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 6),
                decoration: BoxDecoration(
                  color: Colors.white.withValues(alpha: 0.2),
                  borderRadius: BorderRadius.circular(20),
                ),
                child: Row(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    Icon(
                      status == 'aktif' ? Icons.verified : Icons.pending,
                      color: Colors.white,
                      size: 14,
                    ),
                    const SizedBox(width: 4),
                    Text(
                      status == 'aktif' ? 'Member Aktif' : 'Member Pending',
                      style: const TextStyle(
                        color: Colors.white,
                        fontSize: 12,
                        fontWeight: FontWeight.w600,
                      ),
                    ),
                  ],
                ),
              ),
            ],
          ),
        );
      },
    );
  }

  Widget _buildProfileInfo({
    required String name,
    required String email,
    required String phone,
    required String address,
    required String status,
  }) {
    return LayoutBuilder(
      builder: (context, constraints) {
        final isSmallScreen = constraints.maxWidth < 360;

        return Container(
          margin: EdgeInsets.symmetric(horizontal: isSmallScreen ? 12 : 16),
          padding: EdgeInsets.all(isSmallScreen ? 16 : 20),
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
              // Judul Section
              Row(
                children: [
                  Container(
                    padding: const EdgeInsets.all(8),
                    decoration: BoxDecoration(
                      color: const Color(0xFFECFDF5),
                      borderRadius: BorderRadius.circular(10),
                    ),
                    child: const Icon(Icons.badge_outlined, color: Color(0xFF10B981), size: 18),
                  ),
                  const SizedBox(width: 10),
                  const Text(
                    'Informasi Member',
                    style: TextStyle(
                      fontSize: 18,
                      fontWeight: FontWeight.w700,
                      color: Color(0xFF111827),
                    ),
                  ),
                ],
              ),
              const SizedBox(height: 20),

              // Grid Info
              Wrap(
                spacing: 12,
                runSpacing: 12,
                children: [
                  _buildInfoCard(Icons.person_outline, 'Nama Lengkap', name),
                  _buildInfoCard(Icons.email_outlined, 'Email', email),
                  _buildInfoCard(Icons.phone_outlined, 'Nomor HP', phone == '-' ? 'Belum diisi' : phone),
                  _buildInfoCard(Icons.location_on_outlined, 'Alamat', address == '-' ? 'Belum diisi' : address),
                  _buildInfoCard(
                    Icons.workspace_premium_outlined,
                    'Status',
                    status == 'aktif' ? 'Member Aktif' : 'Pending',
                    valueColor: status == 'aktif' ? const Color(0xFF10B981) : const Color(0xFFF59E0B),
                  ),
                  _buildInfoCard(
                    Icons.calendar_today_outlined,
                    'Tanggal Bergabung',
                    _formatDate(_profileData?['created_at']),
                  ),
                ],
              ),
              const SizedBox(height: 20),

              // Tombol Edit
              SizedBox(
                width: double.infinity,
                child: Container(
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
                  child: Material(
                    color: Colors.transparent,
                    child: InkWell(
                      onTap: _showEditProfileDialog,
                      borderRadius: BorderRadius.circular(16),
                      child: const Padding(
                        padding: EdgeInsets.symmetric(vertical: 14),
                        child: Row(
                          mainAxisAlignment: MainAxisAlignment.center,
                          children: [
                            Icon(Icons.edit_outlined, color: Colors.white, size: 18),
                            SizedBox(width: 8),
                            Text(
                              'Edit Profil',
                              style: TextStyle(
                                color: Colors.white,
                                fontSize: 14,
                                fontWeight: FontWeight.w700,
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
          ),
        );
      },
    );
  }

  String _formatDate(dynamic timestamp) {
    if (timestamp == null) return '-';

    try {
      if (timestamp is String) {
        // Parse string date
        final date = DateTime.tryParse(timestamp);
        if (date != null) {
          final months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
          return '${date.day} ${months[date.month - 1]} ${date.year}';
        }
      }
      return '-';
    } catch (e) {
      return '-';
    }
  }

  Widget _buildInfoCard(IconData icon, String label, String value, {Color? valueColor}) {
    return Container(
      padding: const EdgeInsets.all(12),
      decoration: BoxDecoration(
        color: const Color(0xFFF9FAFB),
        borderRadius: BorderRadius.circular(14),
        border: Border.all(color: const Color(0xFFE5E7EB)),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            children: [
              Icon(icon, color: const Color(0xFF10B981), size: 16),
              const SizedBox(width: 6),
              Expanded(
                child: Text(
                  label,
                  style: const TextStyle(
                    fontSize: 11,
                    fontWeight: FontWeight.w600,
                    color: Color(0xFF9CA3AF),
                  ),
                  overflow: TextOverflow.ellipsis,
                ),
              ),
            ],
          ),
          const SizedBox(height: 6),
          Text(
            value,
            style: TextStyle(
              fontSize: 13,
              color: valueColor ?? const Color(0xFF111827),
              fontWeight: FontWeight.w600,
            ),
            overflow: TextOverflow.ellipsis,
            maxLines: 2,
          ),
        ],
      ),
    );
  }

  Widget _buildSectionTitle(String title, IconData icon) {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16),
      child: Row(
        children: [
          Container(
            padding: const EdgeInsets.all(8),
            decoration: BoxDecoration(
              color: const Color(0xFFECFDF5),
              borderRadius: BorderRadius.circular(10),
            ),
            child: Icon(icon, color: const Color(0xFF10B981), size: 18),
          ),
          const SizedBox(width: 10),
          Text(
            title,
            style: const TextStyle(
              fontSize: 18,
              fontWeight: FontWeight.w700,
              color: Color(0xFF111827),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildActivitySummary({
    required int totalReports,
    required int completedReports,
    required int processedReports,
    required int poin,
  }) {
    final stats = [
      {'value': totalReports.toString(), 'label': 'Total Laporan', 'icon': Icons.report_outlined, 'color': const Color(0xFF10B981)},
      {'value': completedReports.toString(), 'label': 'Selesai', 'icon': Icons.check_circle_outline, 'color': const Color(0xFF3B82F6)},
      {'value': processedReports.toString(), 'label': 'Diproses', 'icon': Icons.hourglass_empty, 'color': const Color(0xFFF59E0B)},
      {'value': poin.toString(), 'label': 'Poin', 'icon': Icons.star_outline, 'color': const Color(0xFF8B5CF6)},
    ];

    return Container(
      margin: const EdgeInsets.symmetric(horizontal: 16),
      child: GridView.builder(
        shrinkWrap: true,
        physics: const NeverScrollableScrollPhysics(),
        gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
          crossAxisCount: 4,
          mainAxisSpacing: 8,
          crossAxisSpacing: 8,
          childAspectRatio: 0.9,
        ),
        itemCount: stats.length,
        itemBuilder: (context, index) {
          final item = stats[index];
          return _buildStatCard(
            value: item['value'] as String,
            label: item['label'] as String,
            icon: item['icon'] as IconData,
            color: item['color'] as Color,
          );
        },
      ),
    );
  }

  /// Card statistik dengan ukuran sama untuk semua card
  Widget _buildStatCard({
    required String value,
    required String label,
    required IconData icon,
    required Color color,
  }) {
    return Container(
      padding: const EdgeInsets.symmetric(vertical: 12, horizontal: 8),
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
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        crossAxisAlignment: CrossAxisAlignment.center,
        mainAxisSize: MainAxisSize.min,
        children: [
          // Icon container - sama besar untuk semua
          Container(
            padding: const EdgeInsets.all(10),
            decoration: BoxDecoration(
              color: color.withValues(alpha: 0.1),
              shape: BoxShape.circle,
            ),
            child: Icon(icon, color: color, size: 20),
          ),
          const SizedBox(height: 8),

          // Value - angka besar di tengah
          Text(
            value,
            style: TextStyle(
              fontSize: 18,
              fontWeight: FontWeight.w900,
              color: color,
            ),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 2),

          // Label - teks di bawah
          Text(
            label,
            style: TextStyle(
              fontSize: 10,
              color: Colors.grey.shade600,
              fontWeight: FontWeight.w500,
            ),
            textAlign: TextAlign.center,
            maxLines: 1,
            overflow: TextOverflow.ellipsis,
          ),
        ],
      ),
    );
  }

  Widget _buildMenuList() {
    final menuItems = [
      {'icon': Icons.history, 'label': 'Riwayat Laporan'},
      {'icon': Icons.photo_library_outlined, 'label': 'Foto Lingkungan'},
      {'icon': Icons.emoji_events_outlined, 'label': 'Pencapaian'},
      {'icon': Icons.settings_outlined, 'label': 'Pengaturan Akun'},
      {'icon': Icons.help_outline, 'label': 'Bantuan & FAQ'},
    ];

    return Container(
      margin: const EdgeInsets.symmetric(horizontal: 16),
      padding: const EdgeInsets.symmetric(vertical: 8),
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
        children: menuItems.asMap().entries.map((entry) {
          final index = entry.key;
          final item = entry.value;
          final isLast = index == menuItems.length - 1;
          return Column(
            children: [
              Material(
                color: Colors.transparent,
                child: InkWell(
                  onTap: () {
                    if (item['label'] == 'Riwayat Laporan') {
                      Navigator.push(
                        context,
                        MaterialPageRoute(builder: (context) => const WastePage()),
                      );
                    } else {
                      _showMenuDialog(item['label'] as String);
                    }
                  },
                  child: Padding(
                    padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 16),
                    child: Row(
                      children: [
                        Container(
                          padding: const EdgeInsets.all(10),
                          decoration: BoxDecoration(
                            color: const Color(0xFFECFDF5),
                            borderRadius: BorderRadius.circular(12),
                          ),
                          child: Icon(item['icon'] as IconData, color: const Color(0xFF10B981), size: 20),
                        ),
                        const SizedBox(width: 14),
                        Expanded(
                          child: Text(
                            item['label'] as String,
                            style: const TextStyle(
                              fontSize: 15,
                              fontWeight: FontWeight.w600,
                              color: Color(0xFF111827),
                            ),
                          ),
                        ),
                        Icon(Icons.chevron_right, color: Colors.grey.shade400, size: 22),
                      ],
                    ),
                  ),
                ),
              ),
              if (!isLast)
                Divider(height: 1, indent: 20, endIndent: 20, color: Colors.grey.shade100),
            ],
          );
        }).toList(),
      ),
    );
  }

  Widget _buildLogoutButton() {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16),
      child: Container(
        decoration: BoxDecoration(
          gradient: const LinearGradient(
            colors: [Color(0xFFEF4444), Color(0xFFDC2626)],
          ),
          borderRadius: BorderRadius.circular(18),
          boxShadow: [
            BoxShadow(
              color: const Color(0xFFEF4444).withValues(alpha: 0.3),
              blurRadius: 12,
              offset: const Offset(0, 4),
            ),
          ],
        ),
        child: Material(
          color: Colors.transparent,
          child: InkWell(
            onTap: _showLogoutDialog,
            borderRadius: BorderRadius.circular(18),
            child: const Padding(
              padding: EdgeInsets.symmetric(vertical: 16),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  Icon(Icons.logout, color: Colors.white, size: 20),
                  SizedBox(width: 10),
                  Text(
                    'Keluar dari Akun',
                    style: TextStyle(
                      color: Colors.white,
                      fontSize: 16,
                      fontWeight: FontWeight.w700,
                    ),
                  ),
                ],
              ),
            ),
          ),
        ),
      ),
    );
  }
}