@extends('member.layouts.member')

@section('title', 'Profil Member')

@section('content')
    <h3 class="mb-4">Edit Profil</h3>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card stat-card text-center">
                <div class="card-body">
                    <img src="{{ $member->avatar_base64 ?? asset('default-avatar.png') }}"
                        class="rounded-circle img-thumbnail mb-3" style="width:120px;height:120px;object-fit:cover;"
                        alt="avatar">
                    <h5>{{ $member->name }}</h5>
                    <p class="text-muted mb-0">{{ $member->email }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card stat-card">
                <div class="card-body">
                    <form method="POST" action="{{ route('member.profile.update') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $member->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $member->email) }}" required>
                            @error('email')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Foto Profil (opsional)</label>
                            <input type="file" name="avatar" class="form-control @error('avatar') is-invalid @enderror"
                                accept="image/*">
                            @error('avatar')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <hr>
                        <h6>Ubah Password (opsional)</h6>
                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password" class="form-control"
                                placeholder="Kosongkan jika tidak diubah">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Ulangi password baru">
                        </div>

                        <button type="submit" class="btn btn-danger">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
