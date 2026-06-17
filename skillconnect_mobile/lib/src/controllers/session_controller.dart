import 'dart:convert';

import 'package:flutter/foundation.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';

import '../models/auth_session.dart';
import '../models/auth_user.dart';
import '../repositories/auth_repository.dart';

class SessionController extends ChangeNotifier {
  SessionController({
    AuthRepository? authRepository,
    FlutterSecureStorage? storage,
  }) : _authRepository = authRepository ?? AuthRepository(),
       _storage = storage ?? const FlutterSecureStorage();

  static const _tokenKey = 'skillconnect.token';
  static const _userKey = 'skillconnect.user';

  final AuthRepository _authRepository;
  final FlutterSecureStorage _storage;

  AuthSession? _session;
  bool _restoring = true;

  AuthSession? get session => _session;
  bool get restoring => _restoring;
  bool get isLoggedIn => _session != null;

  Future<void> restore() async {
    _restoring = true;
    notifyListeners();

    try {
      final token = await _storage.read(key: _tokenKey);
      if (token == null || token.isEmpty) {
        _session = null;
        return;
      }

      final user = await _authRepository.currentUser(token);
      _session = AuthSession(token: token, user: user);
      await _persist(_session!);
    } catch (_) {
      await clear();
    } finally {
      _restoring = false;
      notifyListeners();
    }
  }

  Future<void> setSession(AuthSession session) async {
    _session = session;
    await _persist(session);
    notifyListeners();
  }

  Future<void> refreshUser() async {
    final current = _session;
    if (current == null) return;

    final user = await _authRepository.currentUser(current.token);
    _session = AuthSession(token: current.token, user: user);
    await _persist(_session!);
    notifyListeners();
  }

  Future<void> logout() async {
    final current = _session;
    if (current != null) {
      try {
        await _authRepository.logout(current.token);
      } catch (_) {
        // Local logout must still happen if the network is unavailable.
      }
    }
    await clear();
  }

  Future<void> clear() async {
    _session = null;
    await _storage.delete(key: _tokenKey);
    await _storage.delete(key: _userKey);
    notifyListeners();
  }

  Future<void> _persist(AuthSession session) async {
    await _storage.write(key: _tokenKey, value: session.token);
    await _storage.write(key: _userKey, value: jsonEncode(session.user.toJson()));
  }

  Future<AuthUser?> cachedUser() async {
    final raw = await _storage.read(key: _userKey);
    if (raw == null) return null;
    final decoded = jsonDecode(raw);
    if (decoded is! Map<String, dynamic>) return null;
    return AuthUser.fromJson(decoded);
  }
}
