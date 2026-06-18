import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';

import '../models/payment.dart';
import '../repositories/payment_repository.dart';
import '../services/api_client.dart';
import '../theme/app_colors.dart';
import '../utils/currency_formatter.dart';
import '../widgets/empty_state.dart';
import '../widgets/pill.dart';
import '../widgets/section_header.dart';

class PurchaseStatusPage extends StatefulWidget {
  const PurchaseStatusPage({
    super.key,
    required this.token,
    required this.onUnauthorized,
  });

  final String token;
  final Future<void> Function() onUnauthorized;

  @override
  State<PurchaseStatusPage> createState() => _PurchaseStatusPageState();
}

class _PurchaseStatusPageState extends State<PurchaseStatusPage> {
  final _repository = PaymentRepository();
  final _picker = ImagePicker();
  late Future<PaymentPage> _future = _load();
  bool _uploading = false;
  String? _message;

  Future<PaymentPage> _load() async {
    try {
      return await _repository.history(widget.token);
    } on ApiException catch (error) {
      if (error.isUnauthorized) await widget.onUnauthorized();
      rethrow;
    }
  }

  void _refresh() {
    setState(() => _future = _load());
  }

  Future<void> _uploadProof(Payment payment, ImageSource source) async {
    if (_uploading) return;
    final image = await _picker.pickImage(source: source, imageQuality: 85);
    if (image == null) return;

    setState(() {
      _uploading = true;
      _message = null;
    });

    try {
      await _repository.uploadProof(
        token: widget.token,
        paymentId: payment.id,
        filePath: image.path,
      );
      setState(() => _message = 'Bukti pembayaran berhasil diupload.');
      _refresh();
    } on ApiException catch (error) {
      if (error.isUnauthorized) await widget.onUnauthorized();
      setState(() => _message = error.message);
    } finally {
      if (mounted) setState(() => _uploading = false);
    }
  }

