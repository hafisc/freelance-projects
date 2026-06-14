import 'package:flutter/material.dart';
import '../services/auth_service.dart';
import '../pages/landing_page.dart';
import '../components/app_scaffold.dart';

/// ============================================================
/// AuthWrapper - Authentication State Handler
/// ============================================================
/// Widget ini menangani semua state authentication:
/// - Jika user login → tampilkan dashboard
/// - Jika user belum login → tampilkan landing page
///
/// Menggunakan AuthService.isLoggedIn() untuk deteksi status login
///
/// Author: Claude
/// ============================================================

class AuthWrapper extends StatefulWidget {
  const AuthWrapper({super.key});

  @override
  State<AuthWrapper> createState() => _AuthWrapperState();
}

class _AuthWrapperState extends State<AuthWrapper> {
  bool _isChecking = true;

  @override
  void initState() {
    super.initState();
    _checkAuthState();
  }

  Future<void> _checkAuthState() async {
    await AuthService.isLoggedIn();
    if (mounted) {
      setState(() {
        _isChecking = false;
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    // Tampilkan loading indicator saat sedang pengecekan
    if (_isChecking) {
      return const _LoadingScreen();
    }

    // Cek apakah ada user yang sedang login
    return FutureBuilder<bool>(
      future: AuthService.isLoggedIn(),
      builder: (context, snapshot) {
        if (snapshot.connectionState == ConnectionState.waiting) {
          return const _LoadingScreen();
        }

        final isLoggedIn = snapshot.data ?? false;

        if (isLoggedIn) {
          // User sudah login → tampilkan dashboard
          return const AppShell(initialIndex: 0);
        } else {
          // User belum login → tampilkan landing page
          return const LandingPage();
        }
      },
    );
  }
}

/// ============================================================
/// _LoadingScreen - Loading indicator saat pengecekan auth
/// ============================================================
/// Menampilkan splash screen dengan animasi loading
/// ============================================================

class _LoadingScreen extends StatelessWidget {
  const _LoadingScreen();

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF0FDF4),
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            // Logo animated container
            TweenAnimationBuilder<double>(
              tween: Tween(begin: 0.0, end: 1.0),
              duration: const Duration(milliseconds: 800),
              builder: (context, value, child) {
                return Transform.scale(
                  scale: 0.8 + (0.2 * value),
                  child: Opacity(
                    opacity: value,
                    child: child,
                  ),
                );
              },
              child: Container(
                padding: const EdgeInsets.all(20),
                decoration: BoxDecoration(
                  gradient: const LinearGradient(
                    colors: [Color(0xFF10B981), Color(0xFF059669)],
                    begin: Alignment.topLeft,
                    end: Alignment.bottomRight,
                  ),
                  borderRadius: BorderRadius.circular(24),
                  boxShadow: [
                    BoxShadow(
                      color: const Color(0xFF10B981).withValues(alpha: 0.4),
                      blurRadius: 30,
                      offset: const Offset(0, 10),
                    ),
                  ],
                ),
                child: const Icon(
                  Icons.recycling,
                  color: Colors.white,
                  size: 48,
                ),
              ),
            ),
            const SizedBox(height: 32),

            // Title
            const Text(
              'WasteAnalytics',
              style: TextStyle(
                fontSize: 24,
                fontWeight: FontWeight.w800,
                color: Color(0xFF111827),
              ),
            ),
            const SizedBox(height: 8),

            // Subtitle
            const Text(
              'Memuat...',
              style: TextStyle(
                fontSize: 14,
                color: Color(0xFF6B7280),
              ),
            ),
            const SizedBox(height: 32),

            // Loading indicator
            const SizedBox(
              width: 40,
              height: 40,
              child: CircularProgressIndicator(
                color: Color(0xFF10B981),
                strokeWidth: 3,
              ),
            ),
          ],
        ),
      ),
    );
  }
}