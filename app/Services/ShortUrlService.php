<?php

namespace App\Services;

use App\Enums\Role;
use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class ShortUrlService
{
    public function create(User $user, string $originalUrl): ShortUrl
    {
        return ShortUrl::create([
            'company_id'   => $user->company_id,
            'user_id'      => $user->id,
            'original_url' => $originalUrl,
            'code'         => $this->generateUniqueCode(),
        ]);
    }

    public function paginateFor(User $user, int $perPage = 10): LengthAwarePaginator
    {
        return $this->queryFor($user)
            ->with(['user', 'company'])
            ->latest()
            ->paginate($perPage);
    }

    /** Public redirect: URL dhoondo, hit badhao, wapas karo. */
    public function resolve(string $code): ShortUrl
    {
        $shortUrl = ShortUrl::where('code', $code)->firstOrFail();
        $shortUrl->increment('hits');

        return $shortUrl;
    }

    /** Data scoping ek hi jagah: har role ko kaunsi rows dikhengi. */
    private function queryFor(User $user): Builder
    {
        return match ($user->role) {
            Role::SuperAdmin => ShortUrl::query(),
            Role::Admin      => ShortUrl::where('company_id', $user->company_id),
            Role::Member     => ShortUrl::where('user_id', $user->id),
            default          => ShortUrl::whereRaw('1 = 0'),
        };
    }

    private function generateUniqueCode(): string
    {
        do {
            // lower() isliye ki MySQL me unique index case-insensitive hota hai
            $code = Str::lower(Str::random(7));
        } while (ShortUrl::where('code', $code)->exists());

        return $code;
    }
}