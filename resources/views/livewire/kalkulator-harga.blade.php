<div>
    <div class="row">
        <div class="card p-5 mx-auto" style="width: 75%">
            <div class="mb-3">
                <h4 class="fw-bold">Hitung Harga dan Estimasi Waktu Repaint Motor</h4>
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
                            value="4" id="velg" @if (!in_array($selectedTipe, $availableVelgTypes)) disabled @endif>
                        <label class="form-check-label" for="velg">Velg</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" wire:model.live="selectedRepaints"
                            value="5" id="knalpot" @if (!in_array($selectedTipe, $availableKnalpotTypes)) disabled @endif>
                        <label class="form-check-label" for="knalpot">Knalpot</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" wire:model.live="selectedRepaints"
                            value="6" id="cvt" @if (!in_array($selectedTipe, $availableCVTTypes)) disabled @endif>
                        <label class="form-check-label" for="cvt">CVT</label>
                    </div>
                </div>
            @endif

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

            <a href="{{ route('reservasi') }}" class="btn btn-warning fw-bold @if (!$selectedKategori || !$selectedTipe || empty($selectedRepaints)) disabled @endif" >Reservasi</a>

            {{-- <button type="button" class="btn btn-primary fw-bold" data-bs-target="#modalPembayaran"
                data-bs-toggle="modal" @if (!$reservasiTersimpan) disabled @endif>
                Lanjutkan ke Pembayaran
            </button> --}}

        </div>

    </div>
</div>
