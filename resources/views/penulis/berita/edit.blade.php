@extends('layouts.penulis')

@section('content')

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Ubah Berita</h6>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data" action="{{ route('penulis.berita.update', $berita) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label>Judul</label>
                <input type="text" name="judul" value="{{ $berita->judul }}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Kategori</label>
                <select name="kategori_id" class="form-control" required>
                    @foreach ($kategori as $k)
                        <option value="{{ $k->id }}" {{ $k->id == $berita->kategori_id ? 'selected' : '' }}>{{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Isi</label>
                <textarea name="isi" class="form-control" rows="5" id="summernote">{{ $berita->isi }}</textarea>
            </div>
            <div class="mb-3">
                <label>Gambar Baru (Opsional)</label>
                <input type="file" name="gambar" class="form-control" accept="image/*">
                <small class="text-muted">Biarkan kosong jika tidak ingin mengganti gambar thumbnail.</small>
            </div>
            <button class="btn btn-primary">Update</button>
        </form>
        </div>
<script>
$(document).ready(function() {
    $('#summernote').summernote({
        tabsize: 2,
        height: 300,
        toolbar: [
            ['history', ['undo', 'redo']],
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear', 'fontname']],
            ['color', ['color', 'forecolor']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ],
        callbacks: {
            onImageUpload: function(files) {
                var formData = new FormData();
                formData.append('image', files[0]);
                $.ajax({
                    url: '{{ route("upload.summernote") }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(resp) {
                        if (resp.url) {
                            $('#summernote').summernote('insertImage', resp.url);
                        }
                    },
                    error: function(xhr) {
                        var msg = 'Upload gambar gagal.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg += ' ' + xhr.responseJSON.message;
                        }
                        alert(msg);
                    }
                });
            }
        }
    });
});
</script>

@endsection
