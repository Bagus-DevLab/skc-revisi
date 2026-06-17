import 'package:flutter/material.dart';

import '../models/course.dart';
import '../theme/app_colors.dart';
import 'course_image.dart';
import 'progress_line.dart';

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
