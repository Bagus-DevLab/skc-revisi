import 'package:flutter/material.dart';

import '../models/payment.dart';
import '../repositories/payment_repository.dart';
import '../services/api_client.dart';
import '../theme/app_colors.dart';
import '../utils/currency_formatter.dart';
import '../widgets/empty_state.dart';
import '../widgets/pill.dart';
import '../widgets/section_header.dart';

enum _PaymentFilter { all, pending, success, rejected }

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
  _PaymentFilter _filter = _PaymentFilter.pending;
  bool _acting = false;
  String? _message;
  bool _messageIsError = false;

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
    final confirmed = await _confirm(
      title: 'Setujui pembayaran?',
      message:
          'Akses course akan dibuka untuk ${payment.user?.name ?? 'user ini'}.',
      actionLabel: 'Setujui',
    );
    if (!confirmed) return;
    await _act(() => _repository.approve(widget.token, payment.id));
  }

  Future<void> _reject(Payment payment) async {
    final reason = await _askRejectReason(payment);
    if (reason == null) return;
    await _act(() => _repository.reject(widget.token, payment.id, reason));
  }

  Future<bool> _confirm({
    required String title,
    required String message,
    required String actionLabel,
  }) async {
    return await showDialog<bool>(
          context: context,
          builder: (context) => AlertDialog(
            title: Text(title),
            content: Text(message),
            actions: [
              TextButton(
                onPressed: () => Navigator.of(context).pop(false),
                child: const Text('Batal'),
              ),
              FilledButton(
                onPressed: () => Navigator.of(context).pop(true),
                child: Text(actionLabel),
              ),
            ],
          ),
        ) ??
        false;
  }

  Future<String?> _askRejectReason(Payment payment) async {
    final controller = TextEditingController();
    String? validationMessage;

    final reason = await showDialog<String>(
      context: context,
      builder: (context) => StatefulBuilder(
        builder: (context, setDialogState) => AlertDialog(
          title: const Text('Tolak pembayaran'),
          content: Column(
            mainAxisSize: MainAxisSize.min,
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                payment.course?.title ?? 'Course #${payment.courseId}',
                style: const TextStyle(fontWeight: FontWeight.w800),
              ),
              const SizedBox(height: 12),
              TextField(
                controller: controller,
                maxLines: 4,
                textInputAction: TextInputAction.newline,
                decoration: InputDecoration(
                  labelText: 'Alasan penolakan',
                  hintText: 'Contoh: bukti transfer tidak terbaca',
                  alignLabelWithHint: true,
                  errorText: validationMessage,
                  border: const OutlineInputBorder(),
                ),
              ),
            ],
          ),
          actions: [
            TextButton(
              onPressed: () => Navigator.of(context).pop(),
              child: const Text('Batal'),
            ),
            FilledButton.icon(
              onPressed: () {
                final value = controller.text.trim();
                if (value.length < 5) {
                  setDialogState(() {
                    validationMessage = 'Alasan minimal 5 karakter.';
                  });
                  return;
                }
                Navigator.of(context).pop(value);
              },
              icon: const Icon(Icons.close_rounded),
              label: const Text('Tolak'),
            ),
          ],
        ),
      ),
    );
    controller.dispose();
    return reason;
  }

  Future<void> _act(Future<void> Function() action) async {
    if (_acting) return;
    setState(() {
      _acting = true;
      _message = null;
      _messageIsError = false;
    });
    try {
      await action();
      setState(() {
        _message = 'Status pembayaran berhasil diperbarui.';
        _messageIsError = false;
      });
      _refresh();
    } on ApiException catch (error) {
      if (error.isUnauthorized) await widget.onUnauthorized();
      setState(() {
        _message = error.message;
        _messageIsError = true;
      });
    } catch (error) {
      setState(() {
        _message = 'Aksi gagal diproses. Periksa koneksi dan coba lagi.';
        _messageIsError = true;
      });
    } finally {
      if (mounted) setState(() => _acting = false);
    }
  }

  List<Payment> _filtered(List<Payment> payments) {
    return switch (_filter) {
      _PaymentFilter.pending =>
        payments.where((payment) => payment.isPending).toList(),
      _PaymentFilter.success =>
        payments.where((payment) => payment.isSuccess).toList(),
      _PaymentFilter.rejected =>
        payments.where((payment) => payment.isRejected).toList(),
      _PaymentFilter.all => payments,
    };
  }

  @override
  Widget build(BuildContext context) {
    return FutureBuilder<PaymentPage>(
      future: _future,
      builder: (context, snapshot) {
        final payments = snapshot.data?.items ?? const <Payment>[];
        final visiblePayments = _filtered(payments);

        return RefreshIndicator(
          onRefresh: () async => _refresh(),
          child: ListView(
            padding: const EdgeInsets.fromLTRB(20, 12, 20, 24),
            children: [
              SectionHeader(
                title: 'Validasi Pembayaran',
                subtitle: 'Review bukti bayar, setujui akses, atau tolak.',
                action: IconButton(
                  tooltip: 'Refresh pembayaran',
                  onPressed: _refresh,
                  icon: const Icon(Icons.refresh_rounded),
                ),
              ),
              const SizedBox(height: 14),
              if (snapshot.connectionState == ConnectionState.waiting)
                const LinearProgressIndicator(minHeight: 3),
              if (_message != null) ...[
                const SizedBox(height: 12),
                _AdminMessage(message: _message!, isError: _messageIsError),
              ],
              const SizedBox(height: 14),
              if (snapshot.hasError)
                EmptyState(
                  icon: Icons.cloud_off_rounded,
                  title: 'Pembayaran belum bisa dimuat',
                  subtitle: '${snapshot.error}',
                )
              else ...[
                if (payments.isNotEmpty) ...[
                  _AdminSummary(payments: payments),
                  const SizedBox(height: 14),
                  _FilterChips(
                    value: _filter,
                    onChanged: (value) => setState(() => _filter = value),
                  ),
                  const SizedBox(height: 14),
                ],
                if (payments.isEmpty &&
                    snapshot.connectionState != ConnectionState.waiting)
                  const EmptyState(
                    icon: Icons.receipt_long_outlined,
                    title: 'Belum ada pembayaran',
                    subtitle: 'Pembayaran user akan muncul di sini.',
                  )
                else if (visiblePayments.isEmpty)
                  const EmptyState(
                    icon: Icons.filter_alt_off_rounded,
                    title: 'Tidak ada data pada filter ini',
                    subtitle: 'Pilih status lain untuk melihat pembayaran.',
                  )
                else
                  for (final payment in visiblePayments) ...[
                    _PaymentCard(
                      payment: payment,
                      acting: _acting,
                      onApprove: () => _approve(payment),
                      onReject: () => _reject(payment),
                    ),
                    const SizedBox(height: 10),
                  ],
              ],
            ],
          ),
        );
      },
    );
  }
}

