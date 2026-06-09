// lib/services/api_service.dart
import 'dart:convert';
import 'dart:io';
import 'package:flutter/foundation.dart';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

/// ============================================================
/// ApiService - Laravel API Service untuk Data Management
/// ============================================================
/// Handle semua operasi data dengan Laravel API
/// termasuk members, waste items, statistics, dll
///
/// Base URL: http://172.20.10.2:8000/api
/// ============================================================

class ApiService {
  static String get _baseUrl {
    if (kIsWeb) {
      return 'http://127.0.0.1:8000/api';
    }
    return defaultTargetPlatform == TargetPlatform.android
        ? 'http://10.0.2.2:8000/api'
        : 'http://127.0.0.1:8000/api';
  }
  static const int _timeout = 30;

  // ============================================================
  // TOKEN MANAGEMENT
  // ============================================================
  
  static Future<String?> _getToken() async {
  try {
    final prefs = await SharedPreferences.getInstance();
    final token = prefs.getString('auth_token');

    print('TOKEN DITEMUKAN = $token');

    return token;
  } catch (e) {
    debugPrint('Error getting token: $e');
    return null;
  }
}

  static Future<Map<String, String>> _getHeaders({bool withToken = false}) async {
    final headers = <String, String>{
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    };

    if (withToken) {
      final token = await _getToken();
      if (token != null) {
        headers['Authorization'] = 'Bearer $token';
      }
    }

    return headers;
  }

  static Map<String, dynamic> _parseResponse(http.Response response) {
    try {
      final body = jsonDecode(response.body) as Map<String, dynamic>;
      return body;
    } catch (e) {
      // Tampilkan response asli untuk debug
      debugPrint('=== PARSE ERROR ===');
      debugPrint('Status Code: ${response.statusCode}');
      debugPrint('Response Body: ${response.body}');
      debugPrint('===================');
      return {
        'success': false,
        'message': 'Gagal memproses response dari server.',
      };
    }
  }

  // ============================================================
  // MEMBERS API
  // ============================================================
  
  /// Ambil semua member dari database
  static Future<Map<String, dynamic>> getMembers() async {
    try {
      final headers = await _getHeaders(withToken: true);

      final response = await http
          .get(
            Uri.parse('$_baseUrl/members'),
            headers: headers,
          )
          .timeout(
            const Duration(seconds: _timeout),
            onTimeout: () {
              throw Exception('Request timeout');
            },
          );

      final data = _parseResponse(response);

      if (response.statusCode == 200 && data['success'] == true) {
        return {
          'success': true,
          'members': data['data'] ?? [],
        };
      }

      return {
        'success': false,
        'message': data['message'] ?? 'Gagal mengambil data member',
        'members': [],
      };
    } catch (e) {
      debugPrint('Get members error: $e');
      return {
        'success': false,
        'message': 'Gagal terhubung ke server',
        'members': [],
      };
    }
  }

  /// Tambah member baru
  static Future<Map<String, dynamic>> createMember({
    required String name,
    required String role,
    String? phone,
    String? email,
  }) async {
    try {
      final headers = await _getHeaders(withToken: true);

      final response = await http
          .post(
            Uri.parse('$_baseUrl/members'),
            headers: headers,
            body: jsonEncode({
              'name': name.trim(),
              'role': role.trim(),
              'phone': phone?.trim(),
              'email': email?.trim(),
            }),
          )
          .timeout(
            const Duration(seconds: _timeout),
            onTimeout: () {
              throw Exception('Request timeout');
            },
          );

      final data = _parseResponse(response);

      if (response.statusCode == 201 || response.statusCode == 200) {
        return {
          'success': true,
          'message': data['message'] ?? 'Member berhasil ditambahkan',
          'member': data['data'],
        };
      }

      return {
        'success': false,
        'message': data['message'] ?? _getErrorMessage(response.statusCode),
      };
    } catch (e) {
      debugPrint('Create member error: $e');
      return {
        'success': false,
        'message': 'Gagal terhubung ke server',
      };
    }
  }

