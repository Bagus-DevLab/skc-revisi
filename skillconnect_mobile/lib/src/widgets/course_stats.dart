import 'package:flutter/material.dart';

import '../models/course.dart';
import '../theme/app_colors.dart';
import 'mini_stat.dart';

class CourseStats extends StatelessWidget {
  const CourseStats({super.key, required this.course});

  final Course course;

  @override
  Widget build(BuildContext context) {
    return Row(
      children: [
        Expanded(
          child: MiniStat(
            label: 'Rating',
            value: '${course.rating}',
            color: AppColors.warning,
          ),
        ),
        const SizedBox(width: 8),
        Expanded(
          child: MiniStat(
            label: 'Siswa',
            value: '${course.students}',
            color: AppColors.primary,
          ),
        ),
        const SizedBox(width: 8),
        Expanded(
          child: MiniStat(
            label: 'Durasi',
            value: '${course.durationWeeks} mgu',
            color: AppColors.text,
          ),
        ),
      ],
    );
  }
}
