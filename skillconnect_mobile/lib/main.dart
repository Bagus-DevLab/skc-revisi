import 'package:flutter/material.dart';

void main() {
  runApp(const SkillConnectApp());
}

class SkillConnectApp extends StatelessWidget {
  const SkillConnectApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'SkillConnect.id',
      debugShowCheckedModeBanner: false,
      theme: ThemeData(
        useMaterial3: true,
        scaffoldBackgroundColor: AppColors.background,
        colorScheme: ColorScheme.fromSeed(
          seedColor: AppColors.primary,
          primary: AppColors.primary,
          surface: Colors.white,
        ),
        fontFamily: 'Roboto',
        appBarTheme: const AppBarTheme(
          backgroundColor: Colors.white,
          foregroundColor: AppColors.text,
          centerTitle: false,
          elevation: 0,
          surfaceTintColor: Colors.white,
        ),
        cardTheme: CardThemeData(
          color: Colors.white,
          elevation: 0,
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(16),
            side: const BorderSide(color: AppColors.border),
          ),
        ),
      ),
      home: const SkillConnectShell(),
    );
  }
}

class AppColors {
  static const primary = Color(0xFF2563EB);
  static const primaryDark = Color(0xFF1E40AF);
  static const text = Color(0xFF111827);
  static const muted = Color(0xFF6B7280);
  static const background = Color(0xFFF8FAFC);
  static const border = Color(0xFFE5E7EB);
  static const success = Color(0xFF16A34A);
  static const warning = Color(0xFFEAB308);
}

class Course {
  const Course({
    required this.title,
    required this.category,
    required this.description,
    required this.price,
    required this.rating,
    required this.students,
    required this.durationWeeks,
    required this.difficulty,
    required this.matchScore,
    required this.owned,
    required this.progress,
    required this.colors,
  });

  final String title;
  final String category;
  final String description;
  final int price;
  final double rating;
  final int students;
  final int durationWeeks;
  final int difficulty;
  final double matchScore;
  final bool owned;
  final int progress;
  final List<Color> colors;
}

const courses = <Course>[
  Course(
    title: 'Digital Marketing untuk Pemula',
    category: 'Marketing',
    description:
        'Pelajari strategi pemasaran digital, funnel, konten, dan iklan berbayar untuk meningkatkan penjualan.',
    price: 350000,
    rating: 4.8,
    students: 1240,
    durationWeeks: 6,
    difficulty: 2,
    matchScore: 0.94,
    owned: true,
    progress: 72,
    colors: [Color(0xFF2563EB), Color(0xFF0F172A)],
  ),
  Course(
    title: 'UI/UX Design dengan Figma',
    category: 'Design',
    description:
        'Bangun portofolio desain produk digital dari riset, wireframe, prototyping, sampai handoff.',
    price: 425000,
    rating: 4.9,
    students: 980,
    durationWeeks: 8,
    difficulty: 3,
    matchScore: 0.89,
    owned: false,
    progress: 0,
    colors: [Color(0xFF7C3AED), Color(0xFF2563EB)],
  ),
  Course(
    title: 'Laravel API untuk Mobile App',
    category: 'Programming',
    description:
        'Membuat REST API Laravel, autentikasi Sanctum, upload file, dan dashboard data untuk aplikasi mobile.',
    price: 500000,
    rating: 4.7,
    students: 760,
    durationWeeks: 7,
    difficulty: 4,
    matchScore: 0.86,
    owned: false,
    progress: 0,
    colors: [Color(0xFF0F766E), Color(0xFF0F172A)],
  ),
  Course(
    title: 'Data Analyst Career Starter',
    category: 'Data',
    description:
        'Mulai dari spreadsheet, SQL, visualisasi, sampai presentasi insight untuk kebutuhan bisnis.',
    price: 300000,
    rating: 4.6,
    students: 1120,
    durationWeeks: 5,
    difficulty: 2,
    matchScore: 0.81,
    owned: true,
    progress: 100,
    colors: [Color(0xFFF59E0B), Color(0xFF1F2937)],
  ),
];

class SkillConnectShell extends StatefulWidget {
  const SkillConnectShell({super.key});

  @override
  State<SkillConnectShell> createState() => _SkillConnectShellState();
}

class _SkillConnectShellState extends State<SkillConnectShell> {
  int _index = 0;

  static const _titles = [
    'Beranda',
    'Kursus',
    'Dashboard',
    'Catatan',
    'Profil',
  ];

