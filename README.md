## Tentang Praktikum ini

Praktikum ini kedepannya membahas tentang penggunaan teknologi pada Laravel

Teknologi yang digunakan :
- PHP
- Laravel 12
- Composer
- Node.js
- NPM
- Git
- MySQL

## Persyaratan

Sebelum menjalankan project, pastikan sudah menginstall :

- PHP
- Composer
- Node.js
- Git
- MySQL / XAMPP / Laragon

# Pengembangan terbaru

# Sistem Informasi Manajemen Surat (Authentication & Authorization) (05/11/2026) Pertemuan Ke-5

Pengembangan ini merupakan kelanjutan dari Pertemuan Ke-4 yang telah memiliki fitur CRUD Surat Masuk. Pada tahap ini, aplikasi mulai menerapkan sistem autentikasi pengguna dan pembatasan hak akses berdasarkan role.

## Perubahan dan Penambahan

### Database Migration – Penambahan Role

- Menambahkan kolom `role` pada tabel `users` menggunakan migration baru.
- Menggunakan tipe data `string` dengan nilai default `pembaca`.
- Mempertahankan migration users bawaan Laravel agar data sebelumnya tidak hilang.

File yang diubah:
- `database/migrations/` – Migration penambahan kolom role pada users.

Perintah:
```bash
php artisan make:migration add_role_to_users_table --table=users
php artisan migrate
```

### Model User

Memperbarui model `User.php` dengan menambahkan atribut `role` ke dalam `$fillable`.

File:
- `app/Models/User.php`

Perubahan:
- Menambahkan `role` ke dalam daftar mass assignment.
- Mempertahankan atribut `name`, `email`, dan `password`.

### Pembuatan Akun Pengguna

Membuat dua akun untuk kebutuhan pengujian menggunakan Laravel Tinker.

| Role | Hak Akses |
|---|---|
| Petugas | Melihat, menambah, mengedit, dan menghapus surat |
| Pembaca | Hanya melihat daftar dan detail surat |

Perintah:
```bash
php artisan tinker
```
Membuat akun menggunakan `User::updateOrCreate()` dan `Hash::make()` agar password tersimpan dalam bentuk hash.

Akun Petugas
```bash
User::updateOrCreate(['email'=> 'petugas@example.test'],['name'=> 'Petugas SIM-Surat','password'=> Hash::make('PraktikumP5!2026'), 'role' => 'petugas']); 
```
Akun Pembaca
```bash
User::updateOrCreate(['email' => 'pembaca@example.test'], ['name' => 'Pembaca SIM-Surat', 'password' => Hash::make ('PraktikumP5!2026'), 'role' => 'pembaca']); 
```
### Controller Authentication

Menambahkan controller khusus untuk menangani proses login dan logout.

- `app/Http/Controllers/Auth/LoginController.php`

Method yang ditambahkan:

- `showLoginForm()` – Menampilkan halaman login.
- `login()` – Memvalidasi email dan password serta melakukan autentikasi menggunakan `Auth::attempt()`.
- `logout()` – Mengakhiri sesi pengguna menggunakan `Auth::logout()`.

Keamanan session:
- Menggunakan `session()->regenerate()` setelah login.
- Menggunakan `session()->invalidate()` ketika logout.
- Menggunakan `session()->regenerateToken()` untuk memperbarui CSRF token.

### Halaman Login

Menambahkan halaman login menggunakan Blade Template.

- `resources/views/auth/login.blade.php`

Fitur:
- Form input email.
- Form input password.
- Tombol masuk.
- Validasi dan pesan kesalahan menggunakan Blade Directive `@error`.
- Perlindungan CSRF menggunakan `@csrf`.

### Gate Authorization

Menambahkan aturan otorisasi menggunakan Gate pada Laravel.

- `app/Providers/AppServiceProvider.php`

Gate yang dibuat:
```php
Gate::define('manage-letters', function (User $user): bool {
    return $user->role === 'petugas';
});
```

Gate `manage-letters` digunakan untuk membatasi pengelolaan surat sehingga hanya pengguna dengan role `petugas` yang dapat melakukan operasi CRUD.

### Pengamanan Route

Memperbarui konfigurasi route pada:

- `routes/web.php`

Perubahan:
- Menggunakan middleware `guest` untuk halaman login.
- Menggunakan middleware `auth` untuk melindungi dashboard dan halaman surat.
- Menggunakan middleware `can:manage-letters` untuk membatasi operasi pengelolaan surat.
- Mempertahankan route Surat Keluar dari pengembangan sebelumnya.

Pembagian hak akses:

