<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\user\CartController;
use App\Http\Controllers\admin\CouponController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\user\WishlistController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\DiscountController;
use App\Http\Controllers\user\ProductDetailController;
use App\Http\Controllers\user\UserDashboardController;
use App\Http\Controllers\admin\AdminDashboarController;

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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
// User Routes
Route::group(['middleware' => ['user', 'auth']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

    // Product Detail
    Route::get('/product/{id}/show', [ProductDetailController::class, 'show'])->name('product.show');

    // Cart
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::put('/cart/update-quantity/{id}', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('cart.remove');

    //Wishlist
    Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
});

//Admin Routes
Route::group(['middleware' => ['admin', 'auth']], function () {
    Route::get('/admin/dashboard', [AdminDashboarController::class, 'index'])->name('admin.dashboard');

    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/category/{id}/update', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/{id}/delete', [CategoryController::class, 'destroy'])->name('category.destroy');

    // Product
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/{id}/update', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{id}/delete', [ProductController::class, 'destroy'])->name('product.delete');

    // Discount and Tax
    Route::get('/discount', [DiscountController::class, 'index'])->name('discount.index');
    Route::get('/discount/create', [DiscountController::class, 'create'])->name('discount.create');
    Route::post('/discount/store', [DiscountController::class, 'store'])->name('discount.store');
    Route::get('/discount/{id}/edit',[DiscountController::class, 'edit'])->name('discount.edit');
    Route::put('/discount/{id}/update',[DiscountController::class, 'update'])->name('discount.update');
    Route::delete('/discount/{id}/delete',[DiscountController::class, 'destroy'])->name('discount.delete');

    //Coupon
    Route::get('/coupon', [CouponController::class, 'index'])->name('coupon.index');
    Route::get('/coupon/create', [CouponController::class, 'create'])->name('coupon.create');
    Route::post('/coupon/store', [CouponController::class, 'store'])->name('coupon.store');
    Route::get('/coupon/{id}/edit',[CouponController::class, 'edit'])->name('coupon.edit');
    Route::put('/coupon/{id}/update',[CouponController::class, 'update'])->name('coupon.update');
    Route::delete('/coupon/{id}/delete',[CouponController::class, 'destroy'])->name('coupon.delete');

});
