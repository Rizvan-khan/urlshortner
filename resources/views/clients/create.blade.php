@extends('layouts.new-app')

@section('title', 'Invite New Client')

@section('content')
    <h2>Invite New Client</h2>

    <form method="POST" action="{{ route('clients.store') }}">
        @csrf
        <div class="field">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Client name" required>
        </div>
        <div class="field">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="admin@example.com" required>
        </div>
        <button type="submit">Send Invitation</button>
    </form>
@endsection