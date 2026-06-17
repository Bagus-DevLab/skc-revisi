import 'course.dart';

class DashboardSummary {
  const DashboardSummary({
    required this.activeCourses,
    required this.finishedCourses,
    required this.totalInvestment,
    required this.recentCourses,
    this.lastCourse,
  });

  final int activeCourses;
  final int finishedCourses;
  final int totalInvestment;
  final List<Course> recentCourses;
  final Course? lastCourse;

  factory DashboardSummary.fromJson(Map<String, dynamic> json) {
    final stats = json['stats'] is Map<String, dynamic>
        ? json['stats'] as Map<String, dynamic>
        : const <String, dynamic>{};
    final recent = json['recent_courses'] is List
        ? json['recent_courses'] as List
        : const [];

    return DashboardSummary(
      activeCourses: int.tryParse('${stats['active_courses'] ?? 0}') ?? 0,
      finishedCourses: int.tryParse('${stats['finished_courses'] ?? 0}') ?? 0,
      totalInvestment:
          int.tryParse('${stats['total_investment'] ?? 0}') ?? 0,
      lastCourse: json['last_course'] is Map<String, dynamic>
          ? Course.fromJson(json['last_course'] as Map<String, dynamic>)
          : null,
      recentCourses: recent
          .whereType<Map<String, dynamic>>()
          .map(Course.fromJson)
          .toList(),
    );
  }
}
