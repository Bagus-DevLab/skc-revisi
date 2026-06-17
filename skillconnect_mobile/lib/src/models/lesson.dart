class Lesson {
  const Lesson({
    required this.id,
    required this.courseId,
    required this.title,
    required this.description,
    required this.content,
    required this.order,
    required this.isCompleted,
    this.videoUrl,
  });

  final int id;
  final int courseId;
  final String title;
  final String description;
  final String content;
  final int order;
  final bool isCompleted;
  final String? videoUrl;

  factory Lesson.fromJson(Map<String, dynamic> json) {
    return Lesson(
      id: int.tryParse('${json['id'] ?? 0}') ?? 0,
      courseId: int.tryParse('${json['course_id'] ?? 0}') ?? 0,
      title: '${json['title'] ?? 'Materi'}',
      description: '${json['description'] ?? ''}',
      content: '${json['content'] ?? ''}',
      order: int.tryParse('${json['order'] ?? 0}') ?? 0,
      isCompleted: json['is_completed'] == true,
      videoUrl: json['video_url'] as String?,
    );
  }
}
