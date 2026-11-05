@extends('layouts.new-app')

@section('title', 'Short URLs')

@section('content')
    <div class="row">
        <h2>Generated Short URLs</h2>
        @can('create', App\Models\ShortUrl::class)
            <a href="{{ route('short-urls.create') }}">Generate</a>
        @endcan
    </div>

    @include('short-urls._table')

    <p class="muted">Showing {{ $shortUrls->count() }} of total {{ $shortUrls->total() }}</p>
    <div class="pager">{{ $shortUrls->links('pagination::simple-default') }}</div>
@endsection