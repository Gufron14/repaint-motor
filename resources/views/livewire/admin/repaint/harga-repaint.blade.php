<div class="container-fluid">
    <h3 class="fw-bold mb-3">Kelola Harga Repaint</h3>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Daftar Harga Repaint</h4>
                        </div>
                        <div class="col-md-6 text-end">
                            <button wire:click="create()" class="btn btn-primary">Tambah Harga</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <input wire:model.live="search" type="text" class="form-control" placeholder="Cari nama motor...">
                        </div>
                        <div class="col-md-4">
                            <select wire:model.live="kategori_id" class="form-select">
                                <option value="">Semua Kategori</option>
                                @foreach($kategoriMotors as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Motor</th>
                                    <th>Kategori</th>
                                    <th>Jenis Repaint</th>
                                    <th>Harga</th>
                                    <th>Estimasi Waktu</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $currentMotor = null;
                                    $rowspanCount = 0;
                                    $currentPage = $motorRepaints->currentPage();
                                    $perPage = $motorRepaints->perPage();
                                    $currentNumber = ($currentPage - 1) * $perPage;
                                @endphp
                                @foreach($motorRepaints as $index => $motorRepaint)
                                    @if($currentMotor !== $motorRepaint->tipe_motor_id)
                                        @php
                                            $currentMotor = $motorRepaint->tipe_motor_id;
                                            $rowspanCount = $motorRepaints->where('tipe_motor_id', $currentMotor)->count();
                                            $currentNumber++;
                                        @endphp
                                        <tr>
                                            <td rowspan="{{ $rowspanCount }}" class="align-middle text-center">{{ $currentNumber }}</td>
                                            <td rowspan="{{ $rowspanCount }}" class="align-middle">{{ $motorRepaint->tipeMotor->nama_motor }}</td>
                                            <td rowspan="{{ $rowspanCount }}" class="align-middle">{{ $motorRepaint->tipeMotor->kategoriMotor->nama_kategori }}</td>
                                            <td>{{ $motorRepaint->jenisRepaint->nama_repaint }}</td>
                                            <td>Rp {{ number_format($motorRepaint->harga, 0, ',', '.') }}</td>
                                            <td>{{ $motorRepaint->estimasi_waktu }} hari</td>
                                            <td>
                                                <button wire:click="edit({{ $motorRepaint->id }})" class="btn btn-sm btn-info">Edit</button>
                                                <button wire:click="delete({{ $motorRepaint->id }})" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td>{{ $motorRepaint->jenisRepaint->nama_repaint }}</td>
                                            <td>Rp {{ number_format($motorRepaint->harga, 0, ',', '.') }}</td>
                                            <td>{{ $motorRepaint->estimasi_waktu }} hari</td>
                                            <td>
                                                <button wire:click="edit({{ $motorRepaint->id }})" class="btn btn-sm btn-info">Edit</button>
                                                <button wire:click="delete({{ $motorRepaint->id }})" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    
                    
                    <div class="d-flex justify-content-end">
                        {{ $motorRepaints->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($isOpen)
    <div class="modal show d-block" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $motorRepaintId ? 'Edit Harga' : 'Tambah Harga' }}</h5>
                    <button wire:click="closeModal()" type="button" class="btn-close"></button>
                </div>
                <div class="modal-body">
                    @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Tipe Motor</label>
                            <select wire:model="tipe_motor_id" class="form-select">
                                <option value="">Pilih Motor</option>
                                @foreach($tipeMotors as $motor)
                                    <option value="{{ $motor->id }}">{{ $motor->nama_motor }}</option>
                                @endforeach
                            </select>
                            @error('tipe_motor_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Repaint</label>
                            <select wire:model="jenis_repaint_id" class="form-select">
                                <option value="">Pilih Jenis Repaint</option>
                                @foreach($availableJenisRepaints ?? $jenisRepaints as $repaint)
                                    <option value="{{ $repaint->id }}">{{ $repaint->nama_repaint }}</option>
                                @endforeach
                            </select>
                            
                            {{-- @error('jenis_repaint_id') <span class="text-danger">{{ $message }}</span> @enderror --}}
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga</label>
                            <input type="number" wire:model="harga" class="form-control">
                            {{-- @error('harga') <span class="text-danger">{{ $message }}</span> @enderror --}}
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Estimasi Waktu (Hari)</label>
                            <input type="number" wire:model="estimasi_waktu" class="form-control">
                            {{-- @error('estimasi_waktu') <span class="text-danger">{{ $message }}</span> @enderror --}}
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button wire:click="closeModal()" type="button" class="btn btn-secondary">Tutup</button>
                    <button wire:click="store()" type="button" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    @endif
</div>
