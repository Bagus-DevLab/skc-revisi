import 'package:flutter/material.dart';

import '../models/course.dart';
import '../theme/app_colors.dart';
import '../utils/currency_formatter.dart';
import 'course_image.dart';
import 'course_stats.dart';

void showCourseSheet(BuildContext context, Course course) {
  showModalBottomSheet<void>(
    context: context,
    isScrollControlled: true,
    backgroundColor: Colors.white,
    shape: const RoundedRectangleBorder(
      borderRadius: BorderRadius.vertical(top: Radius.circular(24)),
    ),
    builder: (context) => Padding(
      padding: const EdgeInsets.fromLTRB(20, 12, 20, 28),
      child: Column(
        mainAxisSize: MainAxisSize.min,
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Center(
            child: Container(
              width: 42,
              height: 4,
              decoration: BoxDecoration(
                color: AppColors.border,
                borderRadius: BorderRadius.circular(999),
              ),
            ),
          ),
          const SizedBox(height: 18),
          CourseImage(course: course),
          const SizedBox(height: 16),
          Text(
            course.title,
            style: const TextStyle(fontSize: 24, fontWeight: FontWeight.w900),
          ),
          const SizedBox(height: 8),
          Text(
            course.description,
            style: const TextStyle(
              color: AppColors.muted,
              height: 1.45,
              fontWeight: FontWeight.w500,
            ),
          ),
          const SizedBox(height: 16),
          CourseStats(course: course),
          const SizedBox(height: 18),
          Row(
            children: [
              Expanded(
                child: Text(
                  rupiah(course.price),
                  style: const TextStyle(
                    color: AppColors.primary,
                    fontSize: 24,
                    fontWeight: FontWeight.w900,
                  ),
                ),
              ),
              FilledButton.icon(
                onPressed: () => Navigator.of(context).pop(),
                icon: Icon(
                  course.owned
                      ? Icons.play_arrow_rounded
                      : Icons.shopping_bag_rounded,
                ),
                label: Text(course.owned ? 'Lanjutkan' : 'Checkout'),
              ),
            ],
          ),
        ],
      ),
    ),
  );
}