  @override
  Widget build(BuildContext context) {
    final pages = [
      HomePage(onExplore: () => setState(() => _index = 1)),
      const CoursesPage(),
      const DashboardPage(),
      const NotesPage(),
      const ProfilePage(),
    ];

    return Scaffold(
      appBar: AppBar(
        title: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const BrandText(),
            Text(
              _titles[_index],
              style: const TextStyle(
                color: AppColors.muted,
                fontSize: 12,
                fontWeight: FontWeight.w600,
              ),
            ),
          ],
        ),
        actions: [
          IconButton(
            tooltip: 'Notifikasi',
            onPressed: () {},
            icon: const Icon(Icons.notifications_none_rounded),
          ),
          const Padding(
            padding: EdgeInsets.only(right: 16),
            child: CircleAvatar(
              radius: 17,
              backgroundColor: Color(0xFFDBEAFE),
              child: Text(
                'B',
                style: TextStyle(
                  color: AppColors.primary,
                  fontWeight: FontWeight.w900,
                ),
              ),
            ),
          ),
        ],
      ),
      body: SafeArea(child: pages[_index]),
      bottomNavigationBar: NavigationBar(
        selectedIndex: _index,
        height: 68,
        backgroundColor: Colors.white,
        indicatorColor: const Color(0xFFDBEAFE),
        onDestinationSelected: (value) => setState(() => _index = value),
        destinations: const [
          NavigationDestination(
            icon: Icon(Icons.home_outlined),
            selectedIcon: Icon(Icons.home_rounded),
            label: 'Beranda',
          ),
          NavigationDestination(
            icon: Icon(Icons.school_outlined),
            selectedIcon: Icon(Icons.school_rounded),
            label: 'Kursus',
          ),
          NavigationDestination(
            icon: Icon(Icons.dashboard_outlined),
            selectedIcon: Icon(Icons.dashboard_rounded),
            label: 'Dashboard',
          ),
          NavigationDestination(
            icon: Icon(Icons.edit_note_outlined),
            selectedIcon: Icon(Icons.edit_note_rounded),
            label: 'Catatan',
          ),
          NavigationDestination(
            icon: Icon(Icons.person_outline_rounded),
            selectedIcon: Icon(Icons.person_rounded),
            label: 'Profil',
          ),
        ],
      ),
    );
  }
}

class BrandText extends StatelessWidget {
  const BrandText({super.key});

  @override
  Widget build(BuildContext context) {
    return RichText(
      text: const TextSpan(
        children: [
          TextSpan(
            text: 'SkillConnect',
            style: TextStyle(
              color: AppColors.primary,
              fontWeight: FontWeight.w900,
              fontSize: 20,
            ),
          ),
          TextSpan(
            text: '.id',
            style: TextStyle(
              color: AppColors.text,
              fontWeight: FontWeight.w900,
              fontSize: 20,
            ),
          ),
        ],
      ),
    );
  }
}

class HomePage extends StatelessWidget {
  const HomePage({super.key, required this.onExplore});

  final VoidCallback onExplore;

  @override
  Widget build(BuildContext context) {
    final bestCourse = courses.first;

    return ListView(
      padding: const EdgeInsets.fromLTRB(20, 12, 20, 24),
      children: [
        HeroPanel(onExplore: onExplore),
        const SizedBox(height: 18),
        const StatsGrid(),
        const SizedBox(height: 18),
        SectionHeader(
          title: 'Fitur Unggulan',
          subtitle:
              'Belajar fleksibel, tersertifikasi, dan dibantu rekomendasi AI.',
          action: null,
        ),
        const SizedBox(height: 12),
        const FeatureStrip(),
        const SizedBox(height: 20),
        AiMatchCard(course: bestCourse),
        const SizedBox(height: 20),
        SectionHeader(
          title: 'Daftar Kursus',
          subtitle: 'Urutan berdasarkan kecocokan AI',
          action: TextButton(
            onPressed: onExplore,
            child: const Text('Lihat semua'),
          ),
        ),
        const SizedBox(height: 12),
        for (final course in courses.take(3)) ...[
          CourseCard(course: course),
          const SizedBox(height: 12),
        ],
      ],
    );
  }
}

class HeroPanel extends StatelessWidget {
  const HeroPanel({super.key, required this.onExplore});

