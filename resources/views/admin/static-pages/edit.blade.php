@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Edit Static Page: {{ str_replace('-', ' ', $type) }}
            </h6>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.static-pages.update', ['type' => $type]) }}">
                @csrf
                @method('PUT')

                @if($type === 'terms-of-use' || $type === 'privacy-policy')
                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $item->title) }}">
                    </div>
                @endif

                <div class="mb-3">
                    <label>Content</label>
                    <textarea name="content" class="form-control" rows="10" id="summernote">{{ old('content', $item->content) }}</textarea>
                </div>

                @if($type === 'contact')
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $item->email) }}">
                    </div>

                    <div class="mb-3">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $item->phone) }}">
                    </div>

                    <div class="mb-3">
                        <label>Address</label>
                        <textarea name="address" class="form-control" rows="3">{{ old('address', $item->address) }}</textarea>
                    </div>
                @endif

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
