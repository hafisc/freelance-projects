import 'package:flutter/material.dart';
import '../../services/app_state.dart';

class ActivitySection extends StatelessWidget {
  final AppState appState;

  const ActivitySection({
    super.key,
    required this.appState,
  });

  @override
  Widget build(BuildContext context) {
    // Sample activities (can be replaced with real data from appState)
    final activities = _getSampleActivities();

    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(20),
        boxShadow: [
          BoxShadow(
            color: const Color(0xFF10B981).withValues(alpha: 0.08),
            blurRadius: 16,
            offset: const Offset(0, 6),
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // Header
          _buildHeader(activities.length),
          const SizedBox(height: 16),

          // Activity list
          ...activities.asMap().entries.map((entry) {
            final index = entry.key;
            final activity = entry.value;
            return Column(
              children: [
                _ActivityCard(
                  icon: activity['icon'] as IconData,
                  title: activity['title'] as String,
                  time: activity['time'] as String,
                  type: activity['type'] as String,
                  color: activity['color'] as Color,
                  bgColor: activity['bgColor'] as Color,
                ),
                if (index < activities.length - 1) ...[
                  const SizedBox(height: 10),
                  Divider(color: Colors.grey.shade100, height: 1),
                  const SizedBox(height: 10),
                ],
              ],
            );
          }),
        ],
      ),
    );
  }

  Widget _buildHeader(int count) {
    return Row(
      children: [
        Container(
          padding: const EdgeInsets.all(10),
          decoration: BoxDecoration(
            color: const Color(0xFFECFDF5),
            borderRadius: BorderRadius.circular(12),
          ),
          child: const Icon(Icons.history, color: Color(0xFF059669), size: 20),
        ),
        const SizedBox(width: 12),
        const Expanded(
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                'Aktivitas Terbaru',
                style: TextStyle(
                  fontSize: 16,
                  fontWeight: FontWeight.w700,
                  color: Color(0xFF111827),
                ),
              ),
              Text(
                'Aktivitas Anda di TPS 3R',
                style: TextStyle(
                  fontSize: 12,
                  color: Color(0xFF6B7280),
                ),
              ),
            ],
          ),
        ),
        Container(
          padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
          decoration: BoxDecoration(
            color: const Color(0xFF10B981).withValues(alpha: 0.1),
            borderRadius: BorderRadius.circular(20),
          ),
          child: Text(
            '$count Aktivitas',
            style: const TextStyle(
              color: Color(0xFF059669),
              fontSize: 11,
              fontWeight: FontWeight.w600,
            ),
          ),
        ),
      ],
    );
  }

  List<Map<String, dynamic>> _getSampleActivities() {
    final now = DateTime.now();
    return [
      {
        'icon': Icons.check_circle,
        'title': 'Pembayaran Iuran Bulanan',
        'time': _formatRelativeTime(now.subtract(const Duration(hours: 2)), now),
        'type': 'Berhasil',
        'color': const Color(0xFF10B981),
        'bgColor': const Color(0xFFECFDF5),
      },
      {
        'icon': Icons.local_shipping,
        'title': 'Sampah Diangkut',
        'time': _formatRelativeTime(now.subtract(const Duration(hours: 5)), now),
        'type': 'Selesai',
        'color': const Color(0xFF3B82F6),
        'bgColor': const Color(0xFFEFF6FF),
      },
      {
        'icon': Icons.calendar_today,
        'title': 'Jadwal Diperbarui',
        'time': _formatRelativeTime(now.subtract(const Duration(days: 1)), now),
        'type': 'Info',
        'color': const Color(0xFFF59E0B),
        'bgColor': const Color(0xFFFEF3C7),
      },
      {
        'icon': Icons.recycling,
        'title': 'Sampah Olahan - 8.5 kg',
        'time': _formatRelativeTime(now.subtract(const Duration(days: 2)), now),
        'type': 'Proses',
        'color': const Color(0xFF8B5CF6),
        'bgColor': const Color(0xFFF3E8FF),
      },
    ];
  }

  String _formatRelativeTime(DateTime dateTime, DateTime now) {
    final duration = now.difference(dateTime);
    if (duration.inMinutes < 60) {
      return '${duration.inMinutes} menit lalu';
    } else if (duration.inHours < 24) {
      return '${duration.inHours} jam lalu';
    } else if (duration.inDays < 7) {
      return '${duration.inDays} hari lalu';
    } else {
      return '${duration.inDays ~/ 7} minggu lalu';
    }
  }
}