| Fitur | Petugas | Pembaca |
|---|---|---|
| Dashboard | Diizinkan | Diizinkan |
| Daftar Surat Masuk | Diizinkan | Diizinkan |
| Detail Surat Masuk | Diizinkan | Diizinkan |
| Tambah Surat | Diizinkan | 403 Forbidden |
| Edit Surat | Diizinkan | 403 Forbidden |
| Hapus Surat | Diizinkan | 403 Forbidden |

### Penyesuaian Tampilan Blade

Memperbarui tampilan agar menyesuaikan dengan status login dan hak akses pengguna.

File yang disesuaikan:
- `resources/views/layouts/app.blade.php`
- `resources/views/surat-masuk/index.blade.php`

Blade Directive yang digunakan:

- `@auth` – Menampilkan informasi pengguna yang sedang login dan tombol logout.
- `@can('manage-letters')` – Menampilkan tombol tambah, edit, dan hapus hanya untuk petugas.

Tombol Detail tetap dapat diakses oleh semua pengguna yang sudah login.

# Sistem Informasi Manajemen Surat (CRUD & Validasi Surat Masuk) (29/10/2026) Pertemuan Ke-4

Pada pertemuan ke-4, dilakukan pengembangan fitur **CRUD (Create, Read, Update, Delete)** pada Sistem Informasi Manajemen Surat (SIM-Surat), khususnya pada fitur Surat Masuk.

### Perubahan dan Penambahan

1. **Resource Route**
   - Mengubah route Surat Masuk menjadi `Route::resource`.
   - Menambahkan tujuh endpoint untuk kebutuhan CRUD.

2. **Model Eloquent**
   - Menambahkan properti `$fillable` pada model `IncomingLetter`.
   - Mengatur atribut yang dapat diisi melalui mass assignment.

3. **Controller CRUD**
   - Melengkapi `SuratMasukController` dengan method:
     - `index()` – Menampilkan daftar surat.
     - `create()` – Menampilkan form tambah surat.
     - `store()` – Menyimpan data surat.
     - `show()` – Menampilkan detail surat.
     - `edit()` – Menampilkan form edit.
     - `update()` – Memperbarui data surat.
     - `destroy()` – Menghapus data surat.

4. **View / Blade**
   - Menambahkan `create.blade.php` sebagai form tambah surat.
   - Menambahkan `edit.blade.php` sebagai form edit surat.
   - Memperbarui `index.blade.php` dengan tombol tambah, detail, edit, dan hapus.
   - Menyesuaikan `show.blade.php` untuk menampilkan detail data surat.

5. **Validasi Data**
   - Menambahkan validasi menggunakan `$request->validate()`.
   - Menampilkan pesan kesalahan menggunakan `@error`.
   - Mempertahankan input sebelumnya menggunakan `old()`.

6. **Keamanan Form**
   - Menggunakan `@csrf` untuk perlindungan CSRF.
   - Menggunakan `@method('PUT')` untuk proses update.
   - Menggunakan `@method('DELETE')` untuk proses penghapusan.

7. **Notifikasi dan Pengujian**
   - Menambahkan flash message untuk notifikasi berhasil.
   - Menguji proses tambah, tampil, edit, hapus, dan validasi data.

# Sistem Informasi Manajemen Surat (Database,Seeder,Migration & Model) (22/10/2026) Pertemuan Ke-3

## Perubahan Saat Ini
* **Database MySQL: Membuat database `db_sim_surat` sebagai tempat penyimpanan data surat.**
* **Model Surat Masuk: Model `IncomingLetter` yang merepresentasikan tabel surat masuk.**
* **Model Surat Keluar: Model `OutgoingLetter` yang merepresentasikan tabel surat keluar.**
* **Migration: Struktur tabel surat masuk dan surat keluar dibuat melalui `database/migrations`**.
* **Seeder: Data awal (seeding) untuk surat masuk dan surat keluar menggantikan dummy data berbentuk array pada Controller.**

