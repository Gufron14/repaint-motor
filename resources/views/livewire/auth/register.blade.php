<div class="card" style="width: 25rem; margin: 0 auto;">
    <div class="card-body">
        <h2 class="text-center fw-bold">Register</h2>
        <form wire:submit.prevent="register">
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" wire:model="name" class="form-control">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label>No. Telepon</label>
                <input type="text" wire:model="phone" class="form-control">
                @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" wire:model="email" class="form-control">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" wire:model="password" class="form-control">
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="row">
                <div class="col">
                    <button type="submit" class="btn btn-primary fw-bold">Buat Akun</button>
                </div>

                <div class="col align-self-center">
                    <small>Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-decoration-none">Login</a>
                    </small>
                </div>
            </div>
        </form>
    </div>
</div>
