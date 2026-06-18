# Privacy Policy

Tanggal berlaku: 18 Juni 2026

Kebijakan ini menjelaskan bagaimana SkillConnect.id mengelola data pengguna pada aplikasi kursus online berbasis web, API, dan client Flutter.

## Data yang Diproses

SkillConnect.id dapat memproses data berikut:

- Data akun, seperti nama, email, password terenkripsi, role, dan avatar.
- Data aktivitas belajar, seperti kursus yang diikuti, progress, status enrollment, materi yang selesai, dan sertifikat.
- Data pembayaran, seperti metode pembayaran, nominal, status, bukti pembayaran, dan alasan penolakan.
- Data catatan belajar yang dibuat pengguna.
- Token akses API untuk autentikasi client.

## Penggunaan Data

Data digunakan untuk:

- Membuat dan mengelola akun pengguna.
- Menampilkan dashboard, katalog kursus, rekomendasi, progress belajar, dan sertifikat.
- Memproses checkout, upload bukti pembayaran, approval, reject, dan riwayat pembayaran.
- Menyediakan catatan belajar pribadi.
- Mengamankan endpoint API dan membatasi akses berdasarkan role pengguna.
- Mendukung operasional admin dan pemeliharaan aplikasi.

## Penyimpanan File

File seperti gambar course, avatar, dan bukti pembayaran disimpan melalui disk `public` Laravel agar bisa diakses aplikasi sesuai kebutuhan fitur. Environment production harus menjalankan `php artisan storage:link` dan mengatur akses storage dengan benar.

## Akses Admin

Admin dapat melihat dan mengelola data kursus, pengguna, dan pembayaran untuk menjalankan operasional platform. Akses admin dilindungi middleware role dan autentikasi.

## API dan Token

Endpoint protected menggunakan Bearer token Sanctum. Pengguna perlu menjaga token dan kredensial akun agar tidak digunakan pihak lain. Logout akan menghapus token aktif atau token pengguna sesuai konteks request.

## Retensi dan Penghapusan

Data disimpan selama dibutuhkan untuk menjalankan layanan, memenuhi kebutuhan operasional, atau menjaga catatan transaksi. Penghapusan akun dapat menghapus data terkait sesuai relasi database dan kebijakan aplikasi.

## Keamanan

Password disimpan dalam bentuk hash. Aplikasi menggunakan validasi request, pembatasan kepemilikan data pada catatan dan pembayaran, serta role admin untuk melindungi fitur sensitif.

## Catatan

Dokumen ini adalah draft operasional project dan perlu ditinjau ulang sebelum digunakan sebagai dokumen hukum final di production publik.
