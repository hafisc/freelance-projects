import 'package:flutter/material.dart';
import '../../../app/theme.dart';
import '../../../app/routes.dart';
import '../../../core/widgets/app_button.dart';
import '../../../core/widgets/app_text_field.dart';
import '../../../core/helpers/ui_helper.dart';
import '../../auth/models/user_model.dart';
import '../../auth/services/auth_service.dart';
import '../../jobs/models/job_model.dart';
import '../services/application_service.dart';

class ApplyJobScreen extends StatefulWidget {
  final JobModel job;

  const ApplyJobScreen({super.key, required this.job});

  @override
  State<ApplyJobScreen> createState() => _ApplyJobScreenState();
}

class _ApplyJobScreenState extends State<ApplyJobScreen> {
  final _formKey = GlobalKey<FormState>();
  final _fullNameController = TextEditingController();
  final _emailController = TextEditingController();
  final _phoneController = TextEditingController();
  final _addressController = TextEditingController();
  final _noteController = TextEditingController();

  final AuthService _authService = AuthService();
  final ApplicationService _applicationService = ApplicationService();
  bool _isLoading = false;
  UserModel? _currentUser;

  bool get _hasCv => _currentUser?.cv != null && _currentUser!.cv!.isNotEmpty;
  String? get _cvFilename => _currentUser?.cv?.split('/').last;

  @override
  void initState() {
    super.initState();
    _loadUserProfile();
  }

  void _loadUserProfile() async {
    final user = await _authService.getCachedUser();
    if (user != null) {
      setState(() {
        _currentUser = user;
        _fullNameController.text = user.name;
        _emailController.text = user.email;
        _phoneController.text = user.phone;
        _addressController.text = user.address ?? '';
        _noteController.text =
            ''; // Mengosongkan catatan tambahan agar user bisa mengisinya opsional
      });
    }
  }

  @override
  void dispose() {
    _fullNameController.dispose();
    _emailController.dispose();
    _phoneController.dispose();
    _addressController.dispose();
    _noteController.dispose();
    super.dispose();
  }

