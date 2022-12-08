<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <form method="POST" wire:submit.prevent='updateBlogSocialMedia()'>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Facebook</label>
                    <input type="text" class="form-control" placeholder="Facebook page Url" wire:model='facebook_url'>
                    <span class="text-danger">
                        @error('facebook_url')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Instagram</label>
                    <input type="text" class="form-control" placeholder="Instagram Url" wire:model='instagram_url'>
                    <span class="text-danger">
                        @error('instagram_url')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">YouTube</label>
                    <input type="text" class="form-control" placeholder="YouTube channel Url"
                        wire:model='youtube_url'>
                    <span class="text-danger">
                        @error('youtube_url')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">LinkeIn</label>
                    <input type="text" class="form-control" placeholder="LinkeIn Url" wire:model='linkedin_url'>
                    <span class="text-danger">
                        @error('linkedin_url')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
