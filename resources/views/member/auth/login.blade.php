@extends('layouts.web')

@section('title', 'Login Member | MerahPutihPers')

@section('content')
    <style>
        .auth-wrapper {
            min-height: 70vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px 15px;
        }

        .auth-card {
            width: 100%;
            max-width: 480px;
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .auth-card .card-header {
            background: #d90429;
            color: #fff;
            border-radius: 16px 16px 0 0 !important;
            text-align: center;
            font-size: 20px;
            font-weight: 600;
            padding: 18px;
        }
    </style>

    <div class="auth-wrapper">
        <div class="card auth-card">
            <div class="card-header">Login Member</div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('member.login') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-danger w-100">Login</button>
                </form>

                <hr>
                <p class="text-center mb-0">
                    Belum punya akun? <a href="{{ route('member.register') }}">Daftar</a>
                </p>
            </div>
        </div>
    </div>
@endsection
