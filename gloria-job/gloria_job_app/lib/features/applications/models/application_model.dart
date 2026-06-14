import '../../jobs/models/job_model.dart';

class ApplicationModel {
  final int id;
  final int userId;
  final int jobId;
  final String fullName;
  final String email;
  final String phone;
  final String address;
  final String? note;
  final String status;
  final String? adminNote;
  final String createdAt;
  final JobModel? job;

  ApplicationModel({
    required this.id,
    required this.userId,
    required this.jobId,
    required this.fullName,
    required this.email,
    required this.phone,
    required this.address,
    this.note,
    required this.status,
    this.adminNote,
    required this.createdAt,
    this.job,
  });

  factory ApplicationModel.fromJson(Map<String, dynamic> json) {
    return ApplicationModel(
      id: json['id'],
      userId: json['user_id'],
      jobId: json['job_id'],
      fullName: json['full_name'] ?? '',
      email: json['email'] ?? '',
      phone: json['phone'] ?? '',
      address: json['address'] ?? '',
      note: json['note'],
      status: json['status'] ?? 'Menunggu',
      adminNote: json['admin_note'],
      createdAt: json['created_at'] ?? '',
      job: json['job'] != null ? JobModel.fromJson(json['job']) : null,
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'user_id': userId,
      'job_id': jobId,
      'full_name': fullName,
      'email': email,
      'phone': phone,
      'address': address,
      'note': note,
      'status': status,
      'admin_note': adminNote,
      'created_at': createdAt,
      'job': job?.toJson(),
    };
  }
}
