import 'package:flutter/material.dart';

import '../data/course_data.dart';
import '../models/course.dart';
import '../repositories/course_repository.dart';
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
  late Future<List<Course>> _coursesFuture = CourseRepository().fetchCourses();

  void _refreshCourses() {
    setState(() {
      _coursesFuture = CourseRepository().fetchCourses();
    });
  }

  @override
  Widget build(BuildContext context) {
    return FutureBuilder<List<Course>>(
      future: _coursesFuture,
      builder: (context, snapshot) {
        final remoteCourses = snapshot.data;
        final sourceCourses = remoteCourses == null || remoteCourses.isEmpty
            ? courses
            : remoteCourses;
        final categories = [
          'Semua kategori',
          ...sourceCourses.map((c) => c.category).toSet(),
        ];
        final filtered = sourceCourses.where((course) {
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
            SectionHeader(
              title: 'Semua Course',
              subtitle: snapshot.hasError
                  ? 'Data contoh ditampilkan. Periksa koneksi Laravel API.'
                  : 'Data katalog diambil dari Laravel API.',
              action: IconButton(
                tooltip: 'Refresh course',
                onPressed: _refreshCourses,
                icon: const Icon(Icons.refresh_rounded),
              ),
            ),
            const SizedBox(height: 14),
            if (snapshot.connectionState == ConnectionState.waiting)
              const LinearProgressIndicator(minHeight: 3),
            if (snapshot.hasError) ...[
              const SizedBox(height: 12),
              Container(
                padding: const EdgeInsets.all(12),
                decoration: BoxDecoration(
                  color: const Color(0xFFFFFBEB),
                  borderRadius: BorderRadius.circular(12),
                  border: Border.all(color: const Color(0xFFFDE68A)),
                ),
                child: Text(
                  '${snapshot.error}',
                  style: const TextStyle(
                    color: Color(0xFF92400E),
                    fontWeight: FontWeight.w700,
                  ),
                ),
              ),
            ],
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
                      initialValue: categories.contains(_category)
                          ? _category
                          : 'Semua kategori',
                      items: [
                        for (final category in categories)
                          DropdownMenuItem(
                            value: category,
                            child: Text(category),
                          ),
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
      },
    );
  }
}
