<?php

use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'front.pages.home');
Route::get('/article/{any}', [BlogController::class, 'readPost'])->name('read_post');
Route::get('/category/{slug}', [BlogController::class, 'categoryPosts'])->name('category_post');
Route::get('/posts/tag/{any}', [BlogController::class, ''])->name('tag_posts');
Route::get('/search', [BlogController::class, 'searchBlog'])->name('search_post');