  final VoidCallback onExplore;

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(22),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(22),
        border: Border.all(color: AppColors.border),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const Pill(label: 'Platform pelatihan kerja online'),
          const SizedBox(height: 18),
          const Text(
            'Belajar, Tumbuh, dan Tersertifikasi untuk Masa Depan',
            style: TextStyle(
              color: AppColors.text,
              fontSize: 30,
              height: 1.12,
              fontWeight: FontWeight.w900,
            ),
          ),
          const SizedBox(height: 12),
          const Text(
            'Kursus praktis dengan sertifikat resmi, progress belajar, dan rekomendasi course berbasis AHP.',
            style: TextStyle(
              color: AppColors.muted,
              fontSize: 15,
              height: 1.5,
              fontWeight: FontWeight.w500,
            ),
          ),
          const SizedBox(height: 22),
          Row(
            children: [
              Expanded(
                child: FilledButton.icon(
                  onPressed: onExplore,
                  icon: const Icon(Icons.auto_awesome_rounded),
                  label: const Text('Cari Kursus'),
                  style: FilledButton.styleFrom(
                    backgroundColor: AppColors.primary,
                    padding: const EdgeInsets.symmetric(vertical: 14),
                    shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(12),
                    ),
                  ),
                ),
              ),
              const SizedBox(width: 10),
              IconButton.filledTonal(
                tooltip: 'Lihat katalog',
                onPressed: onExplore,
                icon: const Icon(Icons.arrow_forward_rounded),
                style: IconButton.styleFrom(
                  padding: const EdgeInsets.all(14),
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(12),
                  ),
                ),
              ),
            ],
          ),
        ],
      ),
    );
  }
}

class StatsGrid extends StatelessWidget {
  const StatsGrid({super.key});

  @override
  Widget build(BuildContext context) {
    const stats = [
      ('10K+', 'Peserta'),
      ('4+', 'Kursus'),
      ('95%', 'Puas'),
      ('100%', 'Sertifikat'),
    ];

    return GridView.builder(
      shrinkWrap: true,
      physics: const NeverScrollableScrollPhysics(),
      itemCount: stats.length,
      gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
        crossAxisCount: 4,
        mainAxisSpacing: 8,
        crossAxisSpacing: 8,
        childAspectRatio: .82,
      ),
      itemBuilder: (context, index) {
        final stat = stats[index];
        return Container(
          padding: const EdgeInsets.symmetric(horizontal: 6, vertical: 12),
          decoration: BoxDecoration(
            color: Colors.white,
            borderRadius: BorderRadius.circular(14),
            border: Border.all(color: AppColors.border),
          ),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Text(
                stat.$1,
                maxLines: 1,
                style: const TextStyle(
                  color: AppColors.primary,
                  fontSize: 18,
                  fontWeight: FontWeight.w900,
                ),
              ),
              const SizedBox(height: 4),
              Text(
                stat.$2,
                maxLines: 1,
                overflow: TextOverflow.ellipsis,
                style: const TextStyle(
                  color: AppColors.muted,
                  fontSize: 10,
                  fontWeight: FontWeight.w800,
                ),
              ),
            ],
          ),
        );
      },
    );
  }
}

class FeatureStrip extends StatelessWidget {
  const FeatureStrip({super.key});

  @override
  Widget build(BuildContext context) {
    const features = [
      (Icons.schedule_rounded, 'Fleksibel', 'Akses 24/7'),
      (Icons.verified_rounded, 'Sertifikat', 'Digital resmi'),
      (Icons.bolt_rounded, 'AI Match', 'AHP/SAW'),
    ];

    return Row(
      children: [
        for (final feature in features) ...[
          Expanded(
            child: Card(
              child: Padding(
                padding: const EdgeInsets.all(14),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Icon(feature.$1, color: AppColors.primary),
                    const SizedBox(height: 10),
                    Text(
                      feature.$2,
                      maxLines: 1,
                      overflow: TextOverflow.ellipsis,
                      style: const TextStyle(
                        fontWeight: FontWeight.w900,
                        fontSize: 13,
                      ),
                    ),
                    const SizedBox(height: 3),
                    Text(
                      feature.$3,
                      maxLines: 1,
                      overflow: TextOverflow.ellipsis,
                      style: const TextStyle(
                        color: AppColors.muted,
                        fontWeight: FontWeight.w600,
                        fontSize: 11,
                      ),
                    ),
                  ],
                ),
              ),
            ),
          ),
          if (feature != features.last) const SizedBox(width: 8),
        ],
      ],
    );
  }
}

class AiMatchCard extends StatelessWidget {
  const AiMatchCard({super.key, required this.course});

