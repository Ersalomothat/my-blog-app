<?php

use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'front.pages.home');
Route::get('/article/{any}', [BlogController::class, ''])->name('read_post');
Route::get('/category/{any}', [BlogController::class, ''])->name('category_post');
Route::get('/posts/tag/{any}', [BlogController::class, ''])->name('tag_posts');
Route::get('/search', [BlogController::class, ''])->name('search_post');
