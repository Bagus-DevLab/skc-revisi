class Note {
  const Note({
    required this.id,
    required this.content,
    this.createdAt,
    this.updatedAt,
  });

  final int id;
  final String content;
  final String? createdAt;
  final String? updatedAt;

  factory Note.fromJson(Map<String, dynamic> json) {
    return Note(
      id: int.tryParse('${json['id'] ?? 0}') ?? 0,
      content: '${json['content'] ?? ''}',
      createdAt: json['created_at'] as String?,
      updatedAt: json['updated_at'] as String?,
    );
  }
}