  final Course course;

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(18),
      decoration: BoxDecoration(
        color: AppColors.primary,
        borderRadius: BorderRadius.circular(22),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const Pill(
            label: 'AI Matching Engine',
            foreground: AppColors.primary,
            background: Colors.white,
          ),
          const SizedBox(height: 14),
          const Text(
            'Pilihan paling cocok untuk kamu',
            style: TextStyle(
              color: Colors.white,
              fontSize: 22,
              fontWeight: FontWeight.w900,
            ),
          ),
          const SizedBox(height: 14),
          CourseCard(course: course, highlighted: true),
        ],
      ),
    );
  }
}

class CoursesPage extends StatefulWidget {
  const CoursesPage({super.key});

  @override
  State<CoursesPage> createState() => _CoursesPageState();
}

class _CoursesPageState extends State<CoursesPage> {
  String _query = '';
  String _category = 'Semua kategori';

  @override
  Widget build(BuildContext context) {
    final categories = [
      'Semua kategori',
      ...courses.map((c) => c.category).toSet(),
    ];
    final filtered = courses.where((course) {
      final matchesQuery =
          course.title.toLowerCase().contains(_query.toLowerCase()) ||
          course.description.toLowerCase().contains(_query.toLowerCase());
      final matchesCategory =
          _category == 'Semua kategori' || course.category == _category;
      return matchesQuery && matchesCategory;
    }).toList();

    return ListView(
      padding: const EdgeInsets.fromLTRB(20, 12, 20, 24),
      children: [
        const SectionHeader(
          title: 'Semua Course',
          subtitle:
              'Jelajahi katalog kursus dan lanjutkan kursus yang dimiliki.',
        ),
        const SizedBox(height: 14),
        Card(
          child: Padding(
            padding: const EdgeInsets.all(14),
            child: Column(
              children: [
                TextField(
                  onChanged: (value) => setState(() => _query = value),
                  decoration: InputDecoration(
                    hintText: 'Cari judul atau deskripsi course...',
                    prefixIcon: const Icon(Icons.search_rounded),
                    filled: true,
                    fillColor: AppColors.background,
                    border: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(12),
                      borderSide: BorderSide.none,
                    ),
                  ),
                ),
                const SizedBox(height: 10),
                DropdownButtonFormField<String>(
                  initialValue: _category,
                  items: [
                    for (final category in categories)
                      DropdownMenuItem(value: category, child: Text(category)),
                  ],
                  onChanged: (value) {
                    if (value != null) setState(() => _category = value);
                  },
                  decoration: InputDecoration(
                    filled: true,
                    fillColor: AppColors.background,
                    border: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(12),
                      borderSide: BorderSide.none,
                    ),
                  ),
                ),
              ],
            ),
          ),
        ),
        const SizedBox(height: 16),
        for (final course in filtered) ...[
          CourseCard(course: course),
          const SizedBox(height: 12),
        ],
        if (filtered.isEmpty)
          const EmptyState(
            icon: Icons.search_off_rounded,
            title: 'Course tidak ditemukan',
            subtitle: 'Coba ubah kata kunci atau kategori pencarian.',
          ),
      ],
    );
  }
}

class DashboardPage extends StatelessWidget {
  const DashboardPage({super.key});

  @override
  Widget build(BuildContext context) {
    final activeCourses = courses
        .where((c) => c.owned && c.progress < 100)
        .length;
    final finishedCourses = courses
        .where((c) => c.owned && c.progress == 100)
        .length;
    final investment = courses
        .where((c) => c.owned)
        .fold<int>(0, (sum, c) => sum + c.price);
    final lastCourse = courses.firstWhere((c) => c.owned && c.progress < 100);

    return ListView(
      padding: const EdgeInsets.fromLTRB(20, 12, 20, 24),
      children: [
        const SectionHeader(
          title: 'Dashboard Utama',
          subtitle: 'Ringkasan belajar dan aktivitas terbaru.',
        ),
        const SizedBox(height: 14),
        MetricCard(
          icon: Icons.menu_book_rounded,
          title: 'Kursus Aktif',
          value: '$activeCourses',
          color: AppColors.primary,
        ),
        const SizedBox(height: 10),
        MetricCard(
          icon: Icons.verified_rounded,
          title: 'Sertifikat Selesai',
          value: '$finishedCourses',
          color: AppColors.success,
        ),
        const SizedBox(height: 10),
        MetricCard(
          icon: Icons.payments_rounded,
          title: 'Total Investasi',
          value: rupiah(investment),
          color: AppColors.warning,
        ),
        const SizedBox(height: 18),
        ContinueLearningCard(course: lastCourse),
        const SizedBox(height: 18),
        const NotesPreviewCard(),
      ],
    );
  }
}

class NotesPage extends StatelessWidget {
  const NotesPage({super.key});