class _ActivityCard extends StatelessWidget {
  final IconData icon;
  final String title;
  final String time;
  final String type;
  final Color color;
  final Color bgColor;

  const _ActivityCard({
    required this.icon,
    required this.title,
    required this.time,
    required this.type,
    required this.color,
    required this.bgColor,
  });

  @override
  Widget build(BuildContext context) {
    return Row(
      children: [
        // Icon container
        Container(
          width: 44,
          height: 44,
          decoration: BoxDecoration(
            color: bgColor,
            borderRadius: BorderRadius.circular(12),
          ),
          child: Icon(icon, color: color, size: 22),
        ),
        const SizedBox(width: 14),
        // Content
        Expanded(
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                title,
                style: const TextStyle(
                  fontSize: 14,
                  fontWeight: FontWeight.w600,
                  color: Color(0xFF111827),
                ),
              ),
              const SizedBox(height: 4),
              Text(
                time,
                style: const TextStyle(
                  fontSize: 12,
                  color: Color(0xFF9CA3AF),
                ),
              ),
            ],
          ),
        ),
        // Status badge
        Container(
          padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 6),
          decoration: BoxDecoration(
            color: bgColor,
            borderRadius: BorderRadius.circular(10),
          ),
          child: Text(
            type,
            style: TextStyle(
              fontSize: 11,
              fontWeight: FontWeight.w600,
              color: color,
            ),
          ),
        ),
      ],
    );
  }
}

// Alternative version with real waste items from appState
class RecentWasteActivities extends StatelessWidget {
  final AppState appState;

  const RecentWasteActivities({
    super.key,
    required this.appState,
  });

