import 'package:flutter/material.dart';

import '../theme/app_colors.dart';

class Pill extends StatelessWidget {
  const Pill({
    super.key,
    required this.label,
    this.background = const Color(0xFFDBEAFE),
    this.foreground = AppColors.primary,
  });

  final String label;
  final Color background;
  final Color foreground;

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 6),
      decoration: BoxDecoration(
        color: background,
        borderRadius: BorderRadius.circular(999),
      ),
      child: Text(
        label,
        maxLines: 1,
        overflow: TextOverflow.ellipsis,
        style: TextStyle(
          color: foreground,
          fontSize: 10,
          fontWeight: FontWeight.w900,
        ),
      ),
    );
  }
}
