# Jobsheet-10: RESTFUL API
- **Nama**: Fahmi Yahya
- **NIM**: 2341720089
- **Kelas**: TI-2A

## Praktikum 1 - Membuat RESTful API Register
1. **Instalasi aplikasi postman**
    
    ![alt text](ss/1.1.png)
2. **Instalasi JWT**
    ```
    composer require tymon/jwt-auth:2.1.1
    ```
    
    ![alt text](ss/1.2.png)
3. **Membuat secret konfigurasi**
    ```
    php artisan jwt:secret
    ```
    
    ![alt text](ss/1.3.png)
4. **Publish secret key**
    ```
     php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
    ```
    
    ![alt text](ss/1.4.png)
5. **Memodifikasi `config/auth.php`**
    
    ![alt text](ss/1.5.png)
6. **Menambah kode di `UserModel.php`**
    
    ![alt text](ss/1.6.png)
7. **Membuat controller di `controller/Api/RegisterController`**
    
    ![alt text](ss/1.7.png)
8. **Menambahkan route register di `routes/api.php`**
    
    ![alt text](ss/1.8.png)
9. **Hasil**
    - Data Tidak Valid
        
        ![alt text](ss/1.9.1.png)
    - Data Valid
        
        ![alt text](ss/1.9.2.png)

---

## Praktikum 2 - Membuat RESTful API Login
1. **Membuat controller di `controller/Api/LoginController`**

    ![alt text](ss/2.1.png)
2. **Menambahkan route register di `routes/api.php`**
    
    ![alt text](ss/2.2.png)
3. **Hasil**
    - Data Kosong
        
        ![alt text](ss/2.3.1.png)
    - Sukses
        
        ![alt text](ss/2.3.2.png)
    - Username atau Password Salah
        
        ![alt text](ss/2.3.3.png)

---

## Praktikum 3 - Membuat RESTful API Logout
1. **Membuat controller di `controller/Api/LogoutController`**

    ![alt text](ss/3.1.png)
2. **Menambahkan route register di `routes/api.php`**
    
    ![alt text](ss/3.2.png)
3. **Hasil**
        
    ![alt text](ss/3.3.png)