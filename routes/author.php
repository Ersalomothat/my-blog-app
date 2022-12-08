<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

//1.goto RouteServiceProvider after that
//2.goto Authenticate // an error occureed
Route::prefix('author')->name("author")->group(function () {
    Route::middleware(['guest:web'])->group(function () {
        Route::view('login', 'back.pages.auth.login')->name(".login");
        Route::view('forgot-password', 'back.pages.auth.forgot')->name('/forgot-password');
        Route::get('password/reset/{token}', [AuthController::class, 'ResetForm'])->name('/reset-form');
    });

    Route::middleware(['auth:web'])->group(function () {
        Route::get('home', [AuthController::class, 'index'])->name("/home");
        Route::post('logout', [AuthController::class, 'logout'])->name("/logout");
        Route::view('profile', 'back/pages/profile')->name("/profile");
        Route::post('change-profile-picture', [AuthController::class, "changeProfilePicture"])->name("/change.profile.picture");
        Route::view('settings', 'back/pages/settings')->name('/settings');
        Route::post('change-blog-logo', [AuthController::class, "changeBlogLogo"])->name("/change-blog-logo");
        Route::post('/change-blog-favicon', [AuthorController::class, 'changeBlogFavicon'])->name('change-blog-favicon');
        Route::view('author', 'back.pages.authors')->name('/authors');
        Route::view('/categories', 'back.pages.categories')->name('categories');


        Route::prefix('posts')->name('posts.')->group(function () {
            Route::view('/add-post', 'back.pages.add-post')->name('add-post');
            Route::post('/create', [AuthorController::class, 'createPost'])->name('create');
        });
    });
});

// sometimes you have to visit this https://github.com/livewire/livewire
