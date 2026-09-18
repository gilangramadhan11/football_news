<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/article/{slug}', [HomeController::class, 'show'])
    ->name('article.show');
Route::get('/category/{slug}', [HomeController::class, 'show'])
    ->name('category.show');   
Route::get('/category/{slug}', [HomeController::class, 'category'])
    ->name('category.show');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('articles', ArticleController::class);
    Route::resource('categories', CategoryController::class);
});

Route::post('/article/{article}/like', [HomeController::class, 'like'])
    ->name('article.like');

Route::get('/test-403', function () {
    abort(403);
});

Route::middleware('throttle:3,1')->group(function () {

    Route::get('/test-429', function () {

        return "OK";

    });

});

Route::get('/test-500', function () {

    throw new Exception("Testing 500");

});

route::middleware('auth')->group(function () {
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/notifications/{id}', [NotificationController::class, 'show'])
        ->name('notifications.show');

});

Route::post('/notifications/read-all',
    [NotificationController::class, 'readAll'])
    ->name('notifications.readAll');

Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::resource('users', UserController::class);
});

Route::middleware(['auth','role:super_admin,editor'])->group(function () {
    Route::resource('categories', CategoryController::class);
});

Route::middleware(['auth','role:super_admin,editor,author'])->group(function () {
    Route::resource('articles', ArticleController::class);
});

require __DIR__.'/auth.php';
