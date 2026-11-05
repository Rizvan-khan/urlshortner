<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShortUrlRequest;
use App\Models\ShortUrl;
use App\Services\ShortUrlService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ShortUrlController extends Controller
{
    public function __construct(private ShortUrlService $shortUrls) {}

    public function index(Request $request)
    {
        Gate::authorize('viewAny', ShortUrl::class);

        return view('short-urls.index', [
            'shortUrls' => $this->shortUrls->paginateFor($request->user()),
        ]);
    }

    public function create()
    {
        Gate::authorize('create', ShortUrl::class);

        return view('short-urls.create');
    }

    public function store(StoreShortUrlRequest $request)
    {
        $this->shortUrls->create($request->user(), $request->validated('original_url'));

        return redirect()->route('short-urls.index')->with('status', 'Short URL created.');
    }
}