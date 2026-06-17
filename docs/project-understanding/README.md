# Dokumentasi Pemahaman Project

## Ringkasan Aplikasi

Project ini adalah aplikasi kursus online berbasis Laravel 12. Fitur utamanya meliputi autentikasi user, landing page rekomendasi kursus, pembelian kursus melalui upload bukti pembayaran, approval pembayaran oleh admin, enrollment otomatis setelah pembayaran disetujui, progress belajar, sertifikat PDF, catatan belajar, dan API untuk integrasi aplikasi mobile atau client eksternal. Repository juga berisi subproject Flutter di `skillconnect_mobile/`.

Stack utama:

- Backend: Laravel 12, Jetstream, Fortify, Sanctum, Livewire.
- Frontend: Blade, Vite, Tailwind-related assets.
- Database: migrasi Laravel untuk users, courses, payments, enrollments, lessons, notes, sessions, jobs, cache, dan tokens.
- PDF: `barryvdh/laravel-dompdf` untuk sertifikat.
- Testing: PHPUnit via `php artisan test`.

## Struktur Folder Penting

```text
app/
  Http/Controllers/        Controller web, API, dan admin
  Http/Middleware/         Middleware role admin/user
  Livewire/                Komponen interaktif, misalnya NoteManager
  Models/                  Model Eloquent utama
database/
  migrations/              Skema tabel
  factories/               Data dummy untuk test
  seeders/                 Akun awal dan data kursus
resources/
  views/                   Blade untuk user, admin, auth, kursus, PDF
  js/, css/                Entry point Vite
routes/
  web.php                  Route halaman web
  api.php                  Route API Sanctum
tests/
  Feature/, Unit/          Test fitur dan unit
docker/
  nginx/default.conf       Konfigurasi Nginx produksi/container
skillconnect_mobile/
  lib/                     Source client Flutter
```

## Alur Web Utama

Route web dimulai dari `routes/web.php`. Halaman `/` diarahkan ke `LandingController`, yang mengambil semua kursus, daftar kategori, lalu menghitung rekomendasi kursus menggunakan kombinasi normalisasi SAW dan bobot AHP.

User login diarahkan ke `/dashboard`. `DashboardController` memisahkan admin dan user biasa. Jika role user adalah `admin`, request diarahkan ke dashboard admin. User biasa melihat statistik kursus aktif, selesai, total investasi, dan kursus terakhir.

Alur pembelian:

1. User membuka checkout kursus melalui `/course/{id}/checkout`.
2. `PaymentController@store` membuat record `payments` berstatus `pending`.
3. User upload bukti pembayaran di `/payment/{id}/upload`.
4. Admin membuka daftar pembayaran.
5. Jika admin approve, status payment menjadi `success` dan user didaftarkan ke `enrollments`.
6. Setelah enroll, kursus muncul di dashboard dan halaman `my-courses`.

Approval pembayaran dibuat idempotent: jika user sudah terdaftar pada kursus yang sama, proses approve tidak membuat baris enrollment duplikat.

## Alur Belajar dan Sertifikat

Kursus yang sudah dibeli dapat dibuka melalui `CourseController@learn`. Controller memastikan user sudah terdaftar di pivot `enrollments`.

Progress belajar disimpan pada `enrollments.progress`.

Pada web, route `POST /course/{course}/complete-lesson` menambah progress 10% per submit sampai maksimal 100%. Jika progress mencapai 100%, status enrollment berubah dari `active` menjadi `finished`.

Pada API, progress lebih detail:

- `GET /api/courses/{id}/lessons` mengembalikan lesson beserta `is_completed` berdasarkan `enrollments.completed_lessons`.
- `POST /api/lessons/{id}/complete` menandai lesson tertentu selesai, menyimpan ID lesson ke `completed_lessons`, lalu menghitung progress dari jumlah lesson selesai dibanding total lesson course.
- `POST /api/courses/{id}/progress` menyelesaikan lesson berikutnya yang belum selesai. Jika course tidak memiliki lesson berikutnya, endpoint fallback menambah progress 10%.

Jika progress mencapai 100%, status enrollment berubah dari `active` menjadi `finished`.

Sertifikat hanya bisa diunduh untuk kursus dengan status pivot `finished`. `downloadCertificate` membuat PDF dari view `resources/views/pdf/certificate.blade.php`.

## Admin Area

Admin area berada di prefix `/admin` dan dilindungi middleware `role:admin`.

Fitur admin:

- Dashboard admin: ringkasan jumlah user dan kursus.
- Course CRUD: tambah, edit, hapus kursus, termasuk upload gambar kursus.
- User CRUD: tambah, edit role, hapus user, dengan proteksi agar admin tidak menghapus dirinya sendiri.
- Payment management: lihat pembayaran, approve, reject, dan isi alasan penolakan.

Middleware `CheckRole` melakukan pengecekan sederhana terhadap `Auth::user()->role`.

Route resource admin untuk courses dan users hanya membuka index, create, store, edit, update, dan destroy. Route show tidak diekspos karena belum ada halaman detail khusus.

Admin payment tersedia di web dan API. Approval payment bersifat idempotent: jika user sudah memiliki enrollment untuk course yang sama, sistem tidak membuat enrollment baru.

## API

API berada di `routes/api.php`. Public endpoint:

- `POST /api/register`
- `POST /api/login`
- `GET /api/courses`
- `GET /api/courses/{id}`
- `GET /api/recommendations`

