import 'package:flutter/material.dart';
import '../../../app/theme.dart';
import '../../../core/helpers/ui_helper.dart';
import '../../../core/widgets/empty_state.dart';
import '../../../core/widgets/loading_view.dart';
import '../models/notification_model.dart';
import '../services/notification_service.dart';

class NotificationScreen extends StatefulWidget {
  const NotificationScreen({super.key});

  @override
  State<NotificationScreen> createState() => _NotificationScreenState();
}

class _NotificationScreenState extends State<NotificationScreen> {
  final NotificationService _notificationService = NotificationService();
  
  List<NotificationModel> _notifications = [];
  bool _isLoading = true;
  String? _errorMessage;

  @override
  void initState() {
    super.initState();
    _loadNotifications();
  }

  // Mengambil daftar notifikasi dari API
  Future<void> _loadNotifications() async {
    setState(() {
      _isLoading = _notifications.isEmpty; // Tampilkan loading screen hanya jika list kosong
      _errorMessage = null;
    });

    try {
      final data = await _notificationService.getNotifications();
      if (mounted) {
        setState(() {
          _notifications = data;
          _isLoading = false;
        });
      }
    } catch (e) {
      if (mounted) {
        setState(() {
          _errorMessage = e.toString();
          _isLoading = false;
        });
      }
    }
  }

  // Menandai satu notifikasi tertentu sebagai telah dibaca
  Future<void> _markAsRead(NotificationModel notification) async {
    if (notification.isRead) return;

    try {
      await _notificationService.markAsRead(notification.id);
      _loadNotifications(); // Refresh list setelah diupdate
    } catch (e) {
      if (mounted) {
        UiHelper.showSnackBar(
          context,
          'Gagal memperbarui status notifikasi: $e',
          backgroundColor: AppTheme.danger,
        );
      }
    }
  }

  // Menandai seluruh notifikasi sebagai telah dibaca
  Future<void> _markAllAsRead() async {
    final hasUnread = _notifications.any((n) => !n.isRead);
    if (!hasUnread) {
      UiHelper.showSnackBar(
        context,
        'Semua notifikasi sudah dibaca.',
        backgroundColor: AppTheme.primaryBlue,
        icon: Icons.info_outline_rounded,
      );
      return;
    }

    try {
      setState(() {
        _isLoading = true;
      });
      await _notificationService.markAllAsRead();
      await _loadNotifications();
      if (mounted) {
        UiHelper.showSnackBar(
          context,
          'Semua notifikasi berhasil ditandai sebagai dibaca.',
          backgroundColor: AppTheme.success,
          icon: Icons.check_circle_outline_rounded,
        );
      }
    } catch (e) {
      if (mounted) {
        setState(() {
          _isLoading = false;
        });
        UiHelper.showSnackBar(
          context,
          'Gagal menandai semua notifikasi: $e',
          backgroundColor: AppTheme.danger,
        );
      }
    }
  }

  // Fungsi untuk memformat tanggal notifikasi menjadi format yang ramah dibaca (human-friendly)
  String _formatDateTime(DateTime dateTime) {
    final localTime = dateTime.toLocal();
    final now = DateTime.now();
    final difference = now.difference(localTime);

    if (difference.inMinutes < 1) {
      return 'Baru saja';
    } else if (difference.inMinutes < 60) {
      return '${difference.inMinutes} menit yang lalu';
    } else if (difference.inHours < 24) {
      return '${difference.inHours} jam yang lalu';
    } else if (difference.inDays == 1) {
      return 'Kemarin';
    } else {
      final months = [
        'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
        'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'
      ];
      return '${localTime.day} ${months[localTime.month - 1]} ${localTime.year}';
    }
  }

