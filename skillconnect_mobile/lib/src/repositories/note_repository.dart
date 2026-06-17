import '../models/note.dart';
import '../services/api_client.dart';

class NoteRepository {
  NoteRepository({ApiClient? apiClient}) : _apiClient = apiClient ?? ApiClient();

  final ApiClient _apiClient;

  Future<List<Note>> fetchNotes(String token) async {
    final payload = await _apiClient.get('/notes', token: token);
    if (payload is! Map<String, dynamic> || payload['data'] is! List) {
      throw const ApiException('Format catatan tidak valid');
    }
    return (payload['data'] as List)
        .whereType<Map<String, dynamic>>()
        .map(Note.fromJson)
        .toList();
  }

  Future<Note> create(String token, String content) async {
    final payload = await _apiClient.post(
      '/notes',
      token: token,
      body: {'content': content},
    );
    return _noteFromPayload(payload);
  }

  Future<Note> update(String token, int id, String content) async {
    final payload = await _apiClient.put(
      '/notes/$id',
      token: token,
      body: {'content': content},
    );
    return _noteFromPayload(payload);
  }

  Future<void> delete(String token, int id) async {
    await _apiClient.delete('/notes/$id', token: token);
  }

  Note _noteFromPayload(dynamic payload) {
    if (payload is! Map<String, dynamic> ||
        payload['data'] is! Map<String, dynamic>) {
      throw const ApiException('Format catatan tidak valid');
    }
    return Note.fromJson(payload['data'] as Map<String, dynamic>);
  }
}
