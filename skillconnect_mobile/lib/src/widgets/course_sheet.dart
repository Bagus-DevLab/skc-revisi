import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';

import '../models/course.dart';
import '../models/lesson.dart';
import '../repositories/course_repository.dart';
import '../repositories/payment_repository.dart';
import '../services/api_client.dart';
import '../theme/app_colors.dart';
import '../utils/currency_formatter.dart';
import 'course_image.dart';
import 'course_stats.dart';

void showCourseSheet(
  BuildContext context,
  Course course, {
  String? token,
  Future<void> Function()? onUnauthorized,
  VoidCallback? onChanged,
}) {
  showModalBottomSheet<void>(
    context: context,
    isScrollControlled: true,
    backgroundColor: Colors.white,
    shape: const RoundedRectangleBorder(
      borderRadius: BorderRadius.vertical(top: Radius.circular(24)),
    ),
    builder: (context) => _CourseSheet(
      course: course,
      token: token,
      onUnauthorized: onUnauthorized,
      onChanged: onChanged,
    ),
  );
}

class _CourseSheet extends StatefulWidget {
  const _CourseSheet({
    required this.course,
    required this.token,
    required this.onUnauthorized,
    required this.onChanged,
  });

  final Course course;
  final String? token;
  final Future<void> Function()? onUnauthorized;
  final VoidCallback? onChanged;

  @override
  State<_CourseSheet> createState() => _CourseSheetState();
}

class _CourseSheetState extends State<_CourseSheet> {
  final _courseRepository = CourseRepository();
  final _paymentRepository = PaymentRepository();
  final _picker = ImagePicker();
  String _method = 'bank_transfer';
  int? _paymentId;
  bool _loading = false;
  String? _message;
  Future<List<Lesson>>? _lessonsFuture;

  @override
  void initState() {
    super.initState();
    if (widget.course.owned && widget.token != null) {
      _lessonsFuture = _loadLessons();
    }
  }

  Future<List<Lesson>> _loadLessons() async {
    try {
      return await _courseRepository.fetchLessons(
        widget.token!,
        widget.course.id,
      );
    } on ApiException catch (error) {
      if (error.isUnauthorized) await widget.onUnauthorized?.call();
      rethrow;
    }
  }

  Future<void> _checkout() async {
    if (_loading || widget.token == null) return;
    setState(() {
      _loading = true;
      _message = null;
    });

    try {
      final data = await _paymentRepository.checkout(
        token: widget.token!,
        courseId: widget.course.id,
        paymentMethod: _method,
      );
      setState(() {
        _paymentId = int.tryParse('${data['payment_id'] ?? 0}');
        _message = 'Pesanan dibuat. Upload bukti pembayaran untuk diproses.';
      });
      widget.onChanged?.call();
    } on ApiException catch (error) {
      if (error.isUnauthorized) await widget.onUnauthorized?.call();
      setState(() => _message = error.message);
    } finally {
      if (mounted) setState(() => _loading = false);
    }
  }

  Future<void> _uploadProof(ImageSource source) async {
    if (_loading || widget.token == null || _paymentId == null) return;
    final image = await _picker.pickImage(source: source, imageQuality: 85);
    if (image == null) return;

    setState(() {
      _loading = true;
      _message = null;
    });

    try {
      await _paymentRepository.uploadProof(
        token: widget.token!,
        paymentId: _paymentId!,
        filePath: image.path,
      );
      setState(() => _message = 'Bukti pembayaran berhasil diupload.');
      widget.onChanged?.call();
    } on ApiException catch (error) {
      if (error.isUnauthorized) await widget.onUnauthorized?.call();
      setState(() => _message = error.message);
    } finally {
      if (mounted) setState(() => _loading = false);
    }
  }

  Future<void> _complete(Lesson lesson) async {
    if (_loading || widget.token == null || lesson.isCompleted) return;
    setState(() => _loading = true);
    try {
      await _courseRepository.completeLesson(widget.token!, lesson.id);
      setState(() => _lessonsFuture = _loadLessons());
      widget.onChanged?.call();
    } on ApiException catch (error) {
      if (error.isUnauthorized) await widget.onUnauthorized?.call();
      setState(() => _message = error.message);
    } finally {
      if (mounted) setState(() => _loading = false);
    }
  }

