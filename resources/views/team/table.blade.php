<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Total Generated URLs</th>
            <th>Total URL Hits</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($members as $member)
            <tr>
                <td>{{ $member->name }}</td>
                <td>{{ $member->email }}</td>
                <td>{{ $member->role->value }}</td>
                <td>{{ $member->short_urls_count }}</td>
                <td>{{ $member->total_hits ?? 0 }}</td>
            </tr>
        @empty
            <tr><td colspan="5">No team members yet.</td></tr>
        @endforelse
    </tbody>
</table>