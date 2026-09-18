<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\StandingController;

Route::get('/home', [HomeController::class, 'api']);
Route::get('/articles/{slug}', [HomeController::class, 'apiShow']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{slug}/articles', [CategoryController::class, 'articles']);
Route::get('/standings/{slug}', [StandingController::class, 'show']);