import 'package:flutter/material.dart';

import '../data/course_data.dart';
import '../widgets/ai_match_card.dart';
import '../widgets/course_card.dart';
import '../widgets/feature_strip.dart';
import '../widgets/hero_panel.dart';
import '../widgets/section_header.dart';
import '../widgets/stats_grid.dart';

class HomePage extends StatelessWidget {
  const HomePage({super.key, required this.onExplore});

  final VoidCallback onExplore;

  @override
  Widget build(BuildContext context) {
    return ListView(
      padding: const EdgeInsets.fromLTRB(20, 12, 20, 24),
      children: [
        HeroPanel(onExplore: onExplore),
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
        AiMatchCard(course: courses.first),
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