  Future<void> _handleSubmit() async {
    if (!_formKey.currentState!.validate()) return;

    setState(() {
      _isLoading = true;
    });

    try {
      await _applicationService.applyJob(
        jobId: widget.job.id,
        fullName: _fullNameController.text.trim(),
        email: _emailController.text.trim(),
        phone: _phoneController.text.trim(),
        address: _addressController.text.trim(),
        note: _noteController.text.trim().isEmpty
            ? null
            : _noteController.text.trim(),
      );

      if (!mounted) return;

      // Tampilkan dialog sukses
      showDialog(
        context: context,
        barrierDismissible: false,
        builder: (BuildContext context) {
          return AlertDialog(
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(16),
            ),
            title: const Row(
              children: [
                Icon(Icons.check_circle, color: AppTheme.success, size: 28),
                SizedBox(width: 8),
                Text('Kirim Berhasil'),
              ],
            ),
            content: const Text(
              'Lamaran Anda telah berhasil dikirim ke PT. Gloria Jasa Mandiri. Silakan cek berkala status lamaran Anda pada menu Hasil Lamaran.',
            ),
            actions: [
              TextButton(
                onPressed: () {
                  Navigator.of(context).pop(); // Tutup Dialog
                  // Reset stack ke Halaman Utama
                  Navigator.pushNamedAndRemoveUntil(
                    context,
                    AppRoutes.main,
                    (route) => false,
                  );
                },
                child: const Text(
                  'OK',
                  style: TextStyle(
                    fontWeight: FontWeight.bold,
                    color: AppTheme.primaryBlue,
                  ),
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
          _isLoading = false;
        });
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white,
      appBar: AppBar(
        leading: IconButton(
          icon: const Icon(Icons.arrow_back_ios_new_rounded, size: 20),
          onPressed: () => Navigator.pop(context),
        ),
        title: const Text('Formulir Lamaran'),
        backgroundColor: Colors.transparent,
      ),
      body: SafeArea(
        child: SingleChildScrollView(
          padding: const EdgeInsets.all(24.0),
          child: Form(
            key: _formKey,
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                // Info lowongan yang dilamar (Sleek Borderless Card)
                Container(
                  width: double.infinity,
                  padding: const EdgeInsets.all(20),
                  decoration: BoxDecoration(
                    color: const Color(0xfff1f5f9),
                    borderRadius: BorderRadius.circular(20),
                  ),
                  child: Row(
                    children: [
                      Container(
                        padding: const EdgeInsets.all(12),
                        decoration: BoxDecoration(
                          color: AppTheme.primaryBlue.withOpacity(0.08),
                          borderRadius: BorderRadius.circular(14),
                        ),
                        child: const Icon(
                          Icons.work_rounded,
                          color: AppTheme.primaryBlue,
                          size: 24,
                        ),
                      ),
                      const SizedBox(width: 16),
                      Expanded(
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            const Text(
                              'Melamar Posisi:',
                              style: TextStyle(
                                fontSize: 11,
                                color: AppTheme.textSecondary,
                                fontWeight: FontWeight.bold,
                                letterSpacing: 0.5,
                              ),
                            ),
                            const SizedBox(height: 4),
                            Text(
                              widget.job.title,
                              style: const TextStyle(
                                fontSize: 16,
                                fontWeight: FontWeight.bold,
                                color: AppTheme.textPrimary,
                                height: 1.25,
                              ),
                            ),
                            const SizedBox(height: 2),
                            Text(
                              widget.job.companyName,
                              style: const TextStyle(
                                fontSize: 13,
                                color: AppTheme.textSecondary,
                                fontWeight: FontWeight.w600,
                              ),
                            ),
                          ],
                        ),
                      ),
                    ],
                  ),
                ),
                const SizedBox(height: 32),

                // Section Title: Data Diri
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
                      'Data Diri Pelamar',
                      style: TextStyle(
                        fontSize: 16,
                        fontWeight: FontWeight.bold,
                        color: AppTheme.textPrimary,
                      ),
                    ),
                  ],
                ),
                const SizedBox(height: 20),

                // Full Name
                AppTextField(
                  label: 'Nama Lengkap',
                  controller: _fullNameController,
                  hintText: 'Nama lengkap sesuai KTP',
                  prefixIcon: Icons.person_outline_rounded,
                  validator: (value) {
                    if (value == null || value.trim().isEmpty) {
                      return 'Nama lengkap wajib diisi';
                    }
                    return null;
                  },
                ),
                const SizedBox(height: 20),

                // Email
                AppTextField(
                  label: 'Email',
                  controller: _emailController,
                  hintText: 'nama@gmail.com',
                  prefixIcon: Icons.email_outlined,
                  keyboardType: TextInputType.emailAddress,
                  validator: (value) {
                    if (value == null || value.trim().isEmpty) {
                      return 'Email wajib diisi';
                    }
                    return null;
                  },
                ),
                const SizedBox(height: 20),

                // Phone
                AppTextField(
                  label: 'Nomor Handphone (WhatsApp)',
                  controller: _phoneController,
                  hintText: 'Nomor aktif yang bisa dihubungi',
                  prefixIcon: Icons.phone_android_outlined,
                  keyboardType: TextInputType.phone,
                  validator: (value) {
                    if (value == null || value.trim().isEmpty) {
                      return 'Nomor HP wajib diisi';
                    }
                    return null;
                  },
                ),
                const SizedBox(height: 20),

                // Address
                AppTextField(
                  label: 'Alamat Domisili Lengkap',
                  controller: _addressController,
                  hintText: 'Masukkan alamat lengkap domisili Anda saat ini',
                  prefixIcon: Icons.home_outlined,
                  maxLines: 3,
                  keyboardType: TextInputType.multiline,
                  validator: (value) {
                    if (value == null || value.trim().isEmpty) {
                      return 'Alamat domisili wajib diisi';
                    }
                    return null;
                  },
                ),
                const SizedBox(height: 28),

                // Section Title: Dokumen CV
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
                      'Dokumen CV Pelamar',
                      style: TextStyle(
                        fontSize: 16,
                        fontWeight: FontWeight.bold,
                        color: AppTheme.textPrimary,
                      ),
                    ),
                  ],
                ),
                const SizedBox(height: 12),

