@extends('layouts.admin')

@section('title', 'Edit Banner')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Banner / Iklan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.banners.index') }}">Banner</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>

    <div class="card mb-4">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.banners.update', $banner->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-lg-8">
                        <div class="mb-3">
                            <label class="form-label">Judul</label>
                            <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $banner->judul) }}" required>
                            @error('judul')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Link</label>
                            <input type="url" name="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link', $banner->link) }}" required>
                            @error('link')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Posisi</label>
                                    <select name="posisi" id="banner-position" class="form-select @error('posisi') is-invalid @enderror" required>
                                        @foreach (config('banner.positions') as $key => $config)
                                            <option value="{{ $key }}" {{ old('posisi', $banner->posisi) === $key ? 'selected' : '' }}>{{ $config['label'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Urutan</label>
                                    <input type="number" min="0" name="urutan" class="form-control @error('urutan') is-invalid @enderror" value="{{ old('urutan', $banner->urutan) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" value="{{ old('tanggal_mulai', optional($banner->tanggal_mulai)->format('Y-m-d')) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Selesai</label>
                                    <input type="date" name="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror" value="{{ old('tanggal_selesai', optional($banner->tanggal_selesai)->format('Y-m-d')) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Buka link</label>
                                    <div class="d-flex gap-3 mt-2">
                                        <label class="form-check-label">
                                            <input type="radio" name="target" value="_self" {{ old('target', $banner->target) === '_self' ? 'checked' : '' }}> Tab yang sama
                                        </label>
                                        <label class="form-check-label">
                                            <input type="radio" name="target" value="_blank" {{ old('target', $banner->target) === '_blank' ? 'checked' : '' }}> Tab baru
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select @error('status') is-invalid @enderror">
                                        <option value="active" {{ old('status', $banner->status) === 'active' ? 'selected' : '' }}>Aktif</option>
                                        <option value="inactive" {{ old('status', $banner->status) === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alt Text</label>
                            <input type="text" name="alt_text" class="form-control @error('alt_text') is-invalid @enderror" value="{{ old('alt_text', $banner->alt_text) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" rows="3" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $banner->deskripsi) }}</textarea>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card border-light bg-light h-100">
                            <div class="card-body">
                                <h6 class="fw-bold">Upload Gambar Banner Baru</h6>
                                <input type="file" id="banner-image" name="gambar" accept="image/jpeg,image/png,image/webp" class="form-control @error('gambar') is-invalid @enderror">
                                @error('gambar')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                @if ($banner->gambar)
                                    <div class="mt-3 text-center">
                                        <img src="{{ asset('storage/' . $banner->gambar) }}" alt="{{ $banner->alt_text ?? $banner->judul }}" style="max-width:100%; max-height:180px; border-radius:8px; object-fit:contain;">
                                    </div>
                                @endif

                                <div class="mt-3">
                                    <label class="form-label">Mode validasi</label>
                                    <select name="validation_mode" id="validation-mode" class="form-select">
                                        <option value="recommended" {{ old('validation_mode', $banner->validation_mode ?? 'recommended') === 'recommended' ? 'selected' : '' }}>Recommended</option>
                                        <option value="strict" {{ old('validation_mode', $banner->validation_mode ?? 'recommended') === 'strict' ? 'selected' : '' }}>Strict</option>
                                    </select>
                                </div>

                                <div id="banner-preview" class="mt-3 text-center border rounded p-2 bg-white" style="min-height:120px; display:flex; align-items:center; justify-content:center;">
                                    <span class="text-muted small">Preview baru akan muncul di sini.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-danger">Simpan Perubahan</button>
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-light">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const positionConfig = {
        header: { width: 970, height: 250 },
        leaderboard: { width: 728, height: 90 },
        sidebar: { width: 300, height: 250 },
        mobile: { width: 320, height: 100 },
        square: { width: 300, height: 300 }
    };

    const positionSelect = document.getElementById('banner-position');
    const fileInput = document.getElementById('banner-image');
    const previewBox = document.getElementById('banner-preview');

    function showPreview(file) {
        if (!file) {
            previewBox.innerHTML = '<span class="text-muted small">Preview baru akan muncul di sini.</span>';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            previewBox.innerHTML = '<img src="' + e.target.result + '" style="max-width:100%; max-height:180px; border-radius:8px; object-fit:contain;" />';
        };
        reader.readAsDataURL(file);
    }

    function checkImageDimensions(file) {
        if (!file) return;
        const img = new Image();
        const pos = positionSelect.value;
        const config = positionConfig[pos] || { width: 0, height: 0 };
        const url = URL.createObjectURL(file);

        img.onload = function() {
            URL.revokeObjectURL(url);
            const actualWidth = this.width;
            const actualHeight = this.height;
            const actualSize = (file.size / 1024 / 1024).toFixed(2);

            previewBox.insertAdjacentHTML('beforeend', '<div class="mt-3 small text-muted"><div>Ukuran aktual: ' + actualWidth + ' × ' + actualHeight + ' px</div><div>Ukuran rekomendasi: ' + config.width + ' × ' + config.height + ' px</div><div>Format: ' + file.type + '</div><div>Ukuran file: ' + actualSize + ' MB</div></div>');

            const delta = Math.abs(actualWidth - config.width) + Math.abs(actualHeight - config.height);
            if (delta > 60) {
                previewBox.insertAdjacentHTML('beforeend', '<div class="mt-2 text-warning small">Ukuran gambar tidak sesuai dengan ukuran banner yang dipilih. Gunakan ukuran ' + config.width + ' × ' + config.height + ' px.</div>');
            }
        };

        img.src = url;
    }

    positionSelect.addEventListener('change', function() {
        if (fileInput.files && fileInput.files[0]) {
            showPreview(fileInput.files[0]);
            checkImageDimensions(fileInput.files[0]);
        }
    });

    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (!file) return;
        showPreview(file);
        checkImageDimensions(file);
    });
</script>
@endsection
