<div>
    {{-- Success is as dangerous as failure. --}}
    @if (Session::get('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif
    @if (Session::has('failure'))
        <div class="alert alert-danger">
            {{ Session::get('failure') }}

        </div>
    @else
    @endif
    <form class="card card-md" method="post" wire:submit.prevent="forgotHandler()">
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Forgot password</h2>
            <p class="text-muted mb-4">Enter your email address and your password will be reset and emailed to you.
            </p>
            <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="email" wire:model="email" class="form-control" placeholder="Enter email">
                <span class="text-danger">
                    @error('email')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="form-footer">
                <button class="btn btn-primary w-100" type="submit">
                    <!-- Download SVG icon from http://tabler-icons.io/i/mail -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <rect x="3" y="5" width="18" height="14" rx="2" />
                        <polyline points="3 7 12 13 21 7" />
                    </svg>
                    Send me reset password link
                </button>
            </div>
        </div>
    </form>
</div>
<script>
    window.addEventListener('redirectFail', (e) => {
        let seconds = 3;
        const a = '<a href="/author/login"">redirect</a>';
        document.querySelector('.alert.alert-danger').innerHTML =
            `There something went wrong, ${a} in <span id="second"> ${seconds} </span>`
        setInterval(() => {
            document.querySelector('span#second').innerHTML = seconds--;
            console.log(document.querySelector('span#second'))
            if (seconds < 0) {
                window.location.href = "/author/login"
            }
        }, 1000)
    })
</script>
