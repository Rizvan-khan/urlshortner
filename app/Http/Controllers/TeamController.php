<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\InviteTeamMemberRequest;
use App\Services\CompanyService;
use App\Services\InvitationService;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function __construct(
        private CompanyService $companies,
        private InvitationService $invitations,
    ) {}

    public function index(Request $request)
    {
        return view('team.index', ['members' => $this->companies->teamFor($request->user())]);
    }

    public function create()
    {
        return view('team.create', ['roles' => Role::invitable()]);
    }

    public function store(InviteTeamMemberRequest $request)
    {
        $this->invitations->inviteTeamMember(
            $request->user(),
            $request->validated('name'),
            $request->validated('email'),
            Role::from($request->validated('role')),
        );

        return redirect()->route('team.index')->with('status', 'Invitation sent.');
    }
}