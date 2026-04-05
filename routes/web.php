<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\PublisherController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\StockRequestController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Admin\BuyerStoryController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
// Route::get('/', function () {
//     return view('frontend.home');
// });

Route::get('/book', function () {
    return view('frontend.book-details'); // File ka naam jo aapne save kiya hai
});

// Route::get('/shop', function () {
//     return view('frontend.shop'); 
// });

Route::get('/cart', function () {
    return view('frontend.cart'); 
});

// Route::get('/checkout', function () {
//     return view('frontend.checkout'); 
// });

Route::get('/udashboard', function () {
    return view('frontend.user-dashboard'); 
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Admin Panel Routes (Protected by Auth & Admin Middleware)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // --- Core ---
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // --- Inventory Management ---
        // Books (CRUD + Status Toggle)
        Route::resource('books', BookController::class);
        Route::patch('/books/{book}/toggle', [BookController::class, 'toggleStatus'])->name('books.toggle');

        // Authors (CRUD)
        Route::resource('authors', AuthorController::class);

        // Publishers (CRUD)
        Route::resource('publishers', PublisherController::class);

        // --- Operations ---
        // Orders & Tracking
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::post('/orders/{order}/update-tracking', [OrderController::class, 'updateTracking'])->name('orders.updateTracking');

        // Stock Requests
        Route::get('/stock-requests', [StockRequestController::class, 'index'])->name('stock.index');
        Route::post('/stock-requests/{stockRequest}/approve', [StockRequestController::class, 'approve'])->name('stock.approve');
        Route::post('/stock-requests/{stockRequest}/reject', [StockRequestController::class, 'reject'])->name('stock.reject');

        // Sales Reports
        Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');

        // --- Community & Marketing ---
        // Buyer Stories (CRUD + Status Toggle)
        Route::resource('buyer-stories', BuyerStoryController::class);
        Route::post('buyer-stories/toggle/{id}', [BuyerStoryController::class, 'toggle'])->name('buyer-stories.toggle');

        // --- User Management ---
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/sellers', [UserController::class, 'sellers'])->name('sellers.index');
        Route::post('/users/{user}/toggle', [UserController::class, 'toggleStatus'])->name('users.toggle');



        // Profile Routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Settings Routes
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings/update', [SettingController::class, 'update'])->name('settings.update');
    });




    // Front end

    // Frontend Pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/book/{slug}', [ShopController::class, 'show'])->name('book.show');

// Baaki pages ke dummy routes (Inhe hum baad mein banayenge)
Route::get('/cart', function () { return view('frontend.cart'); })->name('cart');

Route::get('/my-account', function () { return view('frontend.user-dashboard'); })->name('dashboard');

// Auth (Ajax Modals ke liye routes)
Route::post('/ajax-login', [AuthController::class, 'login'])->name('ajax.login');
Route::post('/ajax-register', [AuthController::class, 'register'])->name('ajax.register');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/save-for-later/{id}', [CartController::class, 'saveForLater'])->name('cart.saveForLater');
Route::post('/cart/move-to-cart/{id}', [CartController::class, 'moveToCart'])->name('cart.moveToCart');


// Purane routes hata kar ye clean logic daalein
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/place-order', [CheckoutController::class, 'placeOrder'])->name('placeOrder');
Route::get('/order-success/{order_number}', [CheckoutController::class, 'success'])->name('checkout.success');