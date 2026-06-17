import 'package:flutter/material.dart';

import '../models/course.dart';
import '../theme/app_colors.dart';
import '../utils/currency_formatter.dart';
import 'course_image.dart';
import 'course_sheet.dart';
import 'course_stats.dart';
import 'pill.dart';
import 'progress_line.dart';

class CourseCard extends StatelessWidget {
  const CourseCard({
    super.key,
    required this.course,
    this.token,
    this.onUnauthorized,
    this.onChanged,
  });

  final Course course;
  final String? token;
  final Future<void> Function()? onUnauthorized;
  final VoidCallback? onChanged;

  @override
  Widget build(BuildContext context) {
    return Card(
      clipBehavior: Clip.antiAlias,
      child: InkWell(
        onTap: () => showCourseSheet(
          context,
          course,
          token: token,
          onUnauthorized: onUnauthorized,
          onChanged: onChanged,
        ),
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
                        onPressed: () => showCourseSheet(
                          context,
                          course,
                          token: token,
                          onUnauthorized: onUnauthorized,
                          onChanged: onChanged,
                        ),
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
