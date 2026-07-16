
@extends('layouts.admin')

@section('content')

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Kategori</h6>
        </div>
        <div class="card-body">
        <form method="POST" enctype="multipart/form-data" action="{{ route('berita.store') }}">

            @csrf
            <div class="mb-3">
                <label>Judul</label>
                <input type="text" name="judul" class="form-control">
            </div>
            <div class="mb-3">
                <label>Kategori</label>
                <select name="kategori_id" class="form-control">
                    @foreach ($kategori as $k)
                        <option value="{{ $k->id }}">{{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Isi</label>
                <div id=""></div>
                <textarea name="isi" class="form-control" rows="5" id="summernote"></textarea>
                
            </div>
            <div class="mb-3">
                <label>Gambar</label>
                <input type="file" name="gambar" class="form-control">
            </div>
            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Publish At</label>
                <input type="datetime-local" name="publish_at" class="form-control">
            </div>
            <button class="btn btn-success">Simpan</button>
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
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]  
        ]
    });
    </script>

@endsection