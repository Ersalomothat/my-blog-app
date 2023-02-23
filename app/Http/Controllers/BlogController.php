<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Post, SubCategory};
use Illuminate\Support\Str;

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
    public function searchBlog(Request $req)
    {
        $q = request()->query('query');
        if ($q && strlen($q) >= 2) {
            $searchValue = preg_split('/\s+/', $q, -1, PREG_SPLIT_NO_EMPTY);
            $posts = Post::query();

            $posts->where(function ($qr) use ($searchValue) {
                foreach ($searchValue as $item) {
                    $qr->orWhere('post_title', 'LIKE', "%{$item}%");
                    $qr->orWhere('post_tags', 'LIKE', "%{$item}%");
                }
            });
            $posts = $posts->with('subcategory')
                ->with('author')
                ->orderBy('created_at', 'desc')
                ->paginate(6);
            $data = [
                'pageTitle' => 'Search for :: ' . request()->query('query'),
                'posts' => $posts
            ];
            return view('front.pages.search_posts', $data);
        }
        return abort(404);
    }

    public function readPost(Request $req, $slug)
    {
        if (!$slug) return abort(404);
        $post = Post::where('post_slug', $slug)
            ->with('subcategory')
            ->with('author')
            ->first();
        $post_tags = explode(',', $post->post_tags);
        $related_posts = Post::where('id', '!=', $post->id)
            ->where(function ($query) use ($post_tags, $post) {
                foreach ($post_tags as $item) {
                    $query->orWhere('post_tags', 'like', "%$item%")
                        ->orWhere('post_title', 'like', $post->post_title);
                }
            })
            ->inRandomOrder()
            ->take(3)
            ->get();
        $data = [
            'pageTitle' => Str::ucfirst($post->post_title),
            'post' => $post,
            'related_post' => $related_posts,
        ];
        return view('front.pages.single_post', $data);
    }
    public function tagPosts(Request $req, $tag)
    {
        $posts = Post::where('post_tags', 'like', "%$tag%")
            ->with('subCategory')
            ->with('author')
            ->paginate(6);
        if (!$posts) return abort(404);

        $data  = array(
            'pageTitle' => '#' . $tag,
            'posts' => $posts
        );
        return view('front.pages.post-tags', $data);
    }
}
