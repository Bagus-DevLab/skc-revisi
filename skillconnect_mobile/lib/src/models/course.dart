import 'package:flutter/material.dart';

class Course {
  const Course({
    required this.id,
    required this.title,
    required this.category,
    required this.description,
    required this.price,
    required this.rating,
    required this.students,
    required this.durationWeeks,
    required this.matchScore,
    required this.owned,
    required this.progress,
    required this.colors,
    this.imageUrl,
  });

  final int id;
  final String title;
  final String category;
  final String description;
  final int price;
  final double rating;
  final int students;
  final int durationWeeks;
  final double matchScore;
  final bool owned;
  final int progress;
  final List<Color> colors;
  final String? imageUrl;

  factory Course.fromJson(Map<String, dynamic> json) {
    final enrollment = json['enrollment'] is Map<String, dynamic>
        ? json['enrollment'] as Map<String, dynamic>
        : null;
    final progress = enrollment == null
        ? 0
        : int.tryParse('${enrollment['progress'] ?? 0}') ?? 0;
    final match =
        json['match_score'] ?? json['ai_score'] ?? json['user_match_score'];

    return Course(
      id: int.tryParse('${json['id'] ?? 0}') ?? 0,
      title: '${json['title'] ?? 'Tanpa Judul'}',
      category: '${json['category'] ?? 'General'}',
      description: '${json['description'] ?? ''}',
      price: int.tryParse('${json['price'] ?? 0}') ?? 0,
      rating: double.tryParse('${json['rating'] ?? 0}') ?? 0,
      students: int.tryParse('${json['students_count'] ?? 0}') ?? 0,
      durationWeeks: int.tryParse('${json['duration'] ?? 0}') ?? 0,
      matchScore: double.tryParse('${match ?? 0}') ?? 0,
      owned: enrollment != null,
      progress: progress,
      colors: _colorsForCategory('${json['category'] ?? ''}'),
      imageUrl: json['image_url'] as String?,
    );
  }
}

List<Color> _colorsForCategory(String category) {
  switch (category.toLowerCase()) {
    case 'design':
      return const [Color(0xFF7C3AED), Color(0xFF2563EB)];
    case 'programming':
      return const [Color(0xFF0F766E), Color(0xFF0F172A)];
    case 'data':
      return const [Color(0xFFF59E0B), Color(0xFF1F2937)];
    case 'marketing':
      return const [Color(0xFF2563EB), Color(0xFF0F172A)];
    default:
      return const [Color(0xFF2563EB), Color(0xFF1E293B)];
  }
}
