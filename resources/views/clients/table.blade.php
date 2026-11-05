<table>
    <thead>
        <tr>
            <th>Client Name</th>
            <th>Users</th>
            <th>Total Generated URLs</th>
            <th>Total URL Hits</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($companies as $company)
            <tr>
                <td>{{ $company->name }}<br><span class="muted">{{ $company->email }}</span></td>
                <td>{{ $company->users_count }}</td>
                <td>{{ $company->short_urls_count }}</td>
                <td>{{ $company->total_hits ?? 0 }}</td>
            </tr>
        @empty
            <tr><td colspan="4">No clients yet.</td></tr>
        @endforelse
    </tbody>
</table>