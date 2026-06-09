// lib/widgets/member/recycle_progress.dart
import 'package:flutter/material.dart';
import '../../services/app_state.dart';

class RecycleProgress extends StatelessWidget {
  final AppState appState;

  const RecycleProgress({
    super.key,
    required this.appState,
  });

  @override
  Widget build(BuildContext context) {
    // PERBAIKAN: Gunakan ?. dan ?? untuk handle null pada tpsInfo
    final recycleRate = appState.tpsInfo?.recycleRate ?? 0;
    final organic = appState.wasteStatistics['organic'] ?? 0.0;
    final recycle = appState.wasteStatistics['recycle'] ?? 0.0;
    final inorganic = appState.wasteStatistics['inorganic'] ?? 0.0;
    final total = organic + recycle + inorganic;

    // Calculate weekly data (last 7 days)
    final now = DateTime.now();
    final weekItems = appState.wasteItems.where((item) {
      final diff = now.difference(item.date).inDays;
      return diff >= 0 && diff < 7;
    }).toList();
    final weeklyWeight = weekItems.fold<double>(0, (sum, item) => sum + item.weight);

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
          _buildHeader(recycleRate),
          const SizedBox(height: 20),

          // Weekly summary
          _buildWeeklySummary(weeklyWeight),
          const SizedBox(height: 20),

          // Progress bar
          _buildProgressBar(recycleRate),
          const SizedBox(height: 20),

          // Category breakdown
          _buildCategoryBreakdown(organic, recycle, inorganic, total),
        ],
      ),
    );
  }

  Widget _buildHeader(int recycleRate) {
    return Row(
      children: [
        Container(
          padding: const EdgeInsets.all(10),
          decoration: BoxDecoration(
            color: const Color(0xFFECFDF5),
            borderRadius: BorderRadius.circular(12),
          ),
          child: const Icon(Icons.recycling, color: Color(0xFF059669), size: 20),
        ),
        const SizedBox(width: 12),
        const Expanded(
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                'Progress Daur Ulang',
                style: TextStyle(
                  fontSize: 16,
                  fontWeight: FontWeight.w700,
                  color: Color(0xFF111827),
                ),
              ),
              Text(
                'Mingguan',
                style: TextStyle(
                  fontSize: 12,
                  color: Color(0xFF6B7280),
                ),
              ),
            ],
          ),
        ),
        Container(
          padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
          decoration: BoxDecoration(
            color: const Color(0xFF10B981).withValues(alpha: 0.1),
            borderRadius: BorderRadius.circular(20),
          ),
          child: Row(
            mainAxisSize: MainAxisSize.min,
            children: [
              const Icon(Icons.emoji_events, color: Color(0xFF059669), size: 14),
              const SizedBox(width: 4),
              Text(
                '$recycleRate% Target',
                style: const TextStyle(
                  color: Color(0xFF059669),
                  fontSize: 12,
                  fontWeight: FontWeight.w600,
                ),
              ),
            ],
          ),
        ),
      ],
    );
  }

  Widget _buildWeeklySummary(double weeklyWeight) {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        gradient: LinearGradient(
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
          colors: [
            const Color(0xFF10B981).withValues(alpha: 0.1),
            const Color(0xFF059669).withValues(alpha: 0.05),
          ],
        ),
        borderRadius: BorderRadius.circular(16),
        border: Border.all(
          color: const Color(0xFF10B981).withValues(alpha: 0.2),
        ),
      ),
      child: Row(
        children: [
          Container(
            padding: const EdgeInsets.all(12),
            decoration: BoxDecoration(
              color: const Color(0xFF10B981).withValues(alpha: 0.15),
              borderRadius: BorderRadius.circular(12),
            ),
            child: const Icon(Icons.calendar_view_week, color: Color(0xFF10B981), size: 24),
          ),
          const SizedBox(width: 14),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                const Text(
                  'Total Minggu Ini',
                  style: TextStyle(
                    fontSize: 12,
                    color: Color(0xFF6B7280),
                  ),
                ),
                const SizedBox(height: 4),
                Text(
                  '${weeklyWeight.toStringAsFixed(1)} kg',
                  style: const TextStyle(
                    fontSize: 22,
                    fontWeight: FontWeight.w800,
                    color: Color(0xFF10B981),
                  ),
                ),
              ],
            ),
          ),
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 6),
            decoration: BoxDecoration(
              color: const Color(0xFF10B981),
              borderRadius: BorderRadius.circular(20),
            ),
            child: const Row(
              mainAxisSize: MainAxisSize.min,
              children: [
                Icon(Icons.trending_up, color: Colors.white, size: 12),
                SizedBox(width: 4),
                Text(
                  '+12%',
                  style: TextStyle(
                    color: Colors.white,
                    fontSize: 11,
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

  Widget _buildProgressBar(int recycleRate) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Row(
          mainAxisAlignment: MainAxisAlignment.spaceBetween,
          children: [
            const Text(
              'Target Pencapaian',
              style: TextStyle(
                fontSize: 13,
                fontWeight: FontWeight.w600,
                color: Color(0xFF374151),
              ),
            ),
            Text(
              '$recycleRate%',
              style: const TextStyle(
                fontSize: 14,
                fontWeight: FontWeight.w700,
                color: Color(0xFF10B981),
              ),
            ),
          ],
        ),
        const SizedBox(height: 10),
        ClipRRect(
          borderRadius: BorderRadius.circular(8),
          child: Stack(
            children: [
              // Background
              Container(
                height: 12,
                decoration: BoxDecoration(
                  color: const Color(0xFFECFDF5),
                  borderRadius: BorderRadius.circular(8),
                ),
              ),
              // Progress
              FractionallySizedBox(
                widthFactor: recycleRate / 100,
                child: Container(
                  height: 12,
                  decoration: BoxDecoration(
                    gradient: const LinearGradient(
                      colors: [Color(0xFF10B981), Color(0xFF059669)],
                    ),
                    borderRadius: BorderRadius.circular(8),
                  ),
                ),
              ),
            ],
          ),
        ),
        const SizedBox(height: 8),
        Row(
          mainAxisAlignment: MainAxisAlignment.spaceBetween,
          children: [
            Text(
              '0%',
              style: TextStyle(
                fontSize: 10,
                color: Colors.grey.shade500,
              ),
            ),
            Container(
              padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 2),
              decoration: BoxDecoration(
                color: Colors.grey.shade100,
                borderRadius: BorderRadius.circular(4),
              ),
              child: const Text(
                'Target 70%',
                style: TextStyle(
                  fontSize: 10,
                  color: Color(0xFF6B7280),
                  fontWeight: FontWeight.w500,
                ),
              ),
            ),
            Text(
              '100%',
              style: TextStyle(
                fontSize: 10,
                color: Colors.grey.shade500,
              ),
            ),
          ],
        ),
      ],
    );
  }

  Widget _buildCategoryBreakdown(double organic, double recycle, double inorganic, double total) {
    return Row(
      children: [
        Expanded(
          child: _CategoryItem(
            icon: Icons.grass,
            title: 'Organik',
            value: '${organic.toStringAsFixed(1)} kg',
            percentage: total > 0 ? ((organic / total) * 100).toInt() : 0,
            color: const Color(0xFF10B981),
            gradient: const [Color(0xFF10B981), Color(0xFF059669)],
          ),
        ),
        const SizedBox(width: 10),
        Expanded(
          child: _CategoryItem(
            icon: Icons.recycling,
            title: 'Daur Ulang',
            value: '${recycle.toStringAsFixed(1)} kg',
            percentage: total > 0 ? ((recycle / total) * 100).toInt() : 0,
            color: const Color(0xFF3B82F6),
            gradient: const [Color(0xFF3B82F6), Color(0xFF2563EB)],
          ),
        ),
        const SizedBox(width: 10),
        Expanded(
          child: _CategoryItem(
            icon: Icons.delete_outline,
            title: 'Anorganik',
            value: '${inorganic.toStringAsFixed(1)} kg',
            percentage: total > 0 ? ((inorganic / total) * 100).toInt() : 0,
            color: const Color(0xFFF59E0B),
            gradient: const [Color(0xFFF59E0B), Color(0xFFD97706)],
          ),
        ),
      ],
    );
  }
}

