class JobModel {
  final int id;
  final String title;
  final String companyName;
  final String location;
  final String qualification;
  final String description;
  final String? deadline;
  final String status;
  final String jobType;
  final String category;
  final String experience;

  JobModel({
    required this.id,
    required this.title,
    required this.companyName,
    required this.location,
    required this.qualification,
    required this.description,
    this.deadline,
    required this.status,
    required this.jobType,
    required this.category,
    required this.experience,
  });

  factory JobModel.fromJson(Map<String, dynamic> json) {
    return JobModel(
      id: json['id'],
      title: json['title'] ?? '',
      companyName: json['company_name'] ?? '',
      location: json['location'] ?? '',
      qualification: json['qualification'] ?? '',
      description: json['description'] ?? '',
      deadline: json['deadline'],
      status: json['status'] ?? 'Aktif',
      jobType: json['job_type'] ?? '',
      category: json['category'] ?? '',
      experience: json['experience'] ?? '',
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'title': title,
      'company_name': companyName,
      'location': location,
      'qualification': qualification,
      'description': description,
      'deadline': deadline,
      'status': status,
      'job_type': jobType,
      'category': category,
      'experience': experience,
    };
  }
}
