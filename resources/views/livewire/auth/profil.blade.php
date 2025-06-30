<div>
    <div class="card" style="width: 50rem; margin: 0 auto;">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif
            <h3 class="card-title fw-bold">Profil</h3>
            <form wire:submit.prevent="updateProfile">
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" id="name" wire:model="name" class="form-control" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label for="phone" class="form-label">No. Telp</label>
                            <input type="text" id="phone" wire:model="phone" class="form-control" required>
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" wire:model="username" class="form-control" required>
                            @error('username')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" id="password" wire:model="password" class="form-control"
                                autocomplete="new-password">
                            <small class="text-secondary">Kosongkan jika tidak ingin mengganti password</small>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" id="password_confirmation" wire:model="password_confirmation"
                                class="form-control" autocomplete="new-password">
                            @error('password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>


                <button type="submit" class="btn btn-primary fw-bold">Simpan Perubahan</button>
            </form>
        </div>
    </div>

</div>
