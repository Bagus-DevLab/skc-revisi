import 'package:flutter/material.dart';

import '../theme/app_colors.dart';
import '../widgets/profile_tile.dart';

class ProfilePage extends StatelessWidget {
  const ProfilePage({super.key});

  @override
  Widget build(BuildContext context) {
    return ListView(
      padding: const EdgeInsets.fromLTRB(20, 12, 20, 24),
      children: const [
        Card(
          child: Padding(
            padding: EdgeInsets.all(20),
            child: Column(
              children: [
                CircleAvatar(
                  radius: 42,
                  backgroundColor: Color(0xFFDBEAFE),
                  child: Text(
                    'B',
                    style: TextStyle(
                      color: AppColors.primary,
                      fontWeight: FontWeight.w900,
                      fontSize: 34,
                    ),
                  ),
                ),
                SizedBox(height: 14),
                Text(
                  'Bagus Saputra',
                  style: TextStyle(fontSize: 22, fontWeight: FontWeight.w900),
                ),
                SizedBox(height: 4),
                Text(
                  'siswa@skillconnect.id',
                  style: TextStyle(
                    color: AppColors.muted,
                    fontWeight: FontWeight.w600,
                  ),
                ),
                SizedBox(height: 18),
              ],
            ),
          ),
        ),
        SizedBox(height: 14),
        ProfileTile(icon: Icons.history_rounded, title: 'Riwayat Pembayaran'),
        ProfileTile(
          icon: Icons.workspace_premium_rounded,
          title: 'Sertifikat Saya',
        ),
        ProfileTile(icon: Icons.lock_outline_rounded, title: 'Keamanan Akun'),
        ProfileTile(icon: Icons.logout_rounded, title: 'Keluar', danger: true),
      ],
    );
  }
}