  void _showProof(Payment payment) {
    final proofUrl = payment.proofUrl;
    if (proofUrl == null || proofUrl.isEmpty) return;

    showDialog<void>(
      context: context,
      builder: (context) => Dialog(
        clipBehavior: Clip.antiAlias,
        child: InteractiveViewer(
          child: Image.network(
            proofUrl,
            fit: BoxFit.contain,
            errorBuilder: (context, error, stackTrace) => const Padding(
              padding: EdgeInsets.all(24),
              child: Text('Bukti pembayaran tidak bisa ditampilkan.'),
            ),
          ),
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return FutureBuilder<PaymentPage>(
      future: _future,
      builder: (context, snapshot) {
        final payments = snapshot.data?.items ?? const <Payment>[];

        return RefreshIndicator(
          onRefresh: () async => _refresh(),
          child: ListView(
            padding: const EdgeInsets.fromLTRB(20, 12, 20, 24),
            children: [
              SectionHeader(
                title: 'Keranjang',
                subtitle: 'Pantau checkout, upload bukti, dan status akses.',
                action: IconButton(
                  tooltip: 'Refresh status',
                  onPressed: _refresh,
                  icon: const Icon(Icons.refresh_rounded),
                ),
              ),
              const SizedBox(height: 14),
              if (snapshot.connectionState == ConnectionState.waiting)
                const LinearProgressIndicator(minHeight: 3),
              if (_message != null) ...[
                const SizedBox(height: 12),
                _StatusBanner(message: _message!),
              ],
              if (snapshot.hasError) ...[
                const SizedBox(height: 12),
                EmptyState(
                  icon: Icons.cloud_off_rounded,
                  title: 'Status pembelian belum bisa dimuat',
                  subtitle: '${snapshot.error}',
                ),
              ] else ...[
                if (payments.isNotEmpty) ...[
                  _SummaryRow(payments: payments),
                  const SizedBox(height: 14),
                ],
                if (payments.isEmpty &&
                    snapshot.connectionState != ConnectionState.waiting)
                  const EmptyState(
                    icon: Icons.shopping_cart_outlined,
                    title: 'Keranjang masih kosong',
                    subtitle:
                        'Checkout course dari katalog, lalu statusnya akan muncul di sini.',
                  )
                else
                  for (final payment in payments) ...[
                    _PurchaseCard(
                      payment: payment,
                      uploading: _uploading,
                      onShowProof: () => _showProof(payment),
                      onUploadGallery: () =>
                          _uploadProof(payment, ImageSource.gallery),
                      onUploadCamera: () =>
                          _uploadProof(payment, ImageSource.camera),
                    ),
                    const SizedBox(height: 12),
                  ],
              ],
            ],
          ),
        );
      },
    );
  }
}

class _SummaryRow extends StatelessWidget {
  const _SummaryRow({required this.payments});

  final List<Payment> payments;

  @override
  Widget build(BuildContext context) {
    final pending = payments.where((payment) => payment.isPending).length;
    final success = payments.where((payment) => payment.isSuccess).length;
    final rejected = payments.where((payment) => payment.isRejected).length;

    return Row(
      children: [
        Expanded(
          child: _SummaryTile(
            label: 'Diproses',
            value: pending,
            color: AppColors.warning,
            icon: Icons.schedule_rounded,
          ),
        ),
        const SizedBox(width: 8),
        Expanded(
          child: _SummaryTile(
            label: 'Diterima',
            value: success,
            color: AppColors.success,
            icon: Icons.check_circle_rounded,
          ),
        ),
        const SizedBox(width: 8),
        Expanded(
          child: _SummaryTile(
            label: 'Ditolak',
            value: rejected,
            color: Colors.red,
            icon: Icons.cancel_rounded,
          ),
        ),
      ],
    );
  }
}

class _SummaryTile extends StatelessWidget {
  const _SummaryTile({
    required this.label,
    required this.value,
    required this.color,
    required this.icon,
  });

  final String label;
  final int value;
  final Color color;
  final IconData icon;

  @override
  Widget build(BuildContext context) {
    return Card(
      child: Padding(
        padding: const EdgeInsets.all(12),
        child: Column(
          children: [
            Icon(icon, color: color),
            const SizedBox(height: 6),
            Text(
              '$value',
              style: const TextStyle(fontSize: 18, fontWeight: FontWeight.w900),
            ),
            Text(
              label,
              maxLines: 1,
              overflow: TextOverflow.ellipsis,
              style: const TextStyle(
                color: AppColors.muted,
                fontSize: 11,
                fontWeight: FontWeight.w700,
              ),
            ),
          ],
        ),
      ),
    );
  }
}

class _PurchaseCard extends StatelessWidget {
  const _PurchaseCard({
    required this.payment,
    required this.uploading,
    required this.onShowProof,
    required this.onUploadGallery,
    required this.onUploadCamera,
  });

  final Payment payment;
  final bool uploading;
  final VoidCallback onShowProof;
  final VoidCallback onUploadGallery;
  final VoidCallback onUploadCamera;

  @override
  Widget build(BuildContext context) {
    final color = _statusColor(payment);
    final canUpload = payment.isPending && !uploading;

    return Card(
      child: Padding(
        padding: const EdgeInsets.all(14),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Row(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                CircleAvatar(
                  backgroundColor: color.withValues(alpha: 0.12),
                  child: Icon(_statusIcon(payment), color: color),
                ),
                const SizedBox(width: 12),
                Expanded(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        payment.course?.title ?? 'Course #${payment.courseId}',
                        style: const TextStyle(fontWeight: FontWeight.w900),
                      ),
                      const SizedBox(height: 4),
                      Text(
                        '${payment.paymentMethod} • ${rupiah(payment.amount)}',
                        style: const TextStyle(
                          color: AppColors.muted,
                          fontWeight: FontWeight.w600,
                        ),
                      ),
                    ],
                  ),
                ),
                const SizedBox(width: 8),
                Pill(
                  label: payment.statusLabel,
                  background: color.withValues(alpha: 0.12),
                  foreground: color,
                ),
              ],
            ),
            const SizedBox(height: 12),
            Text(
              payment.actionHint,
              style: const TextStyle(
                color: AppColors.muted,
                height: 1.35,
                fontWeight: FontWeight.w600,
              ),
            ),
            const SizedBox(height: 12),
            if (payment.hasProof)
              OutlinedButton.icon(
                onPressed: onShowProof,
                icon: const Icon(Icons.image_rounded),
                label: const Text('Lihat Bukti'),
              )
            else if (payment.isPending)
              Row(
                children: [
                  Expanded(
                    child: FilledButton.icon(
                      onPressed: canUpload ? onUploadGallery : null,
                      icon: uploading
                          ? const SizedBox(
                              width: 18,
                              height: 18,
                              child: CircularProgressIndicator(strokeWidth: 2),
                            )
                          : const Icon(Icons.photo_library_rounded),
                      label: const Text('Galeri'),
                    ),
                  ),
                  const SizedBox(width: 10),
                  Expanded(
                    child: OutlinedButton.icon(
                      onPressed: canUpload ? onUploadCamera : null,
                      icon: const Icon(Icons.photo_camera_rounded),
                      label: const Text('Kamera'),
                    ),
                  ),
                ],
              ),
          ],
        ),
      ),
    );
  }

  Color _statusColor(Payment payment) {
    if (payment.isSuccess) return AppColors.success;
    if (payment.isRejected) return Colors.red;
    return AppColors.warning;
  }

  IconData _statusIcon(Payment payment) {
    if (payment.isSuccess) return Icons.check_circle_rounded;
    if (payment.isRejected) return Icons.cancel_rounded;
    return payment.hasProof ? Icons.pending_actions_rounded : Icons.upload_file;
  }
}

class _StatusBanner extends StatelessWidget {
  const _StatusBanner({required this.message});

  final String message;

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(12),
      decoration: BoxDecoration(
        color: const Color(0xFFEFF6FF),
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: const Color(0xFFBFDBFE)),
      ),
      child: Text(
        message,
        style: const TextStyle(
          color: AppColors.primary,
          fontWeight: FontWeight.w800,
        ),
      ),
    );
  }
}
