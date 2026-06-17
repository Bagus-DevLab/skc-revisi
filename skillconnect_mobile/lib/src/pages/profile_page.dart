import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';

import '../models/auth_session.dart';
import '../models/course.dart';
import '../models/payment.dart';
import '../repositories/course_repository.dart';
import '../repositories/payment_repository.dart';
import '../repositories/profile_repository.dart';
import '../services/api_client.dart';
import '../theme/app_colors.dart';
import '../utils/currency_formatter.dart';
import '../widgets/empty_state.dart';
import '../widgets/profile_tile.dart';

class ProfilePage extends StatefulWidget {
  const ProfilePage({
    super.key,
    required this.session,
    required this.onLogout,
    required this.onUnauthorized,
    required this.onSessionChanged,
  });

  final AuthSession session;
  final Future<void> Function() onLogout;
  final Future<void> Function() onUnauthorized;
  final Future<void> Function(AuthSession session) onSessionChanged;

  @override
  State<ProfilePage> createState() => _ProfilePageState();
}

class _ProfilePageState extends State<ProfilePage> {
  final _profileRepository = ProfileRepository();
  final _paymentRepository = PaymentRepository();
  final _courseRepository = CourseRepository();
  final _picker = ImagePicker();
  late final _nameController = TextEditingController(
    text: widget.session.user.name,
  );
  late final _emailController = TextEditingController(
    text: widget.session.user.email,
  );
  bool _saving = false;
  String? _message;

  @override
  void dispose() {
    _nameController.dispose();
    _emailController.dispose();
    super.dispose();
  }

  Future<void> _updateProfile() async {
    if (_saving) return;
    setState(() {
      _saving = true;
      _message = null;
    });
    try {
      final user = await _profileRepository.updateProfile(
        token: widget.session.token,
        name: _nameController.text.trim(),
        email: _emailController.text.trim(),
      );
      await widget.onSessionChanged(
        AuthSession(token: widget.session.token, user: user),
      );
      setState(() => _message = 'Profil berhasil diperbarui.');
    } on ApiException catch (error) {
      if (error.isUnauthorized) await widget.onUnauthorized();
      setState(() => _message = error.message);
    } finally {
      if (mounted) setState(() => _saving = false);
    }
  }

  Future<void> _uploadAvatar(ImageSource source) async {
    if (_saving) return;
    final image = await _picker.pickImage(source: source, imageQuality: 85);
    if (image == null) return;

    setState(() {
      _saving = true;
      _message = null;
    });
    try {
      final user = await _profileRepository.uploadAvatar(
        token: widget.session.token,
        filePath: image.path,
      );
      await widget.onSessionChanged(
        AuthSession(token: widget.session.token, user: user),
      );
      setState(() => _message = 'Avatar berhasil diupload.');
    } on ApiException catch (error) {
      if (error.isUnauthorized) await widget.onUnauthorized();
      setState(() => _message = error.message);
    } finally {
      if (mounted) setState(() => _saving = false);
    }
  }

  @override
  Widget build(BuildContext context) {
    final user = widget.session.user;
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
                  backgroundImage: user.avatarUrl == null
                      ? null
                      : NetworkImage(user.avatarUrl!),
                  child: user.avatarUrl == null
                      ? Text(
                          initial,
                          style: const TextStyle(
                            color: AppColors.primary,
                            fontWeight: FontWeight.w900,
                            fontSize: 34,
                          ),
                        )
                      : null,
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
                const SizedBox(height: 12),
                Row(
                  children: [
                    Expanded(
                      child: OutlinedButton.icon(
                        onPressed: _saving
                            ? null
                            : () => _uploadAvatar(ImageSource.gallery),
                        icon: const Icon(Icons.photo_library_rounded),
                        label: const Text('Galeri'),
                      ),
                    ),
                    const SizedBox(width: 10),
                    Expanded(
                      child: OutlinedButton.icon(
                        onPressed: _saving
                            ? null
                            : () => _uploadAvatar(ImageSource.camera),
                        icon: const Icon(Icons.photo_camera_rounded),
                        label: const Text('Kamera'),
                      ),
                    ),
                  ],
                ),
              ],
            ),
          ),
        ),
        const SizedBox(height: 14),
        Card(
          child: Padding(
            padding: const EdgeInsets.all(16),
            child: Column(
              children: [
                TextField(
                  controller: _nameController,
                  decoration: const InputDecoration(
                    labelText: 'Nama',
                    prefixIcon: Icon(Icons.badge_outlined),
                  ),
                ),
                const SizedBox(height: 10),
                TextField(
                  controller: _emailController,
                  keyboardType: TextInputType.emailAddress,
                  decoration: const InputDecoration(
                    labelText: 'Email',
                    prefixIcon: Icon(Icons.email_outlined),
                  ),
                ),
                if (_message != null) ...[
                  const SizedBox(height: 10),
                  Text(
                    _message!,
                    style: const TextStyle(fontWeight: FontWeight.w700),
                  ),
                ],
                const SizedBox(height: 12),
                FilledButton.icon(
                  onPressed: _saving ? null : _updateProfile,
                  icon: _saving
                      ? const SizedBox(
                          width: 18,
                          height: 18,
                          child: CircularProgressIndicator(strokeWidth: 2),
                        )
                      : const Icon(Icons.save_rounded),
                  label: const Text('Simpan Profil'),
                ),
              ],
            ),
          ),
        ),
        const SizedBox(height: 14),
        ProfileTile(
          icon: Icons.history_rounded,
          title: 'Riwayat Pembayaran',
          onTap: () => _showPaymentHistory(context),
        ),
        ProfileTile(
          icon: Icons.workspace_premium_rounded,
          title: 'Sertifikat Saya',
          onTap: () => _showCertificates(context),
        ),
        ProfileTile(
          icon: Icons.logout_rounded,
          title: 'Keluar',
          danger: true,
          onTap: widget.onLogout,
        ),
      ],
    );
  }

  void _showPaymentHistory(BuildContext context) {
    showModalBottomSheet<void>(
      context: context,
      isScrollControlled: true,
      builder: (context) => _PaymentHistorySheet(
        future: _paymentRepository.history(widget.session.token),
      ),
    );
  }

  void _showCertificates(BuildContext context) {
    showModalBottomSheet<void>(
      context: context,
      isScrollControlled: true,
      builder: (context) => _CertificatesSheet(
        future: _courseRepository.fetchMyCertificates(widget.session.token),
      ),
    );
  }
}

