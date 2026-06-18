import 'auth_user.dart';
import 'course.dart';
import 'pagination_meta.dart';

class Payment {
  const Payment({
    required this.id,
    required this.courseId,
    required this.paymentMethod,
    required this.amount,
    required this.status,
    this.proofUrl,
    this.rejectionReason,
    this.createdAt,
    this.course,
    this.user,
  });

  final int id;
  final int courseId;
  final String paymentMethod;
  final int amount;
  final String status;
  final String? proofUrl;
  final String? rejectionReason;
  final String? createdAt;
  final Course? course;
  final AuthUser? user;

  bool get isPending => status == 'pending';
  bool get isSuccess => status == 'success';
  bool get isRejected => status == 'rejected';
  bool get hasProof => proofUrl != null && proofUrl!.isNotEmpty;

  String get statusLabel {
    if (isSuccess) return 'Diterima';
    if (isRejected) return 'Ditolak';
    return hasProof ? 'Menunggu review' : 'Menunggu bukti';
  }

  String get actionHint {
    if (isSuccess) return 'Akses course sudah aktif.';
    if (isRejected) {
      return rejectionReason == null || rejectionReason!.isEmpty
          ? 'Pembayaran ditolak. Buat checkout ulang atau hubungi admin.'
          : rejectionReason!;
    }
    if (hasProof) return 'Bukti sudah diupload dan sedang divalidasi admin.';
    return 'Upload bukti pembayaran agar admin bisa memproses pesanan.';
  }

  factory Payment.fromJson(Map<String, dynamic> json) {
    return Payment(
      id: int.tryParse('${json['id'] ?? 0}') ?? 0,
      courseId: int.tryParse('${json['course_id'] ?? 0}') ?? 0,
      paymentMethod: '${json['payment_method'] ?? '-'}',
      amount: int.tryParse('${json['amount'] ?? 0}') ?? 0,
      status: '${json['status'] ?? 'pending'}',
      proofUrl: (json['proof_of_payment_url'] ?? json['proof_url']) as String?,
      rejectionReason: json['rejection_reason'] as String?,
      createdAt: json['created_at'] as String?,
      course: json['course'] is Map<String, dynamic>
          ? Course.fromJson(json['course'] as Map<String, dynamic>)
          : null,
      user: json['user'] is Map<String, dynamic>
          ? AuthUser.fromJson(json['user'] as Map<String, dynamic>)
          : null,
    );
  }
}

class PaymentPage {
  const PaymentPage({required this.items, required this.meta});

  final List<Payment> items;
  final PaginationMeta meta;
}
