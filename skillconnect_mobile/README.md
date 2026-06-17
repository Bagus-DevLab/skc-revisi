# SkillConnect Mobile

Subproject ini adalah client Flutter untuk aplikasi SkillConnect.id. Aplikasi memakai Material UI dan terhubung ke API Laravel di repository root.

## Struktur Penting

```text
lib/main.dart                         Entry point Flutter
lib/src/app/skill_connect_app.dart    MaterialApp dan theme
lib/src/app/skill_connect_shell.dart  Navigasi utama berdasarkan status login dan role
lib/src/config/api_config.dart        Base URL API
lib/src/services/api_client.dart      HTTP client dan error handling API
lib/src/repositories/                 Integrasi API auth dan course
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
- Login dan register via API Laravel.
- Shell navigasi berbeda untuk user biasa dan admin.
- Rekomendasi course via `GET /api/recommendations`.
- Halaman dashboard, course, notes, profile, dan admin payment.

Catatan: sebagian halaman masih memakai data statis/mock, terutama dashboard user, notes, dan admin payment. Integrasi API yang sudah ada berada di `AuthRepository`, `CourseRepository`, dan `ApiClient`.

## Command

```bash
flutter pub get
flutter run
flutter test
```

Backend Laravel perlu berjalan lebih dulu, misalnya dari root repository:

```bash
composer run dev
```