  @override
  Widget build(BuildContext context) {
    const notes = [
      'Review ulang funnel digital marketing sebelum lanjut modul iklan.',
      'Catat contoh landing page yang cocok untuk project akhir.',
      'Upload bukti pembayaran setelah memilih course baru.',
    ];

    return ListView(
      padding: const EdgeInsets.fromLTRB(20, 12, 20, 24),
      children: [
        const SectionHeader(
          title: 'Catatan Pribadi',
          subtitle: 'Ruang notepad seperti fitur Livewire di web.',
        ),
        const SizedBox(height: 14),
        Card(
          child: Padding(
            padding: const EdgeInsets.all(14),
            child: Row(
              children: [
                Expanded(
                  child: TextField(
                    minLines: 1,
                    maxLines: 3,
                    decoration: InputDecoration(
                      hintText: 'Tulis catatan belajar...',
                      filled: true,
                      fillColor: AppColors.background,
                      border: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(12),
                        borderSide: BorderSide.none,
                      ),
                    ),
                  ),
                ),
                const SizedBox(width: 10),
                IconButton.filled(
                  tooltip: 'Simpan catatan',
                  onPressed: () {},
                  icon: const Icon(Icons.add_rounded),
                ),
              ],
            ),
          ),
        ),
        const SizedBox(height: 12),
        for (final note in notes) ...[
          Card(
            child: ListTile(
              leading: const CircleAvatar(
                backgroundColor: Color(0xFFFEF9C3),
                child: Icon(Icons.edit_note_rounded, color: Color(0xFF854D0E)),
              ),
              title: Text(
                note,
                style: const TextStyle(fontWeight: FontWeight.w700),
              ),
              subtitle: const Text('Hari ini'),
              trailing: IconButton(
                tooltip: 'Edit',
                onPressed: () {},
                icon: const Icon(Icons.more_horiz_rounded),
              ),
            ),
          ),
          const SizedBox(height: 10),
        ],
      ],
    );
  }
}

class ProfilePage extends StatelessWidget {
  const ProfilePage({super.key});

  @override
  Widget build(BuildContext context) {
    return ListView(
      padding: const EdgeInsets.fromLTRB(20, 12, 20, 24),
      children: [
        Card(
          child: Padding(
            padding: const EdgeInsets.all(20),
            child: Column(
              children: [
                const CircleAvatar(
                  radius: 42,
                  backgroundColor: Color(0xFFDBEAFE),
                  child: Text(
                    'B',
                    style: TextStyle(
                      color: AppColors.primary,
                      fontWeight: FontWeight.w900,
                      fontSize: 34,
                    ),
                  ),
                ),
                const SizedBox(height: 14),
                const Text(
                  'Bagus Saputra',
                  style: TextStyle(fontSize: 22, fontWeight: FontWeight.w900),
                ),
                const SizedBox(height: 4),
                const Text(
                  'siswa@skillconnect.id',
                  style: TextStyle(
                    color: AppColors.muted,
                    fontWeight: FontWeight.w600,
                  ),
                ),
                const SizedBox(height: 18),
                FilledButton.icon(
                  onPressed: () {},
                  icon: const Icon(Icons.edit_rounded),
                  label: const Text('Edit Profil'),
                ),
              ],
            ),
          ),
        ),
        const SizedBox(height: 14),
        const ProfileTile(
          icon: Icons.history_rounded,
          title: 'Riwayat Pembayaran',
        ),
        const ProfileTile(
          icon: Icons.workspace_premium_rounded,
          title: 'Sertifikat Saya',
        ),
        const ProfileTile(
          icon: Icons.lock_outline_rounded,
          title: 'Keamanan Akun',
        ),
        const ProfileTile(
          icon: Icons.logout_rounded,
          title: 'Keluar',
          danger: true,
        ),
      ],
    );
  }
}

class CourseCard extends StatelessWidget {
  const CourseCard({super.key, required this.course, this.highlighted = false});

  final Course course;
  final bool highlighted;

