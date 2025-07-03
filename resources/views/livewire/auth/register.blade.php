<div class="card border-0 shadow-sm" style="width: 50rem; margin: 0 auto;">
    <div class="card-body p-5">
        <h2 class="text-center fw-bold">Register</h2>
        <form wire:submit.prevent="register">
            <div class="row mt-5">
                <!-- Kolom Kanan: Identitas User -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" wire:model="name" class="form-control">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No. Telepon</label>
                        <input type="number" wire:model="phone" class="form-control">
                        @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat Lengkap</label>
                        <input type="text" wire:model="adress" class="form-control">
                        @error('adress')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Rekening/E-Wallet</label>
                        <input type="text" wire:model="no_rek" class="form-control"
                            placeholder="contoh: BCA - 1234567890">
                        @error('no_rek')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <!-- Kolom Kanan: Akun -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" wire:model="username" wire:input='normalizeUsername' class="form-control">
                        <small class="text-secondary">Kombinasi huruf kecil dan angka tanpa spasi</small><br>
                        @error('username')
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
                    <div class="d-flex mt-5 align-items-center">
                        <div class="col">
                            <button type="submit" class="btn btn-primary fw-bold">Buat Akun</button>
                        </div>
                        <div class="">
                            <small>Sudah punya akun?
                                <a href="{{ route('login') }}" class="text-decoration-none">Login</a>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
