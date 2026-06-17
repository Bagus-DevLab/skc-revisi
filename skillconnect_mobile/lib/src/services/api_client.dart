import 'dart:convert';
import 'dart:io';

import '../config/api_config.dart';

class ApiException implements Exception {
  const ApiException(this.message, [this.statusCode]);

  final String message;
  final int? statusCode;

  @override
  String toString() => message;
}

class ApiClient {
  ApiClient({HttpClient? httpClient})
    : _httpClient = httpClient ?? HttpClient();

  final HttpClient _httpClient;

  Future<dynamic> get(String path, {String? token}) async {
    final request = await _httpClient.getUrl(_uri(path));
    _applyHeaders(request, token);

    final response = await request.close().timeout(const Duration(seconds: 12));
    return _decode(response);
  }

  Future<dynamic> post(
    String path, {
    Map<String, dynamic>? body,
    String? token,
  }) async {
    final request = await _httpClient.postUrl(_uri(path));
    _applyHeaders(request, token);

    if (body != null) {
      request.write(jsonEncode(body));
    }

    final response = await request.close().timeout(const Duration(seconds: 12));
    return _decode(response);
  }

  Uri _uri(String path) {
    final normalizedPath = path.startsWith('/') ? path : '/$path';
    return Uri.parse('${ApiConfig.baseUrl}$normalizedPath');
  }

  void _applyHeaders(HttpClientRequest request, String? token) {
    request.headers.contentType = ContentType.json;
    request.headers.set(HttpHeaders.acceptHeader, ContentType.json.mimeType);

    if (token != null && token.isNotEmpty) {
      request.headers.set(HttpHeaders.authorizationHeader, 'Bearer $token');
    }
  }

  Future<dynamic> _decode(HttpClientResponse response) async {
    final raw = await response.transform(utf8.decoder).join();
    final decoded = raw.isEmpty ? <String, dynamic>{} : jsonDecode(raw);

    if (response.statusCode < 200 || response.statusCode >= 300) {
      final message = decoded is Map<String, dynamic>
          ? '${decoded['message'] ?? 'Request gagal'}'
          : 'Request gagal';
      throw ApiException(message, response.statusCode);
    }

    if (decoded is Map<String, dynamic> && decoded['success'] == false) {
      throw ApiException('${decoded['message'] ?? 'Request gagal'}');
    }

    return decoded;
  }
}
