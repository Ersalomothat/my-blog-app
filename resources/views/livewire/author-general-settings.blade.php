<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <form wire:submit.prevent="updateGeneralSettings()" method="post">
        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="" class="form-label">Blog Name</label>
                    <input type="text" class="form-control" wire:model="blog_name" placeholder="enter blog name">
                    <span class="text-danger">
                        @error('blog_name')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Blog Email</label>
                    <input type="text" class="form-control" placeholder="enter blog name" wire:model="blog_email">
                    <span class="text-danger">
                        @error('blog_email')
                            {{ $message }}
                        @enderror
                    </span>

                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Blog Desc</label>
                    <textarea wire:model="blog_desc" id="" class="form-control" placeholder="Enter blog name" cols="3" rows="3"></textarea>
                    <span class="text-danger">
                        @error('blog_desc')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <button class="btn btn-primary">save changes</button>
            </div>
        </div>
    </form>
</div>
