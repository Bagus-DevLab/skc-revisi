import 'package:flutter/material.dart';

import '../models/dashboard_summary.dart';
import '../repositories/dashboard_repository.dart';
import '../services/api_client.dart';
import '../theme/app_colors.dart';
import '../utils/currency_formatter.dart';
import '../widgets/continue_learning_card.dart';
import '../widgets/empty_state.dart';
import '../widgets/metric_card.dart';
import '../widgets/section_header.dart';

class DashboardPage extends StatefulWidget {
  const DashboardPage({
    super.key,
    required this.token,
    required this.onUnauthorized,
  });

  final String token;
  final Future<void> Function() onUnauthorized;

  @override
  State<DashboardPage> createState() => _DashboardPageState();
}

class _DashboardPageState extends State<DashboardPage> {
  final _repository = DashboardRepository();
  late Future<DashboardSummary> _future = _load();

  Future<DashboardSummary> _load() async {
    try {
      return await _repository.fetch(widget.token);
    } on ApiException catch (error) {
      if (error.isUnauthorized) await widget.onUnauthorized();
      rethrow;
    }
  }

  void _refresh() {
    setState(() => _future = _load());
  }

  @override
  Widget build(BuildContext context) {
    return FutureBuilder<DashboardSummary>(
      future: _future,
      builder: (context, snapshot) {
        return RefreshIndicator(
          onRefresh: () async => _refresh(),
          child: ListView(
            padding: const EdgeInsets.fromLTRB(20, 12, 20, 24),
            children: [
              SectionHeader(
                title: 'Dashboard Utama',
                subtitle: 'Ringkasan belajar dan aktivitas terbaru.',
                action: IconButton(
                  tooltip: 'Refresh dashboard',
                  onPressed: _refresh,
                  icon: const Icon(Icons.refresh_rounded),
                ),
              ),
              const SizedBox(height: 14),
              if (snapshot.connectionState == ConnectionState.waiting)
                const LinearProgressIndicator(minHeight: 3),
              if (snapshot.hasError) ...[
                const SizedBox(height: 12),
                EmptyState(
                  icon: Icons.cloud_off_rounded,
                  title: 'Dashboard belum bisa dimuat',
                  subtitle: '${snapshot.error}',
                ),
              ],
              if (snapshot.hasData)
                _DashboardContent(
                  summary: snapshot.data!,
                  token: widget.token,
                  onUnauthorized: widget.onUnauthorized,
                  onChanged: _refresh,
                ),
            ],
          ),
        );
      },
    );
  }
}

class _DashboardContent extends StatelessWidget {
  const _DashboardContent({
    required this.summary,
    required this.token,
    required this.onUnauthorized,
    required this.onChanged,
  });

  final DashboardSummary summary;
  final String token;
  final Future<void> Function() onUnauthorized;
  final VoidCallback onChanged;

  @override
  Widget build(BuildContext context) {
    final lastCourse = summary.lastCourse;

    return Column(
      crossAxisAlignment: CrossAxisAlignment.stretch,
      children: [
        MetricCard(
          icon: Icons.menu_book_rounded,
          title: 'Kursus Aktif',
          value: '${summary.activeCourses}',
          color: AppColors.primary,
        ),
        const SizedBox(height: 10),
        MetricCard(
          icon: Icons.verified_rounded,
          title: 'Sertifikat Selesai',
          value: '${summary.finishedCourses}',
          color: AppColors.success,
        ),
        const SizedBox(height: 10),
        MetricCard(
          icon: Icons.payments_rounded,
          title: 'Total Investasi',
          value: rupiah(summary.totalInvestment),
          color: AppColors.warning,
        ),
        const SizedBox(height: 18),
        if (lastCourse == null)
          const EmptyState(
            icon: Icons.school_outlined,
            title: 'Belum ada kursus aktif',
            subtitle: 'Checkout kursus lalu upload bukti pembayaran.',
          )
        else
          ContinueLearningCard(
            course: lastCourse,
            token: token,
            onUnauthorized: onUnauthorized,
            onChanged: onChanged,
          ),
        if (summary.recentCourses.isNotEmpty) ...[
          const SizedBox(height: 18),
          const SectionHeader(
            title: 'Kursus Terbaru',
            subtitle: 'Aktivitas belajar terakhir.',
          ),
          const SizedBox(height: 12),
          for (final course in summary.recentCourses)
            ListTile(
              contentPadding: EdgeInsets.zero,
              leading: CircleAvatar(
                backgroundColor: const Color(0xFFDBEAFE),
                child: Text(course.progress.toString()),
              ),
              title: Text(
                course.title,
                style: const TextStyle(fontWeight: FontWeight.w800),
              ),
              subtitle: Text('${course.category} • ${course.progress}%'),
            ),
        ],
      ],
    );
  }
}
