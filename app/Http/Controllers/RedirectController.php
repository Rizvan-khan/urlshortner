<?php

namespace App\Http\Controllers;

use App\Services\ShortUrlService;

class RedirectController extends Controller
{
    public function __construct(private ShortUrlService $shortUrls) {}

    public function show(string $code)
    {
        return redirect()->away($this->shortUrls->resolve($code)->original_url);
    }
}