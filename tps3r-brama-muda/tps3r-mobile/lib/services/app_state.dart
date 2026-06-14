// lib/services/app_state.dart (UPDATE)
import 'package:flutter/material.dart';
import '../models/member.dart';
import '../models/waste_item.dart';
import '../models/tps_info.dart';
import 'api_service.dart';

class AppState extends ChangeNotifier {
  List<Member> _members = [];
  List<WasteItem> _wasteItems = [];
  TpsInfo? _tpsInfo;

  bool _isLoading = false;
  bool _isInitialized = false;
  String? _errorMessage;

  // Getters
  List<Member> get members => _members;
  List<WasteItem> get wasteItems => _wasteItems;
  TpsInfo? get tpsInfo => _tpsInfo;
  bool get isLoading => _isLoading;
  bool get isInitialized => _isInitialized;
  String? get errorMessage => _errorMessage;

  // Computed properties
  int get activeMembersCount => _members.where((m) => m.active).length;
  int get totalWasteItems => _wasteItems.length;
  double get totalWasteWeight => _wasteItems.fold(0, (sum, item) => sum + item.weight);
  Map<String, double> get wasteStatistics {
    final stats = <String, double>{};
    for (final item in _wasteItems) {
      final key = item.category.name;
      stats[key] = (stats[key] ?? 0) + item.weight;
    }
    return stats;
  }

  // ============================================================
  // INITIALIZATION - Ambil semua data dari API
  // ============================================================
  
  Future<void> initializeData() async {
    if (_isInitialized) return;
    
    _setLoading(true);
    try {
      // Ambil data secara paralel
      final results = await Future.wait([
        ApiService.getMembers(),
        ApiService.getWasteItems(),
        ApiService.getTpsInfo(),
      ]);

      // Parse members
      final membersResult = results[0];
      if (membersResult['success'] == true) {
        final membersData = membersResult['members'] as List;
        _members = membersData.map((m) => _parseMember(m)).toList();
      }

      // Parse waste items
      final wasteResult = results[1];
      if (wasteResult['success'] == true) {
        final wasteData = wasteResult['waste_items'] as List;
        _wasteItems = wasteData.map((w) => _parseWasteItem(w)).toList();
      }

      // Parse TPS info
      final tpsResult = results[2];
      if (tpsResult['success'] == true && tpsResult['tps_info'] != null) {
        _tpsInfo = _parseTpsInfo(tpsResult['tps_info']);
      }

      _isInitialized = true;
      _errorMessage = null;
    } catch (e) {
      _errorMessage = 'Gagal memuat data. Periksa koneksi internet.';
      debugPrint('Initialize data error: $e');
    } finally {
      _setLoading(false);
    }
  }

  // ============================================================
  // REFRESH DATA
  // ============================================================
  
  Future<void> refreshAll() async {
    _isInitialized = false;
    await initializeData();
  }

  Future<void> refreshMembers() async {
    _setLoading(true);
    try {
      final result = await ApiService.getMembers();
      if (result['success'] == true) {
        final membersData = result['members'] as List;
        _members = membersData.map((m) => _parseMember(m)).toList();
        notifyListeners();
      }
    } catch (e) {
      debugPrint('Refresh members error: $e');
    } finally {
      _setLoading(false);
    }
  }

  Future<void> refreshWasteItems() async {
    _setLoading(true);
    try {
      final result = await ApiService.getWasteItems();
      if (result['success'] == true) {
        final wasteData = result['waste_items'] as List;
        _wasteItems = wasteData.map((w) => _parseWasteItem(w)).toList();
        notifyListeners();
      }
    } catch (e) {
      debugPrint('Refresh waste items error: $e');
    } finally {
      _setLoading(false);
    }
  }

  // ============================================================
  // MEMBER OPERATIONS
  // ============================================================
  
  Future<bool> addMember({
    required String name,
    required String role,
    String? phone,
    String? email,
  }) async {
    _setLoading(true);
    try {
      final result = await ApiService.createMember(
        name: name,
        role: role,
        phone: phone,
        email: email,
      );

      if (result['success'] == true) {
        await refreshMembers();
        return true;
      } else {
        _setError(result['message'] ?? 'Gagal menambahkan member');
        return false;
      }
    } catch (e) {
      _setError('Gagal terhubung ke server');
      return false;
    } finally {
      _setLoading(false);
    }
  }

  Future<bool> updateMember({
    required int id,
    required String name,
    required String role,
    bool? active,
    String? phone,
    String? email,
  }) async {
    _setLoading(true);
    try {
      final result = await ApiService.updateMember(
        id: id,
        name: name,
        role: role,
        active: active,
        phone: phone,
        email: email,
      );

      if (result['success'] == true) {
        await refreshMembers();
        return true;
      } else {
        _setError(result['message'] ?? 'Gagal memperbarui member');
        return false;
      }
    } catch (e) {
      _setError('Gagal terhubung ke server');
      return false;
    } finally {
      _setLoading(false);
    }
  }

  Future<bool> deleteMember(int id) async {
    _setLoading(true);
    try {
      final result = await ApiService.deleteMember(id);

      if (result['success'] == true) {
        await refreshMembers();
        return true;
      } else {
        _setError(result['message'] ?? 'Gagal menghapus member');
        return false;
      }
    } catch (e) {
      _setError('Gagal terhubung ke server');
      return false;
    } finally {
      _setLoading(false);
    }
  }

