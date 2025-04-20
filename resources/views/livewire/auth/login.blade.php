    <div class="card mt-4 p-3" style="width: 25rem; margin: 0 auto;">
        <div class="card-body">
            <h2 class="text-center fw-bold">Login</h2>
            <form wire:submit.prevent="login">
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" wire:model="email" class="form-control" placeholder="hypeproject@example.com">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" wire:model="password" class="form-control" placeholder="********">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
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
