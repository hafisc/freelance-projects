import 'package:flutter/material.dart';
import '../features/auth/screens/splash_screen.dart';
import '../features/auth/screens/login_screen.dart';
import '../features/auth/screens/register_screen.dart';
import '../features/jobs/screens/main_screen.dart';
import '../features/jobs/screens/job_detail_screen.dart';
import '../features/applications/screens/apply_job_screen.dart';
import '../features/jobs/models/job_model.dart';
import '../features/notifications/screens/notification_screen.dart';

class AppRoutes {
  static const String splash = '/';
  static const String login = '/login';
  static const String register = '/register';
  static const String main = '/main';
  static const String jobDetail = '/job-detail';
  static const String applyJob = '/apply-job';
  static const String notifications = '/notifications';

  static Route<dynamic> generateRoute(RouteSettings settings) {
    switch (settings.name) {
      case splash:
        return MaterialPageRoute(builder: (_) => const SplashScreen(), settings: settings);
      case login:
        return MaterialPageRoute(builder: (_) => const LoginScreen(), settings: settings);
      case register:
        return MaterialPageRoute(builder: (_) => const RegisterScreen(), settings: settings);
      case main:
        return MaterialPageRoute(builder: (_) => const MainScreen(), settings: settings);
      case jobDetail:
        final job = settings.arguments as JobModel;
        return MaterialPageRoute(builder: (_) => JobDetailScreen(job: job), settings: settings);
      case applyJob:
        final job = settings.arguments as JobModel;
        return MaterialPageRoute(builder: (_) => ApplyJobScreen(job: job), settings: settings);
      case notifications:
        return MaterialPageRoute(builder: (_) => const NotificationScreen(), settings: settings);

      default:
        return MaterialPageRoute(
          settings: settings,
          builder: (_) => Scaffold(
            body: Center(
              child: Text('Halaman tidak ditemukan: ${settings.name}'),
            ),
          ),
        );
    }
  }
}
