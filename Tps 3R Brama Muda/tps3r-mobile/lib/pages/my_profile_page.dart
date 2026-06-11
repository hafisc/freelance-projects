import 'package:flutter/material.dart';

import '../services/auth_service.dart';
import '../services/profile_service.dart';

class MyProfilePage extends StatefulWidget {
  const MyProfilePage({super.key});

  @override
  State<MyProfilePage> createState() => _MyProfilePageState();
}

class _MyProfilePageState extends State<MyProfilePage> {
  bool _isLoading = true;
  bool _isSaving = false;
  Map<String, dynamic>? _profile;
  String? _errorMessage;

  @override
  void initState() {
    super.initState();
    _loadProfile();
  }

  Future<void> _loadProfile() async {
    setState(() {
      _isLoading = true;
      _errorMessage = null;
    });

    final profile = await AuthService.getProfile();
    if (!mounted) return;

    setState(() {
      _profile = profile;
      _isLoading = false;
      _errorMessage = profile == null ? 'Profil tidak ditemukan.' : null;
    });
  }

  Future<void> _logout() async {
    await AuthService.logoutUser();
    if (!mounted) return;
    Navigator.of(context).pushReplacementNamed('/landing');
  }

  void _showEditDialog() {
    final nameController = TextEditingController(
      text: _profile?['name']?.toString() ?? '',
    );
    final phoneController = TextEditingController(
      text: _profile?['phone']?.toString() ?? '',
    );

    showDialog(
      context: context,
      builder: (dialogContext) => AlertDialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(20)),
        title: const Text('Edit Profil'),
        content: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            TextField(
              controller: nameController,
              decoration: const InputDecoration(
                labelText: 'Nama Lengkap',
                prefixIcon: Icon(Icons.person_outline),
                border: OutlineInputBorder(),
              ),
            ),
            const SizedBox(height: 12),
            TextField(
              controller: phoneController,
              keyboardType: TextInputType.phone,
              decoration: const InputDecoration(
                labelText: 'Nomor HP',
                prefixIcon: Icon(Icons.phone_outlined),
                border: OutlineInputBorder(),
              ),
            ),
          ],
        ),
        actions: [
          TextButton(
            onPressed: _isSaving ? null : () => Navigator.pop(dialogContext),
            child: const Text('Batal'),
          ),
          ElevatedButton(
            onPressed: _isSaving
                ? null
                : () async {
                    setState(() => _isSaving = true);
                    final result = await ProfileService.updateUserProfile(
                      name: nameController.text,
                      phone: phoneController.text,
                    );
                    setState(() => _isSaving = false);

                    if (!mounted) return;
                    Navigator.pop(dialogContext);
                    ScaffoldMessenger.of(context).showSnackBar(
                      SnackBar(
                        content: Text(result['message']?.toString() ??
                            'Profil berhasil diperbarui.'),
                        backgroundColor: result['success'] == true
                            ? const Color(0xFF10B981)
                            : const Color(0xFFEF4444),
                      ),
                    );
                    if (result['success'] == true) {
                      await _loadProfile();
                    }
                  },
            style: ElevatedButton.styleFrom(
              backgroundColor: const Color(0xFF10B981),
              foregroundColor: Colors.white,
            ),
            child: Text(_isSaving ? 'Menyimpan...' : 'Simpan'),
          ),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    if (_isLoading) {
      return const Scaffold(
        backgroundColor: Color(0xFFF0FDF4),
        body: Center(
          child: CircularProgressIndicator(color: Color(0xFF10B981)),
        ),
      );
    }

    if (_errorMessage != null) {
      return Scaffold(
        backgroundColor: const Color(0xFFF0FDF4),
        body: Center(
          child: Padding(
            padding: const EdgeInsets.all(24),
            child: Column(
              mainAxisSize: MainAxisSize.min,
              children: [
                const Icon(Icons.error_outline, color: Color(0xFFEF4444), size: 46),
                const SizedBox(height: 12),
                Text(
                  _errorMessage!,
                  textAlign: TextAlign.center,
                  style: const TextStyle(color: Color(0xFF6B7280)),
                ),
                const SizedBox(height: 18),
                ElevatedButton.icon(
                  onPressed: _loadProfile,
                  icon: const Icon(Icons.refresh),
                  label: const Text('Coba Lagi'),
                ),
              ],
            ),
          ),
        ),
      );
    }

    final profile = _profile!;
    final name = profile['name']?.toString() ?? 'Member';
    final email = profile['email']?.toString() ?? '-';
    final phone = profile['phone']?.toString();
    final role = profile['role']?.toString() ?? 'member';
    final status = profile['status']?.toString() ?? 'active';
    final joinedAt = _formatDate(profile['created_at']);

    return Scaffold(
      backgroundColor: const Color(0xFFF0FDF4),
      body: SafeArea(
        child: RefreshIndicator(
          color: const Color(0xFF10B981),
          onRefresh: _loadProfile,
          child: SingleChildScrollView(
            physics: const AlwaysScrollableScrollPhysics(),
            padding: const EdgeInsets.all(16),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.stretch,
              children: [
                _ProfileHeader(name: name, role: role, status: status),
                const SizedBox(height: 16),
                _InfoCard(
                  rows: [
                    _InfoRow(Icons.person_outline, 'Nama Lengkap', name),
                    _InfoRow(Icons.email_outlined, 'Email', email),
                    _InfoRow(
                      Icons.phone_outlined,
                      'Nomor HP',
                      phone == null || phone.isEmpty ? 'Belum diisi' : phone,
                    ),
                    _InfoRow(Icons.verified_user_outlined, 'Status', _statusLabel(status)),
                    _InfoRow(Icons.calendar_today_outlined, 'Tanggal Bergabung', joinedAt),
                  ],
                ),
                const SizedBox(height: 16),
                ElevatedButton.icon(
                  onPressed: _showEditDialog,
                  icon: const Icon(Icons.edit_outlined),
                  label: const Text('Edit Profil'),
                  style: ElevatedButton.styleFrom(
                    backgroundColor: const Color(0xFF10B981),
                    foregroundColor: Colors.white,
                    padding: const EdgeInsets.symmetric(vertical: 14),
                    shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(14),
                    ),
                  ),
                ),
                const SizedBox(height: 10),
                OutlinedButton.icon(
                  onPressed: _logout,
                  icon: const Icon(Icons.logout),
                  label: const Text('Keluar dari Akun'),
                  style: OutlinedButton.styleFrom(
                    foregroundColor: const Color(0xFFDC2626),
                    side: const BorderSide(color: Color(0xFFFCA5A5)),
                    padding: const EdgeInsets.symmetric(vertical: 14),
                    shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(14),
                    ),
                  ),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }

  String _statusLabel(String status) {
    return status == 'active' ? 'Member Aktif' : 'Tidak Aktif';
  }

  String _formatDate(dynamic value) {
    final date = value is String ? DateTime.tryParse(value) : null;
    if (date == null) return '-';

    const months = [
      'Jan',
      'Feb',
      'Mar',
      'Apr',
      'Mei',
      'Jun',
      'Jul',
      'Agu',
      'Sep',
      'Okt',
      'Nov',
      'Des',
    ];
    return '${date.day} ${months[date.month - 1]} ${date.year}';
  }
}

class _ProfileHeader extends StatelessWidget {
  final String name;
  final String role;
  final String status;

  const _ProfileHeader({
    required this.name,
    required this.role,
    required this.status,
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(22),
      decoration: BoxDecoration(
        gradient: const LinearGradient(
          colors: [Color(0xFF10B981), Color(0xFF059669)],
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
        ),
        borderRadius: BorderRadius.circular(22),
        boxShadow: [
          BoxShadow(
            color: const Color(0xFF10B981).withValues(alpha: 0.25),
            blurRadius: 18,
            offset: const Offset(0, 8),
          ),
        ],
      ),
      child: Column(
        children: [
          Container(
            width: 84,
            height: 84,
            decoration: BoxDecoration(
              color: Colors.white.withValues(alpha: 0.2),
              shape: BoxShape.circle,
              border: Border.all(color: Colors.white.withValues(alpha: 0.4), width: 2),
            ),
            child: const Icon(Icons.person, color: Colors.white, size: 44),
          ),
          const SizedBox(height: 14),
          Text(
            name,
            textAlign: TextAlign.center,
            maxLines: 2,
            overflow: TextOverflow.ellipsis,
            style: const TextStyle(
              color: Colors.white,
              fontSize: 22,
              fontWeight: FontWeight.w800,
            ),
          ),
          const SizedBox(height: 8),
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
            decoration: BoxDecoration(
              color: Colors.white.withValues(alpha: 0.2),
              borderRadius: BorderRadius.circular(999),
            ),
            child: Text(
              status == 'active' ? 'Member Aktif' : role,
              style: const TextStyle(
                color: Colors.white,
                fontSize: 12,
                fontWeight: FontWeight.w700,
              ),
            ),
          ),
        ],
      ),
    );
  }
}

class _InfoCard extends StatelessWidget {
  final List<_InfoRow> rows;

  const _InfoCard({required this.rows});

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(18),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(18),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withValues(alpha: 0.04),
            blurRadius: 14,
            offset: const Offset(0, 5),
          ),
        ],
      ),
      child: Column(
        children: rows
            .map(
              (row) => Padding(
                padding: const EdgeInsets.symmetric(vertical: 8),
                child: row,
              ),
            )
            .toList(),
      ),
    );
  }
}

class _InfoRow extends StatelessWidget {
  final IconData icon;
  final String label;
  final String value;

  const _InfoRow(this.icon, this.label, this.value);

  @override
  Widget build(BuildContext context) {
    return Row(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Container(
          padding: const EdgeInsets.all(9),
          decoration: BoxDecoration(
            color: const Color(0xFFECFDF5),
            borderRadius: BorderRadius.circular(10),
          ),
          child: Icon(icon, color: const Color(0xFF059669), size: 19),
        ),
        const SizedBox(width: 12),
        Expanded(
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                label,
                style: const TextStyle(
                  color: Color(0xFF6B7280),
                  fontSize: 12,
                  fontWeight: FontWeight.w600,
                ),
              ),
              const SizedBox(height: 3),
              Text(
                value,
                style: const TextStyle(
                  color: Color(0xFF111827),
                  fontSize: 14,
                  fontWeight: FontWeight.w700,
                ),
                maxLines: 3,
                overflow: TextOverflow.ellipsis,
              ),
            ],
          ),
        ),
      ],
    );
  }
}
