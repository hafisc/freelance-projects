import 'package:flutter/foundation.dart';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import 'dart:convert';
import 'auth_service.dart';

/// ============================================================
/// ProfileService - Profile Data Management Service
/// ============================================================
/// Handle semua operasi yang berkaitan dengan profil member
/// menggunakan AuthService untuk mengambil data dari API Laravel
/// dan SharedPreferences untuk penyimpanan lokal
///
/// Author: Claude
/// ============================================================

class ProfileService {
  static String get _baseUrl {
    if (kIsWeb) {
      return 'http://127.0.0.1:8000/api';
    }
    return defaultTargetPlatform == TargetPlatform.android
        ? 'http://10.0.2.2:8000/api'
        : 'http://127.0.0.1:8000/api';
  }

  // SharedPreferences keys
  static const String _userKey = 'user_data';

  // ============================================================
  // GET USER PROFILE - Ambil data profil
  // ============================================================
  /// Mengambil data profil user
  /// Pertama coba dari SharedPreferences, lalu dari API jika perlu
  ///
  /// Returns: Map dengan data user atau null jika tidak ada
  /// ============================================================
  static Future<Map<String, dynamic>?> getUserProfile() async {
    try {
      // Ambil dari SharedPreferences
      final prefs = await SharedPreferences.getInstance();
      final userString = prefs.getString(_userKey);

      if (userString != null) {
        return jsonDecode(userString) as Map<String, dynamic>;
      }

      // Fallback ke API
      final profile = await AuthService.getProfile();
      return profile;
    } catch (e) {
      debugPrint('Error getting user profile: $e');
      return null;
    }
  }

  // ============================================================
  // UPDATE USER PROFILE - Update data profil
  // ============================================================
  /// Mengupdate data profil user ke backend Laravel dan local storage.
  ///
  /// Parameters:
  /// - [name] - Nama lengkap (opsional)
  /// - [phone] - Nomor HP (opsional)
  ///
  /// Returns: Map dengan success dan message
  /// ============================================================
  static Future<Map<String, dynamic>> updateUserProfile({
    String? name,
    String? phone,
  }) async {
    try {
      // Ambil profile saat ini
      final currentProfile = await getUserProfile();

      if (currentProfile == null) {
        return {
          'success': false,
          'message': 'User belum login.',
        };
      }

      final token = await AuthService.getToken();
      if (token == null || token.isEmpty) {
        return {
          'success': false,
          'message': 'Sesi login tidak ditemukan. Silakan login ulang.',
        };
      }

      final response = await http.put(
        Uri.parse('$_baseUrl/auth/profile/update'),
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer $token',
        },
        body: jsonEncode({
          'name': name?.trim().isNotEmpty == true
              ? name!.trim()
              : currentProfile['name'],
          'email': currentProfile['email'],
          'phone': phone?.trim(),
        }),
      );

      final Map<String, dynamic> responseData =
          jsonDecode(response.body) as Map<String, dynamic>;

      if (response.statusCode != 200 || responseData['success'] != true) {
        final errors = responseData['errors'] as Map<String, dynamic>?;
        final firstError = errors?.values.isNotEmpty == true
            ? errors!.values.first
            : null;
        return {
          'success': false,
          'message': firstError is List
              ? firstError.first.toString()
              : responseData['message'] ?? 'Gagal memperbarui profil.',
        };
      }

      final Map<String, dynamic> updateData =
          Map<String, dynamic>.from(responseData['user'] as Map);
      final prefs = await SharedPreferences.getInstance();
      await prefs.setString(_userKey, jsonEncode(updateData));

      return {
        'success': true,
        'message': responseData['message'] ?? 'Profil berhasil diperbarui!',
      };
    } catch (e) {
      debugPrint('Error updating profile: $e');
      return {
        'success': false,
        'message': 'Gagal memperbarui profil. Silakan coba lagi.',
      };
    }
  }

  // ============================================================
  // FETCH PROFILE - Ambil data dari API atau local
  // ============================================================
  /// Alternative untuk mengambil data profil
  /// Cocok untuk FutureBuilder
  /// ============================================================
  static Future<Map<String, dynamic>> fetchProfile() async {
    final profile = await getUserProfile();

    if (profile != null) {
      return profile;
    }

    // Jika tidak ada data, return default profile
    return _getDefaultProfile();
  }

  // ============================================================
  // DEFAULT PROFILE - Profile fallback
  // ============================================================
  /// Mengembalikan profile default jika tidak ada data
  /// ============================================================
  static Map<String, dynamic> _getDefaultProfile() {
    return {
      'name': 'Member',
      'email': '-',
      'phone': '-',
      'role': 'member',
      'status': 'aktif',
    };
  }
}
