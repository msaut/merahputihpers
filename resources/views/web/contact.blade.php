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
</div>
@endsection
