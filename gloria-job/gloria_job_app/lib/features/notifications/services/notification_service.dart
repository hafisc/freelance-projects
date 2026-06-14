import 'dart:convert';
import '../../../core/constants/api_constants.dart';
import '../../../core/network/api_client.dart';
import '../models/notification_model.dart';

class NotificationService {
  final ApiClient _apiClient = ApiClient();

  // Mengambil daftar notifikasi milik pencari kerja
  Future<List<NotificationModel>> getNotifications() async {
    try {
      final response = await _apiClient.get(ApiConstants.notifications);
      final body = jsonDecode(response.body);

      if (response.statusCode == 200 && body['success'] == true) {
        final List<dynamic> data = body['data'];
        return data.map((json) => NotificationModel.fromJson(json)).toList();
      } else {
        throw Exception(body['message'] ?? 'Gagal mengambil notifikasi');
      }
    } catch (e) {
      throw Exception(e.toString().replaceAll('Exception: ', ''));
    }
  }

  // Menandai semua notifikasi sebagai telah dibaca
  Future<void> markAllAsRead() async {
    try {
      final response = await _apiClient.post(ApiConstants.notificationsMarkAllRead, {});
      final body = jsonDecode(response.body);

      if (response.statusCode != 200 || body['success'] != true) {
        throw Exception(body['message'] ?? 'Gagal menandai semua notifikasi sebagai dibaca');
      }
    } catch (e) {
      throw Exception(e.toString().replaceAll('Exception: ', ''));
    }
  }

  // Menandai satu notifikasi tertentu sebagai telah dibaca berdasarkan ID
  Future<void> markAsRead(int id) async {
    try {
      final response = await _apiClient.put('${ApiConstants.notifications}/$id/read');
      final body = jsonDecode(response.body);

      if (response.statusCode != 200 || body['success'] != true) {
        throw Exception(body['message'] ?? 'Gagal menandai notifikasi sebagai dibaca');
      }
    } catch (e) {
      throw Exception(e.toString().replaceAll('Exception: ', ''));
    }
  }
}
