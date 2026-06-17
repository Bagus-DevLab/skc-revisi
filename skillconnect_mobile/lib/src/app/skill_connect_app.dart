import 'package:flutter/material.dart';

import '../theme/app_theme.dart';
import 'skill_connect_shell.dart';

class SkillConnectApp extends StatelessWidget {
  const SkillConnectApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'SkillConnect.id',
      debugShowCheckedModeBanner: false,
      theme: AppTheme.light,
      home: const SkillConnectShell(),
    );
  }
}
