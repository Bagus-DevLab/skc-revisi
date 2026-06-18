# SkillConnect.id

SkillConnect.id adalah aplikasi kursus online berbasis Laravel. Aplikasi ini menyediakan katalog course, rekomendasi course berbasis skor AHP/SAW, checkout dan upload bukti pembayaran, approval pembayaran oleh admin, akses belajar, progress course, sertifikat PDF, catatan belajar, serta API Sanctum untuk integrasi client lain termasuk subproject Flutter di `skillconnect_mobile/`.

## Tech Stack

- Laravel 12, PHP 8.2+
- Laravel Jetstream, Fortify, Sanctum, Livewire
- Blade, Vite
- PHPUnit
- DomPDF untuk sertifikat
- Docker/Nginx config untuk deployment container
- Flutter client di `skillconnect_mobile/`
- GitHub Actions untuk build image GHCR dan deploy ke VPS

## Fitur Utama

- Landing page publik dengan daftar course dan rekomendasi.
- Rekomendasi course web memakai normalisasi SAW dengan bobot AHP untuk price, rating, students, duration, dan difficulty.
- Dashboard user dengan ringkasan course aktif, sertifikat, dan investasi.
- Halaman `Courses` untuk user login yang menampilkan semua course.
- Halaman `My Courses` untuk course yang sudah dibeli/enrolled.
- Checkout course, upload bukti pembayaran, dan riwayat pembayaran.
- Admin dashboard untuk mengelola course, user, melihat detail pembayaran, approve pembayaran, dan reject pembayaran dengan alasan.
- Progress belajar: web menambah progress 10% per submit, sedangkan API mobile melacak `completed_lessons` bila course memiliki lesson.
- Sertifikat PDF untuk course berstatus `finished`.
- Notepad pribadi via Livewire.
- API login/register/logout, course, recommendation, payment, note, profile, dashboard stats, dan admin payment.
- Flutter client dengan auth, dashboard, katalog, rekomendasi, checkout, upload bukti bayar, lesson/progress, notes, profile, payment history, sertifikat, dan admin payment.

## Setup Lokal

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm run build
```

Untuk development:

```bash
composer run dev
```

Command ini menjalankan Laravel server, queue listener, dan Vite secara bersamaan.

Alternatif setup otomatis bawaan Laravel tersedia melalui command berikut. Script ini menjalankan install, membuat `.env` bila belum ada, generate key, migrate, install npm, dan build aset. Jalankan `php artisan migrate --seed` serta `php artisan storage:link` terpisah bila butuh data awal dan akses file upload publik.

```bash
composer run setup
```

## Akun Seed

Seeder default membuat akun berikut:

```text
Admin
Email: admin@skillconnect.id
Password: password123

