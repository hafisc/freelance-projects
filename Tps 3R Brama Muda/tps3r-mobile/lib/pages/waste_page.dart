import 'dart:io';
import 'dart:typed_data';
import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';
import 'package:flutter/foundation.dart';
import '../services/api_service.dart';
import '../services/auth_service.dart';

// Report Model
class WasteReport {
  final String id;
  final String location;
  final String description;
  final XFile? imageFile;
  final String? photoUrl;
  final String date;
  final String status;
  final DateTime createdAt;

  WasteReport({
    required this.id,
    required this.location,
    required this.description,
    this.imageFile,
    this.photoUrl,
    required this.date,
    required this.status,
    required this.createdAt,
  });

  bool get hasImage => imageFile != null || (photoUrl != null && photoUrl!.isNotEmpty);

  factory WasteReport.fromJson(Map<String, dynamic> json) {
    final photoPath = json['photo_path'] as String? ?? '';
    final rawPhotoUrl = json['photo_url'] as String? ?? '';
    
    // Tentukan photoUrl dinamis sesuai platform
    String? resolvedPhotoUrl;
    if (rawPhotoUrl.isNotEmpty || photoPath.isNotEmpty) {
      String path = rawPhotoUrl.isNotEmpty ? rawPhotoUrl : photoPath;
      if (path.contains('/storage/')) {
        path = path.substring(path.indexOf('/storage/') + 9);
      }
      
      String baseStorageUrl;
      if (kIsWeb) {
        baseStorageUrl = 'http://127.0.0.1:8000/storage';
      } else {
        baseStorageUrl = defaultTargetPlatform == TargetPlatform.android
            ? 'http://10.0.2.2:8000/storage'
            : 'http://127.0.0.1:8000/storage';
      }
      resolvedPhotoUrl = '$baseStorageUrl/$path';
    }

    final createdAtStr = json['created_at'] as String? ?? '';
    final createdAt = createdAtStr.isNotEmpty ? DateTime.parse(createdAtStr) : DateTime.now();

    final months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    final localTime = createdAt.toLocal();
    final formattedDate = '${localTime.day} ${months[localTime.month - 1]} ${localTime.year} • ${localTime.hour}:${localTime.minute.toString().padLeft(2, '0')}';

    String uiStatus = 'Menunggu';
    if (json['status'] == 'verified') {
      uiStatus = 'Selesai';
    } else if (json['status'] == 'rejected') {
      uiStatus = 'Ditolak';
    } else if (json['status'] == 'processing') {
      uiStatus = 'Diproses';
    }

    return WasteReport(
      id: (json['id'] ?? '').toString(),
      location: json['location'] ?? '',
      description: json['description'] ?? '',
      photoUrl: resolvedPhotoUrl,
      date: formattedDate,
      status: uiStatus,
      createdAt: createdAt,
    );
  }
}

class WastePage extends StatefulWidget {
  const WastePage({super.key});

  @override
  State<WastePage> createState() => _WastePageState();
}

class _WastePageState extends State<WastePage> {
  final _descriptionController = TextEditingController();
  final _locationController = TextEditingController();
  final ImagePicker _imagePicker = ImagePicker();

  // State
  XFile? _selectedImageFile;
  Uint8List? _selectedImageBytes;
  bool _isLoadingImage = false;
  bool _isSubmitting = false;
  bool _isLoadingReports = true;

  // Reports
  final List<WasteReport> _reports = [];

  @override
  void initState() {
    super.initState();
    _loadReportsFromApi();
  }

  Future<void> _loadReportsFromApi() async {
    setState(() => _isLoadingReports = true);
    try {
      final res = await ApiService.getWasteReports();
      if (res['success'] == true && res['reports'] != null) {
        final List<dynamic> reportsList = res['reports'];
        setState(() {
          _reports.clear();
          _reports.addAll(reportsList.map((r) => WasteReport.fromJson(r)).toList());
          _isLoadingReports = false;
        });
      } else {
        setState(() {
          _reports.clear();
          _reports.addAll(_getSampleReports());
          _isLoadingReports = false;
        });
      }
    } catch (e) {
      debugPrint('Error loading reports: $e');
      setState(() {
        _reports.clear();
        _reports.addAll(_getSampleReports());
        _isLoadingReports = false;
      });
    }
  }

