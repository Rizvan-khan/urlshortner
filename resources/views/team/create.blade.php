@extends('layouts.new-app')

@section('title', 'Invite New Team Member')

@section('content')
    <h2>Invite New Team Member</h2>

    <form method="POST" action="{{ route('team.store') }}">
        @csrf
        <div class="field">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        </div>
        <div class="field">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div class="field">
            <label for="role">Role</label>
            <select id="role" name="role" required>
                @foreach ($roles as $role)
                    <option value="{{ $role->value }}" @selected(old('role') === $role->value)>{{ $role->value }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit">Send Invitation</button>
    </form>
@endsection