User
Email: siswa@skillconnect.id
Password: password123
```

Seeder juga membuat beberapa course awal melalui `CourseSeeder`.

## Route Penting

- `/` - landing page publik.
- `/dashboard` - dashboard setelah login.
- `/courses` - semua course untuk user login.
- `/my-courses` - course yang sudah dimiliki user.
- `/my-certificates` - sertifikat user.
- `/payment-history` - riwayat pembayaran.
- `/notepad` - catatan pribadi.
- `/admin/dashboard` - dashboard admin.
- `/admin/courses` - kelola course.
- `/admin/users` - kelola user.
- `/admin/payments` - konfirmasi pembayaran.
- `/admin/payments/{id}` - detail pembayaran.

## API Ringkas

Public:

- `POST /api/register`
- `POST /api/login`
- `GET /api/courses`
- `GET /api/courses/{id}`
- `GET /api/recommendations`

Protected dengan Bearer token Sanctum:

- `GET /api/user`
- `POST /api/logout`
- `POST /api/update-profile`
- `POST /api/user/avatar`
- `GET /api/dashboard-stats`
- `GET /api/my-courses`
- `GET /api/my-certificates`
- `GET /api/courses/{id}/lessons`
- `POST /api/courses/{id}/progress`
- `POST /api/lessons/{id}/complete`
- `POST /api/checkout/{id}`
- `POST /api/payment/upload/{id}`
- `GET /api/payment-history`
- `apiResource /api/notes`

Protected admin dengan Bearer token user role `admin`:

- `GET /api/admin/payments`
- `POST /api/admin/payments/{id}/approve`
- `POST /api/admin/payments/{id}/reject`

Response API memakai format umum:

```json
{
  "success": true,
  "message": null,
  "data": {}
}
```

Endpoint paginated menambahkan `meta` berisi `current_page`, `last_page`, `per_page`, dan `total`.

## Client Flutter

Subproject Flutter berada di `skillconnect_mobile/`. Base URL API default adalah:

```text
http://127.0.0.1:8000/api
```

Override saat menjalankan Flutter:

```bash
flutter run --dart-define=API_BASE_URL=http://10.0.2.2:8000/api
```

Gunakan `10.0.2.2` untuk Android emulator ketika backend Laravel berjalan di host machine. Source utama Flutter berada di:

```text
skillconnect_mobile/lib/main.dart
skillconnect_mobile/lib/src/app
skillconnect_mobile/lib/src/config
skillconnect_mobile/lib/src/controllers
skillconnect_mobile/lib/src/models
skillconnect_mobile/lib/src/pages
skillconnect_mobile/lib/src/repositories
skillconnect_mobile/lib/src/services
skillconnect_mobile/lib/src/widgets
```

## Testing dan Formatting

```bash
composer run test
./vendor/bin/pint --test
npm run build
```

Test memakai konfigurasi `phpunit.xml` dengan SQLite in-memory untuk environment testing.

Flutter:

```bash
cd skillconnect_mobile
flutter pub get
flutter analyze
flutter test
```

## Deploy Docker Production

Konfigurasi production memakai container PHP-FPM dan Nginx internal. Default compose hanya bind port HTTP ke localhost:

```text
127.0.0.1:8091 -> skc-web:80
```

Ini cocok untuk server yang sudah memakai Nginx Proxy Manager. Di Nginx Proxy Manager, buat proxy host ke:

```text
Forward Hostname / IP: 127.0.0.1
Forward Port: 8091
```

Jika Nginx Proxy Manager kamu forward ke nama container Docker, jalankan SkillConnect pada network Docker yang sama dengan NPM:

```bash
docker inspect npm-app-1 --format '{{range $name, $_ := .NetworkSettings.Networks}}{{println $name}}{{end}}'
```

Masukkan nama network itu ke `.env`:

```env
NPM_NETWORK=nama_network_npm
```

Lalu jalankan compose dengan override NPM:

```bash
docker compose -f docker-compose.prod.yml -f docker-compose.npm.yml up -d --build
```

Di Nginx Proxy Manager, buat proxy host ke:

```text
Forward Hostname / IP: skc-web
Forward Port: 80
```

Contoh setup di server:

```bash
cp .env.example .env
php artisan key:generate --show
```

Masukkan key ke `.env`, lalu sesuaikan minimal:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domain-api-kamu
APP_HTTP_BIND=127.0.0.1
APP_HTTP_PORT=8091
DB_DATABASE=skillconnect
DB_USERNAME=skillconnect
DB_PASSWORD=password-kuat
FILESYSTEM_DISK=public
QUEUE_CONNECTION=sync
CACHE_STORE=file
SESSION_DRIVER=file
```

Build dan jalankan:

```bash
docker compose -f docker-compose.prod.yml up -d --build
docker compose -f docker-compose.prod.yml exec app php artisan migrate --force --seed
```

Jika ingin migration jalan otomatis saat container start, set:

```env
RUN_MIGRATIONS=true
```

Untuk Flutter mobile, arahkan API ke domain Nginx Proxy Manager:

```bash
flutter run --dart-define=API_BASE_URL=https://domain-api-kamu/api
```

Repository juga memiliki workflow `.github/workflows/deploy.yml` yang berjalan saat push ke branch `main`. Workflow tersebut build dan push image ke GitHub Container Registry, lalu deploy ke VPS via SSH menggunakan secret `VPS_HOST`, `VPS_USERNAME`, `VPS_KEY`, dan `PROD_ENV`. Target directory default di workflow adalah `/var/www/skillconnect`.

## Struktur Project

```text
app/Http/Controllers     Controller web, API, dan admin
app/Livewire             Komponen Livewire
app/Models               Model Eloquent
database/migrations      Skema database
database/seeders         Data awal
resources/views          Blade views
routes/web.php           Route web
routes/api.php           Route API
tests/Feature            Test fitur
docker/                  Konfigurasi container pendukung
.github/workflows        Workflow deploy GitHub Actions
skillconnect_mobile/     Client Flutter untuk web/API SkillConnect
```

## Dokumentasi Tambahan

Panduan contributor ada di `AGENTS.md`. Dokumentasi pemahaman teknis yang lebih rinci ada di `docs/project-understanding/README.md`.

## Catatan Konten

`resources/markdown/terms.md` dan `resources/markdown/policy.md` sudah berisi draft operasional SkillConnect.id. Tinjau ulang sebelum digunakan sebagai dokumen hukum final di production publik.

## Catatan Development

- Jalankan `php artisan storage:link` agar upload gambar course, avatar, dan bukti pembayaran bisa diakses publik.
- Status pembayaran yang dianggap berhasil adalah `success`.
- Status enrollment utama adalah `active` dan `finished`.
- `courses.difficulty_level` memakai nilai `1` sampai `5`.
- `enrollments.completed_lessons` menyimpan daftar ID lesson yang selesai untuk progress dari API.
- Jika port dev default penuh, Laravel/Vite dapat memakai port lain yang tersedia.
- `resources/markdown/terms.md` dan `resources/markdown/policy.md` perlu review final sebelum production publik.
