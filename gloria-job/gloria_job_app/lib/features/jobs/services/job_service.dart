import 'dart:convert';
import '../../../core/constants/api_constants.dart';
import '../../../core/network/api_client.dart';
import '../models/job_model.dart';

class JobService {
  final ApiClient _apiClient = ApiClient();

  // Mengambil daftar lowongan pekerjaan aktif
  Future<List<JobModel>> getJobs() async {
    try {
      final response = await _apiClient.get(ApiConstants.jobs);
      final body = jsonDecode(response.body);

      if (response.statusCode == 200 && body['success'] == true) {
        final List<dynamic> data = body['data'];
        return data.map((json) => JobModel.fromJson(json)).toList();
      } else {
        throw Exception(body['message'] ?? 'Gagal memuat lowongan pekerjaan');
      }
    } catch (e) {
      throw Exception(e.toString().replaceAll('Exception: ', ''));
    }
  }

  // Mengambil detail lowongan pekerjaan berdasarkan ID
  Future<JobModel> getJobDetail(int id) async {
    try {
      final response = await _apiClient.get('${ApiConstants.jobs}/$id');
      final body = jsonDecode(response.body);

      if (response.statusCode == 200 && body['success'] == true) {
        return JobModel.fromJson(body['data']);
      } else {
        throw Exception(body['message'] ?? 'Lowongan tidak ditemukan');
      }
    } catch (e) {
      throw Exception(e.toString().replaceAll('Exception: ', ''));
    }
  }
}
