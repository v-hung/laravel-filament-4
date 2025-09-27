<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Shop\ProductController;
use App\Http\Controllers\Site\AboutController;
use App\Http\Controllers\Site\ContactController;
use App\Http\Controllers\Site\HomeController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// home & pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about-us', [AboutController::class, 'index'])->name('about');
Route::get('/contact-us', [ContactController::class, 'index'])->name('contact');

// shop / collections / products
Route::get('/collections', [HomeController::class, 'index'])->name('collections');
Route::get('/collections/{collection_slug}', [HomeController::class, 'index'])->name('collections.show');
Route::get('/collections/{collection_slug}/products/{product_slug}', [HomeController::class, 'index'])->name('collections.products.show');

Route::get('/shop', [ProductController::class, 'shop'])->name('shop');
Route::get('/products/{product_slug}', [ProductController::class, 'detail'])->name('products.detail');

// content
Route::get('/blogs/{blog_slug}', [HomeController::class, 'index'])->name('blogs.show');
Route::get('/blogs/{blog_slug}/{post_slug}', [HomeController::class, 'index'])->name('posts.show');
Route::get('/pages/{page_slug}', [HomeController::class, 'index'])->name('page.show');

// cart
Route::get('/cart', [HomeController::class, 'index'])->name('cart');
Route::post('/cart/add', [HomeController::class, 'index'])->name('cart.add');
Route::post('/cart/update', [HomeController::class, 'index'])->name('cart.update');
Route::post('/cart/clear', [HomeController::class, 'index'])->name('cart.clear');

// wishlist
Route::get('/wishlist', [HomeController::class, 'index'])->name('wishlist');


// Route::prefix('products')->name('products.')->group(function () {
//     Route::get('/', [ProductController::class, 'index'])->name('index');
//     Route::get('{slug}', [ProductController::class, 'show'])->name('show');
// });


// Route::middleware(['auth', 'verified.optional'])->group(function () {
//     Route::get('/', [CartController::class, 'index'])->name('index');
//     Route::post('add/{id}', [CartController::class, 'add'])->name('add');
//     Route::delete('remove/{id}', [CartController::class, 'remove'])->name('remove');
// });


// common
Route::get('/greeting/{locale}', function (string $locale) {
    if (! in_array($locale, ['en', 'vi'])) {
        abort(400, 'Unsupported locale');
    }

    session(['locale' => $locale]);

    App::setLocale($locale);

    return redirect()->back();
})->name('lang.switch');

require __DIR__ . '/auth.php';
