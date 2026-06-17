import 'package:flutter/material.dart';

import '../models/course.dart';

const courses = <Course>[
  Course(
    title: 'Digital Marketing untuk Pemula',
    category: 'Marketing',
    description:
        'Pelajari funnel, konten, dan iklan berbayar untuk meningkatkan penjualan.',
    price: 350000,
    rating: 4.8,
    students: 1240,
    durationWeeks: 6,
    matchScore: .94,
    owned: true,
    progress: 72,
    colors: [Color(0xFF2563EB), Color(0xFF0F172A)],
  ),
  Course(
    title: 'UI/UX Design dengan Figma',
    category: 'Design',
    description:
        'Bangun portofolio desain produk dari riset sampai prototyping.',
    price: 425000,
    rating: 4.9,
    students: 980,
    durationWeeks: 8,
    matchScore: .89,
    owned: false,
    progress: 0,
    colors: [Color(0xFF7C3AED), Color(0xFF2563EB)],
  ),
  Course(
    title: 'Laravel API untuk Mobile App',
    category: 'Programming',
    description:
        'Membuat REST API Laravel, Sanctum, upload file, dan dashboard data.',
    price: 500000,
    rating: 4.7,
    students: 760,
    durationWeeks: 7,
    matchScore: .86,
    owned: false,
    progress: 0,
    colors: [Color(0xFF0F766E), Color(0xFF0F172A)],
  ),
  Course(
    title: 'Data Analyst Career Starter',
    category: 'Data',
    description:
        'Mulai dari spreadsheet, SQL, visualisasi, sampai presentasi insight.',
    price: 300000,
    rating: 4.6,
    students: 1120,
    durationWeeks: 5,
    matchScore: .81,
    owned: true,
    progress: 100,
    colors: [Color(0xFFF59E0B), Color(0xFF1F2937)],
  ),
];
