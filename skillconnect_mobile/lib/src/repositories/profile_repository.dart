import '../models/auth_user.dart';
import '../services/api_client.dart';

class ProfileRepository {
  ProfileRepository({ApiClient? apiClient})
    : _apiClient = apiClient ?? ApiClient();

  final ApiClient _apiClient;

  Future<AuthUser> updateProfile({
    required String token,
    required String name,
    required String email,
  }) async {
    final payload = await _apiClient.post(
      '/update-profile',
      token: token,
      body: {'name': name, 'email': email},
    );
    return _userFromPayload(payload);
  }

  Future<AuthUser> uploadAvatar({
    required String token,
    required String filePath,
  }) async {
    final payload = await _apiClient.multipart(
      '/user/avatar',
      token: token,
      field: 'avatar',
      filePath: filePath,
    );
    return _userFromPayload(payload);
  }

  AuthUser _userFromPayload(dynamic payload) {
    if (payload is! Map<String, dynamic> ||
        payload['data'] is! Map<String, dynamic>) {
      throw const ApiException('Format profil tidak valid');
    }
    final data = payload['data'] as Map<String, dynamic>;
    if (data['user'] is! Map<String, dynamic>) {
      throw const ApiException('Data user tidak valid');
    }
    return AuthUser.fromJson(data['user'] as Map<String, dynamic>);
  }
}
