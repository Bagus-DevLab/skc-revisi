import 'package:flutter/material.dart';

import '../theme/app_colors.dart';

class NotesPreviewCard extends StatelessWidget {
  const NotesPreviewCard({super.key});

  @override
  Widget build(BuildContext context) {
    return const Card(
      child: Padding(
        padding: EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Row(
              children: [
                Icon(Icons.edit_note_rounded, color: Color(0xFF854D0E)),
                SizedBox(width: 8),
                Text(
                  'CATATAN PRIBADI',
                  style: TextStyle(
                    color: Color(0xFF854D0E),
                    fontWeight: FontWeight.w900,
                  ),
                ),
              ],
            ),
            SizedBox(height: 12),
            Text(
              'Review ulang funnel digital marketing sebelum lanjut modul iklan.',
              style: TextStyle(
                color: AppColors.text,
                height: 1.45,
                fontWeight: FontWeight.w600,
              ),
            ),
          ],
        ),
      ),
    );
  }
}