class _CategoryItem extends StatelessWidget {
  final IconData icon;
  final String title;
  final String value;
  final int percentage;
  final Color color;
  final List<Color> gradient;

  const _CategoryItem({
    required this.icon,
    required this.title,
    required this.value,
    required this.percentage,
    required this.color,
    required this.gradient,
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(12),
      decoration: BoxDecoration(
        color: color.withValues(alpha: 0.08),
        borderRadius: BorderRadius.circular(14),
        border: Border.all(color: color.withValues(alpha: 0.15)),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // Icon & Title
          Row(
            children: [
              Container(
                padding: const EdgeInsets.all(6),
                decoration: BoxDecoration(
                  color: color.withValues(alpha: 0.15),
                  borderRadius: BorderRadius.circular(8),
                ),
                child: Icon(icon, color: color, size: 14),
              ),
              const SizedBox(width: 6),
              Expanded(
                child: Text(
                  title,
                  style: TextStyle(
                    fontSize: 10,
                    color: color,
                    fontWeight: FontWeight.w600,
                  ),
                  overflow: TextOverflow.ellipsis,
                ),
              ),
            ],
          ),
          const SizedBox(height: 10),
          // Value
          Text(
            value,
            style: TextStyle(
              fontSize: 14,
              fontWeight: FontWeight.w800,
              color: color,
            ),
          ),
          const SizedBox(height: 6),
          // Mini progress bar
          ClipRRect(
            borderRadius: BorderRadius.circular(3),
            child: LinearProgressIndicator(
              value: percentage / 100,
              backgroundColor: color.withValues(alpha: 0.15),
              valueColor: AlwaysStoppedAnimation<Color>(color),
              minHeight: 4,
            ),
          ),
          const SizedBox(height: 4),
          Text(
            '$percentage%',
            style: TextStyle(
              fontSize: 10,
              color: color.withValues(alpha: 0.8),
              fontWeight: FontWeight.w500,
            ),
          ),
        ],
      ),
    );
  }
}
