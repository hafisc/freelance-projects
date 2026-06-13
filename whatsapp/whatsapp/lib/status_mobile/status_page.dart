import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'add_gallery_page.dart';
import 'status_viewer_page.dart';

class StatusMobilePage extends StatefulWidget {
  const StatusMobilePage({super.key});

  @override
  State<StatusMobilePage> createState() => _StatusMobilePageState();
}

class _StatusMobilePageState extends State<StatusMobilePage> {
  String? _myNewStatusPath;
  String _statusTimeText = 'Disappears after 24 hours';
  
  // Array untuk menyimpan list status yang ditarik dari database status_231006
  List<dynamic> _recentUpdatesFromDB = [];

  @override
  void initState() {
    super.initState();
    _fetchDaftarStatus(); // Ambil data dari database saat halaman dibuka pertama kali
  }

  // Ambil daftar status dari API Native PHP Laragon
  Future<void> _fetchDaftarStatus() async {
    // SINKRONKAN ALAMAT IP BERIKUT DENGAN SERVER LOCAL LAPTOP ANDA
    final String url = "http://localhost/project-231006/API/get_statuses.php";

    try {
      final response = await http.get(Uri.parse(url));
      if (response.statusCode == 200) {
        final dataRespon = jsonDecode(response.body);
        if (dataRespon['success'] == true) {
          setState(() {
            _recentUpdatesFromDB = dataRespon['data'];
          });
        }
      }
    } catch (e) {
      debugPrint("Gagal sinkronisasi data tabel status_231006: $e");
    }
  }

