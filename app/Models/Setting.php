<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = [
        "blog_name",
        "blog_email",
        "blog_desc",
        "blog_logo",
        "blog_favicon"
    ];

    function getBlogLogoAttribute($value)
    {
        return asset('back/dist/img/logo-favicon/' . $value);
    }
}
