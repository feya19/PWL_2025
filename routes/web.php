<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController; // Mengimpor ItemController
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route; // Mengimpor facade Route

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () { // Mendefinisikan rute untuk halaman beranda
//     return view('welcome'); // Menampilkan tampilan 'welcome'
// });

Route::resource('items', ItemController::class); // Mendefinisikan rute resource untuk items

// Route::get('/hello', function () {
//     return 'Hello';
// });

Route::get('/world', function () {
    return 'World';
});

// Route::get('/hello', function () {
//     return 'Hello World';
// });


// Route::get('/', function () {
//     return 'Selamat Datang';
// });

// Route::get('/about', function () {
//     return 'Nama : Fahmi Yahya <br> NIM : 2341720089';
// });

// Route::get('/user/{name}', function ($name) {
//     return 'Nama saya ' . $name;
// });

Route::get('/posts/{post}/comments/{comment}', function ($postID, $commentID) {
    return 'Pos ke-' . $postID . " Komentar ke-" . $commentID;
});

// Route::get('/articles/{id}', function ($articleID) {
//     return 'Halaman Artikel dengan ID {' . $articleID . '}';
// });

// Route::get('/user/{name?}', function ($name = null) {
//     return 'Nama saya ' . $name;
// });

Route::get('/user/{name?}', function ($name = 'Fahmi Yahya') {
    return 'Nama saya ' . $name;
});


Route::get('/hello', [WelcomeController::class, 'hello']);

// Route::get('/', [PageController::class, 'index']);
// Route::get('/about', [PageController::class, 'about']);
// Route::get('/articles/{id}', [PageController::class, 'articles']);

Route::get('/', [HomeController::class, 'index']);
Route::get('/about', [AboutController::class, 'about']);
Route::get('/articles/{id}', [ArticleController::class, 'articles']);

// Route::resource('photos', PhotoController::class)->only([
//     'index', 'show'
// ]);
// Route::resource('photos', PhotoController::class)->except([
//     'create', 'store', 'update', 'destroy'
// ]);

// Route::get ('/greeting', function () {
//     return view('blog.hello ', ['name' => 'Fahmi Yahya']);
// });

Route::get ('/greeting', [WelcomeController::class, 'greeting']);
