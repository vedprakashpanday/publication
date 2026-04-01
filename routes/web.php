<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\AuthorController;  
use App\Http\Controllers\Admin\PublisherController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\StockRequestController;

Route::get('/', function () {
    return view('welcome');
});

// Admin Routes (Baad mein ispe middleware lagayenge)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Book Management Routes
    Route::get('/books', [BookController::class, 'index'])->name('admin.books.index'); // <-- Ye line add karein
    Route::get('/books/create', [BookController::class, 'create'])->name('admin.books.create');
    Route::post('/books', [BookController::class, 'store'])->name('admin.books.store');

    // Author Routes
    Route::resource('authors', AuthorController::class)->names([
        'index' => 'admin.authors.index',
        'create' => 'admin.authors.create',
        'store' => 'admin.authors.store',
        'edit' => 'admin.authors.edit',
        'update' => 'admin.authors.update',
        'destroy' => 'admin.authors.destroy',
    ]);

    // Publisher Routes
    Route::resource('publishers', PublisherController::class)->names([
        'index' => 'admin.publishers.index',
        'create' => 'admin.publishers.create',
        'store' => 'admin.publishers.store',
        'edit' => 'admin.publishers.edit',
        'update' => 'admin.publishers.update',
        'destroy' => 'admin.publishers.destroy',
    ]);


    // Users & Sellers Management
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/sellers', [UserController::class, 'sellers'])->name('admin.sellers.index');
    Route::post('/users/{user}/toggle', [UserController::class, 'toggleStatus'])->name('admin.users.toggle');

    Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
Route::post('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');

Route::post('/orders/{order}/update-tracking', [OrderController::class, 'updateTracking'])->name('admin.orders.updateTracking');


});

Route::get('/stock-requests', [StockRequestController::class, 'index'])->name('admin.stock.index');
Route::post('/stock-requests/{stockRequest}/approve', [StockRequestController::class, 'approve'])->name('admin.stock.approve');
Route::post('/stock-requests/{stockRequest}/reject', [StockRequestController::class, 'reject'])->name('admin.stock.reject');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
