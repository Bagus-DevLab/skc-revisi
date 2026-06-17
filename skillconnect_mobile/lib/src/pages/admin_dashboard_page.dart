import 'package:flutter/material.dart';

import '../theme/app_colors.dart';
import '../widgets/metric_card.dart';
import '../widgets/section_header.dart';

class AdminDashboardPage extends StatelessWidget {
  const AdminDashboardPage({super.key});

  @override
  Widget build(BuildContext context) {
    return ListView(
      padding: const EdgeInsets.fromLTRB(20, 12, 20, 24),
      children: const [
        SectionHeader(
          title: 'Dashboard Admin',
          subtitle: 'Ringkasan operasional SkillConnect.',
        ),
        SizedBox(height: 14),
        MetricCard(
          icon: Icons.school_rounded,
          title: 'Kelola Kursus',
          value: 'Aktif',
          color: AppColors.primary,
        ),
        SizedBox(height: 10),
        MetricCard(
          icon: Icons.group_rounded,
          title: 'Kelola User',
          value: 'User',
          color: AppColors.success,
        ),
        SizedBox(height: 10),
        MetricCard(
          icon: Icons.receipt_long_rounded,
          title: 'Validasi Pembayaran',
          value: 'Payment',
          color: AppColors.warning,
        ),
      ],
    );
  }
}