 @override
Widget build(BuildContext context) {

  final statusList = _recentUpdatesFromDB;
    
    return Scaffold(
      backgroundColor: Colors.black,

      // ================= APP BAR =================
      appBar: AppBar(
        backgroundColor: Colors.black,
        elevation: 0,
        toolbarHeight: 65,
        titleSpacing: 16,
        title: const Text(
          'Updates',
          style: TextStyle(
            color: Colors.white,
            fontSize: 28,
            fontWeight: FontWeight.w500,
          ),
        ),
        actions: [
          Padding(
            padding: const EdgeInsets.only(right: 18),
            child: Image.asset(
              'assets/icons/logo_kamera_atas.JPG',
              width: 30,
              height: 30,
            ),
          ),
          const Padding(
            padding: EdgeInsets.only(right: 18),
            child: Icon(Icons.search, color: Colors.white, size: 24),
          ),
          const Padding(
            padding: EdgeInsets.only(right: 12),
            child: Icon(Icons.more_vert, color: Colors.white, size: 24),
          ),
        ],
      ),

      // ================= BODY =================
      body: RefreshIndicator(
        onRefresh: _fetchDaftarStatus, // Tarik layar ke bawah untuk reload database manual
        color: const Color(0xFF25D366),
        child: SingleChildScrollView(
          physics: const AlwaysScrollableScrollPhysics(),
          padding: const EdgeInsets.fromLTRB(16, 8, 16, 120),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              const Text(
                'Status',
                style: TextStyle(
                  color: Colors.white,
                  fontSize: 19,
                  fontWeight: FontWeight.w600,
                ),
              ),
              const SizedBox(height: 18),

              // ACTIONABLE MY STATUS ROW
              InkWell(
                onTap: () async {
                  final result = await Navigator.push(
                    context,
                    MaterialPageRoute(
                      builder: (context) => const AddStatusPage(),
                    ),
                  );

                  if (result != null && result is String) {
                    setState(() {
                      _myNewStatusPath = result;
                      _statusTimeText = 'Just now';
                    });
                    _fetchDaftarStatus(); // Ambil ulang data status terbaru dari MySQL
                  }
                },
                highlightColor: Colors.transparent,
                splashColor: Colors.white10,
                child: Row(
                  children: [
                    Stack(
                      children: [
                        Container(
                          padding: _myNewStatusPath != null ? const EdgeInsets.all(2) : EdgeInsets.zero,
                          decoration: BoxDecoration(
                            shape: BoxShape.circle,
                            border: _myNewStatusPath != null 
                                ? Border.all(color: const Color(0xFF25D366), width: 2)
                                : null,
                          ),
                          child: ClipOval(
                            child: _myNewStatusPath != null
                                ? Image.asset(
                                    _myNewStatusPath!,
                                    width: 56,
                                    height: 56,
                                    fit: BoxFit.cover,
                                  )
                                : Image.asset(
                                    'assets/icons/logo_profile_status.JPG',
                                    width: 60,
                                    height: 60,
                                    fit: BoxFit.cover,
                                  ),
                          ),
                        ),
                        if (_myNewStatusPath == null)
                          Positioned(
                            bottom: 0,
                            right: 0,
                            child: Container(
                              padding: const EdgeInsets.all(2),
                              decoration: const BoxDecoration(
                                color: Colors.black,
                                shape: BoxShape.circle,
                              ),
                              child: const Icon(
                                Icons.add_circle,
                                color: Color(0xFF25D366),
                                size: 22,
                              ),
                            ),
                          ),
                      ],
                    ),
                    const SizedBox(width: 16),
                    Expanded(
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Text(
                            _myNewStatusPath != null ? 'My status' : 'Add status',
                            style: const TextStyle(
                              color: Colors.white,
                              fontSize: 17,
                              fontWeight: FontWeight.w600,
                            ),
                          ),
                          const SizedBox(height: 3),
                          Text(
                            _statusTimeText,
                            style: const TextStyle(
                              color: Colors.grey,
                              fontSize: 14,
                            ),
                          ),
                        ],
                      ),
                    ),
                  ],
                ),
              ),

              const SizedBox(height: 30),
              const Text(
                'Recent updates',
                style: TextStyle(color: Colors.grey, fontSize: 14),
              ),
              const SizedBox(height: 14),

              // LIST STATUS DINAMIS DARI DATABASE MYSQL (status_231006)
              _recentUpdatesFromDB.isEmpty
                  ? Row(
                      children: [
                        ClipOval(
                          child: Image.asset(
                            'assets/icons/logo_status_whatsapp.JPG',
                            width: 60,
                            height: 60,
                            fit: BoxFit.cover,
                          ),
                        ),
                        const SizedBox(width: 16),
                        Expanded(
                          child: Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              Row(
                                children: const [
                                  Text(
                                    'WhatsApp',
                                    style: TextStyle(
                                      color: Colors.white,
                                      fontSize: 16,
                                      fontWeight: FontWeight.w600,
                                    ),
                                  ),
                                  SizedBox(width: 5),
                                  Icon(Icons.verified, color: Colors.blue, size: 18),
                                ],
                              ),
                              const SizedBox(height: 3),
                              const Text(
                                '21 minutes ago',
                                style: TextStyle(color: Colors.grey, fontSize: 14),
                              ),
                            ],
                          ),
                        ),
                      ],
                    )
                  : ListView.builder(
                      shrinkWrap: true,
                      physics: const NeverScrollableScrollPhysics(),
                      itemCount: statusList.length,
                      itemBuilder: (context, index) {
                        final item = statusList[index];
                        return InkWell(
 onTap: () {
  Navigator.push(
    context,
    MaterialPageRoute(
        builder: (_) => StatusViewerPage(
      mediaPath: item['latest_media'],
      businessName: item['business_name'] ?? 'User',
      isVideo: false,
      isAsset: true,
    ),
    ),
  );
},
  child: Padding(
                          padding: const EdgeInsets.only(bottom: 16.0),
                          child: Row(
                            children: [
                              Container(
                                padding: const EdgeInsets.all(2),
                                decoration: BoxDecoration(
                                  shape: BoxShape.circle,
                                  border: Border.all(color: const Color(0xFF00A884), width: 2),
                                ),
                                
                                child: ClipOval(
                                  child: Image.asset(
                                 item['latest_media'] ??
                                    'assets/icons/logo_profile_status.JPG',
                                    width: 54,
                                    height: 54,
                                    fit: BoxFit.cover,
                                    errorBuilder: (context, error, stackTrace) {
                                      // Fallback jika asset path lokal tidak terdeteksi
                                      return Image.asset(
                                        'assets/icons/logo_profile_status.JPG',
                                        width: 54,
                                        height: 54,
                                        fit: BoxFit.cover,
                                      );
                                    },
                                  ),
                                ),
                              ),
                              
                              const SizedBox(width: 16),
                              Expanded(
                                child: Column(
                                  crossAxisAlignment: CrossAxisAlignment.start,
                                  children: [
                                    Text(
                                      item['business_name'] ?? 'User',
                                      style: const TextStyle(
                                        color: Colors.white,
                                        fontSize: 16,
                                        fontWeight: FontWeight.w600,
                                      ),
                                    ),
                                    const SizedBox(height: 3),
                                    Text(
                                      item['latest_caption'] != null &&
                                      item['latest_caption']
                                          .toString()
                                          .isNotEmpty
                                          ? item['latest_caption']
                                          : 'Barusan',
                                      style: const TextStyle(color: Colors.grey, fontSize: 14),
                                      maxLines: 1,
                                      overflow: TextOverflow.ellipsis,
                                    ),
                                  ],
                                ),
                              ),
                            ],
                          ),
                        )
                        );
                      },
                    ),

