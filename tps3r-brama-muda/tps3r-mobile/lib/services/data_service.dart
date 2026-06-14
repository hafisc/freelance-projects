import '../models/member.dart';
import '../models/tps_info.dart';
import '../models/waste_item.dart';

class DataService {
  static final List<Member> members = [
    Member(name: 'Intan Permata', role: 'Koordinator', active: true, avatarInitial: 'I'),
    Member(name: 'Rizki Adi', role: 'Relawan', active: true, avatarInitial: 'R'),
    Member(name: 'Nina Sari', role: 'Administrasi', active: false, avatarInitial: 'N'),
    Member(name: 'Dedi Santoso', role: 'Teknisi', active: true, avatarInitial: 'D'),
    Member(name: 'Putri Lestari', role: 'Pemandu', active: true, avatarInitial: 'P'),
  ];

  static final List<WasteItem> wasteItems = [
    WasteItem(type: 'Plastik PET', weight: 12.5, date: DateTime.now().subtract(const Duration(days: 1)), status: WasteStatus.recycled, category: WasteCategory.recycle),
    WasteItem(type: 'Sisa Makanan', weight: 8.2, date: DateTime.now().subtract(const Duration(days: 2)), status: WasteStatus.processing, category: WasteCategory.organic),
    WasteItem(type: 'Kertas Karton', weight: 4.0, date: DateTime.now().subtract(const Duration(days: 1)), status: WasteStatus.recycled, category: WasteCategory.recycle),
    WasteItem(type: 'Botol Kaca', weight: 3.1, date: DateTime.now().subtract(const Duration(days: 3)), status: WasteStatus.pending, category: WasteCategory.recycle),
    WasteItem(type: 'Kompos Sayur', weight: 10.4, date: DateTime.now().subtract(const Duration(days: 4)), status: WasteStatus.processing, category: WasteCategory.organic),
    WasteItem(type: 'Logam Bekas', weight: 6.8, date: DateTime.now().subtract(const Duration(days: 5)), status: WasteStatus.recycled, category: WasteCategory.inorganic),
    WasteItem(type: 'Kaleng Aluminium', weight: 5.2, date: DateTime.now().subtract(const Duration(days: 1)), status: WasteStatus.processing, category: WasteCategory.recycle),
  ];

  static final TpsInfo tpsInfo = TpsInfo(
    name: 'TPS 3R Bersih Sejahtera',
    address: 'Jl. Hijau Berseri No. 7, Kota Ramah Lingkungan',
    history: 'TPS 3R kami mulai beroperasi sejak tahun 2018 sebagai pusat pengelolaan sampah terpadu yang mengedepankan daur ulang, komposting, dan pemrosesan sampah organik/anorganik menjadi sumber daya baru.',
    vision: 'Menjadi pusat pengelolaan sampah 3R terdepan yang mendukung masyarakat dan lingkungan hidup berkelanjutan.',
    mission: 'Mengurangi sampah, meningkatkan kualitas lingkungan, dan memberdayakan komunitas melalui program edukasi dan layanan TPS 3R modern.',
    teamSize: 18,
    dailyTonnage: 4,
    recycleRate: 72,
  );

  static final Map<String, double> statisticData = {
    'Organik': 44,
    'Anorganik': 20,
    'Daur Ulang': 36,
  };

  static List<WasteItem> filteredWaste(String query, String status) {
    final normalized = query.trim().toLowerCase();
    return wasteItems.where((item) {
      final matchesQuery = normalized.isEmpty || item.type.toLowerCase().contains(normalized);
      final matchesStatus = status == 'Semua' || item.status.name.toLowerCase() == status.toLowerCase();
      return matchesQuery && matchesStatus;
    }).toList();
  }
}
