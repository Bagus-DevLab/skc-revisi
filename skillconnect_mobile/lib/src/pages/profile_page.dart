import 'package:flutter/material.dart';

import '../models/auth_user.dart';
import '../theme/app_colors.dart';
import '../widgets/profile_tile.dart';

class ProfilePage extends StatelessWidget {
  const ProfilePage({super.key, required this.user, required this.onLogout});

  final AuthUser user;
  final VoidCallback onLogout;

  @override
  Widget build(BuildContext context) {
    final initial = user.name.isNotEmpty ? user.name[0].toUpperCase() : 'U';

    return ListView(
      padding: const EdgeInsets.fromLTRB(20, 12, 20, 24),
      children: [
        Card(
          child: Padding(
            padding: const EdgeInsets.all(20),
            child: Column(
              children: [
                CircleAvatar(
                  radius: 42,
                  backgroundColor: const Color(0xFFDBEAFE),
                  child: Text(
                    initial,
                    style: const TextStyle(
                      color: AppColors.primary,
                      fontWeight: FontWeight.w900,
                      fontSize: 34,
                    ),
                  ),
                ),
                const SizedBox(height: 14),
                Text(
                  user.name,
                  style: const TextStyle(
                    fontSize: 22,
                    fontWeight: FontWeight.w900,
                  ),
                ),
                const SizedBox(height: 4),
                Text(
                  user.email,
                  style: const TextStyle(
                    color: AppColors.muted,
                    fontWeight: FontWeight.w600,
                  ),
                ),
                const SizedBox(height: 10),
                Chip(label: Text(user.roleLabel)),
                const SizedBox(height: 8),
              ],
            ),
          ),
        ),
        const SizedBox(height: 14),
        const ProfileTile(
          icon: Icons.history_rounded,
          title: 'Riwayat Pembayaran',
        ),
        const ProfileTile(
          icon: Icons.workspace_premium_rounded,
          title: 'Sertifikat Saya',
        ),
        const ProfileTile(
          icon: Icons.lock_outline_rounded,
          title: 'Keamanan Akun',
        ),
        ProfileTile(
          icon: Icons.logout_rounded,
          title: 'Keluar',
          danger: true,
          onTap: onLogout,
        ),
      ],
    );
  }
}
