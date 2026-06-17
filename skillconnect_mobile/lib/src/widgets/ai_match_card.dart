import 'package:flutter/material.dart';

import '../models/course.dart';
import '../theme/app_colors.dart';
import 'course_card.dart';
import 'pill.dart';

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
          CourseCard(course: course),
        ],
      ),
    );
  }
}
