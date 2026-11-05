@extends('layouts.new-app')

@section('title', 'Dashboard')

@section('content')
    @if (auth()->user()->isSuperAdmin())
        <div class="row">
            <h2>Clients</h2>
            <a href="{{ route('clients.create') }}">Invite</a>
        </div>
        @include('clients.table', ['companies' => $companies])
        <p class="muted">Showing {{ $companies->count() }} of total {{ $companies->total() }}
            <a href="{{ route('clients.index') }}">View All</a></p>
    @endif

    @if (auth()->user()->isAdmin())
        <div class="row">
            <h2>Team Members</h2>
            <a href="{{ route('team.create') }}">Invite</a>
        </div>
        @include('team.table', ['members' => $members])
        <p class="muted">Showing {{ $members->count() }} of total {{ $members->total() }}
            <a href="{{ route('team.index') }}">View All</a></p>
    @endif

    <div class="row">
        <h2>Generated Short URLs</h2>
        @can('create', App\Models\ShortUrl::class)
            <a href="{{ route('short-urls.create') }}">Generate</a>
        @endcan
    </div>
    @include('short-urls.table', ['shortUrls' => $shortUrls])
    <p class="muted">Showing {{ $shortUrls->count() }} of total {{ $shortUrls->total() }}
        <a href="{{ route('short-urls.index') }}">View All</a></p>
@endsection