  /// Update member
  static Future<Map<String, dynamic>> updateMember({
    required int id,
    required String name,
    required String role,
    bool? active,
    String? phone,
    String? email,
  }) async {
    try {
      final headers = await _getHeaders(withToken: true);

      final response = await http
          .put(
            Uri.parse('$_baseUrl/members/$id'),
            headers: headers,
            body: jsonEncode({
              'name': name.trim(),
              'role': role.trim(),
              'active': active ?? true,
              'phone': phone?.trim(),
              'email': email?.trim(),
            }),
          )
          .timeout(
            const Duration(seconds: _timeout),
            onTimeout: () {
              throw Exception('Request timeout');
            },
          );

      final data = _parseResponse(response);

      if (response.statusCode == 200 && data['success'] == true) {
        return {
          'success': true,
          'message': data['message'] ?? 'Member berhasil diperbarui',
          'member': data['data'],
        };
      }

      return {
        'success': false,
        'message': data['message'] ?? _getErrorMessage(response.statusCode),
      };
    } catch (e) {
      debugPrint('Update member error: $e');
      return {
        'success': false,
        'message': 'Gagal terhubung ke server',
      };
    }
  }

  /// Hapus member
  static Future<Map<String, dynamic>> deleteMember(int id) async {
    try {
      final headers = await _getHeaders(withToken: true);

      final response = await http
          .delete(
            Uri.parse('$_baseUrl/members/$id'),
            headers: headers,
          )
          .timeout(
            const Duration(seconds: _timeout),
            onTimeout: () {
              throw Exception('Request timeout');
            },
          );

      final data = _parseResponse(response);

      if (response.statusCode == 200 && data['success'] == true) {
        return {
          'success': true,
          'message': data['message'] ?? 'Member berhasil dihapus',
        };
      }

      return {
        'success': false,
        'message': data['message'] ?? _getErrorMessage(response.statusCode),
      };
    } catch (e) {
      debugPrint('Delete member error: $e');
      return {
        'success': false,
        'message': 'Gagal terhubung ke server',
      };
    }
  }

  // ============================================================
  // WASTE ITEMS API
  // ============================================================
  
  /// Ambil semua data sampah dari database
  static Future<Map<String, dynamic>> getWasteItems() async {
    try {
      final headers = await _getHeaders(withToken: true);

      final response = await http
          .get(
            Uri.parse('$_baseUrl/reports'),
            headers: headers,
          )
          .timeout(
            const Duration(seconds: _timeout),
            onTimeout: () {
              throw Exception('Request timeout');
            },
          );

      final data = _parseResponse(response);

      if (response.statusCode == 200 && data['success'] == true) {
        return {
          'success': true,
          'waste_items': data['data'] ?? [],
        };
      }

      return {
        'success': false,
        'message': data['message'] ?? 'Gagal mengambil data sampah',
        'waste_items': [],
      };
    } catch (e) {
      debugPrint('Get waste items error: $e');
      return {
        'success': false,
        'message': 'Gagal terhubung ke server',
        'waste_items': [],
      };
    }
  }

  /// Tambah data sampah baru
  static Future<Map<String, dynamic>> createWasteItem({
    required String type,
    required double weight,
    required String category,
    String? status,
    String? notes,
  }) async {
    try {
      final headers = await _getHeaders(withToken: true);

      final response = await http
          .post(
            Uri.parse('$_baseUrl/waste'),
            headers: headers,
            body: jsonEncode({
              'type': type.trim(),
              'weight': weight,
              'category': category,
              'status': status ?? 'pending',
              'notes': notes?.trim(),
            }),
          )
          .timeout(
            const Duration(seconds: _timeout),
            onTimeout: () {
              throw Exception('Request timeout');
            },
          );

      final data = _parseResponse(response);

      if (response.statusCode == 201 || response.statusCode == 200) {
        return {
          'success': true,
          'message': data['message'] ?? 'Data sampah berhasil ditambahkan',
          'waste_item': data['data'],
        };
      }

      return {
        'success': false,
        'message': data['message'] ?? _getErrorMessage(response.statusCode),
      };
    } catch (e) {
      debugPrint('Create waste item error: $e');
      return {
        'success': false,
        'message': 'Gagal terhubung ke server',
      };
    }
  }

