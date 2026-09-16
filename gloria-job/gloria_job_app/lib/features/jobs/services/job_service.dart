import 'dart:convert';
import '../../../core/constants/api_constants.dart';
import '../../../core/network/api_client.dart';
import '../models/job_model.dart';
import '../models/company_model.dart';

class JobService {
  final ApiClient _apiClient = ApiClient();

  // Mengambil daftar lowongan pekerjaan aktif dengan filter opsional
  Future<List<JobModel>> getJobs({String? salaryCategory}) async {
    try {
      String url = ApiConstants.jobs;
      if (salaryCategory != null && salaryCategory.isNotEmpty) {
        url += '?salary_category=${Uri.encodeComponent(salaryCategory)}';
      }
      final response = await _apiClient.get(url);
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

  // Mengambil daftar seluruh perusahaan mitra
  Future<List<CompanyModel>> getCompanies() async {
    try {
      final response = await _apiClient.get(ApiConstants.companies);
      final body = jsonDecode(response.body);

      if (response.statusCode == 200 && body['success'] == true) {
        final List<dynamic> data = body['data'];
        return data.map((json) => CompanyModel.fromJson(json)).toList();
      } else {
        throw Exception(body['message'] ?? 'Gagal memuat daftar perusahaan');
      }
    } catch (e) {
      throw Exception(e.toString().replaceAll('Exception: ', ''));
    }
  }

  // Mengambil detail perusahaan beserta lowongan aktifnya
  Future<CompanyModel> getCompanyDetail(int id) async {
    try {
      final response =
          await _apiClient.get('${ApiConstants.companies}/$id');
      final body = jsonDecode(response.body);

      if (response.statusCode == 200 && body['success'] == true) {
        return CompanyModel.fromJson(body['data']);
      } else {
        throw Exception(body['message'] ?? 'Perusahaan tidak ditemukan');
      }
    } catch (e) {
      throw Exception(e.toString().replaceAll('Exception: ', ''));
    }
  }
}
