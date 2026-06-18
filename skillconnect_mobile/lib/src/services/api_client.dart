import 'dart:convert';

import 'package:http/http.dart' as http;

import '../config/api_config.dart';

class ApiException implements Exception {
  const ApiException(this.message, [this.statusCode]);

  final String message;
  final int? statusCode;

  bool get isUnauthorized => statusCode == 401;

  @override
  String toString() => message;
}

class ApiClient {
  ApiClient({http.Client? httpClient})
    : _httpClient = httpClient ?? http.Client();

  final http.Client _httpClient;

  Future<dynamic> get(String path, {String? token}) async {
    final response = await _httpClient
        .get(_uri(path), headers: _headers(token))
        .timeout(const Duration(seconds: 15));
    return _decode(response);
  }

  Future<dynamic> post(
    String path, {
    Map<String, dynamic>? body,
    String? token,
  }) async {
    final response = await _httpClient
        .post(
          _uri(path),
          headers: _headers(token),
          body: body == null ? null : jsonEncode(body),
        )
        .timeout(const Duration(seconds: 15));
    return _decode(response);
  }

  Future<dynamic> put(
    String path, {
    Map<String, dynamic>? body,
    String? token,
  }) async {
    final response = await _httpClient
        .put(
          _uri(path),
          headers: _headers(token),
          body: body == null ? null : jsonEncode(body),
        )
        .timeout(const Duration(seconds: 15));
    return _decode(response);
  }

  Future<dynamic> delete(String path, {String? token}) async {
    final response = await _httpClient
        .delete(_uri(path), headers: _headers(token))
        .timeout(const Duration(seconds: 15));
    return _decode(response);
  }

  Future<dynamic> multipart(
    String path, {
    required String field,
    required String filePath,
    String? token,
    Map<String, String>? fields,
  }) async {
    final request = http.MultipartRequest('POST', _uri(path));
    request.headers.addAll(_headers(token, json: false));
    request.fields.addAll(fields ?? const {});
    request.files.add(await http.MultipartFile.fromPath(field, filePath));

    final streamed = await request.send().timeout(const Duration(seconds: 30));
    final response = await http.Response.fromStream(streamed);
    return _decode(response);
  }

  Uri _uri(String path) {
    if (path.startsWith('http://') || path.startsWith('https://')) {
      return Uri.parse(path);
    }
    final normalizedPath = path.startsWith('/') ? path : '/$path';
    return Uri.parse('${ApiConfig.baseUrl}$normalizedPath');
  }

  Map<String, String> _headers(String? token, {bool json = true}) {
    return {
      'Accept': 'application/json',
      if (json) 'Content-Type': 'application/json',
      if (token != null && token.isNotEmpty) 'Authorization': 'Bearer $token',
    };
  }

  dynamic _decode(http.Response response) {
    final raw = response.body;
    final decoded = _tryDecode(raw);

    if (response.statusCode < 200 || response.statusCode >= 300) {
      throw ApiException(_messageFrom(decoded), response.statusCode);
    }

    if (decoded is Map<String, dynamic> && decoded['success'] == false) {
      throw ApiException(_messageFrom(decoded), response.statusCode);
    }

    return decoded;
  }

  dynamic _tryDecode(String raw) {
    if (raw.isEmpty) return <String, dynamic>{};
    try {
      return jsonDecode(raw);
    } on FormatException {
      return {'message': 'Server mengembalikan response yang tidak valid.'};
    }
  }

  String _messageFrom(dynamic decoded) {
    if (decoded is Map<String, dynamic>) {
      final message = decoded['message'];
      if (message != null && '$message'.isNotEmpty) return '$message';
      final errors = decoded['errors'];
      if (errors is Map && errors.isNotEmpty) {
        final first = errors.values.first;
        if (first is List && first.isNotEmpty) return '${first.first}';
        return '$first';
      }
    }
    return 'Request gagal';
  }
}
