<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
Route::get('/dashboard', [\App\Http\Controllers\AdController::class,'dashboard'])->name('dashboard');
Route::get('/ad/create', [\App\Http\Controllers\AdController::class,'create'])->name('ad.create');
Route::post('/ad/store', [\App\Http\Controllers\AdController::class,'store'])->name('ad.store');

Route::get('/ad/{id}/show', [\App\Http\Controllers\AdController::class,'show'])->name('ad.show');
Route::get('/ad/{id}/edit', [\App\Http\Controllers\AdController::class,'edit'])->name('ad.edit');
Route::post('/ad/{id}/update', [\App\Http\Controllers\AdController::class,'update'])->name('ad.update');
Route::delete('/ad/{id}/delete', [\App\Http\Controllers\AdController::class,'delete'])->name('ad.delete');
Route::post('/ad/{id}/add_favorite', [\App\Http\Controllers\FavoriteController::class,'add_favorite'])->name('favorite.add');
Route::post('/ad/{id}/remove_favorite', [\App\Http\Controllers\FavoriteController::class,'remove_favorite'])->name('favorite.remove');
Route::get('/ad/load_favorites', [\App\Http\Controllers\FavoriteController::class,'load_favorites'])->name('favorite.load_favorites');
Route::post('/ad/{id}/add_to_cart', [\App\Http\Controllers\CartController::class,'add_to_cart'])->name('cart.load_favorites');
Route::post('/ad/{id}/remove_from_cart', [\App\Http\Controllers\CartController::class,'remove_from_cart'])->name('cart.remove_from_cart');

Route::get('/ad/cart', [\App\Http\Controllers\CartController::class,'list'])->name('cart.list');

