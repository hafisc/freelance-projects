import 'package:flutter/foundation.dart';
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
  /// Mengupdate data profil user di local storage
  /// (Update profile dilakukan di backend Laravel)
  ///
  /// Parameters:
  /// - [name] - Nama lengkap (opsional)
  /// - [phone] - Nomor HP (opsional)
  /// - [address] - Alamat (opsional)
  ///
  /// Returns: Map dengan success dan message
  /// ============================================================
  static Future<Map<String, dynamic>> updateUserProfile({
    String? name,
    String? phone,
    String? address,
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

      // Build update data
      final Map<String, dynamic> updateData = Map.from(currentProfile);

      if (name != null && name.trim().isNotEmpty) {
        updateData['name'] = name.trim();
      }

      if (phone != null) {
        updateData['phone'] = phone.trim();
      }

      if (address != null) {
        updateData['address'] = address.trim();
      }

      // Update ke SharedPreferences
      final prefs = await SharedPreferences.getInstance();
      await prefs.setString(_userKey, jsonEncode(updateData));

      return {
        'success': true,
        'message': 'Profil berhasil diperbarui!',
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
      'address': '-',
      'role': 'member',
      'status': 'aktif',
      'tier': 'BRONZE',
      'poin': 0,
      'totalReports': 0,
      'completedReports': 0,
      'processedReports': 0,
    };
  }
}