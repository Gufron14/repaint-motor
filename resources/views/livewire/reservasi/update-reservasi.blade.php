<div>
    <h5 class="text-center fw-bold mb-3">
        Tambah Komponen Repaint
    </h5>
    <div class="card mb-5">
        <div class="card-body p-5">
            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <label for="" class="text-uppercase fw-bold text-secondary mb-2">Tipe Motor</label>
            <div class="d-flex gap-3 mb-3">
                <div class="col">
                    <label for="" class="form-label text-secondary">Kategori Motor</label>
                    <select class="form-select mb-3" wire:model.live="selectedKategori">
                        <option value="">-- Pilih Kategori Motor --</option>
                        @foreach ($kategoriMotor as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col">
                    <label for="" class="form-label text-secondary">Tipe Motor</label>
                    <select class="form-select mb-3" wire:model.live="selectedTipe">
                        <option value="">-- Pilih Tipe Motor --</option>
                        @foreach ($tipeMotor as $tipe)
                            <option value="{{ $tipe->id }}">{{ $tipe->nama_motor }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label class="form-label text-secondary">Nomor Polisi Motor:</label>
                    <input type="text" wire:model='nomor_polisi' class="form-control"
                        placeholder="Masukkan plat nomor" style="text-transform: uppercase;"
                        oninput="this.value = this.value.toUpperCase()">
                </div>
            </div>
            <label for="" class="text-uppercase fw-bold text-secondary mb-2">Jenis Repaint</label>

            <div class="">
                <label class="form-label text-secondary">Pilih Jenis Repaint:</label>
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

                @if (in_array('1', $selectedRepaints) ||
                        in_array('2', $selectedRepaints) ||
                        in_array('3', $selectedRepaints) ||
                        in_array('4', $selectedRepaints) ||
                        in_array('5', $selectedRepaints) ||
                        in_array('6', $selectedRepaints))
                    <label for="" class="text-uppercase fw-bold text-secondary mb-1 text-center">Unggah Foto
                        Komponen</label>
                @endif

                <div class="d-flex gap-3 mb-3">
                    @if (in_array('1', $selectedRepaints) || in_array('2', $selectedRepaints) || in_array('3', $selectedRepaints))
                        <div>
                            <label for="" class="form-label text-secondary">Foto Motor</label>
                            <input type="file" wire:model='foto_motor' class="form-control">
                            <div wire:loading wire:target="foto_motor" class="text-info small mt-1">
                                <span class="spinner-border spinner-border-sm"></span> Mengunggah...
                            </div>
                            @if ($foto_motor)
                                <div class="mt-2">
                                    <img src="{{ $foto_motor->temporaryUrl() }}" alt="Preview Foto Motor"
                                        class="img-thumbnail" style="max-width: 150px;">
                                </div>
                            @elseif ($existing_foto_motor)
                                <div class="mt-2">
                                    <p class="small text-muted">Foto saat ini:</p>
                                    <img src="{{ Storage::url($existing_foto_motor) }}" alt="Foto Motor Saat Ini"
                                        class="img-thumbnail" style="max-width: 150px;">
                                </div>
                            @endif
                        </div>
                    @endif
                    @if (in_array('4', $selectedRepaints))
                        <div>
                            <label for="foto_velg" class="form-label text-secondary">Foto Velg:</label>
                            <input type="file" wire:model='foto_velg' class="form-control">
                            <div wire:loading wire:target="foto_velg" class="text-info small mt-1">
                                <span class="spinner-border spinner-border-sm"></span> Mengunggah...
                            </div>
                            @if ($foto_velg)
                                <div class="mt-2">
                                    <img src="{{ $foto_velg->temporaryUrl() }}" alt="Preview Foto Velg"
                                        class="img-thumbnail" style="max-width: 150px;">
                                </div>
                            @elseif ($existing_foto_velg)
                                <div class="mt-2">
                                    <p class="small text-muted">Foto saat ini:</p>
                                    <img src="{{ Storage::url($existing_foto_velg) }}" alt="Foto Velg Saat Ini"
                                        class="img-thumbnail" style="max-width: 150px;">
                                </div>
                            @endif
                        </div>
                    @endif
                    @if (in_array('5', $selectedRepaints))
                        <div>
                            <label for="foto_knalpot" class="form-label text-secondary">Foto Knalpot:</label>
                            <input type="file" wire:model='foto_knalpot' class="form-control">
                            <div wire:loading wire:target="foto_knalpot" class="text-info small mt-1">
                                <span class="spinner-border spinner-border-sm"></span> Mengunggah...
                            </div>
                            @if ($foto_knalpot)
                                <div class="mt-2">
                                    <img src="{{ $foto_knalpot->temporaryUrl() }}" alt="Preview Foto Knalpot"
                                        class="img-thumbnail" style="max-width: 150px;">
                                </div>
                            @elseif ($existing_foto_knalpot)
                                <div class="mt-2">
                                    <p class="small text-muted">Foto saat ini:</p>
                                    <img src="{{ Storage::url($existing_foto_knalpot) }}" alt="Foto Knalpot Saat Ini"
                                        class="img-thumbnail" style="max-width: 150px;">
                                </div>
                            @endif
                        </div>
                    @endif
                    @if (in_array('6', $selectedRepaints))
                        <div>
                            <label for="foto_cvt" class="form-label text-secondary">Foto CVT:</label>
                            <input type="file" wire:model='foto_cvt' class="form-control">
                            <div wire:loading wire:target="foto_cvt" class="text-info small mt-1">
                                <span class="spinner-border spinner-border-sm"></span> Mengunggah...
                            </div>
                            @if ($foto_cvt)
                                <div class="mt-2">
                                    <img src="{{ $foto_cvt->temporaryUrl() }}" alt="Preview Foto CVT"
                                        class="img-thumbnail" style="max-width: 150px;">
                                </div>
                            @elseif ($existing_foto_cvt)
                                <div class="mt-2">
                                    <p class="small text-muted">Foto saat ini:</p>
                                    <img src="{{ Storage::url($existing_foto_cvt) }}" alt="Foto CVT Saat Ini"
                                        class="img-thumbnail" style="max-width: 150px;">
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                @if (in_array('1', $selectedRepaints) ||
                        in_array('2', $selectedRepaints) ||
                        in_array('3', $selectedRepaints) ||
                        in_array('4', $selectedRepaints) ||
                        in_array('5', $selectedRepaints) ||
                        in_array('6', $selectedRepaints))
                    <label for="" class="text-uppercase fw-bold text-secondary mb-3 text-center">Pilih Warna
                        Repaint</label>
                @endif

                <div class="d-flex gap-5 mb-3">
                    @if (in_array('1', $selectedRepaints) || in_array('2', $selectedRepaints) || in_array('3', $selectedRepaints))
                        <div class="d-flex gap-3">
                            <label for="warna_body" class="form-label text-secondary">Warna Body:</label>
                            <input type="color" name="warna_body" id="warna_body" wire:model='warna_body'
                                value="{{ $warna_body ?? '#CCCCCC' }}" title="Pilih Warna">
                        </div>
                    @endif
                    @if (in_array('4', $selectedRepaints))
                        <div class="d-flex gap-3">
                            <label for="warna_velg" class="form-label text-secondary">Warna Velg:</label>
                            <input type="color" name="warna_velg" id="warna_velg" wire:model='warna_velg'
                                value="{{ $warna_velg ?? '#CCCCCC' }}" title="Pilih Warna">
                        </div>
                    @endif
                    @if (in_array('5', $selectedRepaints))
                        <div class="d-flex gap-3">
                            <label for="warna_knalpot" class="form-label text-secondary">Warna Knalpot:</label>
                            <input type="color" name="warna_knalpot" id="warna_knalpot" wire:model='warna_knalpot'
                                value="{{ $warna_knalpot ?? '#CCCCCC' }}" title="Pilih Warna">
                        </div>
                    @endif
                    @if (in_array('6', $selectedRepaints))
                        <div class="d-flex gap-3">
                            <label for="warna_cvt" class="form-label text-secondary">Warna CVT:</label>
                            <input type="color" name="warna_cvt" id="warna_cvt" wire:model='warna_cvt'
                                value="{{ $warna_cvt ?? '#CCCCCC' }}" title="Pilih Warna">
                        </div>
                    @endif
                </div>
                @if ($selectedRepaints)
                    <p class="fst-italic text-danger"><i class="bi bi-info-circle me-2"></i>Untuk keakuratan
                        warna,
                        tulis warna
                        lengkap pada Catatan.</p>
                @endif

                <div class="col">
                    <label for="catatan" class="form-label fw-bold text-uppercase text-secondary">Catatan</label>
                    <textarea name="" id="" class="form-control" wire:model='catatan'
                        placeholder="Tinggalkan Catatan anda untuk kami">{{ $catatan }}</textarea>
                </div>

                <hr class="my-4">

                <div class="row mt-4 gap-3 mb-5">
                    <div class="col">
                        <div class="card border-warning">
                            <div class="card-body text-warning">
                                <label class="form-label text-secondary fw-bold text-uppercase">DP 10%:</label>
                                <h3 class="fw-bold">Rp{{ number_format($dpHarga, 0, ',', '.') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card border-success">
                            <div class="card-body text-success">
                                <label class="form-label text-secondary fw-bold text-uppercase">Total Harga:</label>
                                <h3 class="fw-bold">Rp{{ number_format($totalHarga, 0, ',', '.') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card border-info">
                            <div class="card-body text-info">
                                <label class="form-label text-secondary fw-bold text-uppercase">Estimasi
                                    Pengerjaan:</label>
                                <h3 class="fw-bold">{{ $estimasiWaktu }} Hari</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-3">
                    <button type="button" class="btn btn-secondary fw-bold flex-fill"
                        onclick="window.history.back()">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </button>
                    <button type="button" class="btn btn-primary fw-bold flex-fill" wire:click="updateReservasi"
                        @if (!$selectedKategori || !$selectedTipe || empty($selectedRepaints)) disabled @endif>
                        <i class="bi bi-check-circle me-2"></i>Update Reservasi
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Pembayaran Tambahan --}}
    <div wire:ignore.self class="modal fade" id="modalPembayaranTambahan" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @if ($existingPayment)
                            Pembayaran Tambahan
                        @else
                            Upload Bukti Pembayaran DP
                        @endif
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        wire:click="closePaymentModal"></button>
                </div>
                <div class="modal-body">
                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif

                    @if (session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="mb-3">
                        @if ($existingPayment)
                            <p class="fw-bold h4">Pembayaran Tambahan:
                                Rp{{ number_format($additionalPayment, 0, ',', '.') }}</p>
                            <p>Anda telah melakukan pembayaran DP sebelumnya. Silakan bayar selisih untuk komponen
                                tambahan:</p>
                            <div class="alert alert-light">
                                <small>
                                    <strong>Total Harga Sebelumnya:</strong>
                                    Rp{{ number_format($originalTotalHarga, 0, ',', '.') }}<br>
                                    <strong>Total Harga Baru:</strong>
                                    Rp{{ number_format($totalHarga, 0, ',', '.') }}<br>
                                    <strong>Selisih yang harus dibayar:</strong>
                                    Rp{{ number_format($additionalPayment, 0, ',', '.') }}
                                </small>
                            </div>
                        @else
                            <p class="fw-bold h4">Total Pembayaran DP 10%:
                                Rp{{ number_format($additionalPayment, 0, ',', '.') }}</p>
                            <p>Silahkan transfer ke rekening:</p>
                        @endif
                        <ul>
                            <li class="fw-bold">BCA: 1234567890 (A/N Hype Custom Project)</li>
                        </ul>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary">Upload Bukti Transfer</label>
                        <input type="file" class="form-control @error('bukti_pembayaran') is-invalid @enderror"
                            wire:model="bukti_pembayaran">
                        @error('bukti_pembayaran')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        wire:click="closePaymentModal">Batal</button>
                    <button type="button" class="btn btn-primary fw-bold" wire:click="submitAdditionalPayment"
                        @if ($additionalPayment <= 0) disabled @endif>
                        Kirim Pembayaran
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .form-check-input:disabled {
            opacity: 0.5;
        }

        .form-check-label {
            cursor: pointer;
        }

        .form-check-input:disabled+.form-check-label {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .img-thumbnail {
            border: 2px solid #dee2e6;
            border-radius: 8px;
        }

        .alert {
            border-radius: 8px;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .btn {
            border-radius: 8px;
            padding: 12px 24px;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            // Auto-hide alerts after 5 seconds
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);

            // Confirm before leaving page if form has changes
            let formChanged = false;

            // Track form changes
            document.addEventListener('input', () => {
                formChanged = true;
            });

            document.addEventListener('change', () => {
                formChanged = true;
            });

            // Reset form changed flag after successful update
            @this.on('reservasi-updated', () => {
                formChanged = false;
            });

            // Warn before leaving if form has unsaved changes
            window.addEventListener('beforeunload', (e) => {
                if (formChanged) {
                    e.preventDefault();
                    e.returnValue =
                        'Anda memiliki perubahan yang belum disimpan. Yakin ingin meninggalkan halaman?';
                }
            });

                    // Handle payment modal
        @this.on('openPaymentModal', () => {
            const modal = new bootstrap.Modal(document.getElementById('modalPembayaranTambahan'));
            modal.show();
        });
        });
    </script>
@endpush
