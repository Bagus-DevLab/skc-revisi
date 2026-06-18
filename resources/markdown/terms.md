# Terms of Service

Tanggal berlaku: 18 Juni 2026

Dokumen ini menjelaskan ketentuan umum penggunaan SkillConnect.id, aplikasi kursus online yang menyediakan katalog kursus, rekomendasi kursus, pembelian kursus, akses materi belajar, catatan belajar, progress kursus, dan sertifikat penyelesaian.

## Akun Pengguna

Pengguna bertanggung jawab menjaga keamanan email, password, token akses, dan aktivitas yang terjadi melalui akun masing-masing. Informasi akun harus diberikan secara benar saat registrasi atau pembaruan profil.

Administrator dapat mengelola data pengguna, kursus, dan pembayaran untuk kebutuhan operasional platform.

## Kursus dan Akses Belajar

Akses ke kursus berbayar diberikan setelah pembayaran disetujui oleh admin. Kursus yang sudah aktif akan muncul di dashboard dan halaman kursus pengguna.

Progress belajar dihitung berdasarkan aktivitas penyelesaian materi. Sertifikat tersedia untuk kursus yang sudah mencapai status selesai.

## Pembayaran

Pengguna perlu membuat checkout, memilih metode pembayaran, dan mengunggah bukti pembayaran. Status pembayaran dapat berupa `pending`, `success`, atau `rejected`.

Admin berhak menyetujui atau menolak pembayaran. Jika pembayaran ditolak, admin dapat menambahkan alasan penolakan agar pengguna dapat menindaklanjuti.

## Konten dan Catatan

Pengguna dapat membuat catatan belajar pribadi. Catatan tersebut hanya dapat diakses oleh pemilik akun melalui web atau API yang terautentikasi.

Pengguna tidak boleh mengunggah konten yang melanggar hukum, mengandung data rahasia pihak lain, atau mengganggu keamanan dan ketersediaan layanan.

## Penggunaan API dan Mobile Client

API SkillConnect.id menggunakan autentikasi token Sanctum untuk endpoint yang membutuhkan login. Token API harus dijaga sebagai kredensial rahasia dan tidak boleh dibagikan.

Client Flutter resmi di repository ini menggunakan API yang sama untuk login, dashboard, kursus, pembayaran, catatan, profil, dan fitur admin sesuai role pengguna.

## Perubahan Layanan

Fitur, harga kursus, materi, dan kebijakan operasional dapat berubah mengikuti kebutuhan platform. Perubahan penting sebaiknya dikomunikasikan melalui aplikasi atau kanal resmi yang tersedia.

## Catatan

Dokumen ini adalah draft operasional project dan perlu ditinjau ulang sebelum digunakan sebagai dokumen hukum final di production publik.