  @override
  void dispose() {
    _descriptionController.dispose();
    _locationController.dispose();
    super.dispose();
  }

  // Pick image from camera or gallery
  Future<void> _pickImage(ImageSource source) async {
    try {
      setState(() => _isLoadingImage = true);

      final ImageSource actualSource = (kIsWeb && source == ImageSource.camera)
          ? ImageSource.gallery
          : source;

      final XFile? pickedFile = await _imagePicker.pickImage(
        source: actualSource,
        maxWidth: 1024,
        maxHeight: 1024,
        imageQuality: 85,
      );

      if (pickedFile != null) {
        final bytes = await pickedFile.readAsBytes();
        setState(() {
          _selectedImageFile = pickedFile;
          _selectedImageBytes = bytes;
          _isLoadingImage = false;
        });

        if (mounted) {
          ScaffoldMessenger.of(context).showSnackBar(
            SnackBar(
              content: const Row(
                children: [
                  Icon(Icons.check_circle, color: Colors.white, size: 20),
                  SizedBox(width: 10),
                  Text('Foto berhasil dipilih!'),
                ],
              ),
              backgroundColor: const Color(0xFF10B981),
              behavior: SnackBarBehavior.floating,
              shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
            ),
          );
        }
      } else {
        setState(() => _isLoadingImage = false);
      }
    } catch (e) {
      setState(() => _isLoadingImage = false);
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Row(
              children: [
                const Icon(Icons.error_outline, color: Colors.white, size: 20),
                const SizedBox(width: 10),
                Expanded(child: Text('Gagal memilih foto: $e')),
              ],
            ),
            backgroundColor: const Color(0xFFEF4444),
            behavior: SnackBarBehavior.floating,
            shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
          ),
        );
      }
    }
  }

  // Remove selected image
  void _removeImage() {
    setState(() {
      _selectedImageFile = null;
      _selectedImageBytes = null;
    });
    if (mounted) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: const Row(
            children: [
              Icon(Icons.delete_outline, color: Colors.white, size: 20),
              SizedBox(width: 10),
              Text('Foto dihapus'),
            ],
          ),
          backgroundColor: const Color(0xFFF59E0B),
          behavior: SnackBarBehavior.floating,
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
        ),
      );
    }
  }

  // Show image source picker
  void _showImageSourceDialog() {
    showModalBottomSheet(
      context: context,
      backgroundColor: Colors.transparent,
      builder: (context) => Container(
        padding: const EdgeInsets.all(24),
        decoration: const BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.vertical(top: Radius.circular(24)),
        ),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            // Handle
            Container(
              width: 40,
              height: 4,
              decoration: BoxDecoration(
                color: const Color(0xFFE5E7EB),
                borderRadius: BorderRadius.circular(2),
              ),
            ),
            const SizedBox(height: 20),
            const Text(
              'Pilih Sumber Foto',
              style: TextStyle(
                fontSize: 18,
                fontWeight: FontWeight.w700,
                color: Color(0xFF111827),
              ),
            ),
            const SizedBox(height: 20),
            Row(
              children: [
                Expanded(
                  child: _SourceButton(
                    icon: Icons.camera_alt,
                    label: kIsWeb ? 'Upload File' : 'Kamera',
                    color: const Color(0xFF10B981),
                    onTap: () {
                      Navigator.pop(context);
                      _pickImage(ImageSource.camera);
                    },
                  ),
                ),
                const SizedBox(width: 12),
                Expanded(
                  child: _SourceButton(
                    icon: Icons.photo_library,
                    label: 'Galeri',
                    color: const Color(0xFF3B82F6),
                    onTap: () {
                      Navigator.pop(context);
                      _pickImage(ImageSource.gallery);
                    },
                  ),
                ),
              ],
            ),
            const SizedBox(height: 16),
            TextButton(
              onPressed: () => Navigator.pop(context),
              child: const Text(
                'Batal',
                style: TextStyle(
                  color: Color(0xFF6B7280),
                  fontSize: 14,
                ),
              ),
            ),
            SizedBox(height: MediaQuery.of(context).padding.bottom),
          ],
        ),
      ),
    );
  }

  // Submit report
  Future<void> _submitReport() async {
    if (_descriptionController.text.isEmpty || _locationController.text.isEmpty || _selectedImageFile == null) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: const Row(
            children: [
              Icon(Icons.warning_amber, color: Colors.white, size: 20),
              SizedBox(width: 10),
              Text('Lengkapi deskripsi, lokasi, dan foto!'),
            ],
          ),
          backgroundColor: const Color(0xFFF59E0B),
          behavior: SnackBarBehavior.floating,
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
        ),
      );
      return;
    }

    setState(() => _isSubmitting = true);

    String? token = await AuthService.getToken();
    if (token == null) {
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('Sesi telah habis. Silakan login kembali.'))
        );
      }
      setState(() => _isSubmitting = false);
      return;
    }

    final ApiService apiService = ApiService();
    final photoBytes = await _selectedImageFile!.readAsBytes();
    final photoName = _selectedImageFile!.name;

    bool success = await apiService.submitWasteReport(
      photoBytes: photoBytes,
      photoName: photoName,
      location: _locationController.text,
      category: 'Sampah Rumah Tangga',
      description: _descriptionController.text,
      token: token,
    );

    setState(() => _isSubmitting = false);

    if (success && mounted) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: const Row(
            children: [
              Icon(Icons.check_circle, color: Colors.white, size: 20),
              SizedBox(width: 10),
              Text('Laporan berhasil dikirim ke Admin!'),
            ],
          ),
          backgroundColor: const Color(0xFF10B981),
          behavior: SnackBarBehavior.floating,
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
          duration: const Duration(seconds: 3),
        ),
      );
      _descriptionController.clear();
      _locationController.clear();
      setState(() {
        _selectedImageFile = null;
        _selectedImageBytes = null;
      });
      _loadReportsFromApi(); // reload reports from API
    } else {
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('Gagal mengirim laporan.'))
        );
      }
    }
  }

  List<WasteReport> _getSampleReports() {
    final now = DateTime.now();
    return [
      WasteReport(
        id: 'RPT001',
        location: 'Jl. Mawar No. 5',
        description: 'Sampah menumpuk di depan gang sudah 3 hari',
        imageFile: null,
        photoUrl: null,
        date: '18 Mei 2026 • 14:30',
        status: 'Diproses',
        createdAt: now.subtract(const Duration(days: 1)),
      ),
      WasteReport(
        id: 'RPT002',
        location: 'Jl. Melati No. 12',
        description: 'Sampah plastik dan kardus di pinggir jalan',
        imageFile: null,
        photoUrl: null,
        date: '15 Mei 2026 • 09:15',
        status: 'Selesai',
        createdAt: now.subtract(const Duration(days: 4)),
      ),
      WasteReport(
        id: 'RPT003',
        location: 'Jl. Anggrek RT 03',
        description: 'Sampah organik bau menyengat',
        imageFile: null,
        photoUrl: null,
        date: '10 Mei 2026 • 16:45',
        status: 'Selesai',
        createdAt: now.subtract(const Duration(days: 9)),
      ),
      WasteReport(
        id: 'RPT004',
        location: 'Jl. Kenanga RW 02',
        description: 'Kantong sampah robek, sampah berceceran',
        imageFile: null,
        photoUrl: null,
        date: '5 Mei 2026 • 08:00',
        status: 'Selesai',
        createdAt: now.subtract(const Duration(days: 14)),
      ),
    ];
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF0FDF4),
      body: SafeArea(
        child: SingleChildScrollView(
          physics: const BouncingScrollPhysics(),
          padding: const EdgeInsets.all(16),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              // Header
              _buildHeader(),
              const SizedBox(height: 20),

              // Upload Card
              _buildUploadCard(),
              const SizedBox(height: 20),

              // Status Summary
              _buildStatusSummary(),
              const SizedBox(height: 20),

              // Report History
              _buildReportHistory(),

              const SizedBox(height: 24),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildHeader() {
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        gradient: const LinearGradient(
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
          colors: [Color(0xFF10B981), Color(0xFF059669)],
        ),
        borderRadius: BorderRadius.circular(20),
        boxShadow: [
          BoxShadow(
            color: const Color(0xFF10B981).withValues(alpha: 0.35),
            blurRadius: 20,
            offset: const Offset(0, 10),
          ),
        ],
      ),
      child: Row(
        children: [
          Container(
            padding: const EdgeInsets.all(12),
            decoration: BoxDecoration(
              color: Colors.white.withValues(alpha: 0.2),
              borderRadius: BorderRadius.circular(14),
            ),
            child: const Icon(Icons.report_problem, color: Colors.white, size: 28),
          ),
          const SizedBox(width: 16),
          const Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  'Laporan Sampah',
                  style: TextStyle(
                    fontSize: 22,
                    fontWeight: FontWeight.w800,
                    color: Colors.white,
                  ),
                ),
                SizedBox(height: 4),
                Text(
                  'Laporkan sampah yang belum diangkut',
                  style: TextStyle(
                    fontSize: 13,
                    color: Colors.white70,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildUploadCard() {
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(20),
        boxShadow: [
          BoxShadow(
            color: const Color(0xFF10B981).withValues(alpha: 0.08),
            blurRadius: 16,
            offset: const Offset(0, 6),
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // Section Title
          Row(
            children: [
              Container(
                padding: const EdgeInsets.all(8),
                decoration: BoxDecoration(
                  color: const Color(0xFFECFDF5),
                  borderRadius: BorderRadius.circular(10),
                ),
                child: const Icon(Icons.add_photo_alternate, color: Color(0xFF059669), size: 20),
              ),
              const SizedBox(width: 10),
              const Text(
                'Upload Laporan',
                style: TextStyle(
                  fontSize: 16,
                  fontWeight: FontWeight.w700,
                  color: Color(0xFF111827),
                ),
              ),
            ],
          ),
          const SizedBox(height: 16),

          // Image Upload Area
          GestureDetector(
            onTap: _isLoadingImage ? null : _showImageSourceDialog,
            child: _selectedImageFile != null
                ? _buildImagePreview()
                : _buildImagePlaceholder(),
          ),
          const SizedBox(height: 16),

          // Location Input
          const Text(
            'Lokasi',
            style: TextStyle(
              fontSize: 13,
              fontWeight: FontWeight.w600,
              color: Color(0xFF374151),
            ),
          ),
          const SizedBox(height: 8),
          Container(
            decoration: BoxDecoration(
              color: const Color(0xFFF9FAFB),
              borderRadius: BorderRadius.circular(12),
              border: Border.all(color: const Color(0xFFE5E7EB)),
            ),
            child: TextField(
              controller: _locationController,
              decoration: InputDecoration(
                hintText: 'Contoh: Jl. Mawar No. 5',
                hintStyle: TextStyle(color: Colors.grey.shade400),
                prefixIcon: const Icon(Icons.location_on_outlined, color: Color(0xFF10B981)),
                contentPadding: const EdgeInsets.symmetric(horizontal: 14, vertical: 14),
                border: InputBorder.none,
              ),
            ),
          ),
          const SizedBox(height: 16),

          // Description Input
          const Text(
            'Deskripsi',
            style: TextStyle(
              fontSize: 13,
              fontWeight: FontWeight.w600,
              color: Color(0xFF374151),
            ),
          ),
          const SizedBox(height: 8),
          Container(
            decoration: BoxDecoration(
              color: const Color(0xFFF9FAFB),
              borderRadius: BorderRadius.circular(12),
              border: Border.all(color: const Color(0xFFE5E7EB)),
            ),
            child: TextField(
              controller: _descriptionController,
              maxLines: 3,
              decoration: InputDecoration(
                hintText: 'Contoh: Sampah menumpuk di depan gang',
                hintStyle: TextStyle(color: Colors.grey.shade400),
                contentPadding: const EdgeInsets.all(14),
                border: InputBorder.none,
              ),
            ),
          ),
          const SizedBox(height: 20),

          // Submit Button
          SizedBox(
            width: double.infinity,
            child: Container(
              decoration: BoxDecoration(
                gradient: _isSubmitting
                    ? null
                    : const LinearGradient(
                        colors: [Color(0xFF10B981), Color(0xFF059669)],
                      ),
                color: _isSubmitting ? Colors.grey.shade300 : null,
                borderRadius: BorderRadius.circular(14),
                boxShadow: _isSubmitting
                    ? null
                    : [
                        BoxShadow(
                          color: const Color(0xFF10B981).withValues(alpha: 0.3),
                          blurRadius: 8,
                          offset: const Offset(0, 4),
                        ),
                      ],
              ),
              child: Material(
                color: Colors.transparent,
                child: InkWell(
                  onTap: _isSubmitting ? null : _submitReport,
                  borderRadius: BorderRadius.circular(14),
                  child: Padding(
                    padding: const EdgeInsets.symmetric(vertical: 16),
                    child: Row(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        if (_isSubmitting) ...[
                          const SizedBox(
                            width: 20,
                            height: 20,
                            child: CircularProgressIndicator(
                              strokeWidth: 2,
                              valueColor: AlwaysStoppedAnimation<Color>(Colors.white),
                            ),
                          ),
                          const SizedBox(width: 10),
                        ] else ...[
                          const Icon(Icons.send, color: Colors.white, size: 18),
                          const SizedBox(width: 8),
                        ],
                        Text(
                          _isSubmitting ? 'Mengirim...' : 'Kirim Laporan',
                          style: const TextStyle(
                            fontSize: 15,
                            fontWeight: FontWeight.w700,
                            color: Colors.white,
                          ),
                        ),
                      ],
                    ),
                  ),
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildImagePlaceholder() {
    return Container(
      width: double.infinity,
      height: 140,
      decoration: BoxDecoration(
        gradient: LinearGradient(
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
          colors: [
            const Color(0xFF10B981).withValues(alpha: 0.06),
            const Color(0xFF059669).withValues(alpha: 0.04),
          ],
        ),
        borderRadius: BorderRadius.circular(16),
        border: Border.all(
          color: const Color(0xFF10B981).withValues(alpha: 0.2),
          style: BorderStyle.solid,
        ),
      ),
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Container(
            padding: const EdgeInsets.all(14),
            decoration: BoxDecoration(
              color: const Color(0xFF10B981).withValues(alpha: 0.12),
              borderRadius: BorderRadius.circular(14),
            ),
            child: const Icon(Icons.add_a_photo, color: Color(0xFF059669), size: 28),
          ),
          const SizedBox(height: 10),
          const Text(
            'Belum ada foto',
            style: TextStyle(
              fontSize: 14,
              fontWeight: FontWeight.w600,
              color: Color(0xFF059669),
            ),
          ),
          const SizedBox(height: 4),
          Text(
            'Tekan untuk tambah foto',
            style: TextStyle(
              fontSize: 11,
              color: Colors.grey.shade500,
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildImagePreview() {
    return Stack(
      children: [
        Container(
          width: double.infinity,
          height: 180,
          decoration: BoxDecoration(
            borderRadius: BorderRadius.circular(16),
            border: Border.all(
              color: const Color(0xFF10B981).withValues(alpha: 0.4),
              width: 2,
            ),
          ),
          child: ClipRRect(
            borderRadius: BorderRadius.circular(14),
            child: _isLoadingImage
                ? Container(
                    color: const Color(0xFFF0FDF4),
                    child: const Center(
                      child: Column(
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: [
                          CircularProgressIndicator(
                            color: Color(0xFF10B981),
                            strokeWidth: 2,
                          ),
                          SizedBox(height: 10),
                          Text(
                            'Memuat foto...',
                            style: TextStyle(
                              color: Color(0xFF059669),
                              fontSize: 12,
                            ),
                          ),
                        ],
                      ),
                    ),
                  )
                : Image.memory(
                    _selectedImageBytes!,
                    fit: BoxFit.cover,
                  ),
          ),
        ),
        // Delete button
        Positioned(
          top: 8,
          right: 8,
          child: GestureDetector(
            onTap: _removeImage,
            child: Container(
              padding: const EdgeInsets.all(8),
              decoration: BoxDecoration(
                color: const Color(0xFFEF4444),
                borderRadius: BorderRadius.circular(10),
                boxShadow: [
                  BoxShadow(
                    color: Colors.black.withValues(alpha: 0.2),
                    blurRadius: 4,
                    offset: const Offset(0, 2),
                  ),
                ],
              ),
              child: const Icon(Icons.close, color: Colors.white, size: 16),
            ),
          ),
        ),
        // Badge
        Positioned(
          bottom: 8,
          left: 8,
          child: Container(
            padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 5),
            decoration: BoxDecoration(
              color: Colors.black.withValues(alpha: 0.6),
              borderRadius: BorderRadius.circular(8),
            ),
            child: const Row(
              mainAxisSize: MainAxisSize.min,
              children: [
                Icon(Icons.check_circle, color: Color(0xFF10B981), size: 14),
                SizedBox(width: 4),
                Text(
                  '1 foto',
                  style: TextStyle(
                    fontSize: 11,
                    color: Colors.white,
                    fontWeight: FontWeight.w600,
                  ),
                ),
              ],
            ),
          ),
        ),
      ],
    );
  }

  Widget _buildStatusSummary() {
    final menunggu = _reports.where((r) => r.status == 'Menunggu').length;
    final diproses = _reports.where((r) => r.status == 'Diproses').length;
    final selesai = _reports.where((r) => r.status == 'Selesai').length;

    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const Text(
          'Status Laporan',
          style: TextStyle(
            fontSize: 16,
            fontWeight: FontWeight.w700,
            color: Color(0xFF111827),
          ),
        ),
        const SizedBox(height: 12),
        Row(
          children: [
            Expanded(
              child: _StatusCard(
                label: 'Menunggu',
                count: menunggu,
                color: const Color(0xFFF59E0B),
                bgColor: const Color(0xFFFEF3C7),
                icon: Icons.hourglass_empty,
              ),
            ),
            const SizedBox(width: 10),
            Expanded(
              child: _StatusCard(
                label: 'Diproses',
                count: diproses,
                color: const Color(0xFF3B82F6),
                bgColor: const Color(0xFFEFF6FF),
                icon: Icons.sync,
              ),
            ),
            const SizedBox(width: 10),
            Expanded(
              child: _StatusCard(
                label: 'Selesai',
                count: selesai,
                color: const Color(0xFF10B981),
                bgColor: const Color(0xFFECFDF5),
                icon: Icons.check_circle,
              ),
            ),
          ],
        ),
      ],
    );
  }

  Widget _buildReportHistory() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Row(
          children: [
            Container(
              padding: const EdgeInsets.all(8),
              decoration: BoxDecoration(
                color: const Color(0xFFECFDF5),
                borderRadius: BorderRadius.circular(10),
              ),
              child: const Icon(Icons.history, color: Color(0xFF059669), size: 18),
            ),
            const SizedBox(width: 10),
            const Text(
              'Riwayat Laporan',
              style: TextStyle(
                fontSize: 16,
                fontWeight: FontWeight.w700,
                color: Color(0xFF111827),
              ),
            ),
            const Spacer(),
            Container(
              padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
              decoration: BoxDecoration(
                color: const Color(0xFF3B82F6).withValues(alpha: 0.1),
                borderRadius: BorderRadius.circular(20),
              ),
              child: Text(
                '${_reports.length} Laporan',
                style: const TextStyle(
                  color: Color(0xFF3B82F6),
                  fontSize: 11,
                  fontWeight: FontWeight.w600,
                ),
              ),
            ),
          ],
        ),
        const SizedBox(height: 12),

        // Reports List
        ...(_isLoadingReports
            ? [
                const Center(
                  child: Padding(
                    padding: EdgeInsets.all(32.0),
                    child: CircularProgressIndicator(
                      color: Color(0xFF10B981),
                    ),
                  ),
                )
              ]
            : _reports.isEmpty
                ? [
                    Container(
                      width: double.infinity,
                      padding: const EdgeInsets.all(32),
                      decoration: BoxDecoration(
                        color: Colors.white,
                        borderRadius: BorderRadius.circular(16),
                      ),
                      child: Column(
                        children: [
                          Icon(Icons.inbox, size: 48, color: Colors.grey.shade300),
                          const SizedBox(height: 12),
                          const Text(
                            'Belum ada laporan',
                            style: TextStyle(
                              fontSize: 14,
                              color: Color(0xFF9CA3AF),
                              fontWeight: FontWeight.w500,
                            ),
                          ),
                        ],
                      ),
                    ),
                  ]
                : _reports.asMap().entries.map((entry) {
                    final index = entry.key;
                    final report = entry.value;
                    return Column(
                      children: [
                        _ReportListItem(report: report),
                    if (index < _reports.length - 1) ...[
                      const SizedBox(height: 10),
                    ],
                  ],
                );
              })),
      ],
    );
  }
}

// Status Card Widget
class _StatusCard extends StatelessWidget {
  final String label;
  final int count;
  final Color color;
  final Color bgColor;
  final IconData icon;

  const _StatusCard({
    required this.label,
    required this.count,
    required this.color,
    required this.bgColor,
    required this.icon,
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(14),
      decoration: BoxDecoration(
        color: bgColor,
        borderRadius: BorderRadius.circular(14),
        border: Border.all(color: color.withValues(alpha: 0.2)),
      ),
      child: Column(
        children: [
          Icon(icon, color: color, size: 22),
          const SizedBox(height: 8),
          Text(
            '$count',
            style: TextStyle(
              fontSize: 20,
              fontWeight: FontWeight.w800,
              color: color,
            ),
          ),
          const SizedBox(height: 2),
          Text(
            label,
            style: TextStyle(
              fontSize: 11,
              color: color,
              fontWeight: FontWeight.w500,
            ),
          ),
        ],
      ),
    );
  }
}

// Source Button Widget
class _SourceButton extends StatelessWidget {
  final IconData icon;
  final String label;
  final Color color;
  final VoidCallback onTap;

  const _SourceButton({
    required this.icon,
    required this.label,
    required this.color,
    required this.onTap,
  });

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: onTap,
      child: Container(
        padding: const EdgeInsets.symmetric(vertical: 20),
        decoration: BoxDecoration(
          color: color.withValues(alpha: 0.1),
          borderRadius: BorderRadius.circular(16),
          border: Border.all(color: color.withValues(alpha: 0.3)),
        ),
        child: Column(
          children: [
            Container(
              padding: const EdgeInsets.all(12),
              decoration: BoxDecoration(
                color: color.withValues(alpha: 0.2),
                borderRadius: BorderRadius.circular(12),
              ),
              child: Icon(icon, color: color, size: 28),
            ),
            const SizedBox(height: 10),
            Text(
              label,
              style: TextStyle(
                fontSize: 13,
                fontWeight: FontWeight.w600,
                color: color,
              ),
            ),
          ],
        ),
      ),
    );
  }
}

// Report List Item Widget
class _ReportListItem extends StatelessWidget {
  final WasteReport report;

  const _ReportListItem({required this.report});

  Color _getStatusColor(String status) {
    switch (status) {
      case 'Menunggu':
        return const Color(0xFFF59E0B);
      case 'Diproses':
        return const Color(0xFF3B82F6);
      case 'Selesai':
        return const Color(0xFF10B981);
      default:
        return const Color(0xFF6B7280);
    }
  }

  Color _getStatusBgColor(String status) {
    switch (status) {
      case 'Menunggu':
        return const Color(0xFFFEF3C7);
      case 'Diproses':
        return const Color(0xFFEFF6FF);
      case 'Selesai':
        return const Color(0xFFECFDF5);
      default:
        return const Color(0xFFF3F4F6);
    }
  }

  @override
  Widget build(BuildContext context) {
    final statusColor = _getStatusColor(report.status);
    final statusBgColor = _getStatusBgColor(report.status);

    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withValues(alpha: 0.04),
            blurRadius: 12,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // Thumbnail
          Container(
            width: 56,
            height: 56,
            decoration: BoxDecoration(
              color: const Color(0xFFF0FDF4),
              borderRadius: BorderRadius.circular(12),
              border: Border.all(color: const Color(0xFFD1FAE5)),
            ),
            child: report.imageFile != null
                ? ClipRRect(
                    borderRadius: BorderRadius.circular(11),
                    child: kIsWeb
                        ? Image.network(
                            report.imageFile!.path,
                            fit: BoxFit.cover,
                          )
                        : Image.file(
                            File(report.imageFile!.path),
                            fit: BoxFit.cover,
                          ),
                  )
                : report.photoUrl != null
                    ? ClipRRect(
                        borderRadius: BorderRadius.circular(11),
                        child: Image.network(
                          report.photoUrl!,
                          fit: BoxFit.cover,
                          errorBuilder: (context, error, stackTrace) => const Icon(
                            Icons.broken_image,
                            color: Colors.red,
                            size: 20,
                          ),
                          loadingBuilder: (context, child, loadingProgress) {
                            if (loadingProgress == null) return child;
                            return const Center(
                              child: SizedBox(
                                width: 16,
                                height: 16,
                                child: CircularProgressIndicator(
                                  strokeWidth: 2,
                                  color: Color(0xFF10B981),
                                ),
                              ),
                            );
                          },
                        ),
                      )
                    : const Icon(
                        Icons.image,
                        color: Color(0xFF10B981),
                        size: 24,
                      ),
          ),
          const SizedBox(width: 14),
          // Content
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Row(
                  children: [
                    Expanded(
                      child: Text(
                        report.location,
                        style: const TextStyle(
                          fontSize: 14,
                          fontWeight: FontWeight.w600,
                          color: Color(0xFF111827),
                        ),
                      ),
                    ),
                    Container(
                      padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                      decoration: BoxDecoration(
                        color: statusBgColor,
                        borderRadius: BorderRadius.circular(8),
                      ),
                      child: Text(
                        report.status,
                        style: TextStyle(
                          fontSize: 11,
                          fontWeight: FontWeight.w600,
                          color: statusColor,
                        ),
                      ),
                    ),
                  ],
                ),
                const SizedBox(height: 4),
                Text(
                  report.description,
                  style: TextStyle(
                    fontSize: 12,
                    color: Colors.grey.shade600,
                    height: 1.4,
                  ),
                  maxLines: 2,
                  overflow: TextOverflow.ellipsis,
                ),
                const SizedBox(height: 8),
                Row(
                  children: [
                    Icon(Icons.access_time, size: 12, color: Colors.grey.shade400),
                    const SizedBox(width: 4),
                    Text(
                      report.date,
                      style: TextStyle(
                        fontSize: 11,
                        color: Colors.grey.shade500,
                      ),
                    ),
                  ],
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}