  // ============================================================
  // WASTE OPERATIONS
  // ============================================================
  
  Future<bool> addWasteItem({
    required String type,
    required double weight,
    required WasteCategory category,
    WasteStatus status = WasteStatus.pending,
    String? notes,
  }) async {
    _setLoading(true);
    try {
      final result = await ApiService.createWasteItem(
        type: type,
        weight: weight,
        category: category.name,
        status: status.name,
        notes: notes,
      );

      if (result['success'] == true) {
        await refreshWasteItems();
        return true;
      } else {
        _setError(result['message'] ?? 'Gagal menambahkan data sampah');
        return false;
      }
    } catch (e) {
      _setError('Gagal terhubung ke server');
      return false;
    } finally {
      _setLoading(false);
    }
  }

  Future<bool> updateWasteItem({
    required int id,
    String? type,
    double? weight,
    WasteCategory? category,
    WasteStatus? status,
    String? notes,
  }) async {
    _setLoading(true);
    try {
      final result = await ApiService.updateWasteItem(
        id: id,
        type: type,
        weight: weight,
        category: category?.name,
        status: status?.name,
        notes: notes,
      );

      if (result['success'] == true) {
        await refreshWasteItems();
        return true;
      } else {
        _setError(result['message'] ?? 'Gagal memperbarui data sampah');
        return false;
      }
    } catch (e) {
      _setError('Gagal terhubung ke server');
      return false;
    } finally {
      _setLoading(false);
    }
  }

  Future<bool> deleteWasteItem(int id) async {
    _setLoading(true);
    try {
      final result = await ApiService.deleteWasteItem(id);

      if (result['success'] == true) {
        await refreshWasteItems();
        return true;
      } else {
        _setError(result['message'] ?? 'Gagal menghapus data sampah');
        return false;
      }
    } catch (e) {
      _setError('Gagal terhubung ke server');
      return false;
    } finally {
      _setLoading(false);
    }
  }

  // ============================================================
  // SEARCH AND FILTER
  // ============================================================
  
  List<Member> searchMembers(String query) {
    if (query.isEmpty) return _members;
    final lowercaseQuery = query.toLowerCase();
    return _members.where((member) =>
      member.name.toLowerCase().contains(lowercaseQuery) ||
      member.role.toLowerCase().contains(lowercaseQuery)
    ).toList();
  }

  List<WasteItem> filterWasteItems({String? query, WasteStatus? status, WasteCategory? category}) {
    return _wasteItems.where((item) {
      final matchesQuery = query == null || query.isEmpty ||
        item.type.toLowerCase().contains(query.toLowerCase());
      final matchesStatus = status == null || item.status == status;
      final matchesCategory = category == null || item.category == category;
      return matchesQuery && matchesStatus && matchesCategory;
    }).toList();
  }

  // ============================================================
  // PARSING HELPERS
  // ============================================================
  
  Member _parseMember(Map<String, dynamic> data) {
    return Member(
      id: data['id'] ?? 0,
      name: data['name'] ?? '',
      role: data['role'] ?? '',
      active: data['active'] ?? true,
      avatarInitial: (data['name'] ?? '').isNotEmpty 
          ? (data['name'] as String)[0].toUpperCase() 
          : '?',
      phone: data['phone'],
      email: data['email'],
    );
  }

  WasteItem _parseWasteItem(Map<String, dynamic> data) {
    return WasteItem(
      id: data['id'] ?? 0,
      type: data['type'] ?? '',
      weight: (data['weight'] ?? 0).toDouble(),
      date: data['date'] != null 
          ? DateTime.tryParse(data['date'].toString()) ?? DateTime.now()
          : DateTime.now(),
      status: _parseWasteStatus(data['status']),
      category: _parseWasteCategory(data['category']),
      notes: data['notes'],
    );
  }

  WasteStatus _parseWasteStatus(String? status) {
    switch (status?.toLowerCase()) {
      case 'processing':
        return WasteStatus.processing;
      case 'recycled':
      case 'completed':
      case 'selesai':
        return WasteStatus.recycled;
      default:
        return WasteStatus.pending;
    }
  }

  WasteCategory _parseWasteCategory(String? category) {
    switch (category?.toLowerCase()) {
      case 'organic':
        return WasteCategory.organic;
      case 'inorganic':
        return WasteCategory.inorganic;
      case 'recycle':
      default:
        return WasteCategory.recycle;
    }
  }

  TpsInfo _parseTpsInfo(Map<String, dynamic> data) {
    return TpsInfo(
      id: data['id'],
      name: data['name'] ?? '',
      address: data['address'] ?? '',
      history: data['history'],
      vision: data['vision'],
      mission: data['mission'],
      teamSize: data['team_size'] ?? 0,
      dailyTonnage: (data['daily_tonnage'] ?? 0).toDouble(),
      recycleRate: data['recycle_rate'] ?? 0,
      phone: data['phone'],
      email: data['email'],
      operationalHours: data['operational_hours'],
    );
  }

  // ============================================================
  // UTILITY METHODS
  // ============================================================
  
  void _setLoading(bool loading) {
    _isLoading = loading;
    if (loading) _errorMessage = null;
    notifyListeners();
  }

  void _setError(String message) {
    _errorMessage = message;
    notifyListeners();
  }

  void clearError() {
    _errorMessage = null;
    notifyListeners();
  }
}
