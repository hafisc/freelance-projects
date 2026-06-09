// lib/models/waste_item.dart (UPDATE)
class WasteItem {
  final int id;
  final String type;
  final double weight;
  final DateTime date;
  final WasteStatus status;
  final WasteCategory category;
  final String? notes;

  WasteItem({
    this.id = 0,
    required this.type,
    required this.weight,
    required this.date,
    required this.status,
    required this.category,
    this.notes,
  });
}

enum WasteStatus { pending, processing, recycled }
enum WasteCategory { organic, inorganic, recycle }