  /// Update data sampah
  static Future<Map<String, dynamic>> updateWasteItem({
    required int id,
    String? type,
    double? weight,
    String? category,
    String? status,
    String? notes,
  }) async {
    try {
      final headers = await _getHeaders(withToken: true);

      final bodyMap = <String, dynamic>{};
      if (type != null) bodyMap['type'] = type.trim();
      if (weight != null) bodyMap['weight'] = weight;
      if (category != null) bodyMap['category'] = category;
      if (status != null) bodyMap['status'] = status;
      if (notes != null) bodyMap['notes'] = notes.trim();

      final response = await http
          .put(
            Uri.parse('$_baseUrl/reports/$id'),
            headers: headers,
            body: jsonEncode(bodyMap),
          )
          .timeout(
            const Duration(seconds: _timeout),
            onTimeout: () {
              throw Exception('Request timeout');
            },
          );

      final data = _parseResponse(response);

      if (response.statusCode == 200 && data['success'] == true) {
        return {
          'success': true,
          'message': data['message'] ?? 'Data sampah berhasil diperbarui',
          'waste_item': data['data'],
        };
      }

      return {
        'success': false,
        'message': data['message'] ?? _getErrorMessage(response.statusCode),
      };
    } catch (e) {
      debugPrint('Update waste item error: $e');
      return {
        'success': false,
        'message': 'Gagal terhubung ke server',
      };
    }
  }

  /// Hapus data sampah
  static Future<Map<String, dynamic>> deleteWasteItem(int id) async {
    try {
      final headers = await _getHeaders(withToken: true);

      final response = await http
          .delete(
            Uri.parse('$_baseUrl/waste/$id'),
            headers: headers,
          )
          .timeout(
            const Duration(seconds: _timeout),
            onTimeout: () {
              throw Exception('Request timeout');
            },
          );

      final data = _parseResponse(response);

      if (response.statusCode == 200 && data['success'] == true) {
        return {
          'success': true,
          'message': data['message'] ?? 'Data sampah berhasil dihapus',
        };
      }

      return {
        'success': false,
        'message': data['message'] ?? _getErrorMessage(response.statusCode),
      };
    } catch (e) {
      debugPrint('Delete waste item error: $e');
      return {
        'success': false,
        'message': 'Gagal terhubung ke server',
      };
    }
  }

  // ============================================================
  // STATISTICS API
  // ============================================================
  
  /// Ambil statistik dari database
  static Future<Map<String, dynamic>> getStatistics({String period = 'weekly'}) async {
    try {
      final headers = await _getHeaders(withToken: true);

      final response = await http
          .get(
            Uri.parse('$_baseUrl/statistics?period=$period'),
            headers: headers,
          )
          .timeout(
            const Duration(seconds: _timeout),
            onTimeout: () {
              throw Exception('Request timeout');
            },
          );

      final data = _parseResponse(response);

      if (response.statusCode == 200 && data['success'] == true) {
        return {
          'success': true,
          'statistics': data['data'] ?? {},
        };
      }

      return {
        'success': false,
        'message': data['message'] ?? 'Gagal mengambil statistik',
        'statistics': {},
      };
    } catch (e) {
      debugPrint('Get statistics error: $e');
      return {
        'success': false,
        'message': 'Gagal terhubung ke server',
        'statistics': {},
      };
    }
  }

  // ============================================================
  // TPS INFO API
  // ============================================================
  
  /// Ambil info TPS dari database
  static Future<Map<String, dynamic>> getTpsInfo() async {
    try {
      final headers = await _getHeaders(withToken: true);

      final response = await http
          .get(
            Uri.parse('$_baseUrl/tps'),
            headers: headers,
          )
          .timeout(
            const Duration(seconds: _timeout),
            onTimeout: () {
              throw Exception('Request timeout');
            },
          );

      final data = _parseResponse(response);

      if (response.statusCode == 200 && data['success'] == true) {
        return {
          'success': true,
          'tps_info': data['data'],
        };
      }

      return {
        'success': false,
        'message': data['message'] ?? 'Gagal mengambil info TPS',
        'tps_info': null,
      };
    } catch (e) {
      debugPrint('Get TPS info error: $e');
      return {
        'success': false,
        'message': 'Gagal terhubung ke server',
        'tps_info': null,
      };
    }
  }

  // ============================================================
  // WASTE REPORTS API
  // ============================================================
  
  /// Ambil laporan sampah dari database
  static Future<Map<String, dynamic>> getWasteReports() async {
    try {
      final headers = await _getHeaders(withToken: true);

      final response = await http
          .get(
            Uri.parse('$_baseUrl/reports'),
            headers: headers,
          )
          .timeout(
            const Duration(seconds: _timeout),
            onTimeout: () {
              throw Exception('Request timeout');
            },
          );

      final data = _parseResponse(response);

      if (response.statusCode == 200 && data['success'] == true) {
        return {
          'success': true,
          'reports': data['data'] ?? [],
        };
      }

      return {
        'success': false,
        'message': data['message'] ?? 'Gagal mengambil laporan',
        'reports': [],
      };
    } catch (e) {
      debugPrint('Get waste reports error: $e');
      return {
        'success': false,
        'message': 'Gagal terhubung ke server',
        'reports': [],
      };
    }
  }