  Future<void> _completeDefaultMaterial() async {
    if (_loading || widget.token == null || widget.course.progress >= 100) {
      return;
    }
    setState(() {
      _loading = true;
      _message = null;
    });
    try {
      await _courseRepository.completeCourseProgress(
        widget.token!,
        widget.course.id,
      );
      setState(() {
        _message = 'Materi berhasil diselesaikan. Progress course diperbarui.';
        _lessonsFuture = _loadLessons();
      });
      widget.onChanged?.call();
    } on ApiException catch (error) {
      if (error.isUnauthorized) await widget.onUnauthorized?.call();
      setState(() => _message = error.message);
    } finally {
      if (mounted) setState(() => _loading = false);
    }
  }

  void _openLesson(Lesson lesson) {
    showModalBottomSheet<void>(
      context: context,
      isScrollControlled: true,
      backgroundColor: Colors.white,
      shape: const RoundedRectangleBorder(
        borderRadius: BorderRadius.vertical(top: Radius.circular(24)),
      ),
      builder: (context) => _LessonDetailSheet(
        lesson: lesson,
        loading: _loading,
        onComplete: lesson.isCompleted
            ? null
            : () async {
                Navigator.of(context).pop();
                await _complete(lesson);
              },
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return DraggableScrollableSheet(
      expand: false,
      initialChildSize: 0.86,
      maxChildSize: 0.95,
      minChildSize: 0.45,
      builder: (context, scrollController) => ListView(
        controller: scrollController,
        padding: const EdgeInsets.fromLTRB(20, 12, 20, 28),
        children: [
          Center(
            child: Container(
              width: 42,
              height: 4,
              decoration: BoxDecoration(
                color: AppColors.border,
                borderRadius: BorderRadius.circular(999),
              ),
            ),
          ),
          const SizedBox(height: 18),
          CourseImage(course: widget.course),
          const SizedBox(height: 16),
          Text(
            widget.course.title,
            style: const TextStyle(fontSize: 24, fontWeight: FontWeight.w900),
          ),
          const SizedBox(height: 8),
          Text(
            widget.course.description,
            style: const TextStyle(
              color: AppColors.muted,
              height: 1.45,
              fontWeight: FontWeight.w500,
            ),
          ),
          const SizedBox(height: 16),
          CourseStats(course: widget.course),
          const SizedBox(height: 18),
          if (_message != null) ...[
            _InlineMessage(message: _message!),
            const SizedBox(height: 14),
          ],
          if (widget.course.owned) _lessonList() else _checkoutPanel(),
        ],
      ),
    );
  }

  Widget _checkoutPanel() {
    if (widget.token == null) {
      return FilledButton.icon(
        onPressed: () => Navigator.of(context).pop(),
        icon: const Icon(Icons.login_rounded),
        label: const Text('Login untuk checkout'),
      );
    }

    return Column(
      crossAxisAlignment: CrossAxisAlignment.stretch,
      children: [
        Row(
          children: [
            Expanded(
              child: Text(
                rupiah(widget.course.price),
                style: const TextStyle(
                  color: AppColors.primary,
                  fontSize: 24,
                  fontWeight: FontWeight.w900,
                ),
              ),
            ),
            DropdownButton<String>(
              value: _method,
              items: const [
                DropdownMenuItem(
                  value: 'bank_transfer',
                  child: Text('Transfer'),
                ),
                DropdownMenuItem(value: 'ewallet', child: Text('E-Wallet')),
              ],
              onChanged: _loading
                  ? null
                  : (value) => setState(() => _method = value ?? _method),
            ),
          ],
        ),
        const SizedBox(height: 12),
        FilledButton.icon(
          onPressed: _loading ? null : _checkout,
          icon: _loading
              ? const SizedBox(
                  width: 18,
                  height: 18,
                  child: CircularProgressIndicator(strokeWidth: 2),
                )
              : const Icon(Icons.shopping_bag_rounded),
          label: const Text('Checkout'),
        ),
        if (_paymentId != null) ...[
          const SizedBox(height: 10),
          Row(
            children: [
              Expanded(
                child: OutlinedButton.icon(
                  onPressed: _loading
                      ? null
                      : () => _uploadProof(ImageSource.gallery),
                  icon: const Icon(Icons.photo_library_rounded),
                  label: const Text('Galeri'),
                ),
              ),
              const SizedBox(width: 10),
              Expanded(
                child: OutlinedButton.icon(
                  onPressed: _loading
                      ? null
                      : () => _uploadProof(ImageSource.camera),
                  icon: const Icon(Icons.photo_camera_rounded),
                  label: const Text('Kamera'),
                ),
              ),
            ],
          ),
        ],
      ],
    );
  }

  Widget _lessonList() {
    return FutureBuilder<List<Lesson>>(
      future: _lessonsFuture,
      builder: (context, snapshot) {
        if (snapshot.connectionState == ConnectionState.waiting) {
          return const LinearProgressIndicator(minHeight: 3);
        }
        if (snapshot.hasError) {
          return _InlineMessage(message: '${snapshot.error}');
        }
        final lessons = snapshot.data ?? const <Lesson>[];
        if (lessons.isEmpty) {
          return _DefaultCourseMaterial(
            course: widget.course,
            loading: _loading,
            onComplete: _completeDefaultMaterial,
          );
        }
        return Column(
          children: [
            for (final lesson in lessons)
              ListTile(
                contentPadding: EdgeInsets.zero,
                onTap: () => _openLesson(lesson),
                leading: CircleAvatar(
                  backgroundColor: lesson.isCompleted
                      ? const Color(0xFFDCFCE7)
                      : const Color(0xFFDBEAFE),
                  child: Icon(
                    lesson.isCompleted
                        ? Icons.check_rounded
                        : Icons.play_arrow_rounded,
                    color: lesson.isCompleted
                        ? AppColors.success
                        : AppColors.primary,
                  ),
                ),
                title: Text(
                  lesson.title,
                  style: const TextStyle(fontWeight: FontWeight.w800),
                ),
                subtitle: Text(lesson.description),
                trailing: TextButton(
                  onPressed: _loading || lesson.isCompleted
                      ? null
                      : () => _complete(lesson),
                  child: Text(lesson.isCompleted ? 'Selesai' : 'Tandai'),
                ),
              ),
          ],
        );
      },
    );
  }
}

class _LessonDetailSheet extends StatelessWidget {
  const _LessonDetailSheet({
    required this.lesson,
    required this.loading,
    required this.onComplete,
  });

  final Lesson lesson;
  final bool loading;
  final Future<void> Function()? onComplete;

  @override
  Widget build(BuildContext context) {
    final hasVideo = lesson.videoUrl != null && lesson.videoUrl!.isNotEmpty;
    final hasContent = lesson.content.trim().isNotEmpty;

    return DraggableScrollableSheet(
      expand: false,
      initialChildSize: 0.78,
      maxChildSize: 0.94,
      minChildSize: 0.45,
      builder: (context, controller) => ListView(
        controller: controller,
        padding: const EdgeInsets.fromLTRB(20, 12, 20, 28),
        children: [
          Center(
            child: Container(
              width: 42,
              height: 4,
              decoration: BoxDecoration(
                color: AppColors.border,
                borderRadius: BorderRadius.circular(999),
              ),
            ),
          ),
          const SizedBox(height: 18),
          Row(
            children: [
              CircleAvatar(
                backgroundColor: lesson.isCompleted
                    ? const Color(0xFFDCFCE7)
                    : const Color(0xFFDBEAFE),
                child: Icon(
                  lesson.isCompleted
                      ? Icons.check_rounded
                      : Icons.play_arrow_rounded,
                  color: lesson.isCompleted
                      ? AppColors.success
                      : AppColors.primary,
                ),
              ),
              const SizedBox(width: 12),
              Expanded(
                child: Text(
                  lesson.title,
                  style: const TextStyle(
                    fontSize: 22,
                    fontWeight: FontWeight.w900,
                  ),
                ),
              ),
            ],
          ),
          if (lesson.description.isNotEmpty) ...[
            const SizedBox(height: 12),
            Text(
              lesson.description,
              style: const TextStyle(
                color: AppColors.muted,
                height: 1.45,
                fontWeight: FontWeight.w600,
              ),
            ),
          ],
          const SizedBox(height: 18),
          if (hasVideo)
            Container(
              padding: const EdgeInsets.all(14),
              decoration: BoxDecoration(
                color: const Color(0xFFEFF6FF),
                borderRadius: BorderRadius.circular(12),
                border: Border.all(color: const Color(0xFFBFDBFE)),
              ),
              child: Row(
                children: [
                  const Icon(
                    Icons.ondemand_video_rounded,
                    color: AppColors.primary,
                  ),
                  const SizedBox(width: 10),
                  Expanded(
                    child: Text(
                      lesson.videoUrl!,
                      style: const TextStyle(
                        color: AppColors.primary,
                        fontWeight: FontWeight.w700,
                      ),
                    ),
                  ),
                ],
              ),
            )
          else
            Container(
              height: 180,
              alignment: Alignment.center,
              decoration: BoxDecoration(
                color: AppColors.background,
                borderRadius: BorderRadius.circular(12),
                border: Border.all(color: AppColors.border),
              ),
              child: const Icon(
                Icons.menu_book_rounded,
                size: 48,
                color: AppColors.muted,
              ),
            ),
          const SizedBox(height: 18),
          Text(
            hasContent ? lesson.content : 'Konten materi belum tersedia.',
            style: const TextStyle(
              color: AppColors.text,
              height: 1.55,
              fontWeight: FontWeight.w500,
            ),
          ),
          const SizedBox(height: 20),
          FilledButton.icon(
            onPressed: loading ? null : onComplete,
            icon: lesson.isCompleted
                ? const Icon(Icons.check_rounded)
                : const Icon(Icons.done_rounded),
            label: Text(
              lesson.isCompleted ? 'Sudah Selesai' : 'Tandai Selesai',
            ),
          ),
        ],
      ),
    );
  }
}

class _DefaultCourseMaterial extends StatelessWidget {
  const _DefaultCourseMaterial({
    required this.course,
    required this.loading,
    required this.onComplete,
  });

  final Course course;
  final bool loading;
  final Future<void> Function() onComplete;

  void _openMaterial(BuildContext context) {
    showModalBottomSheet<void>(
      context: context,
      isScrollControlled: true,
      backgroundColor: Colors.white,
      shape: const RoundedRectangleBorder(
        borderRadius: BorderRadius.vertical(top: Radius.circular(24)),
      ),
      builder: (context) => _DefaultMaterialDetailSheet(
        course: course,
        loading: loading,
        onComplete: course.progress >= 100
            ? null
            : () async {
                Navigator.of(context).pop();
                await onComplete();
              },
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.stretch,
      children: [
        Container(
          padding: const EdgeInsets.all(14),
          decoration: BoxDecoration(
            color: const Color(0xFFEFF6FF),
            borderRadius: BorderRadius.circular(12),
            border: Border.all(color: const Color(0xFFBFDBFE)),
          ),
          child: const Text(
            'Materi default ditampilkan karena lesson detail belum dibuat oleh admin.',
            style: TextStyle(
              color: AppColors.primary,
              fontWeight: FontWeight.w800,
            ),
          ),
        ),
        const SizedBox(height: 12),
        ListTile(
          contentPadding: EdgeInsets.zero,
          onTap: () => _openMaterial(context),
          leading: const CircleAvatar(
            backgroundColor: Color(0xFFDBEAFE),
            child: Icon(Icons.play_arrow_rounded, color: AppColors.primary),
          ),
          title: Text(
            'Perkenalan ${course.title}',
            style: const TextStyle(fontWeight: FontWeight.w900),
          ),
          subtitle: Text(
            'Video 1 dari 10 • Dasar ${course.category}',
            maxLines: 2,
            overflow: TextOverflow.ellipsis,
          ),
          trailing: TextButton(
            onPressed: loading || course.progress >= 100 ? null : onComplete,
            child: Text(course.progress >= 100 ? 'Selesai' : 'Tandai'),
          ),
        ),
        const SizedBox(height: 10),
        FilledButton.icon(
          onPressed: () => _openMaterial(context),
          icon: const Icon(Icons.menu_book_rounded),
          label: const Text('Buka Materi'),
        ),
      ],
    );
  }
}

class _DefaultMaterialDetailSheet extends StatelessWidget {
  const _DefaultMaterialDetailSheet({
    required this.course,
    required this.loading,
    required this.onComplete,
  });

  final Course course;
  final bool loading;
  final Future<void> Function()? onComplete;

  @override
  Widget build(BuildContext context) {
    return DraggableScrollableSheet(
      expand: false,
      initialChildSize: 0.82,
      maxChildSize: 0.95,
      minChildSize: 0.45,
      builder: (context, controller) => ListView(
        controller: controller,
        padding: const EdgeInsets.fromLTRB(20, 12, 20, 28),
        children: [
          Center(
            child: Container(
              width: 42,
              height: 4,
              decoration: BoxDecoration(
                color: AppColors.border,
                borderRadius: BorderRadius.circular(999),
              ),
            ),
          ),
          const SizedBox(height: 18),
          Text(
            'Perkenalan ${course.title}',
            style: const TextStyle(fontSize: 24, fontWeight: FontWeight.w900),
          ),
          const SizedBox(height: 8),
          Text(
            'Video 1 dari 10 • Durasi: 15 menit',
            style: const TextStyle(
              color: AppColors.muted,
              fontWeight: FontWeight.w700,
            ),
          ),
          const SizedBox(height: 18),
          Container(
            height: 190,
            alignment: Alignment.center,
            decoration: BoxDecoration(
              color: Colors.black,
              borderRadius: BorderRadius.circular(14),
            ),
            child: const Icon(
              Icons.play_circle_fill_rounded,
              color: Colors.white,
              size: 64,
            ),
          ),
          const SizedBox(height: 18),
          const Text(
            'Tentang Video Ini',
            style: TextStyle(fontSize: 18, fontWeight: FontWeight.w900),
          ),
          const SizedBox(height: 10),
          Text(
            course.description,
            style: const TextStyle(
              color: AppColors.muted,
              height: 1.5,
              fontWeight: FontWeight.w600,
            ),
          ),
          const SizedBox(height: 18),
          const Text(
            'Yang Akan Dipelajari',
            style: TextStyle(fontSize: 18, fontWeight: FontWeight.w900),
          ),
          const SizedBox(height: 10),
          _LearningPoint('Memahami konsep dasar ${course.category}'),
          const _LearningPoint('Menguasai tools dan framework terkini'),
          const _LearningPoint('Praktik langsung dengan studi kasus nyata'),
          const _LearningPoint('Tips dan trik dari praktisi berpengalaman'),
          const SizedBox(height: 20),
          FilledButton.icon(
            onPressed: loading ? null : onComplete,
            icon: course.progress >= 100
                ? const Icon(Icons.check_rounded)
                : const Icon(Icons.done_rounded),
            label: Text(
              course.progress >= 100
                  ? 'Course Sudah Selesai'
                  : 'Tandai Selesai & Lanjut',
            ),
          ),
        ],
      ),
    );
  }
}

class _LearningPoint extends StatelessWidget {
  const _LearningPoint(this.text);

  final String text;

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 8),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const Icon(Icons.check_rounded, color: AppColors.success, size: 18),
          const SizedBox(width: 8),
          Expanded(
            child: Text(
              text,
              style: const TextStyle(
                color: AppColors.text,
                fontWeight: FontWeight.w600,
              ),
            ),
          ),
        ],
      ),
    );
  }
}

class _InlineMessage extends StatelessWidget {
  const _InlineMessage({required this.message});

  final String message;

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(12),
      decoration: BoxDecoration(
        color: const Color(0xFFFFFBEB),
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: const Color(0xFFFDE68A)),
      ),
      child: Text(
        message,
        style: const TextStyle(
          color: Color(0xFF92400E),
          fontWeight: FontWeight.w700,
        ),
      ),
    );
  }
}
