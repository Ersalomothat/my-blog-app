<?php

// namespace App; //error jika include

use App\Models\{Setting, Post, SubCategory};
use Illuminate\Support\Str;
use Carbon\Carbon;

if (!function_exists('blogInfo')) {
    function blogInfo()
    {
        return Setting::find(1);
    }
}

/**
 * DATE FORMAT eg: Januari 12, 2022
 */
if (!function_exists('date_formatter')) {
    function date_formatter($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->isoFormat('LL');
    }
}

if (!function_exists('words')) {
    function words($value, $words = 15, $end = "...")
    {
        return Str::words(strip_tags($value), $words, $end);
    }
}


/**
 * chech if use is logged in or has internetconection
 */

if (!function_exists('isOnline')) {
    function isOnline($site = 'https://youtube.com/'): bool
    {
        if (@fopen($site, 'r')) {
            return true;
        }
        return false;
    }
}

/**
 * reading article duration
 */

if (!function_exists('readDuration')) {
    function readDuration(...$text)
    {
        Str::macro('timeCounter', function ($text) {
            $totalWord = str_word_count(implode('', $text));
            $minutesToRead = round($totalWord / 200);
            return (int)max(1, $minutesToRead);
        });
        return Str::timeCounter($text);
    }
}

/**
 * display home main latest post
 */

if (!function_exists('single_latest_post')) {
    function single_latest_post()
    {
        return Post::with('author')
            ->with('subcategory')
            ->limit(1)
            ->orderBy('created_at', 'desc')
            ->first();
    }
}

/**
 * display 6 ;atest post on home page
 */

if (!function_exists('latest_home_6posts')) {
    function latest_home_6posts()
    {
        return Post::with('author')
            ->with('subCategory')
            ->skip(1)
            ->limit(6)
            ->orderBy('created_at', 'DESC')->get();
    }
}

/**
 * display random post
 */
if (!function_exists('recomended_posts')) {
    function recomended_posts()
    {
        return Post::with('author')
            ->with('subCategory')
            ->limit(4)
            ->inRandomOrder()->get();
    }
}

if (!function_exists('categories')) {
    function categories()
    {
        return SubCategory::whereHas('posts')
            ->with('posts')
            ->orderBy('subcategory_name', 'asc')
            ->get();
    }
}

/**
 * Display latest post
 * */

if (!function_exists('display_latest_post')) {
    function display_latest_post($except = null, $limit = 4)
    {
        return Post::where('id', '!=', $except)
            ->limit($limit)
            ->orderBy('created_at', 'DESC')
            ->get();
    }
}
