import 'package:flutter/material.dart';

import '../theme/app_colors.dart';
import '../widgets/section_header.dart';

class AdminPaymentsPage extends StatelessWidget {
  const AdminPaymentsPage({super.key});

  @override
  Widget build(BuildContext context) {
    return ListView(
      padding: const EdgeInsets.fromLTRB(20, 12, 20, 24),
      children: [
        const SectionHeader(
          title: 'Pembayaran',
          subtitle: 'Antrian validasi pembayaran dari peserta.',
        ),
        const SizedBox(height: 14),
        for (final item in const [
          ('INV-1021', 'Menunggu validasi', AppColors.warning),
          ('INV-1018', 'Disetujui', AppColors.success),
          ('INV-1016', 'Ditolak', Colors.red),
        ]) ...[
          Card(
            child: ListTile(
              leading: CircleAvatar(
                backgroundColor: item.$3.withValues(alpha: 0.12),
                child: Icon(Icons.receipt_long_rounded, color: item.$3),
              ),
              title: Text(
                item.$1,
                style: const TextStyle(fontWeight: FontWeight.w900),
              ),
              subtitle: Text(item.$2),
              trailing: const Icon(Icons.chevron_right_rounded),
            ),
          ),
          const SizedBox(height: 8),
        ],
      ],
    );
  }
}
