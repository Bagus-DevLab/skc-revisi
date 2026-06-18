import 'dart:io';

import 'package:http/http.dart' as http;
import 'package:path_provider/path_provider.dart';

import '../models/course.dart';
import '../models/lesson.dart';
import '../services/api_client.dart';

class CourseRepository {
  CourseRepository({ApiClient? apiClient})
    : _apiClient = apiClient ?? ApiClient();

  final ApiClient _apiClient;

  Future<List<Course>> fetchCourses() async {
    final payload = await _apiClient.get('/courses');

    if (payload is! Map<String, dynamic> || payload['data'] is! List) {
      throw const ApiException('Format data course tidak valid');
    }

    return (payload['data'] as List)
        .whereType<Map<String, dynamic>>()
        .map(Course.fromJson)
        .toList();
  }

  Future<List<Course>> fetchMyCourses(String token) async {
    return _courseList(await _apiClient.get('/my-courses', token: token));
  }

  Future<List<Course>> fetchMyCertificates(String token) async {
    return _courseList(await _apiClient.get('/my-certificates', token: token));
  }

  Future<List<Lesson>> fetchLessons(String token, int courseId) async {
    final payload = await _apiClient.get(
      '/courses/$courseId/lessons',
      token: token,
    );
    if (payload is! Map<String, dynamic> || payload['data'] is! List) {
      throw const ApiException('Format materi tidak valid');
    }
    return (payload['data'] as List)
        .whereType<Map<String, dynamic>>()
        .map(Lesson.fromJson)
        .toList();
  }

  Future<void> completeLesson(String token, int lessonId) async {
    await _apiClient.post('/lessons/$lessonId/complete', token: token);
  }

  Future<void> completeCourseProgress(String token, int courseId) async {
    await _apiClient.post('/courses/$courseId/progress', token: token);
  }

  Future<String> downloadCertificate(Course course) async {
    final url = course.certificateUrl;
    if (url == null || url.isEmpty) {
      throw const ApiException('Link sertifikat belum tersedia.');
    }

    final client = http.Client();
    final http.Response response;

    try {
      response = await client
          .get(Uri.parse(url), headers: {'Accept': 'application/pdf'})
          .timeout(const Duration(seconds: 30));
    } finally {
      client.close();
    }

    if (response.statusCode < 200 || response.statusCode >= 300) {
      throw ApiException(
        'Sertifikat belum bisa didownload.',
        response.statusCode,
      );
    }

    final directory = await getApplicationDocumentsDirectory();
    final fileName = _certificateFileName(course.title);
    final file = File('${directory.path}/$fileName');
    await file.writeAsBytes(response.bodyBytes, flush: true);

    return file.path;
  }

  Future<List<Course>> fetchRecommendations({
    String? category,
    int prefPrice = 1,
    int prefRating = 1,
  }) async {
    final params = <String, String>{
      if (category != null && category.isNotEmpty) 'category': category,
      'pref_price': '$prefPrice',
      'pref_rating': '$prefRating',
    };
    final query = Uri(queryParameters: params).query;
    final payload = await _apiClient.get('/recommendations?$query');

    if (payload is! Map<String, dynamic> || payload['data'] is! List) {
      throw const ApiException('Format data rekomendasi tidak valid');
    }

    return (payload['data'] as List)
        .whereType<Map<String, dynamic>>()
        .map(Course.fromJson)
        .toList();
  }

  List<Course> _courseList(dynamic payload) {
    if (payload is! Map<String, dynamic> || payload['data'] is! List) {
      throw const ApiException('Format data course tidak valid');
    }
    return (payload['data'] as List)
        .whereType<Map<String, dynamic>>()
        .map(Course.fromJson)
        .toList();
  }

  String _certificateFileName(String title) {
    final safeTitle = title
        .replaceAll(RegExp(r'[^A-Za-z0-9 _-]'), '')
        .trim()
        .replaceAll(RegExp(r'\s+'), '-');

    return 'Sertifikat-${safeTitle.isEmpty ? 'Course' : safeTitle}.pdf';
  }
}
