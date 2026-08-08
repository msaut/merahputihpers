@extends('layouts.admin')

@section('title', 'Setting Email')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Setting Email (SMTP)</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Setting Email</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-envelope me-1"></i>
                Konfigurasi SMTP
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.settings.email') }}">
                    @csrf
                    @php
                        $mailHost = \App\Models\Setting::get('mail_host', config('mail.mailers.smtp.host'));
                        $mailPort = \App\Models\Setting::get('mail_port', config('mail.mailers.smtp.port'));
                        $mailUsername = \App\Models\Setting::get('mail_username', config('mail.mailers.smtp.username'));
                        $mailPassword = \App\Models\Setting::get('mail_password', config('mail.mailers.smtp.password'));
                        $mailEncryption = \App\Models\Setting::get('mail_encryption', config('mail.mailers.smtp.encryption'));
                        $mailFromAddress = \App\Models\Setting::get('mail_from_address', config('mail.from.address'));
                        $mailFromName = \App\Models\Setting::get('mail_from_name', config('mail.from.name'));
                    @endphp

                    <div class="mb-3">
                        <label class="form-label">SMTP Host</label>
                        <input type="text" name="mail_host" class="form-control" value="{{ $mailHost }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">SMTP Port</label>
                        <input type="number" name="mail_port" class="form-control" value="{{ $mailPort }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">SMTP Username</label>
                        <input type="text" name="mail_username" class="form-control" value="{{ $mailUsername }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">SMTP Password</label>
                        <input type="password" name="mail_password" class="form-control" value="{{ $mailPassword }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Enkripsi</label>
                        <select name="mail_encryption" class="form-select">
                            <option value="">Tidak Ada</option>
                            <option value="tls" {{ $mailEncryption == 'tls' ? 'selected' : '' }}>TLS</option>
                            <option value="ssl" {{ $mailEncryption == 'ssl' ? 'selected' : '' }}>SSL</option>
                        </select>
                    </div>

                    <hr>
                    <h6>Pengirim Email</h6>
                    <div class="mb-3">
                        <label class="form-label">From Address</label>
                        <input type="email" name="mail_from_address" class="form-control" value="{{ $mailFromAddress }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">From Name</label>
                        <input type="text" name="mail_from_name" class="form-control" value="{{ $mailFromName }}" required>
                    </div>

                    <hr>
                    <h6>Pembayaran</h6>
                    <div class="form-check form-switch mb-3">
                        @php $qrEnabled = (bool) \App\Models\Setting::get('qr_enabled', true); @endphp
                        <input type="checkbox" class="form-check-input" name="qr_enabled" value="1"
                            id="qr_enabled" {{ old('qr_enabled', $qrEnabled) ? 'checked' : '' }}>
                        <label class="form-check-label" for="qr_enabled">
                            <i class="fas fa-qrcode"></i> Tampilkan QR Code pembayaran untuk member
                        </label>
                    </div>

                    <button type="submit" class="btn btn-danger">Simpan Setting</button>
                </form>
            </div>
        </div>
    </div>
@endsection
