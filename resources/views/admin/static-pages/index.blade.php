@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Static Pages</h6>
            <a href="{{ route('admin.static-pages.edit', ['type' => $type]) }}" class="btn btn-sm btn-primary">
                Edit {{ $type }}
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Updated At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td>{{ $items->firstItem() + $loop->index }}</td>
                                <td>{{ $item->title ?? '-' }}</td>
                                <td>{{ $item->updated_at ? $item->updated_at->format('d M Y H:i') : '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="single-wrap d-flex justify-content-center admin-berita-pagination">
                {!! $items->links('pagination::bootstrap-4') !!}
            </div>
        </div>
    </div>
</div>
@endsection
