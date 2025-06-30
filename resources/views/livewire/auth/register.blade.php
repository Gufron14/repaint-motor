<div class="card" style="width: 25rem; margin: 0 auto;">
    <div class="card-body">
        <h2 class="text-center fw-bold">Register</h2>
        <form wire:submit.prevent="register">
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" wire:model="name" class="form-control">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            {{-- generate username otomatis dari Nama--}}
            <div class="mb-3">
                <label class="form-label">Username </label> <small class="text-secondary">(Gunakan untuk login)</small>
                <input type="text" wire:model="username" wire:input='normalizeUsername' class="form-control">
                <small class="text-secondary">Huruf kecil dan tanpa spasi!</small><br>
                @error('username')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">No. Telepon</label>
                <input type="number" wire:model="phone" class="form-control">
                @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
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
