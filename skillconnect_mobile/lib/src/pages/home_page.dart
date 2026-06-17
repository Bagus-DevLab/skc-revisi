import 'package:flutter/material.dart';

import '../data/course_data.dart';
import '../models/course.dart';
import '../repositories/course_repository.dart';
import '../widgets/ai_match_card.dart';
import '../widgets/course_card.dart';
import '../widgets/feature_strip.dart';
import '../widgets/hero_panel.dart';
import '../widgets/section_header.dart';
import '../widgets/stats_grid.dart';

class HomePage extends StatefulWidget {
  const HomePage({super.key, required this.onExplore});

  final VoidCallback onExplore;

  @override
  State<HomePage> createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  late final Future<List<Course>> _coursesFuture = CourseRepository()
      .fetchCourses();

  @override
  Widget build(BuildContext context) {
    return FutureBuilder<List<Course>>(
      future: _coursesFuture,
      builder: (context, snapshot) {
        final remoteCourses = snapshot.data;
        final visibleCourses = remoteCourses == null || remoteCourses.isEmpty
            ? courses
            : remoteCourses;
        final usingFallback = snapshot.hasError;

        return ListView(
          padding: const EdgeInsets.fromLTRB(20, 12, 20, 24),
          children: [
            HeroPanel(onExplore: widget.onExplore),
            const SizedBox(height: 18),
            if (snapshot.connectionState == ConnectionState.waiting)
              const LinearProgressIndicator(minHeight: 3),
            if (usingFallback) ...[
              const SizedBox(height: 12),
              ApiStatusBanner(message: '${snapshot.error}'),
            ],
            const SizedBox(height: 18),
            const StatsGrid(),
            const SizedBox(height: 18),
            const SectionHeader(
              title: 'Fitur Unggulan',
              subtitle:
                  'Belajar fleksibel, tersertifikasi, dan dibantu rekomendasi AI.',
            ),
            const SizedBox(height: 12),
            const FeatureStrip(),
            const SizedBox(height: 20),
            AiMatchCard(course: visibleCourses.first),
            const SizedBox(height: 20),
            SectionHeader(
              title: 'Daftar Kursus',
              subtitle: usingFallback
                  ? 'Menampilkan data contoh karena API belum tersambung'
                  : 'Data langsung dari Laravel API',
              action: TextButton(
                onPressed: widget.onExplore,
                child: const Text('Lihat semua'),
              ),
            ),
            const SizedBox(height: 12),
            for (final course in visibleCourses.take(3)) ...[
              CourseCard(course: course),
              const SizedBox(height: 12),
            ],
          ],
        );
      },
    );
  }
}

class ApiStatusBanner extends StatelessWidget {
  const ApiStatusBanner({super.key, required this.message});

  final String message;

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(12),
      decoration: BoxDecoration(
        color: const Color(0xFFFFFBEB),
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: const Color(0xFFFDE68A)),
      ),
      child: Row(
        children: [
          const Icon(Icons.info_outline_rounded, color: Color(0xFF92400E)),
          const SizedBox(width: 10),
          Expanded(
            child: Text(
              'API belum tersambung: $message',
              style: const TextStyle(
                color: Color(0xFF92400E),
                fontWeight: FontWeight.w700,
              ),
            ),
          ),
        ],
      ),
    );
  }
}
