<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sembark URL Shortener')</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; color: #222; }
        nav { background: #eee; padding: 10px 20px; display: flex; gap: 15px; align-items: center; border-bottom: 2px solid orange; }
        nav .spacer { flex: 1; }
        nav form { margin: 0; }
        main { padding: 20px; max-width: 1000px; margin: auto; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; font-size: 14px; }
        th { background: #f5f5f5; }
        .flash { background: #e6ffe6; border: 1px solid #5c5; padding: 8px; margin-bottom: 15px; }
        .errors { background: #ffe6e6; border: 1px solid #c55; padding: 8px; margin-bottom: 15px; }
        .row { display: flex; justify-content: space-between; align-items: center; }
        .field { margin-bottom: 12px; }
        .field label { display: block; margin-bottom: 4px; font-weight: bold; }
        .field input, .field select { padding: 6px; width: 320px; }
        .pager ul { list-style: none; display: flex; gap: 10px; padding: 0; }
        .muted { color: #777; font-size: 13px; }
    </style>
</head>
<body>
@auth
    <nav>
        <strong>URL Shortener</strong>
        <a href="{{ route('dashboard') }}">Dashboard</a>

        @if (auth()->user()->isSuperAdmin())
            <a href="{{ route('clients.index') }}">Clients</a>
            <a href="{{ route('clients.create') }}">Invite Client</a>
            <a href="{{ route('short-urls.index') }}">All Short URLs</a>
        @endif

        @if (auth()->user()->isAdmin())
            <a href="{{ route('team.index') }}">Team</a>
            <a href="{{ route('team.create') }}">Invite Member</a>
        @endif

        @can('create', App\Models\ShortUrl::class)
            <a href="{{ route('short-urls.index') }}">Short URLs</a>
            <a href="{{ route('short-urls.create') }}">Generate</a>
        @endcan

        <span class="spacer"></span>
        <span class="muted">{{ auth()->user()->name }} ({{ auth()->user()->role->value }})</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </nav>
@endauth

<main>
    @if (session('status'))
        <div class="flash">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="errors">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</main>
</body>
</html>