// lib/models/tps_info.dart (UPDATE)
class TpsInfo {
  final int? id;
  final String name;
  final String address;
  final String? history;
  final String? vision;
  final String? mission;
  final int teamSize;
  final double dailyTonnage;
  final int recycleRate;
  final String? phone;
  final String? email;
  final String? operationalHours;

  TpsInfo({
    this.id,
    required this.name,
    required this.address,
    this.history,
    this.vision,
    this.mission,
    this.teamSize = 0,
    this.dailyTonnage = 0,
    this.recycleRate = 0,
    this.phone,
    this.email,
    this.operationalHours,
  });
}