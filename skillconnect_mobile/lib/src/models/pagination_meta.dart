class PaginationMeta {
  const PaginationMeta({
    required this.currentPage,
    required this.lastPage,
    required this.perPage,
    required this.total,
  });

  final int currentPage;
  final int lastPage;
  final int perPage;
  final int total;

  factory PaginationMeta.fromJson(Map<String, dynamic>? json) {
    final data = json ?? const <String, dynamic>{};
    return PaginationMeta(
      currentPage: int.tryParse('${data['current_page'] ?? 1}') ?? 1,
      lastPage: int.tryParse('${data['last_page'] ?? 1}') ?? 1,
      perPage: int.tryParse('${data['per_page'] ?? 0}') ?? 0,
      total: int.tryParse('${data['total'] ?? 0}') ?? 0,
    );
  }
}
