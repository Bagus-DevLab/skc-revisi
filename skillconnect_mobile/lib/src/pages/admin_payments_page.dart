import 'package:flutter/material.dart';

import '../models/payment.dart';
import '../repositories/payment_repository.dart';
import '../services/api_client.dart';
import '../theme/app_colors.dart';
import '../utils/currency_formatter.dart';
import '../widgets/empty_state.dart';
import '../widgets/section_header.dart';

class AdminPaymentsPage extends StatefulWidget {
  const AdminPaymentsPage({
    super.key,
    required this.token,
    required this.onUnauthorized,
  });

  final String token;
  final Future<void> Function() onUnauthorized;

  @override
  State<AdminPaymentsPage> createState() => _AdminPaymentsPageState();
}

class _AdminPaymentsPageState extends State<AdminPaymentsPage> {
  final _repository = PaymentRepository();
  late Future<PaymentPage> _future = _load();
  bool _acting = false;
  String? _message;

  Future<PaymentPage> _load() async {
    try {
      return await _repository.adminPayments(widget.token);
    } on ApiException catch (error) {
      if (error.isUnauthorized) await widget.onUnauthorized();
      rethrow;
    }
  }

  void _refresh() {
    setState(() => _future = _load());
  }

  Future<void> _approve(Payment payment) async {
    await _act(() => _repository.approve(widget.token, payment.id));
  }

  Future<void> _reject(Payment payment) async {
    final controller = TextEditingController();
    final reason = await showDialog<String>(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text('Tolak pembayaran'),
        content: TextField(
          controller: controller,
          maxLines: 3,
          decoration: const InputDecoration(labelText: 'Alasan penolakan'),
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.of(context).pop(),
            child: const Text('Batal'),
          ),
          FilledButton(
            onPressed: () => Navigator.of(context).pop(controller.text.trim()),
            child: const Text('Tolak'),
          ),
        ],
      ),
    );
    controller.dispose();
    if (reason == null) return;
    await _act(() => _repository.reject(widget.token, payment.id, reason));
  }

  Future<void> _act(Future<void> Function() action) async {
    if (_acting) return;
    setState(() {
      _acting = true;
      _message = null;
    });
    try {
      await action();
      setState(() => _message = 'Status pembayaran diperbarui.');
      _refresh();
    } on ApiException catch (error) {
      if (error.isUnauthorized) await widget.onUnauthorized();
      setState(() => _message = error.message);
    } finally {
      if (mounted) setState(() => _acting = false);
    }
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
                title: 'Pembayaran',
                subtitle: 'Antrian validasi pembayaran dari peserta.',
                action: IconButton(
                  tooltip: 'Refresh pembayaran',
                  onPressed: _refresh,
                  icon: const Icon(Icons.refresh_rounded),
                ),
              ),
              if (_message != null) ...[
                const SizedBox(height: 10),
                Text(
                  _message!,
                  style: const TextStyle(fontWeight: FontWeight.w700),
                ),
              ],
              const SizedBox(height: 14),
              if (snapshot.connectionState == ConnectionState.waiting)
                const LinearProgressIndicator(minHeight: 3),
              if (snapshot.hasError)
                EmptyState(
                  icon: Icons.cloud_off_rounded,
                  title: 'Payment belum bisa dimuat',
                  subtitle: '${snapshot.error}',
                )
              else if (payments.isEmpty)
                const EmptyState(
                  icon: Icons.receipt_long_outlined,
                  title: 'Belum ada pembayaran',
                  subtitle: 'Pembayaran user akan muncul di sini.',
                )
              else
                for (final payment in payments) ...[
                  _PaymentCard(
                    payment: payment,
                    acting: _acting,
                    onApprove: () => _approve(payment),
                    onReject: () => _reject(payment),
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

class _PaymentCard extends StatelessWidget {
  const _PaymentCard({
    required this.payment,
    required this.acting,
    required this.onApprove,
    required this.onReject,
  });

  final Payment payment;
  final bool acting;
  final VoidCallback onApprove;
  final VoidCallback onReject;

  @override
  Widget build(BuildContext context) {
    final color = payment.isSuccess
        ? AppColors.success
        : payment.isRejected
        ? Colors.red
        : AppColors.warning;
    final canAct = payment.isPending && !acting;

    return Card(
      child: Padding(
        padding: const EdgeInsets.all(14),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Row(
              children: [
                CircleAvatar(
                  backgroundColor: color.withValues(alpha: 0.12),
                  child: Icon(Icons.receipt_long_rounded, color: color),
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
                      Text(
                        '${payment.user?.name ?? 'User'} • ${payment.status}',
                      ),
                    ],
                  ),
                ),
                Text(
                  rupiah(payment.amount),
                  style: const TextStyle(fontWeight: FontWeight.w900),
                ),
              ],
            ),
            if (payment.rejectionReason != null &&
                payment.rejectionReason!.isNotEmpty) ...[
              const SizedBox(height: 10),
              Text('Alasan: ${payment.rejectionReason}'),
            ],
            const SizedBox(height: 12),
            Row(
              children: [
                Expanded(
                  child: OutlinedButton.icon(
                    onPressed: payment.proofUrl == null
                        ? null
                        : () => showDialog<void>(
                            context: context,
                            builder: (context) =>
                                Dialog(child: Image.network(payment.proofUrl!)),
                          ),
                    icon: const Icon(Icons.image_rounded),
                    label: const Text('Bukti'),
                  ),
                ),
                const SizedBox(width: 8),
                Expanded(
                  child: FilledButton.icon(
                    onPressed: canAct ? onApprove : null,
                    icon: const Icon(Icons.check_rounded),
                    label: const Text('Approve'),
                  ),
                ),
                const SizedBox(width: 8),
                Expanded(
                  child: OutlinedButton.icon(
                    onPressed: canAct ? onReject : null,
                    icon: const Icon(Icons.close_rounded),
                    label: const Text('Reject'),
                  ),
                ),
              ],
            ),
          ],
        ),
      ),
    );
  }
}
