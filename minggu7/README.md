# Jobsheet-7: Authentication dan Authorization di Laravel
- **Nama**: Fahmi Yahya
- **NIM**: 2341720089
- **Kelas**: TI-2A

## Praktikum 1 - Implementasi Authentication
   ![alt text](ss/1.1.png)

---

## Tugas 1 - Implementasi Authentication
   1. **Silahkan implementasikan proses login pada project kalian masing-masing**
   ![alt text](ss/1.2.png)

   2. **Silahkan implementasi proses logout pada halaman web yang kalian buat**
      - Menyesuaikan bagian header untuk menambahkan aksi logout.
      ![alt text](ss/1.4.2.png)

         #### Output:
         ![alt text](ss/1.3.png)

   3. **Amati dan jelaskan tiap tahapan yang kalian kerjakan, dan jabarkan dalam laporan**
      - Sesuai dengan langkah-langkah di jobsheet, yakni:
         1. **Memodifikasi `config/auth.php`**

         2. **Memodifikasi `UserModel.php`**

         3. **Membuat `AuthController.php`**

         4. **Membuat view `login.blade.php`**

         5. **Menambahkan route ke `web.php`**

   4. **Submit kode untuk impementasi Authentication pada repository github kalian.**

---

## Praktikum 2 - Implementasi Authorizaton di Laravel dengan Middleware
   - **Login Menggunakan Admin**
   ![alt text](ss/2.1.png)
   - **Login Menggunakan Manager**
   ![alt text](ss/2.2.png)

---

## Tugas 2 - Implementasi Authorization
   1. **Apa yang kalian pahami pada praktikum 2 ini?**
      - Authorization atau Hak Akses setiap role dapat diatur menggunakan Middleware.
   2. **Amati dan jelaskan tiap tahapan yang kalian kerjakan, dan jabarkan dalam laporan**
      - Sesuai dengan langkah-langkah di jobsheet, yakni:
      1. **Memodifikasi `UserModel.php`**

      2. **Membuat `AuthorizeUser.php`**

      3. **Menambahkan alias middleware di `Kernel.php`**

      4. **Memodifikasi route di `web.php`**
   3. **Submit kode untuk impementasi Authorization pada repository github kalian.**