import 'package:flutter/material.dart';

import '../data/course_data.dart';
import '../theme/app_colors.dart';
import '../utils/currency_formatter.dart';
import '../widgets/continue_learning_card.dart';
import '../widgets/metric_card.dart';
import '../widgets/notes_preview_card.dart';
import '../widgets/section_header.dart';

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
