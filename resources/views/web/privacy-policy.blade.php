@extends('layouts.web')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="h4 mb-3">{{ $page->title ?? 'Privacy Policy' }}</h1>
            <div class="mt-2" style="line-height: 1.8;">
                {!! $page->content !!}
            </div>
        </div>
    </div>
</div>
@endsection
