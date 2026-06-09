import 'dart:io';
import 'dart:typed_data';
import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';
import 'package:path_provider/path_provider.dart';
import 'package:shared_preferences/shared_preferences.dart';
import '../../services/api_service.dart';

class WasteReportSection extends StatefulWidget {
  const WasteReportSection({super.key});

  @override
  State<WasteReportSection> createState() => _WasteReportSectionState();
}

class _WasteReportSectionState extends State<WasteReportSection> {
  final _descriptionController = TextEditingController();
  final _locationController = TextEditingController();
  final ApiService _apiService = ApiService();
  final ImagePicker _imagePicker = ImagePicker();
  
  Uint8List? _selectedImageBytes;
  bool _isSubmitting = false;

  // Fungsi ambil gambar (Kamera atau Galeri)
  Future<void> _pickImage(ImageSource source) async {
    final XFile? pickedFile = await _imagePicker.pickImage(
      source: source,
      maxWidth: 1024,
      imageQuality: 80,
    );

    if (pickedFile != null) {
      final bytes = await pickedFile.readAsBytes();
      setState(() => _selectedImageBytes = bytes);
    }
  }

  Future<void> _submitReport() async {
    if (_descriptionController.text.isEmpty || _locationController.text.isEmpty || _selectedImageBytes == null) {
      ScaffoldMessenger.of(context).showSnackBar(const SnackBar(content: Text('Lengkapi form & foto!')));
      return;
    }

    final prefs = await SharedPreferences.getInstance();
    final String? token = prefs.getString('auth_token');

    if (token == null) {
      ScaffoldMessenger.of(context).showSnackBar(const SnackBar(content: Text('Sesi habis, silakan login kembali.')));
      return;
    }

    setState(() => _isSubmitting = true);

    try {
      bool success = await _apiService.submitWasteReport(
        photoBytes: _selectedImageBytes!,
        photoName: 'report_${DateTime.now().millisecondsSinceEpoch}.png',
        location: _locationController.text,
        category: 'Sampah Rumah Tangga',
        description: _descriptionController.text,
        token: token,
      );

      if (!mounted) return;

      if (success) {
        ScaffoldMessenger.of(context).showSnackBar(const SnackBar(content: Text('Laporan terkirim!'), backgroundColor: Colors.green));
        _descriptionController.clear();
        _locationController.clear();
        setState(() => _selectedImageBytes = null);
      } else {
        ScaffoldMessenger.of(context).showSnackBar(const SnackBar(content: Text('Gagal mengirim ke server.')));
      }
    } catch (e) {
      if (!mounted) return;
      ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text('Error: $e')));
    } finally {
      if (mounted) setState(() => _isSubmitting = false);
    }
  }

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        // AREA FOTO YANG LEBIH MENARIK
        Container(
          height: 200,
          width: double.infinity,
          decoration: BoxDecoration(
            color: Colors.white,
            borderRadius: BorderRadius.circular(20),
            border: Border.all(color: Colors.green.shade200),
            boxShadow: [BoxShadow(color: Colors.grey.shade200, blurRadius: 10, offset: const Offset(0, 5))],
          ),
          child: InkWell(
            onTap: () => _showPickerOptions(context),
            child: _selectedImageBytes != null 
                ? ClipRRect(borderRadius: BorderRadius.circular(20), child: Image.memory(_selectedImageBytes!, fit: BoxFit.cover))
                : Column(mainAxisAlignment: MainAxisAlignment.center, children: [
                    const Icon(Icons.camera_alt, size: 50, color: Colors.green),
                    Text("Ambil/Pilih Foto", style: TextStyle(color: Colors.green.shade700))
                  ]),
          ),
        ),
        const SizedBox(height: 20),
        _buildTextField(_locationController, "Lokasi Sampah", Icons.location_on),
        _buildTextField(_descriptionController, "Deskripsi Masalah", Icons.description, maxLines: 3),
        const SizedBox(height: 20),
        ElevatedButton(
          onPressed: _isSubmitting ? null : _submitReport,
          style: ElevatedButton.styleFrom(
            backgroundColor: Colors.green.shade600,
            padding: const EdgeInsets.symmetric(horizontal: 50, vertical: 15),
            shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(15)),
          ),
          child: _isSubmitting ? const CircularProgressIndicator(color: Colors.white) : const Text("KIRIM LAPORAN", style: TextStyle(color: Colors.white)),
        ),
      ],
    );
  }

  // Helper untuk desain TextField agar tidak polos
  Widget _buildTextField(TextEditingController controller, String hint, IconData icon, {int maxLines = 1}) {
    return Container(
      margin: const EdgeInsets.only(bottom: 15),
      child: TextField(
        controller: controller,
        maxLines: maxLines,
        decoration: InputDecoration(
          prefixIcon: Icon(icon, color: Colors.green),
          hintText: hint,
          filled: true,
          fillColor: Colors.grey.shade100,
          border: OutlineInputBorder(borderRadius: BorderRadius.circular(15), borderSide: BorderSide.none),
        ),
      ),
    );
  }

  // Dialog untuk memilih Kamera atau Galeri
  void _showPickerOptions(BuildContext context) {
    showModalBottomSheet(context: context, builder: (ctx) => Column(
      mainAxisSize: MainAxisSize.min,
      children: [
        ListTile(leading: const Icon(Icons.camera), title: const Text("Kamera"), onTap: () { _pickImage(ImageSource.camera); Navigator.pop(ctx); }),
        ListTile(leading: const Icon(Icons.photo), title: const Text("Galeri"), onTap: () { _pickImage(ImageSource.gallery); Navigator.pop(ctx); }),
      ],
    ));
  }
}