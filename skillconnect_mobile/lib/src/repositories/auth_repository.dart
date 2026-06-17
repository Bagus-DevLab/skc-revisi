import '../models/auth_session.dart';
import '../models/auth_user.dart';
import '../services/api_client.dart';

class AuthRepository {
  AuthRepository({ApiClient? apiClient})
    : _apiClient = apiClient ?? ApiClient();

  final ApiClient _apiClient;

  Future<AuthSession> login({
    required String email,
    required String password,
  }) async {
    final payload = await _apiClient.post(
      '/login',
      body: {'email': email, 'password': password},
    );

    return _sessionFromPayload(payload);
  }

  Future<AuthSession> register({
    required String name,
    required String email,
    required String password,
  }) async {
    final payload = await _apiClient.post(
      '/register',
      body: {
        'name': name,
        'email': email,
        'password': password,
        'password_confirmation': password,
      },
    );

    return _sessionFromPayload(payload);
  }

  Future<AuthUser> currentUser(String token) async {
    final payload = await _apiClient.get('/user', token: token);

    if (payload is! Map<String, dynamic> ||
        payload['data'] is! Map<String, dynamic>) {
      throw const ApiException('Data user tidak valid');
    }

    return AuthUser.fromJson(payload['data'] as Map<String, dynamic>);
  }

  Future<void> logout(String token) async {
    await _apiClient.post('/logout', token: token);
  }

  AuthSession _sessionFromPayload(dynamic payload) {
    if (payload is! Map<String, dynamic>) {
      throw const ApiException('Format response auth tidak valid');
    }

    final data = payload['data'];
    if (data is! Map<String, dynamic>) {
      throw const ApiException('Data auth tidak ditemukan');
    }

    final userJson = data['user'];
    if (userJson is! Map<String, dynamic>) {
      throw const ApiException('Data user tidak valid');
    }

    final token = '${data['access_token'] ?? ''}';
    if (token.isEmpty) {
      throw const ApiException('Token login kosong');
    }

    return AuthSession(token: token, user: AuthUser.fromJson(userJson));
  }
}
