<div>
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none mb-2">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Authors
                    </h2>
                    <div class="text-muted mt-1"></div>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="d-flex">
                        <input type="search" class="form-control d-inline-block w-9 me-3" wire:model="search"
                            placeholder="Search user…">
                        <a href="#" class="btn btn-primary" data-bs-target="#add_author_modal"
                            data-bs-toggle="modal">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            New author
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row row-cards">
        {{-- @foreach --}}
        @forelse ($authors as $author)
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body p-4 text-center">
                        <span class="avatar avatar-xl mb-3 avatar-rounded"
                            style="background-image: url({{ asset($author->picture) }})"></span>
                        <h3 class="m-0 mb-1"><a href="#">{{ $author->name }}</a></h3>
                        <div class="text-muted">{{ $author->email }}</div>
                        <div class="mt-3">
                            {{-- <span class="badge bg-purple-lt">{{ $author->authorType->name }}</span> --}}
                        </div>
                    </div>
                    <div class="d-flex">
                        <a href="#" wire:click.prevent="editAuthor({{ $author }})" class="card-btn">
                            Edit
                        </a>
                        <a href="#" wire:click.prevent="deleteAuthor({{ $author }})" class="card-btn">
                            Delete
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <span class="text-danger">No Authors Found!</span>
        @endforelse
    </div>
    {{ $authors->links('livewire::bootstrap') }}

    {{-- //modal --}}
    <div wire:ignore.self class="modal modal-blur fade" role="document" id="add_author_modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Author</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="addAuthor()" method="">

                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" wire:model="name" placeholder="name">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" wire:model="email" placeholder=""
                                placeholder="Input placeholder">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" wire:model="username"
                                placeholder="Input placeholder">
                            @error('username')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Author Type</label>
                            <div>
                                <select class="form-select" wire:model="author_type" id="floatingSelect"
                                    aria-label="Floating label select example">
                                    <option> <b>choose</b> </option>
                                    @foreach (\App\Models\Type::all() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('author_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-3">
                            <div class="form-label">Is direct as publisher</div>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" wire:model="publisher"
                                    value="1">
                                <span class="form-check-label">Yes</span>
                            </label>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" wire:model="publisher"
                                    value="0">
                                <span class="form-check-label">No</span>
                            </label>
                        </div>
                        @error('publisher')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="form-group">
                            <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- edit --}}
    <div wire:ignore.self class="modal modal-blur fade" role="document" id="edit_author_modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Author</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="updateAuthor()" method="">
                        <input type="hidden" wire:model="selected_author_id">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" wire:model="name" placeholder="name">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" wire:model="email" placeholder=""
                                placeholder="Input placeholder">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" wire:model="username"
                                placeholder="Input placeholder">
                            @error('username')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Author Type</label>
                            <div>
                                <select class="form-select" wire:model="author_type" id="floatingSelect"
                                    aria-label="Floating label select example">
                                    <option> <b>choose</b> </option>
                                    @foreach (\App\Models\Type::all() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('author_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-3">
                            <div class="form-label">Is direct as publisher</div>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" wire:model="publisher"
                                    value="1">
                                <span class="form-check-label">Yes</span>
                            </label>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" wire:model="publisher"
                                    value="0">
                                <span class="form-check-label">No</span>
                            </label>
                        </div>
                        @error('publisher')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="form-group">
                            <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $(window).on('hidden.bs.modal', function() {
            Livewire.emit('resetForm')
        })
        window.addEventListener('hide_add_author_modal', function(e) {
            $('#add_author_modal').modal('hide');
        })
        window.addEventListener('showEditAuthorModal', function(e) {
            $('#edit_author_modal').modal('show');
        })
        window.addEventListener('hide_edit_author_modal', function(e) {
            $('#edit_author_modal').modal('hide')

        })
        window.addEventListener("deleteAuthor", function(event) {
            swal.fire({
                title: event.detail.title,
                imagewidth: 48,
                imageHeight: 48,
                html: event.detail.html,
                showCloseButton: true,
                showCancelButton: true,
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Yes,delete',
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                width: 300,
                allowOutsideClick: false
            }).then(function(result) {
                if (result.value) {
                    Livewire.emit("deleteAuthorAction", event.detail.id);
                }
            })
        })
    </script>
@endpush
