<div>
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h3 class="fw-bold mb-3">Kelola Kategori Motor</h3>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">{{ $isEditing ? 'Edit' : 'Tambah' }} Kategori Motor</h5>
                    </div>
                    <div class="card-body">
                        <form wire:submit="save">
                            <div class="mb-3">
                                <label for="nama_kategori" class="form-label">Nama Kategori</label>
                                <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" 
                                    wire:model="nama_kategori" id="nama_kategori">
                                @error('nama_kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">
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
                        <h5 class="card-title">Daftar Kategori Motor</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Kategori</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($kategoris as $kategori)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $kategori->nama_kategori }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-warning" 
                                                    wire:click="edit({{ $kategori->id }})">
                                                    Edit
                                                </button>
                                                <button class="btn btn-sm btn-danger" 
                                                    wire:click="delete({{ $kategori->id }})"
                                                    onclick="return confirm('Yakin ingin menghapus?')">
                                                    Hapus
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $kategoris->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @script
    <script>
        Livewire.on('alert', ({type, message}) => {
            alert(message);
        });
    </script>
    @endscript
</div>
