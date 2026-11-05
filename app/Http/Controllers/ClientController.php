<?php

namespace App\Http\Controllers;

use App\Http\Requests\InviteClientRequest;
use App\Services\CompanyService;
use App\Services\InvitationService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct(
        private CompanyService $companies,
        private InvitationService $invitations,
    ) {}

    public function index()
    {
        return view('clients.index', ['companies' => $this->companies->paginateWithStats()]);
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(InviteClientRequest $request)
    {
        $this->invitations->inviteClient(
            $request->user(),
            $request->validated('name'),
            $request->validated('email'),
        );

        return redirect()->route('clients.index')->with('status', 'Invitation sent.');
    }
}