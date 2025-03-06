# Jobsheet-4: Eloquent ORM

- **Nama**: Fahmi Yahya
- **NIM**: 2341720089
- **Kelas**: TI-2A

### Praktikum 1 - Pemanfaatan $fillable

1. **Menambahkan Properti $fillable dalam Model**
   ```php
   protected $fillable = ['username', 'nama', 'password', 'level_id'];
   ```
2. **Mengubah UserController untuk Menambahkan Data Baru**
   ```php
   $data = [
       'username' => 'customer-1',
       'nama' => 'Pelanggan',
       'password' => Hash::make('12345'),
       'level_id' => 4
   ];
   UserModel::create($data);
   ```
3. **Hasil dari Implementasi $fillable**
   Setelah kode dijalankan, data baru berhasil ditambahkan ke dalam tabel pengguna.
   
4. **Mengubah Properti $fillable dan Menjalankan Kembali**
   ```php
   protected $fillable = ['username', 'nama', 'level_id'];
   ```
5. **Dampak dari Perubahan $fillable**
   Program mengalami error karena kolom `password` tidak disertakan dalam daftar $fillable.

---

### Praktikum 2.1 - Mengambil Data Tunggal

1. **Menggunakan Metode `find` untuk Mengambil Data Berdasarkan ID**
   ```php
   $user = UserModel::find(1);
   ```
2. **Menampilkan Data pada Tampilan Blade**
   ```php
   <p>{{ $user->username }} - {{ $user->nama }}</p>
   ```
3. **Hasil Implementasi `find`**
   Hanya satu data yang ditampilkan berdasarkan ID yang diberikan.
4. **Menerapkan Metode `first` untuk Mengambil Data**
   ```php
   $user = UserModel::where('level_id', 1)->first();
   ```
5. **Menggunakan `firstWhere` untuk Mengambil Data**
   ```php
   $user = UserModel::firstWhere('level_id', 2);
   ```
6. **Penerapan Metode `findOr`**
   ```php
   $user = UserModel::findOr(1, ['username', 'nama'], function () {
       abort(404);
   });
   ```
7. **Hasil Jika Data Tidak Ditemukan dengan `findOr`**
   Jika data yang dicari tidak ditemukan, program akan menghasilkan error 404.

### Praktikum 2.2 - Mengelola Exception Jika Data Tidak Ditemukan

1. **Menerapkan `findOrFail`**
   ```php
   $user = UserModel::findOrFail(1);
   ```
2. **Menggunakan `firstOrFail` untuk Data yang Tidak Ada**
   ```php
   $user = UserModel::where('username', 'manager-9')->firstOrFail();
   ```
3. **Hasil Jika Data Tidak Ditemukan**
   Program akan memunculkan error karena data yang dimaksud tidak tersedia.

### Praktikum 2.3 - Menggunakan Fungsi Agregasi

1. **Menerapkan `count()` untuk Menghitung Jumlah Data**
   ```php
   $user = UserModel::where('level_id', 2)->count();
   dd($user);
   ```
2. **Menampilkan Hasil Hitungan pada Tampilan Browser**
    ```html
    <tr>
        <th>Jumlah Pengguna</th>
    </tr>
    <tr>
        <td>{{ $data }}</td>
    </tr>
    ```

### Praktikum 2.4 - Membuat atau Mengambil Model

1. **Menggunakan `firstOrCreate`**
    ```php
    $user = UserModel::firstOrCreate([
        'username' => 'manager',
        'nama' => 'Manager',
    ]);
    ```
2. **Menerapkan `firstOrCreate` untuk user yang belum ada**
    ```php
    $user = UserModel::firstOrCreate([
        'username' => 'manager22',
        'nama' => 'Manager Dua Dua',
        'password' => Hash::make('12345'),
        'level_id' => 2
    ]);
    ```
3. **Menggunakan `firstOrNew`**
    ```php
    $user = UserModel::firstOrNew([
        'username' => 'manager',
        'nama' => 'Manager',
    ]);
    ```
