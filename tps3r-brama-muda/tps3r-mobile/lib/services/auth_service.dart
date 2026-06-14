import 'dart:convert';
import 'package:flutter/foundation.dart';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

/// ============================================================
/// AuthService - Laravel Sanctum API Authentication Service
/// ============================================================
/// Handle semua operasi authentication dengan Laravel Sanctum API
/// termasuk register, login, logout, dan profile management
///
/// Base URL: http://172.20.10.2:8000/api
///
/// Author: Claude
/// ============================================================

class AuthService {
  // Base URL Laravel API
  static String get _baseUrl {
    if (kIsWeb) {
      return 'http://127.0.0.1:8000/api';
    }
    return defaultTargetPlatform == TargetPlatform.android
        ? 'http://10.0.2.2:8000/api'
        : 'http://127.0.0.1:8000/api';
  }

  // SharedPreferences keys
  static const String _tokenKey = 'auth_token';
  static const String _userKey = 'user_data';

  // Timeout untuk request (dalam detik)
  static const int _timeout = 30;

  // ============================================================
  // TOKEN MANAGEMENT - Simpan dan ambil token
  // ============================================================

  /// Ambil token dari SharedPreferences
  static Future<String?> getToken() async {
    try {
      final prefs = await SharedPreferences.getInstance();
      return prefs.getString(_tokenKey);
    } catch (e) {
      debugPrint('Error getting token: $e');
      return null;
    }
  }

  /// Simpan token ke SharedPreferences
  static Future<void> _saveToken(String token) async {
    try {
      final prefs = await SharedPreferences.getInstance();
      await prefs.setString(_tokenKey, token);
    } catch (e) {
      debugPrint('Error saving token: $e');
    }
  }

  /// Hapus token dari SharedPreferences
  static Future<void> _removeToken() async {
    try {
      final prefs = await SharedPreferences.getInstance();
      await prefs.remove(_tokenKey);
      await prefs.remove(_userKey);
    } catch (e) {
      debugPrint('Error removing token: $e');
    }
  }

  /// Simpan data user ke SharedPreferences
  static Future<void> _saveUserData(Map<String, dynamic> user) async {
    try {
      final prefs = await SharedPreferences.getInstance();
      await prefs.setString(_userKey, jsonEncode(user));
    } catch (e) {
      debugPrint('Error saving user data: $e');
    }
  }

  /// Ambil data user dari SharedPreferences
  static Future<Map<String, dynamic>?> getCurrentUser() async {
    try {
      final prefs = await SharedPreferences.getInstance();
      final userString = prefs.getString(_userKey);
      if (userString != null) {
        return jsonDecode(userString) as Map<String, dynamic>;
      }
      return null;
    } catch (e) {
      debugPrint('Error getting user data: $e');
      return null;
    }
  }

  // ============================================================
  // AUTH STATE - Cek apakah user sudah login
  // ============================================================

  /// Cek apakah ada user yang sedang login
  static Future<bool> isLoggedIn() async {
    final token = await getToken();
    return token != null && token.isNotEmpty;
  }

  // ============================================================
  // HTTP HELPER - Helper untuk request
  // ============================================================

  /// Buat header dengan atau tanpa token
  static Future<Map<String, String>> _getHeaders({bool withToken = false}) async {
    final headers = <String, String>{
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    };

    if (withToken) {
      final token = await getToken();
      if (token != null) {
        headers['Authorization'] = 'Bearer $token';
      }
    }

    return headers;
  }

  /// Parse response dan handle error
  static Map<String, dynamic> _parseResponse(http.Response response) {
    try {
      final body = jsonDecode(response.body) as Map<String, dynamic>;
      return body;
    } catch (e) {
      return {
        'success': false,
        'message': 'Gagal memproses response dari server.',
      };
    }
  }

