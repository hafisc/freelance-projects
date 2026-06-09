import 'package:flutter/material.dart';
import '../models/member.dart';

class MemberFormDialog extends StatefulWidget {
  final Member? member;
  final Function(Member) onSave;

  const MemberFormDialog({super.key, this.member, required this.onSave});

  @override
  State<MemberFormDialog> createState() => _MemberFormDialogState();
}

class _MemberFormDialogState extends State<MemberFormDialog> {
  final _formKey = GlobalKey<FormState>();
  late TextEditingController _nameController;
  late TextEditingController _roleController;
  late bool _isActive;

  @override
  void initState() {
    super.initState();
    _nameController = TextEditingController(text: widget.member?.name ?? '');
    _roleController = TextEditingController(text: widget.member?.role ?? '');
    _isActive = widget.member?.active ?? true;
  }

  @override
  void dispose() {
    _nameController.dispose();
    _roleController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    final isEditing = widget.member != null;

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
                    isEditing ? Icons.edit : Icons.person_add,
                    color: Colors.green.shade700,
                    size: 28,
                  ),
                  const SizedBox(width: 12),
                  Text(
                    isEditing ? 'Edit Member' : 'Tambah Member Baru',
                    style: const TextStyle(fontSize: 20, fontWeight: FontWeight.w700),
                  ),
                ],
              ),
              const SizedBox(height: 24),
              TextFormField(
                controller: _nameController,
                decoration: const InputDecoration(
                  labelText: 'Nama Lengkap',
                  prefixIcon: Icon(Icons.person),
                ),
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return 'Nama tidak boleh kosong';
                  }
                  return null;
                },
              ),
              const SizedBox(height: 16),
              TextFormField(
                controller: _roleController,
                decoration: const InputDecoration(
                  labelText: 'Peran/Jabatan',
                  prefixIcon: Icon(Icons.work),
                ),
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return 'Peran tidak boleh kosong';
                  }
                  return null;
                },
              ),
              const SizedBox(height: 16),
              SwitchListTile(
                title: const Text('Status Aktif'),
                subtitle: Text(_isActive ? 'Member aktif dan dapat mengakses sistem' : 'Member tidak aktif'),
                value: _isActive,
                onChanged: (value) => setState(() => _isActive = value),
                activeThumbColor: Colors.green.shade700,
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
                    onPressed: _saveMember,
                    child: Text(isEditing ? 'Simpan Perubahan' : 'Tambah Member'),
                  ),
                ],
              ),
            ],
          ),
        ),
      ),
    );
  }

  void _saveMember() {
    if (_formKey.currentState!.validate()) {
      final name = _nameController.text.trim();
      final role = _roleController.text.trim();
      final avatarInitial = name.isNotEmpty ? name[0].toUpperCase() : 'U';

      final member = Member(
        name: name,
        role: role,
        active: _isActive,
        avatarInitial: avatarInitial,
      );

      widget.onSave(member);
      Navigator.of(context).pop();
    }
  }
}