  @override
  Widget build(BuildContext context) {
    return Card(
      clipBehavior: Clip.antiAlias,
      child: InkWell(
        onTap: () => showCourseSheet(context, course),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            CourseImage(course: course),
            Padding(
              padding: const EdgeInsets.all(16),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Row(
                    children: [
                      Expanded(
                        child: Text(
                          course.title,
                          maxLines: 2,
                          overflow: TextOverflow.ellipsis,
                          style: const TextStyle(
                            color: AppColors.text,
                            fontSize: 18,
                            fontWeight: FontWeight.w900,
                          ),
                        ),
                      ),
                      if (course.owned)
                        const Pill(
                          label: 'Dimiliki',
                          background: Color(0xFFDCFCE7),
                          foreground: AppColors.success,
                        ),
                    ],
                  ),
                  const SizedBox(height: 8),
                  Text(
                    course.description,
                    maxLines: 2,
                    overflow: TextOverflow.ellipsis,
                    style: const TextStyle(
                      color: AppColors.muted,
                      fontSize: 13,
                      height: 1.45,
                      fontWeight: FontWeight.w500,
                    ),
                  ),
                  const SizedBox(height: 14),
                  CourseStats(course: course),
                  const SizedBox(height: 14),
                  Row(
                    children: [
                      Expanded(
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            const Text(
                              'Harga',
                              style: TextStyle(
                                color: AppColors.muted,
                                fontSize: 10,
                                fontWeight: FontWeight.w900,
                              ),
                            ),
                            Text(
                              rupiah(course.price),
                              style: const TextStyle(
                                color: AppColors.primary,
                                fontSize: 17,
                                fontWeight: FontWeight.w900,
                              ),
                            ),
                          ],
                        ),
                      ),
                      FilledButton(
                        onPressed: () => showCourseSheet(context, course),
                        style: FilledButton.styleFrom(
                          backgroundColor: course.owned
                              ? AppColors.success
                              : AppColors.primary,
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(10),
                          ),
                        ),
                        child: Text(course.owned ? 'Lanjutkan' : 'Beli Course'),
                      ),
                    ],
                  ),
                  if (course.owned) ...[
                    const SizedBox(height: 14),
                    ProgressLine(value: course.progress),
                  ],
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}

class CourseImage extends StatelessWidget {
  const CourseImage({super.key, required this.course});

  final Course course;

  @override
  Widget build(BuildContext context) {
    return AspectRatio(
      aspectRatio: 16 / 8,
      child: Stack(
        fit: StackFit.expand,
        children: [
          DecoratedBox(
            decoration: BoxDecoration(
              gradient: LinearGradient(
                begin: Alignment.topLeft,
                end: Alignment.bottomRight,
                colors: course.colors,
              ),
            ),
          ),
          Positioned(
            left: 16,
            right: 16,
            bottom: 14,
            child: Text(
              course.category,
              style: const TextStyle(
                color: Colors.white,
                fontWeight: FontWeight.w900,
                letterSpacing: 0,
              ),
            ),
          ),
          Positioned(
            top: 12,
            right: 12,
            child: Container(
              padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 6),
              decoration: BoxDecoration(
                color: Colors.white.withValues(alpha: .92),
                borderRadius: BorderRadius.circular(18),
              ),
              child: Row(
                mainAxisSize: MainAxisSize.min,
                children: [
                  const Icon(
                    Icons.auto_awesome_rounded,
                    color: AppColors.primary,
                    size: 15,
                  ),
                  const SizedBox(width: 4),
                  Text(
                    '${(course.matchScore * 100).round()}% MATCH',
                    style: const TextStyle(
                      color: AppColors.primary,
                      fontWeight: FontWeight.w900,
                      fontSize: 11,
                    ),
                  ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }
}

class CourseStats extends StatelessWidget {
  const CourseStats({super.key, required this.course});

  final Course course;

  @override
  Widget build(BuildContext context) {
    return Row(
      children: [
        Expanded(
          child: MiniStat(
            label: 'Rating',
            value: '${course.rating}',
            color: AppColors.warning,
          ),
        ),
        const SizedBox(width: 8),
        Expanded(
          child: MiniStat(
            label: 'Siswa',
            value: '${course.students}',
            color: AppColors.primary,
          ),
        ),
        const SizedBox(width: 8),
        Expanded(
          child: MiniStat(
            label: 'Durasi',
            value: '${course.durationWeeks} mgu',
            color: AppColors.text,
          ),
        ),
      ],
    );
  }
}

class MiniStat extends StatelessWidget {
  const MiniStat({
    super.key,
    required this.label,
    required this.value,
    required this.color,
  });

  final String label;
  final String value;
  final Color color;

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 10),
      decoration: BoxDecoration(
        color: AppColors.background,
        borderRadius: BorderRadius.circular(10),
      ),
      child: Column(
        children: [
          Text(
            label.toUpperCase(),
            maxLines: 1,
            overflow: TextOverflow.ellipsis,
            style: const TextStyle(
              color: AppColors.muted,
              fontSize: 9,
              fontWeight: FontWeight.w900,
            ),
          ),
          const SizedBox(height: 3),
          Text(
            value,
            maxLines: 1,
            overflow: TextOverflow.ellipsis,
            style: TextStyle(
              color: color,
              fontSize: 13,
              fontWeight: FontWeight.w900,
            ),
          ),
        ],
      ),
    );
  }
}

class ContinueLearningCard extends StatelessWidget {
  const ContinueLearningCard({super.key, required this.course});

  final Course course;

  @override
  Widget build(BuildContext context) {
    return Card(
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Row(
              children: [
                const Icon(Icons.play_circle_rounded, color: AppColors.primary),
                const SizedBox(width: 8),
                const Expanded(
                  child: Text(
                    'LANJUTKAN BELAJAR',
                    style: TextStyle(
                      color: AppColors.text,
                      fontWeight: FontWeight.w900,
                      fontSize: 13,
                    ),
                  ),
                ),
                TextButton(onPressed: () {}, child: const Text('LIHAT SEMUA')),
              ],
            ),
            const SizedBox(height: 12),
            CourseImage(course: course),
            const SizedBox(height: 14),
            Text(
              course.title,
              style: const TextStyle(fontSize: 18, fontWeight: FontWeight.w900),
            ),
            const SizedBox(height: 8),
            ProgressLine(value: course.progress),
            const SizedBox(height: 14),
            SizedBox(
              width: double.infinity,
              child: FilledButton(
                onPressed: () {},
                child: const Text('LANJUTKAN'),
              ),
            ),
          ],
        ),
      ),
    );
  }
}

class NotesPreviewCard extends StatelessWidget {
  const NotesPreviewCard({super.key});

