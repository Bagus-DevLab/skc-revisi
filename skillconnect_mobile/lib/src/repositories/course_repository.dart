import '../models/course.dart';
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
}
