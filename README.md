![perpus](https://github.com/bailyboy021/Perpus/blob/master/public/images/perpus.png?raw=true)


# Perpus

Repository ini berisi contoh implementasi sistem informasi Perpustakaan sederhana menggunakan framework Laravel 11. Sistem ini menyediakan fitur-fitur dasar untuk mengelola buku, anggota, dan transaksi peminjaman.


## Teknologi yang Digunakan

- **Framework**: Laravel 11 (PHP 8.2)
- **Database**: MySQL
- **ORM**: Eloquent
- **Blade**: AdminLTE 3

## Fitur

- **Manajemen Buku**:
    - Tambah, edit, dan hapus data buku (judul, pengarang, dll.)
- **Manajemen Anggota**:
    - Tambah, edit, dan hapus data anggota
- **Transaksi Peminjaman**:
    - Peminjaman buku oleh anggota
    - Pengembalian buku
    - Pencatatan tanggal peminjaman dan pengembalian

## Instalasi

1.  Clone dari repository:

    ```bash
    git clone https://github.com/bailyboy021/Perpus.git
    ```

2.  Pindah ke project directory:

    ```bash
    cd Perpus
    ```

3.  Install Composer dependencies:

    ```bash
    composer install
    ```

4. Salin file .env.example menjadi .env lalu sesuaikan konfigurasi database dan Securing File Upload:

   ```bash
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=gefami
   DB_USERNAME=root
   DB_PASSWORD=

   ########################
   # Securing File Upload
   ########################
   FILE_WHITELIST='jpg|jpeg|png|svg|gif|webp|pdf|docx|doc|xlsx|xls|csv'
   FILE_BLACKLIST='php|phps|pht|phtm|phtml|pgif|shtml|htaccess|phar|inc|hphp|ctp|module|asp|aspx|config|ashx|asmx|aspq|axd|cshtm|cshtml|rem|soap|vbhtm|vbhtml|asa|cer|shtml|jsp|jspx|jsw|jsv|jspf|wss|action|cfm|cfml|cfc|dbm|swf|pl|cgi|yaws|xap|asax|exe|sh|bat|cmd|xml|txt|mf|bash|tar|tar.z|zip|rar'

5. Migrasi database dan seed data awal:

   ```bash
   php artisan migrate --seed

6. Jalankan server:

   ```bash
   php artisan serve

7. Username & Password (untuk role Admin):

   ```bash
   email : admin@ika.tes
   password : Admin2025

   untuk role User bisa registrasi manual oleh User sendiri atau didaftarkan oleh Admin