class _PaymentHistorySheet extends StatelessWidget {
  const _PaymentHistorySheet({required this.future});

  final Future<PaymentPage> future;

  @override
  Widget build(BuildContext context) {
    return _SheetFrame(
      title: 'Riwayat Pembayaran',
      child: FutureBuilder<PaymentPage>(
        future: future,
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return const LinearProgressIndicator(minHeight: 3);
          }
          if (snapshot.hasError) {
            return EmptyState(
              icon: Icons.cloud_off_rounded,
              title: 'Riwayat belum bisa dimuat',
              subtitle: '${snapshot.error}',
            );
          }
          final payments = snapshot.data?.items ?? const <Payment>[];
          if (payments.isEmpty) {
            return const EmptyState(
              icon: Icons.receipt_long_outlined,
              title: 'Belum ada pembayaran',
              subtitle: 'Checkout course akan muncul di sini.',
            );
          }
          return Column(
            children: [
              for (final payment in payments)
                ListTile(
                  contentPadding: EdgeInsets.zero,
                  title: Text(payment.course?.title ?? 'Course #${payment.courseId}'),
                  subtitle: Text('${payment.status} • ${payment.paymentMethod}'),
                  trailing: Text(
                    rupiah(payment.amount),
                    style: const TextStyle(fontWeight: FontWeight.w800),
                  ),
                ),
            ],
          );
        },
      ),
    );
  }
}

class _CertificatesSheet extends StatelessWidget {
  const _CertificatesSheet({required this.future});

  final Future<List<Course>> future;

  @override
  Widget build(BuildContext context) {
    return _SheetFrame(
      title: 'Sertifikat Saya',
      child: FutureBuilder<List<Course>>(
        future: future,
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return const LinearProgressIndicator(minHeight: 3);
          }
          if (snapshot.hasError) {
            return EmptyState(
              icon: Icons.cloud_off_rounded,
              title: 'Sertifikat belum bisa dimuat',
              subtitle: '${snapshot.error}',
            );
          }
          final certificates = snapshot.data ?? const <Course>[];
          if (certificates.isEmpty) {
            return const EmptyState(
              icon: Icons.workspace_premium_outlined,
              title: 'Belum ada sertifikat',
              subtitle: 'Selesaikan semua materi untuk mendapatkan sertifikat.',
            );
          }
          return Column(
            children: [
              for (final course in certificates)
                ListTile(
                  contentPadding: EdgeInsets.zero,
                  leading: const Icon(Icons.workspace_premium_rounded),
                  title: Text(course.title),
                  subtitle: Text(course.category),
                ),
            ],
          );
        },
      ),
    );
  }
}

class _SheetFrame extends StatelessWidget {
  const _SheetFrame({required this.title, required this.child});

  final String title;
  final Widget child;

  @override
  Widget build(BuildContext context) {
    return DraggableScrollableSheet(
      expand: false,
      initialChildSize: 0.72,
      maxChildSize: 0.92,
      minChildSize: 0.35,
      builder: (context, controller) => ListView(
        controller: controller,
        padding: const EdgeInsets.fromLTRB(20, 18, 20, 28),
        children: [
          Text(
            title,
            style: const TextStyle(fontSize: 22, fontWeight: FontWeight.w900),
          ),
          const SizedBox(height: 14),
          child,
        ],
      ),
    );
  }
}
