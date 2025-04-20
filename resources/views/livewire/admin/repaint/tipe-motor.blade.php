<div class="container-fluid">
    <h3 class="fw-bold mb-3">Daftar Tipe Motor</h3>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ $isEditing ? 'Edit' : 'Tambah' }} Tipe Motor</h5>
                </div>
                <div class="card-body">
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif


                    <form wire:submit="save">
                        <div class="mb-3">
                            <label class="form-label">Nama Motor</label>
                            <input type="text" class="form-control @error('nama_motor') is-invalid @enderror" 
                                wire:model="nama_motor">
                            @error('nama_motor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategori Motor</label>
                            <select class="form-select @error('kategori_motor_id') is-invalid @enderror" 
                                wire:model="kategori_motor_id">
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoriMotors as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                            @error('kategori_motor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary right">
                            {{ $isEditing ? 'Update' : 'Simpan' }}
                        </button>
                        @if($isEditing)
                            <button type="button" class="btn btn-secondary" wire:click="$reset">
                                Batal
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Daftar Tipe Motor</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <input type="text" 
                                   wire:model.live="search" 
                                   class="form-control" 
                                   placeholder="Cari nama motor atau kategori...">
                        </div>
                        <div class="col-md-4">
                            <select wire:model.live="selectedKategori" class="form-select">
                                <option value="">Semua Kategori</option>
                                @foreach($kategoriMotors as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Motor</th>
                                    <th>Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tipeMotors as $index => $tipe)
                                    <tr>
                                        <td>{{ $tipeMotors->firstItem() + $index }}</td>
                                        <td>{{ $tipe->nama_motor }}</td>
                                        <td>{{ $tipe->kategoriMotor->nama_kategori }}</td>
                                        <td>
                                            <button wire:click="edit({{ $tipe->id }})" 
                                                class="btn btn-sm btn-warning">
                                                Edit
                                            </button>
                                            <button wire:click="delete({{ $tipe->id }})" 
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <nav aria-label="Page navigation">
                        {{ $tipeMotors->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
