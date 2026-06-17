import 'package:flutter/material.dart';

import '../models/course.dart';
import '../theme/app_colors.dart';

class CourseImage extends StatelessWidget {
  const CourseImage({super.key, required this.course});

  final Course course;

  @override
  Widget build(BuildContext context) {
    return AspectRatio(
      aspectRatio: 16 / 8,
      child: Stack(
        fit: StackFit.expand,
        children: [
          DecoratedBox(
            decoration: BoxDecoration(
              gradient: LinearGradient(
                begin: Alignment.topLeft,
                end: Alignment.bottomRight,
                colors: course.colors,
              ),
            ),
          ),
          if (course.imageUrl != null && course.imageUrl!.isNotEmpty)
            Image.network(
              course.imageUrl!,
              fit: BoxFit.cover,
              errorBuilder: (context, error, stackTrace) {
                return const SizedBox.shrink();
              },
            ),
          Positioned(
            left: 16,
            right: 16,
            bottom: 14,
            child: Text(
              course.category,
              style: const TextStyle(
                color: Colors.white,
                fontWeight: FontWeight.w900,
              ),
            ),
          ),
          Positioned(
            top: 12,
            right: 12,
            child: Container(
              padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 6),
              decoration: BoxDecoration(
                color: Colors.white.withValues(alpha: .92),
                borderRadius: BorderRadius.circular(18),
              ),
              child: Row(
                mainAxisSize: MainAxisSize.min,
                children: [
                  const Icon(
                    Icons.auto_awesome_rounded,
                    color: AppColors.primary,
                    size: 15,
                  ),
                  const SizedBox(width: 4),
                  Text(
                    '${(course.matchScore * 100).round()}% MATCH',
                    style: const TextStyle(
                      color: AppColors.primary,
                      fontWeight: FontWeight.w900,
                      fontSize: 11,
                    ),
                  ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }
}