Endpoint protected menggunakan `auth:sanctum`:

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

Endpoint protected admin menggunakan `auth:sanctum` dan `role:admin`:

- `GET /api/admin/payments`
- `POST /api/admin/payments/{id}/approve`
- `POST /api/admin/payments/{id}/reject`

API auth memakai Sanctum token. Login dan register mengembalikan `access_token` dengan tipe `Bearer`.

Response API memakai format umum `success`, `message`, dan `data`. Response paginated memakai field tambahan `meta` untuk `current_page`, `last_page`, `per_page`, dan `total`.

`GET /api/dashboard-stats` mengembalikan jumlah kursus aktif/selesai, total investasi dari payment berstatus `success`, kursus terakhir, dan daftar kursus terbaru. Gambar kursus memakai field `courses.image`.

`apiResource /api/notes` mendukung list, create, show, update, dan delete. Semua operasi detail mengecek kepemilikan note agar user tidak bisa membaca atau mengubah catatan milik user lain.

## Model dan Relasi Data

Model utama:

- `User`: memiliki banyak `Course` melalui tabel pivot `enrollments`, memiliki banyak `Note`, dan memiliki banyak `Payment`.
- `Course`: memiliki banyak `Lesson`, dan banyak user melalui `enrollments`.
- `Enrollment`: pivot user-course dengan field `progress`, `status`, `last_accessed_at`, dan `completed_lessons`.
- `Payment`: milik user dan course, menyimpan metode, nominal, status, bukti pembayaran, dan alasan penolakan.
- `Lesson`: milik course.
- `Note`: catatan milik user.

Skema penting:

- `courses.difficulty_level` adalah enum angka `1` sampai `5`.
- `payments.status` memakai nilai seperti `pending`, `success`, dan `rejected`.
- `enrollments.status` memakai nilai seperti `active` dan `finished`.
- `enrollments.completed_lessons` dicast sebagai array dan menyimpan ID lesson yang sudah diselesaikan via API.

## Catatan Belajar

Catatan web dikelola oleh Livewire component `NoteManager`. Komponen ini melakukan CRUD catatan milik user login dan mencegah user mengedit atau menghapus catatan user lain.

API notes menyediakan create, list, dan delete melalui `NoteController`. Endpoint ini juga mengecek kepemilikan saat delete.
API notes juga menyediakan show dan update untuk melengkapi kontrak `Route::apiResource`.

## Rekomendasi Kursus

Rekomendasi kursus menggunakan bobot AHP hardcoded di landing page:

- Price: `0.515`, semakin murah semakin baik.
- Rating: `0.222`, semakin tinggi semakin baik.
- Students: `0.129`, semakin banyak semakin baik.
- Duration: `0.074`, semakin besar semakin baik.
- Difficulty: `0.039`, semakin rendah semakin baik.

Landing page menghitung skor semua kursus. Endpoint `/recommendations` dapat memfilter kategori dan menyesuaikan bobot sederhana berdasarkan preferensi user.

Endpoint API `GET /api/recommendations` memakai parameter opsional `category`, `pref_price`, dan `pref_rating`. API recommendation saat ini hanya menghitung komponen price dan rating dengan bobot `0.515` dan `0.222`, lalu mengembalikan `match_score`.

## Client Flutter

Subproject `skillconnect_mobile/` adalah aplikasi Flutter untuk SkillConnect.id. Entry point berada di `lib/main.dart`, shell aplikasi berada di `lib/src/app/skill_connect_shell.dart`, dan base URL API diatur melalui compile-time environment `API_BASE_URL` dengan default `http://127.0.0.1:8000/api`.

Client mobile saat ini memiliki halaman beranda, login, register, dashboard, kursus, catatan, profil, dan halaman admin payment. Repository auth dan course sudah memanggil API Laravel untuk login, register, daftar course, dan rekomendasi. Beberapa halaman seperti dashboard, notes, dan admin payment masih memakai data statis/mock pada source Flutter.

## Setup Lokal

Setup dasar:

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run build
```

Seeder default membuat akun admin, akun user contoh, dan kursus awal dari `CourseSeeder`. Seeder memakai `updateOrCreate` agar aman dijalankan ulang untuk data awal yang sama.

Untuk development:

```bash
composer run dev
```

Command tersebut menjalankan Laravel server, queue listener, dan Vite secara bersamaan.

Untuk test:

```bash
composer run test
```

Test memakai konfigurasi `phpunit.xml`, SQLite in-memory, cache array, mail array, queue sync, dan session array.

## Deployment dan Docker

Project memiliki `Dockerfile`, `docker-compose.prod.yml`, `docker/entrypoint.sh`, dan konfigurasi Nginx di `docker/nginx/default.conf`. Struktur ini menunjukkan aplikasi disiapkan untuk deployment container dengan Nginx/PHP dan proses entrypoint custom.

## Hal yang Perlu Diperhatikan

- Pastikan `php artisan storage:link` dijalankan di environment yang butuh akses file upload publik.
- `npm install` melaporkan vulnerability; audit dependency perlu ditangani terpisah agar tidak mengubah versi secara tidak terkontrol.
- Beberapa komentar kode masih campuran Indonesia dan Inggris. Ini tidak memblokir runtime, tetapi sebaiknya dirapikan saat cleanup style.
- `resources/markdown/terms.md` dan `resources/markdown/policy.md` masih placeholder bawaan dan belum berisi konten legal final.