### Database (`.env`)
Membuat database mengggunakan Xampp/ Laragon dengan nama `db_sim_surat` Kemudian Konfigurasi koneksi database diatur pada file `.env` agar Laravel terhubung ke database `db_sim_surat`.

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_sim_surat
DB_USERNAME=root
DB_PASSWORD=
```

### Model (`app/Models/`)

Model adalah representasi tabel database dalam bentuk class PHP (*Eloquent ORM*), sehingga data bisa diakses tanpa menulis query SQL secara manual.

- **`IncomingLetter.php`** : Model untuk data surat masuk (tabel `incoming_letters`).
- **`OutgoingLetter.php`** : Model untuk data surat keluar (tabel `outgoing_letters`).

Cara Membuat Model :

   ```bash
   php artisan make:model IncommingLetter -m
   php artisan make:model OutgoingLetter -m
   ```

### Migration (`database/migrations/`)

Berisi blueprint struktur tabel yang akan dibuat di database.

- **`create_incoming_letters_table.php`** : Membuat tabel surat masuk.
- **`create_outgoing_letters_table.php`** : Membuat tabel surat keluar.

Membuat Migrations :

   ```bash
    php artisan migrate
   ```

### Seeder (`database/seeders/`)

Seeder digunakan untuk mengisi tabel dengan data awal secara otomatis.

- **`IncomingLetterSeeder.php`** : Mengisi data awal surat masuk.
- **`OutgoingLetterSeeder.php`** : Mengisi data awal surat keluar.
- **`DatabaseSeeder.php`** : Memanggil kedua seeder di atas sekaligus lewat satu perintah.

Membuat Seeder:

   ```bash
   php artisan db:seed --class=IncomingLetterSeeder
   php artisan db:seed --class=OutgoingLetterSeeder
   ```

# Sistem Informasi Manajemen Surat (Surat Masuk & Surat Keluar) (15/10/2026) Pertemuan Ke-2

## Fitur & Fitur Utama Saat Ini
* **Dashboard Utama**: Halaman awal aplikasi.
* **Modul Surat Masuk**: Menampilkan daftar surat masuk dan detail surat berdasarkan ID menggunakan simulasi *dummy data*.
* **Modul Surat Keluar**: Menampilkan daftar surat keluar dan detail surat berbasis ID dengan parameter dinamis.
* **Sistem Layouting Global**: Menggunakan satu master layout induk untuk efisiensi kode tampilan UI.

---

## Struktur Komponen dan Alur Kerja (MVC)

MVC adalah singkatan dari **Model-View-Controller**. Ini adalah sebuah pola arsitektur dalam pembuatan website yang bertugas untuk memisahkan kode program berdasarkan fungsi utamanya, sehingga kode menjadi lebih rapi, terstruktur, dan mudah dikembangkan.

### 1. Rute Aplikasi (`routes/web.php`)
Mengatur lalu lintas URL dan memetakan setiap permintaan pengguna ke *Controller* yang sesuai menggunakan *Named Routes*.
* `GET /dashboard` ➔ Menuju ke halaman Dashboard.
* `GET /surat-masuk` ➔ Memanggil `SuratMasukController@index` (Daftar Surat).
* `GET /surat-masuk/{id}` ➔ Memanggil `SuratMasukController@show` (Detail Surat).
* `GET /surat-keluar` ➔ Memanggil `SuratKeluarController@index` (Daftar Surat).
* `GET /surat-keluar/{id}` ➔ Memanggil `SuratKeluarController@show` (Detail Surat).

### 2. Pengendali Logika (`app/Http/Controllers/`)
Tempat pemrosesan data. Pada tahap praktikum ini, Controller menyediakan *array* data tiruan (*dummy data*) yang dikirim ke View menggunakan fungsi `compact()`.
* **`SuratMasukController.php`**: Mengolah data koleksi surat masuk dan pencarian detail berdasarkan parameter `$id`.
* **`SuratKeluarController.php`**: Mengolah data koleksi surat keluar dan visualisasi detail konten surat.

### 3. Tampilan dan Tata Letak Induk (`resources/views/`)
Menggunakan Blade Engine untuk memisahkan struktur utama halaman web dengan konten yang dinamis.
* **`layout/app.blade.php`**: Berperan sebagai kerangka induk global (*Master Layout*). Berisi struktur HTML standar, menu `<nav>` transisi antar-halaman, serta penanda `@yield('content')`.
* **`surat-masuk/` & `surat-keluar/`**: Berisi file `index.blade.php` dan `show.blade.php` yang memperluas kerangka induk menggunakan perintah `@extends('layout.app')` dan menyisipkan konten tabel/detail di dalam blok `@section('content')`.

## Cara Menjalankan Proyek Secara Lokal

1. **Clone repository ini:**
   ```bash
   git clone https://github.com/kansaa-dev/Praktikum-Laravel
   ```
2. **Masuk ke direktori proyek:**
   ```bash
   cd Praktikum-Laravel
   ```
3. **Install dependensi composer:**
   ```bash
   composer install
   ```
4. **Salin file konfigurasi environment:**
   ```bash
   cp .env.example .env
   ```
5. **Generate application key:**
   ```bash
   php artisan key:generate
   ```
6. **Jalankan server lokal:**
   ```bash
   php artisan serve
   ```
7. Buka browser Anda dan akses `http://127.0.0.1:8000`.

## Tentang Pengembangan

Pengembangan praktikum ini akan terus diperbarui sesuai tugas dan pertemuan pada matakuliah.
