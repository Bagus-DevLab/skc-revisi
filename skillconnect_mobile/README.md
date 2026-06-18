# SkillConnect Mobile

Subproject ini adalah client Flutter untuk aplikasi SkillConnect.id. Aplikasi memakai Material UI dan terhubung ke API Laravel di repository root melalui endpoint Sanctum/API JSON.

## Struktur Penting

```text
lib/main.dart                         Entry point Flutter
lib/src/app/skill_connect_app.dart    MaterialApp dan theme
lib/src/app/skill_connect_shell.dart  Navigasi utama berdasarkan status login dan role
lib/src/config/api_config.dart        Base URL API
lib/src/services/api_client.dart      HTTP client dan error handling API
lib/src/controllers/                  Session restore dan state auth
lib/src/repositories/                 Integrasi API per domain
lib/src/pages/                        Halaman beranda, auth, dashboard, course, notes, profil, admin
lib/src/widgets/                      Komponen UI reusable
```

## Konfigurasi API

Default base URL API adalah:

```text
http://127.0.0.1:8000/api
```

Override saat menjalankan Flutter:

```bash
flutter run --dart-define=API_BASE_URL=http://127.0.0.1:8000/api
```

Jika menjalankan di Android emulator dan backend Laravel berjalan di host machine, gunakan:

```bash
flutter run --dart-define=API_BASE_URL=http://10.0.2.2:8000/api
```

## Fitur Saat Ini

- Beranda publik dan daftar course.
- Login, register, restore session Sanctum, dan logout via API Laravel.
- Token disimpan dengan `flutter_secure_storage`.
- Shell navigasi berbeda untuk user biasa dan admin berdasarkan role.
- Rekomendasi course via `GET /api/recommendations`.
- Dashboard user via `GET /api/dashboard-stats`.
- Katalog course digabung dengan `/api/my-courses` untuk status ownership/progress.
- Checkout course, upload bukti pembayaran, riwayat pembayaran, lesson list, dan complete lesson.
- Notes CRUD via `/api/notes`.
- Profile update dan upload avatar.
- Riwayat pembayaran dan daftar sertifikat.
- Admin payment list, approve, dan reject.

Fallback data contoh hanya dipakai di halaman publik saat API belum tersambung.

## Integrasi API

Repository Flutter berada di `lib/src/repositories` dan memetakan fitur aplikasi ke endpoint Laravel:

- `AuthRepository`: login, register, restore session, logout.
- `CourseRepository`: course list, rekomendasi, my courses, my certificates, lessons, complete lesson.
- `DashboardRepository`: ringkasan dashboard user.
- `NoteRepository`: list, create, update, delete note.
- `PaymentRepository`: checkout, upload proof, payment history, admin payment list, approve, reject.
- `ProfileRepository`: update profile dan upload avatar.

`ApiClient` menangani header JSON, bearer token, multipart upload, timeout, decode response, dan pesan error dari field `message` atau `errors`.

## Command

```bash
flutter pub get
flutter run
flutter test
flutter analyze
```

Backend Laravel perlu berjalan lebih dulu, misalnya dari root repository:

```bash
composer run dev
```
