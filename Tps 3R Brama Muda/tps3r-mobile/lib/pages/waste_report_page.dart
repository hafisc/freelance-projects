import 'dart:io';
import 'dart:typed_data';
import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';
import 'package:flutter/foundation.dart' show kIsWeb;
import '../services/api_service.dart'; // Pastikan path ini benar
import '../services/auth_service.dart';

// Report Model
class WasteReport {
  final String id;
  final String location;
  final String description;
  final XFile? imageFile; // Diubah dari File ke XFile
  final String date;
  final String status;
  final DateTime createdAt;

  WasteReport({
    required this.id,
    required this.location,
    required this.description,
    this.imageFile,
    required this.date,
    required this.status,
    required this.createdAt,
  });

  bool get hasImage => imageFile != null;
}

class WasteReportPage extends StatefulWidget {
  const WasteReportPage({super.key});

  @override
  State<WasteReportPage> createState() => _WasteReportPageState();
}

class _WasteReportPageState extends State<WasteReportPage> {
  final _descriptionController = TextEditingController();
  final _locationController = TextEditingController();
  final ImagePicker _imagePicker = ImagePicker();
  final ApiService _apiService = ApiService();

  XFile? _selectedImageFile; // State untuk XFile
  Uint8List? _selectedImageBytes; // State untuk bytes gambar
  bool _isSubmitting = false;

  final List<WasteReport> _reports = [];

  @override
  void dispose() {
    _descriptionController.dispose();
    _locationController.dispose();
    super.dispose();
  }

  Future<void> _pickImage(ImageSource source) async {
    final XFile? pickedFile = await _imagePicker.pickImage(
      source: source,
      maxWidth: 1024,
      maxHeight: 1024,
      imageQuality: 85,
    );

    if (pickedFile != null) {
      final bytes = await pickedFile.readAsBytes();
      setState(() {
        _selectedImageFile = pickedFile;
        _selectedImageBytes = bytes;
      });
    }
  }

  void _removeImage() {
    setState(() {
      _selectedImageFile = null;
      _selectedImageBytes = null;
    });
  }

  Future<void> _submitReport() async {
    if (_descriptionController.text.isEmpty || _locationController.text.isEmpty || _selectedImageFile == null) {
      ScaffoldMessenger.of(context).showSnackBar(const SnackBar(content: Text('Lengkapi form dan foto!')));
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

    final photoBytes = await _selectedImageFile!.readAsBytes();
    final photoName = _selectedImageFile!.name;

    bool success = await _apiService.submitWasteReport(
      photoBytes: photoBytes,
      photoName: photoName,
      location: _locationController.text,
      category: 'Umum',
      description: _descriptionController.text,
      token: token,
    );

    setState(() => _isSubmitting = false);

    if (success && mounted) {
      ScaffoldMessenger.of(context).showSnackBar(const SnackBar(content: Text('Laporan berhasil dikirim!')));
      _descriptionController.clear();
      _locationController.clear();
      setState(() {
        _selectedImageFile = null;
        _selectedImageBytes = null;
      });
    } else {
      if (mounted) ScaffoldMessenger.of(context).showSnackBar(const SnackBar(content: Text('Gagal mengirim laporan.')));
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF0FDF4),
      body: SafeArea(
        child: SingleChildScrollView(
          padding: const EdgeInsets.all(16),
          child: Column(
            children: [
              _buildUploadCard(),
              const SizedBox(height: 20),
              // Tambahkan ListView di sini untuk menampilkan _reports jika perlu
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildUploadCard() {
    return Container(
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(20)),
      child: Column(
        children: [
          GestureDetector(
            onTap: () => _pickImage(ImageSource.gallery),
            child: _selectedImageBytes != null
                ? Image.memory(_selectedImageBytes!, height: 150)
                : const Icon(Icons.add_a_photo, size: 50),
          ),
          TextField(controller: _locationController, decoration: const InputDecoration(hintText: 'Lokasi')),
          TextField(controller: _descriptionController, decoration: const InputDecoration(hintText: 'Deskripsi')),
          const SizedBox(height: 20),
          ElevatedButton(
            onPressed: _isSubmitting ? null : _submitReport,
            child: _isSubmitting ? const CircularProgressIndicator() : const Text('Kirim Laporan'),
          ),
        ],
      ),
    );
  }
}