  @override
  Widget build(BuildContext context) {
    final recentWaste = appState.wasteItems.take(4).toList();

    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(20),
        boxShadow: [
          BoxShadow(
            color: const Color(0xFF10B981).withValues(alpha: 0.08),
            blurRadius: 16,
            offset: const Offset(0, 6),
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // Header
          Row(
            children: [
              Container(
                padding: const EdgeInsets.all(10),
                decoration: BoxDecoration(
                  color: const Color(0xFFECFDF5),
                  borderRadius: BorderRadius.circular(12),
                ),
                child: const Icon(Icons.inventory_2, color: Color(0xFF059669), size: 20),
              ),
              const SizedBox(width: 12),
              const Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      'Input Sampah Terbaru',
                      style: TextStyle(
                        fontSize: 16,
                        fontWeight: FontWeight.w700,
                        color: Color(0xFF111827),
                      ),
                    ),
                    Text(
                      'Data sampah yang telah diinput',
                      style: TextStyle(
                        fontSize: 12,
                        color: Color(0xFF6B7280),
                      ),
                    ),
                  ],
                ),
              ),
              Container(
                padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                decoration: BoxDecoration(
                  color: const Color(0xFF3B82F6).withValues(alpha: 0.1),
                  borderRadius: BorderRadius.circular(20),
                ),
                child: Text(
                  '${recentWaste.length} Item',
                  style: const TextStyle(
                    color: Color(0xFF3B82F6),
                    fontSize: 11,
                    fontWeight: FontWeight.w600,
                  ),
                ),
              ),
            ],
          ),
          const SizedBox(height: 16),

          // Empty state
          if (recentWaste.isEmpty)
            Center(
              child: Padding(
                padding: const EdgeInsets.all(24),
                child: Column(
                  children: [
                    Icon(Icons.inbox, size: 48, color: Colors.grey.shade300),
                    const SizedBox(height: 12),
                    const Text(
                      'Belum ada data sampah',
                      style: TextStyle(color: Color(0xFF9CA3AF)),
                    ),
                  ],
                ),
              ),
            )
          // Waste items list
          else
            ...recentWaste.asMap().entries.map((entry) {
              final index = entry.key;
              final item = entry.value;
              return Column(
                children: [
                  _WasteActivityItem(
                    icon: _getCategoryIcon(item.category),
                    title: item.type,
                    subtitle: '${item.weight.toStringAsFixed(1)} kg • ${_formatDate(item.date)}',
                    status: _getStatusLabel(item.status),
                    color: _getCategoryColor(item.category),
                    bgColor: _getCategoryBgColor(item.category),
                  ),
                  if (index < recentWaste.length - 1) ...[
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

  IconData _getCategoryIcon(dynamic category) {
    switch (category.toString()) {
      case 'WasteCategory.organic':
        return Icons.grass;
      case 'WasteCategory.inorganic':
        return Icons.flash_on;
      case 'WasteCategory.recycle':
        return Icons.recycling;
      default:
        return Icons.delete_outline;
    }
  }

  Color _getCategoryColor(dynamic category) {
    switch (category.toString()) {
      case 'WasteCategory.organic':
        return const Color(0xFF10B981);
      case 'WasteCategory.inorganic':
        return const Color(0xFF3B82F6);
      case 'WasteCategory.recycle':
        return const Color(0xFFF59E0B);
      default:
        return const Color(0xFF6B7280);
    }
  }

  Color _getCategoryBgColor(dynamic category) {
    switch (category.toString()) {
      case 'WasteCategory.organic':
        return const Color(0xFFECFDF5);
      case 'WasteCategory.inorganic':
        return const Color(0xFFEFF6FF);
      case 'WasteCategory.recycle':
        return const Color(0xFFFEF3C7);
      default:
        return const Color(0xFFF3F4F6);
    }
  }

  String _getStatusLabel(dynamic status) {
    switch (status.toString()) {
      case 'WasteStatus.pending':
        return 'Pending';
      case 'WasteStatus.processing':
        return 'Diproses';
      case 'WasteStatus.recycled':
        return 'Selesai';
      default:
        return 'Unknown';
    }
  }

  String _formatDate(DateTime date) {
    final months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    return '${date.day} ${months[date.month - 1]}';
  }
}

class _WasteActivityItem extends StatelessWidget {
  final IconData icon;
  final String title;
  final String subtitle;
  final String status;
  final Color color;
  final Color bgColor;

  const _WasteActivityItem({
    required this.icon,
    required this.title,
    required this.subtitle,
    required this.status,
    required this.color,
    required this.bgColor,
  });

  @override
  Widget build(BuildContext context) {
    return Row(
      children: [
        // Icon container
        Container(
          width: 44,
          height: 44,
          decoration: BoxDecoration(
            color: bgColor,
            borderRadius: BorderRadius.circular(12),
          ),
          child: Icon(icon, color: color, size: 22),
        ),
        const SizedBox(width: 14),
        // Content
        Expanded(
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                title,
                style: const TextStyle(
                  fontSize: 14,
                  fontWeight: FontWeight.w600,
                  color: Color(0xFF111827),
                ),
              ),
              const SizedBox(height: 4),
              Text(
                subtitle,
                style: const TextStyle(
                  fontSize: 12,
                  color: Color(0xFF6B7280),
                ),
              ),
            ],
          ),
        ),
        // Status badge
        Container(
          padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 6),
          decoration: BoxDecoration(
            color: bgColor,
            borderRadius: BorderRadius.circular(10),
          ),
          child: Text(
            status,
            style: TextStyle(
              fontSize: 11,
              fontWeight: FontWeight.w600,
              color: color,
            ),
          ),
        ),
      ],
    );
  }
}