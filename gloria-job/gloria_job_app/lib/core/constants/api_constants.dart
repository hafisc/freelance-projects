class ApiConstants {
  // Base URL (Menggunakan 10.0.2.2 untuk emulator Android)
  static const String baseUrl = 'http://10.0.2.2:8000/api';

  // Endpoints
  static const String register = '/register';
  static const String login = '/login';
  static const String logout = '/logout';
  static const String profile = '/profile';
  static const String profileUpdate = '/profile/update';

  static const String jobs = '/jobs';
  static const String applications = '/applications';
  static const String myResults = '/applications/my-results';
  
  static const String notifications = '/notifications';
  static const String notificationsMarkAllRead = '/notifications/mark-all-read';
}