              const SizedBox(height: 35),
              // CHANNELS SECTION
              const Text(
                'Channels',
                style: TextStyle(
                  color: Colors.white,
                  fontSize: 19,
                  fontWeight: FontWeight.w600,
                ),
              ),
              const SizedBox(height: 8),
              const Text(
                'Stay updated on topics that matter to you. Find channels to follow below.',
                style: TextStyle(color: Colors.grey, fontSize: 14, height: 1.4),
              ),
              const SizedBox(height: 22),
              Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  const Text(
                    'Find channels to follow',
                    style: TextStyle(
                      color: Colors.white,
                      fontSize: 17,
                      fontWeight: FontWeight.w600,
                    ),
                  ),
                  Container(
                    width: 42,
                    height: 42,
                    decoration: const BoxDecoration(
                      color: Color(0xFF1F1F1F),
                      shape: BoxShape.circle,
                    ),
                    child: const Icon(Icons.keyboard_arrow_down, color: Colors.white),
                  ),
                ],
              ),
              const SizedBox(height: 26),
              SizedBox(
                width: double.infinity,
                height: 50,
                child: OutlinedButton.icon(
                  onPressed: () {},
                  icon: const Icon(Icons.grid_view_rounded, color: Color(0xFF25D366)),
                  label: const Text(
                    'Explore more',
                    style: TextStyle(color: Color(0xFF25D366), fontWeight: FontWeight.w600),
                  ),
                  style: OutlinedButton.styleFrom(
                    side: const BorderSide(color: Colors.grey),
                    shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(30)),
                  ),
                ),
              ),
              const SizedBox(height: 12),
              SizedBox(
                width: double.infinity,
                height: 50,
                child: OutlinedButton.icon(
                  onPressed: () {},
                  icon: const Icon(Icons.add, color: Color(0xFF25D366)),
                  label: const Text(
                    'Create channel',
                    style: TextStyle(color: Color(0xFF25D366), fontWeight: FontWeight.w600),
                  ),
                  style: OutlinedButton.styleFrom(
                    side: const BorderSide(color: Colors.grey),
                    shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(30)),
                  ),
                ),
              ),
            ],
          ),
        ),
      ),

      // ================= FLOATING BUTTON =================
      floatingActionButton: Column(
        mainAxisSize: MainAxisSize.min,
        children: [
          Container(
            width: 48,
            height: 48,
            decoration: BoxDecoration(
              color: const Color(0xFF222222),
              borderRadius: BorderRadius.circular(16),
            ),
            child: Center(
              child: Image.asset(
                'assets/icons/logo_menulis.JPG',
                width: 22,
                height: 22,
              ),
            ),
          ),
          const SizedBox(height: 14),
          Container(
            width: 58,
            height: 58,
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(18),
            ),
            child: Center(
              child: Image.asset(
                'assets/icons/logo_kamera.JPG',
                width: 28,
                height: 28,
              ),
            ),
          ),
        ],
      ),

      // ================= BOTTOM NAV =================
      bottomNavigationBar: Container(
        height: 82,
        color: Colors.black,
        child: Row(
          mainAxisAlignment: MainAxisAlignment.spaceEvenly,
          children: [
            Column(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                Image.asset('assets/icons/logo_chats.JPG', width: 30, height: 30),
                const SizedBox(height: 5),
                const Text('Chats', style: TextStyle(color: Colors.grey, fontSize: 12)),
              ],
            ),
            _navItem(icon: Icons.call_outlined, label: 'Calls', active: false),
            Column(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                Image.asset('assets/icons/update_logo.JPG', width: 34, height: 34),
                const SizedBox(height: 5),
                const Text(
                  'Updates',
                  style: TextStyle(color: Colors.white, fontWeight: FontWeight.w600, fontSize: 12),
                ),
              ],
            ),
            Column(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                Image.asset('assets/icons/tools_status.JPG', width: 30, height: 30),
                const SizedBox(height: 5),
                const Text('Tools', style: TextStyle(color: Colors.white, fontSize: 12)),
              ],
            ),
          ],
        ),
      ),
    );
  }

  static Widget _navItem({required IconData icon, required String label, required bool active}) {
    return Column(
      mainAxisAlignment: MainAxisAlignment.center,
      children: [
        Icon(icon, color: active ? Colors.white : Colors.grey),
        const SizedBox(height: 5),
        Text(
          label,
          style: TextStyle(color: active ? Colors.white : Colors.grey, fontSize: 12),
        ),
      ],
    );
  }
}