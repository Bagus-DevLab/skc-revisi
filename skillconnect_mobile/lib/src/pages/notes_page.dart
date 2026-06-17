import 'package:flutter/material.dart';

import '../theme/app_colors.dart';
import '../widgets/section_header.dart';

class NotesPage extends StatelessWidget {
  const NotesPage({super.key});

  @override
  Widget build(BuildContext context) {
    const notes = [
      'Review ulang funnel digital marketing sebelum lanjut modul iklan.',
      'Catat contoh landing page yang cocok untuk project akhir.',
      'Upload bukti pembayaran setelah memilih course baru.',
    ];

    return ListView(
      padding: const EdgeInsets.fromLTRB(20, 12, 20, 24),
      children: [
        const SectionHeader(
          title: 'Catatan Pribadi',
          subtitle: 'Ruang notepad seperti fitur Livewire di web.',
        ),
        const SizedBox(height: 14),
        Card(
          child: Padding(
            padding: const EdgeInsets.all(14),
            child: Row(
              children: [
                Expanded(
                  child: TextField(
                    minLines: 1,
                    maxLines: 3,
                    decoration: InputDecoration(
                      hintText: 'Tulis catatan belajar...',
                      filled: true,
                      fillColor: AppColors.background,
                      border: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(12),
                        borderSide: BorderSide.none,
                      ),
                    ),
                  ),
                ),
                const SizedBox(width: 10),
                IconButton.filled(
                  tooltip: 'Simpan catatan',
                  onPressed: () {},
                  icon: const Icon(Icons.add_rounded),
                ),
              ],
            ),
          ),
        ),
        const SizedBox(height: 12),
        for (final note in notes) ...[
          Card(
            child: ListTile(
              leading: const CircleAvatar(
                backgroundColor: Color(0xFFFEF9C3),
                child: Icon(Icons.edit_note_rounded, color: Color(0xFF854D0E)),
              ),
              title: Text(
                note,
                style: const TextStyle(fontWeight: FontWeight.w700),
              ),
              subtitle: const Text('Hari ini'),
              trailing: IconButton(
                tooltip: 'Edit',
                onPressed: () {},
                icon: const Icon(Icons.more_horiz_rounded),
              ),
            ),
          ),
          const SizedBox(height: 10),
        ],
      ],
    );
  }
}
