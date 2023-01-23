<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Post, SubCategory};

class BlogController extends Controller
{
    public function categoryPosts(Request $req, $slug)
    {
        if (!$slug) return abort(404);
        $subCategory = SubCategory::where('slug', $slug)->first();
        if (!$subCategory) {
            return abort(404);
        } else {
            $posts = Post::where('category_id', $subCategory->id)
                ->orderBy('created_at', 'desc')
                ->paginate(6);

            $data = [
                'pageTitle' => 'Category - ' . $subCategory->subcategory_name,
                'category' => $subCategory,
                'posts' => $posts
            ];
            return view('front.pages.category_post', $data);
        }
    }
    public function readPost()
    {
        return abort(404);
    }
}
