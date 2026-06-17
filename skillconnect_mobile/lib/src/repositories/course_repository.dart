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
}