  @override
  Widget build(BuildContext context) {
    return Card(
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: const [
            Row(
              children: [
                Icon(Icons.edit_note_rounded, color: Color(0xFF854D0E)),
                SizedBox(width: 8),
                Text(
                  'CATATAN PRIBADI',
                  style: TextStyle(
                    color: Color(0xFF854D0E),
                    fontWeight: FontWeight.w900,
                  ),
                ),
              ],
            ),
            SizedBox(height: 12),
            Text(
              'Review ulang funnel digital marketing sebelum lanjut modul iklan.',
              style: TextStyle(
                color: AppColors.text,
                height: 1.45,
                fontWeight: FontWeight.w600,
              ),
            ),
          ],
        ),
      ),
    );
  }
}

class MetricCard extends StatelessWidget {
  const MetricCard({
    super.key,
    required this.icon,
    required this.title,
    required this.value,
    required this.color,
  });

  final IconData icon;
  final String title;
  final String value;
  final Color color;

  @override
  Widget build(BuildContext context) {
    return Card(
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Row(
          children: [
            CircleAvatar(
              backgroundColor: color.withValues(alpha: .12),
              child: Icon(icon, color: color),
            ),
            const SizedBox(width: 14),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    title,
                    style: const TextStyle(
                      color: AppColors.muted,
                      fontWeight: FontWeight.w700,
                    ),
                  ),
                  const SizedBox(height: 2),
                  Text(
                    value,
                    maxLines: 1,
                    overflow: TextOverflow.ellipsis,
                    style: const TextStyle(
                      color: AppColors.text,
                      fontSize: 22,
                      fontWeight: FontWeight.w900,
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}

class ProgressLine extends StatelessWidget {
  const ProgressLine({super.key, required this.value});

  final int value;

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        Row(
          children: [
            const Text(
              'PROGRESS BELAJAR',
              style: TextStyle(
                color: AppColors.muted,
                fontSize: 10,
                fontWeight: FontWeight.w900,
              ),
            ),
            const Spacer(),
            Text(
              '$value%',
              style: const TextStyle(
                color: AppColors.text,
                fontSize: 11,
                fontWeight: FontWeight.w900,
              ),
            ),
          ],
        ),
        const SizedBox(height: 6),
        ClipRRect(
          borderRadius: BorderRadius.circular(999),
          child: LinearProgressIndicator(
            value: value / 100,
            minHeight: 7,
            backgroundColor: const Color(0xFFE5E7EB),
            valueColor: const AlwaysStoppedAnimation(AppColors.primary),
          ),
        ),
      ],
    );
  }
}

class SectionHeader extends StatelessWidget {
  const SectionHeader({
    super.key,
    required this.title,
    required this.subtitle,
    this.action,
  });

  final String title;
  final String subtitle;
  final Widget? action;

  @override
  Widget build(BuildContext context) {
    return Row(
      crossAxisAlignment: CrossAxisAlignment.end,
      children: [
        Expanded(
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                title,
                style: const TextStyle(
                  color: AppColors.text,
                  fontSize: 24,
                  fontWeight: FontWeight.w900,
                ),
              ),
              const SizedBox(height: 4),
              Text(
                subtitle,
                style: const TextStyle(
                  color: AppColors.muted,
                  fontWeight: FontWeight.w500,
                  height: 1.35,
                ),
              ),
            ],
          ),
        ),
        ?action,
      ],
    );
  }
}