4. **Menerapkan `firstOrNew` untuk user yang belum ada**
    ```php
    $user = UserModel::firstOrNew([
        'username' => 'manager33',
        'nama' => 'Manager Tiga Tiga',
        'password' => Hash::make('12345'),
        'level_id' => 2
    ]);
    ```
5. **Menyimpan Data dengan `firstOrNew` dan `save()`**
    ```php
    $user = UserModel::firstOrNew(
        [
            'username' => 'manager33',
            'nama' => 'Manager Tiga Tiga',
            'password' => Hash::make('12345'),
            'level_id' => 2
        ]
    );
    $user->save();
    ```

### Praktikum 2.5 - Memeriksa Perubahan Atribut

1. **Menggunakan `isDirty` dan `isClean`**
    ```php
    $user = UserModel::create([
        'username' => 'manager55',
        'nama' => 'Manager55',
        'password' => Hash::make('12345'),
        'level_id' => 2
    ]);
    
    $user->username = 'manager56';
    
    $user->isDirty();
    $user->isDirty('username');
    $user->isDirty('nama');
    $user->isDirty(['nama', 'username']);
    
    $user->isClean();
    $user->isClean('username');
    $user->isClean('nama');
    $user->isClean(['nama', 'username']);
    
    $user->save();
    
    $user->isDirty();
    $user->isClean();
    dd($user->isDirty());
     ```
2. **Menerapkan `wasChanged` untuk Melihat Perubahan Atribut**
    ```php
    $user = UserModel::create([
        'username' => 'manager11',
        'nama' => 'Manager11',
        'password' => Hash::make('12345'),
        'level_id' => 2
    ]);
    
    $user->username = 'manager12';

    $user->save();

    $user->wasChanged();
    $user->wasChanged('username');
    $user->wasChanged(['username', 'level_id']);
    $user->wasChanged('nama');
    dd($user->wasChanged(['nama', 'username']));
    ```

### Praktikum 2.6 - CRUD (Create, Read, Update, Delete)

1. **Membuat Tampilan untuk Menampilkan Data (Read)**
    ```html
    <table class="table">
       <thead>
           <tr>
               <th>ID</th>
               <th>Username</th>
               <th>Nama</th>
               <th>Level</th>
               <th>Aksi</th>
           </tr>
       </thead>
       <tbody>
            @foreach($data as $d)
           <tr>
               <td>{{ $d->user_id }}</td>
               <td>{{ $d->username }}</td>
               <td>{{ $d->nama }}</td>
               <td>{{ $d->level_id }}</td>
               <td>
                   <a href="{{ url('/user/ubah', $d->user_id) }}" class="btn btn-warning">Ubah</a>
                   <a href="{{ url('/user/hapus', $d->user_id) }}" class="btn btn-danger">Hapus</a>
               </td>
           </tr>
           @endforeach
       </tbody>
    </table>
    ```
2. **Membuat Fungsi untuk Menampilkan Semua Data (Read)**
    ```php
    public function index()
    {
        $data = UserModel::all();
        return view('user', ['data' => $data]);
    }
    ```
3. **Membuat Form untuk Menambahkan Data (Create)**
    ```html
    <form method="post" action="{{ url('/user/tambah_simpan')}}">
        
        {{ csrf_field() }}
        
        <label>Username</label>
        <input type="text" name="username" placeholder="Masukan Username">
        <br>
        <label>Nama</label>
        <input type="text" name="nama" placeholder="Masukan Nama">
        <br>
        <label>Password</label>
        <input type="password" name="password" placeholder="Masukan Password">
        <br>
        <label>Level ID</label> 
        <Input type="number" name="level_id" placeholder="Masukan ID Level">
        <br><br>
        <input type="submit" class="btn btn-success" value="Simpan">
            
    </form>
    ```
