import 'package:flutter/material.dart';
import '../../../app/theme.dart';
import '../../../app/routes.dart';
import '../../../core/widgets/empty_state.dart';
import '../../../core/widgets/loading_view.dart';
import '../../auth/models/user_model.dart';
import '../../auth/services/auth_service.dart';
import '../models/job_model.dart';
import '../services/job_service.dart';
import '../widgets/job_card.dart';
import '../../notifications/services/notification_service.dart';

class HomeScreen extends StatefulWidget {
  const HomeScreen({super.key});

  @override
  State<HomeScreen> createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  final AuthService _authService = AuthService();
  final JobService _jobService = JobService();
  final NotificationService _notificationService = NotificationService();
  final TextEditingController _searchController = TextEditingController();

  UserModel? _currentUser;
  late Future<List<JobModel>> _jobsFuture;
  int _unreadNotificationsCount = 0;

  String _selectedCategory = 'Semua';
  String _selectedLocation = 'Semua';

  final List<String> _categories = [
    'Semua',
    'Administrasi',
    'Sales/Marketing',
    'F&B/Retail',
    'Operasional/Lapangan',
    'Teknologi/IT',
  ];

  final List<String> _locations = [
    'Semua',
    'Jakarta Barat',
    'Jakarta Selatan',
    'Tangerang',
    'Bekasi',
    'Malang',
    'Surabaya',
  ];

  @override
  void initState() {
    super.initState();
    _loadUser();
    _loadJobs();
    _loadNotifications();
  }

  // Fungsi untuk mengambil jumlah notifikasi belum dibaca dari API Laravel
  void _loadNotifications() async {
    try {
      final data = await _notificationService.getNotifications();
      final unread = data.where((n) => !n.isRead).length;
      if (mounted) {
        setState(() {
          _unreadNotificationsCount = unread;
        });
      }
    } catch (e) {
      debugPrint('Gagal memuat jumlah notifikasi: $e');
    }
  }


  @override
  void dispose() {
    _searchController.dispose();
    super.dispose();
  }

  void _loadUser() async {
    final user = await _authService.getCachedUser();
    setState(() {
      _currentUser = user;
    });
  }

  void _loadJobs() {
    setState(() {
      _jobsFuture = _jobService.getJobs();
    });
  }

  // Fungsi untuk mendapatkan ucapan salam dinamis berdasarkan waktu lokal (pagi/siang/sore/malam)
  String _getDynamicGreeting() {
    final hour = DateTime.now().hour;
    if (hour < 11) {
      return 'Selamat Pagi ☀️';
    } else if (hour < 15) {
      return 'Selamat Siang 🌤️';
    } else if (hour < 18) {
      return 'Selamat Sore ⛅';
    } else {
      return 'Selamat Malam 🌙';
    }
  }

