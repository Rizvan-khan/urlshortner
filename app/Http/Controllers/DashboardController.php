<?php

namespace App\Http\Controllers;

use App\Services\CompanyService;
use App\Services\ShortUrlService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        private ShortUrlService $shortUrls,
        private CompanyService $companies,
    ) {}

    public function __invoke(Request $request)
    {
        $user = $request->user();

        return view('dashboard', [
            'shortUrls' => $this->shortUrls->paginateFor($user, 5),
            'companies' => $user->isSuperAdmin() ? $this->companies->paginateWithStats(5) : null,
            'members'   => $user->isAdmin() ? $this->companies->teamFor($user, 5) : null,
        ]);
    }
}