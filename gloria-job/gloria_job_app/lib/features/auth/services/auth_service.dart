import 'dart:convert';
import 'package:shared_preferences/shared_preferences.dart';
import '../../../core/constants/api_constants.dart';
import '../../../core/network/api_client.dart';
import '../models/user_model.dart';

class AuthService {
  final ApiClient _apiClient = ApiClient();

  // Mendaftar pencari kerja baru
  Future<UserModel> register({
    required String name,
    required String email,
    required String phone,
    required String password,
    required String passwordConfirmation,
  }) async {
    try {
      final response = await _apiClient.post(ApiConstants.register, {
        'name': name,
        'email': email,
        'phone': phone,
        'password': password,
        'password_confirmation': passwordConfirmation,
      });

      final body = jsonDecode(response.body);

      if (response.statusCode == 201 && body['success'] == true) {
        final data = body['data'];
        final token = data['token'];
        final user = UserModel.fromJson(data['user']);

        await _saveSession(token, user);
        return user;
      } else {
        final message = body['message'] ?? 'Gagal melakukan registrasi';
        throw Exception(message);
      }
    } catch (e) {
      throw Exception(e.toString().replaceAll('Exception: ', ''));
    }
  }

  // Masuk log pencari kerja
  Future<UserModel> login({
    required String email,
    required String password,
  }) async {
    try {
      final response = await _apiClient.post(ApiConstants.login, {
        'email': email,
        'password': password,
      });

      final body = jsonDecode(response.body);

      if (response.statusCode == 200 && body['success'] == true) {
        final data = body['data'];
        final token = data['token'];
        final user = UserModel.fromJson(data['user']);

        await _saveSession(token, user);
        return user;
      } else {
        final message = body['message'] ?? 'Email atau password salah';
        throw Exception(message);
      }
    } catch (e) {
      throw Exception(e.toString().replaceAll('Exception: ', ''));
    }
  }

  // Mendapatkan data profil user dari API
  Future<UserModel> getProfile() async {
    try {
      final response = await _apiClient.get(ApiConstants.profile);
      final body = jsonDecode(response.body);

      if (response.statusCode == 200 && body['success'] == true) {
        final user = UserModel.fromJson(body['data']);
        await _saveUserOnly(user);
        return user;
      } else {
        throw Exception('Gagal memuat profil terbaru');
      }
    } catch (e) {
      throw Exception(e.toString().replaceAll('Exception: ', ''));
    }
  }

  // Memperbarui data profil user di API (menggunakan request multipart untuk upload file)
  Future<UserModel> updateProfile({
    required String name,
    required String phone,
    String? address,
    String? cvPath,
    String? summary,
  }) async {
    try {
      final fields = {
        'name': name,
        'phone': phone,
        'address': address ?? '',
        'summary': summary ?? '',
        'skills': '[]',
        'education': '[]',
        'experience': '[]',
      };

      final response = await _apiClient.postMultipart(
        ApiConstants.profileUpdate,
        fields,
        'cv',
        cvPath,
      );

      final body = jsonDecode(response.body);

      if (response.statusCode == 200 && body['success'] == true) {
        final user = UserModel.fromJson(body['data']);
        await _saveUserOnly(user);
        return user;
      } else {
        final message = body['message'] ?? 'Gagal memperbarui profil';
        throw Exception(message);
      }
    } catch (e) {
      throw Exception(e.toString().replaceAll('Exception: ', ''));
    }
  }

  // Keluar log pencari kerja (Logout)
  Future<void> logout() async {
    try {
      await _apiClient.post(ApiConstants.logout, {});
    } catch (_) {
      // Abaikan error jika token di backend sudah expired
    } finally {
      await _clearSession();
    }
  }

  // Helper untuk menyimpan sesi ke SharedPreferences
  Future<void> _saveSession(String token, UserModel user) async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.setString('auth_token', token);
    await prefs.setString('user_profile', jsonEncode(user.toJson()));
  }

  // Helper untuk memperbarui data user saja
  Future<void> _saveUserOnly(UserModel user) async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.setString('user_profile', jsonEncode(user.toJson()));
  }

  // Helper untuk menghapus sesi
  Future<void> _clearSession() async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.remove('auth_token');
    await prefs.remove('user_profile');
  }

  // Cek apakah user sudah masuk log
  Future<bool> isLoggedIn() async {
    final prefs = await SharedPreferences.getInstance();
    final token = prefs.getString('auth_token');
    return token != null && token.isNotEmpty;
  }

  // Mengambil data user yang tersimpan secara lokal
  Future<UserModel?> getCachedUser() async {
    final prefs = await SharedPreferences.getInstance();
    final userStr = prefs.getString('user_profile');
    if (userStr == null) return null;
    try {
      return UserModel.fromJson(jsonDecode(userStr));
    } catch (_) {
      return null;
    }
  }
}
