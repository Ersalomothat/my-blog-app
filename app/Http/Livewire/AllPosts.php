<?php

namespace App\Http\Livewire;

use Livewire\{Component, WithPagination};
use Illuminate\Support\Facades\Storage;
use App\Models\{Post, User, SubCategory};

class AllPosts extends Component
{
    use WithPagination;
    public $perPage = 10;
    public $author = null,
        $orderBy = 'asc',
        $category = null,
        $search = null;
    protected $listeners = [
        'deletepostAction'
    ];

        public function updatingSearch()
        {
            $this->resetPage();
        }
        public function updatingRole()
        {
            $this->resetPage();
        }
    public function updatingAuthor()
    {
        $this->resetPage();
    }
    public function updatingCategory()
    {
        $this->resetPage();
    }
    public function updatingOrderBy()
    {
        $this->resetPage();
    }
    public function mount()
    {
        $this->resetPage();
    }
    public function render()
    {
        return view('livewire.all-posts', [
            'posts' => auth()->user()->type == 1 ?
                Post::search(trim($this->search))
                ->when($this->category, function ($query) {
                    $query->where('category_id', $this->category);
                })
                ->when($this->author, function ($query) {
                    $query->where('author_id', $this->author);
                })
                ->when($this->orderBy, function ($query) {
                    $query->orderBy('id', $this->orderBy);
                })->paginate($this->perPage)
                :
                Post::search(trim($this->search))
                ->where('author_id', auth()->user()->id())
                ->when($this->category, function ($query) {
                    $query->where('category_id', $this->category);
                })
                ->when($this->orderBy, function ($query) {
                    $query->orderBy('id', $this->orderBy);
                })
                ->paginate($this->perPage),
            'authors' => User::whereHas('posts')->get(),
            'categories' => SubCategory::whereHas('posts')->get()
        ]);
    }

    public function deletePost($id)
    {
        $this->dispatchBrowserEvent('deletePost', [
            'title' => 'Are you sure?',
            'html' => 'you want to delete this post',
            'id' => $id,
        ]);
    }
    public function deletepostAction($id)
    {
        $post = Post::findOrFail($id);
        $path = 'images/post_images/';
        $image = $post->featured_image;
        $path_image = $path . $image;

        if ($image != null && Storage::disk('public')->exists($path_image)) {
            // delete thumnails
            if (Storage::disk('public')->exists('thumbnails/resized_' . $path_image)) {
                Storage::disk('public')->delete('thumbnails/resized_' . $path_image);
            }
            // delete image
            if (Storage::disk('public')->exists('thumbnails/thumb_' . $path_image)) {
                Storage::disk('public')->delete('thumbnails/thumb_' . $path_image);
            }
            Storage::disk('public')->delete($path_image);
        }
        $delete = $post->delete();
        if ($delete) {
            $this->showToastr('Post data dleted successfully', 'success');
        } else {
            $this->showToastr('Ups something went wrong', 'error');
        }
    }
    public function showToastr(string $msg, string $type)
    {
        $this->dispatchBrowserEvent('showToastr', [
            'type' => $type,
            'message' => $msg,
        ]);
    }
}
