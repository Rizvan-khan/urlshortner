<p>Hello {{ $invitation->name }},</p>
<p>You have been invited as <strong>{{ $invitation->role->value }}</strong>.</p>
<p><a href="{{ route('invitation.show', $invitation->token) }}">Accept invitation</a></p>
<p>This link expires on {{ $invitation->expires_at->toDayDateTimeString() }}.</p>