<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Site\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/profile', function () {
//     return view('profile');
// })->middleware(['auth', 'verified'])->name('profile');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', [HomeController::class, 'index'])->name('home');

// Route::prefix('products')->name('products.')->group(function () {
//     Route::get('/', [ProductController::class, 'index'])->name('index');
//     Route::get('{slug}', [ProductController::class, 'show'])->name('show');
// });

// Route::middleware(['auth', 'verified.optional'])->group(function () {
//     Route::get('/', [CartController::class, 'index'])->name('index');
//     Route::post('add/{id}', [CartController::class, 'add'])->name('add');
//     Route::delete('remove/{id}', [CartController::class, 'remove'])->name('remove');
// });

require __DIR__ . '/auth.php';
