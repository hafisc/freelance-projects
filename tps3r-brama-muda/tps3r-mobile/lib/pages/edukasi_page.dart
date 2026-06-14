import 'package:flutter/material.dart';
import 'package:flutter/foundation.dart';
import '../services/api_service.dart';
import '../models/edukasi_model.dart';

/// ============================================================
/// EdukasiPage - Halaman Edukasi Sampah
/// ============================================================
/// Menampilkan data edukasi dari database (Laravel API)
/// Layout modern dan clean dengan spacing konsisten
///
/// Author: Claude
/// ============================================================

class EdukasiPage extends StatefulWidget {
  const EdukasiPage({super.key});

  @override
  State<EdukasiPage> createState() => _EdukasiPageState();
}

class _EdukasiPageState extends State<EdukasiPage> {
  // State untuk data dari API
  bool _isLoading = true;
  List<EdukasiItem> _edukasiList = [];

  @override
  void initState() {
    super.initState();
    _loadEdukasiData();
  }

  Future<void> _loadEdukasiData() async {
    setState(() => _isLoading = true);

    try {
      final result = await ApiService.getEdukasi();

      // Sekarang kita mencari key 'data' sesuai struktur Laravel
      if (result['success'] == true && result['data'] != null) {

        // result['data'] adalah Map yang berisi key 'data' (List)
        final Map<String, dynamic> responseData = result['data'];

        if (responseData.containsKey('data')) {
          final List<dynamic> listData = responseData['data'];

          setState(() {
            // Mapping list dari JSON ke List<EdukasiItem>
            _edukasiList = listData.map((item) => EdukasiItem.fromJson(item)).toList();
            _isLoading = false;
          });
        }
      } else {
        debugPrint('Gagal: ${result['message']}');
        setState(() => _isLoading = false);
      }
    } catch (e) {
      debugPrint('Error: $e');
      setState(() => _isLoading = false);
    }
  }

  /// Refresh data
  Future<void> _refreshData() async {
    await _loadEdukasiData();
  }

  /// Format tanggal ke format Indonesia
  String _formatDate(DateTime date) {
    const months = [
      'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
      'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
    ];
    return '${date.day} ${months[date.month - 1]} ${date.year}';
  }

