import 'package:flutter_secure_storage/flutter_secure_storage.dart';
import 'package:flutter_test/flutter_test.dart';
import 'package:skillconnect_mobile/main.dart';

void main() {
  testWidgets('renders SkillConnect mobile shell', (tester) async {
    FlutterSecureStorage.setMockInitialValues({});

    await tester.pumpWidget(const SkillConnectApp());
    await tester.pump();
    await tester.pump(const Duration(milliseconds: 100));

    expect(find.text('Platform pelatihan kerja online'), findsOneWidget);
    expect(find.text('Beranda'), findsWidgets);
    expect(find.text('Cari Kursus'), findsOneWidget);
    expect(
      find.text('Belajar, Tumbuh, dan Tersertifikasi untuk Masa Depan'),
      findsOneWidget,
    );
  });
}
