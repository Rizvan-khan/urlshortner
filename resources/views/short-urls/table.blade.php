@php
    $viewer = auth()->user();
    $showUser = $viewer->isSuperAdmin() || $viewer->isAdmin();
    $showCompany = $viewer->isSuperAdmin();
@endphp

<table>
    <thead>
        <tr>
            <th>Short URL</th>
            <th>Long URL</th>
            <th>Hits</th>
            @if ($showUser) <th>User</th> @endif
            @if ($showCompany) <th>Company</th> @endif
            <th>Created On</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($shortUrls as $url)
            <tr>
                <td><a href="{{ route('short.redirect', $url->code) }}" target="_blank">{{ route('short.redirect', $url->code) }}</a></td>
                <td>{{ \Illuminate\Support\Str::limit($url->original_url, 40) }}</td>
                <td>{{ $url->hits }}</td>
                @if ($showUser) <td>{{ $url->user->name }}</td> @endif
                @if ($showCompany) <td>{{ $url->company->name }}</td> @endif
                <td>{{ $url->created_at->format('d M Y') }}</td>
            </tr>
        @empty
            <tr><td colspan="6">No short URLs yet.</td></tr>
        @endforelse
    </tbody>
</table>