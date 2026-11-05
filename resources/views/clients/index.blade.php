@extends('layouts.new-app')

@section('title', 'Clients')

@section('content')
    <div class="row">
        <h2>Clients</h2>
        <a href="{{ route('clients.create') }}">Invite</a>
    </div>

    @include('clients._table')

    <p class="muted">Showing {{ $companies->count() }} of total {{ $companies->total() }}</p>
    <div class="pager">{{ $companies->links('pagination::simple-default') }}</div>
@endsection