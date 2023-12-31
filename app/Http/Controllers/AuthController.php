<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\{User, Post};
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        return view('back.pages.home', [
            'posts_count' => Post::all(['id'])->count(),
            'users_count' => User::all(['id'])->count() - 1,
        ]);
    }
    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('author.login');
    }
    public function ResetForm(Request $request, $token = null)
    {
        $data = [
            'pageTitle' => 'Reset Password'
        ];
        return view('back.pages.auth.reset', $data)->with(['token' => $token, 'email' => $request->email]);
    }
    public function changeProfilePicture(Request $request)
    {
        $user = User::find(auth("web")->id());
        $path = "back/dist/img/authors/";
        $file = $request->file('file');
        $oldPicture = $user->getAttributes()['picture'];
        $filePath = $path . $oldPicture;
        $new_picture_name = 'AIMG' . $user->id . time() . rand(1, 10000) . ".jpg";

        if ($oldPicture != null && File::exists(public_path($filePath))) {
            File::delete(public_path($filePath));
        }
        $upload = $file->move(public_path($path), $new_picture_name);
        if ($upload) {
            $user->update([
                "picture" => $new_picture_name
            ]);
            return response()->json(['status' => 1, 'msg' => 'Your profile picture has been successfully updated.']);
        } else {
            return response()->json(['status' => 0, 'Something went wrong']);
        }
    }
    public function changeBlogLogo(Request $request)
    {

        $settings =  Setting::find(1);
        $logo_path = "back/dist/img/logo-favicon/";
        $old_logo = $settings->getAttributes()["blog_logo"];
        $file = $request->file("blog_logo");
        $filename = time() . '_' . rand(1, 100000) . '_ larablog_logo.png';
        if ($request->hasFile("blog_logo")) {
            if ($old_logo != null && File::exists(public_path($logo_path . $old_logo))) {
                File::delete(public_path($logo_path . $old_logo));
            }
            $upload = $file->move(public_path($logo_path), $filename);
            if ($upload) {
                $settings->update([
                    "blog_logo" => $filename
                ]);
                return response()->json([
                    'status' => 1,
                    "msg" => 'Larablog logo has been successfully updated.'
                ]);
            } else {
                return response()->json([
                    'status' => 0,
                    'msg' => 'Something went wrong'
                ]);
            }
        }
    }
    public function changeBlogFavicon(Request $request)
    {
        $settings = Setting::find(1);
        $favicon_path = 'back/dist/img/logo-favicon';
        $old_favicon = $settings->getAttributes()['blog_favicon'];
        $file = $request->file('blog_favicon');
        $filename = time() . '_' . rand(1, 2000) . '_larablog_favicon.ico';

        if ($old_favicon != null && File::exists(public_path($favicon_path . $old_favicon))) {
            File::delete(public_path($favicon_path . $old_favicon));
        }

        $upload = $file->move(public_path($favicon_path), $filename);
        if ($upload) {
            $settings->update([
                'blog_favicon' => $filename
            ]);
            return response()->json(['status' => 1, 'msg' => 'Blog favicon has been successfully updated.']);
        } else {
            return response()->json(['status' => 0, 'msg' => 'Something went wrong']);
        }
    }
    public function createPost(Request $request)
    {
        $request->validate([
            'post_title' => 'required|unique:posts,post_title',
            'post_content' => 'required',
            'post_category' => 'required|exists:sub_categories,id',
            'featured_image' => 'required|mimes:jpeg,jpg,png|max:1024',
        ]);

        if ($request->hasFile('featured_image')) {
            $path = "images/post_images/";
            $file = $request->file('featured_image');
            $filename = $file->getClientOriginalName();
            $new_filename = time() . '_' . $filename;

            $upload = Storage::disk('public')->put($path . $new_filename, (string) file_get_contents($file));
            $post_thumbnails_path = $path . '/thumbnails';
            if (!Storage::disk('public')->exists($post_thumbnails_path)) {
                Storage::disk('public')->makeDirectory($post_thumbnails_path, 0755, true, true);
            }


            // create square thumbnail
            Image::make(storage_path('app/public/' . $path . $new_filename))
                ->fit(200, 200)
                ->save(
                    storage_path(
                        'app/public/' . $path . 'thumbnails/' . 'thumb_' . $new_filename
                    )
                );
            // create resized image
            Image::make(storage_path('app/public/' . $path . $new_filename))
                ->fit(500, 350)
                ->save(
                    storage_path(
                        'app/public/' . $path . 'thumbnails/' . 'resized_' . $new_filename
                    )
                );

            if ($upload) {
                $post = new Post();
                $post->author_id = auth()->id();
                $post->category_id = $request->post_category;
                $post->post_title = $request->post_title;
                // $post->post_slug = null;
                $post->post_content = $request->post_content;
                $post->featured_image = $new_filename;
                $post->post_tags = $request->post_tags;
                $saved = $post->save();

                if ($saved) {
                    return response()->json(['code' => 1, 'msg' => 'New post has been successfully created.']);
                } else {
                    return response()->json(['code' => 3, 'msg' => 'Something went wrong ins saving post data.']);
                }
            } else {
                return response()->json(['code' => 3, 'msg' => 'Something went wrong for uploading featured image.']);
            }
        }
    }
    public function editPost(Request $request)
    {
        if (!$request->post_id) {
            abort(404);
        } else {
            $post = Post::findOrFail($request->post_id);
            $data = [
                'post' => $post,
                'pageTitle' => 'Edit Post'
            ];
            return view('back.pages.edit-posts', compact('data'));
        }
    }
    public function updatePost(Request $request)
    {
            if ($request->hasFile('featured_image')) {
                $request->validate([
                'post_title' => 'required|unique:posts,post_title,' . $request->post_id,
                'post_content' => 'required',
                'post_category' => 'required|exists:sub_categories,id',
                'featured_image' => 'mimes:jpeg,jpg,png|max:1024',
            ]);
                $path = "images/post_images/";
                $file = $request->file('featured_image');
                $filename = $file->getClientOriginalName();
                $new_filename = time() . '_' . $filename;
                $upload = Storage::disk('public')->put($path . $new_filename, (string) file_get_contents($file));
                $post_thumbnails_path = $path . '/thumbnails';
                if (!Storage::disk('public')->exists($post_thumbnails_path)) {
                    Storage::disk('public')->makeDirectory($post_thumbnails_path, 0755, true, true);
                }


                // create square thumbnail
                Image::make(storage_path('app/public/' . $path . $new_filename))
                    ->fit(200, 200)
                    ->save(storage_path('app/public/' . $path . 'thumbnails/' . 'thumb_' . $new_filename));
                // create resized image
                Image::make(storage_path('app/public/' . $path . $new_filename))
                    ->fit(500, 350)
                    ->save(storage_path('app/public/' . $path . 'thumbnails/' . 'resized_' . $new_filename));

            if ($upload) {
                $post = Post::findOrFail($request->post_id);
                $old_post_image = $post->featured_image;
                if ($old_post_image != null && Storage::disk('public')->exists($path . $old_post_image)) {
                    Storage::disk('public')->delete($path . $old_post_image);
                    if (Storage::disk('public')->exists($path . 'thumbnails/resized_' . $old_post_image)) {
                        Storage::disk('public')->delete($path . 'thumbnails/resized_' . $old_post_image);
                    }
                    if (Storage::disk('public')->exists($path . 'thumbnails/thumb_' . $old_post_image)) {
                        Storage::disk('public')->delete($path . 'thumbnails/thumb_' . $old_post_image);
                    }
                }

//                $post = Post::find($request->post_id);
                $post->author_id = auth()->id();
                $post->category_id = $request->post_category;
                $post->post_title = $request->post_title;
                $post->post_slug = null;
                $post->post_tags = $request->post_tags;
                $post->post_content = $request->post_content;
                $post->featured_image = $new_filename;
                $saved = $post->save();

                if ($saved) {
                    return response()->json(['code' => 1, 'msg' => 'New post has been successfully created.']);
                } else {
                    return response()->json(['code' => 3, 'msg' => 'Something went wrong ins saving post data.']);
                }
            } else {
                return response()->json(['code' => 3, 'msg' => 'Something went wrong for uploading featured image.']);
            }
        } else {
            $request->validate([
                'post_title' => 'required|unique:posts,post_title,' . $request->post_id,
                'post_content' => 'required',
                'post_category' => 'required|exists:sub_categories,id',
                'featured_image' => 'mimes:jpeg,jpg,png|max:1024',
            ]);
            $post = Post::findOrFail($request->post_id);
            $post->category_id = $request->post_category;
            $post->post_title = $request->post_title;
            $post->post_slug = null;
            $post->post_content = $request->post_content;
            $post->post_tags = $request->post_tags;
            $saved = $post->save();
            if ($saved) {
                return response()->json([
                    'status' => true,
                    'code' => 1,
                    'msg' => 'Successfully updated data post'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'code' => 3,
                    'msg' => 'There are something went wrong!'
                ]);
            }
        }
    }
}