  /// Kirim laporan sampah
  static Future<Map<String, dynamic>> createWasteReport({
    required String location,
    required String description,
    String? imageBase64,
  }) async {
    try {
      final headers = await _getHeaders(withToken: true);

      final response = await http
          .post(
            Uri.parse('$_baseUrl/reports'),
            headers: headers,
            body: jsonEncode({
              'location': location.trim(),
              'description': description.trim(),
              'image': imageBase64,
            }),
          )
          .timeout(
            const Duration(seconds: _timeout),
            onTimeout: () {
              throw Exception('Request timeout');
            },
          );

      final data = _parseResponse(response);

      if (response.statusCode == 201 || response.statusCode == 200) {
        return {
          'success': true,
          'message': data['message'] ?? 'Laporan berhasil dikirim',
          'report': data['data'],
        };
      }

      return {
        'success': false,
        'message': data['message'] ?? _getErrorMessage(response.statusCode),
      };
    } catch (e) {
      debugPrint('Create waste report error: $e');
      return {
        'success': false,
        'message': 'Gagal terhubung ke server',
      };
    }
  }

  // ============================================================
  // EDUKASI API
  // ============================================================

  /// Ambil data edukasi dari database
  /// [page] - untuk pagination (opsional)
  static Future<Map<String, dynamic>> getEdukasi({int page = 1}) async {
    try {
      // Untuk edukasi, tidak perlu auth token (route public)
      final headers = <String, String>{
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      };

      final url = page > 1
          ? '$_baseUrl/educations?page=$page'
          : '$_baseUrl/educations';

      final response = await http
          .get(
            Uri.parse(url),
            headers: headers,
          )
          .timeout(
            const Duration(seconds: _timeout),
            onTimeout: () {
              throw Exception('Request timeout');
            },
          );

      final data = _parseResponse(response);
      debugPrint('Edukasi API Response: $data');

      if (response.statusCode == 200) {
        return {
          'success': true,
          'edukasi': data,
        };
      }

      return {
        'success': false,
        'message': data['message'] ?? 'Gagal mengambil data edukasi',
        'edukasi': null,
      };
    } catch (e) {
      debugPrint('Get edukasi error: $e');
      return {
        'success': false,
        'message': 'Gagal terhubung ke server',
        'edukasi': null,
      };
    }
  }

  // ============================================================
  // HELPER FUNCTIONS
  // ============================================================
  
  static String _getErrorMessage(int statusCode) {
    switch (statusCode) {
      case 400:
        return 'Request tidak valid.';
      case 401:
        return 'Sesi habis. Silakan login ulang.';
      case 403:
        return 'Akses ditolak.';
      case 404:
        return 'Data tidak ditemukan.';
      case 422:
        return 'Validasi gagal. Periksa input Anda.';
      case 429:
        return 'Terlalu banyak percobaan. Tunggu beberapa saat.';
      case 500:
        return 'Server error. Silakan coba lagi.';
      default:
        return 'Terjadi kesalahan (code: $statusCode).';
    }
  }
  Future<bool> submitWasteReport({
    required List<int> photoBytes,
    required String photoName,
    required String location,
    required String category,
    required String description,
    required String token, // Token dari user yang login
  }) async {
    try {
      var uri = Uri.parse('$_baseUrl/reports');
      var request = http.MultipartRequest('POST', uri);
      
      // Tambahkan Header
      request.headers.addAll({
        'Authorization': 'Bearer $token',
        'Accept': 'application/json',
      });

      // Tambahkan Text Fields
      request.fields['location'] = location;
      request.fields['category'] = category;
      request.fields['description'] = description;

      // Tambahkan File Foto
      var photoFile = http.MultipartFile.fromBytes(
        'photo',
        photoBytes,
        filename: photoName,
      );
      request.files.add(photoFile);

      // Kirim Request
      var streamedResponse = await request.send();
      var response = await http.Response.fromStream(streamedResponse);

      if (response.statusCode == 201) {
        return true; // Berhasil
      } else {
        print('Gagal upload: ${response.body}');
        return false; // Gagal
      }
    } catch (e) {
      print('Error submit report: $e');
      return false;
    }
  }
}

