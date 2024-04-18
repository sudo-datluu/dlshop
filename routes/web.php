<?php

use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

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
    return Redirect::to('home');
});

Route::get('home/{categorySlug?}/{subCategorySlug?}', [FrontController::class,'index'])->name('front.home');
Route::get('/product/{slug}', [FrontController::class,'product'])->name('front.product');

Route::get('/cart', [CartController::class,'cart'])->name('front.cart');
Route::get('/cart-json', [CartController::class,'cartJson'])->name('front.cartJson');
Route::post('/add-to-cart', [CartController::class,'addToCart'])->name('front.addToCart');
Route::post('/update-cart', [CartController::class,'updateCart'])->name('front.updateCart');
Route::post('/delete-cart-item', [CartController::class,'deleteCartItem'])->name('front.deleteCartItem');
Route::post('/clear-cart', [CartController::class,'clearCart'])->name('front.clearCart');

Route::get('/checkout', [CartController::class,'checkout'])->name('front.checkout');
Route::post('/process-checkout', [CartController::class,'processCheckout'])->name('front.processCheckout');

Route::get('/orders/{orderId}', [OrderController::class,'order'])->name('front.order');

Route::group(['prefix' => 'admin'], function (){
    Route::group(['middleware' => 'admin.guest'], function (){
        Route::get('/login', [AdminLoginController::class,'index'])->name('admin.login');
        Route::post('/authenticate', [AdminLoginController::class,'authenticate'])->name('admin.authenticate');
    
    });

    Route::group(['middleware' => 'admin.auth'], function (){
        Route::get('/dashboard', [HomeController ::class,'index'])->name('admin.dashboard');
        Route::get('/logout', [HomeController ::class,'logout'])->name('admin.logout');
        
        // Categories
        Route::get('/categories/create', [CategoryController ::class,'create'])->name('categories.create');
        Route::post('/categories', [CategoryController ::class,'store'])->name('categories.store');
    });
});