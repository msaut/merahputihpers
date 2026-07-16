@extends('layouts.admin')

@section('content')

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Ubah Berita</h6>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data" action="{{ route('berita.update', $berita) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label>Judul</label>
                <input type="text" name="judul" value="{{ $berita->judul }}" class="form-control">
            </div>
            <div class="mb-3">
                <label>Kategori</label>
                <select name="kategori_id" class="form-control">
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
                <input type="file" name="gambar" class="form-control">
            </div>
            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="draft" {{ $berita->status == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ $berita->status == 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Publish At</label>
                <input type="datetime-local" name="publish_at" class="form-control" value="{{ $berita->publish_at ? $berita->publish_at->format('Y-m-d\TH:i') : '' }}">
            </div>
            <button class="btn btn-primary">Update</button>
        </form>
        </div>
    </div>
</div>
<script>
    $('#summernote').summernote({
        tabsize: 2,
        height: 300,
        toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear', 'fontname']],
        ['color', ['color', 'forecolor']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['fullscreen', 'codeview', 'help']]  
        ]
    });
</script>

@endsection