class _AdminSummary extends StatelessWidget {
  const _AdminSummary({required this.payments});

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
            label: 'Antrian',
            value: pending,
            color: AppColors.warning,
          ),
        ),
        const SizedBox(width: 8),
        Expanded(
          child: _SummaryTile(
            label: 'Diterima',
            value: success,
            color: AppColors.success,
          ),
        ),
        const SizedBox(width: 8),
        Expanded(
          child: _SummaryTile(
            label: 'Ditolak',
            value: rejected,
            color: Colors.red,
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
  });

  final String label;
  final int value;
  final Color color;

  @override
  Widget build(BuildContext context) {
    return Card(
      child: Padding(
        padding: const EdgeInsets.all(12),
        child: Column(
          children: [
            Text(
              '$value',
              style: TextStyle(
                color: color,
                fontSize: 22,
                fontWeight: FontWeight.w900,
              ),
            ),
            Text(
              label,
              style: const TextStyle(
                color: AppColors.muted,
                fontWeight: FontWeight.w700,
              ),
            ),
          ],
        ),
      ),
    );
  }
}

class _FilterChips extends StatelessWidget {
  const _FilterChips({required this.value, required this.onChanged});

  final _PaymentFilter value;
  final ValueChanged<_PaymentFilter> onChanged;

  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
      scrollDirection: Axis.horizontal,
      child: Row(
        children: [
          _chip('Antrian', _PaymentFilter.pending),
          _chip('Diterima', _PaymentFilter.success),
          _chip('Ditolak', _PaymentFilter.rejected),
          _chip('Semua', _PaymentFilter.all),
        ],
      ),
    );
  }

  Widget _chip(String label, _PaymentFilter filter) {
    return Padding(
      padding: const EdgeInsets.only(right: 8),
      child: ChoiceChip(
        label: Text(label),
        selected: value == filter,
        onSelected: (_) => onChanged(filter),
      ),
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
    final color = _statusColor(payment);
    final canAct = payment.isPending && !acting;

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
                      const SizedBox(height: 4),
                      Text(
                        payment.user?.name ?? 'User tidak diketahui',
                        style: const TextStyle(
                          color: AppColors.muted,
                          fontWeight: FontWeight.w700,
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
            _InfoRow(
              icon: Icons.payments_rounded,
              label: '${payment.paymentMethod} • ${rupiah(payment.amount)}',
            ),
            if (payment.user?.email != null)
              _InfoRow(icon: Icons.email_outlined, label: payment.user!.email),
            if (payment.rejectionReason != null &&
                payment.rejectionReason!.isNotEmpty)
              _InfoRow(
                icon: Icons.info_outline_rounded,
                label: payment.rejectionReason!,
              ),
            const SizedBox(height: 12),
            if (!payment.hasProof)
              const _ProofMissing()
            else
              _ProofPreview(payment: payment),
            const SizedBox(height: 12),
            Row(
              children: [
                Expanded(
                  child: FilledButton.icon(
                    onPressed: canAct ? onApprove : null,
                    icon: acting
                        ? const SizedBox(
                            width: 18,
                            height: 18,
                            child: CircularProgressIndicator(strokeWidth: 2),
                          )
                        : const Icon(Icons.check_rounded),
                    label: const Text('Approve'),
                  ),
                ),
                const SizedBox(width: 10),
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

  Color _statusColor(Payment payment) {
    if (payment.isSuccess) return AppColors.success;
    if (payment.isRejected) return Colors.red;
    return AppColors.warning;
  }
}

class _InfoRow extends StatelessWidget {
  const _InfoRow({required this.icon, required this.label});

  final IconData icon;
  final String label;

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.only(top: 6),
      child: Row(
        children: [
          Icon(icon, size: 16, color: AppColors.muted),
          const SizedBox(width: 8),
          Expanded(
            child: Text(
              label,
              style: const TextStyle(
                color: AppColors.muted,
                fontWeight: FontWeight.w600,
              ),
            ),
          ),
        ],
      ),
    );
  }
}

class _ProofMissing extends StatelessWidget {
  const _ProofMissing();

  @override
  Widget build(BuildContext context) {
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(12),
      decoration: BoxDecoration(
        color: const Color(0xFFFFFBEB),
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: const Color(0xFFFDE68A)),
      ),
      child: const Text(
        'User belum mengupload bukti pembayaran.',
        style: TextStyle(color: Color(0xFF92400E), fontWeight: FontWeight.w800),
      ),
    );
  }
}

class _ProofPreview extends StatelessWidget {
  const _ProofPreview({required this.payment});

  final Payment payment;

  @override
  Widget build(BuildContext context) {
    return InkWell(
      onTap: () => showDialog<void>(
        context: context,
        builder: (context) => Dialog(
          clipBehavior: Clip.antiAlias,
          child: InteractiveViewer(
            child: Image.network(
              payment.proofUrl!,
              fit: BoxFit.contain,
              errorBuilder: (context, error, stackTrace) => const Padding(
                padding: EdgeInsets.all(24),
                child: Text('Bukti pembayaran tidak bisa ditampilkan.'),
              ),
            ),
          ),
        ),
      ),
      borderRadius: BorderRadius.circular(12),
      child: Container(
        height: 150,
        width: double.infinity,
        clipBehavior: Clip.antiAlias,
        decoration: BoxDecoration(
          borderRadius: BorderRadius.circular(12),
          border: Border.all(color: AppColors.border),
        ),
        child: Image.network(
          payment.proofUrl!,
          fit: BoxFit.cover,
          errorBuilder: (context, error, stackTrace) =>
              const Center(child: Text('Bukti tidak bisa dimuat')),
        ),
      ),
    );
  }
}

class _AdminMessage extends StatelessWidget {
  const _AdminMessage({required this.message, required this.isError});

  final String message;
  final bool isError;

  @override
  Widget build(BuildContext context) {
    final color = isError ? Colors.red : AppColors.success;

    return Container(
      padding: const EdgeInsets.all(12),
      decoration: BoxDecoration(
        color: color.withValues(alpha: 0.1),
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: color.withValues(alpha: 0.28)),
      ),
      child: Text(
        message,
        style: TextStyle(color: color, fontWeight: FontWeight.w800),
      ),
    );
  }
}
