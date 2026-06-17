import 'package:flutter/material.dart';

import '../data/course_data.dart';
import '../theme/app_colors.dart';
import '../widgets/course_card.dart';
import '../widgets/empty_state.dart';
import '../widgets/section_header.dart';

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
      final query = _query.toLowerCase();
      final matchesQuery =
          course.title.toLowerCase().contains(query) ||
          course.description.toLowerCase().contains(query);
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