  /// Konversi HTTP status code ke pesan yang user-friendly
  static String _getHttpErrorMessage(int statusCode) {
    switch (statusCode) {
      case 400:
        return 'Request tidak valid.';
      case 401:
        return 'Email atau password salah.';
      case 403:
        return 'Akses ditolak.';
      case 404:
        return 'Endpoint tidak ditemukan.';
      case 422:
        return 'Validasi gagal. Periksa input Anda.';
      case 429:
        return 'Terlalu banyak percobaan. Tunggu beberapa saat lagi.';
      case 500:
        return 'Server error. Silakan coba lagi nanti.';
      case 502:
        return 'Server tidak tersedia. Silakan coba lagi nanti.';
      case 503:
        return 'Layanan tidak tersedia. Silakan coba lagi nanti.';
      default:
        return 'Terjadi kesalahan (code: $statusCode).';
    }
  }

  // ============================================================
  // REGISTER - Daftarkan user baru
  // ============================================================
  /// Register user baru dengan nama, email dan password
  ///
  /// Parameters:
  /// - [name] - Nama lengkap user
  /// - [email] - Email user
  /// - [password] - Password
  ///
  /// Returns: Map dengan keys:
  /// - 'success' (bool) - Apakah operasi berhasil
  /// - 'message' (String) - Pesan sukses/error
  /// - 'user' (Map?) - Data user jika berhasil
  /// ============================================================
  static Future<Map<String, dynamic>> registerUser({
    required String name,
    required String email,
    required String password,
  }) async {
    try {
      final headers = await _getHeaders();

      final response = await http
          .post(
            Uri.parse('$_baseUrl/auth/register'),
            headers: headers,
            body: jsonEncode({
              'name': name.trim(),
              'email': email.trim(),
              'password': password.trim(),
              'password_confirmation': password.trim(),
            }),
          )
          .timeout(
            const Duration(seconds: _timeout),
            onTimeout: () {
              throw Exception('Request timeout. Periksa koneksi internet Anda.');
            },
          );

      final data = _parseResponse(response);

      // Handle HTTP status codes
      if (response.statusCode == 201 || response.statusCode == 200) {
        if (data['success'] == true) {
          // Simpan token dan user data
          final token = data['token'] as String?;
          final user = data['user'] as Map<String, dynamic>?;

          if (token != null) {
            await _saveToken(token);
          }
          if (user != null) {
            await _saveUserData(user);
          }

          return {
            'success': true,
            'message': data['message'] ?? 'Registrasi berhasil! Selamat datang, $name.',
            'user': user,
          };
        }
      }

      // Handle validation errors (Laravel 422)
      if (response.statusCode == 422) {
        final errors = data['errors'] as Map<String, dynamic>?;
        if (errors != null && errors.isNotEmpty) {
          final firstError = errors.values.first;
          final errorMessage = firstError is List ? firstError.first : firstError.toString();
          return {
            'success': false,
            'message': errorMessage,
          };
        }
        return {
          'success': false,
          'message': data['message'] ?? 'Validasi gagal. Periksa input Anda.',
        };
      }

      // Handle other errors
      return {
        'success': false,
        'message': data['message'] ?? _getHttpErrorMessage(response.statusCode),
      };
    } on http.ClientException catch (e) {
      debugPrint('Client error: $e');
      return {
        'success': false,
        'message': 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.',
      };
    } catch (e) {
      debugPrint('Register error: $e');
      if (e.toString().contains('timeout')) {
        return {
          'success': false,
          'message': 'Request timeout. Periksa koneksi internet Anda.',
        };
      }
      return {
        'success': false,
        'message': 'Terjadi kesalahan. Silakan coba lagi.',
      };
    }
  }

