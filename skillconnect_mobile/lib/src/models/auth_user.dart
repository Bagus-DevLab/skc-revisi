class AuthUser {
  const AuthUser({
    required this.id,
    required this.name,
    required this.email,
    required this.role,
  });

  final int id;
  final String name;
  final String email;
  final String role;

  bool get isAdmin => role.toLowerCase() == 'admin';

  String get roleLabel => isAdmin ? 'Admin' : 'User';

  factory AuthUser.fromJson(Map<String, dynamic> json) {
    return AuthUser(
      id: int.tryParse('${json['id'] ?? 0}') ?? 0,
      name: '${json['name'] ?? 'User'}',
      email: '${json['email'] ?? ''}',
      role: '${json['role'] ?? 'user'}',
    );
  }
}
