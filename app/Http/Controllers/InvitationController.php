<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcceptInvitationRequest;
use App\Services\InvitationService;
use Illuminate\Support\Facades\Auth;

class InvitationController extends Controller
{
    public function __construct(private InvitationService $invitations) {}

    public function show(string $token)
    {
        return view('invitation.accept', [
            'invitation' => $this->invitations->findPendingOrFail($token),
        ]);
    }

    public function accept(AcceptInvitationRequest $request, string $token)
    {
        $user = $this->invitations->accept(
            $token,
            $request->validated('name'),
            $request->validated('password'),
        );

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }
}