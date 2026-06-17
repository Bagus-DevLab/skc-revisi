import '../models/payment.dart';
import '../models/pagination_meta.dart';
import '../services/api_client.dart';

class PaymentRepository {
  PaymentRepository({ApiClient? apiClient})
    : _apiClient = apiClient ?? ApiClient();

  final ApiClient _apiClient;

  Future<Map<String, dynamic>> checkout({
    required String token,
    required int courseId,
    required String paymentMethod,
  }) async {
    final payload = await _apiClient.post(
      '/checkout/$courseId',
      token: token,
      body: {'payment_method': paymentMethod},
    );
    if (payload is! Map<String, dynamic> ||
        payload['data'] is! Map<String, dynamic>) {
      throw const ApiException('Format checkout tidak valid');
    }
    return payload['data'] as Map<String, dynamic>;
  }

  Future<void> uploadProof({
    required String token,
    required int paymentId,
    required String filePath,
  }) async {
    await _apiClient.multipart(
      '/payment/upload/$paymentId',
      token: token,
      field: 'proof',
      filePath: filePath,
    );
  }

  Future<PaymentPage> history(String token) async {
    final payload = await _apiClient.get('/payment-history', token: token);
    return _pageFromPayload(payload);
  }

  Future<PaymentPage> adminPayments(String token) async {
    final payload = await _apiClient.get('/admin/payments', token: token);
    return _pageFromPayload(payload);
  }

  Future<void> approve(String token, int paymentId) async {
    await _apiClient.post('/admin/payments/$paymentId/approve', token: token);
  }

  Future<void> reject(String token, int paymentId, String reason) async {
    await _apiClient.post(
      '/admin/payments/$paymentId/reject',
      token: token,
      body: {'rejection_reason': reason},
    );
  }

  PaymentPage _pageFromPayload(dynamic payload) {
    if (payload is! Map<String, dynamic> || payload['data'] is! List) {
      throw const ApiException('Format pembayaran tidak valid');
    }
    return PaymentPage(
      items: (payload['data'] as List)
          .whereType<Map<String, dynamic>>()
          .map(Payment.fromJson)
          .toList(),
      meta: PaginationMeta.fromJson(payload['meta'] as Map<String, dynamic>?),
    );
  }
}
