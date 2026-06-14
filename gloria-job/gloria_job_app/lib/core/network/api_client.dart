import 'dart:convert';
import 'dart:developer';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import '../constants/api_constants.dart';

class ApiClient {
  final http.Client _client = http.Client();

  // Mendapatkan header default beserta token autentikasi jika tersedia
  Future<Map<String, String>> _getHeaders() async {
    final prefs = await SharedPreferences.getInstance();
    final token = prefs.getString('auth_token');

    final headers = {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    };

    if (token != null && token.isNotEmpty) {
      headers['Authorization'] = 'Bearer $token';
    }

    return headers;
  }

  // Melakukan HTTP GET Request
  Future<http.Response> get(String endpoint) async {
    final url = Uri.parse('${ApiConstants.baseUrl}$endpoint');
    final headers = await _getHeaders();

    log('API GET: $url');
    try {
      final response = await _client.get(url, headers: headers);
      log('API RESPONSE [${response.statusCode}]: ${response.body}');
      return response;
    } catch (e) {
      log('API ERROR GET: $e');
      rethrow;
    }
  }

  // Melakukan HTTP POST Request
  Future<http.Response> post(String endpoint, Map<String, dynamic> body) async {
    final url = Uri.parse('${ApiConstants.baseUrl}$endpoint');
    final headers = await _getHeaders();
    final jsonBody = jsonEncode(body);

    log('API POST: $url');
    log('API BODY: $jsonBody');
    try {
      final response = await _client.post(
        url,
        headers: headers,
        body: jsonBody,
      );
      log('API RESPONSE [${response.statusCode}]: ${response.body}');
      return response;
    } catch (e) {
      log('API ERROR POST: $e');
      rethrow;
    }
  }

  // Melakukan HTTP PUT Request
  Future<http.Response> put(String endpoint, [Map<String, dynamic>? body]) async {
    final url = Uri.parse('${ApiConstants.baseUrl}$endpoint');
    final headers = await _getHeaders();
    final jsonBody = body != null ? jsonEncode(body) : null;

    log('API PUT: $url');
    if (jsonBody != null) {
      log('API BODY: $jsonBody');
    }
    try {
      final response = await _client.put(
        url,
        headers: headers,
        body: jsonBody,
      );
      log('API RESPONSE [${response.statusCode}]: ${response.body}');
      return response;
    } catch (e) {
      log('API ERROR PUT: $e');
      rethrow;
    }
  }

  // Melakukan HTTP POST Multipart Request (untuk unggah berkas)
  Future<http.Response> postMultipart(
    String endpoint,
    Map<String, String> fields,
    String fileKey,
    String? filePath,
  ) async {
    final url = Uri.parse('${ApiConstants.baseUrl}$endpoint');
    final headers = await _getHeaders();

    // Hapus Content-Type default karena boundary multipart akan diatur otomatis
    headers.remove('Content-Type');

    log('API MULTIPART POST: $url');
    try {
      final request = http.MultipartRequest('POST', url);
      request.headers.addAll(headers);
      request.fields.addAll(fields);

      if (filePath != null && filePath.isNotEmpty) {
        request.files.add(await http.MultipartFile.fromPath(fileKey, filePath));
      }

      final streamedResponse = await request.send();
      final response = await http.Response.fromStream(streamedResponse);
      log('API RESPONSE [${response.statusCode}]: ${response.body}');
      return response;
    } catch (e) {
      log('API ERROR MULTIPART POST: $e');
      rethrow;
    }
  }
}