  @override
  Widget build(BuildContext context) {
    final hasUnread = _notifications.any((n) => !n.isRead);

    return Scaffold(
      appBar: AppBar(
        title: const Text('Notifikasi'),
        backgroundColor: Colors.white,
        surfaceTintColor: Colors.white,
        elevation: 0,
        leading: IconButton(
          onPressed: () => Navigator.pop(context),
          icon: const Icon(Icons.arrow_back_ios_new_rounded, size: 18),
        ),
        actions: [
          if (_notifications.isNotEmpty)
            Padding(
              padding: const EdgeInsets.only(right: 8.0),
              child: TextButton.icon(
                onPressed: _markAllAsRead,
                icon: Icon(
                  Icons.done_all_rounded,
                  size: 18,
                  color: hasUnread ? AppTheme.primaryBlue : AppTheme.textSecondary,
                ),
                label: Text(
                  'Baca Semua',
                  style: TextStyle(
                    fontSize: 13,
                    fontWeight: FontWeight.bold,
                    color: hasUnread ? AppTheme.primaryBlue : AppTheme.textSecondary,
                  ),
                ),
              ),
            ),
        ],
      ),
      body: _isLoading
          ? const LoadingView(message: 'Memuat notifikasi Anda...')
          : _errorMessage != null
              ? Center(
                  child: Padding(
                    padding: const EdgeInsets.all(24.0),
                    child: Column(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        const Icon(Icons.error_outline_rounded, size: 48, color: AppTheme.danger),
                        const SizedBox(height: 16),
                        Text(
                          'Terjadi kesalahan:\n$_errorMessage',
                          textAlign: TextAlign.center,
                          style: const TextStyle(color: AppTheme.textSecondary),
                        ),
                        const SizedBox(height: 16),
                        ElevatedButton(
                          onPressed: _loadNotifications,
                          style: ElevatedButton.styleFrom(
                            minimumSize: const Size(150, 40),
                            padding: const EdgeInsets.symmetric(horizontal: 16),
                          ),
                          child: const Text('Coba Lagi'),
                        )
                      ],
                    ),
                  ),
                )
              : _notifications.isEmpty
                  ? const EmptyState(
                      title: 'Belum Ada Notifikasi',
                      description: 'Notifikasi tentang status lamaran atau info penting lainnya akan muncul di sini.',
                      icon: Icons.notifications_none_rounded,
                    )
                  : RefreshIndicator(
                      onRefresh: _loadNotifications,
                      color: AppTheme.primaryBlue,
                      backgroundColor: Colors.white,
                      child: ListView.builder(
                        padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 16),
                        physics: const AlwaysScrollableScrollPhysics(),
                        itemCount: _notifications.length,
                        itemBuilder: (context, index) {
                          final notification = _notifications[index];
                          return Padding(
                            padding: const EdgeInsets.only(bottom: 12.0),
                            child: AnimatedContainer(
                              duration: const Duration(milliseconds: 250),
                              decoration: BoxDecoration(
                                color: notification.isRead ? Colors.white : const Color(0xfff0f5ff),
                                borderRadius: BorderRadius.circular(20),
                                border: Border.all(
                                  color: notification.isRead ? const Color(0xffe2e8f0) : AppTheme.primaryBlue.withValues(alpha: 0.15),
                                  width: 1,
                                ),
                                boxShadow: [
                                  BoxShadow(
                                    color: Colors.black.withValues(alpha: notification.isRead ? 0.02 : 0.04),
                                    blurRadius: 10,
                                    offset: const Offset(0, 4),
                                  )
                                ],
                              ),
                              child: Material(
                                color: Colors.transparent,
                                borderRadius: BorderRadius.circular(20),
                                child: InkWell(
                                  onTap: () => _markAsRead(notification),
                                  borderRadius: BorderRadius.circular(20),
                                  child: Padding(
                                    padding: const EdgeInsets.all(16.0),
                                    child: Row(
                                      crossAxisAlignment: CrossAxisAlignment.start,
                                      children: [
                                        // Lingkaran Ikon Notifikasi (Berbeda warna berdasarkan status baca)
                                        Container(
                                          padding: const EdgeInsets.all(10),
                                          decoration: BoxDecoration(
                                            color: notification.isRead
                                                ? const Color(0xfff1f5f9)
                                                : AppTheme.primaryBlue.withValues(alpha: 0.1),
                                            shape: BoxShape.circle,
                                          ),
                                          child: Icon(
                                            notification.title.contains('Diterima')
                                                ? Icons.check_circle_rounded
                                                : notification.title.contains('Ditolak')
                                                    ? Icons.cancel_rounded
                                                    : Icons.notifications_active_rounded,
                                            size: 20,
                                            color: notification.title.contains('Diterima')
                                                ? AppTheme.success
                                                : notification.title.contains('Ditolak')
                                                    ? AppTheme.danger
                                                    : AppTheme.primaryBlue,
                                          ),
                                        ),
                                        const SizedBox(width: 16),
                                        // Detail Judul dan Pesan Notifikasi
                                        Expanded(
                                          child: Column(
                                            crossAxisAlignment: CrossAxisAlignment.start,
                                            children: [
                                              Row(
                                                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                                children: [
                                                  Expanded(
                                                    child: Text(
                                                      notification.title,
                                                      style: TextStyle(
                                                        fontWeight: notification.isRead
                                                            ? FontWeight.w600
                                                            : FontWeight.bold,
                                                        fontSize: 15,
                                                        color: AppTheme.textPrimary,
                                                      ),
                                                    ),
                                                  ),
                                                  if (!notification.isRead)
                                                    Container(
                                                      width: 8,
                                                      height: 8,
                                                      margin: const EdgeInsets.only(left: 8),
                                                      decoration: const BoxDecoration(
                                                        color: AppTheme.primaryBlue,
                                                        shape: BoxShape.circle,
                                                      ),
                                                    ),
                                                ],
                                              ),
                                              const SizedBox(height: 6),
                                              Text(
                                                notification.message,
                                                style: const TextStyle(
                                                  fontSize: 13,
                                                  color: AppTheme.textSecondary,
                                                  height: 1.4,
                                                ),
                                              ),
                                              const SizedBox(height: 10),
                                              // Penanda Waktu Terkirim
                                              Text(
                                                _formatDateTime(notification.createdAt),
                                                style: const TextStyle(
                                                  fontSize: 11,
                                                  fontWeight: FontWeight.w500,
                                                  color: AppTheme.textSecondary,
                                                ),
                                              ),
                                            ],
                                          ),
                                        ),
                                      ],
                                    ),
                                  ),
                                ),
                              ),
                            ),
                          );
                        },
                      ),
                    ),
    );
  }
}
