@extends('layouts.admin') 

@section('content')

<link rel="stylesheet" href="{{ asset('css/custom-pagination-admin.css') }}">


<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Data Berita</h6>
            <a href="{{ route('berita.create') }}" class="btn btn-sm btn-primary">+ Tambah Berita</a>
        </div>
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <p class="m-0 text-primary">Berikut berita yang telah ditulis.</p>
            <p class="m-0 text-primary">Jumlah Berita: {{ $berita->total() }}</p>
        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('berita.index') }}" class="mb-3">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <label class="small text-muted">Penulis</label>
                        <select name="penulis" class="form-control form-control-sm">
                            <option value="">Semua</option>
                            @foreach(($penulis ?? collect()) as $p)
                                <option value="{{ $p->id }}" {{ request('penulis') == $p->id ? 'selected' : '' }}>
                                    {{ $p->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 mb-2">
                        <label class="small text-muted">Kategori</label>
                        <select name="kategori" class="form-control form-control-sm">
                            <option value="">Semua</option>
                            @foreach(($kategoris ?? collect()) as $k)
                                <option value="{{ $k->id }}" {{ request('kategori') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 mb-2">
                        <label class="small text-muted">Status</label>
                        <select name="status" class="form-control form-control-sm">
                            <option value="">Semua</option>
                            @php
                                $statuses = ['draft' => 'draft', 'published' => 'published'];
                            @endphp
                            @foreach($statuses as $value => $label)
                                <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 mb-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-sm btn-primary w-100">Filter</button>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Penulis</th>
                            <th>Judul</th>
                            <th>Gambar</th>
                            <th>Kategori</th>
                            <th>Dibaca</th>
                            <th>status</th>
                            <th>publish_at</th>
                            <th>published_at</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($berita as $b)
                        <tr>
                            <td>{{ $berita->firstItem() + $loop->index }}</td>
                            <td>{{ $b->user ? $b->user->name : 'Penulis tidak ditemukan atau sudah tidak aktif' }}</td>
                            <td>{{ $b->judul }}</td>
<td><img src="{{ $b->gambar_base64 ? $b->gambar_base64 : asset('storage/berita/' . $b->gambar) }}" alt="" width="80" height="40" style="object-fit: cover; border-radius: 4px;"></td>
                            <td>{{ $b->kategori->nama }}</td>
                            <td>{{ $b->views }} x</td>
                            <td>{{ $b->status }}</td>
                            <td>{{ $b->publish_at ? $b->publish_at->format('d M Y H:i') : '-' }}</td>
                            <td>{{ $b->published_at ? $b->published_at->format('d M Y H:i') : '-' }}</td>
                            <td>
                                
                                <a href="{{ route('berita.edit', $b->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form method="POST" action="{{ route('berita.destroy', $b->id) }}" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Hapus?')" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    {{-- <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Penulis</th>
                            <th>Judul</th>
                            <th>Gambar</th>
                            <th>Kategori</th>
                            <th>Dibaca</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot> --}}
                </table>

                <div class="single-wrap d-flex justify-content-center admin-berita-pagination">
                        {!! $berita->links('pagination::bootstrap-4') !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