  // ============================================================
  // LOGIN - Login user yang sudah ada
  // ============================================================
  /// Login user dengan email dan password yang sudah terdaftar
  ///
  /// Parameters:
  /// - [email] - Email user
  /// - [password] - Password user
  ///
  /// Returns: Map dengan keys:
  /// - 'success' (bool) - Apakah operasi berhasil
  /// - 'message' (String) - Pesan sukses/error
  /// - 'user' (Map?) - Data user jika berhasil
  /// ============================================================
  static Future<Map<String, dynamic>> loginUser({
    required String email,
    required String password,
  }) async {
    try {
      final headers = await _getHeaders();

      final response = await http
          .post(
            Uri.parse('$_baseUrl/auth/login'),
            headers: headers,
            body: jsonEncode({
              'email': email.trim(),
              'password': password.trim(),
            }),
          )
          .timeout(
            const Duration(seconds: _timeout),
            onTimeout: () {
              throw Exception('Request timeout. Periksa koneksi internet Anda.');
            },
          );

      final data = _parseResponse(response);

      // Handle successful login
      if (response.statusCode == 200 || response.statusCode == 201) {
        if (data['success'] == true) {
          // Simpan token dan user data
          final token = data['token'] as String?;
          final user = data['user'] as Map<String, dynamic>?;

          if (token != null) {
            await _saveToken(token);
          }
          if (user != null) {
            await _saveUserData(user);
          }

          return {
            'success': true,
            'message': data['message'] ?? 'Login berhasil!',
            'user': user,
          };
        }
      }

      // Handle unauthorized (401)
      if (response.statusCode == 401) {
        return {
          'success': false,
          'message': data['message'] ?? 'Email atau password salah.',
        };
      }

      // Handle validation errors (Laravel 422)
      if (response.statusCode == 422) {
        final errors = data['errors'] as Map<String, dynamic>?;
        if (errors != null && errors.isNotEmpty) {
          final firstError = errors.values.first;
          final errorMessage = firstError is List ? firstError.first : firstError.toString();
          return {
            'success': false,
            'message': errorMessage,
          };
        }
        return {
          'success': false,
          'message': data['message'] ?? 'Validasi gagal. Periksa input Anda.',
        };
      }

      // Handle other errors
      return {
        'success': false,
        'message': data['message'] ?? _getHttpErrorMessage(response.statusCode),
      };
    } on http.ClientException catch (e) {
      debugPrint('Client error: $e');
      return {
        'success': false,
        'message': 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.',
      };
    } catch (e) {
      debugPrint('Login error: $e');
      if (e.toString().contains('timeout')) {
        return {
          'success': false,
          'message': 'Request timeout. Periksa koneksi internet Anda.',
        };
      }
      return {
        'success': false,
        'message': 'Terjadi kesalahan. Silakan coba lagi.',
      };
    }
  }

  // ============================================================
  // LOGOUT - Keluar dari akun
  // ============================================================
  /// Logout user dan hapus session/token
  ///
  /// Returns: void (tidak mengembalikan apa-apa)
  /// ============================================================
  static Future<void> logoutUser() async {
    try {
      final token = await getToken();

      // Jika ada token, panggil API logout
      if (token != null) {
        final headers = await _getHeaders(withToken: true);

        await http
            .post(
              Uri.parse('$_baseUrl/auth/logout'),
              headers: headers,
            )
            .timeout(
              const Duration(seconds: _timeout),
              onTimeout: () {
                // Ignore timeout saat logout
                throw Exception('Logout timeout');
              },
            );
      }
    } catch (e) {
      debugPrint('Logout API error (ignored): $e');
    } finally {
      // Selalu hapus local data meskipun API gagal
      await _removeToken();
    }
  }

  // ============================================================
  // GET PROFILE - Ambil data profil user
  // ============================================================
  /// Mengambil data profil user dari API
  ///
  /// Returns: Map dengan data user atau null jika gagal
  /// ============================================================
  static Future<Map<String, dynamic>?> getProfile() async {
    try {
      final token = await getToken();

      if (token == null) {
        debugPrint('No token found for getProfile');
        return null;
      }

      final headers = await _getHeaders(withToken: true);

      final response = await http
          .get(
            Uri.parse('$_baseUrl/auth/profile'),
            headers: headers,
          )
          .timeout(
            const Duration(seconds: _timeout),
            onTimeout: () {
              throw Exception('Request timeout');
            },
          );

      if (response.statusCode == 200) {
        final data = _parseResponse(response);
        if (data['success'] == true) {
          final user = data['user'] as Map<String, dynamic>?;
          if (user != null) {
            await _saveUserData(user);
          }
          return user;
        }
      }

      // Handle unauthorized - token expired/invalid
      if (response.statusCode == 401) {
        await _removeToken();
        return null;
      }

      // Fallback ke local data
      return await getCurrentUser();
    } catch (e) {
      debugPrint('Get profile error: $e');
      // Fallback ke local data
      return await getCurrentUser();
    }
  }
}