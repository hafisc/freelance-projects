import 'dart:ui';
import 'package:flutter/material.dart';
import '../../../app/theme.dart';
import '../../../app/routes.dart';
import '../../../core/helpers/format_helper.dart';
import '../../../core/helpers/ui_helper.dart';
import '../models/job_model.dart';
import '../../auth/models/user_model.dart';
import '../../auth/services/auth_service.dart';
import '../../applications/services/application_service.dart';
import '../../applications/models/application_model.dart';

class JobDetailScreen extends StatefulWidget {
  final JobModel job;

  const JobDetailScreen({super.key, required this.job});

  @override
  State<JobDetailScreen> createState() => _JobDetailScreenState();
}

class _JobDetailScreenState extends State<JobDetailScreen> {
  final AuthService _authService = AuthService();
  final ApplicationService _applicationService = ApplicationService();

  UserModel? _currentUser;
  ApplicationModel? _existingApplication;
  bool _isLoading = true;
  bool _isSubmitting = false;

  @override
  void initState() {
    super.initState();
    _loadData();
  }

  // Fungsi untuk memuat profil pengguna dan riwayat lamarannya
  Future<void> _loadData() async {
    if (!mounted) return;
    setState(() {
      _isLoading = true;
    });

    try {
      UserModel? user = await _authService.getCachedUser();
      try {
        final freshUser = await _authService.getProfile();
        user = freshUser;
      } catch (profileError) {
        debugPrint('Gagal mengambil profil segar dari API: $profileError');
      }
      _currentUser = user;

      if (user != null) {
        final apps = await _applicationService.getMyApplications();
        final match = apps.where((app) => app.jobId == widget.job.id);
        if (match.isNotEmpty) {
          _existingApplication = match.first;
        } else {
          _existingApplication = null;
        }
      }
    } catch (e) {
      debugPrint('Gagal memuat status lamaran: $e');
    } finally {
      if (mounted) {
        setState(() {
          _isLoading = false;
        });
      }
    }
  }

