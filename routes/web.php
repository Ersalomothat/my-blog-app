<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => to_route('author.login'));

Route::get('/home', function () {
    return view('home');
});
