import 'package:flutter/material.dart';

import '../theme/app_colors.dart';
import 'pill.dart';

class HeroPanel extends StatelessWidget {
  const HeroPanel({super.key, required this.onExplore});

  final VoidCallback onExplore;

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(22),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(22),
        border: Border.all(color: AppColors.border),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const Pill(label: 'Platform pelatihan kerja online'),
          const SizedBox(height: 18),
          const Text(
            'Belajar, Tumbuh, dan Tersertifikasi untuk Masa Depan',
            style: TextStyle(
              color: AppColors.text,
              fontSize: 30,
              height: 1.12,
              fontWeight: FontWeight.w900,
            ),
          ),
          const SizedBox(height: 12),
          const Text(
            'Kursus praktis dengan sertifikat resmi, progress belajar, dan rekomendasi course berbasis AHP.',
            style: TextStyle(
              color: AppColors.muted,
              fontSize: 15,
              height: 1.5,
              fontWeight: FontWeight.w500,
            ),
          ),
          const SizedBox(height: 22),
          Row(
            children: [
              Expanded(
                child: FilledButton.icon(
                  onPressed: onExplore,
                  icon: const Icon(Icons.auto_awesome_rounded),
                  label: const Text('Cari Kursus'),
                  style: FilledButton.styleFrom(
                    backgroundColor: AppColors.primary,
                    padding: const EdgeInsets.symmetric(vertical: 14),
                    shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(12),
                    ),
                  ),
                ),
              ),
              const SizedBox(width: 10),
              IconButton.filledTonal(
                tooltip: 'Lihat katalog',
                onPressed: onExplore,
                icon: const Icon(Icons.arrow_forward_rounded),
                style: IconButton.styleFrom(
                  padding: const EdgeInsets.all(14),
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(12),
                  ),
                ),
              ),
            ],
          ),
        ],
      ),
    );
  }
}
