// lib/models/edukasi_model.dart
// Model untuk data edukasi dari database (Laravel)

class EdukasiItem {
  final int id;
  final String title;
  final String slug;
  final String? thumbnail;
  final String content;
  final int? authorId;
  final String authorName;
  final String status;
  final DateTime createdAt;
  final DateTime updatedAt;

  EdukasiItem({
    required this.id,
    required this.title,
    required this.slug,
    this.thumbnail,
    required this.content,
    this.authorId,
    this.authorName = 'Admin',
    required this.status,
    required this.createdAt,
    required this.updatedAt,
  });

  /// URL lengkap thumbnail (dari Laravel accessor atau construite manual)
  String? get thumbnailUrl {
    if (thumbnail == null || thumbnail!.isEmpty) return null;
    // Jika sudah full URL (dari Laravel thumbnail_url accessor), gunakan langsung
    if (thumbnail!.startsWith('http://') || thumbnail!.startsWith('https://')) {
      return thumbnail;
    }
    // Jika hanya path, kembalikan path tersebut agar resolved secara dinamis oleh UI page
    return thumbnail;
  }

  /// Cek apakah published
  bool get isPublished => status == 'published';

  /// Cek apakah draft
  bool get isDraft => status == 'draft';

  factory EdukasiItem.fromJson(Map<String, dynamic> json) {
    return EdukasiItem(
      id: json['id'] ?? 0,
      title: json['title'] ?? '',
      slug: json['slug'] ?? '',
      thumbnail: json['thumbnail'],
      content: json['content'] ?? '',
      authorId: json['author_id'],
      authorName: json['author_name'] ?? json['author']?['name'] ?? 'Admin',
      status: json['status'] ?? 'draft',
      createdAt: json['created_at'] != null
          ? DateTime.parse(json['created_at'])
          : DateTime.now(),
      updatedAt: json['updated_at'] != null
          ? DateTime.parse(json['updated_at'])
          : DateTime.now(),
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'title': title,
      'slug': slug,
      'thumbnail': thumbnail,
      'content': content,
      'author_id': authorId,
      'status': status,
      'created_at': createdAt.toIso8601String(),
      'updated_at': updatedAt.toIso8601String(),
    };
  }
}

/// Model untuk response API edukasi
class EdukasiResponse {
  final bool success;
  final String? message;
  final List<EdukasiItem> data;
  final int currentPage;
  final int lastPage;
  final int total;

  EdukasiResponse({
    required this.success,
    this.message,
    this.data = const [],
    this.currentPage = 1,
    this.lastPage = 1,
    this.total = 0,
  });

  factory EdukasiResponse.fromJson(Map<String, dynamic> json) {
    List<EdukasiItem> items = [];

    // Handle jika data adalah array langsung (non-paginated)
    if (json['data'] is List) {
      items = (json['data'] as List)
          .map((item) => EdukasiItem.fromJson(item))
          .toList();
    }
    // Handle jika data ada di dalam 'data' (Laravel paginate response)
    else if (json['data'] is Map && json['data']['data'] != null) {
      final paginatedData = json['data']['data'] as List;
      items = paginatedData
          .map((item) => EdukasiItem.fromJson(item))
          .toList();

      return EdukasiResponse(
        success: json['success'] ?? true,
        message: json['message'],
        data: items,
        currentPage: json['data']['current_page'] ?? 1,
        lastPage: json['data']['last_page'] ?? 1,
        total: json['data']['total'] ?? 0,
      );
    }

    return EdukasiResponse(
      success: json['success'] ?? true,
      message: json['message'],
      data: items,
    );
  }
}
