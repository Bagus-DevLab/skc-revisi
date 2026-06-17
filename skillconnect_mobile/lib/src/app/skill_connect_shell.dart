import 'package:flutter/material.dart';

import '../controllers/session_controller.dart';
import '../models/auth_session.dart';
import '../pages/admin_dashboard_page.dart';
import '../pages/admin_payments_page.dart';
import '../pages/courses_page.dart';
import '../pages/dashboard_page.dart';
import '../pages/home_page.dart';
import '../pages/login_page.dart';
import '../pages/notes_page.dart';
import '../pages/profile_page.dart';
import '../pages/register_page.dart';
import '../theme/app_colors.dart';
import '../widgets/brand_text.dart';

class SkillConnectShell extends StatefulWidget {
  const SkillConnectShell({super.key});

  @override
  State<SkillConnectShell> createState() => _SkillConnectShellState();
}

class _SkillConnectShellState extends State<SkillConnectShell> {
  int _index = 0;
  bool _showRegister = false;
  late final SessionController _sessionController;

  AuthSession? get _session => _sessionController.session;

  bool get _isLoggedIn => _session != null;

  @override
  void initState() {
    super.initState();
    _sessionController = SessionController()..addListener(_onSessionChanged);
    _sessionController.restore();
  }

  @override
  void dispose() {
    _sessionController
      ..removeListener(_onSessionChanged)
      ..dispose();
    super.dispose();
  }

  void _onSessionChanged() {
    if (mounted) setState(() {});
  }

  Future<void> _handleLogin(AuthSession session) async {
    await _sessionController.setSession(session);
    setState(() {
      _index = 0;
      _showRegister = false;
    });
  }

  Future<void> _handleLogout() async {
    await _sessionController.logout();
    setState(() {
      _index = 0;
      _showRegister = false;
    });
  }

  Future<void> _handleUnauthorized() async {
    await _sessionController.clear();
    setState(() {
      _index = 0;
      _showRegister = false;
    });
  }