  // Menangani penekanan tombol Lamar
  Future<void> _handleApply() async {
    final hasCv = _currentUser?.cv != null && _currentUser!.cv!.isNotEmpty;

    if (!hasCv) {
      // Tampilkan dialog peringatan untuk melengkapi profil & unggah CV
      showDialog(
        context: context,
        builder: (BuildContext context) {
          return AlertDialog(
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(20),
            ),
            title: const Row(
              children: [
                Icon(Icons.warning_amber_rounded, color: AppTheme.danger, size: 28),
                SizedBox(width: 8),
                Text('Lengkapi Profil Anda'),
              ],
            ),
            content: const Text(
              'Anda wajib melengkapi profil dan mengunggah berkas CV (PDF) terlebih dahulu sebelum dapat melamar pekerjaan ini.',
            ),
            actions: [
              TextButton(
                onPressed: () => Navigator.pop(context),
                child: const Text(
                  'Batal',
                  style: TextStyle(color: AppTheme.textSecondary),
                ),
              ),
              ElevatedButton(
                onPressed: () {
                  Navigator.pop(context);
                  Navigator.pushNamedAndRemoveUntil(
                    context,
                    AppRoutes.main,
                    (route) => false,
                    arguments: 2, // Navigasi langsung ke Tab Profil (index 2)
                  );
                },
                style: ElevatedButton.styleFrom(
                  backgroundColor: AppTheme.primaryBlue,
                  foregroundColor: Colors.white,
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(12),
                  ),
                ),
                child: const Text('Ke Profil Saya'),
              ),
            ],
          );
        },
      );
      return;
    }

    // Tampilkan dialog konfirmasi melamar instan
    showDialog(
      context: context,
      builder: (BuildContext context) {
        return AlertDialog(
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(20),
          ),
          title: const Row(
            children: [
              Icon(Icons.assignment_turned_in_rounded, color: AppTheme.primaryBlue, size: 28),
              SizedBox(width: 8),
              Text('Konfirmasi Lamaran'),
            ],
          ),
          content: RichText(
            text: TextSpan(
              style: const TextStyle(color: AppTheme.textPrimary, fontSize: 14, height: 1.5),
              children: [
                const TextSpan(text: 'Apakah Anda yakin ingin mengirim lamaran untuk posisi '),
                TextSpan(
                  text: widget.job.title,
                  style: const TextStyle(fontWeight: FontWeight.bold, color: AppTheme.primaryBlue),
                ),
                const TextSpan(text: ' di '),
                TextSpan(
                  text: '${widget.job.companyName}?\n\n',
                  style: const TextStyle(fontWeight: FontWeight.bold),
                ),
                const TextSpan(
                  text: 'Data diri lengkap beserta dokumen CV Anda yang terdaftar di profil akan otomatis dikirimkan.',
                  style: TextStyle(color: AppTheme.textSecondary, fontSize: 13),
                ),
              ],
            ),
          ),
          actions: [
            TextButton(
              onPressed: () => Navigator.pop(context),
              child: const Text(
                'Batal',
                style: TextStyle(color: AppTheme.textSecondary),
              ),
            ),
            ElevatedButton(
              onPressed: () {
                Navigator.pop(context);
                _submitApplication();
              },
              style: ElevatedButton.styleFrom(
                backgroundColor: AppTheme.primaryBlue,
                foregroundColor: Colors.white,
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(12),
                ),
              ),
              child: const Text('Kirim Lamaran'),
            ),
          ],
        );
      },
    );
  }

  // Kirim data lamaran ke API Laravel
  Future<void> _submitApplication() async {
    if (_currentUser == null) return;

    setState(() {
      _isSubmitting = true;
    });

    try {
      await _applicationService.applyJob(
        jobId: widget.job.id,
        fullName: _currentUser!.name,
        email: _currentUser!.email,
        phone: _currentUser!.phone,
        address: _currentUser!.address ?? 'Belum diisi',
        note: null, // Tanpa catatan tambahan untuk alur lamaran instan
      );

      if (!mounted) return;

      // Berhasil terkirim, tampilkan dialog sukses
      showDialog(
        context: context,
        barrierDismissible: false,
        builder: (BuildContext context) {
          return AlertDialog(
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(20),
            ),
            title: const Row(
              children: [
                Icon(Icons.check_circle_rounded, color: AppTheme.success, size: 28),
                SizedBox(width: 8),
                Text('Berhasil Terkirim'),
              ],
            ),
            content: const Text(
              'Lamaran Anda telah berhasil dikirim. Anda dapat memantau status lamaran ini secara berkala di menu Hasil Lamaran atau langsung dari halaman detail ini.',
            ),
            actions: [
              TextButton(
                onPressed: () {
                  Navigator.pop(context);
                  _loadData(); // Memuat ulang data lamaran terbaru agar status tombol terupdate
                },
                child: const Text(
                  'OK',
                  style: TextStyle(fontWeight: FontWeight.bold, color: AppTheme.primaryBlue),
                ),
              ),
            ],
          );
        },
      );
    } catch (e) {
      if (!mounted) return;
      UiHelper.showSnackBar(context, e.toString(), isSuccess: false);
    } finally {
      if (mounted) {
        setState(() {
          _isSubmitting = false;
        });
      }
    }
  }

  Widget _buildQualificationList(String text) {
    final items = text
        .split('\n')
        .where((item) => item.trim().isNotEmpty)
        .toList();
    if (items.isEmpty) return const SizedBox.shrink();

    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(24),
        boxShadow: [
          BoxShadow(
            color: const Color(0xff0f172a).withOpacity(0.03),
            blurRadius: 20,
            offset: const Offset(0, 8),
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: items.map((item) {
          // Bersihkan prefix angka seperti "1. " atau "2. "
          var cleanItem = item.trim();
          final numRegExp = RegExp(r'^\d+[\.\)\s\-]+');
          if (numRegExp.hasMatch(cleanItem)) {
            cleanItem = cleanItem.replaceFirst(numRegExp, '');
          }

          return Padding(
            padding: const EdgeInsets.only(bottom: 12.0),
            child: Row(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Container(
                  margin: const EdgeInsets.only(top: 3),
                  padding: const EdgeInsets.all(4),
                  decoration: BoxDecoration(
                    color: AppTheme.primaryBlue.withOpacity(0.1),
                    shape: BoxShape.circle,
                  ),
                  child: const Icon(
                    Icons.check_rounded,
                    color: AppTheme.primaryBlue,
                    size: 10,
                  ),
                ),
                const SizedBox(width: 12),
                Expanded(
                  child: Text(
                    cleanItem,
                    style: const TextStyle(
                      fontSize: 14,
                      color: AppTheme.textPrimary,
                      height: 1.5,
                    ),
                  ),
                ),
              ],
            ),
          );
        }).toList(),
      ),
    );
  }

  Widget _buildInfoChip(IconData icon, String label, Color textColor, Color bgColor) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 8),
      decoration: BoxDecoration(
        color: bgColor,
        borderRadius: BorderRadius.circular(12),
      ),
      child: Row(
        mainAxisSize: MainAxisSize.min,
        children: [
          Icon(icon, size: 14, color: textColor),
          const SizedBox(width: 6),
          Text(
            label,
            style: TextStyle(
              fontSize: 12,
              color: textColor,
              fontWeight: FontWeight.bold,
            ),
          ),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    // Tombol aksi diatur secara dinamis berdasarkan status lamaran
    Widget actionButton;
    
    if (_isLoading) {
      actionButton = ElevatedButton(
        onPressed: null,
        style: ElevatedButton.styleFrom(
          backgroundColor: AppTheme.textSecondary.withOpacity(0.1),
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(16),
          ),
        ),
        child: const SizedBox(
          width: 20,
          height: 20,
          child: CircularProgressIndicator(
            strokeWidth: 2,
            valueColor: AlwaysStoppedAnimation<Color>(AppTheme.primaryBlue),
          ),
        ),
      );
    } else if (_existingApplication != null) {
      final status = _existingApplication!.status;
      Color btnColor;
      IconData icon;
      String text;

      switch (status) {
        case 'Menunggu':
          btnColor = Colors.grey;
          icon = Icons.hourglass_empty_rounded;
          text = 'Sudah Dilamar (Menunggu)';
          break;
        case 'Diproses':
          btnColor = Colors.orange;
          icon = Icons.sync_rounded;
          text = 'Lamaran Sedang Diproses';
          break;
        case 'Diterima':
          btnColor = AppTheme.success;
          icon = Icons.check_circle_rounded;
          text = 'Selamat! Lamaran Diterima 🎉';
          break;
        case 'Ditolak':
          btnColor = AppTheme.danger;
          icon = Icons.cancel_rounded;
          text = 'Lamaran Ditolak';
          break;
        default:
          btnColor = Colors.grey;
          icon = Icons.info_outline_rounded;
          text = 'Status: $status';
      }

      actionButton = ElevatedButton(
        onPressed: null, // Dinonaktifkan karena sudah melamar
        style: ElevatedButton.styleFrom(
          backgroundColor: btnColor.withOpacity(0.12),
          foregroundColor: btnColor,
          elevation: 0,
          disabledBackgroundColor: btnColor.withOpacity(0.12),
          disabledForegroundColor: btnColor,
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(16),
          ),
        ),
        child: Row(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Icon(icon, size: 20, color: btnColor),
            const SizedBox(width: 8),
            Text(
              text,
              style: TextStyle(fontWeight: FontWeight.bold, color: btnColor),
            ),
          ],
        ),
      );
    } else {
      actionButton = ElevatedButton(
        onPressed: _isSubmitting ? null : _handleApply,
        style: ElevatedButton.styleFrom(
          backgroundColor: AppTheme.primaryBlue,
          foregroundColor: Colors.white,
          elevation: 0,
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(16),
          ),
        ),
        child: Row(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            _isSubmitting
                ? const SizedBox(
                    width: 20,
                    height: 20,
                    child: CircularProgressIndicator(
                      strokeWidth: 2,
                      valueColor: AlwaysStoppedAnimation<Color>(Colors.white),
                    ),
                  )
                : const Icon(Icons.send_rounded, size: 20),
            const SizedBox(width: 8),
            Text(_isSubmitting ? 'Mengirim...' : 'Lamar Sekarang'),
          ],
        ),
      );
    }

    return Scaffold(
      backgroundColor: AppTheme.background,
      appBar: AppBar(
        leading: IconButton(
          icon: const Icon(Icons.arrow_back_ios_new_rounded, size: 20),
          onPressed: () => Navigator.pop(context),
        ),
        title: const Text('Detail Lowongan'),
        backgroundColor: Colors.transparent,
      ),
      extendBodyBehindAppBar: false,
      body: Stack(
        children: [
          // Scrollable Content
          SingleChildScrollView(
            padding: const EdgeInsets.fromLTRB(24, 16, 24, 110),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                // Main Header Card
                Container(
                  width: double.infinity,
                  padding: const EdgeInsets.all(24),
                  decoration: BoxDecoration(
                    color: Colors.white,
                    borderRadius: BorderRadius.circular(24),
                    boxShadow: [
                      BoxShadow(
                        color: const Color(0xff0f172a).withOpacity(0.03),
                        blurRadius: 20,
                        offset: const Offset(0, 8),
                      ),
                    ],
                  ),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Container(
                        padding: const EdgeInsets.symmetric(
                          horizontal: 12,
                          vertical: 6,
                        ),
                        decoration: BoxDecoration(
                          color: AppTheme.primaryBlue.withOpacity(0.08),
                          borderRadius: BorderRadius.circular(8),
                        ),
                        child: const Text(
                          'Mitra Resmi GJM',
                          style: TextStyle(
                            fontSize: 11,
                            color: AppTheme.primaryBlue,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                      ),
                      const SizedBox(height: 16),
                      Text(
                        widget.job.title,
                        style: const TextStyle(
                          fontSize: 22,
                          fontWeight: FontWeight.bold,
                          color: AppTheme.textPrimary,
                          letterSpacing: -0.5,
                          height: 1.25,
                        ),
                      ),
                      const SizedBox(height: 6),
                      Text(
                        widget.job.companyName,
                        style: const TextStyle(
                          fontSize: 15,
                          fontWeight: FontWeight.w600,
                          color: AppTheme.textSecondary,
                        ),
                      ),
                      const SizedBox(height: 16),
                      Wrap(
                        spacing: 8,
                        runSpacing: 8,
                        children: [
                          if (widget.job.jobType.isNotEmpty)
                            _buildInfoChip(
                              Icons.work_outline_rounded,
                              widget.job.jobType,
                              AppTheme.primaryBlue,
                              AppTheme.primaryBlue.withOpacity(0.08),
                            ),
                          if (widget.job.experience.isNotEmpty)
                            _buildInfoChip(
                              Icons.stars_outlined,
                              widget.job.experience,
                              const Color(0xff16a34a),
                              const Color(0xfff0fdf4),
                            ),
                          if (widget.job.category.isNotEmpty)
                            _buildInfoChip(
                              Icons.category_outlined,
                              widget.job.category,
                              const Color(0xff0d9488),
                              const Color(0xfff0fdfa),
                            ),
                        ],
                      ),
                      const SizedBox(height: 20),
                      const Divider(color: Color(0xfff1f5f9), height: 1),
                      const SizedBox(height: 16),
                      // Meta Info Row
                      Row(
                        children: [
                          const Icon(
                            Icons.location_on_rounded,
                            color: AppTheme.primaryBlue,
                            size: 18,
                          ),
                          const SizedBox(width: 6),
                          Text(
                            widget.job.location,
                            style: const TextStyle(
                              fontSize: 13,
                              color: AppTheme.textPrimary,
                              fontWeight: FontWeight.bold,
                            ),
                          ),
                          const Spacer(),
                          const Icon(
                            Icons.calendar_month_rounded,
                            color: AppTheme.textSecondary,
                            size: 18,
                          ),
                          const SizedBox(width: 6),
                          Text(
                            FormatHelper.formatDate(widget.job.deadline),
                            style: const TextStyle(
                              fontSize: 13,
                              color: AppTheme.textSecondary,
                              fontWeight: FontWeight.w600,
                            ),
                          ),
                        ],
                      ),
                    ],
                  ),
                ),
                const SizedBox(height: 24),

                // Persyaratan Kualifikasi
                Row(
                  children: [
                    Container(
                      width: 4,
                      height: 16,
                      decoration: BoxDecoration(
                        color: AppTheme.primaryBlue,
                        borderRadius: BorderRadius.circular(2),
                      ),
                    ),
                    const SizedBox(width: 8),
                    const Text(
                      'Persyaratan Kualifikasi',
                      style: TextStyle(
                        fontSize: 16,
                        fontWeight: FontWeight.bold,
                        color: AppTheme.textPrimary,
                      ),
                    ),
                  ],
                ),
                const SizedBox(height: 12),
                _buildQualificationList(widget.job.qualification),
                const SizedBox(height: 24),

                // Deskripsi Pekerjaan
                Row(
                  children: [
                    Container(
                      width: 4,
                      height: 16,
                      decoration: BoxDecoration(
                        color: AppTheme.primaryBlue,
                        borderRadius: BorderRadius.circular(2),
                      ),
                    ),
                    const SizedBox(width: 8),
                    const Text(
                      'Deskripsi Pekerjaan',
                      style: TextStyle(
                        fontSize: 16,
                        fontWeight: FontWeight.bold,
                        color: AppTheme.textPrimary,
                      ),
                    ),
                  ],
                ),
                const SizedBox(height: 12),
                Container(
                  width: double.infinity,
                  padding: const EdgeInsets.all(24),
                  decoration: BoxDecoration(
                    color: Colors.white,
                    borderRadius: BorderRadius.circular(24),
                    boxShadow: [
                      BoxShadow(
                        color: const Color(0xff0f172a).withOpacity(0.03),
                        blurRadius: 20,
                        offset: const Offset(0, 8),
                      ),
                    ],
                  ),
                  child: Text(
                    widget.job.description,
                    style: const TextStyle(
                      fontSize: 14,
                      color: AppTheme.textPrimary,
                      height: 1.6,
                    ),
                  ),
                ),
              ],
            ),
          ),

          // Bottom Action Button Wrapper with Glassmorphic Backdrop
          Positioned(
            bottom: 0,
            left: 0,
            right: 0,
            child: ClipRect(
              child: BackdropFilter(
                filter: ImageFilter.blur(sigmaX: 12, sigmaY: 12),
                child: Container(
                  padding: const EdgeInsets.fromLTRB(24, 16, 24, 24),
                  decoration: BoxDecoration(
                    color: Colors.white.withOpacity(0.85),
                    border: Border(
                      top: BorderSide(
                        color: Colors.white.withOpacity(0.4),
                        width: 1.5,
                      ),
                    ),
                  ),
                  child: SafeArea(
                    top: false,
                    child: actionButton,
                  ),
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }
}
