@extends('layouts.new-app')

@section('title', 'Team Members')

@section('content')
    <div class="row">
        <h2>Team Members</h2>
        <a href="{{ route('team.create') }}">Invite</a>
    </div>

    @include('team._table')

    <p class="muted">Showing {{ $members->count() }} of total {{ $members->total() }}</p>
    <div class="pager">{{ $members->links('pagination::simple-default') }}</div>
@endsection