  // Fungsi untuk menampilkan Bottom Sheet filter yang rapi, kreatif, dan modern
  void _showFilterBottomSheet(BuildContext context) {
    showModalBottomSheet(
      context: context,
      isScrollControlled: true,
      backgroundColor: Colors.transparent,
      builder: (context) {
        return StatefulBuilder(
          builder: (context, setSheetState) {
            return Container(
              decoration: const BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.only(
                  topLeft: Radius.circular(28),
                  topRight: Radius.circular(28),
                ),
              ),
              padding: EdgeInsets.fromLTRB(
                24,
                16,
                24,
                MediaQuery.of(context).padding.bottom + 24,
              ),
              child: Column(
                mainAxisSize: MainAxisSize.min,
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  // Batang pegangan seret atas (Aesthetic drag handle)
                  Center(
                    child: Container(
                      width: 40,
                      height: 4,
                      decoration: BoxDecoration(
                        color: const Color(0xffe2e8f0),
                        borderRadius: BorderRadius.circular(2),
                      ),
                    ),
                  ),
                  const SizedBox(height: 18),
                  // Judul & Tombol Reset
                  Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      const Text(
                        'Filter Lowongan',
                        style: TextStyle(
                          fontSize: 18,
                          fontWeight: FontWeight.bold,
                          color: AppTheme.textPrimary,
                        ),
                      ),
                      TextButton(
                        onPressed: () {
                          setSheetState(() {
                            _selectedCategory = 'Semua';
                            _selectedLocation = 'Semua';
                          });
                        },
                        style: TextButton.styleFrom(
                          foregroundColor: AppTheme.danger,
                          padding: EdgeInsets.zero,
                          minimumSize: const Size(50, 30),
                          tapTargetSize: MaterialTapTargetSize.shrinkWrap,
                        ),
                        child: const Text(
                          'Reset',
                          style: TextStyle(
                            fontWeight: FontWeight.bold,
                            fontSize: 13,
                          ),
                        ),
                      ),
                    ],
                  ),
                  const Divider(color: Color(0xfff1f5f9), height: 24),
                  
                  // Filter Kategori Pekerjaan
                  const Text(
                    'KATEGORI PEKERJAAN',
                    style: TextStyle(
                      fontSize: 11,
                      fontWeight: FontWeight.bold,
                      color: AppTheme.textSecondary,
                      letterSpacing: 0.8,
                    ),
                  ),
                  const SizedBox(height: 12),
                  Wrap(
                    spacing: 8,
                    runSpacing: 8,
                    children: _categories.map((cat) {
                      final isSelected = _selectedCategory == cat;
                      return ChoiceChip(
                        label: Text(cat),
                        selected: isSelected,
                        onSelected: (selected) {
                          setSheetState(() {
                            _selectedCategory = cat;
                          });
                        },
                        selectedColor: AppTheme.primaryBlue,
                        backgroundColor: const Color(0xfff1f5f9),
                        labelStyle: TextStyle(
                          fontSize: 12,
                          fontWeight: FontWeight.bold,
                          color: isSelected ? Colors.white : AppTheme.textSecondary,
                        ),
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(10),
                          side: BorderSide(
                            color: isSelected ? AppTheme.primaryBlue : Colors.transparent,
                          ),
                        ),
                        showCheckmark: false,
                        padding: const EdgeInsets.symmetric(horizontal: 6, vertical: 4),
                      );
                    }).toList(),
                  ),
                  const SizedBox(height: 24),

                  // Filter Lokasi Bekerja
                  const Text(
                    'LOKASI BEKERJA',
                    style: TextStyle(
                      fontSize: 11,
                      fontWeight: FontWeight.bold,
                      color: AppTheme.textSecondary,
                      letterSpacing: 0.8,
                    ),
                  ),
                  const SizedBox(height: 12),
                  Wrap(
                    spacing: 8,
                    runSpacing: 8,
                    children: _locations.map((loc) {
                      final isSelected = _selectedLocation == loc;
                      return ChoiceChip(
                        label: Text(loc),
                        selected: isSelected,
                        onSelected: (selected) {
                          setSheetState(() {
                            _selectedLocation = loc;
                          });
                        },
                        selectedColor: AppTheme.primaryBlue,
                        backgroundColor: const Color(0xfff1f5f9),
                        labelStyle: TextStyle(
                          fontSize: 12,
                          fontWeight: FontWeight.bold,
                          color: isSelected ? Colors.white : AppTheme.textSecondary,
                        ),
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(10),
                          side: BorderSide(
                            color: isSelected ? AppTheme.primaryBlue : Colors.transparent,
                          ),
                        ),
                        showCheckmark: false,
                        padding: const EdgeInsets.symmetric(horizontal: 6, vertical: 4),
                      );
                    }).toList(),
                  ),
                  const SizedBox(height: 32),

                  // Tombol Terapkan
                  SizedBox(
                    width: double.infinity,
                    child: ElevatedButton(
                      onPressed: () {
                        setState(() {});
                        Navigator.pop(context);
                      },
                      child: const Text('Terapkan Filter'),
                    ),
                  ),
                ],
              ),
            );
          },
        );
      },
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xfff8fafc), // Slate background
      body: SafeArea(
        child: RefreshIndicator(
          onRefresh: () async {
            _loadUser();
            _loadJobs();
          },
          color: AppTheme.primaryBlue,
          child: CustomScrollView(
            physics: const AlwaysScrollableScrollPhysics(),
            slivers: [
              // Premium Header Section (Desain Rapi, Kreatif & Keren)
              SliverToBoxAdapter(
                child: Container(
                  padding: const EdgeInsets.fromLTRB(24, 24, 24, 28),
                  decoration: BoxDecoration(
                    color: Colors.white,
                    borderRadius: const BorderRadius.only(
                      bottomLeft: Radius.circular(32),
                      bottomRight: Radius.circular(32),
                    ),
                    boxShadow: [
                      BoxShadow(
                        color: const Color(0xff0f172a).withOpacity(0.04),
                        blurRadius: 20,
                        offset: const Offset(0, 8),
                      ),
                    ],
                  ),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      // Top Row: Brand Logo & Notification Action
                      Row(
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        children: [
                          // App Branding (Logo + Name)
                          Row(
                            children: [
                              Container(
                                width: 36,
                                height: 36,
                                decoration: BoxDecoration(
                                  color: Colors.white,
                                  borderRadius: BorderRadius.circular(10),
                                  boxShadow: [
                                    BoxShadow(
                                      color: const Color(0xff0f172a).withOpacity(0.06),
                                      blurRadius: 10,
                                      offset: const Offset(0, 4),
                                    ),
                                  ],
                                  border: Border.all(
                                    color: const Color(0xffe2e8f0),
                                    width: 1,
                                  ),
                                ),
                                child: ClipRRect(
                                  borderRadius: BorderRadius.circular(10),
                                  child: Image.asset(
                                    'assets/images/logo.jpg',
                                    fit: BoxFit.contain,
                                  ),
                                ),
                              ),
                              const SizedBox(width: 10),
                              const Text.rich(
                                TextSpan(
                                  children: [
                                    TextSpan(
                                      text: 'GLORIA ',
                                      style: TextStyle(
                                        color: AppTheme.primaryBlue,
                                        fontWeight: FontWeight.w900,
                                        fontSize: 18,
                                        letterSpacing: 0.5,
                                      ),
                                    ),
                                    TextSpan(
                                      text: 'JOB',
                                      style: TextStyle(
                                        color: AppTheme.primaryDark,
                                        fontWeight: FontWeight.w600,
                                        fontSize: 18,
                                        letterSpacing: 0.5,
                                      ),
                                    ),
                                  ],
                                ),
                              ),
                            ],
                          ),
                          // Premium Notification Bell (Desain minimalis berlingkar)
                          Container(
                            decoration: BoxDecoration(
                              color: const Color(0xfff8fafc),
                              shape: BoxShape.circle,
                              border: Border.all(
                                color: const Color(0xffe2e8f0),
                                width: 1,
                              ),
                            ),
                            child: Stack(
                              clipBehavior: Clip.none,
                              children: [
                                IconButton(
                                  onPressed: () async {
                                    await Navigator.pushNamed(
                                      context,
                                      AppRoutes.notifications,
                                    );
                                    _loadNotifications();
                                  },
                                  icon: Icon(
                                    _unreadNotificationsCount > 0
                                        ? Icons.notifications_active_outlined
                                        : Icons.notifications_none_rounded,
                                    color: AppTheme.primaryBlue,
                                    size: 20,
                                  ),
                                  constraints: const BoxConstraints(),
                                  padding: const EdgeInsets.all(10),
                                ),
                                if (_unreadNotificationsCount > 0)
                                  Positioned(
                                    top: 8,
                                    right: 8,
                                    child: Container(
                                      width: 8,
                                      height: 8,
                                      decoration: const BoxDecoration(
                                        color: AppTheme.danger,
                                        shape: BoxShape.circle,
                                      ),
                                    ),
                                  ),
                              ],
                            ),
                          ),
                        ],
                      ),
                      const SizedBox(height: 24),
                      // Greeting & Personalized Text
                      Text(
                        _getDynamicGreeting(),
                        style: const TextStyle(
                          fontSize: 13,
                          fontWeight: FontWeight.w600,
                          color: AppTheme.textSecondary,
                        ),
                      ),
                      const SizedBox(height: 6),
                      Text(
                        _currentUser?.name ?? 'Pelamar Kerja',
                        style: const TextStyle(
                          fontSize: 26,
                          fontWeight: FontWeight.w900,
                          color: AppTheme.textPrimary,
                          letterSpacing: -0.8,
                        ),
                      ),
                      const SizedBox(height: 8),
                      const Text(
                        'Temukan lowongan kerja impian Anda di PT. Gloria Jasa Mandiri.',
                        style: TextStyle(
                          fontSize: 13,
                          color: AppTheme.textSecondary,
                          fontWeight: FontWeight.w400,
                          height: 1.4,
                        ),
                      ),
                      const SizedBox(height: 20),
                      // Search Bar Row with integrated Filter Button
                      Row(
                        children: [
                          Expanded(
                            child: TextField(
                              controller: _searchController,
                              onChanged: (value) {
                                setState(() {}); // Memicu pembangunan ulang untuk filter data
                              },
                              style: const TextStyle(
                                color: AppTheme.textPrimary,
                                fontSize: 14,
                                fontWeight: FontWeight.w500,
                              ),
                              decoration: InputDecoration(
                                hintText: 'Cari posisi, lokasi, atau kualifikasi...',
                                hintStyle: const TextStyle(
                                  color: AppTheme.textSecondary,
                                  fontSize: 14,
                                ),
                                prefixIcon: const Icon(
                                  Icons.search_rounded,
                                  color: AppTheme.primaryBlue,
                                  size: 22,
                                ),
                                suffixIcon: _searchController.text.isNotEmpty
                                    ? IconButton(
                                        icon: const Icon(
                                          Icons.clear_rounded,
                                          color: AppTheme.textSecondary,
                                          size: 18,
                                        ),
                                        onPressed: () {
                                          _searchController.clear();
                                          setState(() {});
                                        },
                                      )
                                    : null,
                                contentPadding: const EdgeInsets.symmetric(
                                  vertical: 16,
                                  horizontal: 20,
                                ),
                                filled: true,
                                fillColor: const Color(0xfff1f5f9),
                                border: OutlineInputBorder(
                                  borderRadius: BorderRadius.circular(20),
                                  borderSide: BorderSide.none,
                                ),
                                enabledBorder: OutlineInputBorder(
                                  borderRadius: BorderRadius.circular(20),
                                  borderSide: BorderSide.none,
                                ),
                                focusedBorder: OutlineInputBorder(
                                  borderRadius: BorderRadius.circular(20),
                                  borderSide: const BorderSide(
                                    color: AppTheme.primaryBlue,
                                    width: 1.5,
                                  ),
                                ),
                              ),
                            ),
                          ),
                          const SizedBox(width: 12),
                          // Premium Filter Button with Active State Color Feedback
                          GestureDetector(
                            onTap: () => _showFilterBottomSheet(context),
                            child: AnimatedContainer(
                              duration: const Duration(milliseconds: 200),
                              height: 56, // Matches the height of TextField
                              width: 56,
                              decoration: BoxDecoration(
                                color: _selectedCategory != 'Semua' || _selectedLocation != 'Semua'
                                    ? AppTheme.primaryBlue
                                    : const Color(0xfff1f5f9),
                                borderRadius: BorderRadius.circular(20),
                                border: Border.all(
                                  color: _selectedCategory != 'Semua' || _selectedLocation != 'Semua'
                                      ? AppTheme.primaryBlue
                                      : Colors.transparent,
                                  width: 1.5,
                                ),
                                boxShadow: _selectedCategory != 'Semua' || _selectedLocation != 'Semua'
                                    ? [
                                        BoxShadow(
                                          color: AppTheme.primaryBlue.withOpacity(0.2),
                                          blurRadius: 8,
                                          offset: const Offset(0, 4),
                                        )
                                      ]
                                    : [],
                              ),
                              child: Icon(
                                Icons.tune_rounded,
                                color: _selectedCategory != 'Semua' || _selectedLocation != 'Semua'
                                    ? Colors.white
                                    : AppTheme.primaryBlue,
                                size: 22,
                              ),
                            ),
                          ),
                        ],
                      ),
                      // Active Dismissible Filter Tags (Tag Filter Aktif)
                      if (_selectedCategory != 'Semua' || _selectedLocation != 'Semua') ...[
                        const SizedBox(height: 16),
                        SingleChildScrollView(
                          scrollDirection: Axis.horizontal,
                          physics: const BouncingScrollPhysics(),
                          child: Row(
                            children: [
                              if (_selectedCategory != 'Semua')
                                Padding(
                                  padding: const EdgeInsets.only(right: 8.0),
                                  child: Chip(
                                    label: Text('Bidang: $_selectedCategory'),
                                    onDeleted: () {
                                      setState(() {
                                        _selectedCategory = 'Semua';
                                      });
                                    },
                                    deleteIconColor: AppTheme.danger,
                                    backgroundColor: AppTheme.primaryBlue.withOpacity(0.08),
                                    labelStyle: const TextStyle(
                                      fontSize: 12,
                                      fontWeight: FontWeight.bold,
                                      color: AppTheme.primaryBlue,
                                    ),
                                    shape: RoundedRectangleBorder(
                                      borderRadius: BorderRadius.circular(12),
                                      side: BorderSide.none,
                                    ),
                                    padding: const EdgeInsets.symmetric(horizontal: 4, vertical: 2),
                                  ),
                                ),
                              if (_selectedLocation != 'Semua')
                                Padding(
                                  padding: const EdgeInsets.only(right: 8.0),
                                  child: Chip(
                                    label: Text('Lokasi: $_selectedLocation'),
                                    onDeleted: () {
                                      setState(() {
                                        _selectedLocation = 'Semua';
                                      });
                                    },
                                    deleteIconColor: AppTheme.danger,
                                    backgroundColor: AppTheme.primaryBlue.withOpacity(0.08),
                                    labelStyle: const TextStyle(
                                      fontSize: 12,
                                      fontWeight: FontWeight.bold,
                                      color: AppTheme.primaryBlue,
                                    ),
                                    shape: RoundedRectangleBorder(
                                      borderRadius: BorderRadius.circular(12),
                                      side: BorderSide.none,
                                    ),
                                    padding: const EdgeInsets.symmetric(horizontal: 4, vertical: 2),
                                  ),
                                ),
                            ],
                          ),
                        ),
                      ],
                    ],
                  ),
                ),
              ),

              // Section Title
              SliverToBoxAdapter(
                child: Padding(
                  padding: const EdgeInsets.fromLTRB(24, 20, 24, 16),
                  child: Row(
                    children: [
                      Container(
                        width: 4,
                        height: 18,
                        decoration: BoxDecoration(
                          color: AppTheme.primaryBlue,
                          borderRadius: BorderRadius.circular(2),
                        ),
                      ),
                      const SizedBox(width: 8),
                      const Text(
                        'Lowongan Pekerjaan Terbaru',
                        style: TextStyle(
                          fontSize: 16,
                          fontWeight: FontWeight.bold,
                          color: AppTheme.textPrimary,
                        ),
                      ),
                    ],
                  ),
                ),
              ),

              // Jobs List Builder with Realtime Filter
              FutureBuilder<List<JobModel>>(
                future: _jobsFuture,
                builder: (context, snapshot) {
                  if (snapshot.connectionState == ConnectionState.waiting) {
                    return const SliverFillRemaining(
                      hasScrollBody: false,
                      child: LoadingView(
                        message: 'Mengambil lowongan pekerjaan...',
                      ),
                    );
                  } else if (snapshot.hasError) {
                    return SliverFillRemaining(
                      hasScrollBody: false,
                      child: EmptyState(
                        title: 'Koneksi Gagal',
                        description: 'Gagal memuat lowongan: ${snapshot.error}',
                        icon: Icons.wifi_off_outlined,
                        buttonText: 'Coba Lagi',
                        onButtonPressed: _loadJobs,
                      ),
                    );
                  } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
                    return const SliverFillRemaining(
                      hasScrollBody: false,
                      child: EmptyState(
                        title: 'Tidak Ada Lowongan',
                        description:
                            'Saat ini belum ada lowongan pekerjaan aktif di PT. Gloria Jasa Mandiri.',
                        icon: Icons.work_off_outlined,
                      ),
                    );
                  }

                  final jobs = snapshot.data!;
                  final searchQuery = _searchController.text
                      .toLowerCase()
                      .trim();

                  // Local filtering logic
                  final filteredJobs = jobs.where((job) {
                    final matchesSearch = job.title.toLowerCase().contains(searchQuery) ||
                        job.companyName.toLowerCase().contains(searchQuery) ||
                        job.location.toLowerCase().contains(searchQuery) ||
                        job.qualification.toLowerCase().contains(searchQuery);

                    final matchesCategory = _selectedCategory == 'Semua' ||
                        job.category.toLowerCase() == _selectedCategory.toLowerCase() ||
                        (_selectedCategory == 'Teknologi/IT' && job.category.toLowerCase().contains('it')) ||
                        (_selectedCategory == 'Teknologi/IT' && job.title.toLowerCase().contains('developer'));

                    final matchesLocation = _selectedLocation == 'Semua' ||
                        job.location.toLowerCase().contains(_selectedLocation.toLowerCase());

                    return matchesSearch && matchesCategory && matchesLocation;
                  }).toList();

                  if (filteredJobs.isEmpty) {
                    return const SliverFillRemaining(
                      hasScrollBody: false,
                      child: EmptyState(
                        title: 'Tidak Menemukan Hasil',
                        description:
                            'Coba masukkan kata kunci pencarian lainnya atau ganti filter.',
                        icon: Icons.search_off_outlined,
                      ),
                    );
                  }

                  return SliverPadding(
                    padding: const EdgeInsets.symmetric(horizontal: 20),
                    sliver: SliverList(
                      delegate: SliverChildBuilderDelegate((context, index) {
                        final job = filteredJobs[index];
                        return JobCard(
                          job: job,
                          onTap: () {
                            debugPrint('!!! TAPPED JOB: ${job.title} !!!');
                            Navigator.pushNamed(
                              context,
                              AppRoutes.jobDetail,
                              arguments: job,
                            );
                          },
                        );
                      }, childCount: filteredJobs.length),
                    ),
                  );
                },
              ),
              const SliverToBoxAdapter(child: SizedBox(height: 100)),
            ],
          ),
        ),
      ),
    );
  }
}
