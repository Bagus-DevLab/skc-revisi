import 'package:flutter/material.dart';

import '../theme/app_colors.dart';

class FeatureStrip extends StatelessWidget {
  const FeatureStrip({super.key});

  @override
  Widget build(BuildContext context) {
    const features = [
      (Icons.schedule_rounded, 'Fleksibel', 'Akses 24/7'),
      (Icons.verified_rounded, 'Sertifikat', 'Digital resmi'),
      (Icons.bolt_rounded, 'AI Match', 'AHP/SAW'),
    ];
    return Row(
      children: [
        for (final feature in features) ...[
          Expanded(
            child: Card(
              child: Padding(
                padding: const EdgeInsets.all(14),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Icon(feature.$1, color: AppColors.primary),
                    const SizedBox(height: 10),
                    Text(
                      feature.$2,
                      maxLines: 1,
                      overflow: TextOverflow.ellipsis,
                      style: const TextStyle(
                        fontWeight: FontWeight.w900,
                        fontSize: 13,
                      ),
                    ),
                    const SizedBox(height: 3),
                    Text(
                      feature.$3,
                      maxLines: 1,
                      overflow: TextOverflow.ellipsis,
                      style: const TextStyle(
                        color: AppColors.muted,
                        fontWeight: FontWeight.w600,
                        fontSize: 11,
                      ),
                    ),
                  ],
                ),
              ),
            ),
          ),
          if (feature != features.last) const SizedBox(width: 8),
        ],
      ],
    );
  }
}