  @override
  Widget build(BuildContext context) {
    if (_sessionController.restoring) {
      return const Scaffold(
        body: SafeArea(
          child: Center(
            child: Column(
              mainAxisSize: MainAxisSize.min,
              children: [
                CircularProgressIndicator(),
                SizedBox(height: 14),
                Text('Memulihkan sesi...'),
              ],
            ),
          ),
        ),
      );
    }

    final navigation = _buildNavigation();
    if (_index >= navigation.pages.length) {
      _index = 0;
    }

    return Scaffold(
      appBar: AppBar(
        title: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const BrandText(),
            Text(
              navigation.titles[_index],
              style: const TextStyle(
                color: AppColors.muted,
                fontSize: 12,
                fontWeight: FontWeight.w600,
              ),
            ),
          ],
        ),
        actions: _isLoggedIn
            ? [
                IconButton(
                  tooltip: 'Notifikasi',
                  onPressed: () {},
                  icon: const Icon(Icons.notifications_none_rounded),
                ),
                Padding(
                  padding: const EdgeInsets.only(right: 16),
                  child: CircleAvatar(
                    radius: 17,
                    backgroundColor: const Color(0xFFDBEAFE),
                    child: Text(
                      _session!.user.name.isNotEmpty
                          ? _session!.user.name[0].toUpperCase()
                          : 'U',
                      style: const TextStyle(
                        color: AppColors.primary,
                        fontWeight: FontWeight.w900,
                      ),
                    ),
                  ),
                ),
              ]
            : [
                TextButton(
                  onPressed: () => setState(() {
                    _index = 1;
                    _showRegister = false;
                  }),
                  child: const Text('Login'),
                ),
                const SizedBox(width: 8),
              ],
      ),
      body: SafeArea(child: navigation.pages[_index]),
      bottomNavigationBar: NavigationBar(
        selectedIndex: _index,
        height: 68,
        backgroundColor: Colors.white,
        indicatorColor: const Color(0xFFDBEAFE),
        onDestinationSelected: (value) => setState(() {
          _index = value;
          if (!_isLoggedIn && value == 0) {
            _showRegister = false;
          }
        }),
        destinations: navigation.destinations,
      ),
    );
  }

  _ShellNavigation _buildNavigation() {
    final session = _session;

    if (session == null) {
      return _ShellNavigation(
        titles: ['Beranda', _showRegister ? 'Register' : 'Login'],
        pages: [
          HomePage(onExplore: () => setState(() => _index = 1)),
          _showRegister
              ? RegisterPage(
                  onRegistered: _handleLogin,
                  onLoginTap: () => setState(() => _showRegister = false),
                )
              : LoginPage(
                  onLogin: _handleLogin,
                  onRegisterTap: () => setState(() => _showRegister = true),
                ),
        ],
        destinations: const [
          NavigationDestination(
            icon: Icon(Icons.home_outlined),
            selectedIcon: Icon(Icons.home_rounded),
            label: 'Beranda',
          ),
          NavigationDestination(
            icon: Icon(Icons.person_outline_rounded),
            selectedIcon: Icon(Icons.person_rounded),
            label: 'Masuk',
          ),
        ],
      );
    }

    if (session.user.isAdmin) {
      return _ShellNavigation(
        titles: const ['Dashboard', 'Kursus', 'Pembayaran', 'Profil'],
        pages: [
          const AdminDashboardPage(),
          const CoursesPage(),
          AdminPaymentsPage(
            token: session.token,
            onUnauthorized: _handleUnauthorized,
          ),
          ProfilePage(
            session: session,
            onLogout: _handleLogout,
            onUnauthorized: _handleUnauthorized,
            onSessionChanged: _sessionController.setSession,
          ),
        ],
        destinations: const [
          NavigationDestination(
            icon: Icon(Icons.dashboard_outlined),
            selectedIcon: Icon(Icons.dashboard_rounded),
            label: 'Dashboard',
          ),
          NavigationDestination(
            icon: Icon(Icons.school_outlined),
            selectedIcon: Icon(Icons.school_rounded),
            label: 'Kursus',
          ),
          NavigationDestination(
            icon: Icon(Icons.receipt_long_outlined),
            selectedIcon: Icon(Icons.receipt_long_rounded),
            label: 'Payment',
          ),
          NavigationDestination(
            icon: Icon(Icons.person_outline_rounded),
            selectedIcon: Icon(Icons.person_rounded),
            label: 'Profil',
          ),
        ],
      );
    }

    return _ShellNavigation(
      titles: const ['Dashboard', 'Kursus', 'Catatan', 'Profil'],
      pages: [
        DashboardPage(
          token: session.token,
          onUnauthorized: _handleUnauthorized,
        ),
        CoursesPage(token: session.token, onUnauthorized: _handleUnauthorized),
        NotesPage(token: session.token, onUnauthorized: _handleUnauthorized),
        ProfilePage(
          session: session,
          onLogout: _handleLogout,
          onUnauthorized: _handleUnauthorized,
          onSessionChanged: _sessionController.setSession,
        ),
      ],
      destinations: const [
        NavigationDestination(
          icon: Icon(Icons.dashboard_outlined),
          selectedIcon: Icon(Icons.dashboard_rounded),
          label: 'Dashboard',
        ),
        NavigationDestination(
          icon: Icon(Icons.school_outlined),
          selectedIcon: Icon(Icons.school_rounded),
          label: 'Kursus',
        ),
        NavigationDestination(
          icon: Icon(Icons.edit_note_outlined),
          selectedIcon: Icon(Icons.edit_note_rounded),
          label: 'Catatan',
        ),
        NavigationDestination(
          icon: Icon(Icons.person_outline_rounded),
          selectedIcon: Icon(Icons.person_rounded),
          label: 'Profil',
        ),
      ],
    );
  }
}

class _ShellNavigation {
  const _ShellNavigation({
    required this.titles,
    required this.pages,
    required this.destinations,
  });

  final List<String> titles;
  final List<Widget> pages;
  final List<NavigationDestination> destinations;
}