  /// ============================================================
  /// FUNGSI BARU: Helper untuk mendapatkan full URL gambar
  /// ============================================================
  String _getFullImageUrl(String path) {
    if (path.startsWith('http')) return path;

    String baseStorageUrl;
    if (kIsWeb) {
      baseStorageUrl = 'http://127.0.0.1:8000/storage';
    } else {
      baseStorageUrl = defaultTargetPlatform == TargetPlatform.android
          ? 'http://10.0.2.2:8000/storage'
          : 'http://127.0.0.1:8000/storage';
    }
    return '$baseStorageUrl/$path';
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF0FDF4),
      body: SafeArea(
        child: _isLoading ? _buildLoadingState() : _buildContent(),
      ),
    );
  }

  /// Loading state
  Widget _buildLoadingState() {
    return Center(
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          const CircularProgressIndicator(
            color: Color(0xFF10B981),
            strokeWidth: 3,
          ),
          const SizedBox(height: 16),
          Text(
            'Memuat data edukasi...',
            style: TextStyle(
              color: Colors.grey.shade600,
              fontSize: 14,
            ),
          ),
        ],
      ),
    );
  }

  /// Main content
  Widget _buildContent() {
    return RefreshIndicator(
      onRefresh: _refreshData,
      color: const Color(0xFF10B981),
      child: LayoutBuilder(
        builder: (context, constraints) {
          final screenWidth = constraints.maxWidth;
          final double horizontalPadding;
          final double spacing;

          // Adaptive sizing based on screen width
          if (screenWidth < 340) {
            horizontalPadding = 12.0;
            spacing = 10.0;
          } else if (screenWidth < 400) {
            horizontalPadding = 14.0;
            spacing = 12.0;
          } else {
            horizontalPadding = 16.0;
            spacing = 14.0;
          }

          return SingleChildScrollView(
            physics: const BouncingScrollPhysics(),
            padding: EdgeInsets.symmetric(horizontal: horizontalPadding),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                SizedBox(height: spacing),
                // Header Banner
                _buildHeaderBanner(screenWidth),
                SizedBox(height: spacing * 2),
                // Articles List
                ..._buildArticlesList(),
                SizedBox(height: spacing * 4),
              ],
            ),
          );
        },
      ),
    );
  }

  /// Build articles list
  List<Widget> _buildArticlesList() {
    if (_edukasiList.isEmpty) {
      return [
        _buildEmptyState(),
      ];
    }

    return _edukasiList.map((article) {
      return _buildArticleCard(article);
    }).toList();
  }

  /// Empty state
  Widget _buildEmptyState() {
    return Container(
      padding: const EdgeInsets.all(32),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withValues(alpha: 0.05),
            blurRadius: 12,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Column(
        children: [
          Icon(
            Icons.article_outlined,
            size: 64,
            color: Colors.grey.shade300,
          ),
          const SizedBox(height: 16),
          Text(
            'Belum ada artikel edukasi',
            style: TextStyle(
              fontSize: 16,
              fontWeight: FontWeight.w600,
              color: Colors.grey.shade600,
            ),
          ),
          const SizedBox(height: 8),
          Text(
            'Artikel edukasi akan muncul di sini',
            style: TextStyle(
              fontSize: 13,
              color: Colors.grey.shade500,
            ),
          ),
        ],
      ),
    );
  }

  /// Article card
  Widget _buildArticleCard(EdukasiItem article) {
    return GestureDetector(
      onTap: () {
        _showArticleDetail(article);
      },
      child: Container(
        margin: const EdgeInsets.only(bottom: 12),
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(16),
          boxShadow: [
            BoxShadow(
              color: Colors.black.withValues(alpha: 0.05),
              blurRadius: 12,
              offset: const Offset(0, 4),
            ),
          ],
        ),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Thumbnail
            if (article.thumbnailUrl != null)
              ClipRRect(
                borderRadius: const BorderRadius.vertical(
                  top: Radius.circular(16),
                ),
                child: Image.network(
                  _getFullImageUrl(article.thumbnailUrl!), // <--- SUDAH MENGGUNAKAN HELPER
                  height: 160,
                  width: double.infinity,
                  fit: BoxFit.cover,
                  errorBuilder: (context, error, stackTrace) {
                    return Container(
                      height: 160,
                      color: const Color(0xFFECFDF5),
                      child: Center(
                        child: Icon(
                          Icons.image,
                          size: 48,
                          color: Colors.grey.shade300,
                        ),
                      ),
                    );
                  },
                  loadingBuilder: (context, child, loadingProgress) {
                    if (loadingProgress == null) return child;
                    return Container(
                      height: 160,
                      color: const Color(0xFFECFDF5),
                      child: Center(
                        child: CircularProgressIndicator(
                          color: const Color(0xFF10B981),
                          strokeWidth: 2,
                          value: loadingProgress.expectedTotalBytes != null
                              ? loadingProgress.cumulativeBytesLoaded /
                              loadingProgress.expectedTotalBytes!
                              : null,
                        ),
                      ),
                    );
                  },
                ),
              )
            else
              Container(
                height: 120,
                decoration: const BoxDecoration(
                  color: Color(0xFFECFDF5),
                  borderRadius: BorderRadius.vertical(
                    top: Radius.circular(16),
                  ),
                ),
                child: Center(
                  child: Icon(
                    Icons.article,
                    size: 48,
                    color: const Color(0xFF10B981).withValues(alpha: 0.5),
                  ),
                ),
              ),

            // Content
            Padding(
              padding: const EdgeInsets.all(16),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  // Badge artikel untuk tampilan user
                  Container(
                    padding: const EdgeInsets.symmetric(
                      horizontal: 10,
                      vertical: 4,
                    ),
                    decoration: BoxDecoration(
                      color: const Color(0xFFECFDF5),
                      borderRadius: BorderRadius.circular(20),
                    ),
                    child: const Text(
                      'Artikel',
                      style: TextStyle(
                        fontSize: 11,
                        fontWeight: FontWeight.w600,
                        color: Color(0xFF059669),
                      ),
                    ),
                  ),
                  const SizedBox(height: 10),

                  // Title
                  Text(
                    article.title,
                    style: const TextStyle(
                      fontSize: 16,
                      fontWeight: FontWeight.w700,
                      color: Color(0xFF111827),
                      height: 1.3,
                    ),
                    maxLines: 2,
                    overflow: TextOverflow.ellipsis,
                  ),
                  const SizedBox(height: 8),

                  // Content preview
                  Text(
                    article.content,
                    style: TextStyle(
                      fontSize: 13,
                      color: Colors.grey.shade600,
                      height: 1.5,
                    ),
                    maxLines: 3,
                    overflow: TextOverflow.ellipsis,
                  ),
                  const SizedBox(height: 12),

                  // Meta info
                  Row(
                    children: [
                      // Author
                      Icon(
                        Icons.person_outline,
                        size: 14,
                        color: Colors.grey.shade500,
                      ),
                      const SizedBox(width: 4),
                      Text(
                        article.authorName,
                        style: TextStyle(
                          fontSize: 12,
                          color: Colors.grey.shade500,
                        ),
                      ),
                      const SizedBox(width: 16),

                      // Date
                      Icon(
                        Icons.calendar_today_outlined,
                        size: 14,
                        color: Colors.grey.shade500,
                      ),
                      const SizedBox(width: 4),
                      Text(
                        _formatDate(article.createdAt),
                        style: TextStyle(
                          fontSize: 12,
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
      ),
    );
  }

  /// Show article detail (bottom sheet)
  void _showArticleDetail(EdukasiItem article) {
    showModalBottomSheet(
      context: context,
      isScrollControlled: true,
      backgroundColor: Colors.transparent,
      builder: (context) => DraggableScrollableSheet(
        initialChildSize: 0.9,
        minChildSize: 0.5,
        maxChildSize: 0.95,
        builder: (context, scrollController) => Container(
          decoration: const BoxDecoration(
            color: Colors.white,
            borderRadius: BorderRadius.vertical(top: Radius.circular(24)),
          ),
          child: Column(
            children: [
              // Handle
              Container(
                margin: const EdgeInsets.only(top: 12),
                width: 40,
                height: 4,
                decoration: BoxDecoration(
                  color: const Color(0xFFE5E7EB),
                  borderRadius: BorderRadius.circular(2),
                ),
              ),

              // Content
              Expanded(
                child: SingleChildScrollView(
                  controller: scrollController,
                  padding: const EdgeInsets.all(20),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      // Thumbnail
                      if (article.thumbnailUrl != null)
                        ClipRRect(
                          borderRadius: BorderRadius.circular(16),
                          child: Image.network(
                            _getFullImageUrl(article.thumbnailUrl!), // <--- SUDAH MENGGUNAKAN HELPER
                            height: 200,
                            width: double.infinity,
                            fit: BoxFit.cover,
                            errorBuilder: (context, error, stackTrace) {
                              return Container(
                                height: 200,
                                color: const Color(0xFFECFDF5),
                                child: const Center(
                                  child: Icon(
                                    Icons.image,
                                    size: 48,
                                    color: Color(0xFF10B981),
                                  ),
                                ),
                              );
                            },
                          ),
                        ),

                      const SizedBox(height: 20),

                      // Badge artikel untuk tampilan user
                      Container(
                        padding: const EdgeInsets.symmetric(
                          horizontal: 12,
                          vertical: 6,
                        ),
                        decoration: BoxDecoration(
                          color: const Color(0xFFECFDF5),
                          borderRadius: BorderRadius.circular(20),
                        ),
                        child: const Text(
                          'Artikel',
                          style: TextStyle(
                            fontSize: 12,
                            fontWeight: FontWeight.w600,
                            color: Color(0xFF059669),
                          ),
                        ),
                      ),
                      const SizedBox(height: 16),

                      // Title
                      Text(
                        article.title,
                        style: const TextStyle(
                          fontSize: 22,
                          fontWeight: FontWeight.w800,
                          color: Color(0xFF111827),
                          height: 1.3,
                        ),
                      ),
                      const SizedBox(height: 12),

                      // Meta info
                      Row(
                        children: [
                          Container(
                            padding: const EdgeInsets.all(8),
                            decoration: BoxDecoration(
                              color: const Color(0xFFECFDF5),
                              borderRadius: BorderRadius.circular(8),
                            ),
                            child: const Icon(
                              Icons.person,
                              size: 16,
                              color: Color(0xFF10B981),
                            ),
                          ),
                          const SizedBox(width: 8),
                          Text(
                            article.authorName,
                            style: const TextStyle(
                              fontSize: 14,
                              fontWeight: FontWeight.w500,
                              color: Color(0xFF374151),
                            ),
                          ),
                          const SizedBox(width: 20),
                          Container(
                            padding: const EdgeInsets.all(8),
                            decoration: BoxDecoration(
                              color: const Color(0xFFECFDF5),
                              borderRadius: BorderRadius.circular(8),
                            ),
                            child: const Icon(
                              Icons.calendar_today,
                              size: 16,
                              color: Color(0xFF10B981),
                            ),
                          ),
                          const SizedBox(width: 8),
                          Text(
                            _formatDate(article.createdAt),
                            style: const TextStyle(
                              fontSize: 14,
                              fontWeight: FontWeight.w500,
                              color: Color(0xFF374151),
                            ),
                          ),
                        ],
                      ),
                      const SizedBox(height: 24),

                      // Divider
                      Container(
                        height: 1,
                        color: const Color(0xFFE5E7EB),
                      ),
                      const SizedBox(height: 24),

                      // Content
                      Text(
                        article.content,
                        style: TextStyle(
                          fontSize: 15,
                          color: Colors.grey.shade700,
                          height: 1.8,
                        ),
                      ),
                      const SizedBox(height: 40),
                    ],
                  ),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }

  /// Header Banner - simetris di semua ukuran
  Widget _buildHeaderBanner(double screenWidth) {
    final bool isCompact = screenWidth < 360;
    final double iconSize = isCompact ? 12 : 14;
    final double badgePaddingH = isCompact ? 10.0 : 12.0;
    final double badgePaddingV = isCompact ? 5.0 : 6.0;
    final double titleSize = isCompact ? 22.0 : (screenWidth > 400 ? 28.0 : 24.0);
    final double subtitleSize = isCompact ? 10.0 : 13.0;

    return Container(
      width: double.infinity,
      padding: EdgeInsets.all(isCompact ? 16.0 : 20.0),
      decoration: BoxDecoration(
        gradient: const LinearGradient(
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
          colors: [Color(0xFF10B981), Color(0xFF059669)],
        ),
        borderRadius: BorderRadius.circular(20),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // Badge
          Container(
            padding: EdgeInsets.symmetric(horizontal: badgePaddingH, vertical: badgePaddingV),
            decoration: BoxDecoration(
              color: Colors.white.withValues(alpha: 0.2),
              borderRadius: BorderRadius.circular(20),
            ),
            child: Row(
              mainAxisSize: MainAxisSize.min,
              children: [
                Icon(Icons.school, color: Colors.white, size: iconSize),
                const SizedBox(width: 4),
                Text(
                  'Edukasi',
                  style: TextStyle(
                    color: Colors.white,
                    fontSize: isCompact ? 10.0 : 12.0,
                    fontWeight: FontWeight.w700,
                  ),
                ),
              ],
            ),
          ),
          SizedBox(height: isCompact ? 14.0 : 18.0),

          // Title
          Text(
            'Artikel Edukasi',
            style: TextStyle(
              color: Colors.white,
              fontSize: titleSize,
              fontWeight: FontWeight.w900,
              height: 1.1,
            ),
          ),
          SizedBox(height: isCompact ? 10.0 : 14.0),

          // Subtitle
          Container(
            padding: EdgeInsets.symmetric(horizontal: badgePaddingH, vertical: badgePaddingV),
            decoration: BoxDecoration(
              color: Colors.white.withValues(alpha: 0.2),
              borderRadius: BorderRadius.circular(10),
            ),
            child: Text(
              'Pelajari cara mengelola sampah dengan benar',
              style: TextStyle(
                color: Colors.white,
                fontSize: subtitleSize,
                fontWeight: FontWeight.w500,
              ),
            ),
          ),
        ],
      ),
    );
  }
}