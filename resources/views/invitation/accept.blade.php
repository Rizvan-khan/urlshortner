@extends('layouts.new-app')

@section('title', 'Accept Invitation')

@section('content')
    <h2>Accept Invitation</h2>
    <p>You are invited as <strong>{{ $invitation->role->value }}</strong>
       for <strong>{{ $invitation->company->name }}</strong>.</p>
    <p class="muted">Email: {{ $invitation->email }}</p>

    <form method="POST" action="{{ route('invitation.accept', $invitation->token) }}">
        @csrf
        <div class="field">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $invitation->name) }}" required>
        </div>
        <div class="field">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="field">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>
        <button type="submit">Set Password &amp; Join</button>
    </form>
@endsection