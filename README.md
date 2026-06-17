# SkillConnect.id

SkillConnect.id adalah aplikasi kursus online berbasis Laravel. Aplikasi ini menyediakan katalog course, rekomendasi course berbasis skor AHP/SAW, checkout dan upload bukti pembayaran, approval pembayaran oleh admin, akses belajar, progress course, sertifikat PDF, catatan belajar, serta API Sanctum untuk integrasi client lain termasuk subproject Flutter di `skillconnect_mobile/`.

## Tech Stack

- Laravel 12, PHP 8.2+
- Laravel Jetstream, Fortify, Sanctum, Livewire
- Blade, Vite
- PHPUnit
- DomPDF untuk sertifikat
- Docker/Nginx config untuk deployment container

## Fitur Utama

- Landing page publik dengan daftar course dan rekomendasi.
- Dashboard user dengan ringkasan course aktif, sertifikat, dan investasi.
- Halaman `Courses` untuk user login yang menampilkan semua course.
- Halaman `My Courses` untuk course yang sudah dibeli/enrolled.
- Checkout course, upload bukti pembayaran, dan riwayat pembayaran.
- Admin dashboard untuk mengelola course, user, dan konfirmasi pembayaran.
- Progress belajar: web menambah progress 10% per submit, sedangkan API mobile melacak `completed_lessons` bila course memiliki lesson.
- Sertifikat PDF untuk course berstatus `finished`.
- Notepad pribadi via Livewire.
- API login/register/logout, course, recommendation, payment, note, profile, dashboard stats, dan admin payment.

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

## Testing dan Formatting

```bash
composer run test
./vendor/bin/pint --test
npm run build
```

Test memakai konfigurasi `phpunit.xml` dengan SQLite in-memory untuk environment testing.

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
skillconnect_mobile/     Client Flutter untuk web/API SkillConnect
```

## Dokumentasi Tambahan

Panduan contributor ada di `AGENTS.md`.

Dokumentasi pemahaman arsitektur dan alur aplikasi ada di:

```text
docs/project-understanding/README.md
```

## Catatan Development

- Jalankan `php artisan storage:link` agar upload gambar course, avatar, dan bukti pembayaran bisa diakses publik.
- Status pembayaran yang dianggap berhasil adalah `success`.
- Status enrollment utama adalah `active` dan `finished`.
- `courses.difficulty_level` memakai nilai `1` sampai `5`.
- `enrollments.completed_lessons` menyimpan daftar ID lesson yang selesai untuk progress dari API.
- Jika port dev default penuh, Laravel/Vite dapat memakai port lain yang tersedia.
- `resources/markdown/terms.md` dan `resources/markdown/policy.md` masih placeholder dan perlu isi final sebelum production.
