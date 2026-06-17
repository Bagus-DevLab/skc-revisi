import 'package:flutter/material.dart';

import '../theme/app_colors.dart';

class BrandText extends StatelessWidget {
  const BrandText({super.key});

  @override
  Widget build(BuildContext context) {
    return RichText(
      text: const TextSpan(
        children: [
          TextSpan(
            text: 'SkillConnect',
            style: TextStyle(
              color: AppColors.primary,
              fontWeight: FontWeight.w900,
              fontSize: 20,
            ),
          ),
          TextSpan(
            text: '.id',
            style: TextStyle(
              color: AppColors.text,
              fontWeight: FontWeight.w900,
              fontSize: 20,
            ),
          ),
        ],
      ),
    );
  }
}
