<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Api\ArticleController;

Route::get('/home', [HomeController::class, 'api']);
Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/{slug}', [HomeController::class, 'apiShow']);