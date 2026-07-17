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

            @if($type === 'contact')
                <hr class="my-4">

                <div class="card shadow-none border">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Pesan Masuk (Contact Messages)</h6>
                    </div>

                    <div class="card-body">
                        @if(isset($contactMessages) && $contactMessages->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Judul</th>
                                            <th>Pesan</th>
                                            <th>Dikirim</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($contactMessages as $msg)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $msg->nama }}</td>
                                                <td>{{ $msg->email }}</td>
                                                <td>{{ $msg->judul_pesan }}</td>
                                                <td style="max-width:420px; white-space: normal;">
                                                    {{ \Illuminate\Support\Str::limit(strip_tags($msg->pesan), 120) }}
                                                </td>
                                                <td>{{ $msg->created_at ? $msg->created_at->format('d M Y H:i') : '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-muted">Belum ada pesan masuk.</div>
                        @endif
                    </div>
                </div>
            @endif
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
