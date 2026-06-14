import 'dart:convert';
import '../../../core/constants/api_constants.dart';
import '../../../core/network/api_client.dart';
import '../models/application_model.dart';

class ApplicationService {
  final ApiClient _apiClient = ApiClient();

  // Mengirim lamaran pekerjaan baru ke backend
  Future<ApplicationModel> applyJob({
    required int jobId,
    required String fullName,
    required String email,
    required String phone,
    required String address,
    String? note,
  }) async {
    try {
      final response = await _apiClient.post(ApiConstants.applications, {
        'job_id': jobId,
        'full_name': fullName,
        'email': email,
        'phone': phone,
        'address': address,
        'note': note,
      });

      final body = jsonDecode(response.body);

      if ((response.statusCode == 201 || response.statusCode == 200) &&
          body['success'] == true) {
        return ApplicationModel.fromJson(body['data']);
      } else {
        throw Exception(body['message'] ?? 'Gagal mengirim lamaran pekerjaan');
      }
    } catch (e) {
      throw Exception(e.toString().replaceAll('Exception: ', ''));
    }
  }

  // Mengambil daftar lamaran (hasil lamaran) milik pencari kerja
  Future<List<ApplicationModel>> getMyApplications() async {
    try {
      final response = await _apiClient.get(ApiConstants.myResults);
      final body = jsonDecode(response.body);

      if (response.statusCode == 200 && body['success'] == true) {
        final List<dynamic> data = body['data'];
        return data.map((json) => ApplicationModel.fromJson(json)).toList();
      } else {
        throw Exception(body['message'] ?? 'Gagal mengambil riwayat lamaran');
      }
    } catch (e) {
      throw Exception(e.toString().replaceAll('Exception: ', ''));
    }
  }
}
