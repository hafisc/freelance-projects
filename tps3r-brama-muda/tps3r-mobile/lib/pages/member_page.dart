import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../services/app_state.dart';
import '../widgets/member/member_header.dart';
import '../widgets/member/member_statistics.dart';
import '../widgets/member/schedule_card.dart';
import '../widgets/member/member_notifications.dart';
import '../widgets/member/recycle_progress.dart';
import '../widgets/member/waste_report.dart';
// Impor file yang berisi RecentWasteActivities
import '../widgets/member/activity_section.dart'; 

class MemberPage extends StatelessWidget {
  const MemberPage({super.key});

  @override
  Widget build(BuildContext context) {
    return Consumer<AppState>(
      builder: (context, appState, child) {
        return Container(
          width: double.infinity,
          color: const Color(0xFFF0FDF4),
          child: LayoutBuilder(
            builder: (context, constraints) {
              final horizontalPadding = constraints.maxWidth < 360 ? 12.0 : 16.0;
              final verticalPadding = constraints.maxWidth < 360 ? 16.0 : 24.0;

              return SingleChildScrollView(
                physics: const BouncingScrollPhysics(),
                padding: EdgeInsets.symmetric(
                  vertical: verticalPadding,
                  horizontal: horizontalPadding,
                ),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    const MemberHeader(),
                    const SizedBox(height: 20),

                    MemberStatistics(appState: appState),
                    const SizedBox(height: 16),

                    const ScheduleCard(),
                    const SizedBox(height: 16),

                    RecycleProgress(appState: appState),
                    const SizedBox(height: 16),

                    const WasteReportSection(),
                    const SizedBox(height: 16),

                    // REVISI: Pastikan hanya memanggil RecentWasteActivities sekali
                    // dan pastikan namanya sesuai dengan yang ada di activity_section.dart
                    RecentWasteActivities(appState: appState),
                    const SizedBox(height: 16),

                    const MemberNotifications(),
                    const SizedBox(height: 24),
                  ],
                ),
              );
            },
          ),
        );
      },
    );
  }
}