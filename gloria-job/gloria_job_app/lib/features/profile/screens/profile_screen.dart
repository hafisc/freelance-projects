import 'package:flutter/material.dart';
import 'package:file_picker/file_picker.dart';
import '../../../app/theme.dart';
import '../../../app/routes.dart';
import '../../../core/widgets/app_text_field.dart';
import '../../../core/helpers/ui_helper.dart';
import '../../auth/models/user_model.dart';
import '../../auth/services/auth_service.dart';

class ProfileScreen extends StatefulWidget {
  const ProfileScreen({super.key});

  @override
  State<ProfileScreen> createState() => _ProfileScreenState();
}

class _ProfileScreenState extends State<ProfileScreen> {
  final AuthService _authService = AuthService();
  UserModel? _currentUser;
  bool _isLoading = false;

  String? _getCvFilename(String? cvPath) {
    if (cvPath == null || cvPath.isEmpty) return null;
    return cvPath.split('/').last;
  }

  @override
  void initState() {
    super.initState();
    _loadUser();
  }

  // Mengambil data pengguna dari cache lokal dan API
  void _loadUser() async {
    final user = await _authService.getCachedUser();
    setState(() {
      _currentUser = user;
    });

    try {
      final freshUser = await _authService.getProfile();
      setState(() {
        _currentUser = freshUser;
      });
    } catch (_) {
      // Tetap menggunakan data dari cache jika pemuatan API gagal
    }
  }

