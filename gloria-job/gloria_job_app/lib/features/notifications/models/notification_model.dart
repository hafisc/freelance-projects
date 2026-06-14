// Model data untuk Notifikasi
class NotificationModel {
  final int id;
  final int userId;
  final String title;
  final String message;
  final bool isRead;
  final DateTime createdAt;

  NotificationModel({
    required this.id,
    required this.userId,
    required this.title,
    required this.message,
    required this.isRead,
    required this.createdAt,
  });

  // Konstruktor factory untuk memetakan JSON dari API Laravel menjadi NotificationModel
  factory NotificationModel.fromJson(Map<String, dynamic> json) {
    // Menangani casting field is_read yang bisa berupa boolean atau integer (1/0) dari MySQL
    final rawIsRead = json['is_read'];
    final isReadVal = rawIsRead == true || rawIsRead == 1 || rawIsRead == '1';

    return NotificationModel(
      id: json['id'] ?? 0,
      userId: json['user_id'] ?? 0,
      title: json['title'] ?? '',
      message: json['message'] ?? '',
      isRead: isReadVal,
      createdAt: json['created_at'] != null
          ? DateTime.parse(json['created_at'])
          : DateTime.now(),
    );
  }

  // Mengubah objek NotificationModel kembali ke JSON jika dibutuhkan
  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'user_id': userId,
      'title': title,
      'message': message,
      'is_read': isRead ? 1 : 0,
      'created_at': createdAt.toIso8601String(),
    };
  }
}
