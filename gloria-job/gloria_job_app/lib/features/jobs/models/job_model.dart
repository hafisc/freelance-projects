import 'company_model.dart';

class JobModel {
  final int id;
  final String title;
  final String companyName;       // Legacy field (backward compat)
  final String companyDisplayName; // Computed: company?.name ?? company_name
  final int? companyId;
  final CompanyModel? company;    // Relasi perusahaan lengkap
  final String location;
  final String qualification;
  final String description;
  final String? deadline;
  final String status;
  final String jobType;
  final String category;
  final String experience;
  final String? salaryCategory;
  final int? salaryMin;
  final int? salaryMax;
  final String? salaryDisplay;    // Formatted salary string dari API

  JobModel({
    required this.id,
    required this.title,
    required this.companyName,
    required this.companyDisplayName,
    this.companyId,
    this.company,
    required this.location,
    required this.qualification,
    required this.description,
    this.deadline,
    required this.status,
    required this.jobType,
    required this.category,
    required this.experience,
    this.salaryCategory,
    this.salaryMin,
    this.salaryMax,
    this.salaryDisplay,
  });

  factory JobModel.fromJson(Map<String, dynamic> json) {
    // Parse company jika ada
    CompanyModel? company;
    if (json['company'] != null) {
      try {
        company = CompanyModel.fromJson(json['company']);
      } catch (_) {}
    }

    return JobModel(
      id: json['id'],
      title: json['title'] ?? '',
      companyName: json['company_name'] ?? '',
      companyDisplayName: json['company_display_name'] ??
          json['company']?['name'] ??
          json['company_name'] ??
          'PT. Gloria Jasa Mandiri',
      companyId: json['company_id'],
      company: company,
      location: json['location'] ?? '',
      qualification: json['qualification'] ?? '',
      description: json['description'] ?? '',
      deadline: json['deadline'],
      status: json['status'] ?? 'Aktif',
      jobType: json['job_type'] ?? '',
      category: json['category'] ?? '',
      experience: json['experience'] ?? '',
      salaryCategory: json['salary_category'],
      salaryMin: json['salary_min'] != null
          ? int.tryParse(json['salary_min'].toString())
          : null,
      salaryMax: json['salary_max'] != null
          ? int.tryParse(json['salary_max'].toString())
          : null,
      salaryDisplay: json['salary_display'],
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'title': title,
      'company_name': companyName,
      'company_id': companyId,
      'location': location,
      'qualification': qualification,
      'description': description,
      'deadline': deadline,
      'status': status,
      'job_type': jobType,
      'category': category,
      'experience': experience,
      'salary_category': salaryCategory,
      'salary_min': salaryMin,
      'salary_max': salaryMax,
    };
  }

  /// Mendapatkan string gaji yang tampil ke user
  String get formattedSalary {
    if (salaryDisplay != null && salaryDisplay!.isNotEmpty) {
      return salaryDisplay!;
    }
    if (salaryCategory == 'Negosiasi') return 'Negosiasi';
    if (salaryMin != null && salaryMax != null) {
      return 'Rp ${_formatNumber(salaryMin!)} - Rp ${_formatNumber(salaryMax!)}';
    }
    if (salaryMin != null) return '≥ Rp ${_formatNumber(salaryMin!)}';
    if (salaryMax != null) return '≤ Rp ${_formatNumber(salaryMax!)}';
    if (salaryCategory != null && salaryCategory!.isNotEmpty) {
      return salaryCategory!;
    }
    return '';
  }

  bool get hasSalaryInfo =>
      (salaryCategory != null && salaryCategory!.isNotEmpty) ||
      salaryMin != null ||
      salaryMax != null;

  String _formatNumber(int n) {
    // Format: 3.000.000
    return n.toString().replaceAllMapped(
          RegExp(r'(\d{1,3})(?=(\d{3})+(?!\d))'),
          (m) => '${m[1]}.',
        );
  }
}
