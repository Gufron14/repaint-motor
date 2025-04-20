<div class="container-fluid">
    <h3 class="fw-bold mb-3">Daftar Jenis Repaint</h3>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ $isEditing ? 'Edit' : 'Tambah' }} Jenis Repaint</h5>
                </div>
                <div class="card-body">
                    <form wire:submit="save">
                        <div class="mb-3">
                            <label for="nama_repaint" class="form-label">Nama Repaint</label>
                            <input type="text" class="form-control @error('nama_repaint') is-invalid @enderror" 
                                wire:model="nama_repaint" id="nama_repaint">
                            @error('nama_repaint')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
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
                    <h5 class="card-title">Daftar Jenis Repaint</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Repaint</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jenisRepaints as $index => $jenisRepaint)
                                    <tr>
                                        <td>{{ $jenisRepaints->firstItem() + $index }}</td>
                                        <td>{{ $jenisRepaint->nama_repaint }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning" 
                                                wire:click="edit({{ $jenisRepaint->id }})">
                                                Edit
                                            </button>
                                            <button class="btn btn-sm btn-danger" 
                                                wire:click="delete({{ $jenisRepaint->id }})"
                                                onclick="return confirm('Yakin ingin menghapus data ini?')">
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
                        {{ $jenisRepaints->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
