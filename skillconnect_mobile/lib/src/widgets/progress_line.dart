import 'package:flutter/material.dart';

import '../theme/app_colors.dart';

class ProgressLine extends StatelessWidget {
  const ProgressLine({super.key, required this.value});

  final int value;

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        Row(
          children: [
            const Text(
              'PROGRESS BELAJAR',
              style: TextStyle(
                color: AppColors.muted,
                fontSize: 10,
                fontWeight: FontWeight.w900,
              ),
            ),
            const Spacer(),
            Text(
              '$value%',
              style: const TextStyle(
                color: AppColors.text,
                fontSize: 11,
                fontWeight: FontWeight.w900,
              ),
            ),
          ],
        ),
        const SizedBox(height: 6),
        ClipRRect(
          borderRadius: BorderRadius.circular(999),
          child: LinearProgressIndicator(
            value: value / 100,
            minHeight: 7,
            backgroundColor: const Color(0xFFE5E7EB),
            valueColor: const AlwaysStoppedAnimation(AppColors.primary),
          ),
        ),
      ],
    );
  }
}
