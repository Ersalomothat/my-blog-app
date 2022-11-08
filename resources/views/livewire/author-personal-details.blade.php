<div>
    {{-- Be like water. --}}
    <form method="post" class="" wire:submit.prevent="updateDetails()">
        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control" name="example-text-input" placeholder="nama"
                        wire:model="name">
                    <span class="text-danger">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">username</label>
                    <input type="text" class="form-control" name="example-text-input" placeholder="username"
                        wire:model="username">
                    <span class="text-danger">
                        @error('username')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control" name="example-text-input" placeholder="email" disabled
                        wire:model="email">
                    <span class="text-danger">
                        @error('email')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Biography <span class="form-label-description">56/100</span></label>
            <textarea class="form-control" name="example-textarea-input" rows="6" placeholder="Biography.."
                wire:model="biography">

            </textarea>
            <span class="text-danger">
                @error('biography')
                    {{ $message }}
                @enderror
            </span>
        </div>
        <button type="submit" class="btn btn-primary">save changes</button>
    </form>
</div>
