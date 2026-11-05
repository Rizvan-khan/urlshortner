<?php

namespace App\Services;

use App\Models\Company;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class CompanyService
{
    /** SuperAdmin ke liye: companies + users count + URLs count + total hits. */
    public function paginateWithStats(int $perPage = 10): LengthAwarePaginator
    {
        return Company::query()
            ->withCount(['users', 'shortUrls'])
            ->withSum('shortUrls as total_hits', 'hits')
            ->latest()
            ->paginate($perPage);
    }

    /** Admin ke liye: sirf apni company ki team. */
    public function teamFor(User $admin, int $perPage = 10): LengthAwarePaginator
    {
        return User::query()
            ->where('company_id', $admin->company_id)
            ->withCount('shortUrls')
            ->withSum('shortUrls as total_hits', 'hits')
            ->orderBy('name')
            ->paginate($perPage);
    }
}