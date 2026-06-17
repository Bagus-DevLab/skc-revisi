import '../models/dashboard_summary.dart';
import '../services/api_client.dart';

class DashboardRepository {
  DashboardRepository({ApiClient? apiClient})
    : _apiClient = apiClient ?? ApiClient();

  final ApiClient _apiClient;

  Future<DashboardSummary> fetch(String token) async {
    final payload = await _apiClient.get('/dashboard-stats', token: token);
    if (payload is! Map<String, dynamic> ||
        payload['data'] is! Map<String, dynamic>) {
      throw const ApiException('Format dashboard tidak valid');
    }
    return DashboardSummary.fromJson(payload['data'] as Map<String, dynamic>);
  }
}
