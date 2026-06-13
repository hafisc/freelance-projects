import 'package:flutter/material.dart';
import 'package:file_picker/file_picker.dart';
import 'dart:typed_data';
import 'status_upload_page.dart';
import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import 'dart:async';

void main() {
  runApp(
    const MaterialApp(
      debugShowCheckedModeBanner: false,
      home: StatusWebPage(),
    ),
  );
}

Timer? refreshTimer;
class StatusWebPage extends StatefulWidget {
  const StatusWebPage({super.key});

  @override
  State<StatusWebPage> createState() => _StatusWebPageState();
}

class _StatusWebPageState extends State<StatusWebPage> {

  Uint8List? myStatusImage;

List<dynamic> statusList = [];

Map<String, dynamic>? myStatusData;

List<dynamic> recentStatuses = [];

int currentUserId = 0;

  Future<void> loadStatus() async {

  try {

    final response = await http.get(
      Uri.parse(
        "http://localhost/project-231006/API/get_statuses.php",
      ),
    );

    final data =
        jsonDecode(response.body);

    if (data["success"] == true) {

     setState(() {

  statusList = data["data"];

  myStatusData = null;

  recentStatuses.clear();

  for (var item in statusList) {

    if (item["id_user"] == currentUserId) {

      myStatusData = item;

    } else {

      recentStatuses.add(item);

    }
  }
});

    debugPrint(
  statusList.toString(),
);
      debugPrint(
        "TOTAL STATUS USER : ${statusList.length}",
      );
    }

  } catch (e) {

    debugPrint(
      "LOAD STATUS ERROR : $e",
    );
  }
}

    Future<void> loadUser() async {

      final prefs =
          await SharedPreferences.getInstance();

      currentUserId =
          prefs.getInt("id_user") ?? 0;

      debugPrint(
  "LOGIN USER : $currentUserId",
);

      await loadStatus();
    }
  Widget _sidebarIcon(
  String imagePath,
) {
  return InkWell(
    onTap: () {},
    child: Container(
      width: 40,
      height: 40,
      alignment: Alignment.center,
      child: Image.asset(
        imagePath,
        width: 24,
        height: 24,
        fit: BoxFit.contain,
      ),
    ),
  );
}
  Future<void> _showStatusMenu(BuildContext context) async {
 final overlay =
    Overlay.of(context).context.findRenderObject() as RenderBox;
    
  final result = await showMenu(
    context: context,
    color: Colors.white,
    position: RelativeRect.fromRect(
      const Rect.fromLTWH(
        5, // kiri
        120, // tepat di bawah My Status
        1,
        1,
      ),
      Offset.zero & overlay.size,
    ),
    items: const [
      PopupMenuItem(
        value: 'photo',
        child: Row(
          children: [
            Icon(Icons.photo_library_outlined),
            SizedBox(width: 10),
            Text('Photos & videos'),
          ],
        ),
      ),
      PopupMenuItem(
        value: 'text',
        child: Row(
          children: [
            Icon(Icons.edit_outlined),
            SizedBox(width: 10),
            Text('Text'),
          ],
        ),
      ),
    ],
  );

if (result == 'photo') {

  final picked = await FilePicker.platform.pickFiles(
    type: FileType.image,
    allowMultiple: false,
    withData: true,
  );

  if (picked != null &&
      picked.files.single.bytes != null) {

    final result = await Navigator.push(
  context,
  MaterialPageRoute(
    builder: (_) => StatusUploadPage(
      imageBytes: picked.files.single.bytes!,
      fileName: picked.files.single.name,
    ),
  ),
);

   if (result == true) {

  await loadStatus();

}
  }
}

if (result == 'text') {
  print('Text dipilih');
}

} // <-- TAMBAHKAN INI

@override
void initState() {
  super.initState();

  loadUser();

  refreshTimer =
      Timer.periodic(
    const Duration(seconds: 5),
    (timer) {

      loadStatus();

    },
  );

}

