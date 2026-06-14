import 'package:flutter_test/flutter_test.dart';
import 'package:gloria_job_app/app/app.dart';

void main() {
  testWidgets('App basic initialization test', (WidgetTester tester) async {
    // Build our app and trigger a frame.
    await tester.pumpWidget(const GloriaJobApp());
    expect(find.byType(GloriaJobApp), findsOneWidget);
    
    // Advance virtual time to trigger the splash screen delay timer (2 seconds)
    await tester.pump(const Duration(seconds: 3));
    // Pump one more frame to allow navigation to complete
    await tester.pump();
  });
}
