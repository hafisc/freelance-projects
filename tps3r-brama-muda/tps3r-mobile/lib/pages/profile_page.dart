// lib/pages/profile_page.dart

import 'package:flutter/material.dart';
import '../services/data_service.dart';
import '../models/tps_info.dart';

class ProfilePage extends StatefulWidget {
  const ProfilePage({super.key});

  @override
  State<ProfilePage> createState() => _ProfilePageState();
}

class _ProfilePageState extends State<ProfilePage> {
  // Data profil TPS
  late TpsInfo _tpsInfo;

  @override
  void initState() {
    super.initState();
    _tpsInfo = DataService.tpsInfo;
  }

  void _showEditTpsDialog() {
    final nameController = TextEditingController(text: _tpsInfo.name);
    final addressController = TextEditingController(text: _tpsInfo.address);
    final historyController = TextEditingController(text: _tpsInfo.history ?? '');
    final visionController = TextEditingController(text: _tpsInfo.vision ?? '');
    final missionController = TextEditingController(text: _tpsInfo.mission ?? '');
    final teamSizeController = TextEditingController(text: _tpsInfo.teamSize.toString());
    final dailyTonnageController = TextEditingController(text: _tpsInfo.dailyTonnage.toString());
    final recycleRateController = TextEditingController(text: _tpsInfo.recycleRate.toString());

    showDialog(
      context: context,
      builder: (context) => Dialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(24)),
        child: Container(
          constraints: const BoxConstraints(maxWidth: 500),
          child: SingleChildScrollView(
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
                      child: const Icon(Icons.edit_location_alt, color: Colors.white, size: 24),
                    ),
                    const SizedBox(width: 14),
                    const Expanded(
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Text(
                            'Edit Profil TPS',
                            style: TextStyle(
                              fontSize: 20,
                              fontWeight: FontWeight.w800,
                              color: Color(0xFF111827),
                            ),
                          ),
                          Text(
                            'Perbarui informasi TPS 3R',
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
                  label: 'Nama TPS',
                  icon: Icons.business,
                  hint: 'Masukkan nama TPS',
                ),
                const SizedBox(height: 16),

                _buildFormField(
                  controller: addressController,
                  label: 'Alamat',
                  icon: Icons.location_on_outlined,
                  hint: 'Masukkan alamat lengkap',
                  maxLines: 2,
                ),
                const SizedBox(height: 16),

                _buildFormField(
                  controller: teamSizeController,
                  label: 'Jumlah Tim Operasional',
                  icon: Icons.people_outline,
                  hint: 'Masukkan jumlah tim',
                  keyboardType: TextInputType.number,
                ),
                const SizedBox(height: 16),

                _buildFormField(
                  controller: dailyTonnageController,
                  label: 'Pengelolaan per Hari (ton)',
                  icon: Icons.scale_outlined,
                  hint: 'Masukkan jumlah ton/hari',
                  keyboardType: const TextInputType.numberWithOptions(decimal: true),
                ),
                const SizedBox(height: 16),

                _buildFormField(
                  controller: recycleRateController,
                  label: 'Tingkat Daur Ulang (%)',
                  icon: Icons.recycling,
                  hint: 'Masukkan persentase',
                  keyboardType: TextInputType.number,
                ),
                const SizedBox(height: 16),

                _buildFormField(
                  controller: historyController,
                  label: 'Sejarah',
                  icon: Icons.history_edu,
                  hint: 'Masukkan sejarah TPS',
                  maxLines: 3,
                ),
                const SizedBox(height: 16),

                _buildFormField(
                  controller: visionController,
                  label: 'Visi',
                  icon: Icons.visibility,
                  hint: 'Masukkan visi TPS',
                  maxLines: 2,
                ),
                const SizedBox(height: 16),

                _buildFormField(
                  controller: missionController,
                  label: 'Misi',
                  icon: Icons.flag_outlined,
                  hint: 'Masukkan misi TPS',
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
                          gradient: const LinearGradient(
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
                            onTap: () {
                              // Simpan perubahan
                              setState(() {
                                _tpsInfo = TpsInfo(
                                  name: nameController.text,
                                  address: addressController.text,
                                  history: historyController.text,
                                  vision: visionController.text,
                                  mission: missionController.text,
                                  teamSize: int.tryParse(teamSizeController.text) ?? _tpsInfo.teamSize,
                                  // PERBAIKAN LINE 219: Gunakan double.tryParse untuk konversi ke double
                                  dailyTonnage: double.tryParse(dailyTonnageController.text) ?? _tpsInfo.dailyTonnage,
                                  recycleRate: int.tryParse(recycleRateController.text) ?? _tpsInfo.recycleRate,
                                );
                              });
                              Navigator.pop(context);
                              _showSnackBar('Profil TPS berhasil diperbarui!');
                            },
                            borderRadius: BorderRadius.circular(14),
                            child: const Padding(
                              padding: EdgeInsets.symmetric(vertical: 14),
                              child: Text(
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
            border: Border.all(color: const Color(0xFFE5E7EB)),
          ),
          child: TextField(
            controller: controller,
            keyboardType: keyboardType,
            maxLines: maxLines,
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

  void _showSnackBar(String message) {
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Row(
          children: [
            const Icon(Icons.check_circle, color: Colors.white, size: 20),
            const SizedBox(width: 12),
            Text(message, style: const TextStyle(fontWeight: FontWeight.w600)),
          ],
        ),
        backgroundColor: const Color(0xFF10B981),
        behavior: SnackBarBehavior.floating,
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
        margin: const EdgeInsets.all(16),
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
    return Scaffold(
      backgroundColor: const Color(0xFFF4FBF7),
      body: SafeArea(
        child: SingleChildScrollView(
          padding: const EdgeInsets.symmetric(vertical: 24, horizontal: 24),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              // Header dengan Edit Button
              _buildHeader(),
              const SizedBox(height: 28),

              // Informasi TPS & Sejarah
              LayoutBuilder(
                builder: (context, constraints) {
                  final isWide = constraints.maxWidth > 600;
                  if (isWide) {
                    return Row(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Expanded(child: _buildInfoCard()),
                        const SizedBox(width: 18),
                        Expanded(child: _buildHistoryCard()),
                      ],
                    );
                  } else {
                    return Column(
                      children: [
                        _buildInfoCard(),
                        const SizedBox(height: 18),
                        _buildHistoryCard(),
                      ],
                    );
                  }
                },
              ),
              const SizedBox(height: 28),

              // Visi & Misi
              LayoutBuilder(
                builder: (context, constraints) {
                  final isWide = constraints.maxWidth > 600;
                  if (isWide) {
                    return Row(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        // PERBAIKAN LINE 436: Tambahkan ?? '' untuk handle null
                        Expanded(child: _buildFeatureBadge('Visi', _tpsInfo.vision ?? '', Icons.visibility)),
                        const SizedBox(width: 16),
                        // PERBAIKAN LINE 438: Tambahkan ?? '' untuk handle null
                        Expanded(child: _buildFeatureBadge('Misi', _tpsInfo.mission ?? '', Icons.flag_outlined)),
                      ],
                    );
                  } else {
                    return Column(
                      children: [
                        // PERBAIKAN LINE 444: Tambahkan ?? '' untuk handle null
                        _buildFeatureBadge('Visi', _tpsInfo.vision ?? '', Icons.visibility),
                        const SizedBox(height: 16),
                        // PERBAIKAN LINE 446: Tambahkan ?? '' untuk handle null
                        _buildFeatureBadge('Misi', _tpsInfo.mission ?? '', Icons.flag_outlined),
                      ],
                    );
                  }
                },
              ),
              const SizedBox(height: 28),

              // Statistik Sampah
              _buildStatCard(),
              const SizedBox(height: 28),

              // Menu Aksi
              _buildMenuSection(),
              const SizedBox(height: 32),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildHeader() {
    return Row(
      children: [
        Expanded(
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                _tpsInfo.name,
                style: const TextStyle(
                  fontSize: 28,
                  fontWeight: FontWeight.w800,
                  color: Color(0xFF111827),
                ),
              ),
              const SizedBox(height: 8),
              const Text(
                'Kelola informasi dan data operasional TPS 3R',
                style: TextStyle(
                  fontSize: 14,
                  color: Color(0xFF6B7280),
                ),
              ),
            ],
          ),
        ),
        const SizedBox(width: 16),
        // Tombol Edit
        Container(
          decoration: BoxDecoration(
            gradient: const LinearGradient(
              colors: [Color(0xFF10B981), Color(0xFF059669)],
            ),
            borderRadius: BorderRadius.circular(14),
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
              onTap: _showEditTpsDialog,
              borderRadius: BorderRadius.circular(14),
              child: const Padding(
                padding: EdgeInsets.symmetric(horizontal: 20, vertical: 12),
                child: Row(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    Icon(Icons.edit_outlined, color: Colors.white, size: 18),
                    SizedBox(width: 8),
                    Text(
                      'Edit TPS',
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
      ],
    );
  }

  Widget _buildInfoCard() {
    return Container(
      padding: const EdgeInsets.all(24),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(24),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withValues(alpha: 0.04),
            blurRadius: 24,
            offset: const Offset(0, 14),
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
                  color: const Color(0xFFECFDF5),
                  borderRadius: BorderRadius.circular(12),
                ),
                child: const Icon(Icons.info_outline, color: Color(0xFF10B981), size: 22),
              ),
              const SizedBox(width: 12),
              const Text(
                'Informasi TPS',
                style: TextStyle(
                  fontSize: 18,
                  fontWeight: FontWeight.w700,
                  color: Color(0xFF111827),
                ),
              ),
            ],
          ),
          const SizedBox(height: 20),
          _buildInfoRow('Nama', _tpsInfo.name),
          _buildInfoRow('Alamat', _tpsInfo.address),
          _buildInfoRow('Tim Operasional', '${_tpsInfo.teamSize} orang'),
          _buildInfoRow('Pengelolaan per hari', '${_tpsInfo.dailyTonnage.toStringAsFixed(1)} ton'),
          _buildInfoRow('Tingkat daur ulang', '${_tpsInfo.recycleRate}%'),
        ],
      ),
    );
  }

  Widget _buildInfoRow(String label, String value) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 14),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          SizedBox(
            width: 140,
            child: Text(
              '$label:',
              style: const TextStyle(
                fontSize: 14,
                fontWeight: FontWeight.w600,
                color: Color(0xFF6B7280),
              ),
            ),
          ),
          Expanded(
            child: Text(
              value,
              style: const TextStyle(
                fontSize: 14,
                color: Color(0xFF111827),
                height: 1.5,
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildHistoryCard() {
    return Container(
      padding: const EdgeInsets.all(24),
      decoration: BoxDecoration(
        color: const Color(0xFFECFDF5),
        borderRadius: BorderRadius.circular(24),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withValues(alpha: 0.04),
            blurRadius: 24,
            offset: const Offset(0, 14),
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
                  color: Colors.white,
                  borderRadius: BorderRadius.circular(12),
                ),
                child: const Icon(Icons.history_edu, color: Color(0xFF10B981), size: 22),
              ),
              const SizedBox(width: 12),
              const Text(
                'Sejarah TPS',
                style: TextStyle(
                  fontSize: 18,
                  fontWeight: FontWeight.w700,
                  color: Color(0xFF10B981),
                ),
              ),
            ],
          ),
          const SizedBox(height: 18),
          // Gambar TPS (placeholder)
          Container(
            height: 180,
            decoration: BoxDecoration(
              color: const Color(0xFF10B981),
              borderRadius: BorderRadius.circular(20),
            ),
            child: const Center(
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  Icon(Icons.factory, color: Colors.white, size: 60),
                  SizedBox(height: 8),
                  Text(
                    'TPS 3R Brama Muda',
                    style: TextStyle(
                      color: Colors.white,
                      fontSize: 14,
                      fontWeight: FontWeight.w600,
                    ),
                  ),
                ],
              ),
            ),
          ),
          const SizedBox(height: 18),
          // PERBAIKAN LINE 687: Tambahkan ?? '' untuk handle null
          Text(
            _tpsInfo.history ?? '',
            style: const TextStyle(
              fontSize: 14,
              color: Color(0xFF374151),
              height: 1.6,
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildFeatureBadge(String title, String description, IconData icon) {
    return Container(
      padding: const EdgeInsets.all(22),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(24),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withValues(alpha: 0.04),
            blurRadius: 20,
            offset: const Offset(0, 12),
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
                child: Icon(icon, color: const Color(0xFF10B981), size: 20),
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
          const SizedBox(height: 14),
          Text(
            description,
            style: const TextStyle(
              fontSize: 14,
              color: Color(0xFF374151),
              height: 1.6,
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildStatCard() {
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(24),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(24),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withValues(alpha: 0.04),
            blurRadius: 24,
            offset: const Offset(0, 14),
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
                  color: const Color(0xFFECFDF5),
                  borderRadius: BorderRadius.circular(12),
                ),
                child: const Icon(Icons.bar_chart, color: Color(0xFF10B981), size: 22),
              ),
              const SizedBox(width: 12),
              const Text(
                'Statistik Sampah',
                style: TextStyle(
                  fontSize: 18,
                  fontWeight: FontWeight.w700,
                  color: Color(0xFF111827),
                ),
              ),
            ],
          ),
          const SizedBox(height: 20),
          LayoutBuilder(
            builder: (context, constraints) {
              final isWide = constraints.maxWidth > 400;
              if (isWide) {
                return Row(
                  children: [
                    Expanded(child: _buildStatItem('Recycled', '${DataService.statisticData['Daur Ulang']?.toInt() ?? 0}%', Icons.recycling)),
                    const SizedBox(width: 12),
                    Expanded(child: _buildStatItem('Organik', '${DataService.statisticData['Organik']?.toInt() ?? 0} kg/hari', Icons.eco)),
                    const SizedBox(width: 12),
                    Expanded(child: _buildStatItem('Anorganik', '${DataService.statisticData['Anorganik']?.toInt() ?? 0} kg/hari', Icons.delete_outline)),
                  ],
                );
              } else {
                return Column(
                  children: [
                    Row(
                      children: [
                        Expanded(child: _buildStatItem('Recycled', '${DataService.statisticData['Daur Ulang']?.toInt() ?? 0}%', Icons.recycling)),
                        const SizedBox(width: 12),
                        Expanded(child: _buildStatItem('Organik', '${DataService.statisticData['Organik']?.toInt() ?? 0} kg/hari', Icons.eco)),
                      ],
                    ),
                    const SizedBox(height: 12),
                    _buildStatItem('Anorganik', '${DataService.statisticData['Anorganik']?.toInt() ?? 0} kg/hari', Icons.delete_outline),
                  ],
                );
              }
            },
          ),
        ],
      ),
    );
  }

  Widget _buildStatItem(String label, String value, IconData icon) {
    return Container(
      padding: const EdgeInsets.symmetric(vertical: 20, horizontal: 18),
      decoration: BoxDecoration(
        color: const Color(0xFFF0FDF4),
        borderRadius: BorderRadius.circular(20),
      ),
      child: Row(
        children: [
          Container(
            padding: const EdgeInsets.all(10),
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(12),
            ),
            child: Icon(icon, color: const Color(0xFF10B981), size: 22),
          ),
          const SizedBox(width: 14),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  label,
                  style: const TextStyle(
                    fontSize: 12,
                    color: Color(0xFF6B7280),
                    fontWeight: FontWeight.w600,
                  ),
                ),
                const SizedBox(height: 4),
                Text(
                  value,
                  style: const TextStyle(
                    fontSize: 18,
                    fontWeight: FontWeight.bold,
                    color: Color(0xFF111827),
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildMenuSection() {
    final menuItems = [
      {'icon': Icons.people_outline, 'label': 'Kelola Tim Operasional'},
      {'icon': Icons.calendar_today_outlined, 'label': 'Jadwal Operasional'},
      {'icon': Icons.notifications_outlined, 'label': 'Notifikasi'},
      {'icon': Icons.settings_outlined, 'label': 'Pengaturan TPS'},
      {'icon': Icons.help_outline, 'label': 'Bantuan'},
    ];

    return Container(
      padding: const EdgeInsets.all(24),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(24),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withValues(alpha: 0.04),
            blurRadius: 24,
            offset: const Offset(0, 14),
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
                  color: const Color(0xFFECFDF5),
                  borderRadius: BorderRadius.circular(12),
                ),
                child: const Icon(Icons.menu, color: Color(0xFF10B981), size: 22),
              ),
              const SizedBox(width: 12),
              const Text(
                'Menu Aksi',
                style: TextStyle(
                  fontSize: 18,
                  fontWeight: FontWeight.w700,
                  color: Color(0xFF111827),
                ),
              ),
            ],
          ),
          const SizedBox(height: 16),
          ...menuItems.asMap().entries.map((entry) {
            final index = entry.key;
            final item = entry.value;
            final isLast = index == menuItems.length - 1;
            return Column(
              children: [
                Material(
                  color: Colors.transparent,
                  child: InkWell(
                    onTap: () => _showMenuDialog(item['label'] as String),
                    borderRadius: BorderRadius.circular(16),
                    child: Padding(
                      padding: const EdgeInsets.symmetric(vertical: 14),
                      child: Row(
                        children: [
                          Container(
                            padding: const EdgeInsets.all(10),
                            decoration: BoxDecoration(
                              color: const Color(0xFFF0FDF4),
                              borderRadius: BorderRadius.circular(12),
                            ),
                            child: Icon(item['icon'] as IconData, color: const Color(0xFF10B981), size: 22),
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
                          const Icon(Icons.chevron_right, color: Color(0xFF9CA3AF), size: 22),
                        ],
                      ),
                    ),
                  ),
                ),
                if (!isLast)
                  Divider(height: 1, color: Colors.grey.shade100),
              ],
            );
          }),
        ],
      ),
    );
  }
}
