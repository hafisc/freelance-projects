import 'package:flutter/material.dart';
import '../models/waste_item.dart';

class WasteFormDialog extends StatefulWidget {
  final WasteItem? wasteItem;
  final Function(WasteItem) onSave;

  const WasteFormDialog({super.key, this.wasteItem, required this.onSave});

  @override
  State<WasteFormDialog> createState() => _WasteFormDialogState();
}

class _WasteFormDialogState extends State<WasteFormDialog> {
  final _formKey = GlobalKey<FormState>();
  late TextEditingController _typeController;
  late TextEditingController _weightController;
  late WasteStatus _selectedStatus;
  late WasteCategory _selectedCategory;
  late DateTime _selectedDate;

  @override
  void initState() {
    super.initState();
    _typeController = TextEditingController(text: widget.wasteItem?.type ?? '');
    _weightController = TextEditingController(text: widget.wasteItem?.weight.toString() ?? '');
    _selectedStatus = widget.wasteItem?.status ?? WasteStatus.pending;
    _selectedCategory = widget.wasteItem?.category ?? WasteCategory.organic;
    _selectedDate = widget.wasteItem?.date ?? DateTime.now();
  }

  @override
  void dispose() {
    _typeController.dispose();
    _weightController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    final isEditing = widget.wasteItem != null;

    return Dialog(
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(24)),
      child: Container(
        constraints: const BoxConstraints(maxWidth: 500),
        padding: const EdgeInsets.all(24),
        child: Form(
          key: _formKey,
          child: Column(
            mainAxisSize: MainAxisSize.min,
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Row(
                children: [
                  Icon(
                    isEditing ? Icons.edit : Icons.add_circle,
                    color: Colors.green.shade700,
                    size: 28,
                  ),
                  const SizedBox(width: 12),
                  Text(
                    isEditing ? 'Edit Data Sampah' : 'Tambah Data Sampah',
                    style: const TextStyle(fontSize: 20, fontWeight: FontWeight.w700),
                  ),
                ],
              ),
              const SizedBox(height: 24),
              TextFormField(
                controller: _typeController,
                decoration: const InputDecoration(
                  labelText: 'Jenis Sampah',
                  prefixIcon: Icon(Icons.delete_outline),
                ),
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return 'Jenis sampah tidak boleh kosong';
                  }
                  return null;
                },
              ),
              const SizedBox(height: 16),
              TextFormField(
                controller: _weightController,
                keyboardType: TextInputType.number,
                decoration: const InputDecoration(
                  labelText: 'Berat (kg)',
                  prefixIcon: Icon(Icons.scale),
                ),
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return 'Berat tidak boleh kosong';
                  }
                  final weight = double.tryParse(value);
                  if (weight == null || weight <= 0) {
                    return 'Berat harus berupa angka positif';
                  }
                  return null;
                },
              ),
              const SizedBox(height: 16),
              DropdownButtonFormField<WasteCategory>(
                initialValue: _selectedCategory,
                decoration: const InputDecoration(
                  labelText: 'Kategori',
                  prefixIcon: Icon(Icons.category),
                ),
                items: WasteCategory.values.map((category) {
                  return DropdownMenuItem(
                    value: category,
                    child: Text(_getCategoryLabel(category)),
                  );
                }).toList(),
                onChanged: (value) {
                  if (value != null) setState(() => _selectedCategory = value);
                },
              ),
              const SizedBox(height: 16),
              DropdownButtonFormField<WasteStatus>(
                initialValue: _selectedStatus,
                decoration: const InputDecoration(
                  labelText: 'Status',
                  prefixIcon: Icon(Icons.flag),
                ),
                items: WasteStatus.values.map((status) {
                  return DropdownMenuItem(
                    value: status,
                    child: Text(_getStatusLabel(status)),
                  );
                }).toList(),
                onChanged: (value) {
                  if (value != null) setState(() => _selectedStatus = value);
                },
              ),
              const SizedBox(height: 16),
              InkWell(
                onTap: _selectDate,
                child: InputDecorator(
                  decoration: const InputDecoration(
                    labelText: 'Tanggal',
                    prefixIcon: Icon(Icons.calendar_today),
                  ),
                  child: Text(
                    '${_selectedDate.day.toString().padLeft(2, '0')}/${_selectedDate.month.toString().padLeft(2, '0')}/${_selectedDate.year}',
                    style: const TextStyle(fontSize: 16),
                  ),
                ),
              ),
              const SizedBox(height: 24),
              Row(
                mainAxisAlignment: MainAxisAlignment.end,
                children: [
                  TextButton(
                    onPressed: () => Navigator.of(context).pop(),
                    child: const Text('Batal'),
                  ),
                  const SizedBox(width: 12),
                  ElevatedButton(
                    onPressed: _saveWasteItem,
                    child: Text(isEditing ? 'Simpan Perubahan' : 'Tambah Data'),
                  ),
                ],
              ),
            ],
          ),
        ),
      ),
    );
  }

  void _selectDate() async {
    final picked = await showDatePicker(
      context: context,
      initialDate: _selectedDate,
      firstDate: DateTime(2020),
      lastDate: DateTime.now(),
    );
    if (picked != null) {
      setState(() => _selectedDate = picked);
    }
  }

  void _saveWasteItem() {
    if (_formKey.currentState!.validate()) {
      final type = _typeController.text.trim();
      final weight = double.parse(_weightController.text);

      final wasteItem = WasteItem(
        type: type,
        weight: weight,
        date: _selectedDate,
        status: _selectedStatus,
        category: _selectedCategory,
      );

      widget.onSave(wasteItem);
      Navigator.of(context).pop();
    }
  }

  String _getCategoryLabel(WasteCategory category) {
    switch (category) {
      case WasteCategory.organic:
        return 'Organik';
      case WasteCategory.inorganic:
        return 'Anorganik';
      case WasteCategory.recycle:
        return 'Daur Ulang';
    }
  }

  String _getStatusLabel(WasteStatus status) {
    switch (status) {
      case WasteStatus.pending:
        return 'Pending';
      case WasteStatus.processing:
        return 'Processing';
      case WasteStatus.recycled:
        return 'Recycled';
    }
  }
}