                // Status Dokumen CV Pelamar (Modern Borderless Banner)
                Container(
                  width: double.infinity,
                  padding: const EdgeInsets.all(20),
                  decoration: BoxDecoration(
                    color: _hasCv
                        ? const Color(0xfff0fdf4)
                        : const Color(0xfffef2f2),
                    borderRadius: BorderRadius.circular(20),
                  ),
                  child: Row(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Icon(
                        _hasCv
                            ? Icons.check_circle_rounded
                            : Icons.warning_rounded,
                        color: _hasCv ? AppTheme.success : AppTheme.danger,
                        size: 24,
                      ),
                      const SizedBox(width: 14),
                      Expanded(
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          mainAxisSize: MainAxisSize.min,
                          children: [
                            Text(
                              _hasCv
                                  ? 'CV Terunggah: $_cvFilename'
                                  : 'Dokumen CV Belum Ada',
                              style: TextStyle(
                                fontSize: 14,
                                fontWeight: FontWeight.bold,
                                color: _hasCv
                                    ? AppTheme.success
                                    : AppTheme.danger,
                              ),
                            ),
                            const SizedBox(height: 6),
                            Text(
                              _hasCv
                                  ? 'Berkas CV Anda di profil akan otomatis dilampirkan.'
                                  : 'Anda wajib mengunggah file CV di Halaman Profil terlebih dahulu sebelum melamar pekerjaan ini.',
                              style: const TextStyle(
                                fontSize: 12,
                                color: AppTheme.textSecondary,
                                height: 1.4,
                              ),
                            ),
                            if (!_hasCv) ...[
                              const SizedBox(height: 16),
                              ElevatedButton.icon(
                                onPressed: () {
                                  Navigator.pop(context);
                                  UiHelper.showSnackBar(
                                    context,
                                    'Silakan pilih tab Profil untuk mengunggah CV Anda.',
                                    isSuccess: true,
                                    aboveBottomBar: false,
                                  );
                                },
                                icon: const Icon(
                                  Icons.person_rounded,
                                  size: 16,
                                ),
                                label: const Text('Ke Halaman Profil Saya'),
                                style: ElevatedButton.styleFrom(
                                  backgroundColor: AppTheme.danger,
                                  foregroundColor: Colors.white,
                                  elevation: 0,
                                  padding: const EdgeInsets.symmetric(
                                    horizontal: 16,
                                    vertical: 8,
                                  ),
                                  shape: RoundedRectangleBorder(
                                    borderRadius: BorderRadius.circular(12),
                                  ),
                                ),
                              ),
                            ],
                          ],
                        ),
                      ),
                    ],
                  ),
                ),
                const SizedBox(height: 28),

                // Note
                AppTextField(
                  label: 'Catatan Tambahan (Opsional)',
                  controller: _noteController,
                  hintText:
                      'Tulis kualifikasi singkat, pengalaman kerja, atau motivasi Anda melamar...',
                  prefixIcon: Icons.note_alt_outlined,
                  maxLines: 4,
                  keyboardType: TextInputType.multiline,
                ),
                const SizedBox(height: 36),

                // Submit Button
                AppButton(
                  text: 'Kirim Lamaran Pekerjaan',
                  isLoading: _isLoading,
                  onPressed: _hasCv ? _handleSubmit : null,
                ),
                const SizedBox(height: 16),
              ],
            ),
          ),
        ),
      ),
    );
  }
}
