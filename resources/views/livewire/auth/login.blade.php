    <div class="card mt-4 p-3" style="width: 25rem; margin: 0 auto;">
        <div class="card-body">
            <h2 class="text-center fw-bold">Login</h2>
            <form wire:submit.prevent="login">
                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" wire:model="username" wire:input='normalizeUsername' class="form-control @error('username') is-invalid @enderror">
                    @error('username')
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle-fill me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" wire:model="password" class="form-control @error('password') is-invalid @enderror" placeholder="********">
                    @error('password')
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle-fill me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary fw-bold">Login</button>
                    </div>
                    <div class="col align-self-center">
                        <small>Belum punya akun?
                            <a href="{{ route('register') }}">Buat Akun</a>
                        </small>
                    </div>
                </div>

            </form>
        </div>
    </div>
