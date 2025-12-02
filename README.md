# Aplikasi Kantin

Aplikasi Kantin adalah platform pemesanan berbasis web yang membantu pelanggan memilih menu, memesan makanan/minuman, dan melakukan checkout tanpa harus mengantre. Proyek ini dikembangkan menggunakan Laravel dan PHP Artisan command sebagai fondasi utamanya.

Aplikasi ini dibuat sebagai tugas kelompok untuk memahami pembuatan aplikasi web full-stack, mulai dari backend, tampilan, hingga alur pemesanan.
Proyek ini dibuat sebagai tugas kelompok untuk membangun aplikasi kantin digital.

# 👥  Anggota Kelompok 3

| No | Nama                            | NIM         |
|----|---------------------------------|------------ |
| 1  | Mia Audina Ika Apriliani        | 24111814107 |
| 2  | Egin Sefiano Widodo             | 24111814009 |
| 3  | Gofur Aryan Nur Karim           | 24111814031 |
| 4  | Muhammad Dzikri Azkia Ridwani   | 24111814076 |



# 🎯 Tujuan Proyek

- Membuat aplikasi pemesanan kantin yang sederhana dan mudah digunakan.
- Mempermudah pelanggan melihat daftar menu.
- Mengurangi antrean dengan sistem pemesanan digital.

# 🛠 Teknologi yang Digunakan
Aplikasi dibangun menggunakan:
Laravel (PHP Framework)
PHP Artisan sebagai command-line utama
Composer untuk package management
MySQL / database lain sesuai konfigurasi

# 🍽️ Fitur Utama

✔ Melihat daftar menu makanan & minuman


✔ Menambah pesanan ke keranjang

✔ Mengubah kuantitas pesanan

✔ Checkout pemesanan

✔ Admin mengelola menu (tambah, edit, hapus)

✔ Admin mengelola pesanan masuk

✔ Sistem login untuk admin/user (opsional)


# 🚀 Cara Menjalankan Proyek

1. Clone repository
git clone <url-repo-kalian>

2. Masuk ke folder proyek
cd nama-folder

3. Install dependencies dengan Composer
composer install

4. Copy file environment
cp .env.example .env

5. Generate application key
php artisan key:generate

6. Migrasi database
php artisan migrate

7. Jalankan server
http://127.0.0.1:8000


📌 Catatan

- Pastikan environment sudah diset menggunakan `.env` sebelum menjalankan perintah `php artisan serve`.
- Jika terjadi error saat migrasi database, cek konfigurasi koneksi pada `.env` dan jalankan:



















