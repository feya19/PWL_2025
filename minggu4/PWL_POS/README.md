# Jawaban Jobsheet-3: Migration

## 1. Pada Praktikum 1 - Tahap 5, apakah fungsi dari APP_KEY pada file setting .env Laravel?
APP_KEY di Laravel berfungsi sebagai kunci enkripsi yang digunakan untuk berbagai kebutuhan keamanan, seperti hashing password dan enkripsi data. Kunci ini penting untuk melindungi data sensitif dalam aplikasi agar tetap aman meskipun database terkena ancaman.

## 2. Pada Praktikum 1, bagaimana kita men-generate nilai untuk APP_KEY?
APP_KEY dapat dibuat dengan menjalankan perintah berikut di terminal:

```bash
php artisan key:generate
```

Perintah ini secara otomatis menghasilkan kunci acak dan menyimpannya di dalam file `.env`.

## 3. Pada Praktikum 2.1 - Tahap 1, secara default Laravel memiliki berapa file migrasi? dan untuk apa saja file migrasi tersebut?
Secara default, Laravel memiliki dua file migrasi:
- `create_users_table.php` untuk tabel `users`
- `create_password_resets_table.php` untuk tabel `password_resets`

File migrasi ini digunakan untuk mendefinisikan struktur tabel yang dibutuhkan dalam aplikasi.

## 4. Secara default, file migrasi terdapat kode `$table->timestamps();`, apa tujuan/output dari fungsi tersebut?
Kode ini secara otomatis menambahkan dua kolom ke tabel: `created_at` dan `updated_at`, yang mencatat kapan sebuah record dibuat dan diperbarui.

## 5. Pada File Migrasi, terdapat fungsi `$table->id();` Tipe data apa yang dihasilkan dari fungsi tersebut?
Fungsi ini menghasilkan kolom dengan tipe data integer yang bersifat auto-increment dan unsigned. Biasanya digunakan sebagai primary key tabel.

## 6. Apa bedanya hasil migrasi pada tabel `m_level`, antara menggunakan `$table->id();` dengan menggunakan `$table->id('level_id');`?
- `$table->id();` akan membuat kolom primary key dengan nama `id`.
- `$table->id('level_id');` akan membuat primary key dengan nama `level_id`, sesuai dengan yang kita tentukan.

## 7. Pada migration, fungsi `->unique()` digunakan untuk apa?
Digunakan untuk memastikan bahwa nilai dalam suatu kolom harus unik, sehingga tidak ada duplikasi data di tabel tersebut.

## 8. Pada Praktikum 2.2 - Tahap 2, kenapa kolom `level_id` pada tabel `m_user` menggunakan `$table->unsignedBigInteger('level_id')`, sedangkan kolom `level_id` pada tabel `m_level` menggunakan `$table->id('level_id')`?
- Pada `m_user`, `level_id` menggunakan `$table->unsignedBigInteger('level_id')` karena bertindak sebagai foreign key yang mengacu ke tabel `m_level`.
- Pada `m_level`, `level_id` menggunakan `$table->id('level_id')` karena berfungsi sebagai primary key.

## 9. Pada Praktikum 3 - Tahap 6, apa tujuan dari Class `Hash`? dan apa maksud dari kode program `Hash::make('1234');`?
Class `Hash` digunakan untuk mengenkripsi password sebelum disimpan ke database. Contoh:

```php
Hash::make('1234');
```

Kode ini akan meng-hash string `1234` menggunakan algoritma yang aman, biasanya bcrypt.

## 10. Pada Praktikum 4 - Tahap 3/5/7, pada query builder terdapat tanda tanya (`?`), apa kegunaan dari tanda tanya (`?`) tersebut?
Tanda `?` digunakan sebagai placeholder dalam query, sehingga parameter yang diberikan akan di-bind dengan aman untuk mencegah SQL Injection.

## 11. Pada Praktikum 6 - Tahap 3, apa tujuan penulisan kode `protected $table = 'm_user';` dan `protected $primaryKey = 'user_id';`?
Kode ini bertujuan untuk menentukan secara eksplisit nama tabel (`m_user`) dan primary key (`user_id`) dalam model Laravel agar sesuai dengan skema database yang digunakan.

## 12. Menurut kalian, lebih mudah menggunakan mana dalam melakukan operasi CRUD ke database (DB Façade / Query Builder / Eloquent ORM)? Jelaskan.
Eloquent ORM biasanya lebih mudah digunakan karena menyediakan abstraksi berbasis objek, sehingga kita bisa berinteraksi dengan database tanpa harus menulis query SQL secara langsung. Namun, jika butuh fleksibilitas lebih, Query Builder atau bahkan DB Facade bisa menjadi pilihan tergantung kebutuhan proyek.

