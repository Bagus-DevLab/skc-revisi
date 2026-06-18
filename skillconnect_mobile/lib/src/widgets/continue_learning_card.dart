import 'package:flutter/material.dart';

import '../models/course.dart';
import '../theme/app_colors.dart';
import 'course_image.dart';
import 'course_sheet.dart';
import 'progress_line.dart';

class ContinueLearningCard extends StatelessWidget {
  const ContinueLearningCard({
    super.key,
    required this.course,
    required this.token,
    required this.onUnauthorized,
    this.onChanged,
  });

  final Course course;
  final String token;
  final Future<void> Function() onUnauthorized;
  final VoidCallback? onChanged;

  void _openCourse(BuildContext context) {
    showCourseSheet(
      context,
      course,
      token: token,
      onUnauthorized: onUnauthorized,
      onChanged: onChanged,
    );
  }

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
                TextButton(
                  onPressed: () => _openCourse(context),
                  child: const Text('BUKA'),
                ),
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
                onPressed: () => _openCourse(context),
                child: const Text('LANJUTKAN'),
              ),
            ),
          ],
        ),
      ),
    );
  }
}
