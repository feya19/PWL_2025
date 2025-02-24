<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

route::get('/', [HomeController::class, 'index']);

route::prefix('product') ->group(function () 
{
    route::get('/', [ProductController::class, 'index']);
    route::get('/category/food-beverage', [ProductController::class, 'foodBeverage']) -> name ('product.food-beverage');
    route::get('/category/beauty-health', [ProductController::class, 'beautyHealth']) -> name ('product.beauty-health');
    route::get('/category/home-care', [ProductController::class, 'homeCare']) -> name ('product.home-care');
    route::get('/category/baby-kid', [ProductController::class, 'babyKid']) -> name ('product.baby-kid');
 
});

route::get('/transaction', [TransactionController::class, 'index']);

route::get('/user/{id}/name/{name}', [UserController::class, 'show']);






