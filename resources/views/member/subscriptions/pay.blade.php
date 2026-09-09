@extends('member.layouts.member')

@section('title', 'Upload Bukti Pembayaran')

@section('content')
    <h3 class="mb-4">Upload Bukti Pembayaran</h3>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <h5>{{ $plan->name }}</h5>
                    <p class="text-muted">{{ $plan->description }}</p>
                    <h3 class="text-danger">Rp {{ number_format($plan->price, 0, ',', '.') }}</h3>
                    <p class="text-muted mb-0">Masa aktif: {{ $plan->days }} hari</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card stat-card">
                <div class="card-body">
                    <form method="POST" action="{{ route('member.subscriptions.store', $plan->id) }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Metode Pembayaran</label>
                            <select name="payment_method_id" id="payment-method-select"
                                class="form-select @error('payment_method_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Metode --</option>
                                @foreach ($methods as $method)
                                    <option value="{{ $method->id }}" {{ old('payment_method_id') == $method->id ? 'selected' : '' }}>
                                        {{ $method->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('payment_method_id')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>

{{-- Info rekening / nama per metode (muncul saat dipilih) --}}
                        <div class="mb-3">
                            <?php foreach ($methods as $method): ?>
                                <div class="payment-method-info d-none alert alert-light border"
                                    id="method-info-{{ $method->id }}">
                                    <div class="d-flex justify-content-between">
                                        <strong>{{ $method->name }}</strong>
                                    </div>
                                    <?php if ($method->account_name): ?>
                                        <div class="mt-1"><small class="text-muted">Atas Nama:</small>
                                            <strong>{{ $method->account_name }}</strong></div>
                                    <?php endif; ?>
                                    <?php if ($method->account_number): ?>
                                        <div class="mt-1"><small class="text-muted">Nomor / Akun:</small>
                                            <strong>{{ $method->account_number }}</strong></div>
                                    <?php endif; ?>
                                    <?php if ($method->description): ?>
                                        <div class="mt-2 p-2 bg-light border rounded">
                                            <small class="text-muted">Keterangan:</small>
                                            <div>{!! nl2br(e($method->description)) !!}</div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($method->account_number && $qrEnabled): ?>
                                        <div class="mt-2 text-center">
                                            <div class="d-inline-block p-2 bg-white border rounded"
                                                id="qr-{{ $method->id }}"></div>
                                            <div class="form-text mt-1">Scan QR untuk melakukan pembayaran</div>
                                        </div>
                                    @endif
                                    @if (!$method->account_name && !$method->account_number)
                                        <div class="mt-1 text-muted small">Silakan hubungi admin untuk detail pembayaran.</div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Upload Bukti Pembayaran</label>
                            <input type="file" name="payment_proof"
                                class="form-control @error('payment_proof') is-invalid @enderror" accept="image/*" required>
                            @error('payment_proof')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                            <div class="form-text">Format: JPG, PNG, WEBP. Maks 4MB.</div>
                        </div>

<button type="submit" class="btn btn-danger">Kirim Bukti Pembayaran</button>
                        <a href="{{ route('member.subscriptions.index') }}" class="btn btn-light">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @if ($qrEnabled)
        <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const select = document.getElementById('payment-method-select');
            const infos = document.querySelectorAll('.payment-method-info');

            // Generate QR code untuk tiap metode yang memiliki nomor akun (hanya jika setting QR aktif)
            @if ($qrEnabled)
                @foreach ($methods as $method)
                    @if ($method->account_number)
                        (function () {
                            const elId = 'qr-{{ $method->id }}';
                            const el = document.getElementById(elId);
                            if (el && typeof QRCode !== 'undefined') {
                                new QRCode(el, {
                                    text: '{{ $method->account_name }} {{ $method->account_number }}',
                                    width: 140,
                                    height: 140,
                                    correctLevel: QRCode.CorrectLevel.M
                                });
                            }
                        })();
                    @endif
                @endforeach
            @endif

            function showInfo(methodId) {
                infos.forEach(el => el.classList.add('d-none'));
                if (methodId) {
                    const target = document.getElementById('method-info-' + methodId);
                    if (target) target.classList.remove('d-none');
                }
            }

            // Tampilkan info saat select berubah
            if (select) {
                select.addEventListener('change', function () {
                    showInfo(this.value);
                });
                // Tampilkan jika sudah ada nilai (mis. karena validasi form error & old value)
                showInfo(select.value);
            }
        });
    </script>
@endpush
