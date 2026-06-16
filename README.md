# SkillConnect.id

SkillConnect.id adalah aplikasi kursus online berbasis Laravel. Aplikasi ini menyediakan katalog course, rekomendasi course berbasis skor AHP/SAW, checkout dan upload bukti pembayaran, approval pembayaran oleh admin, akses belajar, progress course, sertifikat PDF, catatan belajar, serta API Sanctum untuk integrasi client lain.

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
- Progress belajar: course selesai saat progress mencapai 100%.
- Sertifikat PDF untuk course berstatus `finished`.
- Notepad pribadi via Livewire.
- API login/register, course, payment, note, profile, dashboard stats.

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

Protected dengan Bearer token Sanctum:

- `GET /api/user`
- `GET /api/dashboard-stats`
- `GET /api/my-courses`
- `GET /api/my-certificates`
- `GET /api/courses/{id}/lessons`
- `POST /api/lessons/{id}/complete`
- `POST /api/checkout/{id}`
- `POST /api/payment/upload/{id}`
- `GET /api/payment-history`
- `apiResource /api/notes`

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
- Jika port dev default penuh, Laravel/Vite dapat memakai port lain yang tersedia.
