import 'package:flutter/material.dart';

class Course {
  const Course({
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
  });

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
}