  // Menangani fungsi keluar log (logout)
  Future<void> _handleLogout() async {
    final confirm = await showDialog<bool>(
      context: context,
      builder: (context) => AlertDialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
        title: const Text('Keluar Log'),
        content: const Text('Apakah Anda yakin ingin keluar dari akun Anda?'),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context, false),
            child: const Text(
              'Batal',
              style: TextStyle(color: AppTheme.textSecondary),
            ),
          ),
          TextButton(
            onPressed: () => Navigator.pop(context, true),
            child: const Text(
              'Keluar',
              style: TextStyle(
                color: AppTheme.danger,
                fontWeight: FontWeight.bold,
              ),
            ),
          ),
        ],
      ),
    );

    if (confirm != true) return;

    setState(() {
      _isLoading = true;
    });

    try {
      await _authService.logout();
      if (!mounted) return;

      UiHelper.showSnackBar(context, 'Berhasil keluar log.', isSuccess: true);

      Navigator.pushNamedAndRemoveUntil(
        context,
        AppRoutes.login,
        (route) => false,
      );
    } catch (e) {
      if (!mounted) return;
      UiHelper.showSnackBar(context, 'Gagal logout: $e', isSuccess: false);
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
      backgroundColor: AppTheme.background,
      appBar: AppBar(
        title: const Text('Profil Saya'),
        automaticallyImplyLeading: false,
        actions: [
          IconButton(
            onPressed: _handleLogout,
            icon: const Icon(Icons.logout_rounded, color: AppTheme.danger),
            tooltip: 'Keluar Akun',
          ),
        ],
      ),
      body: _isLoading
          ? const Center(
              child: CircularProgressIndicator(color: AppTheme.primaryBlue),
            )
          : SingleChildScrollView(
              padding: const EdgeInsets.symmetric(horizontal: 20.0, vertical: 24.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  // CARD UTAMA: Avatar, Nama, Kontak, Domicile
                  _buildHeaderCard(),
                  
                  const SizedBox(height: 12),

                  // DOKUMEN CV / RESUME CARD
                  _buildSectionTitle('Dokumen CV / Resume', Icons.description_outlined),
                  _buildCvCard(),

                  const SizedBox(height: 16),

                  // MENU BANTUAN & HUBUNGI KAMI (SOW 12)
                  _buildSectionTitle('Bantuan & Dukungan', Icons.support_agent_rounded),
                  _buildHelpMenuCard(),

                  const SizedBox(height: 120),
                ],
              ),
            ),
    );
  }

  // Widget Pembantu Card Wrapper
  Widget _buildCard({required Widget child}) {
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(20),
      margin: const EdgeInsets.only(bottom: 16),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(20),
        boxShadow: [
          BoxShadow(
            color: const Color(0xff0f172a).withOpacity(0.02),
            blurRadius: 16,
            offset: const Offset(0, 6),
          ),
        ],
        border: Border.all(color: const Color(0xffe2e8f0)),
      ),
      child: child,
    );
  }

  // Widget Pembantu Section Title
  Widget _buildSectionTitle(String title, IconData icon) {
    return Padding(
      padding: const EdgeInsets.only(left: 4.0, bottom: 8.0),
      child: Row(
        children: [
          Icon(icon, color: AppTheme.primaryBlue, size: 20),
          const SizedBox(width: 8),
          Text(
            title,
            style: const TextStyle(
              fontSize: 15,
              fontWeight: FontWeight.bold,
              color: AppTheme.textPrimary,
            ),
          ),
        ],
      ),
    );
  }

  // Widget Header Profile
  Widget _buildHeaderCard() {
    return _buildCard(
      child: Column(
        children: [
          Row(
            crossAxisAlignment: CrossAxisAlignment.center,
            children: [
              // Avatar dengan gradient ring
              Container(
                padding: const EdgeInsets.all(3),
                decoration: const BoxDecoration(
                  shape: BoxShape.circle,
                  gradient: LinearGradient(
                    colors: [AppTheme.primaryBlue, AppTheme.accentCyan],
                    begin: Alignment.topLeft,
                    end: Alignment.bottomRight,
                  ),
                ),
                child: Container(
                  padding: const EdgeInsets.all(2),
                  decoration: const BoxDecoration(
                    color: Colors.white,
                    shape: BoxShape.circle,
                  ),
                  child: CircleAvatar(
                    radius: 36,
                    backgroundColor: AppTheme.primaryBlue.withOpacity(0.1),
                    backgroundImage: _currentUser?.name != null && _currentUser!.name.isNotEmpty
                        ? NetworkImage(
                            'https://api.dicebear.com/7.x/avataaars/png?seed=${Uri.encodeComponent(_currentUser!.name)}')
                        : null,
                    child: _currentUser?.name == null || _currentUser!.name.isEmpty
                        ? const Icon(
                            Icons.person_rounded,
                            color: AppTheme.primaryBlue,
                            size: 38,
                          )
                        : null,
                  ),
                ),
              ),
              const SizedBox(width: 20),
              // Nama & Gelar/Posisi
              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      _currentUser?.name ?? 'Memuat...',
                      style: const TextStyle(
                        fontSize: 18,
                        fontWeight: FontWeight.bold,
                        color: AppTheme.textPrimary,
                        letterSpacing: -0.5,
                      ),
                    ),
                    const SizedBox(height: 4),
                    Text(
                      _currentUser?.email ?? 'Memuat...',
                      style: const TextStyle(
                        fontSize: 13,
                        color: AppTheme.textSecondary,
                        fontWeight: FontWeight.w500,
                      ),
                    ),
                  ],
                ),
              ),
            ],
          ),
          const Divider(color: Color(0xfff1f5f9), height: 32),
          // Info Kontak Sekunder
          _buildHeaderInfoRow(Icons.phone_android_rounded, _currentUser?.phone ?? '-'),
          const SizedBox(height: 10),
          _buildHeaderInfoRow(Icons.place_outlined, _currentUser?.address ?? 'Alamat belum diisi'),
          const SizedBox(height: 16),
          // Tombol Edit
          ElevatedButton.icon(
            onPressed: _showEditProfileDialog,
            icon: const Icon(Icons.edit_note_rounded, size: 18),
            label: const Text('Edit / Lengkapi Profil'),
            style: ElevatedButton.styleFrom(
              backgroundColor: AppTheme.primaryBlue.withOpacity(0.08),
              foregroundColor: AppTheme.primaryBlue,
              elevation: 0,
              minimumSize: const Size(double.infinity, 44),
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(12),
              ),
              textStyle: const TextStyle(
                fontSize: 13,
                fontWeight: FontWeight.bold,
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildHeaderInfoRow(IconData icon, String text) {
    return Row(
      children: [
        Icon(icon, size: 16, color: AppTheme.textSecondary),
        const SizedBox(width: 8),
        Expanded(
          child: Text(
            text,
            style: const TextStyle(
              fontSize: 13,
              color: AppTheme.textPrimary,
              fontWeight: FontWeight.w500,
            ),
            maxLines: 1,
            overflow: TextOverflow.ellipsis,
          ),
        ),
      ],
    );
  }

  // Widget Berkas CV
  Widget _buildCvCard() {
    final cvName = _getCvFilename(_currentUser?.cv);
    return _buildCard(
      child: Row(
        children: [
          Container(
            padding: const EdgeInsets.all(12),
            decoration: BoxDecoration(
              color: const Color(0xfffee2e2),
              borderRadius: BorderRadius.circular(12),
            ),
            child: const Icon(
              Icons.picture_as_pdf_rounded,
              color: AppTheme.danger,
              size: 28,
            ),
          ),
          const SizedBox(width: 16),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  cvName ?? 'Belum Mengunggah CV',
                  style: TextStyle(
                    fontSize: 14,
                    fontWeight: FontWeight.bold,
                    color: cvName != null ? AppTheme.textPrimary : AppTheme.textSecondary,
                  ),
                  maxLines: 1,
                  overflow: TextOverflow.ellipsis,
                ),
                const SizedBox(height: 2),
                Text(
                  cvName != null ? 'CV Tersemat & Aktif' : 'Unggah CV untuk melamar lowongan',
                  style: TextStyle(
                    fontSize: 11,
                    color: cvName != null ? AppTheme.success : AppTheme.textSecondary,
                    fontWeight: FontWeight.w500,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  // Widget kartu menu bantuan (SOW 12)
  Widget _buildHelpMenuCard() {
    return _buildCard(
      child: Column(
        children: [
          ListTile(
            contentPadding: EdgeInsets.zero,
            leading: Container(
              padding: const EdgeInsets.all(8),
              decoration: BoxDecoration(
                color: AppTheme.primaryBlue.withOpacity(0.08),
                borderRadius: BorderRadius.circular(10),
              ),
              child: const Icon(
                Icons.help_outline_rounded,
                color: AppTheme.primaryBlue,
                size: 20,
              ),
            ),
            title: const Text(
              'Hubungi Kami & Bantuan',
              style: TextStyle(
                fontSize: 14,
                fontWeight: FontWeight.bold,
                color: AppTheme.textPrimary,
              ),
            ),
            subtitle: const Text(
              'Detail kontak resmi PT. Gloria Jasa Mandiri',
              style: TextStyle(
                fontSize: 11,
                color: AppTheme.textSecondary,
              ),
            ),
            trailing: const Icon(
              Icons.chevron_right_rounded,
              color: AppTheme.textSecondary,
            ),
            onTap: _showCompanyContactBottomSheet,
          ),
        ],
      ),
    );
  }

  // Fungsi untuk merender detail kontak perusahaan di bottom sheet (SOW 12)
  Widget _buildContactDetailItem(IconData icon, String title, String value) {
    return Row(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Icon(icon, size: 16, color: AppTheme.primaryBlue),
        const SizedBox(width: 10),
        Expanded(
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                title,
                style: const TextStyle(
                  fontSize: 11,
                  color: AppTheme.textSecondary,
                  fontWeight: FontWeight.w600,
                ),
              ),
              const SizedBox(height: 2),
              Text(
                value,
                style: const TextStyle(
                  fontSize: 13,
                  color: AppTheme.textPrimary,
                  fontWeight: FontWeight.w500,
                ),
              ),
            ],
          ),
        ),
      ],
    );
  }

  // Fungsi untuk menampilkan bottom sheet detail kontak (SOW 12)
  void _showCompanyContactBottomSheet() {
    showModalBottomSheet(
      context: context,
      backgroundColor: Colors.white,
      shape: const RoundedRectangleBorder(
        borderRadius: BorderRadius.vertical(top: Radius.circular(24)),
      ),
      builder: (context) {
        return Padding(
          padding: const EdgeInsets.all(24.0),
          child: Column(
            mainAxisSize: MainAxisSize.min,
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              // Header Sheet
              Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  const Text(
                    'Hubungi Kami',
                    style: TextStyle(
                      fontSize: 18,
                      fontWeight: FontWeight.bold,
                      color: AppTheme.textPrimary,
                      letterSpacing: -0.5,
                    ),
                  ),
                  IconButton(
                    icon: const Icon(Icons.close_rounded),
                    onPressed: () => Navigator.pop(context),
                  ),
                ],
              ),
              const Divider(color: Color(0xfff1f5f9), height: 16),
              const SizedBox(height: 8),

              // Info Perusahaan
              Row(
                children: [
                  Container(
                    padding: const EdgeInsets.all(10),
                    decoration: BoxDecoration(
                      color: AppTheme.primaryBlue.withOpacity(0.08),
                      borderRadius: BorderRadius.circular(12),
                    ),
                    child: const Icon(
                      Icons.business_rounded,
                      color: AppTheme.primaryBlue,
                      size: 24,
                    ),
                  ),
                  const SizedBox(width: 14),
                  const Expanded(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          'PT. Gloria Jasa Mandiri',
                          style: TextStyle(
                            fontSize: 15,
                            fontWeight: FontWeight.bold,
                            color: AppTheme.textPrimary,
                          ),
                        ),
                        Text(
                          'Penyedia Jasa Tenaga Kerja Terpercaya',
                          style: TextStyle(
                            fontSize: 11,
                            color: AppTheme.textSecondary,
                            fontWeight: FontWeight.w500,
                          ),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
              const SizedBox(height: 24),

              // Detail Kontak
              _buildContactDetailItem(Icons.place_outlined, 'Alamat Kantor', 'Jl. Raya Darmo No. 45, Surabaya, Jawa Timur 60256'),
              const SizedBox(height: 14),
              _buildContactDetailItem(Icons.email_outlined, 'Email Resmi', 'info@gloriajasamandiri.co.id'),
              const SizedBox(height: 14),
              _buildContactDetailItem(Icons.phone_outlined, 'Nomor Telepon', '(031) 567890'),
              const SizedBox(height: 14),
              _buildContactDetailItem(Icons.chat_outlined, 'WhatsApp Support', '0812-3456-7890'),
              const SizedBox(height: 16),
            ],
          ),
        );
      },
    );
  }

  // BOTTOM SHEET EDITOR PROFILE
  void _showEditProfileDialog() {
    if (_currentUser == null) return;

    final nameController = TextEditingController(text: _currentUser!.name);
    final phoneController = TextEditingController(text: _currentUser!.phone);
    final addressController = TextEditingController(text: _currentUser!.address ?? '');

    final formKey = GlobalKey<FormState>();
    String? selectedCvPath;
    String? selectedCvName = _getCvFilename(_currentUser!.cv);
    bool isSaving = false;

    showModalBottomSheet(
      context: context,
      isScrollControlled: true,
      backgroundColor: Colors.white,
      shape: const RoundedRectangleBorder(
        borderRadius: BorderRadius.vertical(top: Radius.circular(24)),
      ),
      builder: (context) {
        return StatefulBuilder(
          builder: (context, setSheetState) {
            return Container(
              constraints: BoxConstraints(
                maxHeight: MediaQuery.of(context).size.height * 0.85,
              ),
              child: Padding(
                padding: EdgeInsets.only(
                  left: 20,
                  right: 20,
                  top: 20,
                  bottom: MediaQuery.of(context).viewInsets.bottom + 20,
                ),
                child: Column(
                  mainAxisSize: MainAxisSize.min,
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    // Header Bottom Sheet
                    Row(
                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                      children: [
                        const Text(
                          'Edit / Lengkapi Profil',
                          style: TextStyle(
                            fontSize: 18,
                            fontWeight: FontWeight.bold,
                            color: AppTheme.textPrimary,
                            letterSpacing: -0.5,
                          ),
                        ),
                        IconButton(
                          icon: const Icon(Icons.close_rounded),
                          onPressed: () => Navigator.pop(context),
                        ),
                      ],
                    ),
                    const Divider(color: Color(0xfff1f5f9), height: 16),
                    // Scrollable Form Fields
                    Expanded(
                      child: SingleChildScrollView(
                        child: Form(
                          key: formKey,
                          child: Column(
                            crossAxisAlignment: CrossAxisAlignment.stretch,
                            children: [
                              const SizedBox(height: 10),
                              // DATA PRIBADI
                              _buildSubHeader('Data Pribadi'),
                              AppTextField(
                                label: 'Nama Lengkap',
                                controller: nameController,
                                hintText: 'Nama lengkap sesuai KTP',
                                prefixIcon: Icons.person_outline_rounded,
                                validator: (value) {
                                  if (value == null || value.trim().isEmpty) {
                                    return 'Nama lengkap wajib diisi';
                                  }
                                  return null;
                                },
                              ),
                              const SizedBox(height: 16),
                              AppTextField(
                                label: 'Nomor HP (WhatsApp)',
                                controller: phoneController,
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
                              const SizedBox(height: 16),
                              AppTextField(
                                label: 'Alamat Domisili Lengkap',
                                controller: addressController,
                                hintText: 'Masukkan alamat lengkap domisili Anda',
                                prefixIcon: Icons.home_outlined,
                                maxLines: 2,
                                keyboardType: TextInputType.multiline,
                                validator: (value) {
                                  if (value == null || value.trim().isEmpty) {
                                    return 'Alamat domisili wajib diisi';
                                  }
                                  return null;
                                },
                              ),
                              const SizedBox(height: 24),

                              // DOKUMEN CV
                              _buildSubHeader('Dokumen CV (Maksimal 5MB PDF/Word)'),
                              Container(
                                padding: const EdgeInsets.all(12),
                                decoration: BoxDecoration(
                                  color: const Color(0xfff8fafc),
                                  borderRadius: BorderRadius.circular(12),
                                  border: Border.all(color: const Color(0xffe2e8f0)),
                                ),
                                child: Row(
                                  children: [
                                    const Icon(
                                      Icons.description_outlined,
                                      color: AppTheme.primaryBlue,
                                      size: 24,
                                    ),
                                    const SizedBox(width: 12),
                                    Expanded(
                                      child: Column(
                                        crossAxisAlignment: CrossAxisAlignment.start,
                                        children: [
                                          Text(
                                            selectedCvName ?? 'Belum ada berkas terpilih',
                                            style: TextStyle(
                                              fontSize: 13,
                                              fontWeight: selectedCvName != null
                                                  ? FontWeight.bold
                                                  : FontWeight.normal,
                                              color: selectedCvName != null
                                                  ? AppTheme.textPrimary
                                                  : AppTheme.textSecondary,
                                            ),
                                            maxLines: 1,
                                            overflow: TextOverflow.ellipsis,
                                          ),
                                          if (selectedCvPath != null)
                                            const Text(
                                              'Berkas baru siap diunggah',
                                              style: TextStyle(
                                                fontSize: 10,
                                                color: AppTheme.success,
                                                fontWeight: FontWeight.w600,
                                              ),
                                            ),
                                        ],
                                      ),
                                    ),
                                    const SizedBox(width: 8),
                                    ElevatedButton(
                                      onPressed: () async {
                                        try {
                                          FilePickerResult? result = await FilePicker.pickFiles(
                                            type: FileType.custom,
                                            allowedExtensions: ['pdf', 'doc', 'docx'],
                                          );
                                          if (result != null) {
                                            final path = result.files.single.path;
                                            if (path != null) {
                                              setSheetState(() {
                                                selectedCvPath = path;
                                                selectedCvName = result.files.single.name;
                                              });
                                            }
                                          }
                                        } catch (e) {
                                          if (context.mounted) {
                                            UiHelper.showSnackBar(
                                              context,
                                              'Gagal memilih berkas: $e',
                                              isSuccess: false,
                                            );
                                          }
                                        }
                                      },
                                      style: ElevatedButton.styleFrom(
                                        backgroundColor: AppTheme.primaryBlue.withOpacity(0.08),
                                        foregroundColor: AppTheme.primaryBlue,
                                        elevation: 0,
                                        minimumSize: const Size(100, 36),
                                        padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 8),
                                        shape: RoundedRectangleBorder(
                                          borderRadius: BorderRadius.circular(8),
                                        ),
                                      ),
                                      child: Text(
                                        selectedCvName == null ? 'Pilih Berkas' : 'Ubah',
                                        style: const TextStyle(fontSize: 11, fontWeight: FontWeight.bold),
                                      ),
                                    ),
                                  ],
                                ),
                              ),
                              const SizedBox(height: 120),
                            ],
                          ),
                        ),
                      ),
                    ),
                    const SizedBox(height: 16),
                    // Tombol Simpan
                    ElevatedButton(
                      onPressed: isSaving
                          ? null
                          : () async {
                              if (!formKey.currentState!.validate()) return;

                              final navigator = Navigator.of(context);

                              setSheetState(() {
                                isSaving = true;
                              });

                              try {
                                final updatedUser = await _authService.updateProfile(
                                  name: nameController.text.trim(),
                                  phone: phoneController.text.trim(),
                                  address: addressController.text.trim(),
                                  cvPath: selectedCvPath,
                                  summary: '',
                                );

                                if (context.mounted) {
                                  setState(() {
                                    _currentUser = updatedUser;
                                  });

                                  navigator.pop(); // Close Bottom Sheet

                                  UiHelper.showSnackBar(
                                    context,
                                    'Profil berhasil diperbarui.',
                                    isSuccess: true,
                                    aboveBottomBar: true,
                                  );
                                }
                              } catch (e) {
                                if (context.mounted) {
                                  UiHelper.showSnackBar(
                                    context,
                                    e.toString(),
                                    isSuccess: false,
                                    aboveBottomBar: true,
                                  );
                                }
                              } finally {
                                if (mounted) {
                                  setSheetState(() {
                                    isSaving = false;
                                  });
                                }
                              }
                            },
                      style: ElevatedButton.styleFrom(
                        backgroundColor: AppTheme.primaryBlue,
                        foregroundColor: Colors.white,
                        elevation: 0,
                        minimumSize: const Size(double.infinity, 48),
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(14),
                        ),
                      ),
                      child: isSaving
                          ? const SizedBox(
                              height: 18,
                              width: 18,
                              child: CircularProgressIndicator(
                                color: Colors.white,
                                strokeWidth: 2.5,
                              ),
                            )
                          : const Text(
                              'Simpan Perubahan',
                              style: TextStyle(fontSize: 14, fontWeight: FontWeight.bold),
                            ),
                    ),
                  ],
                ),
              ),
            );
          },
        );
      },
    );
  }

  Widget _buildSubHeader(String text) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 12.0, top: 4.0),
      child: Text(
        text,
        style: const TextStyle(
          fontSize: 13,
          fontWeight: FontWeight.bold,
          color: AppTheme.primaryBlue,
        ),
      ),
    );
  }
}