class Pill extends StatelessWidget {
  const Pill({
    super.key,
    required this.label,
    this.background = const Color(0xFFDBEAFE),
    this.foreground = AppColors.primary,
  });

  final String label;
  final Color background;
  final Color foreground;

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 6),
      decoration: BoxDecoration(
        color: background,
        borderRadius: BorderRadius.circular(999),
      ),
      child: Text(
        label,
        maxLines: 1,
        overflow: TextOverflow.ellipsis,
        style: TextStyle(
          color: foreground,
          fontSize: 10,
          fontWeight: FontWeight.w900,
        ),
      ),
    );
  }
}

class ProfileTile extends StatelessWidget {
  const ProfileTile({
    super.key,
    required this.icon,
    required this.title,
    this.danger = false,
  });

  final IconData icon;
  final String title;
  final bool danger;

  @override
  Widget build(BuildContext context) {
    return Card(
      child: ListTile(
        leading: Icon(icon, color: danger ? Colors.red : AppColors.primary),
        title: Text(
          title,
          style: TextStyle(
            color: danger ? Colors.red : AppColors.text,
            fontWeight: FontWeight.w800,
          ),
        ),
        trailing: const Icon(Icons.chevron_right_rounded),
      ),
    );
  }
}

class EmptyState extends StatelessWidget {
  const EmptyState({
    super.key,
    required this.icon,
    required this.title,
    required this.subtitle,
  });

  final IconData icon;
  final String title;
  final String subtitle;

  @override
  Widget build(BuildContext context) {
    return Card(
      child: Padding(
        padding: const EdgeInsets.all(28),
        child: Column(
          children: [
            Icon(icon, color: AppColors.muted, size: 42),
            const SizedBox(height: 12),
            Text(title, style: const TextStyle(fontWeight: FontWeight.w900)),
            const SizedBox(height: 4),
            Text(
              subtitle,
              textAlign: TextAlign.center,
              style: const TextStyle(color: AppColors.muted),
            ),
          ],
        ),
      ),
    );
  }
}

void showCourseSheet(BuildContext context, Course course) {
  showModalBottomSheet<void>(
    context: context,
    isScrollControlled: true,
    backgroundColor: Colors.white,
    shape: const RoundedRectangleBorder(
      borderRadius: BorderRadius.vertical(top: Radius.circular(24)),
    ),
    builder: (context) {
      return Padding(
        padding: const EdgeInsets.fromLTRB(20, 12, 20, 28),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Center(
              child: Container(
                width: 42,
                height: 4,
                decoration: BoxDecoration(
                  color: AppColors.border,
                  borderRadius: BorderRadius.circular(999),
                ),
              ),
            ),
            const SizedBox(height: 18),
            CourseImage(course: course),
            const SizedBox(height: 16),
            Text(
              course.title,
              style: const TextStyle(fontSize: 24, fontWeight: FontWeight.w900),
            ),
            const SizedBox(height: 8),
            Text(
              course.description,
              style: const TextStyle(
                color: AppColors.muted,
                height: 1.45,
                fontWeight: FontWeight.w500,
              ),
            ),
            const SizedBox(height: 16),
            CourseStats(course: course),
            const SizedBox(height: 18),
            Row(
              children: [
                Expanded(
                  child: Text(
                    rupiah(course.price),
                    style: const TextStyle(
                      color: AppColors.primary,
                      fontSize: 24,
                      fontWeight: FontWeight.w900,
                    ),
                  ),
                ),
                FilledButton.icon(
                  onPressed: () => Navigator.of(context).pop(),
                  icon: Icon(
                    course.owned
                        ? Icons.play_arrow_rounded
                        : Icons.shopping_bag_rounded,
                  ),
                  label: Text(course.owned ? 'Lanjutkan' : 'Checkout'),
                ),
              ],
            ),
          ],
        ),
      );
    },
  );
}

String rupiah(int value) {
  final chars = value.toString().split('').reversed.toList();
  final chunks = <String>[];
  for (var i = 0; i < chars.length; i += 3) {
    chunks.add(chars.skip(i).take(3).toList().reversed.join());
  }
  return 'Rp ${chunks.reversed.join('.')}';
}
