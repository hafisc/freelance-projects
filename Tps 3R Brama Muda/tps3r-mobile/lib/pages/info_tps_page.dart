import 'package:flutter/material.dart';

class InfoTpsPage extends StatelessWidget {
  const InfoTpsPage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF4FBF7),
      body: SafeArea(
        child: SingleChildScrollView(
          physics: const BouncingScrollPhysics(),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.stretch,
            children: [
              // Header Banner
              _buildHeaderBanner(),
              const SizedBox(height: 20),

              // About Section
              _buildSectionTitle('Tentang Kami', Icons.info_outline),
              _buildAboutCard(),
              const SizedBox(height: 20),

              // Visi Misi Section
              _buildSectionTitle('Visi & Misi', Icons.visibility),
              _buildVisiMisiCard(),
              const SizedBox(height: 20),

              // Tujuan TPS
              _buildSectionTitle('Tujuan TPS 3R', Icons.flag_outlined),
              _buildTujuanCard(),
              const SizedBox(height: 20),

              // Informasi Kontak
              _buildSectionTitle('Informasi Kontak', Icons.contact_phone_outlined),
              _buildKontakCard(),
              const SizedBox(height: 20),

              // Jadwal Pengangkutan
              _buildSectionTitle('Jadwal Pengangkutan', Icons.schedule_outlined),
              _buildJadwalCard(),
              const SizedBox(height: 20),

              // Jenis Sampah
              _buildSectionTitle('Jenis Sampah yang Diterima', Icons.delete_outline),
              _buildJenisSampahGrid(),
              const SizedBox(height: 32),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildHeaderBanner() {
    return Container(
      height: 220,
      margin: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(24),
        boxShadow: [
          BoxShadow(
            color: const Color(0xFF10B981).withValues(alpha: 0.2),
            blurRadius: 20,
            offset: const Offset(0, 10),
          ),
        ],
      ),
      child: ClipRRect(
        borderRadius: BorderRadius.circular(24),
        child: Stack(
          fit: StackFit.expand,
          children: [
            // Background gradient
            Container(
              decoration: const BoxDecoration(
                gradient: LinearGradient(
                  begin: Alignment.topLeft,
                  end: Alignment.bottomRight,
                  colors: [Color(0xFF10B981), Color(0xFF059669), Color(0xFF047857)],
                ),
              ),
              child: Stack(
                children: [
                  // Decorative icons
                  Positioned(
                    right: -40,
                    top: -40,
                    child: Icon(Icons.eco, size: 180, color: Colors.white.withValues(alpha: 0.1)),
                  ),
                  Positioned(
                    left: -30,
                    bottom: -30,
                    child: Icon(Icons.recycling, size: 140, color: Colors.white.withValues(alpha: 0.08)),
                  ),
                  // Pattern overlay
                  Positioned(
                    right: 30,
                    bottom: 40,
                    child: Container(
                      padding: const EdgeInsets.all(16),
                      decoration: BoxDecoration(
                        color: Colors.white.withValues(alpha: 0.1),
                        borderRadius: BorderRadius.circular(16),
                      ),
                      child: Icon(Icons.eco, color: Colors.white.withValues(alpha: 0.5), size: 40),
                    ),
                  ),
                ],
              ),
            ),
            // Overlay gradient
            Container(
              decoration: BoxDecoration(
                gradient: LinearGradient(
                  begin: Alignment.topCenter,
                  end: Alignment.bottomCenter,
                  colors: [
                    Colors.black.withValues(alpha: 0.1),
                    Colors.black.withValues(alpha: 0.3),
                  ],
                ),
              ),
            ),
            // Content
            Padding(
              padding: const EdgeInsets.all(24),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                mainAxisAlignment: MainAxisAlignment.end,
                children: [
                  Container(
                    padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
                    decoration: BoxDecoration(
                      color: Colors.white.withValues(alpha: 0.2),
                      borderRadius: BorderRadius.circular(20),
                    ),
                    child: const Row(
                      mainAxisSize: MainAxisSize.min,
                      children: [
                        Icon(Icons.verified, color: Colors.white, size: 14),
                        SizedBox(width: 4),
                        Text(
                          'TPS Resmi',
                          style: TextStyle(
                            color: Colors.white,
                            fontSize: 11,
                            fontWeight: FontWeight.w700,
                          ),
                        ),
                      ],
                    ),
                  ),
                  const SizedBox(height: 12),
                  const Text(
                    'TPS 3R Brama Muda',
                    style: TextStyle(
                      color: Colors.white,
                      fontSize: 26,
                      fontWeight: FontWeight.w900,
                      height: 1.2,
                    ),
                  ),
                  const SizedBox(height: 6),
                  Container(
                    padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                    decoration: BoxDecoration(
                      color: Colors.white.withValues(alpha: 0.15),
                      borderRadius: BorderRadius.circular(8),
                    ),
                    child: const Text(
                      'Bersama Kelola Sampah, Bersama Jaga Lingkungan',
                      style: TextStyle(
                        color: Colors.white,
                        fontSize: 12,
                        fontWeight: FontWeight.w600,
                      ),
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
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

  Widget _buildAboutCard() {
    return Container(
      margin: const EdgeInsets.symmetric(horizontal: 16),
      padding: const EdgeInsets.all(20),
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
      child: const Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            children: [
              Icon(Icons.eco, color: Color(0xFF10B981), size: 24),
              SizedBox(width: 12),
              Expanded(
                child: Text(
                  'Tentang Kami',
                  style: TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.w700,
                    color: Color(0xFF111827),
                  ),
                ),
              ),
            ],
          ),
          SizedBox(height: 12),
          Text(
            'TPS 3R Brama Muda adalah pusat pengelolaan sampah reduce, reuse, recycle yang melayani warga untuk lingkungan yang lebih bersih dan berkelanjutan.',
            style: TextStyle(
              fontSize: 14,
              color: Color(0xFF6B7280),
              height: 1.6,
            ),
          ),
          SizedBox(height: 12),
          Text(
            'Kami berkomitmen menjadikan lingkungan bebas sampah melalui edukasi dan aksi nyata untuk masyarakat yang lebih sehat dan bersih.',
            style: TextStyle(
              fontSize: 14,
              color: Color(0xFF6B7280),
              height: 1.6,
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildVisiMisiCard() {
    return Container(
      margin: const EdgeInsets.symmetric(horizontal: 16),
      padding: const EdgeInsets.all(20),
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
          // Visi
          Container(
            padding: const EdgeInsets.all(16),
            decoration: BoxDecoration(
              gradient: LinearGradient(
                colors: [
                  const Color(0xFFECFDF5),
                  const Color(0xFF10B981).withValues(alpha: 0.1),
                ],
              ),
              borderRadius: BorderRadius.circular(16),
            ),
            child: const Row(
              children: [
                Icon(Icons.visibility, color: Color(0xFF10B981), size: 24),
                SizedBox(width: 12),
                Expanded(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        'Visi',
                        style: TextStyle(
                          fontSize: 14,
                          fontWeight: FontWeight.w700,
                          color: Color(0xFF059669),
                        ),
                      ),
                      SizedBox(height: 4),
                      Text(
                        'Menjadi pusat pengelolaan sampah 3R terdepan yang mendukung masyarakat dan lingkungan hidup berkelanjutan.',
                        style: TextStyle(
                          fontSize: 13,
                          color: Color(0xFF374151),
                          height: 1.4,
                        ),
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ),
          const SizedBox(height: 16),
          // Misi
          Container(
            padding: const EdgeInsets.all(16),
            decoration: BoxDecoration(
              gradient: LinearGradient(
                colors: [
                  const Color(0xFFF3E8FF),
                  const Color(0xFF8B5CF6).withValues(alpha: 0.1),
                ],
              ),
              borderRadius: BorderRadius.circular(16),
            ),
            child: const Row(
              children: [
                Icon(Icons.track_changes, color: Color(0xFF8B5CF6), size: 24),
                SizedBox(width: 12),
                Expanded(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        'Misi',
                        style: TextStyle(
                          fontSize: 14,
                          fontWeight: FontWeight.w700,
                          color: Color(0xFF7C3AED),
                        ),
                      ),
                      SizedBox(height: 4),
                      Text(
                        'Mengurangi sampah, meningkatkan kualitas lingkungan, dan memberdayakan komunitas melalui program edukasi dan layanan TPS 3R modern.',
                        style: TextStyle(
                          fontSize: 13,
                          color: Color(0xFF374151),
                          height: 1.4,
                        ),
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildTujuanCard() {
    final tujuanList = [
      {'icon': Icons.recycling, 'text': 'Mengurangi jumlah sampah ke TPA'},
      {'icon': Icons.science, 'text': 'Meningkatkan daur ulang sampah'},
      {'icon': Icons.school, 'text': 'Edukasi warga tentang pengelolaan sampah'},
      {'icon': Icons.eco, 'text': 'Membuat lingkungan lebih bersih dan sehat'},
    ];

    return Container(
      margin: const EdgeInsets.symmetric(horizontal: 16),
      padding: const EdgeInsets.all(20),
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
        children: tujuanList.asMap().entries.map((entry) {
          final index = entry.key;
          final item = entry.value;
          final isLast = index == tujuanList.length - 1;
          return Column(
            children: [
              Row(
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
                      item['text'] as String,
                      style: const TextStyle(
                        fontSize: 14,
                        color: Color(0xFF374151),
                        height: 1.4,
                      ),
                    ),
                  ),
                ],
              ),
              if (!isLast) const SizedBox(height: 12),
            ],
          );
        }).toList(),
      ),
    );
  }

  Widget _buildKontakCard() {
    final kontakList = [
      {'icon': Icons.location_on_outlined, 'label': 'Lokasi', 'value': 'Jl. Hijau Berseri No. 7, Kota Ramah Lingkungan'},
      {'icon': Icons.access_time, 'label': 'Jam Operasional', 'value': 'Senin - Sabtu, 07.00 - 15.00 WIB'},
      {'icon': Icons.phone, 'label': 'Kontak', 'value': '+62 812-3456-7890'},
      {'icon': Icons.email_outlined, 'label': 'Email', 'value': 'info@bramamuda.id'},
    ];

    return Container(
      margin: const EdgeInsets.symmetric(horizontal: 16),
      padding: const EdgeInsets.all(20),
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
        children: kontakList.asMap().entries.map((entry) {
          final index = entry.key;
          final item = entry.value;
          final isLast = index == kontakList.length - 1;
          return Column(
            children: [
              Row(
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
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          item['label'] as String,
                          style: const TextStyle(
                            fontSize: 12,
                            fontWeight: FontWeight.w600,
                            color: Color(0xFF9CA3AF),
                          ),
                        ),
                        const SizedBox(height: 2),
                        Text(
                          item['value'] as String,
                          style: const TextStyle(
                            fontSize: 14,
                            color: Color(0xFF111827),
                            fontWeight: FontWeight.w500,
                          ),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
              if (!isLast) const SizedBox(height: 14),
            ],
          );
        }).toList(),
      ),
    );
  }

  Widget _buildJadwalCard() {
    final jadwalList = [
      {'day': 'Senin', 'type': 'Sampah Organik', 'time': '07.00 - 10.00', 'color': const Color(0xFF10B981)},
      {'day': 'Rabu', 'type': 'Sampah Anorganik', 'time': '08.00 - 11.00', 'color': const Color(0xFF3B82F6)},
      {'day': 'Sabtu', 'type': 'Sampah B3', 'time': '09.00 - 12.00', 'color': const Color(0xFF8B5CF6)},
    ];

    return Container(
      margin: const EdgeInsets.symmetric(horizontal: 16),
      padding: const EdgeInsets.all(20),
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
        children: jadwalList.asMap().entries.map((entry) {
          final index = entry.key;
          final item = entry.value;
          final isLast = index == jadwalList.length - 1;
          return Column(
            children: [
              Row(
                children: [
                  Container(
                    width: 48,
                    height: 48,
                    decoration: BoxDecoration(
                      color: (item['color'] as Color).withValues(alpha: 0.1),
                      borderRadius: BorderRadius.circular(14),
                    ),
                    child: Icon(Icons.calendar_month, color: item['color'] as Color, size: 24),
                  ),
                  const SizedBox(width: 14),
                  Expanded(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          item['day'] as String,
                          style: const TextStyle(
                            fontSize: 15,
                            fontWeight: FontWeight.w700,
                            color: Color(0xFF111827),
                          ),
                        ),
                        const SizedBox(height: 2),
                        Text(
                          item['type'] as String,
                          style: TextStyle(
                            fontSize: 13,
                            color: Colors.grey.shade600,
                          ),
                        ),
                      ],
                    ),
                  ),
                  Container(
                    padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
                    decoration: BoxDecoration(
                      color: (item['color'] as Color).withValues(alpha: 0.1),
                      borderRadius: BorderRadius.circular(20),
                    ),
                    child: Row(
                      mainAxisSize: MainAxisSize.min,
                      children: [
                        Icon(Icons.access_time, color: item['color'] as Color, size: 14),
                        const SizedBox(width: 4),
                        Text(
                          item['time'] as String,
                          style: TextStyle(
                            fontSize: 12,
                            fontWeight: FontWeight.w600,
                            color: item['color'] as Color,
                          ),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
              if (!isLast) const SizedBox(height: 12),
            ],
          );
        }).toList(),
      ),
    );
  }

  Widget _buildJenisSampahGrid() {
    final jenisSampah = [
      {
        'icon': Icons.grass,
        'label': 'Organik',
        'desc': 'Sisa makanan, sayur, buah',
        'color': const Color(0xFF10B981),
      },
      {
        'icon': Icons.local_mall,
        'label': 'Anorganik',
        'desc': 'Plastik, kertas, logam',
        'color': const Color(0xFF3B82F6),
      },
      {
        'icon': Icons.inventory_2,
        'label': 'Residu',
        'desc': 'Sampah yang tidak bisa didaur ulang',
        'color': const Color(0xFF6B7280),
      },
      {
        'icon': Icons.warning_amber,
        'label': 'B3 Rumah Tangga',
        'desc': 'Baterai, obat kadaluarsa, pestisida',
        'color': const Color(0xFFF59E0B),
      },
    ];

    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16),
      child: GridView.builder(
        shrinkWrap: true,
        physics: const NeverScrollableScrollPhysics(),
        gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
          crossAxisCount: 2,
          mainAxisSpacing: 12,
          crossAxisSpacing: 12,
          childAspectRatio: 1.1,
        ),
        itemCount: jenisSampah.length,
        itemBuilder: (context, index) {
          final item = jenisSampah[index];
          return Container(
            padding: const EdgeInsets.all(16),
            decoration: BoxDecoration(
              gradient: LinearGradient(
                begin: Alignment.topLeft,
                end: Alignment.bottomRight,
                colors: [
                  (item['color'] as Color).withValues(alpha: 0.1),
                  (item['color'] as Color).withValues(alpha: 0.05),
                ],
              ),
              borderRadius: BorderRadius.circular(20),
              border: Border.all(
                color: (item['color'] as Color).withValues(alpha: 0.2),
              ),
            ),
            child: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                Container(
                  padding: const EdgeInsets.all(12),
                  decoration: BoxDecoration(
                    color: (item['color'] as Color).withValues(alpha: 0.2),
                    shape: BoxShape.circle,
                  ),
                  child: Icon(
                    item['icon'] as IconData,
                    color: item['color'] as Color,
                    size: 28,
                  ),
                ),
                const SizedBox(height: 10),
                Text(
                  item['label'] as String,
                  style: TextStyle(
                    fontSize: 14,
                    fontWeight: FontWeight.w700,
                    color: item['color'] as Color,
                  ),
                ),
                const SizedBox(height: 4),
                Text(
                  item['desc'] as String,
                  textAlign: TextAlign.center,
                  style: TextStyle(
                    fontSize: 10,
                    color: Colors.grey.shade600,
                    height: 1.3,
                  ),
                ),
              ],
            ),
          );
        },
      ),
    );
  }
}