import 'package:flutter/material.dart';

class MenuCard extends StatelessWidget {
  final IconData icon;
  final String title;
  final String subtitle;
  final VoidCallback onTap;

  const MenuCard({required this.icon, required this.title, required this.subtitle, required this.onTap, super.key});

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: onTap,
      child: Container(
        decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(24), boxShadow: [BoxShadow(color: Colors.black12, blurRadius: 28, offset: const Offset(0, 14))]),
        padding: const EdgeInsets.all(24),
        child: Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
          Container(
            decoration: BoxDecoration(color: Colors.green.shade50, borderRadius: BorderRadius.circular(18)),
            padding: const EdgeInsets.all(14),
            child: Icon(icon, size: 28, color: Colors.green.shade700),
          ),
          const SizedBox(height: 22),
          Text(title, style: const TextStyle(fontSize: 20, fontWeight: FontWeight.w700)),
          const SizedBox(height: 10),
          Text(subtitle, style: const TextStyle(fontSize: 14, color: Colors.black54, height: 1.4)),
        ]),
      ),
    );
  }
}
