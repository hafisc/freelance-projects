import 'package:flutter/material.dart';

class BarChartWidget extends StatelessWidget {
  final Map<String, double> data;

  const BarChartWidget({required this.data, super.key});

  @override
  Widget build(BuildContext context) {
    final maxValue = data.values.isNotEmpty ? data.values.reduce((value, element) => value > element ? value : element) : 1;
    return Column(
      children: data.entries.map((entry) {
        final widthFactor = entry.value / maxValue;
        final barColor = entry.key == 'Organik' ? Colors.green : entry.key == 'Anorganik' ? Colors.blue : Colors.orange;
        return Padding(
          padding: const EdgeInsets.symmetric(vertical: 12),
          child: Row(children: [
            SizedBox(width: 110, child: Text(entry.key, style: const TextStyle(fontWeight: FontWeight.w600))),
            const SizedBox(width: 18),
            Expanded(
              child: Stack(children: [
                Container(height: 18, decoration: BoxDecoration(color: Colors.grey.shade200, borderRadius: BorderRadius.circular(12))),
                FractionallySizedBox(
                  widthFactor: widthFactor,
                  child: Container(height: 18, decoration: BoxDecoration(color: barColor, borderRadius: BorderRadius.circular(12))),
                ),
              ]),
            ),
            const SizedBox(width: 16),
            Text('${entry.value.toStringAsFixed(0)} kg', style: TextStyle(color: barColor, fontWeight: FontWeight.w700)),
          ]),
        );
      }).toList(),
    );
  }
}

class PieChartWidget extends StatelessWidget {
  final Map<String, double> data;

  const PieChartWidget({required this.data, super.key});

  @override
  Widget build(BuildContext context) {
    return SizedBox(
      height: 260,
      child: CustomPaint(
        painter: _PieChartPainter(data: data),
        child: Center(
          child: Container(
            width: 88,
            height: 88,
            decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(48), boxShadow: [BoxShadow(color: Colors.black12, blurRadius: 20, offset: const Offset(0, 8))]),
            child: const Center(child: Text('3 Kategori', textAlign: TextAlign.center, style: TextStyle(fontSize: 12, fontWeight: FontWeight.w700))),
          ),
        ),
      ),
    );
  }
}

class _PieChartPainter extends CustomPainter {
  final Map<String, double> data;

  _PieChartPainter({required this.data});

  @override
  void paint(Canvas canvas, Size size) {
    final total = data.values.fold<double>(0, (previous, value) => previous + value);
    final center = Offset(size.width / 2, size.height / 2);
    final radius = size.width * 0.42;
    var startAngle = -3.14 / 2;
    final paint = Paint()..style = PaintingStyle.stroke..strokeWidth = 50;

    for (final entry in data.entries) {
      final sweep = (entry.value / total) * 3.14 * 2;
      paint.color = entry.key == 'Organik' ? Colors.green : entry.key == 'Anorganik' ? Colors.blue : Colors.orange;
      canvas.drawArc(Rect.fromCircle(center: center, radius: radius), startAngle, sweep, false, paint);
      startAngle += sweep;
    }
  }

  @override
  bool shouldRepaint(covariant CustomPainter oldDelegate) => false;
}
