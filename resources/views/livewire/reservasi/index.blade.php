<div>
    <div class="row">
        <div class="card p-5">
            <div class="mb-3">
                <h3 class="fw-bold">Formulir Reservasi</h3>
            </div>

            <select class="form-select mb-3" wire:model.live="selectedKategori">
                <option value="">-- Pilih Kategori Motor --</option>
                @foreach ($kategoriMotor as $kategori)
                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                @endforeach
            </select>

            @if ($selectedKategori)
                <select class="form-select mb-3" wire:model.live="selectedTipe">
                    <option value="">-- Pilih Tipe Motor --</option>
                    @foreach ($tipeMotor as $tipe)
                        <option value="{{ $tipe->id }}">{{ $tipe->nama_motor }}</option>
                    @endforeach
                </select>
            @endif

            @if ($selectedTipe)
                <label class="form-label">Pilih Jenis Repaint:</label>
                <div class="mb-3 d-flex gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" wire:model.live="selectedRepaints"
                            value="1" id="fullBody" @if (!in_array($selectedTipe, $availableFullBodyTypes)) disabled @endif>
                        <label class="form-check-label" for="fullBody">Full Body</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" wire:model.live="selectedRepaints"
                            value="2" id="bodyHalus" @if (!in_array($selectedTipe, $availableBodyHalusTypes)) disabled @endif>
                        <label class="form-check-label" for="bodyHalus">Body Halus</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" wire:model.live="selectedRepaints"
                            value="3" id="bodyKasar" @if (!in_array($selectedTipe, $availableBodyKasarTypes)) disabled @endif>
                        <label class="form-check-label" for="bodyKasar">Body Kasar</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" wire:model.live="selectedRepaints"
                            value="4" id="velg">
                        <label class="form-check-label" for="velg">Velg</label>
                    </div>
                </div>
            @endif

            @if ($selectedTipe)
            <div class="d-flex gap-5">
                @if (in_array('1', $selectedRepaints) || in_array('2', $selectedRepaints) || in_array('3', $selectedRepaints))
                    <div class="d-flex gap-3">
                        <label for="warna_body" class="form-label">Pilih Warna Body:</label>
                        <input type="color" name="warna_body" id="warna_body" wire:model='warna_body' value="#CCCCCC"
                            title="Pilih Warna">
                    </div>
                @endif

                @if (in_array('4', $selectedRepaints))
                    <div class="d-flex gap-3">
                        <label for="warna_velg" class="form-label">Pilih Warna Velg:</label>
                        <input type="color" name="warna_velg" id="warna_velg" wire:model='warna_velg' value="#CCCCCC"
                            title="Pilih Warna">
                    </div>
                @endif
            </div>
            <p class="fst-italic text-danger"><i class="bi bi-info-circle me-2"></i>Untuk keakuratan warna, tulis warna lengkap pada Catatan.</p>
            @endif

            <div>
                <label for="catatan" class="form-label">Catatan:</label>
                <textarea name="" id="" class="form-control" wire:model='catatan'
                    placeholder="Tinggalkan Catatan anda untuk kami"></textarea>
            </div>

            <div class="row mt-4 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Total Harga</label>
                    <h3 class="fw-bold">Rp. {{ number_format($totalHarga, 0, ',', '.') }}</h3>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Estimasi Waktu Pengerjaan</label>
                    <h3 class="fw-bold">{{ $estimasiWaktu }} Hari</h3>
                </div>
            </div>

            <button type="button" class="btn btn-success fw-bold" wire:click="reservasi" data-bs-toggle="modal"
                data-bs-target="#modalPembayaran" @if (!$selectedKategori || !$selectedTipe || empty($selectedRepaints)) disabled @endif>
                Reservasi Sekarang
            </button>


            {{-- <button type="button" class="btn btn-primary fw-bold" data-bs-target="#modalPembayaran"
                data-bs-toggle="modal" @if (!$reservasiTersimpan) disabled @endif>
                Lanjutkan ke Pembayaran
            </button> --}}

        </div>

    </div>

    {{-- modal Pembayaran --}}
    <div wire:ignore.self class="modal fade" id="modalPembayaran" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Bukti Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    <div class="mb-3">
                        <p class="fw-bold h4">Total Pembayaran: Rp. {{ number_format($totalHarga, 0, ',', '.') }}</p>
                        <p>Silahkan transfer ke rekening:</p>
                        <ul>
                            <li>BCA: 1234567890 (A/N Hype Custom Project)</li>
                        </ul>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Upload Bukti Transfer</label>
                        <input type="file" class="form-control @error('bukti_pembayaran') is-invalid @enderror"
                            wire:model="bukti_pembayaran">
                        @error('bukti_pembayaran')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-target="#staticBackdrop"
                        data-bs-toggle="modal" wire:click="handleModalClose">Batal</button>
                    <button type="button" class="btn btn-primary fw-bold" wire:click="submitPembayaran">Kirim</button>
                </div>
            </div>
        </div>
    </div>
</div>
