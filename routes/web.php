<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CustomerDetailController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\CustomerProductController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

// Admin Routes
Route::middleware('admin')->group(function () {
    Route::get('/admin/dashboard', [AdminLoginController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('categories', CategoryController::class)->names('admin.categories');
    Route::resource('products', ProductController::class)->names('admin.products');
    Route::resource('customer-details', CustomerDetailController::class)->only(['index', 'show'])->names('admin.customer-details');
    Route::post('/admin/products/{product}/stock', [ProductController::class, 'updateStock']);
    Route::post('/admin/products/{product}/discount', [ProductController::class, 'updateDiscount']);
    Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
    Route::post('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.status');
    Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::resource('customers', \App\Http\Controllers\Admin\CustomerController::class)->only(['index', 'show']);
    Route::resource('/admin/users', \App\Http\Controllers\UserController::class)->names('admin.users');
    Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
});

// Admin Login
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login']);

// Customer Pages (part of homepage)
Route::get('/', [CustomerProductController::class, 'welcome'])->name('welcome');
Route::get('/all-products', [CustomerProductController::class, 'allProducts'])->name('all-products');
Route::get('/sale', [CustomerProductController::class, 'discountedProducts'])->name('sale');
Route::get('/featured', [CustomerProductController::class, 'featuredProducts'])->name('featured');
Route::get('/cart', function () { return view('cart'); })->name('cart');
Route::get('/checkout', function () { return view('checkout'); })->name('checkout');
Route::get('/customer/profile', [CustomerProfileController::class, 'index'])->name('customer.profile');
Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout');
Route::get('/customer/orders', [CheckoutController::class, 'orders'])->name('customer.orders');
Route::post('/customer/profile', [CustomerProfileController::class, 'store'])->name('profile.store');
Route::put('/profile/{profile}', [CustomerProfileController::class, 'update'])->name('profile.update');
Route::get('/about', function () { return view('about'); })->name('about');
Route::get('/contact', function () { return view('contact'); })->name('contact');
Route::get('/search/results', [SearchController::class, 'results'])->name('search.products');
Route::get('/search-overlay', [SearchController::class, 'overlay'])->name('search.overlay');

// Customer Auth Routes
Route::get('/customer/login', [CustomerAuthController::class, 'showLoginForm'])->name('customer.login');
Route::post('/customer/login', [CustomerAuthController::class, 'login']);
Route::get('/customer/register', [CustomerAuthController::class, 'showRegisterForm'])->name('customer.register');
Route::post('/customer/register', [CustomerAuthController::class, 'register']);
Route::post('/customer/logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');

require __DIR__.'/auth.php';
