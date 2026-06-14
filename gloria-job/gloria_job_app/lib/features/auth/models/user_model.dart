// Item pendidikan pencari kerja
class EducationItem {
  final String school;
  final String degree; // Contoh: SMA, D3, S1, S2, dll.
  final String period; // Contoh: 2018 - 2022
  final String? major;  // Contoh: Teknik Informatika

  EducationItem({
    required this.school,
    required this.degree,
    required this.period,
    this.major,
  });

  factory EducationItem.fromJson(Map<String, dynamic> json) {
    return EducationItem(
      school: json['school'] ?? '',
      degree: json['degree'] ?? '',
      period: json['period'] ?? '',
      major: json['major'],
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'school': school,
      'degree': degree,
      'period': period,
      'major': major,
    };
  }
}

// Item pengalaman kerja pencari kerja
class ExperienceItem {
  final String company;
  final String role;   // Contoh: Flutter Developer, Kasir, dll.
  final String period; // Contoh: 2022 - Sekarang
  final String? description;

  ExperienceItem({
    required this.company,
    required this.role,
    required this.period,
    this.description,
  });

  factory ExperienceItem.fromJson(Map<String, dynamic> json) {
    return ExperienceItem(
      company: json['company'] ?? '',
      role: json['role'] ?? '',
      period: json['period'] ?? '',
      description: json['description'],
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'company': company,
      'role': role,
      'period': period,
      'description': description,
    };
  }
}

// Model data User Pencari Kerja dengan profil lengkap
class UserModel {
  final int id;
  final String name;
  final String email;
  final String phone;
  final String? address;
  final String? cv;
  final String? summary;
  final List<String>? skills;
  final List<EducationItem>? education;
  final List<ExperienceItem>? experience;

  UserModel({
    required this.id,
    required this.name,
    required this.email,
    required this.phone,
    this.address,
    this.cv,
    this.summary,
    this.skills,
    this.education,
    this.experience,
  });

  factory UserModel.fromJson(Map<String, dynamic> json) {
    List<String>? parsedSkills;
    if (json['skills'] != null) {
      if (json['skills'] is String) {
        parsedSkills = (json['skills'] as String)
            .split(',')
            .map((e) => e.trim())
            .where((e) => e.isNotEmpty)
            .toList();
      } else if (json['skills'] is List) {
        parsedSkills = List<String>.from(json['skills']);
      }
    }

    List<EducationItem>? parsedEducation;
    if (json['education'] != null && json['education'] is List) {
      parsedEducation = (json['education'] as List)
          .map((e) => EducationItem.fromJson(Map<String, dynamic>.from(e)))
          .toList();
    }

    List<ExperienceItem>? parsedExperience;
    if (json['experience'] != null && json['experience'] is List) {
      parsedExperience = (json['experience'] as List)
          .map((e) => ExperienceItem.fromJson(Map<String, dynamic>.from(e)))
          .toList();
    }

    return UserModel(
      id: json['id'],
      name: json['name'] ?? '',
      email: json['email'] ?? '',
      phone: json['phone'] ?? '',
      address: json['address'],
      cv: json['cv'],
      summary: json['summary'],
      skills: parsedSkills,
      education: parsedEducation,
      experience: parsedExperience,
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'name': name,
      'email': email,
      'phone': phone,
      'address': address,
      'cv': cv,
      'summary': summary,
      'skills': skills,
      'education': education?.map((e) => e.toJson()).toList(),
      'experience': experience?.map((e) => e.toJson()).toList(),
    };
  }
}