4. **Membuat route untuk Halaman Tambah (Create)**
    ```php
    Route::get('/user/tambah', [UserController::class, 'tambah']);
    ```
5. **Membuat fungsi tambah untuk Menampilkan Halaman Tambah (Create)**
    ```php
    public function tambah()
    {
        return view('user_tambah');
    }
    ```
6. **Membuat route untuk Menyimpan Data (Submit)**
    ```php
     Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);
    ```
7. **Membuat Fungsi untuk Memproses Data Baru (Submit)**
    ```php
    public function tambah_simpan(Request $request)
    {
        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make("$request->password"),
            'level_id' => $request->level_id
        ]);
        return redirect('/user');
    }
    ```
8. **Membuat Form untuk Mengedit Data (Edit)**
    ```html
    <form method="post" action="{{ url('/user/ubah_simpan/' . $data->user_id) }}">
        
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        
        <label>Username</label>
        <input type="text" name="username" placeholder="Masukan Username" value="{{ $data->username }}">
        <br>
        <label>Nama</label>
        <input type="text" name="nama" placeholder="Masukan Nama" value="{{ $data->nama }}">
        <br>
        <label>Password</label>
        <input type="password" name="password" placeholder="Masukan Password" value="{{ $data->password }}">
        <br>
        <label>Level ID</label> 
        <input type="number" name="level_id" placeholder="Masukan ID Level" value="{{ $data->level_id }}">
        <br><br>
        <input type="submit" class="btn btn-success" value="Ubah">
        
    </form>
     ```
9. **Membuat route untuk Mengedit Data (Edit)**
    ```php
    Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
    ```
10. **Membuat fungsi tambah untuk Menampilkan Halaman Ubah (Edit)**
    ```php
    public function ubah($id)
    {
        $user = UserModel::find($id);
        return view('user_ubah', ['data' => $user]);
    }
    ```
11. **Membuat route untuk Menyimpan Perubahan Data (Update)**
    ```php
    Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
    ```
12. **Membuat fungsi untuk Menyimpan Perubahan Data (Update)**
    ```php
    public function ubah_simpan(Request $request, $id)
    {
        $user = UserModel::find($id);

        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->password = Hash::make("$request->password");
        $user->level_id = $request->level_id;

        $user->save();

        return redirect('/user');
    }
    ```
13. **Membuat route untuk Menghapus Data (Delete)**
    ```php
    Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);
    ```
12. **Membuat fungsi untuk Menghapus Data (Delete)**
    ```php
    public function hapus($id)
    {
        $user = UserModel::find($id);
        $user->delete();

        return redirect('/user');
    }
    ```

### Praktikum 2.7 - Menerapkan Relasi antar Model

1. **Menambahkan Relasi ke Model UserModel**
    ```php
    public function level() {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }
    ```
2. **Menggunakan Relasi di UserController**
    ```php
    public function index()
    {
        $data = UserModel::with('level')->get();
        return view('user', ['data' => $data]);
    }
    ```
3. **Menampilkan Data Relasi pada Tampilan**
    ```html
        <table border="1" cellpadding="2" cellspacing="0"> 
            <tr> 
                <td>ID</td> 
                <td>Username</td> 
                <td>Nama</td>
                <td>ID Level Pengguna</td> 
                <td>Aksi</td>
                <td>Kode Level</td> 
                <td>Nama Level</td> 
            </tr> 
            @foreach ($data as $d)
            
            <tr> 
                <td>{{ $d->user_id }}</td> 
                <td>{{ $d->username }}</td> 
                <td>{{ $d->nama }}</td> 
                <td>{{ $d->level_id }}</td>
                <td>{{ $d->level->level_kode}}</td>
                <td>{{ $d->level->level_nama}}</td>
                <td><a href="{{ url('/user/ubah/' . $d->user_id) }}">Ubah</a> | <a href="{{ url('/user/hapus/' . $d->user_id) }}">Hapus</a></td>
            </tr> 
            @endforeach
        </table>
    ```