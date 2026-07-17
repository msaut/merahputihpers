@extends('layouts.web')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="h4 mb-3">{{ $page->title ?? 'Contact' }}</h1>

            @if (!empty($page->email))
                <p class="mb-1"><strong>Email:</strong> {{ $page->email }}</p>
            @endif
            @if (!empty($page->phone))
                <p class="mb-1"><strong>Phone:</strong> {{ $page->phone }}</p>
            @endif
            @if (!empty($page->address))
                <p class="mb-3"><strong>Address:</strong> {{ $page->address }}</p>
            @endif

            @if (!empty($page->content))
                <div style="line-height: 1.8;">
                    {!! $page->content !!}
                </div>
            @endif
        </div>
    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <h2 class="h5 mb-3">Hubungi Kami</h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('static.contact.messages') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Judul Pesan</label>
                        <input type="text" name="judul_pesan" class="form-control" value="{{ old('judul_pesan') }}" required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Pesan</label>
                        <textarea name="pesan" class="form-control" rows="6" required>{{ old('pesan') }}</textarea>
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">Kirim Pesan</button>
            </form>
        </div>
    </div>
</div>
@endsection
