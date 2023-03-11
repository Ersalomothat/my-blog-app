<?php

use App\Http\Controllers\{BlogController, ContactMessageController};
use Illuminate\Support\Facades\{Route};

Route::view('/', 'front.pages.home')->name('home');
Route::get('/article/{any}', [BlogController::class, 'readPost'])->name('read_post');
Route::get('/category/{slug}', [BlogController::class, 'categoryPosts'])->name('category_post');
Route::get('/posts/tag/{any}', [BlogController::class, 'tagPosts'])->name('tag_posts');
Route::get('/search', [BlogController::class, 'searchBlog'])->name('search_post');
Route::view('contact', 'front/pages/contact')->name('contact');

// contact me

Route::post('send-msg', [ContactMessageController::class, 'store'])->name('send_msg');
