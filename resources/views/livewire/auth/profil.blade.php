<div>
    <div class="card" style="width: 25rem; margin: 0 auto;">
        <div class="card-body">
            @if (session('success'))
            <div class="alert alert-success">
                <i class="bi bi-check-circle me-2"></i>  {{ session('success') }}
            </div>
        @endif
            <h3 class="card-title fw-bold">Profil</h3>
            <form wire:submit.prevent="updateProfile">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" id="name" wire:model="name" class="form-control" required>
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" wire:model="email" class="form-control" required>
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                
                <div class="mb-3">
                    <label for="phone" class="form-label">No. Telp</label>
                    <input type="text" id="phone" wire:model="phone" class="form-control" required>
                    @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                
                <button type="submit" class="btn btn-primary fw-bold">Simpan Perubahan</button>
            </form>
        </div>
    </div>
    
</div>
