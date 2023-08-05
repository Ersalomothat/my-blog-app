    <div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <div class="row g-2 align-items-center mb-3">
        <div class="col">
            <h2 class="page-title">
                All -Posts
            </h2>
            <div class="text-muted mt-1">{{ $posts->count() }}</div>
        </div>
        <!-- Page title actions -->
        <div class="col-12 col-md-auto ms-auto d-print-none">
            <div class="d-flex">
                <div class="me-3">
                    <label for="">Search
                        <div class="input-icon">
                            <input type="text" wire:model="search" class="form-control" placeholder="Search…">
                            <span class="input-icon-addon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <circle cx="10" cy="10" r="7"></circle>
                                    <line x1="21" y1="21" x2="15" y2="15"></line>
                                </svg>
                            </span>
                        </div>
                    </label>
                </div>
                <div class="me-3">

                </div>
                <div class="me-3">
                    <label for="">Category
                        <select name="" id="" class="form-control">
                            <option value="">--No Selected--</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ __($category->subcategory_name) }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
                <div class="me-3">
                    <label for="">Author
                        <select wire:model="author" class="form-control">
                            <option value="">--No Selected--</option>
                            @foreach ($authors as $author)
                                <option value="{{ $author->id }}">{{ __($author->name) }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
                <div class="me-3">
                    <label for="">Order By
                        <select wire:model="orderBy" class="form-control">
                            <option value="asc">ASC</option>
                            <option value="desc">DESC</option>
                        </select>
                    </label>
                </div>

            </div>
        </div>
    </div>
    <div class="row row-cards">
        @forelse($posts as $post)
            <div class="col-sm-6 col-lg-4">
                <div class="card card-sm">
                    <a href="#" class="d-block"><img
                            src="{{ asset('storage/images/post_images/' . $post->featured_image) }}"
                            class="card-img-top"></a>
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <p>{{ __($post->post_title) }}</p>
                        </div>
                        <div class="align-items-between">
                            <a href="{{ route('author.posts.edit-post', ['post_id' => $post->id]) }}"
                                class="btn btn-primary">Edit</a>
                            <button wire:click.prevent="deletePost({{ $post->id }})"
                                class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <h1>Empty Page</h1>
        @endforelse
        <div class="d-flex">
            {{ $posts->links('livewire::simple-bootstrap') }}
        </div>
    </div>
</div>
@push('scripts')
    <script>
        window.addEventListener('deletePost', function(e) {
            swal.fire({
                title: e.detail.title,
                html: e.detail.html,
                imageWidth: 48,
                imageHeight: 48,
                showCloseButton: true,
                showCancelButton: true,
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Yes, delete',
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                width: 300,
                allowOutsideClick: false
            }).then((res) => {
                if (res.value) {
                    window.livewire.emit('deletepostAction', e.detail.id)
                }
            })
        })
    </script>
@endpush
