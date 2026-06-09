import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import 'services/app_state.dart';
import 'components/app_scaffold.dart';
import 'screens/auth_wrapper.dart';
import 'pages/landing_page.dart';
import 'pages/login_page.dart';
import 'pages/register_page.dart';
import 'pages/info_tps_page.dart';
import 'pages/my_profile_page.dart';

void main() async {
  WidgetsFlutterBinding.ensureInitialized();
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return ChangeNotifierProvider(
      create: (_) => AppState(),
      child: MaterialApp(
        debugShowCheckedModeBanner: false,
        title: 'TPS 3R Brama Muda',
        theme: ThemeData(
          colorScheme: ColorScheme.fromSeed(
            seedColor: const Color(0xFF14532D),
            primary: const Color(0xFF14532D),
            secondary: const Color(0xFF16A34A),
            brightness: Brightness.light,
          ),
          useMaterial3: true,
        ),
        // Home menggunakan AuthWrapper untuk auto-login
        home: const AuthWrapper(),
        routes: {
          '/landing': (_) => const LandingPage(),
          '/login': (_) => const LoginPage(),
          '/register': (_) => const RegisterPage(),
          '/info-tps': (_) => const InfoTpsPage(),
          '/my-profile': (_) => const MyProfilePage(),
          '/app': (context) {
            final args = ModalRoute.of(context)?.settings.arguments as Map<String, dynamic>?;
            final initialIndex = args?['initialIndex'] as int? ?? 0;
            return AppShell(initialIndex: initialIndex);
          },
        },
      ),
    );
  }
}