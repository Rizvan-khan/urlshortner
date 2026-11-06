<?php

namespace App\Services;

use App\Models\Company;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class CompanyService
{
   
    public function paginateWithStats(int $perPage = 10): LengthAwarePaginator
    {
        return Company::query()
            ->withCount(['users', 'shortUrls'])
            ->withSum('shortUrls as total_hits', 'hits')
            ->latest()
            ->paginate($perPage);
    }


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