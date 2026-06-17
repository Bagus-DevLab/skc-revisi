import 'package:flutter/material.dart';

import '../models/auth_session.dart';
import '../repositories/auth_repository.dart';
import '../services/api_client.dart';
import '../theme/app_colors.dart';
import '../widgets/brand_text.dart';

class LoginPage extends StatefulWidget {
  const LoginPage({
    super.key,
    required this.onLogin,
    required this.onRegisterTap,
  });

  final ValueChanged<AuthSession> onLogin;
  final VoidCallback onRegisterTap;

  @override
  State<LoginPage> createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
  final _emailController = TextEditingController(text: 'siswa@skillconnect.id');
  final _passwordController = TextEditingController(text: 'password123');
  final _repository = AuthRepository();
  bool _loading = false;
  String? _error;

  @override
  void dispose() {
    _emailController.dispose();
    _passwordController.dispose();
    super.dispose();
  }

  Future<void> _submit() async {
    if (_loading) return;

    setState(() {
      _loading = true;
      _error = null;
    });

    try {
      final session = await _repository.login(
        email: _emailController.text.trim(),
        password: _passwordController.text,
      );
      if (!mounted) return;
      widget.onLogin(session);
    } on ApiException catch (error) {
      setState(() => _error = error.message);
    } catch (_) {
      setState(() => _error = 'Tidak bisa terhubung ke Laravel API');
    } finally {
      if (mounted) {
        setState(() => _loading = false);
      }
    }
  }

  void _fillAccount(String email) {
    setState(() {
      _emailController.text = email;
      _passwordController.text = 'password123';
      _error = null;
    });
  }

  @override
  Widget build(BuildContext context) {
    return ListView(
      padding: const EdgeInsets.fromLTRB(20, 18, 20, 24),
      children: [
        const BrandText(),
        const SizedBox(height: 18),
        const Text(
          'Masuk ke SkillConnect',
          style: TextStyle(fontSize: 28, fontWeight: FontWeight.w900),
        ),
        const SizedBox(height: 8),
        const Text(
          'Gunakan akun Laravel yang sudah tersedia untuk membuka navigasi sesuai role.',
          style: TextStyle(
            color: AppColors.muted,
            fontWeight: FontWeight.w600,
            height: 1.45,
          ),
        ),
        const SizedBox(height: 20),
        Wrap(
          spacing: 10,
          runSpacing: 10,
          children: [
            FilledButton.tonalIcon(
              onPressed: () => _fillAccount('siswa@skillconnect.id'),
              icon: const Icon(Icons.person_rounded),
              label: const Text('Akun User'),
            ),
            FilledButton.tonalIcon(
              onPressed: () => _fillAccount('admin@skillconnect.id'),
              icon: const Icon(Icons.admin_panel_settings_rounded),
              label: const Text('Akun Admin'),
            ),
          ],
        ),
        const SizedBox(height: 18),
        TextField(
          controller: _emailController,
          keyboardType: TextInputType.emailAddress,
          textInputAction: TextInputAction.next,
          decoration: const InputDecoration(
            labelText: 'Email',
            prefixIcon: Icon(Icons.email_outlined),
          ),
        ),
        const SizedBox(height: 12),
        TextField(
          controller: _passwordController,
          obscureText: true,
          onSubmitted: (_) => _submit(),
          decoration: const InputDecoration(
            labelText: 'Password',
            prefixIcon: Icon(Icons.lock_outline_rounded),
          ),
        ),
        if (_error != null) ...[
          const SizedBox(height: 12),
          _AuthMessage(message: _error!),
        ],
        const SizedBox(height: 18),
        FilledButton.icon(
          onPressed: _loading ? null : _submit,
          icon: _loading
              ? const SizedBox(
                  width: 18,
                  height: 18,
                  child: CircularProgressIndicator(strokeWidth: 2),
                )
              : const Icon(Icons.login_rounded),
          label: Text(_loading ? 'Memproses...' : 'Masuk'),
        ),
        const SizedBox(height: 12),
        OutlinedButton.icon(
          onPressed: widget.onRegisterTap,
          icon: const Icon(Icons.person_add_alt_1_rounded),
          label: const Text('Buat akun baru'),
        ),
      ],
    );
  }
}

class _AuthMessage extends StatelessWidget {
  const _AuthMessage({required this.message});

  final String message;

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(12),
      decoration: BoxDecoration(
        color: const Color(0xFFFEF2F2),
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: const Color(0xFFFECACA)),
      ),
      child: Row(
        children: [
          const Icon(Icons.error_outline_rounded, color: Color(0xFFB91C1C)),
          const SizedBox(width: 10),
          Expanded(
            child: Text(
              message,
              style: const TextStyle(
                color: Color(0xFFB91C1C),
                fontWeight: FontWeight.w700,
              ),
            ),
          ),
        ],
      ),
    );
  }
}
