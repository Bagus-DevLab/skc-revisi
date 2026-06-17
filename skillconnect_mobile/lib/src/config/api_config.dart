class ApiConfig {
  const ApiConfig._();

  static const baseUrl = String.fromEnvironment(
    'API_BASE_URL',
    defaultValue: 'https://skillconnect.my.id/api',
  );
}
