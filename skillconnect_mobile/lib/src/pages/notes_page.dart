import 'package:flutter/material.dart';

import '../models/note.dart';
import '../repositories/note_repository.dart';
import '../services/api_client.dart';
import '../theme/app_colors.dart';
import '../widgets/empty_state.dart';
import '../widgets/section_header.dart';

class NotesPage extends StatefulWidget {
  const NotesPage({
    super.key,
    required this.token,
    required this.onUnauthorized,
  });

  final String token;
  final Future<void> Function() onUnauthorized;

  @override
  State<NotesPage> createState() => _NotesPageState();
}

class _NotesPageState extends State<NotesPage> {
  final _repository = NoteRepository();
  final _controller = TextEditingController();
  late Future<List<Note>> _future = _load();
  Note? _editing;
  bool _saving = false;
  String? _error;

  @override
  void dispose() {
    _controller.dispose();
    super.dispose();
  }

  Future<List<Note>> _load() async {
    try {
      return await _repository.fetchNotes(widget.token);
    } on ApiException catch (error) {
      if (error.isUnauthorized) await widget.onUnauthorized();
      rethrow;
    }
  }

  void _refresh() {
    setState(() => _future = _load());
  }

  Future<void> _save() async {
    final content = _controller.text.trim();
    if (_saving || content.isEmpty) return;

    setState(() {
      _saving = true;
      _error = null;
    });

    try {
      final editing = _editing;
      if (editing == null) {
        await _repository.create(widget.token, content);
      } else {
        await _repository.update(widget.token, editing.id, content);
      }
      _controller.clear();
      _editing = null;
      _refresh();
    } on ApiException catch (error) {
      if (error.isUnauthorized) await widget.onUnauthorized();
      setState(() => _error = error.message);
    } finally {
      if (mounted) setState(() => _saving = false);
    }
  }

  Future<void> _delete(Note note) async {
    if (_saving) return;
    setState(() {
      _saving = true;
      _error = null;
    });

    try {
      await _repository.delete(widget.token, note.id);
      if (_editing?.id == note.id) {
        _editing = null;
        _controller.clear();
      }
      _refresh();
    } on ApiException catch (error) {
      if (error.isUnauthorized) await widget.onUnauthorized();
      setState(() => _error = error.message);
    } finally {
      if (mounted) setState(() => _saving = false);
    }
  }

  void _edit(Note note) {
    setState(() {
      _editing = note;
      _controller.text = note.content;
      _error = null;
    });
  }

  @override
  Widget build(BuildContext context) {
    return FutureBuilder<List<Note>>(
      future: _future,
      builder: (context, snapshot) {
        final notes = snapshot.data ?? const <Note>[];

        return RefreshIndicator(
          onRefresh: () async => _refresh(),
          child: ListView(
            padding: const EdgeInsets.fromLTRB(20, 12, 20, 24),
            children: [
              SectionHeader(
                title: 'Catatan Pribadi',
                subtitle: 'Catatan belajar tersimpan di Laravel API.',
                action: IconButton(
                  tooltip: 'Refresh catatan',
                  onPressed: _refresh,
                  icon: const Icon(Icons.refresh_rounded),
                ),
              ),
              const SizedBox(height: 14),
              Card(
                child: Padding(
                  padding: const EdgeInsets.all(14),
                  child: Column(
                    children: [
                      Row(
                        children: [
                          Expanded(
                            child: TextField(
                              controller: _controller,
                              minLines: 1,
                              maxLines: 4,
                              decoration: InputDecoration(
                                hintText: _editing == null
                                    ? 'Tulis catatan belajar...'
                                    : 'Edit catatan...',
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
                            tooltip: _editing == null
                                ? 'Simpan catatan'
                                : 'Update catatan',
                            onPressed: _saving ? null : _save,
                            icon: _saving
                                ? const SizedBox(
                                    width: 18,
                                    height: 18,
                                    child: CircularProgressIndicator(
                                      strokeWidth: 2,
                                    ),
                                  )
                                : Icon(
                                    _editing == null
                                        ? Icons.add_rounded
                                        : Icons.check_rounded,
                                  ),
                          ),
                        ],
                      ),
                      if (_editing != null)
                        Align(
                          alignment: Alignment.centerLeft,
                          child: TextButton(
                            onPressed: _saving
                                ? null
                                : () => setState(() {
                                    _editing = null;
                                    _controller.clear();
                                  }),
                            child: const Text('Batal edit'),
                          ),
                        ),
                    ],
                  ),
                ),
              ),
              if (_error != null) ...[
                const SizedBox(height: 10),
                Text(
                  _error!,
                  style: const TextStyle(
                    color: Color(0xFFB91C1C),
                    fontWeight: FontWeight.w700,
                  ),
                ),
              ],
              const SizedBox(height: 12),
              if (snapshot.connectionState == ConnectionState.waiting)
                const LinearProgressIndicator(minHeight: 3),
              if (snapshot.hasError)
                EmptyState(
                  icon: Icons.cloud_off_rounded,
                  title: 'Catatan belum bisa dimuat',
                  subtitle: '${snapshot.error}',
                )
              else if (notes.isEmpty)
                const EmptyState(
                  icon: Icons.edit_note_rounded,
                  title: 'Belum ada catatan',
                  subtitle: 'Tulis catatan pertama dari form di atas.',
                )
              else
                for (final note in notes) ...[
                  Card(
                    child: ListTile(
                      leading: const CircleAvatar(
                        backgroundColor: Color(0xFFFEF9C3),
                        child: Icon(
                          Icons.edit_note_rounded,
                          color: Color(0xFF854D0E),
                        ),
                      ),
                      title: Text(
                        note.content,
                        style: const TextStyle(fontWeight: FontWeight.w700),
                      ),
                      subtitle: Text(note.updatedAt ?? note.createdAt ?? '-'),
                      trailing: PopupMenuButton<String>(
                        onSelected: (value) {
                          if (value == 'edit') _edit(note);
                          if (value == 'delete') _delete(note);
                        },
                        itemBuilder: (context) => const [
                          PopupMenuItem(value: 'edit', child: Text('Edit')),
                          PopupMenuItem(value: 'delete', child: Text('Hapus')),
                        ],
                      ),
                    ),
                  ),
                  const SizedBox(height: 10),
                ],
            ],
          ),
        );
      },
    );
  }
}