  @override
void dispose() {

  refreshTimer?.cancel();

  super.dispose();
}

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xfff5f5f5),
      body: Row(
        children: [

          // =========================
          // SIDEBAR
          // =========================
         Container(
          width: 68,

          decoration: const BoxDecoration(
            color: Colors.white,
            border: Border(
              right: BorderSide(
                color: Color(0xffD1D7DB),
                width: 1,
              ),
            ),
          ),

          child: Column(
            children: [

              const SizedBox(height: 30),

              // CHAT
              _sidebarIcon(
                'assets/icons/logo_chat.jpg',
              ),

              const SizedBox(height: 30),

              // STATUS / UPDATES
              _sidebarIcon(
                'assets/icons/logo_updates.jpg',
              ),

              const SizedBox(height: 30),

              // SIARAN
              _sidebarIcon(
                'assets/icons/logo_siaran.jpg',
              ),

              const SizedBox(height: 30),

              // KOMUNITAS
              _sidebarIcon(
                'assets/icons/logo_komunitas.jpg',
              ),

              const SizedBox(height: 30),

              // TOOLS
              _sidebarIcon(
                'assets/icons/logo_tools.jpg',
              ),

              const Spacer(),

              // FOTO
              _sidebarIcon(
                'assets/icons/logo_foto.jpg',
              ),

              const SizedBox(height: 30),

              // SETTING
              _sidebarIcon(
                'assets/icons/logo_setting.jpg',
              ),

              const SizedBox(height: 30),

              // PROFILE
              _sidebarIcon(
                'assets/icons/logo_profile.jpg',
              ),

              const SizedBox(height: 30),
            ],
          ),
        ),

          // =========================
          // STATUS LIST PANEL
          // =========================
          Container(
            width: 420,
            color: Colors.white,
            child: Column(
              children: [

                Container(
                  height: 70,
                  padding: const EdgeInsets.symmetric(horizontal: 20),
                  child: Row(
                    children: [
                      const Text(
                        "Status",
                        style: TextStyle(
                          fontSize: 24,
                          fontWeight: FontWeight.w500,
                        ),
                      ),
                      const Spacer(),
                      IconButton(
                        onPressed: () {},
                        icon: const Icon(Icons.add_circle_outline),
                      ),
                      IconButton(
                        onPressed: () {},
                        icon: const Icon(Icons.more_vert),
                      ),
                    ],
                  ),
                ),

                // =========================
                // MY STATUS (KLIK DISINI)
                // =========================
                ListTile(
                  onTap: () {
                    _showStatusMenu(context);
                  },
                leading: Stack(
                    children: [
CircleAvatar(
  radius: 24,
  backgroundImage: myStatusData != null
      ? NetworkImage(
          "http://localhost/project-231006/uploads/${myStatusData!["latest_media"]}",
        )
      : null,
  backgroundColor: const Color(0xffd6f4ef),
  child: myStatusData == null
      ? const Icon(
          Icons.person,
          color: Colors.teal,
        )
      : null,
),

Positioned(
                        right: 0,
                        bottom: 0,
                        child: Container(
                          width: 18,
                          height: 18,
                          decoration: const BoxDecoration(
                            color: Colors.black,
                            shape: BoxShape.circle,
                          ),
                          child: const Icon(
                            Icons.add,
                            color: Colors.white,
                            size: 14,
                          ),
                        ),
                      )
                    ],
                  ),
                  title: const Text("My status"),
                 subtitle: Text(
                  myStatusData == null
                      ? "Click to add status update"
                      : "${myStatusData!["statuses"].length} updates",
                ),
                ),

                const SizedBox(height: 20),

                const Padding(
                  padding: EdgeInsets.only(left: 20),
                  child: Align(
                    alignment: Alignment.centerLeft,
                    child: Text(
                      "Viewed",
                      style: TextStyle(
                        color: Colors.grey,
                        fontSize: 13,
                      ),
                    ),
                  ),
                ),

                const SizedBox(height: 12),
                const Padding(
  padding: EdgeInsets.only(left: 20),
  child: Align(
    alignment: Alignment.centerLeft,
    child: Text(
      "Recent Updates",
      style: TextStyle(
        color: Colors.green,
        fontWeight: FontWeight.bold,
      ),
    ),
  ),
),

const SizedBox(height: 10),

Expanded(
  child: ListView.builder(
    itemCount: recentStatuses.length,
    itemBuilder: (context, index) {

      final user =
          recentStatuses[index];

      return ListTile(

        leading: CircleAvatar(
          backgroundImage: NetworkImage(
            "http://localhost/project-231006/uploads/${user["latest_media"]}",
          ),
        ),

        title: Text(
          user["business_name"],
        ),

        subtitle: Text(
          user["latest_time"],
        ),

        onTap: () {

          print(
            user["statuses"],
          );

        },
      );
    },
  ),
),
              ],
            ),
          ),

          // =========================
          // RIGHT CONTENT
          // =========================
         Expanded(
  child: Container(
    color: const Color(0xfff7f7f7),
child: myStatusData == null
        ? Center(
            child: Column(
              mainAxisSize: MainAxisSize.min,
              children: [
                Image.asset(
                  'assets/icons/logo_share.JPG',
                  width: 80,
                  height: 80,
                ),
                const SizedBox(height: 30),
                const Text(
                  "Share status updates",
                  style: TextStyle(
                    fontSize: 38,
                    fontWeight: FontWeight.w400,
                  ),
                ),
                const SizedBox(height: 15),
                Text(
                  "Share photos, videos and text that disappear after 24 hours.",
                  style: TextStyle(
                    fontSize: 15,
                    color: Colors.grey.shade700,
                  ),
                ),
              ],
            ),
          )
        : Center(
            child: Container(
              width: 360,
              height: 640,
              decoration: BoxDecoration(
                borderRadius: BorderRadius.circular(12),
                boxShadow: [
                  BoxShadow(
                    color: Colors.black12,
                    blurRadius: 10,
                  ),
                ],
              ),
              clipBehavior: Clip.antiAlias,
             child: Image.network(
              "http://localhost/project-231006/uploads/${myStatusData!["latest_media"]}",
              fit: BoxFit.cover,
            ),
            ),
          ),
  ),
),
        ],
      ),
    );
  }
}