import 'package:flutter/material.dart';

import '../pages/courses_page.dart';
import '../pages/dashboard_page.dart';
import '../pages/home_page.dart';
import '../pages/notes_page.dart';
import '../pages/profile_page.dart';
import '../theme/app_colors.dart';
import '../widgets/brand_text.dart';

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
