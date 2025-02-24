<?php

use App\Http\Controllers\ItemController; // Mengimpor ItemController
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

Route::get('/', function () { // Mendefinisikan rute untuk halaman beranda
    return view('welcome'); // Menampilkan tampilan 'welcome'
});

Route::resource('items', ItemController::class); // Mendefinisikan rute resource untuk items
